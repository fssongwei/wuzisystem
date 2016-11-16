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
if(isset($_POST['item']))
{
    $accesstoken =$_POST['accesstoken'];
    $userid=$_POST['userid'];
    $campus=$_POST['campus'];
    $item=$_POST['item'];
    $quantity=$_POST['quantity'];
    $location=$_POST['location'];
    $type=$_POST['type'];
    if(empty($quantity)){$quantity=9999;}
    if(empty($location)){$location='未知';}
    
    for($i=1;;$i++)
    {
        linkdb('wuzi');
        if(!isDataExist('wuzi','id',$i))
        {
            //上传数据到数据库
            $url = "127.0.0.1";
            $user = "root";
            $password = "sna2008";
            $con = mysql_connect($url,$user,$password);
            mysql_query("set names 'utf8'");
            mysql_select_db("wuzi",$con);
            $sql = "insert into wuzi (item,location,id,campus,quantity,type)  values('$item','$location','$i','$campus','$quantity','$type')";
            if (!mysql_query($sql,$con))
            {
                die('Error: ' . mysql_error());
                echo "<script>alert('未能成功创建物资，请稍后再试');</script>";
                echo "<script language=\"javascript\">location.href = 'javascript:history.back()'</script>";
                break;
                exit;
            }else
            {
                echo "<script>alert('创建物资成功');</script>";
                echo "<script language=\"javascript\">location.href = 'changelist.php?campus=$campus&userid=$userid&accesstoken=$accesstoken'</script>";
                $record = '新增了一项物资（'.$item.'）';
                createRecord($userid,$record);//创建操作记录
                break;
                exit;
            }
        }
    }
}

//获取登陆信息
$userid=$_GET['userid'];
$accesstoken=$_GET['accesstoken'];
$campus=$_GET['campus'];
checkRegister($userid);//检查登陆
if($campus == 'main'){$xiaoqu = '校本部';}
if($campus == 'south'){$xiaoqu = '南校区';}

echo '<form action="additem.php" method="POST" >';//表单开始

echo "<input type='hidden' name='userid' value=$userid>
    <input type='hidden' name='accesstoken' value=$accesstoken>
    <input type='hidden' name='campus' value=$campus>";//表单隐藏信息

//显示表单
echo "
<div class='weui-cells__title'>新增物资（ $xiaoqu ）</div>
<div class='weui-cells weui-cells_form'>
    
<div class='weui-cell'>
    <div class='weui-cell__hd'><label class='weui-label'>物品名称</label></div>
        <div class='weui-cell__bd'>
            <input class='weui-input' name='item' style='text-align:right' type='text'  placeholder='5字以内' maxlength='5'>
        </div>
</div>
    
<div class='weui-cell'>
    <div class='weui-cell__hd'><label class='weui-label'>数量</label></div>
        <div class='weui-cell__bd'>
        <input class='weui-input' name='quantity' style='text-align:right' type='number' pattern='[0-9]*' placeholder='如果为若干则此项留空'>
        </div>
</div>
    
<div class='weui-cell'>
    <div class='weui-cell__hd'><label class='weui-label'>存放位置</label></div>
        <div class='weui-cell__bd'>
        <input class='weui-input' name='location' style='text-align:right' type='text'  placeholder='' maxlength='5'>
        </div>
</div>
    
<div class='weui-cell weui-cell_select weui-cell_select-after'>
    <div class='weui-cell__hd'><label for='' class='weui-label'>类别</label></div>
        <div class='weui-cell__bd'>
        <select class='weui-select' name='type' style='text-align:right'>";
    
        linkdb('wuzi');
        $type = fetchArray('wuzitype','campus',$campus,'type');
        for($i=0;$i<count($type);$i++)
        {
            echo "<option value='$type[$i]' style='text-align:right'>$type[$i]</option>";
        }


echo "
        </select>
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
