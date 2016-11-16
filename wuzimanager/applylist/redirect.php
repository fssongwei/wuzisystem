<?php
include('function.php');
//获取表单数据
$accesstoken =$_POST['accesstoken'];
$userid=$_POST['userid'];
$applyid=$_POST['applyid'];


linkdb('wuziapply');
$check = mysql_query("select * from wuziapply where applyid = '$applyid' ");
while($array = mysql_fetch_array($check))
{
$itemid = $array["itemid"];

if($_POST[$itemid] == ''){echo "<script>alert('未填写归还物资数量，请重新填写');</script>";
echo "<script language=\"javascript\">location.href = 'javascript:history.back()'</script>";
exit;}
mysql_query(" UPDATE wuziapply SET quantity = '$_POST[$itemid]' WHERE itemid = '$itemid' and applyid = '$applyid' ");
}

header("location:submit.php?userid=$userid&accesstoken=$accesstoken&applyid=$applyid&state=3");
?>

