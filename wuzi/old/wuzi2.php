
<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
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
session_start();

function curlPost($url,$data=""){   
 $ch = curl_init();
    $opt = array(
			CURLOPT_URL     => $url,            
            CURLOPT_HEADER  => 0,
			CURLOPT_POST    => 1,
            CURLOPT_POSTFIELDS      => $data,
            CURLOPT_RETURNTRANSFER  => 1,
            CURLOPT_TIMEOUT         => 20
    );
   $ssl = substr($url,0,8) == "https://" ? TRUE : FALSE;
    if ($ssl){
        $opt[CURLOPT_SSL_VERIFYHOST] = 2;
        $opt[CURLOPT_SSL_VERIFYPEER] = FALSE;
    }

    curl_setopt_array($ch,$opt);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

$conn = mysql_connect("localhost","root","sna2008");
if (!$conn){
    die("fail to connect the datebase：" . mysql_error());
}
mysql_select_db("qyhlogin", $conn);
mysql_query("set character set 'utf8'");//读库 
mysql_query("set names 'utf8'");//写库
if(isset($_GET['userid'])){$userid=$_GET['userid'];}
if(isset($_SESSION['userid'])){$userid=$_SESSION['userid'];}
if(isset($userid)){$_SESSION['userid'] = $userid;}

if(isset($_GET['accesstoken'])){$accesstoken=$_GET['accesstoken'];}
if(isset($_SESSION['accesstoken'])){$accesstoken =$_SESSION['accesstoken'];}
if(isset($accesstoken)){$_SESSION['accesstoken'] = $accesstoken;}

$campus='main';


//检测用户名是否正确
$check_query = mysql_query("select * from qyhlogin where userid='$userid' ");

if($result = mysql_fetch_array($check_query)){
//获得账号对应的姓名
$checkname = mysql_query("select name from qyhlogin where userid='$userid' ");
$namearray = mysql_fetch_array($checkname);
$_SESSION['name'] = $namearray[0];
$name=$namearray[0];
//获得账号对应的身份
$checkidentity = mysql_query("select identity from qyhlogin where userid='$userid' ");
$identityarray = mysql_fetch_array($checkidentity);
$_SESSION['identity'] = $identityarray[0];
$identity = $identityarray[0];
//获得账号对应的部门
$checkdepartment = mysql_query("select department from qyhlogin where userid='$userid' ");
$departmentarray = mysql_fetch_array($checkdepartment);
$_SESSION['department'] = $departmentarray[0];
$department=$departmentarray[0];

//连接物资数据库
$conn = mysql_connect("localhost","root","sna2008");
if (!$conn){
    die("fail to connect the datebase：" . mysql_error());
}
mysql_select_db("wuzi", $conn);
mysql_query("set character set 'utf8'");//读库 
mysql_query("set names 'utf8'");//写库


//显示物资清单

$checkitem = mysql_query("select * from wuzi where campus = '$campus' ");

echo "<br><h2 style='font-weight:normal' align='center'>物资借用申请表</h2>";

if($campus == 'main'){$xiaoqu = '校本部';$_SESSION['xiaoqu'] = $xiaoqu;}
if($campus == 'south'){$xiaoqu = '南校区';$_SESSION['xiaoqu'] = $xiaoqu;}


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

echo '<form name="myform" action="submit.php" method="POST" onSubmit="return check()" >';
echo '<div class="weui_cells_title">选择物资</div><div class="weui_cells weui_cells_form">';



while($itemarray = mysql_fetch_array($checkitem))

{
$item = $itemarray["item"];
$id = $itemarray["id"];
$quantity = $itemarray["quantity"];




echo "
<div class='weui_cell'>
            <div class='weui_cell_hd'><label class='weui_label'>$item</label></div>
            <div class='weui_cell_bd weui_cell_primary'>
";

if($quantity == 9999){echo "<input class='weui_input' type='number' pattern='[0-9]*' style='text-align:right' placeholder='剩余若干' name = '$id'>";}
if($quantity != 9999){echo "<input class='weui_input' type='number' pattern='[0-9]*' style='text-align:right' placeholder='剩余：$quantity' name = '$id'>";}

echo "</div></div>";
}
echo "</div>";

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

//输出对点干事名单
echo '<div class="weui_cells_title">审核人员（对点秘书处干事或部长）</div>';

$conn = mysql_connect("localhost","root","sna2008");
if (!$conn){
    die("fail to connect the datebase：" . mysql_error());
}
mysql_select_db("qyhlogin", $conn);
mysql_query("set character set 'utf8'");//读库 
mysql_query("set names 'utf8'");//写库
$check = mysql_query("select * from qyhlogin where department = '秘书处' ");



echo '<div class="weui_cells">
        <div class="weui_cell weui_cell_select weui_select_after">
            <div class="weui_cell_hd">
                <label for="" class="weui_label">审核人</label>
            </div>
            <div class="weui_cell_bd weui_cell_primary">
                <select class="weui_select" name="checkname" id = "sect">';
echo "<option value = ''></option>";

while($checknamearray = mysql_fetch_array($check))

{
$checkname = $checknamearray["name"];
$checknameid = $checknamearray["userid"];

echo "<option value='$checknameid'>$checkname</option>";
}


echo "
                </select>
            </div>
        </div>
    </div>";

echo '</br><input class="weui_btn weui_btn_primary" type="submit" name="submit" onclick="flag = 0" value="提交" /></br></form>';








/*
$Url="https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=$accesstoken";
$msg="发送信息<br><a href='www.baidu.com'>点击阅读</a>";
$data="{\"touser\":\"$userid\",\"msgtype\":\"text\",\"agentid\":85,\"text\":{\"content\":\"$msg\"},\"safe\":0}";
$res = curlPost($Url,$data);
$errmsg=json_decode($res)->errmsg;
if($errmsg==="ok"){
	echo "发送成功！";
}else{
	echo "发送失败，".$errmsg;
}

*/

}else{
//登录不成功输出
echo "<script>alert('身份信息不存在，请联系管理员！');
document.addEventListener('WeixinJSBridgeReady', function(){ WeixinJSBridge.call('closeWindow'); }, false);
</script>";}

echo '<br><div class="weui-footer">
            <p class="weui-footer__links">
                <a href="http://tw.jnu.edu.cn" class="weui-footer__link">共青团暨南大学委员会</a>
            </p>
            <p class="weui-footer__text">Copyright © 2015-2016 jnusna</p>
        </div><br>';

?>

</body>
</html>
