<?php 


//引入核心库文件
include "phpqrcode/phpqrcode.php";
//定义纠错级别
$errorLevel = "L";
//定义生成图片宽度和高度;默认为3
$size = "4";
//定义生成内容



//生成网址类型
$applyid = $_GET['applyid'];

$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe1b78fe749897a87&redirect_uri=tw.jnu.edu.cn/qyh/wuzimanager/index.php&response_type=code&scope=snsapi_base&state=$applyid&connect_redirect=1#wechat_redirect";


QRcode::png($url, false, $errorLevel, $size);



?>