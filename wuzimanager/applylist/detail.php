<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<link rel="stylesheet" href="css/weui.css"/>
<link rel="stylesheet" href="css/example.css"/>

<title>物资借用申请表</title>
</head>

<body bgcolor="#FBF9FE">

<?php
include('function.php');
session_start();

//获取表单数据
$accesstoken =$_GET['accesstoken'];
$userid=$_GET['userid'];
$applyid=$_GET['applyid'];

linkdb('qyhlogin');
$department =  fetchData('qyhlogin','userid',$userid,'department');

if($department != '秘书处')
{
	echo "<script>alert('非秘书处干事或部长无权查看！');</script>";
	echo "<script>
    document.addEventListener('WeixinJSBridgeReady', function(){ WeixinJSBridge.call('closeWindow'); }, false);
    </script>";
}


linkdb('wuziapply');
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
$opinion = $array["opinion"];
}

if($state == ''){$state = '审核中';}
echo "

<div class='weui-cells'>
<div class='weui-cell'>
            <div class='weui-cell__bd'>
                <p>状态</p>
            </div>
            <div class='weui-cell__ft'>$state</div>
        </div>
    </div>
";

echo '<div class="weui-cells__title">申请者信息</div>';
echo "<div class='weui-cells'>
        <div class='weui-cell'>
            <div class='weui-cell__bd'>
                <p>申请人</p>
            </div>
            <div class='weui-cell__ft'>$name</div>
        </div>
<div class='weui-cell'>
            <div class='weui-cell__bd'>
                <p>借用部门</p>
            </div>
            <div class='weui-cell__ft'>$department</div>
        </div>
<div class='weui-cell'>
            <div class='weui-cell__bd'>
                <p>校区</p>
            </div>
            <div class='weui-cell__ft'>$xiaoqu</div>
        </div>
    </div>";


if($state == '已借出'){
echo '<form name="myform" action="redirect.php" method="POST" >';
echo '<div class="weui-cells__title">归还前请核对物资数量</div><div class="weui-cells">';

}else {


echo '<div class="weui-cells__title">物资信息</div><div class="weui-cells">';}

linkdb('wuziapply');
$checkwuzi = mysql_query("select * from wuziapply where applyid = '$applyid' ");
while($wuziarray = mysql_fetch_array($checkwuzi))
{$itemid = $wuziarray["itemid"];$quantity = $wuziarray["quantity"];


linkdb('wuzi');
$checkitem = mysql_query("select * from wuzi where id = '$itemid' ");
while($itemarray = mysql_fetch_array($checkitem))
{$item = $itemarray["item"];$leftover = $itemarray["quantity"];$location=$itemarray["location"];}
if($leftover == 9999){$q = "若干";}else{$q = $leftover;}

echo "<div class='weui-cell'>
            <div class='weui-cell__bd'>
                <p>$item</p>
            </div>";
            if($state == '审核通过') { 
            	echo "
            <div class='weui-cell__ft'>$quantity （剩余$q &nbsp;&nbsp;所在柜：$location ）</div> "; }
            else if($state == '已借出'){
            	//echo "<input class='weui_input' type='number' style='text-align:right' name='$itemid' value='$quantity'>";
            	  echo "<input type='number' name='$itemid' value='$quantity' style='width:50px;font-size:20px;border-radius:0'>";
          }
else  { echo "
            <div class='weui-cell__ft'>$quantity （剩余$q ）</div> "; }
 echo " </div>";

}
echo '</div>';



echo '<div class="weui-cells__title">借用及归还日期</div>';
echo "<div class='weui-cells'>
        <div class='weui-cell'>
            <div class='weui-cell__bd'>
                <p>借用日期</p>
            </div>
            <div class='weui-cell__ft'>$borrowdate</div>
        </div>
<div class='weui-cell'>
            <div class='weui-cell__bd'>
                <p>归还日期</p>
            </div>
            <div class='weui-cell__ft'>$returndate</div>
        </div>
</div>
<div class='weui-cells__title'>审核人员（对点秘书处干事或部长）</div>
<div class='weui-cells'>
<div class='weui-cell'>
            <div class='weui-cell__bd'>
                <p>审批人</p>
            </div>
            <div class='weui-cell__ft'>$checkname</div>
        </div>";


if($borrowname != ''){echo "
<div class='weui-cell'>
            <div class='weui-cell__bd'>
                <p>借出确认</p>
            </div>
            <div class='weui-cell__ft'>$borrowname</div>
        </div>
";}

if($returnname != ''){echo "
<div class='weui-cell'>
            <div class='weui-cell__bd'>
                <p>归还确认</p>
            </div>
            <div class='weui-cell__ft'>$returnname</div>
        </div>
";}
  
echo  "</div>";

    echo "<div class='weui-cells__title'>备注</div>
    <div class='weui-panel weui-panel_access'>
    <div class='weui-panel__bd'>
    <div class='weui-media-box weui-media-box_text'>
    <p class='weui-media-box__desc'>$remark</p>
    </div>
    </div>
    </div>";


if(!empty($opinion)){
    echo "<div class='weui-cells__title'>审批意见</div>
    <div class='weui-panel weui-panel_access'>
    <div class='weui-panel__bd'>
    <div class='weui-media-box weui-media-box_text'>
    <p class='weui-media-box__desc'>$opinion</p>
    </div>
    </div>
    </div>";}


if($state == '审核中'){

echo "<br>
<div class='weui-btn-area'>
<a href='submit.php?userid=$userid&accesstoken=$accesstoken&applyid=$applyid&state=1' class='weui-btn weui-btn_primary'>通过申请</a>
<a href='opinion.php?userid=$userid&accesstoken=$accesstoken&applyid=$applyid&state=0' class='weui-btn weui-btn_warn'>拒绝申请</a></div></br>";
}

if($state == '审核通过'){
echo "<br>
<div class='weui-btn-area'>
<a href='submit.php?userid=$userid&accesstoken=$accesstoken&applyid=$applyid&state=2' class='weui-btn weui-btn_primary'>确认借出</a></div></br>";
}

if($state == '已借出'){



echo "<input type='hidden' name='userid' value='$userid'>";
echo "<input type='hidden' name='accesstoken' value='$accesstoken'>";
echo "<input type='hidden' name='applyid' value='$applyid'>";

echo '
<br>
<div class="weui-btn-area">
<input class="weui-btn weui-btn_primary" type="submit" name="submit" onclick="flag = 0" value="确认归还" /></div></form><br>';
}


printFooter(0);

?>

</body>
</html>
