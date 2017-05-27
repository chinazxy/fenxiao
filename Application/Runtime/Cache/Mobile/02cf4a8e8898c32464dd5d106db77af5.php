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

<link rel="stylesheet" href="/Template/mobile/new/Static/css/main.css" type="text/css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/public.css" type="text/css">  
    <div class="mycenter">
    	<div class="my_center_head">
        	<div class="my_center_head_left">
        		<?php if(user.head_pic != ''): ?><div><img src="/<?php echo ($user["head_pic"]); ?>"/></div>
        		<?php else: ?>
        			<div><img src="/Template/mobile/new/Static/images/user68.jpg"/></div><?php endif; ?>
            	<input type='hidden' value='<?php echo ($user[is_lock]); ?>'/>
            	
                
            </div>
			<?php if($user[is_lock] == 0 and $user[is_temination] == 1): ?><a class="center_bond on">已解约</a>
                <?php elseif($user[is_lock] == 0 and $user[is_temination] == 2 or $user[is_temination] == 3): ?>
                    <a class="center_bond on">解约中</a>
                <?php elseif(($user[is_out] == 1) and ($user[is_lock] == 2)): ?>
                    <a class="center_bond on">等待审核</a>
                <?php elseif($user[is_lock] == 3): ?>
                    <a class="center_bond on">平台审核中</a>
                <?php elseif(($user[is_out] == 2)and ($user[is_lock] == 2)): ?>
                    <a class="center_bond on" href="<?php echo U('User/again');?>?id=<?php echo ($user["user_id"]); ?>">重新审核</a>
                 <?php elseif($user[is_lock] == 0): ?>
                    <a class="center_bond on">已缴保证金</a>
            	<?php elseif(($user[is_lock] == 1)): ?>
            		<a class="center_bond on" href="<?php echo U('User/pay_order');?>?type=3">未缴保证金</a><?php endif; ?>
            <div class="my_center_head_right">
            	<h3><?php echo ($user['username']); ?><!--<a class="m_btn"  href="<?php echo U('Mobile/User/docash');?>">提现</a>--></h3>
                <!--<div class="rank">经销商等级：<span><?php echo ($user['level_name']); ?></span><a class="m_btn">升级</a></div>-->
            </div>
          
        </div>
		<div style="background:#fff;">
			<div class="capital And">
				<?php if($user[u_type] == 1): ?><div class="Si"><p class="name"><em class="yuer"><img src="/Public/upload/head_pic/20170520/yuer.svg"/></em>余额</p><p class="money">￥<?php echo ($user['user_money']); ?></p></div>
					<div class="Si sever"><p class="name">不可用余额</p><p class="money">￥<?php echo ($user['frozen_money']); ?></p></div><?php endif; ?>
				<?php if($user[u_type] == 2): ?><div class="Si"><p class="name">可用余额</p><p class="money">￥<?php echo ($finance['f_money']); ?></p></div>
					<div class="Si sever"><p class="name">不可用余额</p><p class="money">￥<?php echo ($finance['frozen_money']); ?></p></div><?php endif; ?>
			</div>
			<div class="list-block">

				<div class="list-block_box border_none">
					<div class="list-block_box_left">我的订单</div>
					<div class="list-block_box_right"><i class="icon yuer"><img src="/Public/upload/head_pic/20170520/dding.svg"/></i></div>
				</div>
				<div id="od_uAnd" class="c-panel clearfix">
					<span class="list_bor1 list_bor2"></span>
					<span class="list_bor3"></span>
					<div class="usr-fkx clearfix">
						<a class="order-tag" href="<?php echo U('/Mobile/User/order_list',array('type'=>'WAITPAY'));?>"  >
							<i class="tj"><img src="/Public/upload/head_pic/20170520/wd_2.svg"/></i>
							<?php if($waitpayNum != 0): ?><em><?php echo ($waitpayNum); ?></em><?php endif; ?>
							<span>待付款</span>
						</a>
						<a class="order-tag" href="<?php echo U('/Mobile/User/order_list',array('type'=>'WAITSEND'));?>">
							<i class="tj"><img src="/Public/upload/head_pic/20170520/wd_3.svg"/></i>
							<?php if($waitsendNum != 0): ?><em><?php echo ($waitsendNum); ?></em><?php endif; ?>
							<span>待发货</span>
						</a>
						<a class="order-tag" href="<?php echo U('/Mobile/User/order_list',array('type'=>'WAITRECEIVE'));?>">
							<i class="tj"><img src="/Public/upload/head_pic/20170520/wd_4.svg"/></i>
							<?php if($waitreceiveNum != 0): ?><em><?php echo ($waitreceiveNum); ?></em><?php endif; ?>
							<span>待收货</span>
						</a>
						<a class="order-tag" href="<?php echo U('/Mobile/User/order_list',array('type'=>'RETURNING'));?>">
							<i class="tj"><img src="/Public/upload/head_pic/20170520/wd_5.svg"/></i>
							<?php if($waitcomentNum != 0): ?><em><?php echo ($waitcomentNum); ?></em><?php endif; ?>
							<span>退货中</span>
						</a>
					</div>


				</div>
			</div>
			<div class="list-block">
				<div class="list-block_box border_none">
					<div class="list-block_box_left">下级订单</div>
					<div class="list-block_box_right"><i class="icon yuer"><img src="/Public/upload/head_pic/20170520/dding.svg"/></i></div>
				</div>
				<div id="od_uAnd" class="c-panel clearfix">
					<span class="list_bor1 left50"></span>

					<span class="list_bor3 widthop"></span>
					<div class="usr-fkx width100 clearfix">

						<a class="order-tag" href="<?php echo U('/Mobile/User/order_list_down',array('type'=>'WAITSEND'));?>">
							<i class="tj"><img src="/Public/upload/head_pic/20170520/wd_3.svg"/></i>
							<?php if($kidWaitSend != 0): ?><em><?php echo ($kidWaitSend); ?></em><?php endif; ?>
							<span>待发货</span>
						</a>
						<a class="order-tag" href="<?php echo U('/Mobile/User/order_list_down',array('type'=>'WAITRECEIVE'));?>">
							<i class="tj"><img src="/Public/upload/head_pic/20170520/wd_4.svg"/></i>
							<?php if($kidWaitReceive != 0): ?><em><?php echo ($kidWaitReceive); ?></em><?php endif; ?>
							<span>待收货</span>
						</a>
						<a class="order-tag" style="width: 100%" href="<?php echo U('/Mobile/User/order_list_down',array('type'=>'RETURNING'));?>">
							<i class="tj"><img src="/Public/upload/head_pic/20170520/wd_5.svg"/></i>
							<?php if($kidReturning != 0): ?><em><?php echo ($kidReturning); ?></em><?php endif; ?>
							<span>待退货</span>
						</a>

					</div>
				</div>
			</div>

        <div class="list-block">
        <a href="<?php echo U('Mobile/User/account_list');?>" >
        	<div class="list-block_box">
            	<div class="list-block_box_left">账户管理</div>
                <div class="list-block_box_right"><i class="icon yuer"><img src="/Public/upload/head_pic/20170520/zhgl.svg"/></i></div>
            </div>
          </a>
        </div>
        <div class="list-block">
        <a href="<?php echo U('Mobile/User/cash');?>" >
        	<div class="list-block_box">
            	<div class="list-block_box_left">资金管理</div>
                <div class="list-block_box_right"><i class="icon yuer"><img src="/Public/upload/head_pic/20170520/yhq.svg"/></i></div>
            </div>
          </a>
        </div>
          <div class="list-block">
        <a href="<?php echo U('Mobile/User/my_goods');?>" >
        	<div class="list-block_box">
            	<div class="list-block_box_left">库存查看</div>
                <div class="list-block_box_right"><i class="icon yuer"><img src="/Public/upload/head_pic/20170520/kcgl.svg"/></i></div>
            </div>
          </a>
        </div> 
     
        <div class="list-block">
        <a href="<?php echo U('Mobile/User/return_order');?>" >
        	<div class="list-block_box">
            	<div class="list-block_box_left">可退货单</div>
                <div class="list-block_box_right"><i class="icon yuer"><img src="/Public/upload/head_pic/20170520/kthd.svg"/></i></div>
            </div>
            </a>
        </div>
       <!--   <div class="list-block">
        <a href="<?php echo U('Mobile/User/return_goods_list');?>" >
        	<div class="list-block_box">
            	<div class="list-block_box_left">我的退货</div>
                <div class="list-block_box_right"><i class="icon icon_back"></i></div>
            </div>
            </a>
        </div>
      <div class="list-block">
        <a href="<?php echo U('Mobile/User/return_goods_list_down');?>" >
        	<div class="list-block_box">
            	<div class="list-block_box_left">下级退货</div>
                <div class="list-block_box_right"><i class="icon icon_back"></i></div>
            </div>
            </a>
        </div>-->
    	<div class="list-block">
    	<a href="<?php echo U('Mobile/User/userinfo');?>">
        	<div class="list-block_box">
            	<div class="list-block_box_left">我的帐号</div>
                <div class="list-block_box_right"><i class="icon yuer"><img src="/Public/upload/head_pic/20170520/wdzh.svg"/></i></div>
            </div>
            </a>
        </div>
    	<div class="list-block">
    	<a href="fff.html">
        	<div class="list-block_box">
            	<div class="list-block_box_left">申请首页推广</div>
                <div class="list-block_box_right"><i class="icon yuer"><img src="/Public/upload/head_pic/20170520/tg.svg"/></i></div>
            </div>
            </a>
        </div>
        <div class="list-block">
        <a href="<?php echo U('User/change_pwd');?>">
        	<div class="list-block_box">
            	<div class="list-block_box_left">帐号安全</div>
                <div class="list-block_box_right"><i class="icon yuer"><img src="/Public/upload/head_pic/20170520/zhaq.svg"/></i></div>
            </div>
         </a>
        </div>
        <div class="list-block">
        <a href="<?php echo U('User/address_list');?>">
        	<div class="list-block_box">
            	<div class="list-block_box_left">收货地址</div>
                <div class="list-block_box_right"><i class="icon yuer"><img src="/Public/upload/head_pic/20170520/adds.svg"/></i></div>
            </div>
        </a>
        </div>
        <div class="list-block">
        <a href="<?php echo U('User/my_famil');?>">
        	<div class="list-block_box">
            	<div class="list-block_box_left">我的上下级</div>
                <div class="list-block_box_right"><i class="icon yuer"><img src="/Public/upload/head_pic/20170520/sxj.svg"/></i></div>
            </div>
        </a>
        </div>
        <div class="list-block" style="display:none">
        <a href="<?php echo U('User/message_list');?>">
        	<div class="list-block_box">
            	<div class="list-block_box_left">反馈意见</div>
                <div class="list-block_box_right"><i class="icon icon_back"></i></div>
            </div>
            </a>
        </div></div>
        
        <div class="cancel"><a href="<?php echo U('User/logout');?>" class="btn btn-lg btn-block btn-danger" style="color:#fff;">注销</a></div>
        
        <div style="height:120px;"></div>
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
    <!-- <div class="footer">
    	<a class="icon icon_s"><i></i><span>产品</span></a>
        <a class="icon icon_s"><i></i><span>订单</span></a>
        <a class="icon icon_s"><i></i><span>通知</span></a>
        <a class="icon icon_s"><i></i><span>我的</span></a>
    </div> -->
</div>

<script type="text/javascript">
var page = 1;
var H = $(window).innerHeight();
$('.H').css('height', H + 'px');

var menu=1;
/* $('.menu').click(function(){
	$(this).toggleClass('on');
}) */
$('.header_menu_i').click(function(){
    $('body').toggleClass('mobopen');
    
    if(menu==1){
        $('.header_menu').css('height','0px');
        $('.header_menu').animate({height:H + 'px'},500);
        menu=2;
    }else{
        $('.header_menu').show().animate({height:'0px'},500);
        setTimeout(function(){
            $('.header_menu').css('display','')
        },500)
        menu=1;
    }
});

function headmenu_m(a,b){
    if(!b) return;
    $(a).parent().toggleClass('open');
}

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