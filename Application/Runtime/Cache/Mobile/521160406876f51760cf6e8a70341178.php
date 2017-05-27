<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
<meta name="Generator" content="upshop1.2" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>密码设置-<?php echo ($upshop_config['shop_info_store_title']); ?></title>
<meta http-equiv="keywords" content="<?php echo ($upshop_config['shop_info_store_keyword']); ?>" />
<meta name="description" content="<?php echo ($upshop_config['shop_info_store_desc']); ?>" />

<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/css/public.css"/>
<link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/css/login.css"/>  
<script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/common.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/layer.js" ></script>
</head>
<body>
<header id="header" class='header'>
    <div class="h-left"><a href="javascript:history.back(-1)"></a></div>
	<div class="h-mid">找回密码</div>
</header>
<div id="tbh5v0">
	<div class="find">        
	<section class="innercontent">
		<?php if($is_set == 1): ?><div class="find_box_end">
				<p>新密码设置成功！</p>
				<p>请您牢记新密码！</p>
				<p class="on_go">
					<a href="<?php echo U('User/login');?>" title="立即登陆" class="btn_big1" style=" color:#FFF">立即登录&gt;&gt;</a>
				</p>
		</div>
		<?php else: ?>
		<form action="" method="post" id="formPassword" name="formPassword">
			<div class="field pwd" style=" margin-top:20px">
				<input name="password" id="password" type="password" placeholder="请输入密码" class="c-form-txt-normal" />
			</div>
			<div class="field pwd">
				<input name="password2" id="comfirm_password" type="password" placeholder="请再次确认密码" class="c-form-txt-normal" />
			</div>
			<div class="submit-btn">
				<input type="button" id="btn_submit" name="btn_submit" class="btn_big1" value="提 交" onClick="checkpwd()"/>
			</div>
		</form><?php endif; ?>
	</section>
<script type="text/javascript">

function checkpwd() {
	var new_password = $('#password').val();
	var confirm_password = $('#comfirm_password').val();
	if(new_password == '' || confirm_password == ''){
		layer.open({content:'密码不能为空',time:2});
		return false;
	}else if(new_password.length<6 || confirm_password.length<6){
		layer.open({content:'密码长度不能少于6位',time:2});
		return false;
	}else if(new_password != confirm_password){
		layer.open({content:'两次密码输入不一致',time:2});
		return false;
	}else{
		$('#formPassword').submit();
	}
}
</script>
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
</div>
<div style="height:50px; line-height:50px; clear:both;"></div>
<div class="v_nav">
	<div class="vf_nav">
		<ul>
			<li> <a href="<?php echo U('Index/index');?>">
			    <i class="vf_1"></i>
			    <span>首页</span></a></li>
			<li><a href="<?php echo U('Msg/index');?>">
			    <i class="vf_3"></i>
			    <span>消息</span></a></li>
			<li>
			<a href="<?php echo U('User/order_list');?>">
			  <!--  <em class="global-nav__nav-shop-cart-num" id="ECS_CARTINFO" style="right:9px;"></em> -->
			   <input type='hidden' value=' <?php echo ($cart_total_price[anum]); ?> ' name='car_total_price' />
			   <i class="vf_4"></i>
			   <span>订单</span>
			   </a>
			</li>
			<li><a href="<?php echo U('User/index');?>">
			    <i class="vf_5"></i>
			    <span>个人</span></a>
			</li>
		</ul>
	</div>
</div> 
</body>
</html>