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
    
//获取登陆信息
$userid=$_GET['userid'];
$accesstoken=$_GET['accesstoken'];
$campus=$_GET['campus'];
checkRegister($userid);//检查登陆
if($campus == 'main'){$xiaoqu = '校本部';}
if($campus == 'south'){$xiaoqu = '南校区';}

//显示表单
echo "<div class='weui-cells__title'>新建、修改或删除分类 ( $xiaoqu )</div>";
echo "<div class='weui-cells'>";
    
    linkdb('wuzi');
    $type = fetchArray('wuzitype','campus',$campus,'type');
    for($i=0;$i<count($type);$i++)
    {
        $temp = $type[$i];
        echo "
        <a class='weui-cell weui-cell_access' href='updatetype.php?userid=$userid&accesstoken=$accesstoken&campus=$campus&type=$temp'>
        <div class='weui-cell__bd'><p>$type[$i]</p></div>
        <div class='weui-cell__ft'></div>
        </a>";
    }
echo  "</div>";

//输出按钮
echo "
<div class='weui-btn-area'>
<a href='createtype.php?userid=$userid&accesstoken=$accesstoken&campus=$campus' class='weui-btn weui-btn_primary'>新建分类</a>
</div>";

printFooter(1);
?>

</body>
</html>

