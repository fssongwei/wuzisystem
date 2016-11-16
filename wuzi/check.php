<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<link rel="stylesheet" href="weui.css"/>
<link rel="stylesheet" href="example.css"/>
<link href="style.css" rel='stylesheet' type='text/css' />
<link href="style2.css" rel='stylesheet' type='text/css' />
<title>物资借用</title> 
<style type="text/css">
h1 {font-family:FangSong;}
</style>
</head>

<script language=javascript>
var flag = 0;
function check(){
if (flag == 0){
if(document.myform.borrowdate.value==""){
    alert('请填写借用日期');
 return false;
  }
  else if(document.myform.returndate.value==""){
    alert('请填写预计归还日期');
 return false;
  } else if(document.myform.checkname.value==""){
    alert('请填写审核人');
 return false;
} else if(document.myform.borrowdate.value > document.myform.returndate.value){
    alert('借用日期不得大于归还日期，请重新选择');
 return false;
}
}
}
</script>

<body bgcolor="#FBF9FE">
<?php
include('function.php');
session_start();
echo '<form name="myform" action="submit.php" method="POST" onSubmit="return check()" >';//表单开始

if(isset($_POST['userid'])){$userid=$_POST['userid'];echo "<input type='hidden' name='userid' value=$userid>";}else{exit;}
if(isset($_POST['accesstoken'])){$accesstoken=$_POST['accesstoken'];echo "<input type='hidden' name='accesstoken' value=$accesstoken>";}else{exit;}
if(isset($_POST['campus'])){$campus=$_POST['campus'];echo "<input type='hidden' name='campus' value=$campus>";}else{exit;}

if($campus == 'main'){$xiaoqu = '校本部';echo "<input type='hidden' name='xiaoqu' value='校本部'>";}
if($campus == 'south'){$xiaoqu = '南校区';echo "<input type='hidden' name='xiaoqu' value='南校区'>";}

if(!checkdataexist('qyhlogin','sna2008','userid',$userid)){//登陆不成功则输出
    echo "<script>alert('身份信息不存在，请完善个人身份信息！');location.replace('register.php?userid=$userid');</script>";
    exit;
}
    
    //判断是否存在超过借出数量的物资申请
    $test = 0;
    for ($i = 1;$i < 200;$i++)
    {
        if (isset($_POST["$i"]) && $_POST["$i"] != '')
        {
            $number = $_POST["$i"];
            $item = getuniquecolumn('wuzi','sna2008','id',$i,'item');
            $quantity = getuniquecolumn('wuzi','sna2008','id',$i,'quantity');
            
            while($array = mysql_fetch_array($check)){$item = $array["item"];$quantity = $array["quantity"];}
            
            if($quantity < $number)
            {
                echo "<script>alert('$item 数量不足，请重新选择');</script>";
                echo "<script language=\"javascript\">location.href = 'javascript:history.back()'</script>";
                exit;
            }
            $test ++;
        }
    }
    
    if($test == 0){ echo "<script>alert('你还没有选择任何物资~');</script>";
        echo "<script language=\"javascript\">location.href = 'javascript:history.back()'</script>";
        exit;}

//---------------------------------------显示申请者信息--------------------------------
$name = getuniquecolumn('qyhlogin','sna2008','userid',$userid,'name');
echo "<input type='hidden' name='name' value=$name>";
$identity = getuniquecolumn('qyhlogin','sna2008','userid',$userid,'identity');
echo "<input type='hidden' name='identity' value=$identity>";
$department = getuniquecolumn('qyhlogin','sna2008','userid',$userid,'department');
echo "<input type='hidden' name='department' value=$department>";

echo "<br><h2 style='font-weight:normal' align='center'>物资借用申请表</h2>
<div class='weui_cells_title'>申请者信息</div><div class='weui_cells'>
<div class='weui_cell'><div class='weui_cell_bd weui_cell_primary'>
<p>申请人</p></div><div class='weui_cell_ft'>$name</div></div>
<div class='weui_cell'><div class='weui_cell_bd weui_cell_primary'>
<p>借用部门</p></div><div class='weui_cell_ft'>$department</div></div>
<div class='weui_cell'><div class='weui_cell_bd weui_cell_primary'>
<p>校区</p></div><div class='weui_cell_ft'>$xiaoqu</div></div>
</div>";


//---------------------------------------显示物资清单信息--------------------------------
    echo '<div class="weui_cells_title">物资信息</div><div class="weui_cells">';
   
    for ($a = 1;$a < 200;$a++)
    {
        if(isset($_POST["$a"]) && $_POST["$a"] != '')
        {
            $number = $_POST["$a"];
            $item = getuniquecolumn('wuzi','sna2008','id',$a,'item');
            $quantity = getuniquecolumn('wuzi','sna2008','id',$a,'quantity');
            echo "<div class='weui_cell'>
            <div class='weui_cell_bd weui_cell_primary'>
            <p>$item</p>
            </div>
            <div class='weui_cell_ft'>$number</div>
            </div>";
            echo "<input type='hidden' name='$a' value='$number'>";
        }
    }
    echo '</div>';



//---------------------------------日期输入框---------------------------------------
echo '
<div class="weui_cells_title">借用及归还日期</div>
<div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_hd"><label for="" class="weui_label">借用日期</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="date" style="text-align:right" name="borrowdate" value="">
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label for="" class="weui_label">归还日期</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="date" style="text-align:right"  name="returndate" value="">
            </div>
        </div>
    </div>';

//---------------------------------输出对点干事名单---------------------------------------
echo '<div class="weui_cells_title">审核人员（对点秘书处干事或部长）</div>';

logindatabase('qyhlogin','sna2008');
$check = mysql_query("select * from qyhlogin where department = '秘书处' ");

echo '<div class="weui_cells">
<div class="weui_cell weui_cell_select weui_select_after">
<div class="weui_cell_hd"><label for="" class="weui_label">审核人</label></div>
<div class="weui_cell_bd weui_cell_primary"><select class="weui_select" name="checkname" id = "sect">';
echo "<option value = ''></option>";

while($checknamearray = mysql_fetch_array($check))
{$checkname = $checknamearray["name"];
$checknameid = $checknamearray["userid"];
echo "<option value='$checknameid'>$checkname</option>";}

echo "</select></div></div></div>";
    
    echo '
    <div class="weui-cells__title">备注</div>
    <div class="weui-cells weui-cells_form">
    <div class="weui-cell">
    <div class="weui-cell__bd">
    <textarea name="remark" class="weui-textarea" placeholder="(选填)" rows="3"></textarea>
    </div>
    </div>
    </div>';

    echo '</br><div class="weui-btn-area">
    <input class="weui_btn weui_btn_primary" type="submit" name="submit" onclick="flag = 0" value="提交" />
    </div></form>';



//--------------------------------------------footer-----------------------------------------
echo '<br><div class="weui-footer"><p class="weui-footer__links">
<a href="http://tw.jnu.edu.cn" class="weui-footer__link">共青团暨南大学委员会</a></p>
<p class="weui-footer__text">Copyright © 2015-2016 jnusna</p></div><br>';

?>
</body>
</html>
