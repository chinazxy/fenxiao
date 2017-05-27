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

<body class="bg_white">
<div class="wrap" style="display:block;">
	<!--头部-->
    <style>.wrap{padding-top:50px;display:none;}.wrap.fot{DISPLAY:BLOCK;}</style>
    <div class="header2">
    	<a><i onClick="history.go(-1)"></i><span></span></a>
        <a class="head_preserve">保存</a>
        <p>我的帐号</p>
    </div>
    <div id="pageContent">
    <form action='' method="post" class="userform" enctype="multipart/form-data">
      <div class="centent_box haha_w z-myuser">
        <div class="z-div background_none clearfix z-myuser-photo">
            <div class="col-xs-4">头像</div>
            <?php if(user.head_pic != ''): ?><div class="col-xs-3  pull-right"><img id="cover" src="/<?php echo ($user["head_pic"]); ?>" width="35" height="35" class="img-circle"></div>
        		<?php else: ?>
        		<div class="col-xs-3  pull-right"><img id="cover" src="/Template/mobile/new/Static/images/user68.jpg" width="35" height="35" class="img-circle"></div><?php endif; ?>
            
            <input style="display:none" id="file1" type="file" name='photo1' />
        </div>
        <div class="z-div background_none clearfix">
            <div class="col-xs-4">昵称</div>
            <div class="col-xs-8  pull-right">
			<?php if($user["is_change"] == 0): ?><input class="form-control" name="nickname" type="text" value="<?php echo ($user["nickname"]); ?>" placeholder="请输入昵称" ><?php endif; ?>
			<?php if($user["is_change"] == 1): ?><input class="form-control" name="nickname" type="text" value="<?php echo ($user["nickname"]); ?>" placeholder="请输入昵称" disabled><?php endif; ?>
			</div>
        </div>

        <div class="z-div background_none clearfix">
            <div class="col-xs-4">真实姓名</div>
			<?php if($user["is_change"] == 0): ?><div class="col-xs-8  pull-right"><input class="form-control" name="username" type="text" value="<?php echo ($user["username"]); ?>" placeholder="请输入姓名" disabled></div><?php endif; ?>
			<?php if($user["is_change"] == 1): ?><div class="col-xs-8  pull-right"><input class="form-control" name="username" type="text" value="<?php echo ($user["username"]); ?>" placeholder="请输入姓名" disabled></div><?php endif; ?>
        </div>
        <div class="z-div background_none clearfix">
            <div class="col-xs-4">手机</div>
            <div class="col-xs-8  pull-right"><input class="form-control" name="mobile" type="text" value="<?php echo ($user["mobile"]); ?>" placeholder="请输入手机号码" disabled></div>
        </div>

        <div class="z-div background_none clearfix">
            <div class="col-xs-4">邮箱</div>
            <div class="col-xs-8  pull-right"><input class="form-control" name="email" type="text" value="<?php echo ($user["email"]); ?>" placeholder="请输入邮箱地址"></div>
        </div>
        <div class="z-div background_none clearfix">
        <div class="col-xs-4">代理地区</div>
        <div class="col-xs-8  pull-right"><input name='country' value='1' type="hidden">
                 <select class="province_select"  name="province" id="province" >
                      <option value="0">请选择</option>
                        <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><option <?php if($user['province'] == $p['id']): ?>selected<?php endif; ?>  value="<?php echo ($p["id"]); ?>"><?php echo ($p["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                 </select>
                <select name="city" id="city" >
                    <option  value="0">请选择</option>
                    <?php if(is_array($city)): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><option <?php if($user['city'] == $p['id']): ?>selected<?php endif; ?>  value="<?php echo ($p["id"]); ?>"><?php echo ($p["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select></div>
		</div>
        <div class="z-div background_none border_bottom clearfix">
            <div class="col-xs-12">个人简介</div>
            <div class="col-xs-12 "><textarea name="my_desc" class="form-control" rows="3" placeholder="请输入个人简介" style="margin-top:8px;"><?php echo ($user["my_desc"]); ?></textarea></div>
        </div>
      </div>
    </form>
    <div class="cancel"><a href="<?php echo U('User/logout');?>" class="btn btn-lg btn-block btn-danger">注销</a></div>
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
		   $('#province').on('change',function(){
	           var pro = $(this).val();
	           if(pro==1||pro==338||pro==10543||pro==31929||pro==0){
	               $('#city').hide();
	               $('#city').empty();
	               return;
	           }
	           $.get("<?php echo U('get_city');?>",{province:pro},function(data){
	               $('#city').empty();
	               $('#city').show();
	               $('#city').append("<option value='0'>请选择</option>");
	               $.each(data,function(k,v){
	                   $('#city').append("<option value='"+v.id+"'>"+v.name+"</option>");
	               })
	           })
	       })
			$('#file1').change(function(){
			$('#cover').attr('src','');
					var files = !!this.files ? this.files : [];
			var reader = new FileReader();
			
			// 将本地文件给DataURL
			reader.readAsDataURL(files[0]);
			reader.onloadend = function () {$('#cover').attr('src',this.result);}
			})	
			$('#cover').click(function(){
				$('#file1').click();
			});
			$('.head_preserve').click(function(){
				$('.userform').submit();
			})
})
</script>
</body>
</html>