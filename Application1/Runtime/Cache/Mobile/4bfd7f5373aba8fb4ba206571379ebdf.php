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
        	   <div class="go_login"><i class="ccIcons-user"></i><?php if(empty($user['nickname'])){echo $user['mobile'];}else{echo $user['nickname'];} ?><a class="out" href="<?php echo U('user/logout');?>">退出&nbsp;&gt;</a></div>
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
<div style="height:50px;" ></div>
<div id="pageContent">
<form id='bulid' action="<?php echo U('bulid_order');?>" method='POST'>
	<div class="centent_box z-order_confirm clearfix">
		<div class="z-div col-xs-12">订单金额<span class="pull-right" style="color:#000">￥<?php echo ($count); ?></span></div>
		<input type='hidden'  value="<?php echo ($count); ?>" name="count" />
		<input class='is_cart' type='hidden' value='<?php echo ($cart); ?>' name="is_cart"/>
		<div class="z-div col-xs-12 z-shopa"><a>订单备注<i class="icon-chevron-right pull-right"></i></a>
        	<div class="z-shop_list_box">
            	<div class="z-remark"><textarea name='mark' id='mark' class="form-control" rows="3" placeholder="可以输入多行文本"></textarea></div>
            </div>
        </div>
        
        <div class="z-div col-xs-12 z-shopa open"><a>商品清单<i class="icon-chevron-right pull-right"></i><i class="icon-chevron-down pull-right"></i></a>
        	<div class="z-shop_list_box">
        	<?php if(is_array($goodsList)): foreach($goodsList as $key=>$goods): ?><div class="z-order-dllist z-cart-box">
                    <div class="z-cart-p clearfix">
                        <div class="z-cart-p_img col-xs-4"><img class="img-responsive" src="<?php echo ($goods["original_img"]); ?>"></div>
                        <div class="z-cart-p-content col-xs-8">
                            <h3 class="z-p-name text-ellipsis"><?php echo ($goods["goods_name"]); ?></h3>
                            <p class="z-p-spec"><strong>规格：</strong><span><?php echo ($goods["specname"]); ?></span></p>
							 <div class="text-muted">数量：<input type="text" value="<?php echo ($goods["number"]); ?>" class="number"></div>
							<input type="hidden" class="stock" value="<?php echo ($goods["stock"]); ?>">
                            <p class="z-p-price text-info">￥<?php echo ($goods["price"]); ?></p>
                        </div>
                    </div>
                </div>
                <input type='hidden' name="goods_info[]" value="<?php echo ($goods["goods_id"]); ?>/<?php echo ($goods["spec_key"]); ?>/<?php echo ($goods["number"]); ?>" /><?php endforeach; endif; ?>
            </div>
        </div>
		<div class="z-div col-xs-12 z-shopa"><a>收货信息<i class="icon-chevron-right pull-right"></i><i class="icon-chevron-down pull-right"></i></a>
        	<div class="z-shop_list_box z-shop_consignee">
			<?php if(is_array($addressList)): foreach($addressList as $key=>$add): ?><div class="content text-muted consignee <?php if($add['is_default']==1){ echo 'active'; } ?>">
                    <div class="clearfix">
                        <div class="col-xs-6">收货人：<?php echo ($add["consignee"]); ?></div><div class="col-xs-2"></div><div class="col-xs-4"><?php echo ($add["mobile"]); ?></div>
                        <div class="col-xs-12"><?php echo ($add["re_address"]); ?></div>
                        <span style="display:none"><?php echo ($add["address_id"]); ?></span>
                    </div>
                </div><?php endforeach; endif; ?>
            </div>
		</div>
	</div>

<div style="height:60px;" ></div>

	<div class="z-footer">
		<div class="col-xs-12 z-order-footrt">
			<div class="col-xs-7">应付金额：<strong class="text-primary">￥<?php echo ($count); ?></strong></div>
			<a id='submit' class="btn btn-primary pull-right">提交订单</a>
		</div>
	</div>
	 <input  class='ddd'  type='hidden' name='address_id' value="<?php echo ($address["address_id"]); ?>"/>
</form>
</div>
<!--<div class="toast"><div class="toast-content"></div></div>-->
<script src="/Public/ihtml/js/zui.min.js"></script>
<script>
$('.z-shopa a').on('click',function(){
	if($(this).parent().hasClass('open')){
		$(this).parent().removeClass('open');
	}else{
		$(this).parent().addClass('open');
	}
})
$('.z-shop_consignee > div').on('click',function(){
	$('.z-shop_consignee > div').removeClass('active');
	$(this).addClass('active');
	var address_id = $(this).find('div span').text();
	$('.ddd').val(address_id);
})
$(function(){
	$('#submit').on('click',function(){
		var num = $('#is_login').val();
		var number = Number($('.number').val());
		var stock = Number($('.stock').val());
		if (number > stock){
			$.toast({text:"所选商品库存不足"});
			return;
		}else{
			$('#bulid').submit();
		}

	})
})
</script>
</body>
</html>