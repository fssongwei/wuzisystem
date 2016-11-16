
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
session_start();

echo '<div class="weui_cells">
        <div class="weui_cell weui_cell_select weui_select_after">
            <div class="weui_cell_hd">
                <label for="" class="weui_label">选择部门</label>
            </div>
            <div class="weui_cell_bd weui_cell_primary">
                        <select class="weui_select"  onchange="window.location=this.value;" name="select"><option value="">';
                    

if(isset($_GET['department'])){echo $_GET['department'];}


echo '
</option>
                    <option value="applylistsouth.php?department=秘书处">秘书处</option>
                    <option value="applylistsouth.php?department=组织部">组织部</option>
                    <option value="applylistsouth.php?department=宣传部">宣传部</option>
                    <option value="applylistsouth.php?department=学术科技部">学术科技部</option>
                    <option value="applylistsouth.php?department=社会实践部">社会实践部</option>
                    <option value="applylistsouth.php?department=联络部">联络部</option>
                    <option value="applylistsouth.php?department=编辑部">编辑部</option>
                    <option value="applylistsouth.php?department=人力资源部">人力资源部</option>
                    <option value="applylistsouth.php?department=调研部">调研部</option>
                    <option value="applylistsouth.php?department=国旗护卫队">国旗护卫队</option>
                    <option value="applylistsouth.php?department=礼仪队">礼仪队</option>
                    <option value="applylistsouth.php?department=学生网络联盟">学生网络联盟</option>
                    <option value="applylistsouth.php?department=新媒体部">新媒体部</option>
					<option value="applylistsouth.php?department=司仪小组">司仪小组</option>
					<option value="applylistsouth.php?department=秘书长">秘书长</option>
                </select>
            </div>
        </div>
    </div>
';


$campus = '南校区';

if(isset($_GET['userid'])){$userid = $_GET['userid'];}
if(isset($_SESSION['userid'])){$userid = $_SESSION['userid'];}
if(isset($userid)){$_SESSION['userid'] = $userid;}

if(isset($_GET['accesstoken'])){$accesstoken = $_GET['accesstoken'];}
if(isset($_SESSION['accesstoken'])){$accesstoken = $_SESSION['accesstoken'];}
if(isset($accesstoken)){$_SESSION['accesstoken'] = $accesstoken;}

if(isset($_GET['department'])){$department = $_GET['department'];}else{$department = '';}




//导出审核中的申请
$url = "127.0.0.1";
$user = "root";
$password = "sna2008";
$con = mysql_connect($url,$user,$password);
mysql_query("set names 'utf8'");
mysql_select_db("wuziapply",$con);
$check = mysql_query("select * from wuziapply where department = '$department' and campus = '$campus' ");
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
$name = $array["name"];
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
<label class='weui-form-preview__label'>申请人</label>
<span class='weui-form-preview__value'>$name</span>
</div>
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
<label class='weui-form-preview__label'>申请人</label>
<span class='weui-form-preview__value'>$name</span>
</div>
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






//导出审核通过的申请
$url = "127.0.0.1";
$user = "root";
$password = "sna2008";
$con = mysql_connect($url,$user,$password);
mysql_query("set names 'utf8'");
mysql_select_db("wuziapply",$con);
$check = mysql_query("select * from wuziapply where department = '$department' and campus = '$campus' ");
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
$name = $array["name"];
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
<label class='weui-form-preview__label'>申请人</label>
<span class='weui-form-preview__value'>$name</span>
</div>
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
<label class='weui-form-preview__label'>申请人</label>
<span class='weui-form-preview__value'>$name</span>
</div>
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
$i++;
}

}




//导出审核不通过的申请
$url = "127.0.0.1";
$user = "root";
$password = "sna2008";
$con = mysql_connect($url,$user,$password);
mysql_query("set names 'utf8'");
mysql_select_db("wuziapply",$con);
$check = mysql_query("select * from wuziapply where  department = '$department' and campus = '$campus' ");

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
$name = $array["name"];
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
<label class='weui-form-preview__label'>申请人</label>
<span class='weui-form-preview__value'>$name</span>
</div>
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
<label class='weui-form-preview__label'>申请人</label>
<span class='weui-form-preview__value'>$name</span>
</div>
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
$i++;
}

}





//导出已借出的申请
$url = "127.0.0.1";
$user = "root";
$password = "sna2008";
$con = mysql_connect($url,$user,$password);
mysql_query("set names 'utf8'");
mysql_select_db("wuziapply",$con);
$check = mysql_query("select * from wuziapply where  department = '$department' and campus = '$campus' ");

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
$name = $array["name"];
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
<label class='weui-form-preview__label'>申请人</label>
<span class='weui-form-preview__value'>$name</span>
</div>
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
<label class='weui-form-preview__label'>申请人</label>
<span class='weui-form-preview__value'>$name</span>
</div>
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
$i++;
}

}




//导出已归还的申请
$url = "127.0.0.1";
$user = "root";
$password = "sna2008";
$con = mysql_connect($url,$user,$password);
mysql_query("set names 'utf8'");
mysql_select_db("wuziapply",$con);
$check = mysql_query("select * from wuziapply where  department = '$department' and campus = '$campus' ");

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
$name = $array["name"];
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
<label class='weui-form-preview__label'>申请人</label>
<span class='weui-form-preview__value'>$name</span>
</div>
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
<label class='weui-form-preview__label'>申请人</label>
<span class='weui-form-preview__value'>$name</span>
</div>
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
$i++;
}

}


echo '<br><br><div class="weui-footer">
            <p class="weui-footer__links">
                <a href="http://tw.jnu.edu.cn" class="weui-footer__link">共青团暨南大学委员会</a>
            </p>
            <p class="weui-footer__text">Copyright © 2015-2016 jnusna</p>
        </div><br>';



?>

</body>
</html>
