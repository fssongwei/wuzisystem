<?php
define("db_host","localhost");//数据库地址
define("db_user","root");//数据库用户帐号
define("db_password","sna2008");//数据库密码


//登陆数据库
function linkdb($dbname){
	$con = mysql_connect(db_host,db_user,db_password);
	if (!$con){die("fail to connect the datebase：" . mysql_error());}
		mysql_select_db($dbname, $con);
		mysql_query("set character set 'utf8'");
		mysql_query("set names 'utf8'");
}

//判断某条记录是否存在（需要连接数据库）
function isDataExist($db_form_name,$field,$data)
{
    $check = mysql_query("select * from $db_form_name where $field='$data' ");
    if($result = mysql_fetch_array($check)){return 1;} else {return 0;}
}

//检查是否注册（无注册则跳转到注册页面）
function checkRegister($USERID)
{
    linkdb('qyhlogin');
    if(!isDataExist('qyhlogin','userid',$USERID))
    {
    echo "
    <script>
    alert('身份信息不存在，请完善个人身份信息！');
    location.replace('register.php?userid=$userid');
    </script>";
    exit;
    }
}

//从筛选字段1得到的记录中获得字段2的数组
function fetchArray($db_form_name,$field1,$data,$field2)
{
    $check = mysql_query("select * from $db_form_name where $field1 = '$data' ");
    $i = 0;
    while($array = mysql_fetch_array($check))
    {
        $newarray[$i] = $array["$field2"];
        $i++;
    }
	return $newarray;
}

//从筛选字段1得到的唯一记录中获得字段2的数据值
function fetchData($db_form_name,$field1,$data,$field2)
{
    $check = mysql_query("select * from $db_form_name where $field1='$data' ");
    $array = mysql_fetch_array($check);
    return $array["$field2"];
}


//创建操作记录
function createRecord($userid,$record)
{
    linkdb('qyhlogin');
    $name = fetchData('qyhlogin','userid',$userid,'name');
    $time = date('y-m-d h:i:s',time());
    $url = db_host;
    $user = db_user;
    $password = db_password;
    $con = mysql_connect($url,$user,$password);
    mysql_query("set names 'utf8'");
    mysql_select_db("wuzi",$con);
    $sql = "insert into record (name,time,record)  values('$name','$time','$record')";
    mysql_query($sql,$con);
}

//创建注脚
function printFooter($flag)
{
    $year = date('Y');
    if($flag == 1)
    {
        echo "
        <br><div class='weui-footer weui-footer_fixed-bottom'><p class='weui-footer__links'>
        <a href='http://tw.jnu.edu.cn' class='weui-footer__link'>共青团暨南大学委员会</a></p>
        <p class='weui-footer__text'>Copyright © 2015-$year jnusna</p></div><br>";
    }
    if($flag == 0)
    {
        echo "
        <br><div class='weui-footer'><p class='weui-footer__links'>
        <a href='http://tw.jnu.edu.cn' class='weui-footer__link'>共青团暨南大学委员会</a></p>
        <p class='weui-footer__text'>Copyright © 2015-$year jnusna</p></div><br>";
    }
}

//curl方法获得页面内容
function getContent($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
       
//通过企业号接口发送信息
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
    if ($ssl)
    {
            $opt[CURLOPT_SSL_VERIFYHOST] = 2;
            $opt[CURLOPT_SSL_VERIFYPEER] = FALSE;
    }
    curl_setopt_array($ch,$opt);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
?>
