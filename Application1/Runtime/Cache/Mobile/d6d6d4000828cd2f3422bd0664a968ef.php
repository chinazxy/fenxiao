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


<body class="bg_white">
<div class="wrap">
	<!--头部-->
    <div class="header2">
    	<a onClick="history.go(-1)"><i></i><span></span></a>
        <!--<a href="<?php echo U('Mobile/Index/index');?>" class="icon icon_home"></a>-->
        <aside class="top_bar">
         <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
       </aside>
        <p>提现</p>
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
    <div class="withdrawals">
    	<div class="withdrawals_box">
        	<div class="logo"><!-- <img src="img/1.jpg" width="100%"/> --></div>
            <div class="withdrawals_box_ye"><p>我的余额</p><div>￥<?php echo ($user_money[user_money] + $user_money[frozen_money]); ?></div></div>
            <div class="withdrawals_box_ye2"><span>可用余额：</span>￥<?php echo ($user_money["user_money"]); ?></div>
            <div class="withdrawals_box_ye2"><span>不可用余额：</span>￥<?php echo ($user_money["frozen_money"]); ?></div>
    <!--         <a class="m_btn btn-block withdrawals_box_a" style="background:#5eb9f7;color:#fff;">充值</a> -->
            <a href="<?php echo U('Mobile/User/cash_list');?>" class="m_btn btn-block withdrawals_box_a" style="background:none;color:#333;"><span style="border-bottom:1px solid #333;padding-bottom:5px;">提现记录</span></a>
            <?php if($user_money["is_temination"] != 0): ?><a href="javascript:void(0)" style="background:#000;color:#fff;"  class="m_btn btn-block withdrawals_box_a temination">充值</a>
                <a href="javascript:void(0)" style="background:none;border:1px solid #ccc;"  class="m_btn btn-block withdrawals_box_a temination">提现</a>
                <?php elseif($user_money["is_temination"] == 0): ?>
                <a href="<?php echo U('Mobile/user/recharge');?>" style="background:#000;color:#fff;"  class="m_btn btn-block withdrawals_box_a">充值</a>
                <a href="<?php echo U('Mobile/User/docash');?>" style="background:none;border:1px solid #ccc;"  class="m_btn btn-block withdrawals_box_a">提现</a><?php endif; ?>
        </div>
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
</div>
<script type="text/javascript">
var H = document.body.clientHeight;
$('.H').css('height', H + 'px');

$('.menu').click(function(){
	$(this).toggleClass('on');
})
$('.temination').click(function(){
    alert('您已向平台提出解约，无法进行资金操作！');
})
</script>
</body>
</html>