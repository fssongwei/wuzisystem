<?php
include('function.php');
//本页面用于获取用户的userid和accesstoken等信息并跳转到微信菜单对应的应用
/*
用户点击菜单后，将跳转到OAuth2.0验证页面，该页面将携带code（用于获取accesstoken，获取用户的id和头像等其他信息需要携带
accesstoken，code只能用一次，因此任何形式的后退到此页面均不能通过code获得accesstoken）和状态码state（用于确定用户
点击的是哪个菜单）跳转到本页面
*/
    
$corpid = 'wxe1b78fe749897a87';
$corpserect = '_bhy3FqqNs2BJ0dno1Pd4RkkTqyDJibyHawF3BFNaDdBt_pHVzMH7uEu0f-4LvFp';
$location = 'http://tw.jnu.edu.cn/qyh/wuzimanager/';
    
session_start();
//获取code和state,如果获取不到code则不执行下面的语句
if(isset($_GET['state'])){$state = $_GET['state'];}
if(isset($_GET['code'])){$code = $_GET['code'];}else{exit;}
    
//获取accesstoken
$url = 'https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid='.$corpid.'&corpsecret='.$corpserect;
$content = getContent($url);
$json = json_decode($content); //对JSON格式的字符串进行编码
$accesstokenarray = get_object_vars($json);//转换成数组
$accesstoken = $accesstokenarray['access_token'];
$_SESSION['accesstoken'] = $accesstoken;

//获取userid
$url = 'https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token='.$accesstoken.'&code='.$code;
$content = getContent($url);
$json = json_decode($content); //对JSON格式的字符串进行编码
$useridarray = get_object_vars($json);//转换成数组
$userid = $useridarray['UserId'];//输出UserId
$_SESSION['userid'] = $userid;

//根据状态码跳转到对应的页面
switch ($state)
{
    case nxq:
        header("location:/qyh/wuzimanager/applylist/applylist.php?userid=$userid&accesstoken=$accesstoken&campus=south");
        break;
    case xbb:
        header("location:/qyh/wuzimanager/applylist/applylist.php?userid=$userid&accesstoken=$accesstoken&campus=main");
        break;
    case me:
        header("location:/qyh/wuzimanager/applylist/applytome.php?userid=$userid&accesstoken=$accesstoken");
        break;
    case ms:
        header("location:/qyh/wuzimanager/manage/changelist.php?userid=$userid&accesstoken=$accesstoken&campus=south");
        break;
    case mn:
        header("location:/qyh/wuzimanager/manage/changelist.php?userid=$userid&accesstoken=$accesstoken&campus=main");
        break;
    default:
        header("location:/qyh/wuzimanager/applylist/detail.php?userid=$userid&accesstoken=$accesstoken&applyid=$state");
}
?>
