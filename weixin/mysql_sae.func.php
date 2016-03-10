<?php
require_once("config.php");
    /*替换为你自己的数据库名（可从管理中心查看到）*/
    $dbname = test_mysql;
     
    /*从环境变量里取出数据库连接需要的参数*/
    $host = getenv('SAE_MYSQL_HOST_M');
    $port = getenv('SAE_MYSQL_PORT');
    $user = getenv('SAE_MYSQL_USER');
    $pwd = getenv('SAE_MYSQL_PASS');
    
    /*接着调用mysql_connect()连接服务器*/
    $link=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
// $link = @mysql_connect("{$host}:{$port}",$user,$pwd,true);
    if(!$link) {
      die("Connect Server Failed: " . mysql_error());
    }
    /*连接成功后立即调用mysql_select_db()选中需要连接的数据库*/
    if(!mysql_select_db($dbname,$link)) {
      die("Select Database Failed: " . mysql_error($link));
    }
    /*至此连接已完全建立，就可对当前数据库进行相应的操作了*/
    
    //创建表

function _create_table($sql){
    mysql_query($sql) or die('创建表失败，错误信息：'.mysql_error());
    return "创建表成功";
}
//插入数据
function _insert_data($sql){
      if(!mysql_query($sql)){
        return 0;    //插入数据失败
    }else{
          if(mysql_affected_rows()>0){
              return 1;    //插入成功
          }else{
              return 2;    //没有行受到影响
          }
    }
}
//删除数据
function _delete_data($sql){
      if(!mysql_query($sql)){
        return 0;    //删除失败
      }else{
          if(mysql_affected_rows()>0){
              return 1;    //删除成功
          }else{
              return 2;    //没有行受到影响
          }
    }
}
//修改数据
function _update_data($sql){
      if(!mysql_query($sql)){
        return 0;    //更新数据失败
    }else{
          if(mysql_affected_rows()>0){
              return 1;    //更新成功;
          }else{
              return 2;    //没有行受到影响
          }
    }
}
//检索数据
function _select_data($sql){
    $ret = mysql_query($sql) or die('SQL语句有错误，错误信息：'.mysql_error());
    return $ret;
}
//删除表
function _drop_table($sql){
    mysql_query($sql) or die('删除表失败，错误信息：'.mysql_error());
    return "删除表成功";
}
?>