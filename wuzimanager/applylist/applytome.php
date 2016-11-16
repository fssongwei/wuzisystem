<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<link rel="stylesheet" href="css/weui.css"/>
<link rel="stylesheet" href="css/example.css"/>

<title>申请列表</title>
</head>

<body bgcolor="#FBF9FE">

<?php
session_start();
include('function.php');

if(isset($_GET['userid'])){$userid = $_GET['userid'];}
if(isset($_GET['accesstoken'])){$accesstoken = $_GET['accesstoken'];}

linkdb('qyhlogin');
$name = fetchData('qyhlogin','userid',$userid,'name');

//导出审核中的申请
linkdb('wuziapply');
$check = mysql_query("select * from wuziapply where checkname = '$name' ");
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
$fromname = $array["name"];
$campus = $array["campus"];
$department = $array["department"];
$state = $array["state"];

if($state == '')
{
    if(!isset($$var2))
    {
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
        <span class='weui-form-preview__value'>$fromname</span>
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
        </a>";
    }

    if(isset($$var2) && $$var != $$var2)
    {
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
        <span class='weui-form-preview__value'>$fromname</span>
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
        </a>";
    }
    $i++;
}
}

//导出审核通过的申请
linkdb('wuziapply');
$check = mysql_query("select * from wuziapply where checkname = '$name' ");
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
$fromname = $array["name"];
$state = $array["state"];
$campus = $array["campus"];
$checkname = $array["checkname"];
$department = $array["department"];


if($state == '审核通过')
{
    if(!isset($$var2))
    {
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
        <span class='weui-form-preview__value'>$fromname</span>
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
        </a>";
    }

    if(isset($$var2) && $$var != $$var2)
    {
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
        <span class='weui-form-preview__value'>$fromname</span>
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
        </a>";
    }
$i++;
}
}

//导出审核不通过的申请
linkdb('wuziapply');
$check = mysql_query("select * from wuziapply where  checkname = '$name' ");
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
$fromname = $array["name"];
$state = $array["state"];
$campus = $array["campus"];
$checkname = $array["checkname"];
$department = $array["department"];

if($state == '审核不通过')
{
    if(!isset($$var2))
    {
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
        <span class='weui-form-preview__value'>$fromname</span>
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
        </a>";
    }

    if(isset($$var2) && $$var != $$var2)
    {
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
        <span class='weui-form-preview__value'>$fromname</span>
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
        </a>";
    }
$i++;
}
}





//导出已借出的申请
linkdb('wuziapply');
$check = mysql_query("select * from wuziapply where  borrowname = '$name' ");
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
$fromname = $array["name"];
$state = $array["state"];
$campus = $array["campus"];
$borrowname = $array["borrowname"];
$department = $array["department"];


if($state == '已借出')
{
    if(!isset($$var2))
    {
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
        <span class='weui-form-preview__value'>$fromname</span>
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
        </a>";
    }

    if(isset($$var2) && $$var != $$var2)
    {
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
        <span class='weui-form-preview__value'>$fromname</span>
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
        </a>";
}
$i++;
}
}

//导出已归还的申请
linkdb('wuziapply');
$check = mysql_query("select * from wuziapply where  returnname = '$name' ");
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
$fromname = $array["name"];
$state = $array["state"];
$campus = $array["campus"];
$returnname = $array["returnname"];
$department = $array["department"];

if($state == '已归还')
{
    if(!isset($$var2))
    {
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
        <span class='weui-form-preview__value'>$fromname</span>
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
        </a>";
    }

    if(isset($$var2) && $$var != $$var2)
    {
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
        <span class='weui-form-preview__value'>$fromname</span>
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
        </a>";
    }
$i++;
}
}

printFooter(0);
?>
</body>
</html>
