
<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<link href="style.css" rel='stylesheet' type='text/css' />
<title>物资借用</title> 
<style type="text/css">
h1 {font-family:FangSong;}
</style>
</head>

<body bgcolor="#FBF9FE">

<?php


session_start();

if(isset($_GET['userid'])){$userid = $_GET['userid'];}
if(isset($_SESSION['userid'])){$userid = $_SESSION['userid'];}
if(isset($userid)){$_SESSION['userid'] = $userid;}

if(isset($_GET['accesstoken'])){$accesstoken = $_GET['accesstoken'];}
if(isset($_SESSION['accesstoken'])){$accesstoken = $_SESSION['accesstoken'];}
if(isset($accesstoken)){$_SESSION['accesstoken'] = $accesstoken;}




echo "
<div class='weui_cells_title'>选择校区</div>
<div class='weui_cells weui_cells_access'>
        <a class='weui_cell' href='http://tw.jnu.edu.cn/qyh/wuzi/wuzi2.php?userid=$userid&accesstoken=$accesstoken&campus=main'>
            <div class='weui_cell_bd weui_cell_primary'>
                <p>校本部</p>
            </div>
            <div class='weui_cell_ft'>
            </div>
        </a>
        <a class='weui_cell' href='http://tw.jnu.edu.cn/qyh/wuzi/wuzi.php?userid=$userid&accesstoken=$accesstoken&campus=south'>
            <div class='weui_cell_bd weui_cell_primary'>
                <p>南校区</p>
            </div>
            <div class='weui_cell_ft'>
            </div>
        </a>
    </div>
";








?>

</body>
</html>
