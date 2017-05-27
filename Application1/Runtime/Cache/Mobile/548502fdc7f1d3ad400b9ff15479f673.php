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
<title>首页推广</title>
<!--<meta http-equiv="keywords" content="<?php echo ($upshop_config['shop_info_store_keyword']); ?>" />
<meta name="description" content="<?php echo ($upshop_config['shop_info_store_desc']); ?>" />-->
<meta name="Keywords" content="upshop触屏版  upshop 手机版" />
<meta name="Description" content="upshop触屏版   upshop商城 "/>
<link rel="stylesheet" href="/Template/mobile/new/Static/css/zui.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/zui.lite.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/zui.lite.min.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/zui.min.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/main.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/zui-theme.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/zui-theme.min.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/public.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/m.css">
<script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/common.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/modernizr.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/layer.js" ></script>
</head>

<body>
<div class="wrap">
	<div class="header2">
    	<a onclick="history.go(-1)"><i></i><span></span></a>
        <aside class="top_bar">
         <div onclick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
       </aside>
        <p>首页推广</p>
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
    <div style="height:45px;"></div>
	<div class="col-xs-12 padding_hhi">
    	<h1 class="text-center">标题标题标题</h1>
    	<div class="col-xs-12" style="font-size:16px;padding-top:20px;">服务内容：首页金牌卖家广告翻滚一个月  收费200元/次，次日生效。</div>
    </div>
	<div class="z-order-footer col-xs-12" style="padding-top:100PX"PADDING-BOTTOM:50px">
    		<a class="btn btn-lg btn-block btn-primary qrsq">确认申请</a>
    	</div>
	 <!-- <div class="footer" >
	      <div class="links"  id="TP_MEMBERZONE"> 
	      		<?php if($user_id > 0): ?><a href="<?php echo U('User/index');?>"><span><?php echo ($user["nickname"]); ?></span></a><a href="<?php echo U('User/logout');?>"><span>退出</span></a>
	      		<?php else: ?>
	      		<a href="<?php echo U('User/login');?>"><span>登录</span></a><a href="<?php echo U('User/reg');?>"><span>注册</span></a><?php endif; ?>
	      		<a href="#"><span>反馈</span></a><a href="javascript:window.scrollTo(0,0);"><span>回顶部</span></a>
		  </div>
	      <ul class="linkss" >
		      <li>
		        <a href="#">
		        <i class="footerimg_1"></i>
		        <span>客户端</span></a></li>
		      <li>
		      <a href="javascript:;"><i class="footerimg_2"></i><span class="gl">触屏版</span></a></li>
		      <li><a href="<?php echo U('Home/Index/index');?>" class="goDesktop"><i class="footerimg_3"></i><span>电脑版</span></a></li>
	      </ul>
	  	 <p class="mf_o4">备案号:<?php echo ($upshop_config['shop_info_record_no']); ?><br/>&copy; 2005-2016 upshop多商户V1.2 版权所有，并保留所有权利。</p>
</div> -->
<div class='wrap fot'>
	<div class="footer">
	    	<a id="jump1"class="cc-href" href="<?php echo U('Mobile/Index/index');?>"><i class="ccIcons-product"></i><span>产品</span></a>
	        <a id="jump2"class="cc-href" href="<?php echo U('Mobile/User/order_list');?>"><!-- <i class="footer_order_label"></i> --><i class="ccIcons-order"></i><span>订单</span></a>
	        <a id="jump3"class="cc-href" href="<?php echo U('Mobile/Msg/index');?>"><i class="ccIcons-toast"></i><span>通知</span></a>
	        <a id="jump4"class="cc-href" href="<?php echo U('User/index');?>"><i class="ccIcons-user"></i><span>我的</span></a>
	</div>
</div> 
<script src="../js/jquery-1.9.1.min.js"></script>
<script src="../js/zui.min.js"></script>
<script>
$('.qrsq').on('click',function(){
	alert('您的余额不足，无法完成操作')
})
</script>
</body>
</html>