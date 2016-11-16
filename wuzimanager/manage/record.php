<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<link rel="stylesheet" href="css/weui.css"/>
<link rel="stylesheet" href="css/example.css"/>

<title>物资管理</title>
</head>

<body bgcolor="#FBF9FE">
<?php
include('function.php');
    
echo "<div class='weui-cells__title'>查看修改记录</div>";

    linkdb('wuzi');
    $check = mysql_query("select * from record ");
    while($array = mysql_fetch_array($check))
    {
        $time = $array["time"];
        $name = $array["name"];
        $record = $array["record"];

        echo "<div class='weui-form-preview'>
        <div class='weui-form-preview__bd'>
        <div class='weui-form-preview__item'>
        <label class='weui-form-preview__label'>操作人</label>
        <span class='weui-form-preview__value'>$name</span>
        </div>
        <div class='weui-form-preview__item'>
        <label class='weui-form-preview__label'>事件</label>
        <span class='weui-form-preview__value'>$record</span>
        </div>
        <div class='weui-form-preview__item'>
        <label class='weui-form-preview__label'>时间</label>
        <span class='weui-form-preview__value'>$time</span>
        </div>
        </div>
        </div><br>";
    }

printFooter(0);//输出footer
?>
</body>
</html>
