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
<div style='height:60px;'></div>
<link rel="stylesheet" href="/Template/mobile/new/Static/css/public.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/user.css">

<div class="centent_box z-myuser">
  <form id='subm' action="<?php echo U('Mobile/User/add_address');?>" method="post" >
	<div class="z-div clearfix">
		<div class="col-xs-4">收货人姓名</div>
		<div class="col-xs-8  pull-right"><input name="consignee" id="consignee" type="text" value="<?php echo ($address["consignee"]); ?>" maxlength="12" placeholder="收货人姓名"/></div>
	</div>
    <div class="z-div clearfix">
		<div class="col-xs-4">地区</div>
		<div class="col-xs-8  pull-right"><input name='country' value='1' type="hidden">
	             <select class="province_select"  name="province" id="province" >
                      <option value="0">请选择</option>
                        <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><option <?php if($address['province'] == $p['id']): ?>selected<?php endif; ?>  value="<?php echo ($p["id"]); ?>"><?php echo ($p["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                 </select>
                <select name="city" id="city" >
                    <option  value="0">请选择</option>
                    <?php if(is_array($city)): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><option <?php if($address['city'] == $p['id']): ?>selected<?php endif; ?>  value="<?php echo ($p["id"]); ?>"><?php echo ($p["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select></div>
	</div>
    <div class="z-div clearfix">
		<div class="col-xs-4">详细地址</div>
		<div class="col-xs-8  pull-right"><input type="text"  name="address" id="address" placeholder="详细地址" maxlength="100" value="<?php echo ($address["address"]); ?>"/></div>
	</div>
    <div class="z-div clearfix">
		<div class="col-xs-4">手机</div>
		<div class="col-xs-8  pull-right"><input type="text" name="mobile" value="<?php echo ($address["mobile"]); ?>"  maxlength="15" placeholder="手机号码"/></div>
	</div>
    <div class="z-div clearfix">
		<div class="col-xs-4">邮政编码</div>
		<div class="col-xs-8  pull-right"><input type="text" name="zipcode" value="<?php echo ($address["zipcode"]); ?>"  maxlength="10"  placeholder="邮政编码"/></div>
	</div>
    <div style=" height:50px"></div>
    <div class="z-footer">
        <div class="col-xs-12"><input id="save" type="button" value="保存" class="btn btn-block btn-info"></div>
    </div>
    <input type='hidden' name='keys' value='<?php echo ($keys); ?>'/>
    </form>
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
	})
	$('#save').on('click',function(){
		var flag = checkForm();
		if(flag){
			$('#subm').submit();
		}
		return;
		
	})
    function checkForm(){
        var consignee = $('input[name="consignee"]').val();
        var province = $('select[name="province"]').find('option:selected').val();
        var city = $('select[name="city"]').find('option:selected').val();
        var address = $('input[name="address"]').val();
        var mobile = $('input[name="mobile"]').val();
        var zipcode = $("input[name='zipcode']").val();
        var error = '';
        var telPattern=/^[1][34578][0-9]{9}$/;
        var reg = /^[^\s]*$/;
        var zip = /^\d{6}$/;
        if(consignee == ''){
            error = '收货人不能为空';
            $.toast({text:error});
            return;
        }
        if(!reg.test(consignee)){
            error = '收货人不能包含空格';
            $.toast({text:error});
            return;
        }
        if(province==0){
            error= '请选择省份';
            $.toast({text:error});
            return;
        }
        if(city==0){
            error= '请选择城市 ';
            $.toast({text:error});   
            return;
        }
        if(address == ''){
            error= '请填写地址';
            $.toast({text:error});   
            return;
        }
        if(!reg.test(address)){
            error= '地址不能包含空格';
            $.toast({text:error});
            return;
        }
        if(!telPattern.test(mobile)){
            error= '手机号码格式有误 ';
            $.toast({text:error});
            return;
		}
        console.log(zipcode);
        if(zipcode == ''){
            error= '请输入邮政编码';
            $.toast({text:error});
            return;
        }
        if(!zip.test(zipcode)){
            error= '邮政编码格式不正确';
            $.toast({text:error});
            return;
        }
        if(error){
         
            return false;
        }
			 
        return true;
    }
</script> 
</body>
</html>