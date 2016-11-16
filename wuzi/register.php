
<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<link href="style.css" rel='stylesheet' type='text/css' />
<title>完善信息</title> 
<style type="text/css">
h1 {font-family:FangSong;}
</style>
</head>

<script language=javascript>
var flag = 0;
function check(){

if(confirm( "提交后不可更改，是否提交？")==false)return  false; 


}
</script>

<body bgcolor="#FBF9FE">


<?php

$userid = $_GET['userid'];

echo "<br><h2 style='font-weight:normal' align='center'>注册系统</h2>";
echo '<form name="myform" action="registersubmit.php" method="POST" onSubmit="return check()" >';




echo '
<div class="weui_cells_title">注意：首次使用企业号需要完善个人身份信息，本表只能填写一次，请认真填写。</div>
<div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">姓名</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="text" name = "name" placeholder="请输入姓名">
            </div>
        </div>
<div class="weui_cell weui_cell_select weui_select_after">
            <div class="weui_cell_hd">
                <label for="" class="weui_label">部门</label>
            </div>
            <div class="weui_cell_bd weui_cell_primary">
                <select class="weui_select" name="department">
                    <option value="秘书处">秘书处</option>
                    <option value="组织部">组织部</option>
                    <option value="宣传部">宣传部</option>
                    <option value="学术科技部">学术科技部</option>
                    <option value="社会实践部">社会实践部</option>
                    <option value="联络部">联络部</option>
                    <option value="编辑部">编辑部</option>
                    <option value="调研部">调研部</option>
                    <option value="国旗护卫队">国旗护卫队</option>
                    <option value="礼仪队">礼仪队</option>
                    <option value="学生网络联盟">学生网络联盟</option>
                    <option value="新媒体部">新媒体部</option>
										<option value="司仪小组">司仪小组</option>

                </select>
            </div>
        </div>

<div class="weui_cell weui_cell_select weui_select_after">
            <div class="weui_cell_hd">
                <label for="" class="weui_label">身份</label>
            </div>
            <div class="weui_cell_bd weui_cell_primary">
                <select class="weui_select" name="identity">
                    <option value="干事">干事</option>
                    <option value="部长">部长</option>
                </select>
            </div>
        </div>


    </div>';

echo "<input type='hidden' name='userid' value=$userid >";

echo '</br><input class="weui_btn weui_btn_primary" type="submit" name="submit" onclick="flag = 0" value="提交" /></br></form>';






?>

</body>
</html>
