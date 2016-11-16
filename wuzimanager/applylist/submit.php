<?php
include('function.php');

//获取表单数据
$accesstoken =$_GET['accesstoken'];
$userid=$_GET['userid'];
$applyid=$_GET['applyid'];
$stat=$_GET['state'];

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
$state = $array["state"];
}

linkdb('qyhlogin');
$checkname = mysql_query("select * from qyhlogin where name = '$name' and department ='$department' ");
while($namearray = mysql_fetch_array($checkname))
{
$toid = $namearray["userid"];
}

$myname = fetchData('qyhlogin','userid',$userid,'name');



if($stat == 2)
{
if($state == "已借出") break 2;

linkdb('wuziapply');
$checkwuzi = mysql_query("select * from wuziapply where applyid = '$applyid' ");
while($wuziarray = mysql_fetch_array($checkwuzi))
{$itemid = $wuziarray["itemid"];$quantity = $wuziarray["quantity"];

//获取物品名item和当前剩余量leftover
linkdb('wuzi');
$checkitem = mysql_query("select * from wuzi where id = '$itemid' ");
while($itemarray = mysql_fetch_array($checkitem))
{$item = $itemarray["item"];$leftover = $itemarray["quantity"];}
if($leftover != 9999){$leftover = $leftover - $quantity;}

//修改wuzi数据库项目数量
$check_query = mysql_query("select * from wuzi where id='$itemid' ");
if($result = mysql_fetch_array($check_query))
{$check_query = mysql_query(" UPDATE wuzi SET quantity = '$leftover' WHERE id = '$itemid' ");}
}

linkdb('wuziapply');
//修改wuziapply状态
mysql_query(" UPDATE wuziapply SET state = '已借出' WHERE applyid = '$applyid' ");
mysql_query(" UPDATE wuziapply SET borrowname = '$myname' WHERE applyid = '$applyid' ");

//发送信息
date_default_timezone_set(PRC);
$time = date('y-m-d h:i:s',time());

$Url="https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=$accesstoken";
$data="{
   \"touser\": \"$toid\",
   \"msgtype\": \"news\",
   \"agentid\": 85,
   \"news\": {
       \"articles\":[
           {
               \"title\": \"你已于$time 领取物资\",
               \"description\": \"点击查看更多信息\",
               \"url\": \"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe1b78fe749897a87&redirect_uri=tw.jnu.edu.cn/qyh/wuzi/index.php&response_type=code&scope=snsapi_base&state=$applyid&connect_redirect=1#wechat_redirect\",
           },
       ]
   }
}";
$res = curlPost($Url,$data);

echo "<script>
document.addEventListener('WeixinJSBridgeReady', function(){ WeixinJSBridge.call('closeWindow'); }, false);
</script>";

} 


if($stat == 0){
if($state == "审核不通过") break 2;

linkdb('wuziapply');
//修改wuziapply状态
mysql_query(" UPDATE wuziapply SET state = '审核不通过' WHERE applyid = '$applyid' ");
mysql_query(" UPDATE wuziapply SET checkname = '$myname' WHERE applyid = '$applyid' ");
if(isset($_GET['opinion'])){$opinion = $_GET['opinion'];}
if(empty($opinion)){$opinion = '无';}
mysql_query(" UPDATE wuziapply SET opinion = '$opinion' WHERE applyid = '$applyid' ");

//发送信息
$Url="https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=$accesstoken";
$data="{
   \"touser\": \"$toid\",
   \"msgtype\": \"news\",
   \"agentid\": 85,
   \"news\": {
       \"articles\":[
           {
               \"title\": \"你的物资申请未通过\",
               \"description\": \"$myname 拒绝了你的物资申请，点击查看更多信息\",
               \"url\": \"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe1b78fe749897a87&redirect_uri=tw.jnu.edu.cn/qyh/wuzi/index.php&response_type=code&scope=snsapi_base&state=$applyid&connect_redirect=1#wechat_redirect\",
           },
       ]
   }
}";
$res = curlPost($Url,$data);

echo "<script>
document.addEventListener('WeixinJSBridgeReady', function(){ WeixinJSBridge.call('closeWindow'); }, false);
</script>";
}




if($stat == 1){
if($state == "审核通过") break 2;

linkdb('wuziapply');
//修改wuziapply状态
mysql_query(" UPDATE wuziapply SET state = '审核通过'  WHERE applyid = '$applyid' ");
mysql_query(" UPDATE wuziapply SET checkname = '$myname' WHERE applyid = '$applyid' ");

//发送信息
$Url="https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=$accesstoken";
$data="{
   \"touser\": \"$toid\",
   \"msgtype\": \"news\",
   \"agentid\": 85,
   \"news\": {
       \"articles\":[
           {
               \"title\": \"你的物资申请已通过\",
               \"description\": \"$myname 已通过你的物资申请，点击查看更多信息\",
               \"url\": \"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe1b78fe749897a87&redirect_uri=tw.jnu.edu.cn/qyh/wuzi/index.php&response_type=code&scope=snsapi_base&state=$applyid&connect_redirect=1#wechat_redirect\",
           },
       ]
   }
}";
$res = curlPost($Url,$data);

echo "<script>
document.addEventListener('WeixinJSBridgeReady', function(){ WeixinJSBridge.call('closeWindow'); }, false);
</script>";

} 


if($stat == 3){
if($state == "已归还") break 2;

linkdb('wuziapply');
$checkwuzi = mysql_query("select * from wuziapply where applyid = '$applyid' ");

while($wuziarray = mysql_fetch_array($checkwuzi))
{$itemid = $wuziarray["itemid"];$quantity = $wuziarray["quantity"];

//获取物品名item和当前剩余量leftover
linkdb('wuzi');
$checkitem = mysql_query("select * from wuzi where id = '$itemid' ");
while($itemarray = mysql_fetch_array($checkitem))
{$item = $itemarray["item"];$leftover = $itemarray["quantity"];}
if($leftover != 9999){$leftover = $leftover + $quantity;}

//修改wuzi数据库项目数量
mysql_query(" UPDATE wuzi SET quantity = '$leftover'  WHERE id = '$itemid' ");
}

linkdb('wuziapply');
//修改wuziapply状态
mysql_query(" UPDATE wuziapply SET state = '已归还' WHERE applyid = '$applyid' ");
mysql_query(" UPDATE wuziapply SET returnname = '$myname' WHERE applyid = '$applyid' ");

//发送信息
$Url="https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=$accesstoken";
date_default_timezone_set(PRC);
$time = date('y-m-d h:i:s',time());
$data="{
   \"touser\": \"$toid\",
   \"msgtype\": \"news\",
   \"agentid\": 85,
   \"news\": {
       \"articles\":[
           {
               \"title\": \"你已于$time 归还物资\",
               \"description\": \"点击查看更多信息\",
               \"url\": \"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe1b78fe749897a87&redirect_uri=tw.jnu.edu.cn/qyh/wuzi/index.php&response_type=code&scope=snsapi_base&state=$applyid&connect_redirect=1#wechat_redirect\",
           },
       ]
   }
}";
$res = curlPost($Url,$data);
}

echo "<script>alert(\"提交成功\");location.replace(\"detail.php?userid=$userid&accesstoken=$accesstoken&applyid=$applyid\")</script>";

?>
