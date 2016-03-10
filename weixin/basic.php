<?php
/**
 * MySQL示例，通过该示例可熟悉BAE平台MySQL的使用（CRUD）
 */
require_once("config.php");
    /*替换为你自己的数据库名（可从管理中心查看到）*/
    $dbname = test_mysql;
     
    /*从环境变量里取出数据库连接需要的参数*/
    $host = getenv('SAE_MYSQL_HOST_M');
    $port = getenv('SAE_MYSQL_PORT');
    $user = getenv('SAE_MYSQL_USER');
    $pwd = getenv('SAE_MYSQL_PASS');
    
    /*接着调用mysql_connect()连接服务器*/
    // $link = @mysql_connect("{$host}:{$port}",$user,$pwd,true);
    $link=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
    if(!$link) {
      die("Connect Server Failed: " . mysql_error());
    }
    /*连接成功后立即调用mysql_select_db()选中需要连接的数据库*/
    if(!mysql_select_db($dbname,$link)) {
      die("Select Database Failed: " . mysql_error($link));
    }
    /*至此连接已完全建立，就可对当前数据库进行相应的操作了*/
    /*！！！注意，无法再通过本次连接调用mysql_select_db来切换到其它数据库了！！！*/
    /* 需要再连接其它数据库，请再使用mysql_connect+mysql_select_db启动另一个连接*/
     
    /**
    * 接下来就可以使用其它标准php mysql函数操作进行数据库操作
    */
    
    //创建一个数据库表
    $sql = "create table if not exists test_mysql(
            id int primary key auto_increment,
            no int, 
            name varchar(1024),
            key idx_no(no))";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Create Table Failed: " . mysql_error($link));
    } else {
        echo "Create Table Succeed<br />";
    }
    
    //插入数据
    $sql = "insert into test_mysql(no, name) values(2007,'this is a test message'),
            (2008,'this is another test message'),
            (2009,'xxxxxxxxxxxxxx')";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Insert Failed: " . mysql_error($link));
    } else {
        echo "Insert Succeed<br />";
    }
    
    //删除数据
    $sql = "delete from test_mysql where no = 2008";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Delete Failed: " . mysql_error($link));
    } else {
        echo "Delete  Succeed<br />";
    }
    
    //修改数据
    $sql = "update test_mysql set name = 'yyyyyy' where no = 2009";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Update Failed: " . mysql_error($link));
    } else {
        echo "Update Succeed<br />";
    }
    
    
    //检索数据
    $sql = "select id,no,name from test_mysql";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Select Failed: " . mysql_error($link));
    } else {
        echo "Select Succeed<br />";
        while ($row = mysql_fetch_assoc($ret)) {
            echo "{$row['id']} {$row['no']} {$row['name']}<br />";
        }
    }
    
    //删除表
    $sql = "drop table if exists test_mysql";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Drop Table Failed: " . mysql_error($link));
    } else {
        echo "Drop Table Succeed<br />";
    }


||||||| .r74
<?php
/**
 * MySQL示例，通过该示例可熟悉BAE平台MySQL的使用（CRUD）
 */
require_once("../configure.php");
    /*替换为你自己的数据库名（可从管理中心查看到）*/
    $dbname = test_mysql;
     
    /*从环境变量里取出数据库连接需要的参数*/
    $host = getenv('SAE_MYSQL_HOST_M');
    $port = getenv('SAE_MYSQL_PORT');
    $user = getenv('SAE_MYSQL_USER');
    $pwd = getenv('SAE_MYSQL_PASS');
    
    /*接着调用mysql_connect()连接服务器*/
    $link = @mysql_connect("{$host}:{$port}",$user,$pwd,true);
    if(!$link) {
      die("Connect Server Failed: " . mysql_error());
    }
    /*连接成功后立即调用mysql_select_db()选中需要连接的数据库*/
    if(!mysql_select_db($dbname,$link)) {
      die("Select Database Failed: " . mysql_error($link));
    }
    /*至此连接已完全建立，就可对当前数据库进行相应的操作了*/
    /*！！！注意，无法再通过本次连接调用mysql_select_db来切换到其它数据库了！！！*/
    /* 需要再连接其它数据库，请再使用mysql_connect+mysql_select_db启动另一个连接*/
     
    /**
    * 接下来就可以使用其它标准php mysql函数操作进行数据库操作
    */
    
    //创建一个数据库表
    $sql = "create table if not exists test_mysql(
            id int primary key auto_increment,
            no int, 
            name varchar(1024),
            key idx_no(no))";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Create Table Failed: " . mysql_error($link));
    } else {
        echo "Create Table Succeed<br />";
    }
    
    //插入数据
    $sql = "insert into test_mysql(no, name) values(2007,'this is a test message'),
            (2008,'this is another test message'),
            (2009,'xxxxxxxxxxxxxx')";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Insert Failed: " . mysql_error($link));
    } else {
        echo "Insert Succeed<br />";
    }
    
    //删除数据
    $sql = "delete from test_mysql where no = 2008";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Delete Failed: " . mysql_error($link));
    } else {
        echo "Delete  Succeed<br />";
    }
    
    //修改数据
    $sql = "update test_mysql set name = 'yyyyyy' where no = 2009";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Update Failed: " . mysql_error($link));
    } else {
        echo "Update Succeed<br />";
    }
    
    
    //检索数据
    $sql = "select id,no,name from test_mysql";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Select Failed: " . mysql_error($link));
    } else {
        echo "Select Succeed<br />";
        while ($row = mysql_fetch_assoc($ret)) {
            echo "{$row['id']} {$row['no']} {$row['name']}<br />";
        }
    }
    
    //删除表
    $sql = "drop table if exists test_mysql";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Drop Table Failed: " . mysql_error($link));
    } else {
        echo "Drop Table Succeed<br />";
    }


=======
<?php
/**
 * MySQL示例，通过该示例可熟悉BAE平台MySQL的使用（CRUD）
 */
require_once("config.php");
    /*替换为你自己的数据库名（可从管理中心查看到）*/
    $dbname = test_mysql;
     
    /*从环境变量里取出数据库连接需要的参数*/
    $host = getenv('SAE_MYSQL_HOST_M');
    $port = getenv('SAE_MYSQL_PORT');
    $user = getenv('SAE_MYSQL_USER');
    $pwd = getenv('SAE_MYSQL_PASS');
    
    /*接着调用mysql_connect()连接服务器*/
    $link = @mysql_connect("{$host}:{$port}",$user,$pwd,true);
    if(!$link) {
      die("Connect Server Failed: " . mysql_error());
    }
    /*连接成功后立即调用mysql_select_db()选中需要连接的数据库*/
    if(!mysql_select_db($dbname,$link)) {
      die("Select Database Failed: " . mysql_error($link));
    }
    /*至此连接已完全建立，就可对当前数据库进行相应的操作了*/
    /*！！！注意，无法再通过本次连接调用mysql_select_db来切换到其它数据库了！！！*/
    /* 需要再连接其它数据库，请再使用mysql_connect+mysql_select_db启动另一个连接*/
     
    /**
    * 接下来就可以使用其它标准php mysql函数操作进行数据库操作
    */
    
    //创建一个数据库表
    $sql = "create table if not exists test_mysql(
            id int primary key auto_increment,
            no int, 
            name varchar(1024),
            key idx_no(no))";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Create Table Failed: " . mysql_error($link));
    } else {
        echo "Create Table Succeed<br />";
    }
    
    //插入数据
    $sql = "insert into test_mysql(no, name) values(2007,'this is a test message'),
            (2008,'this is another test message'),
            (2009,'xxxxxxxxxxxxxx')";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Insert Failed: " . mysql_error($link));
    } else {
        echo "Insert Succeed<br />";
    }
    
    //删除数据
    $sql = "delete from test_mysql where no = 2008";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Delete Failed: " . mysql_error($link));
    } else {
        echo "Delete  Succeed<br />";
    }
    
    //修改数据
    $sql = "update test_mysql set name = 'yyyyyy' where no = 2009";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Update Failed: " . mysql_error($link));
    } else {
        echo "Update Succeed<br />";
    }
    
    
    //检索数据
    $sql = "select id,no,name from test_mysql";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Select Failed: " . mysql_error($link));
    } else {
        echo "Select Succeed<br />";
        while ($row = mysql_fetch_assoc($ret)) {
            echo "{$row['id']} {$row['no']} {$row['name']}<br />";
        }
    }
    
    //删除表
    $sql = "drop table if exists test_mysql";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Drop Table Failed: " . mysql_error($link));
    } else {
        echo "Drop Table Succeed<br />";
    }


>>>>>>> .r77
||||||| .r77
<?php
/**
 * MySQL示例，通过该示例可熟悉BAE平台MySQL的使用（CRUD）
 */
require_once("config.php");
    /*替换为你自己的数据库名（可从管理中心查看到）*/
    $dbname = test_mysql;
     
    /*从环境变量里取出数据库连接需要的参数*/
    $host = getenv('SAE_MYSQL_HOST_M');
    $port = getenv('SAE_MYSQL_PORT');
    $user = getenv('SAE_MYSQL_USER');
    $pwd = getenv('SAE_MYSQL_PASS');
    
    /*接着调用mysql_connect()连接服务器*/
    $link = @mysql_connect("{$host}:{$port}",$user,$pwd,true);
    if(!$link) {
      die("Connect Server Failed: " . mysql_error());
    }
    /*连接成功后立即调用mysql_select_db()选中需要连接的数据库*/
    if(!mysql_select_db($dbname,$link)) {
      die("Select Database Failed: " . mysql_error($link));
    }
    /*至此连接已完全建立，就可对当前数据库进行相应的操作了*/
    /*！！！注意，无法再通过本次连接调用mysql_select_db来切换到其它数据库了！！！*/
    /* 需要再连接其它数据库，请再使用mysql_connect+mysql_select_db启动另一个连接*/
     
    /**
    * 接下来就可以使用其它标准php mysql函数操作进行数据库操作
    */
    
    //创建一个数据库表
    $sql = "create table if not exists test_mysql(
            id int primary key auto_increment,
            no int, 
            name varchar(1024),
            key idx_no(no))";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Create Table Failed: " . mysql_error($link));
    } else {
        echo "Create Table Succeed<br />";
    }
    
    //插入数据
    $sql = "insert into test_mysql(no, name) values(2007,'this is a test message'),
            (2008,'this is another test message'),
            (2009,'xxxxxxxxxxxxxx')";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Insert Failed: " . mysql_error($link));
    } else {
        echo "Insert Succeed<br />";
    }
    
    //删除数据
    $sql = "delete from test_mysql where no = 2008";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Delete Failed: " . mysql_error($link));
    } else {
        echo "Delete  Succeed<br />";
    }
    
    //修改数据
    $sql = "update test_mysql set name = 'yyyyyy' where no = 2009";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Update Failed: " . mysql_error($link));
    } else {
        echo "Update Succeed<br />";
    }
    
    
    //检索数据
    $sql = "select id,no,name from test_mysql";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Select Failed: " . mysql_error($link));
    } else {
        echo "Select Succeed<br />";
        while ($row = mysql_fetch_assoc($ret)) {
            echo "{$row['id']} {$row['no']} {$row['name']}<br />";
        }
    }
    
    //删除表
    $sql = "drop table if exists test_mysql";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Drop Table Failed: " . mysql_error($link));
    } else {
        echo "Drop Table Succeed<br />";
    }


=======
<?php
/**
 * MySQL示例，通过该示例可熟悉BAE平台MySQL的使用（CRUD）
 */
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
    /*！！！注意，无法再通过本次连接调用mysql_select_db来切换到其它数据库了！！！*/
    /* 需要再连接其它数据库，请再使用mysql_connect+mysql_select_db启动另一个连接*/
     
    /**
    * 接下来就可以使用其它标准php mysql函数操作进行数据库操作
    */
    
    //创建一个数据库表
    $sql = "create table if not exists test_mysql(
            id int primary key auto_increment,
            no int, 
            name varchar(1024),
            key idx_no(no))";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Create Table Failed: " . mysql_error($link));
    } else {
        echo "Create Table Succeed<br />";
    }
    
    //插入数据
    $sql = "insert into test_mysql(from_user, account) values(2007,'this is a test message'),
            (2008,'this is another test message'),
            (2009,'xxxxxxxxxxxxxx')";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Insert Failed: " . mysql_error($link));
    } else {
        echo "Insert Succeed<br />";
    }
    
    //删除数据
    $sql = "delete from test_mysql where from_user = 2008";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Delete Failed: " . mysql_error($link));
    } else {
        echo "Delete  Succeed<br />";
    }
    
    //修改数据
    $sql = "update test_mysql set account = 'yyyyyy' where from_user = 2009";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Update Failed: " . mysql_error($link));
    } else {
        echo "Update Succeed<br />";
    }
    
    
    //检索数据
    $sql = "select id,from_user,account from test_mysql";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Select Failed: " . mysql_error($link));
    } else {
        echo "Select Succeed<br />";
        while ($row = mysql_fetch_assoc($ret)) {
            echo "{$row['id']} {$row['from_user']} {$row['account']}<br />";
        }
    }
    
    //删除表
    $sql = "drop table if exists test_mysql";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
        die("Drop Table Failed: " . mysql_error($link));
    } else {
        echo "Drop Table Succeed<br />";
    }


>>>>>>> .r80
?>