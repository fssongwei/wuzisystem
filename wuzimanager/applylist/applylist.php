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
include('function.php');
    
    if(isset($_GET['department'])){$department = $_GET['department'];}
    if(isset($_GET['campus'])){$campus = $_GET['campus'];}
    if(isset($_GET['userid'])){$userid = $_GET['userid'];}
    if(isset($_GET['accesstoken'])){$accesstoken = $_GET['accesstoken'];}


    echo "
    <div class='weui-cells'>
    <div class='weui-cell weui-cell_select weui-cell_select-after'>
    <div class='weui-cell__hd'>
    <label for='' class='weui-label'>选择部门</label>
    </div>
    <div class='weui-cell__bd'>
    <select class='weui-select' name='select' onchange='window.location=this.value;'>";
    
    linkdb('wuzi');
    $departmentarray = fetchArray('department','','','department');
    echo "<option value=''>$department</option>";
    
    for($i = 0;$i < count($departmentarray);$i++){
        if($departmentarray[$i] != $department){
            echo "<option value='applylist.php?userid=$userid&accesstoken=$accesstoken&campus=$campus&department=$departmentarray[$i]'>$departmentarray[$i]</option>";
        }
    }

    echo "
    </select>
    </div>
    </div>
    </div>";

    if($campus == 'main'){$xiaoqu = '校本部';}
    if($campus == 'south'){$xiaoqu = '南校区';}


//导出审核中的申请
linkdb('wuziapply');
$check = mysql_query("select * from wuziapply where department = '$department' and campus = '$xiaoqu' ");
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
        <span class='weui-form-preview__value'>$name</span>
        </div>
        <div class='weui-form-preview__item'>
        <label class='weui-form-preview__label'>借用部门（校区）</label>
        <span class='weui-form-preview__value'>$department ($xiaoqu)</span>
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
        <span class='weui-form-preview__value'>$name</span>
        </div>
        <div class='weui-form-preview__item'>
        <label class='weui-form-preview__label'>借用部门（校区）</label>
        <span class='weui-form-preview__value'>$department ($xiaoqu)</span>
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
$check = mysql_query("select * from wuziapply where department = '$department' and campus = '$xiaoqu' ");
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
$checkname = $array["checkname"];

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
        <span class='weui-form-preview__value'>$name</span>
        </div>
        <div class='weui-form-preview__item'>
        <label class='weui-form-preview__label'>借用部门（校区）</label>
        <span class='weui-form-preview__value'>$department ($xiaoqu)</span>
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
        <span class='weui-form-preview__value'>$name</span>
        </div>
        <div class='weui-form-preview__item'>
        <label class='weui-form-preview__label'>借用部门（校区）</label>
        <span class='weui-form-preview__value'>$department ($xiaoqu)</span>
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
$check = mysql_query("select * from wuziapply where  department = '$department' and campus = '$xiaoqu' ");
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
$checkname = $array["checkname"];


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
        <span class='weui-form-preview__value'>$name</span>
        </div>
        <div class='weui-form-preview__item'>
        <label class='weui-form-preview__label'>借用部门（校区）</label>
        <span class='weui-form-preview__value'>$department ($xiaoqu)</span>
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
        <span class='weui-form-preview__value'>$name</span>
        </div>
        <div class='weui-form-preview__item'>
        <label class='weui-form-preview__label'>借用部门（校区）</label>
        <span class='weui-form-preview__value'>$department ($xiaoqu)</span>
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
$check = mysql_query("select * from wuziapply where  department = '$department' and campus = '$xiaoqu' ");
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
$borrowname = $array["borrowname"];

if($state == '已借出')
{
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
        <span class='weui-form-preview__value'>$department ($xiaoqu)</span>
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
        <span class='weui-form-preview__value'>$name</span>
        </div>
        <div class='weui-form-preview__item'>
        <label class='weui-form-preview__label'>借用部门（校区）</label>
        <span class='weui-form-preview__value'>$department ($xiaoqu)</span>
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
$check = mysql_query("select * from wuziapply where  department = '$department' and campus = '$xiaoqu' ");
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
$returnname = $array["returnname"];

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
        <span class='weui-form-preview__value'>$name</span>
        </div>
        <div class='weui-form-preview__item'>
        <label class='weui-form-preview__label'>借用部门（校区）</label>
        <span class='weui-form-preview__value'>$department ($xiaoqu)</span>
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
    <span class='weui-form-preview__value'>$name</span>
    </div>
    <div class='weui-form-preview__item'>
    <label class='weui-form-preview__label'>借用部门（校区）</label>
    <span class='weui-form-preview__value'>$department ($xiaoqu)</span>
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
