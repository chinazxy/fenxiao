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
    <div style="height:60px;"></div>
    <div class="cart">
      <?php if(is_array($cartList)): foreach($cartList as $key=>$cart): ?><div class="product_list1"  style="border-bottom:1px solid ;">
            <div class="product_box">
                <div class="product_box_img"><img src="<?php echo ($cart["original_img"]); ?>"/></div>
                <div class="name"><?php echo ($cart["goods_name"]); ?></div>
                <div class="spec"><i><?php echo ($cart["key_name"]); ?></i><span class="stock">库存：
               <?php if($cart['store']>100){ ?> 
                                       库存充足
                <?php }else{ ?>
                                       库存紧张 
                <?php } ?>
                </span></div>
                <div class="price">￥<?php echo ($cart["member_goods_price"]); ?></div>
            </div>
            <div class="cart_btn" style='border:none;'>
                <span class="cart_btn_a"><i></i><span>删除</span></span><input class='delet' type='hidden' value='<?php echo ($cart["id"]); ?>' name="delet"/>
				<div class="f-right goods_info">单位(件)<input  type='hidden' value='<?php echo ($cart["spec_key"]); ?>/<?php echo ($cart["goods_id"]); ?>'><input class='number' name="" type="text" value='<?php echo ($cart["goods_num"]); ?>'onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"><input class='prices' type='hidden' value='<?php echo ($cart["member_goods_price"]); ?>'></div>
            </div>
        </div><?php endforeach; endif; ?>
       <?php if(empty($cartList)){ ?>
       <p class="text-center wu">购物车内暂时没有产品</p>
       <?php } ?>
    </div>
    
    
    
    <div class="cart_footer">
        <div class="cart_footer_left">
            <span class="cart_footer_left_n goods_number">商品：<?php echo ($goods_count); ?></span>
            <span class="cart_footer_left_n z-color-main">&nbsp;&nbsp;&nbsp;合计：<span class="total">￥<?php echo ($priceCount); ?>元</span></span>
        </div>
        <a  class="m_btn f-right">下单</a>
        
        <form  action="<?php echo U('Cart/sure_buy');?>" method='POST' id='sure_buy'>
            <input type='hidden' value="2" name="buy_type" />
			<input type='hidden' value="is_cart" name="is_cart">
        </form>
    </div>
</div>

<script type="text/javascript">
var H = document.body.clientHeight;
$('.H').css('height', H + 'px');

$('.menu').click(function(){
    $(this).toggleClass('on');
})
$(function(){
	$('.number').on('change',function(){
		if($(this).val()==0){
			 $.toast({text:"商品数量不能为0"});
			 return;
		}
		var fright = $('.goods_info');
		var count = 0;
		var gcount = 0;
		fright.each(function(){
			var num = $(this).find('.number').val();
			var price = $(this).find('.prices').val();
			count += (num*price);
			gcount = Number(num)+Number(gcount);
		})
		$('.cart_footer_left_n').text()
		$('.total').text("￥"+count+"元");
		$('.goods_number').text("商品："+gcount);
		var rule = $(this).prev().val();
		var goods_id = rule.split('/')[1];
        var goods_spec = rule.split('/')[0];
		var goods_num = $(this).val();
		
        $.ajax({
            type:"post",
            url:"<?php echo U('Cart/addCart');?>",
            data:{goods_id:goods_id,goods_spec:goods_spec,goods_num:goods_num},
            success:function(res){
            	console.log(res);
                var data = JSON.parse(res);
                if(data.status==1){
                	 $.toast({text:data.msg});
                }else{
                	$.toast({text:data.msg});
                }
                flag2=true;
            },
            error:function(){
                flag2=true;
            }
        });
	})
	
	function  sure_remove(){
		if(window.confirm('确定要删除购物车商品么？')){
            return true;
         }else{
            return false;
            }
	}
	$('.cart_btn_a').on('click',function(){
		var t = sure_remove();

	    if(!t){
	    	return;
	    }
		var self = $(this);
		var car_id = $(this).next().val();
		$.post("<?php echo U('remove_cart');?>",{id:car_id},function(data){
			if(data.status==1){
				self.parents('.product_list1').remove();
				var fright = $('.goods_info');
		        var count = 0;
		        var gcount = 0;
		        fright.each(function(){
		            var num = $(this).find('.number').val();
		            var price = $(this).find('.prices').val();
		            count += (num*price);
		            gcount = Number(num)+Number(gcount);
		        
		        })
		        $('.cart_footer_left_n').text()
		        $('.total').text("￥"+count+"元");
		        $('.goods_number').text("商品："+gcount);
		        $.toast({text:"删除成功"});
		        location.reload()
			}
		})
	})
	
	$('.m_btn').on('click',function(){
		  var fright = $('.goods_info');
		  console.log(fright);
		  if(fright.length==0){
			  return;
		  }
		  var k = true;
		  var t = $('.product_list1');
		  $.each(t,function(i,x){
			  var buy_num = $('.number').eq(i).val();
			  var all_num = $('.stock').eq(i).text();
			  buy_num = parseInt(buy_num);
			  all_num = parseInt(getNum(all_num));
			  if(buy_num>all_num){
				  $.toast({text:"购买商品数量不可超过库存"});
				  k = false;
				  return;
			  }
		  })
		  if(k==false){
			  return;
		  }
		  $('#sure_buy').submit();
		//top.location.href="<?php echo U('cart2');?>";
	})
	function getNum(text){
		var value = text.replace(/[^0-9]/ig,""); 
		return value;
		}
})
</script>
</body>
</html>