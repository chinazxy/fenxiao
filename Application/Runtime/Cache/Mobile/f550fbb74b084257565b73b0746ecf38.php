<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
<meta name="Generator" content="upshop v1.1" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="format-detection" content="telephone=no" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="applicable-device" content="mobile">
<title></title>
<meta http-equiv="keywords" content="<?php echo ($upshop_config['shop_info_store_keyword']); ?>" />
<meta name="description" content="<?php echo ($upshop_config['shop_info_store_desc']); ?>" />
<meta name="Keywords" content="upshop触屏版  upshop 手机版" />
<meta name="Description" content="upshop触屏版   upshop商城 "/>
<link rel="stylesheet" href="/Template/mobile/new/Static/css/zui.min.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/main.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/public.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/m.css">
<script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/common.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/modernizr.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/layer.js" ></script>
<!-- <?php echo ($upshop_config['shop_info_store_title']); ?> -->
</head>

<div  style='margin-top:50px;'>
</div>
<body>
<div id="pageContent">
    <div class="header2">
        <a onClick="history.go(-1)"><i></i><span></span></a>
        <!--<a href="<?php echo U('Mobile/Index/index');?>" class="icon icon_home"></a>-->
        <aside class="top_bar">
         <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
       </aside>
        <p>帐户管理</p>
    </div>
    <script type="text/javascript" src="/Template/mobile/new/Static/js/mobile.js" ></script>
<div class="goods_nav hid" id="menu">
      <div class="Triangle">
        <h2></h2>
      </div>
      <ul>
        <li><a href="<?php echo U('Index/index');?>"><span class="menu1"></span><i>首页</i></a></li>
        <li><a href="<?php echo U('Cart/cart');?>"><span class="menu3"></span><i>购物车</i></a></li>
        <li style=" border:0;"><a href="<?php echo U('User/index');?>"><span class="menu4"></span><i>我的</i></a></li>
   </ul>
 </div> 
  
    
    <div class="centent_box" style="margin:0 2%;padding-top:10px;">
    <form method='post' id='rec' action="<?php echo U('user/sure_rechage');?>" >
        <h3 class="col-xs-12" style="font-size:16px; line-height:20px; text-align:center;margin-bottom:2%;">请输入充值金额</h3>
        <div class="clearfix">
            <div class="col-xs-1 text-right" style="font-size:20px; line-height:35px; text-align:center;margin-right:10px;">￥</div><div class="col-xs-10"><input name='money' type="num" class="form-control money"></div>
        </div>
        <h3 class="col-xs-12 z-page-btn">支付方式</h3>
        <div class="cv_div z-div parre"><i class="icon-pay-zfb"></i><span style="margin-left:2px;">支付宝</span><i class="icon-check-circle text-primary pull-right pora"></i></div>
    </div>
    
    <div style="height:70px;"></div>
    <div class="z-footer">
        <div class="z-pay-footer">
            <a class="btn btn-lg" onclick="history.go(-1)">返回</a>
            <a class="btn btn-lg btn-primary sure_recharge"  style="margin-left:10px;">确认付款</a>
        </div>
    </div>
    </form>
</div>
<script src="/Public/ihtml/js/zui.min.js"></script>
<script>
   $(function(){
	   $('.sure_recharge').on('click',function(){
           var money = $('.money').val();
		   var moneyRegex = /^(([1-9]\d{0,9})|0)(\.\d{1,2})?$/;
		   if(!moneyRegex.test(money)||isNaN(money)){
		       alert('请输入正确的金额');
               return;
		   }
           if(money == 0 || money == ''){
               alert('请输入正确的金额');
               return;
           }
		   $('#rec').submit();
	   })
   })
</script>
</body>
</html>