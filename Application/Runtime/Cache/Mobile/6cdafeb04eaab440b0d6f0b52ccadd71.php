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

</head>

<body>
<div id="pageContent">
<div class="header2">
    	<a><i onClick="history.go(-1)"></i></a>
        <!--<a href="<?php echo U('Mobile/Index/index');?>" class="icon icon_home"></a>-->
        <aside class="top_bar" style="display:none">
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
    <div style="height:45px;"></div>
    
	<div class="centent_box col-xs-12" >
		<div class="z-tx-box color-blue">
			<h3 class="head">到账帐户：<span class="text-primary"></span></h3>
			<div class="col-xs-12 z-tx-box-btn" style="border-bottom:1px solid #ccc;">
				<span></span>
				<!--<input class="bank" type="text" placeholder="" value="<?php echo ($account["account_name"]); ?>--<?php echo ($account["account_num"]); ?>" readonly>-->
                <div>
                <select class="form-control2 bank">
                	<option value="">点击选择提现账户</option>
                	<?php if(is_array($account)): foreach($account as $key=>$item): ?><option value="<?php echo ($item["id"]); ?>"><?php echo ($item["account_name"]); ?>--<?php echo ($item["account_num"]); ?></option><?php endforeach; endif; ?>
                </select>
                </div>
			</div>
			
			<div class="col-xs-12 border-bottom z-tx-box-btn">
				<h2 class="title">提现金额￥：</h2>
				<input class="money" type="text" placeholder="">
				<input type="hidden" id="allmoney" value="<?php echo ($user_info["user_money"]); ?>"/>
			</div>
			<div class="col-xs-12 z-tx-footer  clearfix"><div class="">我的余额：<strong class="text-primary" >￥<span id="user_money"><?php echo ($user_info["user_money"]); ?></span></strong><a class="lead pull-right doall_cash">全部提现</a></div></div>
		</div>
	</div>
	<div class="z-page-btn z-padding-4x" style="background:none;">
		<a class="btn btn-block btn-lg z-bg-main do_cash" >确认提现</a>
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
<!-- <script src="../js/jquery-1.9.1.min.js"></script>
<script src="../js/zui.min.js"></script> -->
<script>
$(function(){
	$(".do_cash").click(function(){
		var bank = $('.bank').val();
		var money = $('.money').val();
		var moneyRegex = /^(([1-9]\d{0,20})|0)(\.\d{1,2})?$/;
		if(isNaN(money)){
			alert('请输入正确的金额');
			return;
		}
		if(!moneyRegex.test(money)){
		   alert('只能保留到小数点后两位');
			return;
		}
		var num = Number(parseFloat($('#allmoney').val()) - parseFloat(money)).toFixed(2);
		console.log(bank+'+'+money);
		//return;
		$.post('',{bank:bank,money:money},function(resp){
			if(resp.status==1){
				var num = Number(parseFloat($('#allmoney').val()) - parseFloat(money)).toFixed(2);
				$('#allmoney').val(num);
				$('#user_money').text(num);
				alert(resp.info);
				location.href="<?php echo U('cash_list');?>";
			}else{
				alert(resp.info)
			}
		})
	});
	$('.doall_cash').click(function(){
		$('.money').val($('#allmoney').val());
		//$(".do_cash").click();
	})
})
</script>
</body>
</html>