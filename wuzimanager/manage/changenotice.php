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

//表单数据处理
if(isset($_POST['notice']))
{
    $accesstoken =$_POST['accesstoken'];
    $userid=$_POST['userid'];
    $campus=$_POST['campus'];
    $notice=$_POST['notice'];
    
    //上传数据到数据库
    linkdb('wuzi');
    mysql_query(" UPDATE notice SET notice = '$notice' WHERE campus='$campus'  ");

    echo "<script>alert('修改成功');</script>";
    echo "<script language=\"javascript\">location.href = 'changelist.php?campus=$campus&userid=$userid&accesstoken=$accesstoken'</script>";

    $record = '修改了注意事项';
    createRecord($userid,$record);//创建操作记录
    exit;
}

//获取登陆信息
$userid=$_GET['userid'];
$accesstoken=$_GET['accesstoken'];
$campus=$_GET['campus'];
checkRegister($userid);//检查登陆
if($campus == 'main'){$xiaoqu = '校本部';}
if($campus == 'south'){$xiaoqu = '南校区';}
    
echo '<form action="changenotice.php" method="POST">';//表单开始

echo "<input type='hidden' name='userid' value=$userid>
    <input type='hidden' name='accesstoken' value=$accesstoken>
    <input type='hidden' name='campus' value=$campus>";//表单隐藏信息

//显示表单
linkdb('wuzi');
$notice = fetchData('notice','campus',$campus,'notice');
    
echo "
<div class='weui-cells__title'>编辑注意事项（ $xiaoqu ）</div>
<div class='weui-cells weui-cells_form'>
    <div class='weui-cell'>
        <div class='weui-cell__bd'>
            <textarea class='weui-textarea' rows='5' name='notice'>$notice</textarea>
        </div>
    </div>
</div>";
    
//输出按钮
echo "
<div class='weui-btn-area'>
<input class='weui-btn weui-btn_primary' type='submit' name='submit' value='确定' />
</div></form>";
    
printFooter(1);//输出footer
?>
</body>
</html>
