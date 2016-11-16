<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<link rel="stylesheet" href="weui.css"/>
<link rel="stylesheet" href="example.css"/>
<link href="style.css" rel='stylesheet' type='text/css' />

<title>物资借用</title>
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

include('function.php');
session_start();
echo '<form name="myform" action="check.php" method="POST" onSubmit="return check()" >';//表单开始

if(isset($_GET['userid'])){$userid=$_GET['userid'];echo "<input type='hidden' name='userid' value=$userid>";}else{exit;}
if(isset($_GET['accesstoken'])){$accesstoken=$_GET['accesstoken'];echo "<input type='hidden' name='accesstoken' value=$accesstoken>";}else{exit;}
if(isset($_GET['campus'])){$campus=$_GET['campus'];echo "<input type='hidden' name='campus' value=$campus>";}else{exit;}

if($campus == 'main'){$xiaoqu = '校本部';echo "<input type='hidden' name='xiaoqu' value='校本部'>";}
if($campus == 'south'){$xiaoqu = '南校区';echo "<input type='hidden' name='xiaoqu' value='南校区'>";}

if(!checkdataexist('qyhlogin','sna2008','userid',$userid)){//登陆不成功则输出
    echo "<script>alert('身份信息不存在，请完善个人身份信息！');location.replace('register.php?userid=$userid');</script>";
    exit;
}

//---------------------------------------显示申请者信息--------------------------------
$name = getuniquecolumn('qyhlogin','sna2008','userid',$userid,'name');
echo "<input type='hidden' name='name' value=$name>";
$identity = getuniquecolumn('qyhlogin','sna2008','userid',$userid,'identity');
echo "<input type='hidden' name='identity' value=$identity>";
$department = getuniquecolumn('qyhlogin','sna2008','userid',$userid,'department');
echo "<input type='hidden' name='department' value=$department>";


echo "<br><h2 style='font-weight:normal' align='center'>物资借用申请表</h2>
<div class='weui_cells_title'>申请者信息</div><div class='weui_cells'>
<div class='weui_cell'><div class='weui_cell_bd weui_cell_primary'>
<p>申请人</p></div><div class='weui_cell_ft'>$name</div></div>
<div class='weui_cell'><div class='weui_cell_bd weui_cell_primary'>
<p>借用部门</p></div><div class='weui_cell_ft'>$department</div></div>
<div class='weui_cell'><div class='weui_cell_bd weui_cell_primary'>
<p>校区</p></div><div class='weui_cell_ft'>$xiaoqu</div></div>
</div>";


//---------------------------------------显示物资清单信息--------------------------------

    echo '<div class="container" id="container"></div>
    <script type="text/html" id="tpl_home">
    <div class="page">

    <div class="page__bd page__bd_spacing">
    <div class="weui_cells_title">选择物资</div>
    <ul>';

    logindatabase('wuzi','sna2008');
    $checktype = mysql_query("select * from wuzitype where campus = '$campus' ");
    $index = 0;
    while($typearray = mysql_fetch_array($checktype)){
        $type[$index] = $typearray["type"];
        $index ++;
    }

    for($i = 0;$i < count($type);$i++){

        echo '<li>
        <div class="weui-flex js_category">
        <p class="weui-flex__item">';
        echo $type[$i];
        echo '
        </p>
        </div>
        <div class="page__category js_categoryInner">
        <div class="weui-cells page__category-content">';

    logindatabase('wuzi','sna2008');
        $temp = $type[$i];
    $checkitem = mysql_query("select * from wuzi where campus = '$campus' and type='$temp' ");
        
    while($itemarray = mysql_fetch_array($checkitem)){
        $item = $itemarray["item"];
        $id = $itemarray["id"];
        $quantity = $itemarray["quantity"];
        echo "<div class='weui_cell'>
        <div class='weui_cell_hd'><label class='weui_label'>$item</label></div>
        <div class='weui_cell_bd weui_cell_primary'>";
        if($quantity == 9999){echo "<input class='weui_input' type='number' pattern='[0-9]*' style='text-align:right' placeholder='剩余若干' name = '$id' $id = '$item'>    </div></div>";}
        if($quantity != 9999){echo "<input class='weui_input' type='number' pattern='[0-9]*' style='text-align:right' placeholder='剩余：$quantity' name = '$id' id = '$item'>    </div></div>";}
    }
                         
        echo '</div>
        </div>
        </li>';

    
    }
    
    if(checkdataexist('wuzi','sna2008','type','未分类')){
    echo '<li>
    <div class="weui-flex js_category"><p class="weui-flex__item">未分类</p></div>
    <div class="page__category js_categoryInner">
    <div class="weui-cells page__category-content">';
        
        logindatabase('wuzi','sna2008');
        $temp = $type[$i];
        $checkitem = mysql_query("select * from wuzi where campus = '$campus' and type='未分类' ");
        while($itemarray = mysql_fetch_array($checkitem)){
            $item = $itemarray["item"];
            $id = $itemarray["id"];
            $quantity = $itemarray["quantity"];
            echo "<div class='weui_cell'>
            <div class='weui_cell_hd'><label class='weui_label'>$item</label></div>
            <div class='weui_cell_bd weui_cell_primary'>";
            if($quantity == 9999){echo "<input class='weui_input' type='number' pattern='[0-9]*' style='text-align:right' placeholder='剩余若干' name = '$id' $id = '$item'>    </div></div>";}
            if($quantity != 9999){echo "<input class='weui_input' type='number' pattern='[0-9]*' style='text-align:right' placeholder='剩余：$quantity' name = '$id' id = '$item'>    </div></div>";}
        }
        
        echo '</div>
        </div>
        </li>';
    }
    
    
    
     
        echo '</ul>
        </div>
    </br>';
    

    logindatabase('wuzi','sna2008');
    $check = mysql_query("select * from notice where campus='$campus' ");
    $itemarray = mysql_fetch_array($check);
    $notice = $itemarray[0];
    echo "<div class='weui-cells__tips'>$notice</div>";

    echo '
    <div class="weui-btn-area">
   <input class="weui_btn weui_btn_primary" type="submit" name="submit" onclick="flag = 0" value="下一步" />
    </div></form>
    
    
    <br><div class="weui-footer"><p class="weui-footer__links">
    <a href="http://tw.jnu.edu.cn" class="weui-footer__link">共青团暨南大学委员会</a></p>
    <p class="weui-footer__text">Copyright © 2015-2016 jnusna</p></div><br>
    
        </div>';
    

    
    


echo '</br><input class="weui_btn weui_btn_primary" type="submit" name="submit" onclick="flag = 0" value="提交" /></br></form>';


//--------------------------------------------footer-----------------------------------------
echo '<br><div class="weui-footer"><p class="weui-footer__links">
<a href="http://tw.jnu.edu.cn" class="weui-footer__link">共青团暨南大学委员会</a></p>
<p class="weui-footer__text">Copyright © 2015-2016 jnusna</p></div><br>';

?>

<script type="text/javascript">
$(function(){
  var winH = $(window).height();
  var categorySpace = 10;
  
  $('.js_item').on('click', function(){
                   var id = $(this).data('id');
                   window.pageManager.go(id);
                   });
  $('.js_category').on('click', function(){
                       var $this = $(this),
                       $inner = $this.next('.js_categoryInner'),
                       $page = $this.parents('.page'),
                       $parent = $(this).parent('li');
                       var innerH = $inner.data('height');
                       bear = $page;
                       
                       if(!innerH){
                       $inner.css('height', 'auto');
                       innerH = $inner.height();
                       $inner.removeAttr('style');
                       $inner.data('height', innerH);
                       }
                       
                       if($parent.hasClass('js_show')){
                       $parent.removeClass('js_show');
                       }else{
                       $parent.siblings().removeClass('js_show');
                       
                       $parent.addClass('js_show');
                       if(this.offsetTop + this.offsetHeight + innerH > $page.scrollTop() + winH){
                       var scrollTop = this.offsetTop + this.offsetHeight + innerH - winH + categorySpace;
                       
                       if(scrollTop > this.offsetTop){
                       scrollTop = this.offsetTop - categorySpace;
                       }
                       
                       $page.scrollTop(scrollTop);
                       }
                       }
                       });
  });
</script>


<script src="zepto.min.js"></script>
<script type="text/javascript" src="jweixin-1.0.0.js"></script>
<script src="example.js"></script>
</body>
</html>

