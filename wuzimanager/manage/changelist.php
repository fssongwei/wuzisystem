<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<link rel="stylesheet" href="css/weui.css"/>
<link rel="stylesheet" href="css/example.css"/>

<title>物资管理</title>
</head>

<body bgcolor="#FBF9FE">
<?php
include('function.php');

//获取登陆信息
$userid=$_GET['userid'];
$accesstoken=$_GET['accesstoken'];
$campus=$_GET['campus'];
checkRegister($userid);//检查登陆

//输出物资列表
echo '<div class="container" id="container"></div>
<script type="text/html" id="tpl_home">
<div class="page">
<div class="page__bd page__bd_spacing">
<div class="weui-cells__title">增加、修改或删除物资项</div>
<ul>';

//登陆数据库
linkdb('wuzi');
$type = fetchArray('wuzitype','campus',$campus,'type');
if(isDataExist('wuzi','type','未分类')){$count = count($type);$type[$count] = '未分类';}
    
for($i=0;$i<count($type);$i++)
{
    echo "<li>
        <div class='weui-flex js_category'>
        <p class='weui-flex__item'>$type[$i]</p>
        </div>
        <div class='page__category js_categoryInner'>
        <div class='weui-cells'>";

    linkdb('wuzi');
    $check = mysql_query("select * from wuzi where campus = '$campus' and type='$type[$i]' ");
    while($array = mysql_fetch_array($check))
    {
        $item = $array["item"];
        $id = $array["id"];
        $quantity = $array["quantity"];
        echo "<a class='weui-cell weui-cell_access' href='itemdetail.php?id=$id&name=$item&userid=$userid&accesstoken=$accesstoken&campus=$campus'>
            <div class='weui-cell__bd'><p>$item</p></div>";
        if($quantity == 9999){echo " <div class='weui-cell__ft'>剩余若干</div></a>";}
        if($quantity != 9999){echo " <div class='weui-cell__ft'>当前剩余：$quantity</div></a>";}
    }

    echo '</div></div></li>';
}

echo '</ul></div></br>';
    

//输出注意事项
linkdb('wuzi');
$notice = fetchData('notice','campus',$campus,'notice');
echo "<div class='weui-cells__tips'>$notice</div>";
    
//输出按钮
echo "
<div class='weui-btn-area'>
<a href='additem.php?userid=$userid&accesstoken=$accesstoken&campus=$campus' class='weui-btn weui-btn_primary'>新增物资</a><br>
<a href='changetype.php?userid=$userid&accesstoken=$accesstoken&campus=$campus' class='weui-btn weui-btn_primary'>编辑分类</a><br>
<a href='changenotice.php?userid=$userid&accesstoken=$accesstoken&campus=$campus' class='weui-btn weui-btn_primary'>编辑注意事项</a>
<a href='record.php?userid=$userid&accesstoken=$accesstoken&campus=$campus' class='weui-btn weui-btn_primary'>查看修改记录</a>
</div>";

printFooter(0);//输出footer
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


<script src="js/zepto.min.js"></script>
<script type="js/text/javascript" src="jweixin-1.0.0.js"></script>
<script src="js/example.js"></script>
</body>
</html>

