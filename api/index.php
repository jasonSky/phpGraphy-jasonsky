<?php
    //ini_set("display_errors", "On");
    //error_reporting(E_ALL | E_STRICT);
    header("Content-type:text/html;charset=utf-8");
    //连接数据库
    $con = mysql_connect("localhost:3309","root","!QAZ2wsx");
    if ($con) {
        //echo "connect success";
        //选择数据库
        mysql_select_db("SpiderData",$con);
        mysql_query("set names 'utf8'"); //select 数据库之后加多这一句
        //获得GET里面的值
        $name = $_GET['name'];
        //查询数据库
        $query = mysql_query("SELECT name,url FROM m3u8 where name like '%".$name."%'");
        //数据库查询结果保存为数组（注意第二个参数）
        // MYSQL_ASSOC - 关联数组
        // MYSQL_NUM - 数字数组
        // MYSQL_BOTH - 默认。同时产生关联和数字数组
        $num=mysql_num_rows($query);
	$result=array();
        $result["code"]=200;
        $result["count"]=$num;
        //这里用一个for循环输出所有满足条件的查询语句
    	for ($i=0; $i <$num ; $i++) { 
             $row = mysql_fetch_array($query,MYSQL_ASSOC);
             $result["data"][$i] = array("name"=>urlencode($row['name']),"url"=>urlencode($row['url']),"live"=>urlencode("http://blog.jasonsky.com.cn/player/?video=".$row['url']));
    	}
        $json = json_encode($result);
        echo (urldecode($json)) ;
    }else{
        $result=array();
        $result["code"]=500;
        $result["msg"]= "Server Failed!";
        echo json_encode($result);
    }
 
    mysql_close($con);
?>
