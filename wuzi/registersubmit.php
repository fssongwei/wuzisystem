
<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<link href="style.css" rel='stylesheet' type='text/css' />
<title>确认信息</title> 
<style type="text/css">
h1 {font-family:FangSong;}
</style>
</head>



<body bgcolor="#FBF9FE">

<?php



session_start();



$userid = $_POST['userid'];
$name = $_POST['name'];
$department = $_POST['department'];
$identity = $_POST['identity'];
if($identity == '部长'){$identity = 2;}
if($identity == '干事'){$identity = 1;}



$url = "127.0.0.1";
$user = "root";
$password = "sna2008";
$con = mysql_connect($url,$user,$password);
mysql_query("set names 'utf8'");
mysql_select_db("qyhlogin",$con);




//获取SESSION信息并复制到变量（month只能提交当月的表单）



//检查数据库是否已经有表单数据
$check_query = mysql_query("select * from qyhlogin where department='$department' and name = '$name' ");

if($result = mysql_fetch_array($check_query))
{
//如果数据库存在表单数据则更新此记录的数据
$check_query = mysql_query(" UPDATE qyhlogin SET userid = '$userid', identity = '$identity' WHERE department = '$department' and name = '$name' ");
echo "<script>alert('提交成功');
document.addEventListener('WeixinJSBridgeReady', function(){ WeixinJSBridge.call('closeWindow'); }, false);
</script>";

}else{

//如果数据库不存在表单数据则插入一条新的记录
$sql = "insert into qyhlogin (userid,name,department,identity)  values('$userid','$name','$department','$identity')";
if (!mysql_query($sql,$con)){die('Error: ' . mysql_error());}
echo "<script>alert('提交成功');
document.addEventListener('WeixinJSBridgeReady', function(){ WeixinJSBridge.call('closeWindow'); }, false);
</script>";

mysql_close($con);
}


?>

</body>
</html>
