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
//修改物资名称
if(isset($_POST['id']))
{
    $accesstoken =$_POST['accesstoken'];
    $userid=$_POST['userid'];
    $campus=$_POST['campus'];
    $item =$_POST['item'];
    $id=$_POST['id'];
    $type=$_POST['type'];
    $quantity=$_POST['quantity'];
    $location=$_POST['location'];
    if(empty($quantity) || $quantity == '若干'){$quantity = '9999';}
    if(empty($location)){$location = '未知';}

    //上传数据到数据库
    linkdb('wuzi');
    mysql_query(" UPDATE wuzi SET item = '$item' WHERE id='$id' ");
    mysql_query(" UPDATE wuzi SET location = '$location' WHERE id='$id' ");
    mysql_query(" UPDATE wuzi SET quantity = '$quantity' WHERE id='$id' ");
    mysql_query(" UPDATE wuzi SET type = '$type' WHERE id='$id' ");

    echo "<script>alert('修改成功');</script>";
    echo "<script language=\"javascript\">location.href = 'changelist.php?campus=$campus&userid=$userid&accesstoken=$accesstoken'</script>";
        
    $record = '修改了一项物资（'.$item.'）';
    createRecord($userid,$record);//创建操作记录
    exit;
}
    
//删除分类
if(isset($_GET['state']) && $_GET['state'] == 'delete')
{
    $userid=$_GET['userid'];
    $accesstoken=$_GET['accesstoken'];
    $id=$_GET['id'];
    $campus=$_GET['campus'];
        
    linkdb('wuzi');
    mysql_query("delete from wuzi where campus='$campus' and id='$id' ");
        
    echo "<script>alert('删除成功');</script>";
    echo "<script language=\"javascript\">location.href = 'changelist.php?campus=$campus&userid=$userid&accesstoken=$accesstoken'</script>";
        
    $record = '删除了一项物资';
    createRecord($userid,$record);//创建操作记录
    exit;
}
    
//获取登陆信息
$userid=$_GET['userid'];
$accesstoken=$_GET['accesstoken'];
$campus=$_GET['campus'];
$name=$_GET['name'];
$id=$_GET['id'];
checkRegister($userid);//检查登陆
if($campus == 'main'){$xiaoqu = '校本部';}
if($campus == 'south'){$xiaoqu = '南校区';}
    
echo '<form name="myform" action="itemdetail.php" method="POST" onSubmit="return check()" >';//表单开始
    
echo "<input type='hidden' name='userid' value=$userid>
    <input type='hidden' name='accesstoken' value=$accesstoken>
    <input type='hidden' name='name' value=$name>
    <input type='hidden' name='id' value=$id>
    <input type='hidden' name='campus' value=$campus>";//表单隐藏信息

linkdb('wuzi');
$location = fetchData('wuzi','id',$id,'location');
$type = fetchData('wuzi','id',$id,'type');
$quantity = fetchData('wuzi','id',$id,'quantity');
if($quantity == '9999'){$quantity = '若干';}

//显示表单
echo "
<div class='weui-cells__title'>修改或删除物资（ $xiaoqu ）</div>
<div class='weui-cells weui-cells_form'>
<div class='weui-cell'>
    <div class='weui-cell__hd'><label class='weui-label'>物品名称</label></div>
        <div class='weui-cell__bd'>
            <input class='weui-input' name='item' style='text-align:right' type='text'  value='$name' maxlength='5'>
        </div>
</div>
<div class='weui-cell'>
    <div class='weui-cell__hd'><label class='weui-label'>数量(留空则为若干)</label></div>
        <div class='weui-cell__bd'>
            <input class='weui-input' name='quantity' style='text-align:right' type='text' pattern='[0-9]*' value='$quantity'>
        </div>
</div>
<div class='weui-cell'>
    <div class='weui-cell__hd'><label class='weui-label'>存放位置</label></div>
        <div class='weui-cell__bd'>
            <input class='weui-input' name='location' style='text-align:right' type='text'  value='$location' maxlength='5'>
    </div>
</div>";

echo '
<div class="weui-cell weui-cell_select weui-cell_select-after">
    <div class="weui-cell__hd">
        <label for="" class="weui-label">类别</label>
    </div>
    <div class="weui-cell__bd">
    <select class="weui-select" name="type" style="text-align:right">';
    
echo "<option value='$type' style='text-align:right'>$type</option>";
linkdb('wuzi');
$optiontype = fetchArray('wuzitype','campus',$campus,'type');
for($i=0;$i<count($optiontype);$i++)
{
    if($optiontype[$i] != $type)
    {
    echo "<option value='$optiontype[$i]' style='text-align:right'>$optiontype[$i]</option>";
    }
}
echo '</select></div></div></div><br>';
    
//输出按钮
echo "
<div class='weui-btn-area'>
<input class='weui-btn weui-btn_primary' type='submit' name='submit' value='保存修改' />
<br><a href='#' class='weui-btn weui-btn_warn' onclick='del()'>删除</a>
</div></form>";
    
echo "<script>
function del(){
    if(confirm('确定要删除该项物资吗？这将清除所有有关该物资的借用记录')){
        window.location = 'itemdetail.php?campus=$campus&userid=$userid&accesstoken=$accesstoken&id=$id&state=delete';
        return true;
    }else{return false;}
}
</script>";

printFooter(1);//输出footer
?>
</body>
</html>
