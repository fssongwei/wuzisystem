<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<link href="style.css" rel='stylesheet' type='text/css' />
<link href="style2.css" rel='stylesheet' type='text/css' />
<title>申请列表</title> 
<style type="text/css">
h1 {font-family:FangSong;}
</style>
</head>
<body bgcolor="#FBF9FE">
<?php
include('function.php');
session_start();

if(isset($_GET['choose'])){$choose = $_GET['choose'];}else{$choose = '全部申请';}
echo '<div class="weui_cells"><div class="weui_cell weui_cell_select weui_select_after">
<div class="weui_cell_hd"><label for="" class="weui_label">筛选</label></div>
<div class="weui_cell_bd weui_cell_primary">
<select class="weui_select"  onchange="window.location=this.value;" name="select">';

echo "<option value=''>$choose</option>
<option value='applylist.php?choose=全部申请'>全部申请</option>
<option value='applylist.php?choose=审核中'>审核中</option>
<option value='applylist.php?choose=已通过'>已通过</option>
<option value='applylist.php?choose=未通过'>未通过</option>
<option value='applylist.php?choose=已借出'>已借出</option>
<option value='applylist.php?choose=已归还'>已归还</option>
</select></div></div></div>";


if(isset($_GET['userid'])){$userid = $_GET['userid'];}
if(isset($_SESSION['userid'])){$userid = $_SESSION['userid'];}
if(isset($userid)){$_SESSION['userid'] = $userid;}

if(isset($_GET['accesstoken'])){$accesstoken = $_GET['accesstoken'];}
if(isset($_SESSION['accesstoken'])){$accesstoken = $_SESSION['accesstoken'];}
if(isset($accesstoken)){$_SESSION['accesstoken'] = $accesstoken;}

$name = getuniquecolumn('qyhlogin','sna2008','userid',$userid,'name');
$department = getuniquecolumn('qyhlogin','sna2008','userid',$userid,'department');

if($choose == '审核中' || $choose == '全部申请'){
//导出审核中的申请
logindatabase('wuziapply','sna2008');
$check = mysql_query("select * from wuziapply where name = '$name' and department = '$department' ");
$i = 1;


while($array = mysql_fetch_array($check))
{
$var = "applyid".$i;
$a = $i - 1;
$var2 = "applyid".$a;
$$var = $array["applyid"];
$applyid = $$var;

$borrowdate = $array["borrowdate"];
$returndate = $array["returndate"];
$campus = $array["campus"];
$state = $array["state"];

if($state == ''){

if(!isset($$var2)){
echo "
<br><a href='detail.php?userid=$userid&accesstoken=$accesstoken&applyid=$applyid'>
<div class='weui-form-preview'>
<div class='weui-form-preview__hd'>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>状态</label>
<em class='weui-form-preview__value'>审核中</em>
</div>
</div>
<div class='weui-form-preview__bd'>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借用部门（校区）</label>
<span class='weui-form-preview__value'>$department ($campus)</span>
</div>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借用时间</label>
<span class='weui-form-preview__value'>$borrowdate 至 $returndate</span>
</div>
</div> 
</div>      
</a>
";
}

if(isset($$var2) && $$var != $$var2){

echo "

<br><a href='detail.php?userid=$userid&accesstoken=$accesstoken&applyid=$applyid'>
          <div class='weui-form-preview'>
<div class='weui-form-preview__hd'>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>状态</label>
<em class='weui-form-preview__value'>审核中</em>
</div>
</div>
<div class='weui-form-preview__bd'>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借用部门（校区）</label>
<span class='weui-form-preview__value'>$department ($campus)</span>
</div>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借用时间</label>
<span class='weui-form-preview__value'>$borrowdate 至 $returndate</span>
</div>
</div>    
</div>   
</a>
";


}
$i++;
}

}
}


if($choose == '已通过' || $choose == '全部申请'){
//导出审核通过的申请
logindatabase('wuziapply','sna2008');
$check = mysql_query("select * from wuziapply where name = '$name' and department = '$department' ");
$j = 1;


while($array = mysql_fetch_array($check))
{
$var = "applyid".$j;
$a = $j - 1;
$var2 = "applyid".$a;
$$var = $array["applyid"];
$applyid = $$var;


$borrowdate = $array["borrowdate"];
$returndate = $array["returndate"];
$state = $array["state"];
$campus = $array["campus"];
$checkname = $array["checkname"];


if($state == '审核通过'){

if(!isset($$var2)){
echo "

<br><a href='detail.php?userid=$userid&accesstoken=$accesstoken&applyid=$applyid'>
<div class='weui-form-preview'>
<div class='weui-form-preview__hd'>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>状态</label>
<em class='weui-form-preview__value'>已通过</em>
</div>
</div>
<div class='weui-form-preview__bd'>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借用部门（校区）</label>
<span class='weui-form-preview__value'>$department ($campus)</span>
</div>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借用时间</label>
<span class='weui-form-preview__value'>$borrowdate 至 $returndate</span>
</div>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>审批人</label>
<span class='weui-form-preview__value'>$checkname</span>
</div>
</div> 
</div>      
</a>
";

}

if(isset($$var2) && $$var != $$var2){
echo "

<br><a href='detail.php?userid=$userid&accesstoken=$accesstoken&applyid=$applyid'>
<div class='weui-form-preview'>
<div class='weui-form-preview__hd'>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>状态</label>
<em class='weui-form-preview__value'>已通过</em>
</div>
</div>
<div class='weui-form-preview__bd'>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借用部门（校区）</label>
<span class='weui-form-preview__value'>$department ($campus)</span>
</div>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借用时间</label>
<span class='weui-form-preview__value'>$borrowdate 至 $returndate</span>
</div>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>审批人</label>
<span class='weui-form-preview__value'>$checkname</span>
</div>
</div> 
</div>      
</a>
";
}
$j++;
}


}

}

if($choose == '未通过' || $choose == '全部申请'){
//导出审核不通过的申请
logindatabase('wuziapply','sna2008');
$check = mysql_query("select * from wuziapply where name = '$name' and department = '$department' ");

$k = 1;


while($array = mysql_fetch_array($check))
{
$var = "applyid".$k;
$a = $k - 1;
$var2 = "applyid".$a;
$$var = $array["applyid"];
$applyid = $$var;

$borrowdate = $array["borrowdate"];
$returndate = $array["returndate"];
$state = $array["state"];
$campus = $array["campus"];
$checkname = $array["checkname"];

if($state == '审核不通过'){

if(!isset($$var2)){
echo "

<br><a href='detail.php?userid=$userid&accesstoken=$accesstoken&applyid=$applyid'>
<div class='weui-form-preview'>
<div class='weui-form-preview__hd'>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>状态</label>
<em class='weui-form-preview__value'>未通过</em>
</div>
</div>
<div class='weui-form-preview__bd'>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借用部门（校区）</label>
<span class='weui-form-preview__value'>$department ($campus)</span>
</div>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借用时间</label>
<span class='weui-form-preview__value'>$borrowdate 至 $returndate</span>
</div>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>审批人</label>
<span class='weui-form-preview__value'>$checkname</span>
</div>
</div> 
</div>      
</a>
";

}

if(isset($$var2) && $$var != $$var2){
echo "

<br><a href='detail.php?userid=$userid&accesstoken=$accesstoken&applyid=$applyid'>
<div class='weui-form-preview'>
<div class='weui-form-preview__hd'>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>状态</label>
<em class='weui-form-preview__value'>未通过</em>
</div>
</div>
<div class='weui-form-preview__bd'>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借用部门（校区）</label>
<span class='weui-form-preview__value'>$department ($campus)</span>
</div>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借用时间</label>
<span class='weui-form-preview__value'>$borrowdate 至 $returndate</span>
</div>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>审批人</label>
<span class='weui-form-preview__value'>$checkname</span>
</div>
</div> 
</div>      
</a>
";
}
$k++;
}


}

}


if($choose == '已借出' || $choose == '全部申请'){
//导出已借出的申请
logindatabase('wuziapply','sna2008');
$check = mysql_query("select * from wuziapply where name = '$name' and department = '$department' ");

$l = 1;


while($array = mysql_fetch_array($check))
{
$var = "applyid".$l;
$a = $l - 1;
$var2 = "applyid".$a;
$$var = $array["applyid"];
$applyid = $$var;

$borrowdate = $array["borrowdate"];
$returndate = $array["returndate"];
$state = $array["state"];
$campus = $array["campus"];
$borrowname = $array["borrowname"];

if($state == '已借出'){

if(!isset($$var2)){
echo "

<br><a href='detail.php?userid=$userid&accesstoken=$accesstoken&applyid=$applyid'>
<div class='weui-form-preview'>
<div class='weui-form-preview__hd'>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>状态</label>
<em class='weui-form-preview__value'>已借出</em>
</div>
</div>
<div class='weui-form-preview__bd'>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借用部门（校区）</label>
<span class='weui-form-preview__value'>$department ($campus)</span>
</div>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借用时间</label>
<span class='weui-form-preview__value'>$borrowdate 至 $returndate</span>
</div>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借出人</label>
<span class='weui-form-preview__value'>$borrowname</span>
</div>
</div> 
</div>      
</a>
";

}

if(isset($$var2) && $$var != $$var2){
echo "

<br><a href='detail.php?userid=$userid&accesstoken=$accesstoken&applyid=$applyid'>
<div class='weui-form-preview'>
<div class='weui-form-preview__hd'>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>状态</label>
<em class='weui-form-preview__value'>已借出</em>
</div>
</div>
<div class='weui-form-preview__bd'>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借用部门（校区）</label>
<span class='weui-form-preview__value'>$department ($campus)</span>
</div>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借用时间</label>
<span class='weui-form-preview__value'>$borrowdate 至 $returndate</span>
</div>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借出人</label>
<span class='weui-form-preview__value'>$borrowname</span>
</div>
</div> 
</div>      
</a>
";
}
$l++;
}


}

}


if($choose == '已归还' || $choose == '全部申请'){
logindatabase('wuziapply','sna2008');
$check = mysql_query("select * from wuziapply where name = '$name' and department = '$department' ");

$m = 1;


while($array = mysql_fetch_array($check))
{
$var = "applyid".$m;
$a = $m - 1;
$var2 = "applyid".$a;
$$var = $array["applyid"];
$applyid = $$var;

$borrowdate = $array["borrowdate"];
$returndate = $array["returndate"];
$state = $array["state"];
$campus = $array["campus"];
$returnname = $array["returnname"];

if($state == '已归还'){

if(!isset($$var2)){
echo "

<br><a href='detail.php?userid=$userid&accesstoken=$accesstoken&applyid=$applyid'>
<div class='weui-form-preview'>
<div class='weui-form-preview__hd'>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>状态</label>
<em class='weui-form-preview__value'>已归还</em>
</div>
</div>
<div class='weui-form-preview__bd'>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借用部门（校区）</label>
<span class='weui-form-preview__value'>$department ($campus)</span>
</div>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借用时间</label>
<span class='weui-form-preview__value'>$borrowdate 至 $returndate</span>
</div>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>归还确认</label>
<span class='weui-form-preview__value'>$returnname</span>
</div>
</div> 
</div>      
</a>
";

}

if(isset($$var2) && $$var != $$var2){
echo "

<br><a href='detail.php?userid=$userid&accesstoken=$accesstoken&applyid=$applyid'>
<div class='weui-form-preview'>
<div class='weui-form-preview__hd'>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>状态</label>
<em class='weui-form-preview__value'>已归还</em>
</div>
</div>
<div class='weui-form-preview__bd'>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借用部门（校区）</label>
<span class='weui-form-preview__value'>$department ($campus)</span>
</div>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>借用时间</label>
<span class='weui-form-preview__value'>$borrowdate 至 $returndate</span>
</div>
<div class='weui-form-preview__item'>
<label class='weui-form-preview__label'>归还确认</label>
<span class='weui-form-preview__value'>$returnname</span>
</div>
</div> 
</div>      
</a>
";
}
$m++;
}


}

}

$allitem = $i + $j + $k + $l + $m ;
if($choose == '全部申请' && $allitem <= 8){
echo '<br><br><div class="weui-footer weui-footer_fixed-bottom">';
}
else
if($choose == '审核中' && $i <= 3 ){
echo '<br><br><div class="weui-footer weui-footer_fixed-bottom">';
}
else
if($choose == '已通过' && $j <= 3 ){
echo '<br><br><div class="weui-footer weui-footer_fixed-bottom">';
}
else
if($choose == '未通过' && $k <= 3 ){
echo '<br><br><div class="weui-footer weui-footer_fixed-bottom">';
}
else
if($choose == '已借出' && $l <= 3 ){
echo '<br><br><div class="weui-footer weui-footer_fixed-bottom">';
}
else
if($choose == '已归还' && $m <= 3 ){
echo '<br><br><div class="weui-footer weui-footer_fixed-bottom">';
}
else {
echo '<br><br><div class="weui-footer">';

}

echo '<p class="weui-footer__links">
<a href="http://tw.jnu.edu.cn" class="weui-footer__link">共青团暨南大学委员会</a></p>
<p class="weui-footer__text">Copyright © 2015-2016 jnusna</p></div><br>';
?>

</body>
</html>
