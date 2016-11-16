<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<link rel="stylesheet" href="weui.css"/>
<link rel="stylesheet" href="example.css"/>
<link href="style.css" rel='stylesheet' type='text/css' />
<link href="style2.css" rel='stylesheet' type='text/css' />
<title>提交成功</title> 
<style type="text/css">
h1 {font-family:FangSong;}
</style>
</head>
<body bgcolor="#FBF9FE">

<?php
include('function.php');
session_start();

$accesstoken = $_POST['accesstoken'];
$userid = $_POST['userid'];

$borrowdate = $_POST['borrowdate'];
$returndate = $_POST['returndate'];
$checknameid = $_POST['checkname'];

$name = $_POST['name'];
$department = $_POST['department'];
$xiaoqu = $_POST['xiaoqu'];
    if(isset($_POST['remark'])){
        $remark = $_POST['remark'];}
    if(empty($remark)){$remark = '无';}

    
//为每个申请生成一个applyid
$str = uniqid(mt_rand(),1);
$applyid = sha1($str);

//审核人姓名
$checkname = getuniquecolumn('qyhlogin','sna2008','userid',$checknameid,'name');

//判断是否存在超过借出数量的物资申请
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
    }
}


echo '<div class="weui_cells_title">提交成功，请等待秘书处干事或部长级审核确认</div>';
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

//上传数据到数据库
        $url = "127.0.0.1";
        $user = "root";
        $password = "sna2008";
        $con = mysql_connect($url,$user,$password);
        mysql_query("set names 'utf8'");
        mysql_select_db("wuziapply",$con);
        $sql = "insert into wuziapply (applyid,itemid,quantity,borrowdate,returndate,name,department,campus,checkname,remark)  values('$applyid','$a','$number','$borrowdate','$returndate','$name','$department','$xiaoqu','$checkname','$remark')";
        if (!mysql_query($sql,$con)){die('Error: ' . mysql_error());
            echo "<script>alert('未成功提交，请稍后再试');</script>";
            echo "<script language=\"javascript\">location.href = 'javascript:history.back()'</script>";
            exit;}
}
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
                <p>审核人员</p>
            </div>
            <div class='weui_cell_ft'>$checkname</div>
        </div>
    </div>";

        echo "<div class='weui_cells_title'>备注</div>
    <div class='weui-panel weui-panel_access'>
    <div class='weui-panel__bd'>
<div class='weui-media-box weui-media-box_text'>
        <p class='weui-media-box__desc'>$remark</p>
    </div>
    </div>
    </div>";



//发送信息
$Url="https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=$accesstoken";
$data="{
   \"touser\": \"$checknameid\",
   \"msgtype\": \"news\",
   \"agentid\": 86,
   \"news\": {
       \"articles\":[
           {
               \"title\": \"你收到一份新的物资申请\",
               \"description\": \"$department $name 向你提出物资申请，点击查看更多信息\",
               \"url\": \"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe1b78fe749897a87&redirect_uri=tw.jnu.edu.cn/qyh/wuzimanager/index.php&response_type=code&scope=snsapi_base&state=$applyid&connect_redirect=1#wechat_redirect\",
           },
       ]
   }
}";
$res = curlPost($Url,$data);

echo '<br><br><div class="weui-footer">
            <p class="weui-footer__links">
                <a href="http://tw.jnu.edu.cn" class="weui-footer__link">共青团暨南大学委员会</a>
            </p>
            <p class="weui-footer__text">Copyright © 2015-2016 jnusna</p>
        </div><br>';


?>

</body>
</html>
