   <?php
//登陆数据库
function logindatabase($databasename,$databasepassword){
	$conn = mysql_connect("localhost","root",$databasepassword);
	if (!$conn){die("fail to connect the datebase：" . mysql_error());}
		mysql_select_db($databasename, $conn);
		mysql_query("set character set 'utf8'");
		mysql_query("set names 'utf8'");
}

//通过唯一字段信息获得某条记录另一字段的信息（1.数据库名 2.数据库密码 3.字段名1 4.字段1数据 5.字段名2）
function getuniquecolumn($databasename,$databasepw,$name1,$data1,$name2){
	logindatabase($databasename,$databasepw);
		$check = mysql_query("select $name2 from $databasename where $name1='$data1' ");
		$itemarray = mysql_fetch_array($check);
		return $itemarray[0];
}

//判断某条记录是否存在（1.数据库名 2.数据库密码 3.字段名1 4.字段1数据）
function checkdataexist($databasename,$databasepw,$name1,$data1){
		logindatabase($databasename,$databasepw);
		$check = mysql_query("select * from $databasename where $name1='$data1' ");
		if($result = mysql_fetch_array($check)){ return 1;} else {return 0;}
}

       
       //curl方法获得页面内容
       function getContent($url) {
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
           if ($ssl){
               $opt[CURLOPT_SSL_VERIFYHOST] = 2;
               $opt[CURLOPT_SSL_VERIFYPEER] = FALSE;
           }
           
           curl_setopt_array($ch,$opt);
           $data = curl_exec($ch);
           curl_close($ch);
           return $data;
       }
?>
