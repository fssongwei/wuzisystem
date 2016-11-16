
<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<link href="style.css" rel='stylesheet' type='text/css' />
<link href="style2.css" rel='stylesheet' type='text/css' />
<title>物资借用申请表</title> 
<style type="text/css">
h1 {font-family:FangSong;}
</style>
</head>



<body bgcolor="#FBF9FE">

<?php
session_start();


//获取表单数据
if(isset($_GET['accesstoken'])){$accesstoken =$_GET['accesstoken'];}
if(isset($_GET['userid'])){$userid=$_GET['userid'];}
if(isset($_GET['applyid'])){$applyid=$_GET['applyid'];}


$url = "127.0.0.1";
$user = "root";
$password = "sna2008";
$con = mysql_connect($url,$user,$password);
mysql_query("set names 'utf8'");
mysql_select_db("wuziapply",$con);
$check = mysql_query("select * from wuziapply where applyid = '$applyid' ");
while($array = mysql_fetch_array($check))
{
$borrowdate = $array["borrowdate"];
$returndate = $array["returndate"];
$department = $array["department"];
$name = $array["name"];
$xiaoqu = $array["campus"];
$checkname = $array["checkname"];
$borrowname = $array["borrowname"];
$returnname = $array["returnname"];
$state = $array["state"];
$remark = $array["remark"];
$opinion= $array["opinion"];
}

if($state == ''){$state = '审核中';}


echo "

<div class='weui_cells'>
<div class='weui_cell'>
            <div class='weui_cell_bd weui_cell_primary'>
                <p>状态</p>
            </div>
            <div class='weui_cell_ft'>$state</div>
        </div>
    </div>
";

echo '<div class="weui_cells_title">申请者信息</div>';
echo "<div class='weui_cells'>
        <div class='weui_cell'>
            <div class='weui_cell_bd weui_cell_primary'>
                <p>申请人</p>
            </div>
            <div class='weui_cell_ft'>$name</div>
        </div>
<div class='weui_cell'>
            <div class='weui_cell_bd weui_cell_primary'>
                <p>借用部门</p>
            </div>
            <div class='weui_cell_ft'>$department</div>
        </div>
<div class='weui_cell'>
            <div class='weui_cell_bd weui_cell_primary'>
                <p>校区</p>
            </div>
            <div class='weui_cell_ft'>$xiaoqu</div>
        </div>
    </div>";




echo '<div class="weui_cells_title">物资信息</div><div class="weui_cells">';

$url = "127.0.0.1";
$user = "root";
$password = "sna2008";
$con = mysql_connect($url,$user,$password);
mysql_query("set names 'utf8'");
mysql_select_db("wuziapply",$con);
$checkwuzi = mysql_query("select * from wuziapply where applyid = '$applyid' ");
while($wuziarray = mysql_fetch_array($checkwuzi))
{$itemid = $wuziarray["itemid"];$quantity = $wuziarray["quantity"];


$url = "127.0.0.1";
$user = "root";
$password = "sna2008";
$con = mysql_connect($url,$user,$password);
mysql_query("set names 'utf8'");
mysql_select_db("wuzi",$con);
$checkitem = mysql_query("select * from wuzi where id = '$itemid' ");
while($itemarray = mysql_fetch_array($checkitem))
{$item = $itemarray["item"];$leftover = $itemarray["quantity"];}
if($leftover == 9999){$q = "若干";}else{$q = $leftover;}

echo "<div class='weui_cell'>
            <div class='weui_cell_bd weui_cell_primary'>
                <p>$item</p>
            </div>
            <div class='weui_cell_ft'>$quantity （剩余$q ）</div>
        </div>";

}
echo '</div>';




echo '<div class="weui_cells_title">借用及归还日期</div>';
echo "<div class='weui_cells'>
        <div class='weui_cell'>
            <div class='weui_cell_bd weui_cell_primary'>
                <p>借用日期</p>
            </div>
            <div class='weui_cell_ft'>$borrowdate</div>
        </div>
<div class='weui_cell'>
            <div class='weui_cell_bd weui_cell_primary'>
                <p>归还日期</p>
            </div>
            <div class='weui_cell_ft'>$returndate</div>
        </div>
</div>
<div class='weui_cells_title'>审核人员（对点秘书处干事或部长）</div>
<div class='weui_cells'>
<div class='weui_cell'>
            <div class='weui_cell_bd weui_cell_primary'>
                <p>审批人</p>
            </div>
            <div class='weui_cell_ft'>$checkname</div>
        </div>";


if($borrowname != ''){echo "
<div class='weui_cell'>
            <div class='weui_cell_bd weui_cell_primary'>
                <p>借出确认</p>
            </div>
            <div class='weui_cell_ft'>$borrowname</div>
        </div>
";}

if($returnname != ''){echo "
<div class='weui_cell'>
            <div class='weui_cell_bd weui_cell_primary'>
                <p>归还确认</p>
            </div>
            <div class='weui_cell_ft'>$returnname</div>
        </div>
";}
    
  
echo  "</div>";

    echo "<div class='weui_cells_title'>备注</div>
    <div class='weui-panel weui-panel_access'>
    <div class='weui-panel__bd'>
    <div class='weui-media-box weui-media-box_text'>
    <p class='weui-media-box__desc'>$remark</p>
    </div>
    </div>
    </div>";


if(!empty($opinion)){
    echo "<div class='weui_cells_title'>审批意见</div>
    <div class='weui-panel weui-panel_access'>
    <div class='weui-panel__bd'>
    <div class='weui-media-box weui-media-box_text'>
    <p class='weui-media-box__desc'>$opinion</p>
    </div>
    </div>
    </div>";}
    
if($state != '审核中' && $state != '审核不通过' && $state!='已归还'){


echo "<br><div class='weui-btn-area'><a href='qzcode.php?applyid=$applyid' class='weui_btn weui_btn_primary'>查看二维码(凭此二维码借用和归还物资)</a></div></br>";

}

echo '<br><div class="weui-footer">
            <p class="weui-footer__links">
                <a href="http://tw.jnu.edu.cn" class="weui-footer__link">共青团暨南大学委员会</a>
            </p>
            <p class="weui-footer__text">Copyright © 2015-2016 jnusna</p>
        </div><br>';

?>

</body>
</html>
