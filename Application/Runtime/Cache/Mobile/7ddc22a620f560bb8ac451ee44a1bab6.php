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
    <!-- banner -->
   <style>
   .ccFooter #btn1{border:1px solid #ccc;background:none;}
   </style>
   <!-- 详细 -->
    <div class="detail">
       <div class="swiper-container">
      <div class="swiper-wrapper">
      <?php if(is_array($goods_img)): foreach($goods_img as $key=>$img): ?><div class="swiper-slide">
           <!-- 这张图片不行太大了 -->
            <a href="javascript:void(0);"><img class="swiper-ccimg" src="<?php echo ($img["image_url"]); ?>" alt=""></a>
        </div><?php endforeach; endif; ?>

      </div>
      <div class="swiper-pagination"></div>
    </div>
        <div class="detail-text">
            <div class="detail-name"><?php echo ($goods["goods_name"]); ?></div>
            <div class="detail-money">单价：￥<?php echo ($total); ?></div>
        </div>
    </div>
    <!-- 卡片 -->
    <div class="cccard">
        <div class="cccard-title">规格</div>
        <div class="cccard-group">
            <?php if(is_array($spc)): foreach($spc as $key=>$vo): ?><input type="hidden" value="<?php echo ($goods["goods_id"]); ?>/<?php echo ($vo["key"]); ?>"><div class=" active cccard-btn" data-value="<?php echo ($vo[$price]); ?>"><?php echo ($vo["tmp"]); ?></div>
            
            <!--<div class="cccard-btn">100g</div>-->
            <!--<div class="cccard-btn">50g</div>-->
           
        </div><?php endforeach; endif; ?>
        <?php if($vo['store_count']>100){ ?>
            <div class="cccard-count">库存充足</div>
        <?php }else{ ?>
            <div class="cccard-count">库存紧张</div>
        <?php } ?>
        <div class="cccard-plus">
           <!--  <div class="cccard-plusDown">-</div> -->
          <!--   <div class="cccard-plusInput"> --><input type="number" style='border: 1px solid #ccc;' class='cccard-plusInput'  name='name' value='1' onkeyup="value =Number(value.replace(/[^\d]+/g,''))"><!-- </div> -->
           <!--  <div class="cccard-plusUp">+</div> -->
        </div>
    </div>
<!--     <div class="cccard">
        <div class="cccard-title">商品信息</div>
        <div class="cccard-item">
            <div class="cccard-nick">商品名称：</div>
            <div class="cccard-text"><?php echo ($goods['goods_name']); ?></div>
        </div>
        <div class="cccard-item">
            <div class="cccard-nick">商品属性：</div>
            <div class="cccard-text"><?php echo ($type); ?></div>
        </div>
        <div class="cccard-item">
            <div class="cccard-nick">规格：</div>
                <div class="cccard-text"><?php echo ($gui); ?></div>

        </div>
    </div> -->
    <div class="ccinfo">
        <div class="ccinfo-title">产品详情<div class="ccinfo-plus active"></div></div>
        <div class="ccinfo-list">
            <div class="ccinfo-listItem"><?php echo htmlspecialchars_decode($goods['goods_content']); ?></div>
            <!--<div class="ccinfo-listItem">这是详情~</div>-->
            <!--<div class="ccinfo-listItem">这是详情~</div>-->
        </div>
    </div>
    
    <!-- 放大图片 -->
    <style>
	.pinch-box{position:fixed;top:0;width:100%;padding:10px;background:#000;z-index:99;display:none;}
	</style>
    <div class="pinch-box">
    	<div class="pinch-zoom"><img src=""/></div>
    </div>
    
    <div style="height:60px;background:#fff;"></div>
    <div class="ccFooter">
        <a id="btn1" href="javascript:void(0);" class="ccFooter-btn">立即结算</a><a id="btn2" href="javascript:void(0);" class="ccFooter-btn active">加入购物车</a>
    </div>
     <form  action ="<?php echo U('cart/sure_buy');?>" method = 'POST'  id ='sure_but'>
        <input type='hidden' name='goods_id' id ='s_goods_id' value='<?php echo ($goods["goods_id"]); ?>' />
        <input type='hidden' name='goods_spec' id ='s_goods_spec' value='' />
        <input type='hidden' name='goods_num' id ='s_goods_num' value='' />
        <input type='hidden' name='buy_type' id ='s_buy_type'' value='1 '/>
     </form>
     <input type='hidden' name='login' id ='is_login' value='<?php echo ($is_login); ?>' />

<script src="/Public/jd/js/pinchzoom.js" ></script>
    <script>
        $(function(){
        	/* 图片放大 */
			$('.pinch-box').css('height',$(window).innerHeight() + 'px');
			$('.ccinfo-list img,.swiper-ccimg').on('click',function(){
				$('.pinch-box').show();
				$('.pinch-box img').attr('src',$(this).attr('src'));
				$('div.pinch-zoom').each(function () {
					new RTP.PinchZoom($(this), {});
				});
			})
			$('.pinch-box, .pinch-box img').on('click',function(){
				$('.pinch-box').hide();
                $('.pinch-box img').attr('src','');
			})
            
            var flag1=true;
            /* 立即结算 */
            $("#btn1").on("click",function(){
            	var is_login =$('#is_login').val();
                
                if(is_login==0){
                       $.toast({text:"请先登录"});
                       return;
                }
                if($(".cccard-btn.active").length==0){
                    $.toast({text:"请选择规格"});
                    return ;
                }
                var rule=$(".cccard-btn.active").prev().val();
                var count=$(".cccard-plusInput").val();
                var goods_id = rule.split('/')[0];
                var goods_spec = rule.split('/')[1];
                var goods_num = count;
                var all = "<?php echo ($vo['store_count']); ?>";
                all = parseInt(all);
                if(all<goods_num){
                    $.toast({text:'上级库存不足'});
                    return;
                } 
              
                if(isNaN(goods_num)||goods_num<=0){
                    $.toast({text:"商品数量错误"});
                    return;
                }
                if(flag1){
                   $('#s_goods_id').val(goods_id);
                   $('#s_goods_spec').val(goods_spec);
                   $('#s_goods_num').val(goods_num);
                   $('#sure_but').submit();
                   return;
                }
            });
            
            var flag2 = true;
            $("#btn2").on("click",function(){
            	var is_login =$('#is_login').val();
               
                if(is_login==0){
                    $.toast({text:"请先登录"});
                    return;
                }
                if($(".cccard-btn.active").length==0){
                    $.toast({text:"请选择规格"});
                    return ;
                }
                var rule=$(".cccard-btn.active").prev().val();
                var count=$(".cccard-plusInput").val();
                var goods_id = rule.split('/')[0];
                var goods_spec = rule.split('/')[1];
                var goods_num = count;
                var all = "<?php echo ($vo['store_count']); ?>";
                all = parseInt(all);
                if(all<goods_num){
                    $.toast({text:'上级库存不足'});
                    return;
                } 
              
               /*  var all = "<?php echo ($vo['store_count']); ?>";
                if(all<goods_num){
                    $.toast({text:'上级存款不足'});
                    return;
                } */
                if(isNaN(goods_num)||goods_num<=0){
                    $.toast({text:"商品数量错误"});
                    return;
                }
              
                if(flag2){
                    flag2=false;
                    $.ajax({
                        type:"post",
                        url:"<?php echo U('Cart/addCart');?>",
                        data:{style:2,goods_id:goods_id,goods_spec:goods_spec,goods_num:goods_num},
                        success:function(res){
                        
                            var data = JSON.parse(res);
                            console.log(data);
                            if(data.status==1){
                                $.toast({text:data.msg});
                                $('#cartGoods').text(data.countCartGoods);
                                /* $(".ccslider").removeClass("active").fadeOut("fast");
                                $('.header').show(); */
                            }
                            flag2=true;
                        },
                        error:function(){
                            flag2=true;
                        }
                    });
                }
            });
        	/* banner */
            var mySwiper = new Swiper('.swiper-container', {
                autoplay: 5000,
                pagination : '.swiper-pagination',
                loop : true,
            });
            /* 产品详细 */
            $(".ccinfo-plus").on("click",function(){
                if($(this).hasClass("active")){
                    $(this).removeClass("active");
                    $(".ccinfo-list").slideUp();
                }else {
					$(this).addClass("active");
                    $(".ccinfo-list").removeClass('hidden').slideDown();
                }
            });
            /* 规格 */
            $(".cccard-btn").on("click",function(){
               $(".cccard-btn").removeClass("active");
                $(this).addClass("active");
                
                var value=$(this).data("value");
                console.log(value);
                value="￥"+parseInt(value).toFixed(2);
                $(".detail-money").text(value);
                $(".cccard-plusInput").val(1);
            });
            /* 规格 加减 */
            $(".cccard-plusDown").on("click",function(){
                var num=parseInt($(".cccard-plusInput").val()); 
                if(num<=0){
                    return ;
                }
                num--;
                $(".cccard-plusInput").val(num);
                var value=parseInt($(".cccard-btn.active").data("value"));
                if(num==0){
                    num=1;
                }
              /*   value=num*value;
                $(".detail-money").text("￥"+value.toFixed(2)); */

            });
            $(".cccard-plusUp").on("click",function(){
                if($(".cccard-btn.active").length==0){
                    $.toast({text:"请选择规格",class:"toast-danger"});
                    return;
                }
                var num=parseInt($(".cccard-plusInput").val()); 
                num++;
                $(".cccard-plusInput").val(num);
                var value=parseInt($(".cccard-btn.active").data("value"));
              /*   value=num*value;
                $(".detail-money").text("￥"+value.toFixed(2)); */
            });              
        });
        
           
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    </script>
</body>
</html>