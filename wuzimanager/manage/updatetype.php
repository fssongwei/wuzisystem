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
//修改分类名称
if(isset($_POST['newtype']))
{
    $accesstoken =$_POST['accesstoken'];
    $userid=$_POST['userid'];
    $campus=$_POST['campus'];
    $type=$_POST['type'];
    $newtype=$_POST['newtype'];

    //上传数据到数据库
    linkdb('wuzi');
    mysql_query(" UPDATE wuzitype SET type = '$newtype' WHERE campus='$campus' and type='$type' ");
    mysql_query(" UPDATE wuzi SET type = '$newtype' WHERE campus='$campus' and type='$type' ");

    echo "<script>alert('修改成功');</script>";
    echo "<script language=\"javascript\">location.href = 'changetype.php?campus=$campus&userid=$userid&accesstoken=$accesstoken'</script>";
    
    $record = '修改了一个分类（'.$type.'修改为'.$newtype.'）';
    createRecord($userid,$record);//创建操作记录
    exit;
}

//删除分类
if(isset($_GET['state']) && $_GET['state'] == 'delete')
{
    $userid=$_GET['userid'];
    $accesstoken=$_GET['accesstoken'];
    $type=$_GET['type'];
    $campus=$_GET['campus'];

    linkdb('wuzi');
    mysql_query("delete from wuzitype where campus='$campus' and type='$type' ");
    mysql_query(" UPDATE wuzi SET type = '未分类' WHERE campus='$campus' and type='$type' ");
        
    echo "<script>alert('删除成功');</script>";
    echo "<script language=\"javascript\">location.href = 'changetype.php?campus=$campus&userid=$userid&accesstoken=$accesstoken'</script>";
    
    $record = '删除了一个分类（'.$type.'）';
    createRecord($userid,$record);//创建操作记录
    exit;
}
  

//获取登陆信息
$userid=$_GET['userid'];
$accesstoken=$_GET['accesstoken'];
$campus=$_GET['campus'];
$type=$_GET['type'];
checkRegister($userid);//检查登陆
if($campus == 'main'){$xiaoqu = '校本部';}
if($campus == 'south'){$xiaoqu = '南校区';}
    
echo "<form action='updatetype.php' method='POST'>";//表单开始

echo "<input type='hidden' name='userid' value=$userid>
    <input type='hidden' name='accesstoken' value=$accesstoken>
    <input type='hidden' name='type' value=$type>
    <input type='hidden' name='campus' value=$campus>";//表单隐藏信息

//显示表单
echo "
<div class='weui-cells__title'>编辑或删除分类（ $xiaoqu ）</div>
<div class='weui-cells weui-cells_form'>

<div class='weui-cell'>
    <div class='weui-cell__hd'><label class='weui-label'>分类名</label></div>
        <div class='weui-cell__bd'>
            <input class='weui-input' name='newtype' style='text-align:right' type='text'  value='$type' maxlength='6'>
        </div>
</div>
</div><br>";
    
echo "
<div class='weui-btn-area'>
<input class='weui-btn weui-btn_primary' type='submit' name='submit' onclick='flag = 0' value='保存修改' />
<br><a href='#' class='weui-btn weui-btn_warn' onclick='del()'>删除</a>
</div></form>";
    
echo "<script>
function del(){
if(confirm('确定要删除该分类吗？其下的所有项目将归为未分类')){
        window.location = 'updatetype.php?campus=$campus&userid=$userid&accesstoken=$accesstoken&type=$type&state=delete';
        return true;
    }else{return false;}
}
</script>";

printFooter(1);//输出footer
?>
</body>
</html>
