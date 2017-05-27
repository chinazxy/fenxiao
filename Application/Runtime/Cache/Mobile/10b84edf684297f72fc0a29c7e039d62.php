<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="robots" content="index,follow" />
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="format-detection" content="telphone=no, email=no" />
    <meta name="renderer" content="webkit">
    <meta name="keywords" content="cchen" />
    <meta name="description" content="诚享东方经销商下单系统" />
    <meta name="author" content="cchen, 719857499@qq.com" />
    <meta name="x5-page-mode" content="app">
    <title></title>
    <!-- 通用类 -->
    <link rel="stylesheet" href="/Public/jd/css/reset.css">
    <link rel="stylesheet" href="/Public/jd/css/bootstrap3.min.css">
    <!-- 插件类 独立性 -->
    <link rel="stylesheet" href="/Public/jd/css/plugin.css">
    <link rel="stylesheet" href="/Public/jd/css/swiper-3.3.1.min.css">
    <!-- 所有页面类 -->
    <link rel="stylesheet" href="/Public/jd/css/chencc.css">
    <link rel="stylesheet" href="/Template/mobile/new/Static/css/main.css" type="text/css">
    <script src="/Public/jd/js/jquery.js"></script>
    <script src="/Public/jd/js/plugin.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/zui/1.5.0/js/zui.min.js"></script>
    <script src="/Public/jd/js/swiper-3.3.1.min.js"></script>
    <link href="/Public/ihtml/css/zui.min.css" rel="stylesheet">
<link href="/Public/ihtml/css/m.css" rel="stylesheet">
</head>
    <script type="text/javascript">
var headmenu_m;
$(function(){
	var H = $(window).innerHeight();
	$('.H').css('height', H + 'px');
	var H2 = $('body').height();
	$('.header_menu').css('height',H2 + 'px');
	
	var menu=1;
	$('.header_menu_i').click(function(){
		$('body').toggleClass('mobopen').css('overflow','');
		$('.a_search').removeClass('icon_close').addClass('icon_search');
		$('.header_search_box').hide();search_box=1;
		H2 = $('body').height();
		if(menu==1){
			$('.header_menu').css('height','0px');
			$('.header_menu').animate({height:H2 + 'px'},500);
			menu=2;
		}else{
			$('.header_menu').show().animate({height:'0px'},500);
			setTimeout(function(){
				$('.header_menu').css('display','')
			},500)
			menu=1;
		}
	});

	headmenu_m = function(a,b){
		if(!b) return;
		var heli = $(a).next('ul').find('li');
		var hez = heli.length * heli.height();
		
		if($(a).next('ul').height() == 0){
			$('.header_menu_1').find('ul').css('height','0px');
			$(a).next('ul').animate({height:hez + 'px'},500);
			$(a).parent().addClass('open');
		}else{
			$(a).next('ul').animate({height:'0px'},500)
			$(a).parent().removeClass('open');
		}
	}
$('.hide_this').click(function(){
	$('body').toggleClass('mobopen').css('overflow','');
	$('.a_search').removeClass('icon_close').addClass('icon_search');
	$('.header_search_box').hide();
	search_box=1;
	$('.header_menu').show().animate({height:'0px'},500);
	setTimeout(function(){
		$('.header_menu').css('display','')
	},500)
	menu=1;
})
	var search_box=1;
	$('.a_search').click(function(){
		$('body').removeClass('mobopen');menu=1;

		if(search_box==1){
			$('body').css('overflow','hidden');
			$(this).removeClass('icon_search').addClass('icon_close');
			$('.header_search_box').show().css('height','0px');
			$('.header_search_box').animate({height:H + 'px'},500);
			search_box=2;
		}else{
			$('body').css('overflow','');
			$(this).removeClass('icon_close').addClass('icon_search');
			$('.header_search_box').animate({height:'0px'},500);
			setTimeout(function(){
				$('.header_search_box').css('display','')
			},500)
			search_box=1;
		}
	});
})
</script>
<body class="bg-white1 bg-white">
    <div class="wrap" >
    <div class="header">
        <div class="header_menu_i"><span></span></div>
        <a href="<?php echo U('Index/index');?>" class="logo"></a>
        <div class="header_right"><a class="icon icon_search a_search">搜索</a><a href="<?php echo U('Cart/cart');?>" class="icon icon_cart">购物车
        <?php if(!empty($user)){ ?>
        <span id='cartGoods' class="label-danger"style="width:50%;"><?php echo ($countCartGoods); ?></span>
        <?php } ?>
        </a></div>
        <div class="header_menu H">
        	<div class="hide_this"></div>
        	<?php if(empty($user)){ ?><div class="go_login">欢迎登录诚享东方<a href="<?php echo U('user/login');?>">登录&nbsp;&gt;</a></div><?php } ?>
        	<?php if(!empty($user)){ ?>
        	   <div class="go_login"><i class="ccIcons-user2"></i><?php if(empty($user['nickname'])){echo $user['mobile'];}else{echo $user['nickname'];} ?><a class="out" href="<?php echo U('user/logout');?>">退出&nbsp;&gt;</a></div>
        	<?php } ?>
            
            <div class="header_menu_1">
                <a class="header_menu_m" href="<?php echo U('Index/index');?>" onClick="headmenu_m(this,false)">首页</a>
            </div>
             <div class="header_menu_1">
                <a class="header_menu_m" onClick="headmenu_m(this,true)">类别<span></span></a>
                <ul>
                   <?php if(is_array($cateList)): foreach($cateList as $key=>$cate): ?><li><a href="<?php echo U('goods/brandGoodsList');?>?cate_id=<?php echo ($cate["id"]); ?>"><?php echo ($cate["name"]); ?></a></li><?php endforeach; endif; ?>
                </ul>
            </div>
            <div class="header_menu_1">
                <a class="header_menu_m" href="<?php echo U('index/qualification');?>" onClick="headmenu_m(this,false)">经销商认证</a>
            </div>
            <div class="header_menu_1">
                <a class="header_menu_m" href="http://zhongguo12315.cn/hfs" onClick="headmenu_m(this,false)">防伪查询</a>
            </div>
            <div class="header_menu_1">
                <a class="header_menu_m" href="<?php echo U('article/articleList');?>" onClick="headmenu_m(this,false)">新闻资讯</a>
            </div>
            <?php if(empty($user)){ ?>
            <div class="header_menu_1">
                <a href="<?php echo U('user/reg');?>" class="header_menu_m" onClick="headmenu_m(this,false)">我要加盟</a>
            </div>
            <?php } ?>
        </div>
        <form id='sear' action="<?php echo U('goods/brandGoodsList');?>">
	        <div class="header_search_box H">
	            <div class="header_search_k"><input name="keyword" type="text" id='searkey' placeholder="输入关键字搜索"><button id='keyword' ><a class="icon icon_search">搜索</a></button></div>
	            <div class="header_search_hot">
	                <h3>热门搜索</h3>
	                <?php if(is_array($keywordList)): foreach($keywordList as $key=>$word): ?><a class="label label-badge label-primary" href="<?php echo U('goods/brandGoodsList');?>?keyword=<?php echo ($word["keyword"]); ?>"><?php echo ($word["keyword"]); ?></a><?php endforeach; endif; ?>
	            </div>
	        </div>
        </form>
    </div>
   </div>
<div style="height:60px;" ></div>
<div id="pageContent">
	<div class="z-pay centent_box">
		<?php if($must_add>0){ ?>
		<div class="z-pay-head"><i class=""></i></div>
		<p class="lead z-text-center">缴纳保证金</p>
		<p class="lead z-text-center">应付总金额：   ￥ <?php echo ($must_add); ?></p>
		<?php }else{ ?>
		<div class="z-pay-head"><i class=""></i></div>
		<p class="lead z-text-center">订单号：  <?php echo ($order["order_sn"]); ?></p>
		<p class="lead z-text-center">应付总金额：￥ <?php echo ($order["order_amount"]); ?></p>
		<?php } ?>
		<div>
			<div class="cv_div z-div">
				<i class="icon-pay-logo"></i>
				<?php if($user[u_type] == 1): ?><span>资金帐户<small class="text-muted">余额：<?php echo ($user["user_money"]); ?></small></span><?php endif; ?>
				<?php if($user[u_type] == 2): ?><span>资金帐户<small class="text-muted">余额：<?php echo ($finance["f_money"]); ?></small></span><?php endif; ?>
				<i class="icon-check-circle pull-right"></i>
			</div>
			<div class=" cv_div z-div"><i class="icon-pay-zfb"></i><span>支付宝</span><i class="icon-check-circle pull-right"></i></div>
			<!--<div class=" cv_div z-div"><i class="icon-pay-wx"></i><span>微信</span><i class="icon-check-circle pull-right"></i></div>-->
			<!--<div class=" cv_div z-div"><i class="icon-pay-yl"></i><span>银联</span><i class="icon-check-circle pull-right"></i></div>-->
		</div>
	</div>
	<div style="height:70px;"></div>
	<div class="z-footer">
		<div class="z-pay-footer">
			<?php if($must_add>0){ ?>
			<a href="<?php echo U('User/index');?>" class="btn btn-lg">延后付款 </a>
			<a id='pay_bzj' class="btn btn-lg btn-primary" style="margin-left:10px;">确认付款</a>
			<?php }else{ ?>
			<a href="<?php echo U('User/order_list');?>?type=WAITPAY" class="btn btn-lg">延后付款 </a>
			<a id='pay_now' class="btn btn-lg btn-primary" style="margin-left:10px;">确认付款</a>
			<?php } ?>
		</div>
	</div>
</div>

<div class="hide_black hide">
	<p class="payC"><a class="btn btn-success">支付完成</a></p>
</div>
<div class="modal fade" id="wxqr">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div style="text-align:center">
				<img src="">
				<p>请扫码支付</p>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="/Template/mobile/new/Static/js/wxpay.js"></script>
<script>
	var type = false;
	var _pay=false;
	$('.cv_div').on('click',function(){
		$('.cv_div').find('.icon-check-circle').removeClass('text-primary');
		$(this).find('.icon-check-circle').addClass('text-primary');
		type =$(this).index();
		/* 	console.log(type); */
	})
	$('#pay_bzj').on('click',function(){
	    if(_pay) return;
		var user_money = parseFloat("<?php echo ($user["user_money"]); ?>");
		var must_add = parseFloat("<?php echo ($must_add); ?>");
		var flag = true;
		var inwx = 0;
		if(type===false){
			$.toast({text:"请选择支付方式"});
			return;
		}
		if(type==0 && user_money<must_add){
			$.toast({text:"余额不足"});
			return;
		}
		$.post("<?php echo U('pay_bzj');?>",{must_add:must_add,type:type},function(data){
			console.log(data);
			if(data.status==1){
				$.toast({text:data.msg}); 
				setTimeout(jump_html(),5000);
			}else if(data.status==2){
				location.href=data.url;
			}else if(data.status==3)
			{
				if(inwx==0)
				{
					$('#wxqr').find('img').attr('src',data.wx);
					$('#wxqr').modal('show');
					return false;
				}
				else {
					WxPay.Pay(data.wx.appId, data.wx.timeStamp, data.wx.nonceStr, data.wx.package, data.wx.signType, data.wx.paySign, function (i) {
						if (i == "ok") {
							//Success
						} else {
							alert(i);
						}

					});
				}
				return;
			}
		})
		function jump_html(){
			location.href="<?php echo U('user/index');?>";
		}
		_pay=true
	})
	$('#pay_now').on('click',function(){
	    if(_pay) return;
		var user_money = parseFloat("<?php echo ($user["user_money"]); ?>");
		var pay_amount = parseFloat("<?php echo ($order["order_amount"]); ?>");
		var order_sn ="<?php echo ($order["order_sn"]); ?>";
		var flag = true;
		var inwx=0;
		if(type===false){
			$.toast({text:"请选择支付方式"});
			return;
		}
		if(type == 0 && user_money<pay_amount){
			$.toast({text:"余额不足"});
			return;
		}
		if(flag==true){
			flag = false;
			var ua = window.navigator.userAgent.toLowerCase();
			if(ua.match(/MicroMessenger/i) == 'micromessenger'){
				inwx=1;
			}else{
				inwx=0;
			}
			$.post("<?php echo U('pay_now');?>",{pay_amount:pay_amount,type:type,order_sn:order_sn,inwx:inwx},function(data){
				flag = true;

				if(data.status==1){
					$.toast({text:"付款成功"});
				}else if(data.status==2){
					location.href=data.url;
					console.log(data.url);
					return;
				}else if(data.status==3)
				{
//						$.toast({text:data.status});
					if(inwx==0)
					{
						console.log(data);
						$('#wxqr').find('img').attr('src',data.wx);
						$('#wxqr').modal('show');
						return false;
					}
					else
					{
						WxPay.Pay(data.wx.appId, data.wx.timeStamp, data.wx.nonceStr, data.wx.package, data.wx.signType, data.wx.paySign, function (i) {

							if (i == "ok") {
								//Success
							} else {
								alert(i);
							}

						});
					}
					return;
				}
				else{
					$.toast({text:data.msg});
					return;
				}
				setTimeout(jump_html(),5000);
			})
		}
		function jump_html(){
			location.href="<?php echo U('user/order_list');?>?type=WAITSEND";
		}
		_pay=true;
	})
	/*$(function(){
		var user_money =  parseFloat("<?php echo ($user["user_money"]); ?>");
		var flag = true;
		var inwx=0;
		$('#sure_pay').on('click',function(){
			var pay_amount = parseFloat("<?php echo ($order["order_amount"]); ?>");
			//	var ac_pay = $('#ac_pay').val();
			//console.log(type===false);
			console.log(user_money);
			console.log(pay_amount);
			if(type==0&&user_money<pay_amount){
				$.toast({text:"余额不足"});
				return;
			}
			if(type===false){
				$.toast({text:"请选择支付方式"});
				return;
			}
			/*   if(isNaN(ac_pay)){
			 $.toast({text:"请输入有效的金额"});
			 return;
			 }
			 */
			//if(pay_amount==0||!pay_amount){
				/* 	if(user_money<ac_pay){
				 $.toast({text:"账户余额不足"});
				 return;
				 } */
				/*var must_add = parseFloat("<?php echo ($must_add); ?>");
				$.post("<?php echo U('pay_bzj');?>",{must_add:must_add,type:type},function(data){
					console.log(data);
					if(data.status==1){
						$.toast({text:data.msg});   setTimeout(jump_html(),5000);
					}else if(data.status==2){
						location.href=data.url;
//						console.log(data.url);
					}else if(data.status==3)
					{
//						$.toast({text:data.status});
						if(inwx==0)
						{
//							console.log(data);
							$('#wxqr').find('img').attr('src',data.wx);
							$('#wxqr').modal('show');
							return false;
						}
						else
						{
							WxPay.Pay(data.wx.appId, data.wx.timeStamp, data.wx.nonceStr, data.wx.package, data.wx.signType, data.wx.paySign, function (i) {

								if (i == "ok") {
									//Success
								} else {
									alert(i);
								}

							});
						}
						return;
					}

				})
				return;
			}
			var order_sn ="<?php echo ($order["order_sn"]); ?>";*/
			/* 		var ac_pay = $('#ac_pay').val();

			 if(ac_pay>pay_amount){
			 ac_pay = pay_amount;
			 }
			 if(user_money<ac_pay){
			 $.toast({text:"账户余额不足"});
			 return;
			 }

			 if(ac_pay<pay_amount&&type<1){
			 $.toast({text:"选择付款方式"});
			 return;
			 } */
			/*if(flag==true){
				flag = false;
				var ua = window.navigator.userAgent.toLowerCase();
				if(ua.match(/MicroMessenger/i) == 'micromessenger'){
					inwx=1;
				}else{
					inwx=0;
				}
				$.post("<?php echo U('pay_now');?>",{pay_amount:pay_amount,type:type,order_sn:order_sn,inwx:inwx},function(data){
					flag = true;

					if(data.status==1){
						$.toast({text:"付款成功"});
					}else if(data.status==2){
						location.href=data.url;
						console.log(data.url);
						return;
					}else if(data.status==3)
					{
//						$.toast({text:data.status});
						if(inwx==0)
						{
							console.log(data);
							$('#wxqr').find('img').attr('src',data.wx);
							$('#wxqr').modal('show');
							return false;
						}
						else
						{
							WxPay.Pay(data.wx.appId, data.wx.timeStamp, data.wx.nonceStr, data.wx.package, data.wx.signType, data.wx.paySign, function (i) {

								if (i == "ok") {
									//Success
								} else {
									alert(i);
								}

							});
						}
						return;
					}
					else{
						$.toast({text:data.msg});

						return;
					}
					setTimeout(jump_html(),5000);
				})
			}
		})*/
		/*function jump_html(){
			location.href="<?php echo U('user/order_list');?>?type=WAITSEND";
		}*/
	//})
</script>
</body>
</html>