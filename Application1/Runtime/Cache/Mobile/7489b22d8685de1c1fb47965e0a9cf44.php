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
.goods_nav{top:50px;}
</style>
<body>
	<div class="z-list">
    	<div class="head"><span class="title">&nbsp;退货单状态</span>
    	<div class="pull-right text-primary">
    	<?php if($return_goods[status] == 0): ?>申请中<?php endif; ?>
        <?php if($return_goods[status] == 1): ?>客服处理中<?php endif; ?>
        <?php if($return_goods[status] == 2): ?>已完成<?php endif; ?> &nbsp;
    	<!--<i class="icon-chevron-right"></i>--></div>
    	</div>
        <div class="content text-muted">
        	<div>单号&nbsp;<?php echo ($order_info["order_sn"]); ?></div>
        	<div>时间&nbsp;<?php echo (date("Y-m-d",$return_goods["addtime"])); ?></div>
        </div>
    </div>
    <div class="z-list">
    	<div class="head"><span class="title">&nbsp;订单金额</span><div class="pull-right text-muted">￥<?php echo ($order_info["total_amount"]); ?></div></div>
        <div class="content text-muted">
        	<div style="display:none">商品金额<div class="pull-right text-muted">￥<?php echo ($order_info["total_amount"]); ?></div></div>
        </div>
    </div>
    <div class="z-list">
    	<div class="head z-shopa open"><span class="title">&nbsp;问题描述</span>
        	<div class="z-shop_list_box">
            	<div class="z-remark col-xs-12" style="font-size:12px;"><?php echo ($return_goods['reason']); ?></div>
            	<div class="Gg_photo col-xs-12">
            	<?php if(is_array($return_goods[imgs])): $i = 0; $__LIST__ = $return_goods[imgs];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><img src="<?php echo ($item); ?>" width="60"/>  
	            <!-- <a href="<?php echo ($item); ?>" target="_blank"><div><img src="<?php echo ($item); ?>"/></div></a>&nbsp;&nbsp;&nbsp; --><?php endforeach; endif; else: echo "" ;endif; ?> 
            </div>
        </div>
    </div>
	<div class="z-list">
    	<div class="head clearfix"><span class="col-xs-4">快递单号</span><div class="col-xs-8 text-muted"><?php echo ($return_goods['return_sn']); ?></div></div>
    </div>
    <?php if($return_goods[status] != 2): ?><div class="z-footer">
    	<div class="z-order-footer col-xs-12">
    		<a class="btn btn-block btn-primary" id="back">完成</a>
    		<input type="hidden" value="<?php echo ($return_goods['id']); ?>" id = "id"/>
    	</div>
    </div><?php endif; ?>
<!-- <script src="../js/jquery-1.9.1.min.js"></script>
<script src="../js/zui.min.js"></script> -->

		<style>
			.pinch-box{position:fixed;top:0;width:100%;padding:10px;background:#000;z-index:99;display:none;}
		</style>
		<div class="pinch-box">
			<div class="pinch-zoom"><img src=""/></div>
		</div>

<script src="/Public/jd/js/pinchzoom.js" ></script>
<script>
$('.z-shopa a').on('click',function(){
	if($(this).parent().hasClass('open')){
		$(this).parent().removeClass('open');
	}else{
		$(this).parent().addClass('open');
	}
})
$(function(){
	//图片放
	$('.pinch-box').css('height',$(window).innerHeight() + 'px');
	$('.Gg_photo img').on('click',function(){
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
	//图片放

	$('#back').click(function(){
		var id = $('#id').val();
		$.post('',{id:id},function(resp){
			if(resp.status ==1){
				alert(resp.info);
				location.href = "<?php echo U('order_list_my_down');?>";
			}else{
				alert(resp.info);
			}
		});
	});
});
</script>
</body>
</html>