<?php
/**
 * 微信公众平台-数据库功能使用源代码（MySQL）
 * ================================
 * Copyright 2013-2014 David Tang
 * http://www.cnblogs.com/mchina/
 * http://www.joythink.net/
 * ================================
 * Author:David
 * 个人微信：mchina_tang
 * 公众微信：zhuojinsz
 * Date:2013-09-26
 */

//引入数据库函数文件
require_once 'mysql_sae.func.php';

//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->responseMsg();
//$wechatObj->valid();

class wechatCallbackapiTest
{
    /*public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }*/

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)){
                
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $RX_TYPE = trim($postObj->MsgType);

                switch($RX_TYPE)
                {
                    case "text":
                        $resultStr = $this->handleText($postObj);
                        break;
                    case "event":
                        $resultStr = $this->handleEvent($postObj);
                        break;
                    default:
                        $resultStr = "Unknow msg type: ".$RX_TYPE;
                        break;
                }
                echo $resultStr;
        }else {
            echo "";
            exit;
        }
    }

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
            $keywords = explode("+",$keyword);
            //获取当前时间
            $nowtime=date("Y-m-d G:i:s");
          
            //判断是否已经绑定
            $select_sql="SELECT id from test_mysql WHERE from_user='$fromUsername'";
            $res=_select_data($select_sql);
            $rows=mysql_fetch_array($res, MYSQL_ASSOC);
            if($rows[id] <> ''){
                $user_flag='y';          
            }
          
            if(trim($keywords[0] == '绑定')){
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
            }elseif(trim($keywords[0] == '查询')){
                $select_sql="SELECT * FROM test_mysql WHERE from_user='$fromUsername'";
                $select_res=_select_data($select_sql);
                $rows=mysql_fetch_assoc($select_res);
                if($rows[id] <> ''){
                    $contentStr="账户:$rows[account]\n"."密码：$rows[password]\n"."From_user：$rows[from_user]\n"."更新时间：$rows[update_time]";
                }else{
                    $contentStr="您还未绑定账户，查询不到相关信息，请先绑定，谢谢！";
                }
            }elseif(trim($keywords[0] == "修改")){
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
            }elseif(trim($keywords[0] == "删除")){
                $delete_sql="DELETE FROM test_mysql WHERE from_user='$fromUsername'";
                $res = _delete_data($delete_sql);
                if($res == 1){
                    $contentStr = "删除成功";
                }elseif($res == 0){
                    $contentStr = "删除失败";
                }
            }else{
                $contentStr = "感谢您关注【栗子】"."\n"."微信号：lizi"."\n"."使用以下方法测试数据库的使用\n"."1. 绑定+账户+密码\n"."2. 查询\n"."3. 修改+旧密码+新密码\n"."4. 删除";
            }
            
           // $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            echo $resultStr;
        }else{
            echo "Input something...";
        }
    }

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
                    
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>%d</FuncFlag>
                    </xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $flag);
        return $resultStr;
    }

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