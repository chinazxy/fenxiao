<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>诚享东方管理后台</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
 	<link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 --
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/Public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
    	folder instead of downloading all of them to reduce the load. -->
    <link href="/Public/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="/Public/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />   
    <!-- jQuery 2.1.4 -->
    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/Public/js/common.js"></script>
    <script src="/Public/js/myFormValidate.js"></script>    
    <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
    <script src="/Public/js/myAjax.js"></script>
    <script type="text/javascript">
    function delfunc(obj){
    	layer.confirm('确认删除？', {
    		  btn: ['确定','取消'] //按钮
    		}, function(){
    		    // 确定
   				$.ajax({
   					type : 'post',
   					url : $(obj).attr('data-url'),
   					data : {act:'del',del_id:$(obj).attr('data-id')},
   					dataType : 'json',
   					success : function(data){
   						if(data==1){
   							layer.msg('操作成功', {icon: 1});
   							$(obj).parent().parent().remove();
   						}else{
   							layer.msg(data, {icon: 2,time: 2000});
   						}
   						layer.closeAll();
   					}
   				})
    		}, function(index){
    			layer.close(index);
    			return false;// 取消
    		}
    	);
    }
    
    function selectAll(name,obj){
    	$('input[name*='+name+']').prop('checked', $(obj).checked);
    }    
    </script>        
  </head>
  <body style="background-color:#ecf0f5;">
 

<div class="wrapper">
  <div class="breadcrumbs" id="breadcrumbs">
	<ol class="breadcrumb">
	<?php if(is_array($navigate_admin)): foreach($navigate_admin as $k=>$v): if($k == '后台首页'): ?><li><a href="<?php echo ($v); ?>"><i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo ($k); ?></a></li>
	    <?php else: ?>
	        <li><a href="<?php echo ($v); ?>"><?php echo ($k); ?></a></li><?php endif; endforeach; endif; ?>
	</ol>
</div>

    <section class="content">
    <div class="row">
      <div class="col-xs-12">
      	<div class="box">
          <!-- <nav class="navbar navbar-default">	     
			<div class="collapse navbar-collapse">
                <div class="navbar-form pull-right margin">
                      <?php if($order['order_status'] < 2): ?><a href="<?php echo U('Admin/order/edit_order',array('order_id'=>$order['order_id']));?>" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="编辑">修改订单</a><?php endif; ?>
                      <?php if(($split == 1) and ($order['order_status'] < 2)): ?><a href="<?php echo U('Admin/order/split_order',array('order_id'=>$order['order_id']));?>" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="编辑">拆分订单</a><?php endif; ?>
                      <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回"><i class="fa fa-reply"></i></a>
               </div>
            </div>
           </nav>-->
   
        <!--新订单列表 基本信息-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">基本信息</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td>订单 ID:</td>
                        <td>订单号:</td>
                        <td>会员:</td>
                        <td>E-Mail:</td>
                        <td>电话:</td>
                        <td>总计:</td>
                        <td>订单状态:</td>
                        <td>下单时间:</td>
                        <td>支付时间:</td>
                        <td>支付方式:</td>
                    </tr>
                    <tr>
                        <td><?php echo ($order["order_id"]); ?></td>
                        <td><?php echo ($order["order_sn"]); ?></td>
                        <td><a href="#" target="_blank"><?php echo ($order["consignee"]); ?></a></td>
                        <td><a href="#"><?php echo ($order["email"]); ?></a></td>
                        <td><?php echo ($order["mobile"]); ?></td>
                        <td><?php echo ($order["order_amount"]); ?></td>
                        <td id="order-status"><?php echo ($order_status[$order[order_status]]); ?> / <?php echo ($pay_status[$order[pay_status]]); if($order['pay_code'] == 'cod'): ?><span style="color: red">(货到付款)</span><?php endif; ?> / <?php echo ($shipping_status[$order[shipping_status]]); ?></td>
                    	<td><?php echo (date('Y-m-d H:i',$order["add_time"])); ?></td>
                    	<td><?php if($order["pay_time"] != 0): echo (date('Y-m-d H:i',$order["pay_time"])); ?>
                         <?php else: ?>
                            N<?php endif; ?>
                        </td>             
                        <td id="pay-type">
                            <?php echo ((isset($dec["desc"]) && ($dec["desc"] !== ""))?($dec["desc"]):'其他方式'); ?>
                        </td>
                    </tr>
                    <tr >
                        <td colspan="11">
                            <table width="100%">
                                <tr>
                                <th width="10%" style="border-right: 1px #cccccc solid;text-align: center">*订单备注*：</th>
                                <td style="text-align: center"><?php echo ($order["user_note"]); ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--新订单列表 收货人信息-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">收货信息</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <tbody><tr>
					<td>收货人:</td>
					<td>联系方式:</td>
					<td>地址:</td>
					<td>邮编:</td>
					<td>配送方式:</td>
			        <td>快递单号:</td>
                    </tr>
                    <tr>
                        <td><?php echo ($order["consignee"]); ?></td>
                        <td><?php echo ($order["mobile"]); ?></td>
                        <td><?php echo ($order["address2"]); ?></td>
                        <td>
                            <?php if($order["zipcode"] != ''): echo ($order["zipcode"]); ?>
                                <?php else: ?>
                                N<?php endif; ?>
                        </td>
                        <td>
                            <?php echo ($order["shipping_name"]); ?>
                            <!--<?php if($order[shipping_name]): ?><a href="<?php echo U('Admin/Order/shipping_print',array('order_id'=>$order['order_id'],'code'=>$order['shipping_code']));?>" target="_blank" class="btn btn-primary input-sm" onclick="">打印快递单</a><?php endif; ?>-->
                        </td>
                      <td><?php echo ($info["invoice_no"]); ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--新订单列表 商品信息-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">商品信息 </h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td class="text-left">商品</td>
                        <td class="text-left">属性</td>
                        <td class="text-right">数量</td>
                        <!--<td class="text-right">单品价格</td>-->
                        <td class="text-right">会员折扣价</td>
                        <td class="text-right">单品小计</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($orderGoods)): $i = 0; $__LIST__ = $orderGoods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$good): $mod = ($i % 2 );++$i;?><tr>
                            <td class="text-left"><a href="<?php echo U('/Admin/Goods/addEditGoods',array('id'=>$good['goods_id']));?>"><?php echo ($good["goods_name"]); ?></a>
                            </td>
                            <td class="text-left"><?php echo ($good["spec_key_name"]); ?></td>
                            <td class="text-right"><?php echo ($good["goods_num"]); ?></td>
                            <!--<td class="text-right"><?php echo ($good["goods_price"]); ?></td>-->
                            <td class="text-right"><?php echo ($good["member_goods_price"]); ?></td>
                            <td class="text-right"><?php echo ($good["goods_total"]); ?></td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                    <!--<tr>
                        <td colspan="4" class="text-right">小计:</td>
                        <td class="text-right"><?php echo ($order["total_fee"]); ?></td>
                    </tr>-->
                    </tbody>
                </table>

            </div>
        </div>
        <!--新订单列表 费用信息-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">费用信息
				<?php if($pay_status[$order[pay_status]] == '未支付'): ?><a class="btn btn-primary btn-xs" data-original-title="修改费用" title="" data-toggle="tooltip" href="<?php echo U('Admin/Order/editprice',array('order_id'=>$order['order_id']));?>">
                    <i class="fa fa-pencil"></i>
					</a><?php endif; ?>
				</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td class="text-right">小计:</td>
                        <td class="text-right">运费:</td>
                        <td class="text-right">积分 (-<?php echo ($order["integral"]); ?>):</td>
                        <td class="text-right">余额抵扣</td>
                        <td class="text-right">优惠:</td>
                        <td class="text-right">总计:</td>
                    </tr>
                    <tr>
                        <td class="text-right"><?php echo ($order["goods_price"]); ?></td>
                        <td class="text-right">+<?php echo ($order["shipping_price"]); ?></td>
                        <td class="text-right">-<?php echo ($order["integral_money"]); ?></td>
                        <td class="text-right">-<?php echo ($order["user_money"]); ?></td>
                        <td class="text-right">-<?php echo ($order["discount"]); ?></td>
                        <td class="text-right"><?php echo ($order["order_amount"]); ?></td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <!--新订单列表 操作信息-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">操作信息</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <div class="row">
                            <td class="text-right col-sm-2"><p class="margin">操作备注：</p></td>
                            <td colspan="3">
                                <form id="order-action">
                                    <textarea name="note" placeholder="请输入操作备注" rows="3" class="form-control"></textarea>
                                </form>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="row">
                            <td class="text-right col-sm-2"><p class="margin">当前可执行操作：</p></td>
                            <td colspan="3">
                                <div class="input-group">
                                	<?php if(is_array($button)): foreach($button as $k=>$vo): if($k == 'pay_cancel'): ?><a class="btn btn-primary margin" href="javascript:void(0)" data-url="<?php echo U('Order/pay_cancel',array('order_id'=>$order['order_id']));?>" onclick="pay_cancel(this)"><?php echo ($vo); ?></a>
                                		<?php elseif($k == 'delivery'): ?>
                                			<a class="btn btn-primary margin" href="<?php echo U('Order/delivery_list',array('order_id'=>$order['order_id']));?>"><?php echo ($vo); ?></a>
                                		<?php elseif($k == 'refund'): ?>
                                			<!--退货商品列表-->
											<input class="btn btn-primary" type="button" onclick="selectGoods2(<?php echo ($order['order_id']); ?>)" value="退货申请"> 	
                                		<?php else: ?>
                                		<button class="btn btn-primary margin" onclick="ajax_submit_form('order-action','<?php echo U('Admin/order/order_action',array('order_id'=>$order['order_id'],'type'=>$k));?>');" type="button" id="confirm">
                                		<?php echo ($vo); ?></button><?php endif; endforeach; endif; ?>                                
                                </div>
                            </td>
                        </div>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--新订单列表 操作记录信息-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">操作记录</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td class="text-center">操作者</td>
                        <td class="text-center">操作时间</td>
                        <td class="text-center">订单状态</td>
                        <td class="text-center">付款状态</td>
                        <td class="text-center">发货状态</td>
                        <td class="text-center">描述</td>
                        <td class="text-center">备注</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($action_log)): $i = 0; $__LIST__ = $action_log;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$log): $mod = ($i % 2 );++$i;?><tr>
                            <td class="text-center"><?php echo ($log["action_user"]); ?></td>
                            <td class="text-center"><?php echo (date('Y-m-d H:i:s',$log["log_time"])); ?></td>
                            <td class="text-center"><?php echo ($order_status[$log[order_status]]); ?></td>
                            <td class="text-center"><?php echo ($pay_status[$log[pay_status]]); if($order['pay_code'] == 'code'): ?><span style="color: red">(货到付款)</span><?php endif; ?></td>
                            <td class="text-center"><?php echo ($shipping_status[$log[shipping_status]]); ?></td>
                            <td class="text-center"><?php echo ($log["status_desc"]); ?></td>
                            <td class="text-center"><?php echo ($log["action_note"]); ?></td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
            </div>
          </div>
        </div>
	  </div>
    </div> 
   </section>
</div>
</body>
<script>
function pay_cancel(obj){
    var url =  $(obj).attr('data-url')+'/'+Math.random();
    layer.open({
        type: 2,
        title: '退款操作',
        shadeClose: true,
        shade: 0.8,
        area: ['45%', '50%'],
        content: url, 
    });
}
//取消付款
function pay_callback(s){
	if(s==1){
		layer.msg('操作成功', {icon: 1});
		layer.closeAll('iframe');
	}else{
		layer.msg('操作失败', {icon: 3});
		layer.closeAll('iframe');
	}
}

// 弹出退换货商品
function selectGoods2(order_id){
	var url = "/index.php?m=Admin&c=Order&a=get_order_goods&order_id="+order_id;
	layer.open({
		type: 2,
		title: '选择商品',
		shadeClose: true,
		shade: 0.8,
		area: ['60%', '60%'],
		content: url, 
	});
}    
// 申请退换货
function call_back(order_id,goods_id)
{
	var url = "/index.php?m=Admin&c=Order&a=add_return_goods&order_id="+order_id+"&goods_id="+goods_id;	
	location.href = url;
}
</script>
</html>