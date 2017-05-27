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
.z-footer {border-top:none;}
.z-order-footer a {width:43%;}
.z-order-footer a.btn-primary {font-size:16px;	}
</style>
<body class="clearfix">
	<div class="header2">
    	<a><i onClick="history.go(-1)"></i></a>
        <!--<a href="<?php echo U('Mobile/Index/index');?>" class="icon icon_home"></a>-->
        <aside class="top_bar" style="display:none">
         <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
       </aside>
       <p>订单详情</p>
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
    <div style="height:15px;"></div>
    
	<div class="z-list" style="margin-top:10%;">
    	<div class="head line_height20">订单状态</span><div class="pull-right text-primary"><?php echo ($order_info["order_status_desc"]); ?>&nbsp;</div></div>
        <div class="content text-muted">
        	<div class="line_height20">单号&nbsp;<?php echo ($order_info["order_sn"]); ?></div>
        	<div class="line_height20">时间&nbsp;<?php echo date("Y-m-d H:i:s",$order_info[add_time]);?></div>
        </div>
    </div>
    <div class="z-list">
    	<div class="head line_height20">订单金额</span><div class="pull-right text-muted">￥<?php echo ($order_info[order_amount]); if($order_info['return_money'] != ''): ?>-退货金额￥<?php echo ($order_info['return_money']); endif; ?></div></div>
        <div class="content text-muted">
        	<div class="line_height20">商品金额<div class="pull-right text-muted">￥<?php echo ($order_info[order_amount]); if($order_info['return_money'] != ''): ?>-退货金额￥<?php echo ($order_info['return_money']); endif; ?></div></div>
        </div>
    </div>
    <!--<div class="z-list">
    	<div class="head">付款方式</span><div class="pull-right text-warning"><?php echo ($order_info["pay_name"]); ?></div></div>
    </div>-->
    <div class="z-list">
    	<div class="head z-shopa"><a>备注信息</span><div class="pull-right text-muted"><i class="icon-chevron-right"></i><i class="icon-chevron-down pull-right"></i></div></a>
        	<div class="z-shop_list_box">
            	<div class="z-remark"><textarea readonly class="form-control" rows="3" placeholder="可以输入多行文本" name="user_note"><?php echo ($order_info["user_note"]); ?></textarea></div>
            </div>
        </div>
    </div>
    <div class="z-list">
    	<div class="head z-shopa open"><a>商品清单</span><div class="pull-right text-muted"><i class="icon-chevron-right"></i><i class="icon-chevron-down pull-right"></i></div></a>
        	<div class="z-shop_list_box">
        	
        	<?php if(is_array($order_info["goods_list"])): $i = 0; $__LIST__ = $order_info["goods_list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$good): $mod = ($i % 2 );++$i;?><div class="z-order-dllist z-cart-box">
                    <div class="z-cart-p clearfix">
                        <div class="z-cart-p_img col-xs-4"><img class="img-responsive" src="<?php echo (goods_thum_images($good["goods_id"],100,100)); ?>"></div>
                        <div class="z-cart-p-content col-xs-8">
                            <h3 class="z-p-name text-ellipsis"><?php echo ($good["goods_name"]); ?></h3>
                            <p class="z-p-spec"><strong>规格：</strong><span><?php echo ($good["spec_key_name"]); ?></span></p>
                            <div class="text-muted">
							数量：<?php echo ($good['goods_num']); ?>
							<?php if($good['return_num'] != ''): ?>-退货数量<?php echo ($good['return_num']); endif; ?>
							<?php if($good['return_num'] == ''): ?>-退货数量0<?php endif; ?>
							</div>
                            <p class="z-p-price text-info"><strong>￥<?php echo ($good['member_goods_price']); ?></strong></p>
                        </div>
                    </div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?> 
            </div>
        </div>
    </div>
	<div class="z-list">
    	<div class="head">收货信息</div>
        <div class="content text-muted consignee">
        	<div>
        		<div class="col-xs-6">收货人：<?php echo ($order_info["consignee"]); ?></div><div class="col-xs-2">&nbsp;</div><div class="col-xs-4 text_align_right"><?php echo ($order_info["mobile"]); ?></div>
        		<div class="col-xs-12"><?php echo ($or_add); ?></div>
        	</div>
        </div>
    </div>
	<div class="z-list">
    	<div class="head">物流信息</div>
        <div class="content text-muted consignee">
        	<div class="clearfix">
        		<div class="col-xs-8"><?php echo ($order_info["invoice_no"]); ?></div><div class="col-xs-4 text-right"><?php echo ($order_info["shipping_name"]); ?></div>
        	</div>
            <div class="col-xs-12 clearfix" style="margin-top:10px;"><button style="visibility:hidden;" id="fahuo_2" type="button" class="btn btn-sm pull-right" data-toggle="modal" data-target="#myModal" style="box-shadow:none;background:none;border-radius:4px;">修改信息</button></div>
        </div>
    </div>
    <div class="modal modal-for-page fade jxs-modal" id="myModal" aria-hidden="false">
		    <div class="modal-dialog">
		      <div class="modal-content" style="font-size:14px;line-height:normal;">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
		          <h4 class="modal-title">物流信息</h4>
		        </div>
		        <div class="modal-body form-horizontal">
                    <div class="col-xs-12 form-group">
                        <div class="col-xs-4">发货快递</div>
                        <div class="col-xs-8">
                            <input type="num" id="courier_name" class="form-control" placeholder="填写快递公司">
                            
                            
                        </div>
                    </div>
                    <div class="col-xs-12 form-group">
                        <div class="col-xs-4">快递单号</div>
                        <div class="col-xs-8">
                            <input type="num" id="courier_num" class="form-control" placeholder="填写单号" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[\u4e00-\u9fa5]/g,''))" onkeyup="this.value=this.value.replace(/[\u4e00-\u9fa5]/g,'')">
                        </div>
                    </div>
                </div>
		        <div class="modal-footer">
		          <button type="button" class="btn btn-default" data-dismiss="modal"id="reback">取消</button>
		          <button type="button" id="fahuo" class="btn btn-primary" id="agree">发货</button>
		        </div>
		      </div>
		    </div>
		</div>
    
    
    <div style="height:80px;"></div>
    <?php switch($type): case "1": ?><div class="z-footer">
    	
    	<!-- <div class="z-order-footer col-xs-12">
    		<a class="btn btn-block btn-warning " href="<?php echo U('User/pay_order',array('order_id'=>$order_info['order_id'],'type'=>2));?>">立即付款</a>
    	</div> -->
    	<?php if($order_info["order_status"] < 2): ?><div class="z-order-footer col-xs-12">
    	<?php if(($order_info["cancel_btn"] == 1 ) and ($order_info["shipping_status"] == 0)): ?><a onClick="cancel_order(<?php echo ($order_info["order_id"]); ?>)" class="on_comment btn btn-lg">取消订单</a><?php endif; ?>
    	<!-- <?php if(($order_info["shipping_status"] == 1)): ?><a href="<?php echo U('Mobile/User/return_goods',array('order_id'=>$order_info['order_id'],'order_sn'=>$order_info['order_sn'],'goods_id'=>$order_info['goods_id']));?>" class="on_comment btn btn-lg">我要退货</a><?php endif; ?> -->
    	<?php if($order_info["pay_status"] == 0): ?><a class="btn btn-lg btn-primary" href="<?php echo U('User/pay_order',array('order_id'=>$order_info['order_id'],'type'=>2));?>">立即付款</a><?php endif; ?>
			<?php if(($order_info["pay_status"] == 1) and ($order_info["shipping_status"] == 1)): ?><a data-toggle="modal" data-target="#receipt" class="btn btn-lg btn-primary">确认收货</a><?php endif; ?>

			<?php if(($order_info["pay_status"] == 1) and ($order_info["shipping_status"] == 0)): ?><!-- <a class="btn btn-lg btn-primary" href="javascript::">等待发货</a> --><?php endif; ?>
    	</div>
    	<?php else: ?>
    	<div class="z-order-footer col-xs-12">
    	<!-- <?php if(($order_info["shipping_status"] == 1)): ?><a href="<?php echo U('Mobile/User/return_goods',array('order_id'=>$order_info['order_id'],'order_sn'=>$order_info['order_sn'],'goods_id'=>$order_info['goods_id']));?>" class="on_comment btn btn-lg">我要退货</a><?php endif; ?> -->
    	
    	   <a class="btn buy_again btn-lg btn-primary" href="javascript:;">再次购买</a>
    	<form id='buy_a' method='POST' action="<?php echo U('cart/sure_buy');?>"> 
    	   <input type='hidden' name='order_sn' value='<?php echo ($order_info["order_sn"]); ?>' />
    	   <input type='hidden' name='order_id' value='<?php echo ($order_info["order_id"]); ?>' />
    	   <input type='hidden' name='buy_type' value='3' />
    	</form>
    	</form>
    	</div><?php endif; ?>
    </div><?php break;?>
    <?php case "2": if(($order_info["pay_status"] == 1) and ($order_info["shipping_status"] == 0)): ?><div class="z-footer">
    	<div class="z-order-footer col-xs-12">
    		<a id="fahuo_1" class="btn btn-block btn-lg btn-warning " href="#">立即发货</a>
    	</div>
    </div><?php endif; ?>
		<?php if(($order_info["pay_status"] == 1) and ($order_info["shipping_status"] == 1) and ($order_info["order_status"] == 6)): ?><div class="z-footer">
				<div class="z-order-footer col-xs-12">
					<a id="return" class="btn btn-block btn-lg btn-warning " href="<?php echo U('/Mobile/User/return_goods_info_down',array('id'=>$order_info['order_id']));?>">处理退货</a>
				</div>
			</div><?php endif; break; endswitch;?>
	<div class="modal fade" id="receipt">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<h3 class="text-center">是否确认收货</h3>
				</div>
				<div class="modal-footer">
					<a type="button" class="btn btn-default" data-dismiss="modal">取消</a>
					<a type="button" class="btn btn-primary" href="<?php echo U('Mobile/User/order_confirm',array('id'=>$order_info['order_id']));?>">确认</a>
				</div>
			</div>
		</div>
	</div>

	<!--<script src="/Public/ihtml/js/jquery-1.9.1.min.js"></script>-->
<script src="/Public/ihtml/js/zui.min.js"></script>
<script>
$('.buy_again').on('click',function(){
	$('#buy_a').submit();
})
$('.z-shopa a').on('click',function(){
	if($(this).parent().hasClass('open')){
		$(this).parent().removeClass('open');
	}else{
		$(this).parent().addClass('open');
	}
})
$("#fahuo_1").on('click',function(){
	
	$("#fahuo_2").click();
});
$('#fahuo').on('click',function(){
	var url = "<?php echo U('Mobile/User/fahuo',array('id'=>$order_info['order_id']));?>";
	var id = "<?php echo ($order_info['order_id']); ?>";
	var courier_num = $('#courier_num').val();
	var courier_name = $('#courier_name').val();
	if(courier_name == ''){
		alert("快递公司不能为空");
		return;
	}
	if(courier_num == ''){
		alert("快递单号不能为空");
		return;
	}
	$.post(url,{id:id,courier_num:courier_num,courier_name:courier_name},function(resp){
		if(resp){
			alert(resp.info);
			setTimeout(function(){
				location.href = "<?php echo U('user/order_list_down');?>";
			},1000);
		}
	});
});
//取消订单
function cancel_order(id){
	if(!confirm("确定取消订单?"))
		return false;
	location.href = "/index.php?m=Mobile&c=User&a=cancel_order&id="+id;
}
</script>
</body>
</html>