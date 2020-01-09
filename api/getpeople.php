<?php
    //ini_set("display_errors", "On");
    //error_reporting(E_ALL | E_STRICT);
    header("Content-type:text/html;charset=utf-8");
    //连接数据库
    $con = mysqli_connect("localhost:3309","root","!QAZ2wsx","SpiderData");
    if ($con) {
        //echo "connect success";
        //选择数据库
        //mysqli_select_db("SpiderData",$con);
        mysqli_query($con, "set names 'utf8'"); //select 数据库之后加多这一句
        //获得GET里面的值
        $name = $_GET['name'];
        //查询数据库
        $query = mysqli_query($con, "SELECT * FROM People");
        //数据库查询结果保存为数组（注意第二个参数）
        // MYSQL_ASSOC - 关联数组
        // MYSQL_NUM - 数字数组
        // MYSQL_BOTH - 默认。同时产生关联和数字数组
        $num=mysqli_num_rows($query);
	$result=array();
        $result["code"]=200;
        $result["count"]=$num;
        //这里用一个for循环输出所有满足条件的查询语句
    	for ($i=0; $i <$num ; $i++) { 
             $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
             $result["data"][$i] = array("name"=>urlencode($row['name']),"birthday"=>urlencode($row['birthday']),"summary"=>urlencode($row['summary']));
    	}
        $json = json_encode($result);
        echo (urldecode($json)) ;
    }else{
        $result=array();
        $result["code"]=500;
        $result["msg"]= mysqli_connect_error();
        echo json_encode($result);
    }
 
    mysqli_close($con);
?>
