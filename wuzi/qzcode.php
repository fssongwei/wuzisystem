<?php 


//������Ŀ��ļ�
include "phpqrcode/phpqrcode.php";
//���������
$errorLevel = "L";
//��������ͼƬ��Ⱥ͸߶�;Ĭ��Ϊ3
$size = "4";
//������������



//������ַ����
$applyid = $_GET['applyid'];

$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe1b78fe749897a87&redirect_uri=tw.jnu.edu.cn/qyh/wuzimanager/index.php&response_type=code&scope=snsapi_base&state=$applyid&connect_redirect=1#wechat_redirect";


QRcode::png($url, false, $errorLevel, $size);



?>