<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<link rel="stylesheet" href="css/weui.css"/>
<link rel="stylesheet" href="css/example.css"/>

<title>审核意见</title>
</head>

<body bgcolor="#FBF9FE">

<?php
include('function.php');
//获取表单数据
$accesstoken =$_GET['accesstoken'];
$userid=$_GET['userid'];
$applyid=$_GET['applyid'];

echo '<form action="submit.php" method="get">
    <div class="weui-cells__title">审核意见</div>
    <div class="weui-cells weui-cells_form">
    <div class="weui-cell">
    <div class="weui-cell__bd">
    <textarea name="opinion" class="weui-textarea" placeholder="(选填)" rows="3"></textarea>
    </div>
    </div>
    </div>';

echo "<br>
<input type='hidden' name='userid' value='$userid'>
<input type='hidden' name='accesstoken' value='$accesstoken'>
<input type='hidden' name='applyid' value='$applyid'>
<input type='hidden' name='state' value='0'>

<div class='weui-btn-area'>
<input class='weui-btn weui-btn_warn' type='submit' value='拒绝申请' />
</div></form></br>";

printFooter(0);
?>
</body>
</html>
