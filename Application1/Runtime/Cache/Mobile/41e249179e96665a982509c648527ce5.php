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
    <div style="height:50px;"></div>
    
	<div class="centent_box">
		<h3 class="col-xs-12" style="font-size:17px;padding-top:20px;padding-bottom:10px; margin:0 2%;">到账帐户</h3>
		<?php if(is_array($account)): foreach($account as $key=>$list): ?><div class="z-div col-xs-12"><?php echo ($list["account_name"]); echo ($list["account_num"]); ?><input class="account_id" type="hidden" value="<?php echo ($list["id"]); ?>">
			<?php if($list["default"] == 1): ?><i class="icon-check-circle pull-right text-primary"></i>
			<?php else: ?>
			<i class="icon-check-circle pull-right"></i><?php endif; ?>
			</div><?php endforeach; endif; ?>
		<input type="hidden" value="<?php echo ($default); ?>" id="account_id"/>
        <div class="z-padding-3x z-page-btn"><a href="<?php echo U('Mobile/User/account_add');?>" class="btn btn-lg btn-block z-bg-main">添加帐户</a></div>
        <div class="z-padding-3x z-page-btn" id="delete"><a class="m_btn btn-block text-center"><span>删除帐户</span></a></div>
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
<script>
$(function(){
	$('.z-div').on('click',function(){
		$('.z-div').find('.icon-check-circle').removeClass('text-primary');
		$(this).find('.icon-check-circle').addClass('text-primary');
		$('#account_id').val($(this).find('.account_id').val());
		console.log($(this).find('.account_id').val());
	});
    function  sure_remove(){
        if(window.confirm('确定删除账号么？')){
            return true;
         }else{
            return false;
            }
    }
	$('#delete').on('click',function(){
		var t = sure_remove();
        if(!t){
            return;
        }
		var id = $('#account_id').val();
		$.post("change_account_status",{id:id,type:1},function(resp){
			if(resp){
				alert(resp.info);
				  location.reload()
			}
		});
	});
	$('#set_default').on('click',function(){
		var id = $('#account_id').val();
		$.post("change_account_status",{id:id,type:2},function(resp){
			if(resp){
				alert(resp.info);
				  location.reload()
			}
		});
	});
	
})

</script>
</body>
</html>