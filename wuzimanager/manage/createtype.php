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
if(isset($_POST['type']))
{
    $accesstoken =$_POST['accesstoken'];
    $userid=$_POST['userid'];
    $campus=$_POST['campus'];
    $type=$_POST['type'];
    
    linkdb('wuzi');
    if(isDataExist(wuzitype,'type',$type))
    {
    echo "<script>alert('该分类已存在，请重新输入');</script>";
    echo "<script language=\"javascript\">location.href = 'javascript:history.back()'</script>";
    exit;
    }
    
    //上传数据到数据库
    $url = "127.0.0.1";
    $user = "root";
    $password = "sna2008";
    $con = mysql_connect($url,$user,$password);
    mysql_query("set names 'utf8'");
    mysql_select_db("wuzi",$con);
    $sql = "insert into wuzitype (type,campus)  values('$type','$campus')";
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
        echo "<script>alert('未成功提交，请稍后再试');</script>";
        echo "<script language=\"javascript\">location.href = 'javascript:history.back()'</script>";
        exit;
    }else
    {
        echo "<script>alert('提交成功');</script>";
        echo "<script language=\"javascript\">location.href = 'changetype.php?campus=$campus&userid=$userid&accesstoken=$accesstoken'</script>";
        $record = '新建了一个分类（'.$type.'）';
        createRecord($userid,$record);//创建操作记录
        exit;
    }
}

//获取登陆信息
$userid=$_GET['userid'];
$accesstoken=$_GET['accesstoken'];
$campus=$_GET['campus'];
checkRegister($userid);//检查登陆
if($campus == 'main'){$xiaoqu = '校本部';}
if($campus == 'south'){$xiaoqu = '南校区';}
    
echo '<form action="createtype.php" method="POST">';//表单开始

echo "<input type='hidden' name='userid' value=$userid>
    <input type='hidden' name='accesstoken' value=$accesstoken>
    <input type='hidden' name='campus' value=$campus>";//表单隐藏信息

//显示表单
echo "
<div class='weui-cells__title'>新建分类（ $xiaoqu ）</div>
<div class='weui-cells weui-cells_form'>
    
<div class='weui-cell'>
    <div class='weui-cell__hd'><label class='weui-label'>分类名</label></div>
        <div class='weui-cell__bd'>
            <input class='weui-input' name='type' style='text-align:right' type='text'  placeholder='6字以内' maxlength='6'>
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
