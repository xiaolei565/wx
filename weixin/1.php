<?php
/**
 * 微信公众平台测试代码
 * ================================
 * Copyright 2016 bestaust
 * ================================
 * Author:@风筝有风1234
 */

//引入数据库函数文件
require_once 'mysql_sae.func.php';

//定义token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->responseMsg();
//$wechatObj->valid();//将原来的$wechatObj函数注释掉

class wechatCallbackapiTest
{
    //注释掉
    /*public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }*/
    //响应消息方法
    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];//接收原始消息
        //判断消息类型
        if (!empty($postStr)){
                
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);//将数据载入对象中
                $RX_TYPE = trim($postObj->MsgType);

                switch($RX_TYPE)
                {
                    case "text":
                        $resultStr = $this->handleText($postObj);//使用handleText() 函数处理文本消息；
                        break;
                    case "event":
                        $resultStr = $this->handleEvent($postObj);//使用handleEvent() 函数处理事件推送；
                        break;
                    default:
                        $resultStr = "Unknow msg type: ".$RX_TYPE;//其他类型事件
                        break;
                }
                echo $resultStr;
        }else {
            echo "";
            exit;
        }
    }
    //处理文本信息
    public function handleText($postObj)
    {
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        $time = time();
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>0</FuncFlag>
                    </xml>";             
        if(!empty( $keyword ))
        {
            
            $msgType = "text";
            //有道翻译所需函数
            $str_trans = mb_substr($keyword,0,2,"UTF-8");
            $str_valid = mb_substr($keyword,0,-2,"UTF-8");
           
            $keywords = explode("+",$keyword);
            $nowtime=date("Y-m-d G:i:s"); //获取当前时间
            //判断是否已经绑定
            $select_sql="SELECT id from test_mysql WHERE from_user='$fromUsername'";
            $res=_select_data($select_sql);
            $rows=mysql_fetch_array($res, MYSQL_ASSOC);
            if($rows[id] <> ''){
                $user_flag='y';          
            }
             if($str_trans == '翻译' && !empty($str_valid)){
                
                        $word = mb_substr($keyword,2,202,"UTF-8");
                        //调用有道词典
                        $contentStr = $this->youdaoDic($word);
                    }else {
                        $contentStr = "感谢您关注【卓锦苏州】"."\n"."微信号：zhuojinsz"."\n"."卓越锦绣，万代不朽";
                    }
 
           
            //数据库操作：绑定
            if(trim($keywords[0] == '绑定'&& $str_trans!='翻译')){
                if($user_flag <> 'y'){
                    $insert_sql="INSERT INTO test_mysql(from_user, account, password, update_time) VALUES('$fromUsername','$keywords[1]','$keywords[2]','$nowtime')";
                    $res = _insert_data($insert_sql);
                    if($res == 1){
                        $contentStr = "绑定成功";
                    }elseif($res == 0){
                        $contentStr = "绑定失败";
                    }
                }else{
                    $contentStr = "该账户已绑定";
                }
            //数据库操作：查询
            }elseif(trim($keywords[0] == '查询'&& $str_trans!='翻译')){
                $select_sql="SELECT * FROM test_mysql WHERE from_user='$fromUsername'";
                $select_res=_select_data($select_sql);
                $rows=mysql_fetch_assoc($select_res);
                if($rows[id] <> ''){
                    $contentStr="账户:$rows[account]\n"."密码：$rows[password]\n"."From_user：$rows[from_user]\n"."更新时间：$rows[update_time]";
                }else{
                    $contentStr="您还未绑定账户，查询不到相关信息，请先绑定，谢谢！";
                }
            //数据库操作：修改
            }elseif(trim($keywords[0] == "修改"&& $str_trans!='翻译')){
                $old_password=$keywords[1];
                $new_password=$keywords[2];
                $select_password_sql="SELECT * FROM test_mysql WHERE from_user='$fromUsername'";
                $select_res=_select_data($select_password_sql);
                $rows=mysql_fetch_assoc($select_res);
                if($old_password == $rows[password]){
                    $update_sql="UPDATE test_mysql SET password='$new_password' WHERE from_user='$fromUsername'";
                    $res = _update_data($update_sql);
                    if($res == 1){
                        $contentStr = "修改成功";
                    }elseif($res == 0){
                        $contentStr = "修改失败";
                    }
                }else{
                    $contentStr = "原密码有误，请确认后重试";
                }
            //数据库操作：删除
            }elseif(trim($keywords[0] == "删除"&& $str_trans!='翻译')){
                $delete_sql="DELETE FROM test_mysql WHERE from_user='$fromUsername'";
                $res = _delete_data($delete_sql);
                if($res == 1){
                    $contentStr = "删除成功";
                }elseif($res == 0){
                    $contentStr = "删除失败";
                }
                //翻译功能
            }elseif ($str_trans == '翻译'&& $keywords[0] != '绑定'&& !empty($str_valid)) {
                    $word = mb_substr($keyword,2,202,"UTF-8");
                        //调用有道词典
                    $contentStr = $this->youdaoDic($word);
                }elseif ($str_trans == '翻译'&& empty($str_valid)) {
                   $contentStr = "翻译失败";
                }else{
                $contentStr = "感谢您关注【栗子】"."\n"."微信号：lizi"."\n"."使用以下方法测试数据库的使用\n"."1. 绑定+账户+密码\n"."2. 查询\n"."3. 修改+旧密码+新密码\n"."4. 删除";
            }
           
 
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            echo $resultStr;
        }else{
            echo "Input something...";
        }
    }

    //处理事件推送
    public function handleEvent($object)
    {
        $contentStr = "";
        switch ($object->Event)
        {
            case "subscribe":
                $contentStr = "感谢您关注【栗子】"."\n"."微信号：lizi"."\n"."使用以下方法测试数据库的使用\n"."1. 绑定+账户+密码\n"."2. 查询\n"."3. 修改+旧密码+新密码\n"."4. 删除";
                break;
            default :
                $contentStr = "Unknow Event: ".$object->Event;
                break;
        }
        $resultStr = $this->responseText($object, $contentStr);
        return $resultStr;
    }
    
    public function responseText($object, $content, $flag=0)
    {
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>%d</FuncFlag>
                    </xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $flag);
        return $resultStr;
    }
    //youdao翻译
   public function youdaoDic($word){
        $keyfrom = "bestaust";   //申请APIKEY时所填表的网站名称的内容
        $apikey = "1842766201";  //从有道申请的APIKEY
        //有道翻译-json格式
        $url_youdao = 'http://fanyi.youdao.com/fanyiapi.do?keyfrom='.$keyfrom.'&key='.$apikey.'&type=data&doctype=json&version=1.1&q='.$word;
        
        $jsonStyle = file_get_contents($url_youdao);

        $result = json_decode($jsonStyle,true);
        
        $errorCode = $result['errorCode'];
        
        $trans = '';

        if(isset($errorCode)){

            switch ($errorCode){
                case 0:
                    $trans = $result['translation']['0'];
                    break;
                case 20:
                    $trans = '要翻译的文本过长';
                    break;
                case 30:
                    $trans = '无法进行有效的翻译';
                    break;
                case 40:
                    $trans = '不支持的语言类型';
                    break;
                case 50:
                    $trans = '无效的key';
                    break;
                default:
                    $trans = '出现异常';
                    break;
            }
        }
        return $trans;
        
    }
    //签名校验
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];    
                
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
}

?>