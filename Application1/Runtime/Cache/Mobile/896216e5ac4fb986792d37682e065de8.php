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

<style>
.my_sxlv{padding:50px 0 70px 0;}
a{color:#333;}
.list_famil{border-top:10px solid #f5f5f5;}
.goods_nav{top:50px;}
</style>
<body>
<div class="wrap">
	<!--头部-->
    <div class="header2">
    	<a><i onClick="history.go(-1)"></i></a>
        <!--<a href="<?php echo U('Mobile/Index/index');?>" class="icon icon_home"></a>-->
        <aside class="top_bar">
         <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
       </aside>
       <p>我的上下级</p>
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
    <div class="my_sxlv">
        <div class="" style="display:none">
            <div class="z-list"><i class="icon-search"></i>&nbsp;代理商查询</div>
        </div>
        <?php if($parent["user_id"] != 0): ?><div class=" padding_hhi">
            <div class="z-list sever background_none border_bottom">我的上级：</div>
            <?php if($parent["is_temination"] != 2): ?><a href="<?php echo U('Mobile/User/famil_detail');?>?type=1&uid=<?php echo ($parent["user_id"]); ?>"><?php endif; ?>
            <div class="channel-box z_pomar clearfix">
            	<?php if(empty($parent["head_pic"])): ?><div class="col-xs-4"><img class="img-responsive" src="/Template/mobile/new/Static/images/user68.jpg"/></div>
                 <?php else: ?>
                  <div class="col-xs-4"><img class="img-responsive" src="/<?php echo ($parent["head_pic"]); ?>"/></div><?php endif; ?>
                <div class="col-xs-8">
                    <div class="col-xs-7"><?php echo ($parent["nickname"]); ?></div>
                    <div class="col-xs-5 text-primary"><?php echo ($parent["level"]); ?></div>
                    <div class="col-xs-7"><?php echo ($parent["mobile"]); ?></div>
                    <div class="col-xs-5"></div>
                    <?php if($parent["is_lock"] == 1 and $parent["is_temination"] == 0): ?><div class="col-xs-5 text-danger">冻结</div>
                        <?php elseif($parent["is_temination"] == 1): ?>
                        <div class="col-xs-5 text-danger">解约</div>
                        <?php elseif($parent["is_temination"] == 2): ?>
                        <div class="col-xs-5 text-danger">解约中</div>
                        <?php else: ?>
                        <div class="col-xs-5 text-danger">正常</div><?php endif; ?>
                </div>
            </div>
            </a>
        </div><?php endif; ?>
        <div class=" padding_hhi">
        	<div class="z-list sever background_none border_bottom">我的下级：</div>
            <?php if(is_array($child)): foreach($child as $key=>$chi): ?><a href="<?php echo U('Mobile/User/famil_detail');?>?type=2&uid=<?php echo ($chi["user_id"]); ?>">
            <div class="channel-box z_pomar clearfix">
            	<?php if(empty($chi["head_pic"])): ?><div class="col-xs-4"><img class="img-responsive" src="/Template/mobile/new/Static/images/user68.jpg"/></div>
                 <?php else: ?>
                 	<div class="col-xs-4"><img class="img-responsive" src="/<?php echo ($chi["head_pic"]); ?>"/></div><?php endif; ?>
                <div class="col-xs-8">
                    <div class="col-xs-7"><?php echo ($chi["nickname"]); ?></div>
                    <div class="col-xs-5 text-primary"><?php echo ($chi["level"]); ?></div>
                    <div class="col-xs-7"><?php echo ($chi["mobile"]); ?></div>
                     <?php if($chi['is_lock']==2||$chi['is_lock']==4){ ?>
                     <div class="col-xs-7"><a href="<?php echo U('pass_apply');?>?id=<?php echo ($chi["user_id"]); ?>">通过下级申请审核</a></div>
                     <?php } ?>
                   <!--   -->
                    <?php if($chi["is_lock"] == 1 and $chi["is_temination"] == 0): ?><div class="col-xs-5 text-danger">冻结</div>
                    	<div style='float:right' class="col-xs-5 text-danger"><?php if(!empty($chi['jy'])){echo $chi['jy'];} ?></div>
                     <?php elseif($chi["is_temination"] == 1): ?>
                        <div class="col-xs-5 text-danger">解约</div>
                        <div style='float:right' class="col-xs-5 text-danger"><?php if(!empty($chi['jy'])){echo $chi['jy'];} ?></div>
                        <?php elseif($chi["is_temination"] == 2): ?>
                        <div class="col-xs-5 text-danger">解约申请中</div>
                        <div style='float:right' class="col-xs-5 text-danger"><?php if(!empty($chi['jy'])){echo $chi['jy'];} ?></div>
                        <?php elseif($chi["is_temination"] == 3): ?>
                        <div class="col-xs-5 text-danger">平台解约中</div>
                        <div style='float:right' class="col-xs-5 text-danger"><?php if(!empty($chi['jy'])){echo $chi['jy'];} ?></div>
                    <?php else: ?>
                     <div class="col-xs-5 text-danger">正常</div>
                    	<div style='float:right' class="col-xs-5 text-danger"><?php if(!empty($chi['jy'])){echo $chi['jy'];} ?></div><?php endif; ?>
                </div>
            </div>
           
            
            
            </a><?php endforeach; endif; ?>
            <a style="display:none"><div class="icon_more">加载更多</div></a>
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

$('.more').on('click',function(){
	$.get("<?php echo U('more_hot');?>",{page:page},function(data){
		if(data.status==1001){
			alert(data.data);
		}else if(data.status==1000){
			page++;
			console.log(data.data);
		}
		console.log(page);
	})
})
</script>
</body>
</html>