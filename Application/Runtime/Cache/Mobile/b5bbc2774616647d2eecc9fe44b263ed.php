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
   <!-- banner -->
<style>
.swiper-container{padding-top:50px;}
</style>
    <div class="swiper-container">
      <div class="swiper-wrapper">
    
       <?php if(is_array($bannerImg)): foreach($bannerImg as $l=>$b): ?><div class="swiper-slide">
           <!-- 这张图片不行太大了 -->
            <a href="<?php echo ($bannerLink[$l]); ?>"><img class="swiper-ccimg" src="<?php echo ($b); ?>" alt=""></a>
        </div><?php endforeach; endif; ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
    <!-- menu -->
    <div class="ccmenu">
       <?php if(is_array($thems)): foreach($thems as $key=>$t): ?><a  href="<?php echo U('Goods/brandGoodsList');?>?id=<?php echo ($t["id"]); ?>" class="ccmenu-item"><?php echo ($t["name"]); ?></a><?php endforeach; endif; ?>
    </div>
    <!-- 商品 -->
    <div class="ccshop">
        <div class="ccshop-menu">
            <div style='font-size:15px;' class="ccshop-title">畅销产品<!-- <span class="ccshop-subTitle"><?php echo ($count); ?></span> --></div>
            <!--<div id="ccshopBtn" class="ccshop-icon icons icons-list-o"></div>-->
        </div>
       <?php if(is_array($hot_goods)): foreach($hot_goods as $key=>$hot): ?><div class="ccshop-item">
        <a href="<?php echo U('Mobile/Goods/productDetails');?>?id=<?php echo ($hot["goodsid"]); ?>"><img class="ccshop-img" src="<?php echo ($hot["original_img"]); ?>" alt=""></a>
            <div class="ccshop-content">
                <div class="ccshop-name"><?php echo ($hot["goods_name"]); ?></div>
                <div class="ccshop-info">
                    <div class="ccshop-text"><span class="ccshop-type"><?php echo ($hot["spec"]); ?></span>种规格可选</div>
                    <div class="ccshop-text">库存：<span class="ccshop-count"><?php echo ($hot["store_count"]); ?></span></div>
                </div>
                <div class="ccshop-status">
                    <div class="ccshop-money">￥<?php echo ($hot["price"]); ?></div>
                    <div class="ccshop-car icons icons-car"></div><input type='hidden' value='<?php echo ($hot["goods_id"]); ?>'/>
                </div>
            </div>
        </div><?php endforeach; endif; ?>
        
    </div>
    <!-- 加载更多 -->
    <div class="load">
        <div class="load-content">
            <div class="load-download icons icons-download"></div>
            <div class="load-text">加载更多</div>
        </div>
    </div>
    
    <!-- 新闻 -->
    <div class="z-news ccshop active">
    	<div style="font-size:15px;margin:0 2%;color:#333;padding:10px 0;border-bottom:1px solid #ccc;" class="ccshop-title">新闻资讯<a href="<?php echo U('Article/articleList');?>" class="pull-right small" style=" line-height:25px;">更多资讯&gt;</a></div>
    	 <?php if(is_array($article)): foreach($article as $key=>$ar): ?><div class="ccshop-item">
         <a href="<?php echo U('Article/article');?>?article_id=<?php echo ($ar["article_id"]); ?>">
            <img class="ccshop-img" src="<?php echo ($ar["thumb"]); ?>" alt="">
            <div class="ccshop-content">
                <h3 class="text-ellipsis"><?php echo ($ar["title"]); ?></h3>
                <p><?php echo date('Y-m-d',$ar['publish_time']); ?></p>
            </div>
         </a>
        </div><?php endforeach; endif; ?>
    </div>
    
    <!-- 二维码 -->
    <div class="qrcode">
        <img class="qrcode-img" src="/Public/jd/img/qrcode.jpg" alt="">
    </div>
    <!-- 公司详细 -->
    <div class="company">
        <a href="<?php echo U('article/index');?>" class="company-item no-line">品牌故事</a>
        <?php if(empty($user)){ ?><a href="<?php echo U('user/reg');?>" class="company-item">我要加盟</a><?php } ?>
        <a href="<?php echo U('index/qualification');?>" class="company-item">经销商认证</a>
        <a href="http://zhongguo12315.cn/hfs" class="company-item">防伪查询</a>
    </div>
    <!-- 联系方式 -->
    <div class="ccaddress">
        <div class="ccaddress-text">联系我们：<?php echo ($web_config["phone"]); ?></div>
		<div class="ccaddress-text">客服电话:<?php echo ($web_config["tel"]); ?>&nbsp;&nbsp;客服微信:<?php echo ($web_config["wechat"]); ?></div>
        <div class="ccaddress-text"><?php echo ($web_config["address"]); ?></div>
        <div class="ccaddress-copyright"><?php echo ($web_config["record_no"]); ?></div>
    </div>
    <div style="height:2px;"></div>
    <!-- 侧边栏 -->
    <div class="ccslider">
        <div class="ccslider-content">
            <div class="ccslider-shop">
               <div class="ccslider-imgBox">
               <a class='ccslider-link' href="javascript:void(0);">    <img class="ccslider-img" src="/Public/jd/img/shop.jpg" alt=""></a>
               </div>
                <div class="ccslider-title ts">
                   <!--  <div class="ccslider-num">货号：获取失败</div> -->
                    <div class="ccslider-name">获取失败</div>
                    <div class="ccslider-money">￥0.00</div>
                </div>
                <div class="ccslider-closeBox">
                    <div class="ccslider-close icons icons-close"></div>
                </div>
            </div>
            <div class="ccslider-rule">
                <div class="ccslider-ruleTitle">规格</div>
                <div class="ccslider-group">
                    
                </div>
                <div class="ccslider-ruleTitle">数量<span>(库存 <span class="ccslider-count"></span>)</span></div>
                <input type='hidden' id='countss' value='' />
                <div class="ccslider-plus">
                    <div class="ccslider-plusBtn ccslider-plusDown">-</div>
                    <div class="ccslider-plusInput">1</div>
                    <div class="ccslider-plusBtn ccslider-plusUp">+</div>
                </div>
            </div>
            <div class="ccslider-sales">
                <div id="sale1" class="ccslider-salesBtn">立即结算</div>
                <div id="sale2" class="ccslider-salesBtn active">加入购物车</div>
            </div>
        </div>
    </div>

<script>
//用js处理rem字

(function() {
	//当设备的方向变化（设备横向持或纵向持）此事件被触发。绑定此事件时，
	//注意现在当浏览器不支持orientationChange事件的时候我们绑定了resize 事件。
	//总来的来就是监听当然窗口的变化，一旦有变化就需要重新设置根字体的值
	resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
		recalc = function() {
			var docEl = document.body;
			//设置根字体大小
			var fontSize = 40 * (docEl.clientWidth / 640) + 'px';
			$('.ccshop-item').css('font-size',fontSize);
		};
	window.addEventListener(resizeEvt, recalc, false);
	document.addEventListener('DOMContentLoaded', recalc, false);

	window.rem_clean = function() {
		window.removeEventListener(resizeEvt, recalc, false);
		document.removeEventListener('DOMContentLoaded', recalc, false);
	}
})(window)
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
     <form  action ="<?php echo U('cart/sure_buy');?>" method = 'POST'  id ='sure_but'>
     	<input type='hidden' name='goods_id' id ='s_goods_id' value='' />
        <input type='hidden' name='goods_spec' id ='s_goods_spec' value='' />
        <input type='hidden' name='goods_num' id ='s_goods_num' value='' />
        <input type='hidden' name='buy_type' id ='s_buy_type'' value='1	'/>
     </form>
    <input type='hidden' name='login' id ='is_login' value='<?php echo ($is_login); ?>' />



    <script>
        $(function(){
        	var page = 1;
            /* banner */
            var mySwiper = new Swiper('.swiper-container', {
                autoplay: 5000,
                pagination : '.swiper-pagination',
                loop : true,
            });
           /* 商店 切换形态 */
            $("#ccshopBtn").on("click",function(){
                if($(this).hasClass("icons-list-o")){
                    $(this).removeClass("icons-list-o").addClass("icons-list");
                    $(".ccshop").addClass("active");
                }else {
                    $(this).removeClass("icons-list").addClass("icons-list-o");
                    $(".ccshop").removeClass("active");
                }
            });
            /* 购物车 */
            $(".ccshop-car").on("click",showSlider);
            function showSlider(){
            	var goods_id = $(this).next().val();
            	var $ccshopItem=$(this).parent().parent().parent();
                var is_login =$('#is_login').val();
                console.log(is_login);
                if(is_login==0){
                	$.toast({text:"请先登录"});
                	return;
                }
            	$('.ccslider-group').empty();
            	$.get("<?php echo U('Goods/goodsInfo');?>",{id:goods_id,ajax:1},function(data){
            		
            		$('.ccslider-link').attr("href","<?php echo U('Mobile/Goods/productDetails');?>?id="+data.goods.goodsid);
            		
            		var res = data.spec;
            		var ccslidergroup = $('.ccslider-group');
            	 	$.each(res,function(i,x){
            			//  $('.ts').text('规格');
            			  
            			  if(i==0){
            				   ccslidergroup.append(" <input type='hidden' value='"+x.goods_id+"/"+x.key+"'><div class='ccslider-btn active'>"+x.key_name.split(':')[1]+"</div><input type='hidden' value='"+x.price+"'>");
            			  }else{
            				   ccslidergroup.append(" <input type='hidden' value='"+x.goods_id+"/"+x.key+"'><div class='ccslider-btn'>"+x.key_name.split(':')[1]+"</div><input type='hidden' value='"+x.price+"'>");
            			  }
            			  var tmp = '';
            			  if(x.store_count>100){
            				  tmp ='库存充足';
            			  }else{
            				  tmp ='库存紧张';
            			  }
            			  
            			  $('#countss').val(x.store_count);
            			  $(".ccslider-count").text(tmp);
            			  $(".ccslider-btn").on("click",btnClick);
            		  }) 
            		
            	})
             
                $('.header').hide();
                $('.wrap').hide();
                var ccshopImg=$ccshopItem.find(".ccshop-img").attr("src");
                var ccshopName=$ccshopItem.find(".ccshop-name").text();
                var ccshopMoney=$ccshopItem.find(".ccshop-money").text();
                var ccshopType=$ccshopItem.find(".ccshop-type").text();
                
                
                /* 填充数据 */
                $(".ccslider-img").attr("src",ccshopImg);
                $(".ccslider-name").text(ccshopName);
                $(".ccslider-money").text(ccshopMoney);
                
                /* 每次都初始化为1 */
                $(".ccslider-plusInput").text(1);
                $(".ccslider").fadeIn("fast").addClass("active");
            }
            /* 侧边栏 */
            $(".ccslider-close").on("click",function(){
                $(".ccslider").removeClass("active").fadeOut("fast");
                $('.header').show();
                $('.wrap').show();
            });
            $(".ccslider-plusDown").on("click",function(){
                var num=parseInt($(".ccslider-plusInput").text().trim());
                if(num<=1){
                    $.toast({text:"无法在减少了"});
                    return;
                }
                num--;
                $(".ccslider-plusInput").text(num);
            });
            $(".ccslider-plusUp").on("click",function(){
                var num=parseInt($(".ccslider-plusInput").text().trim());
                num++;
                $(".ccslider-plusInput").text(num);
            });
           /*  $(".ccslider-btn").on("click",btnClick); */
            function btnClick(){
            	$(".ccslider-btn").removeClass("active");
                $(this).addClass("active");
                $('.ccslider-money').text("￥"+$(this).next().val());
            }
            /* 加载更多 */
            $(".load-download").on("click",function(){
                $.get("<?php echo U('more_hot');?>",{page:page},function(data){
                    if(data.status==1001){
                        $.toast({text:data.data});
                        $(".load-download").hide();
                        $('.load-text').text('');
                    }else if(data.status==1000){
                        page++;
                        console.log(data.data);
                        createCcshopItem(data.data);
                    }
                })
            });
            function createCcshopItem(arrs){
                arrs.map(function(res,num){
                    var $item=$("<div />",{class:"ccshop-item"});
                    var $link = $("<a />",{href:"<?php echo U('Mobile/Goods/productDetails');?>?id="+res.goods_id});
                    var $img=$("<img />",{class:"ccshop-img",src:res.original_img});
                    var $content=$("<div />",{class:"ccshop-content"});
                    var $name=$("<div />",{class:"ccshop-name",text:res.goods_name});
                    var $info=$("<div />",{class:"ccshop-info"});
                    var $text1=$("<div />",{class:"ccshop-text"});
                    var $span1=$("<span />",{class:"ccshop-type",text:res.spec+"种规格可选"});
                    var $text2=$("<div />",{class:"ccshop-text",text:"库存"});
                    var $span2=$("<span />",{class:"ccshop-count",text:res.store_count});
                    var $status=$("<div />",{class:"ccshop-status"});
                    var $money=$("<div />",{class:"ccshop-money",text:"￥"+res.price});
                    var $car=$("<div />",{class:"ccshop-car icons icons-car"});
                    var $goods_id = $("<input />",{class:'',type:'hidden',value:res.goods_id});
                    var $kucun = $("<input />",{class:'ccshop-cukun',type:'hidden',value:res.store_count});
                    $car.on("click",showSlider);
                    $status.append($money,$car,$goods_id,$kucun);
                    $text2.append($span2);
                    $text1.append($span1);
                    $info.append($text1,$text2);
                    $content.append($name,$info,$status);
                    $link.append($img);
                    $item.append($link,$content);
                    $(".ccshop").append($item);
                   
                });  
            }
            
            var flag1=true;
            var flag2=true;
            /* 立即结算 */
            $("#sale1").on("click",function(){
                if($(".ccslider-btn.active").length==0){
                    $.toast({text:"请选择规格"});
                    return ;
                }
                var name=$(".ccslider-name").text();
                var money=$(".ccslider-money").text();
                var rule=$(".ccslider-btn.active").prev().val();
                var count=$(".ccslider-plusInput").text();
                var goods_id = rule.split('/')[0];
                var goods_spec = rule.split('/')[1];
                var goods_num = count;
                var all = parseInt($('#countss').val());
               
                if(all<goods_num){
                    $.toast({text:'上级库存不足'});
                    return;
                }
                console.log(goods_id);
                console.log(goods_spec);
                console.log(goods_num);
                if(flag1){
                   $('#s_goods_id').val(goods_id);
                   $('#s_goods_spec').val(goods_spec);
                   $('#s_goods_num').val(goods_num);
                   $('#sure_but').submit();
                   return;
                }
            });
            /* 加入订单 */
            $("#sale2").on("click",function(){
                if($(".ccslider-btn.active").length==0){
                    $.toast({text:"请选择规格"});
                    return ;
                }
                var name=$(".ccslider-name").text();
                var money=$(".ccslider-money").text();
                var rule=$(".ccslider-btn.active").prev().val();
                var count=$(".ccslider-plusInput").text();
                var info={
                    Name:name,
                    Money:money,
                    Rule:rule,
                    Count:count
                };
                var goods_id = rule.split('/')[0];
                var goods_spec = rule.split('/')[1];
                var goods_num = count;
                var all = parseInt($('#countss').val());
                
                if(all<goods_num){
                	
                	$.toast({text:'上级库存不足'});
                
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
                            	$('#cartGoods').text(data.countCartGoods);
                            	$.toast({text:data.msg});
                            	/* $(".ccslider").removeClass("active").fadeOut("fast");
                                $('.header').show(); */
                            }else{
                            	$.toast({text:data.msg});
                            }
                        	flag2=true;
                        },
                        error:function(){
                            flag2=true;
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>