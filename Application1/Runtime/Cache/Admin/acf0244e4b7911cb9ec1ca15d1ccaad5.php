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
    <!-- Main content -->
    <!--<div class="container-fluid">-->
    <div class="container-fluid">
        <form id="delivery-form" action="<?php echo U('Admin/order/deliveryHandle');?>" method="post">
        <!--新订单列表 基本信息-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">基本信息</h3>
            </div>
            <div class="panel-body">
               <nav class="navbar navbar-default">	     
				<div class="collapse navbar-collapse">
	                <div class="navbar-form pull-right margin">
	                    <a href="<?php echo U('Admin/Order/order_print',array('order_id'=>$order['order_id']));?>" target="_blank" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="打印订单">
	                        <i class="fa fa-print"></i>打印订单
	                    </a>
	                    <a href="<?php echo U('Admin/Order/delivery_list');?>" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回"><i class="fa fa-reply"></i></a>
	               </div>
	            </div>
	           </nav>
                <table class="table table-bordered">
                    <tbody>

                    <tr>
                        <td class="text-right">订单号:</td>
                        <td class="text-center"><?php echo ($order["order_sn"]); ?></td>
                        <td class="text-right">下单时间:</td>
                        <td class="text-center"><?php echo (date('Y-m-d H:i',$order["add_time"])); ?></td>
                    </tr>
                    <tr>
                        <td class="text-right">快递公司:</td>
                        <td class="text-center">
                        	<input class="input-sm" name="shipping_name" id="shipping_name" value="<?php echo ($order["shipping_name"]); ?>">
                        </td>
                        <td class="text-right">配送费用:</td>
                        <td class="text-center"><?php echo ($order["shipping_price"]); ?></td>
                    </tr>
                    <tr>
                        <td class="text-right">配送单号:</td>
                        <td class="text-center">
                        <input class="input-sm" name="invoice_no" id="invoice_no" value="<?php echo ($order["invoice_no"]); ?>" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[\u4e00-\u9fa5]/g,''))" onkeyup="this.value=this.value.replace(/[\u4e00-\u9fa5]/g,'')">
                        </td>
                    </tr>
                    </tbody></table>

            </div>
        </div>
        <!--新订单列表 收货人信息-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">收货信息</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td class="text-right">收货人:</td>
                        <td class="text-center"><?php echo ($order["consignee"]); ?></td>
                        <td class="text-right">电子邮件:</td>
                        <td class="text-center"><?php echo ($order["email"]); ?></td>
                    </tr>
                    <tr>
                        <td class="text-right">地址:</td>
                        <td class="text-center"><?php echo ($order["address2"]); ?></td>
                        <td class="text-right">邮编:</td>
                        <td class="text-center"><?php echo ($order["zipcode"]); ?></td>
                    </tr>
                    <tr>
                        <td class="text-right">电话:</td>
                        <td class="text-center"><?php echo ($order["mobile"]); ?></td>
                        <td colspan="2"></td>
                    </tr>
                    </tbody></table>

            </div>
        </div>
        <!--新订单列表 商品信息-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">商品信息</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td class="text-left">商品</td>
                        <td class="text-left">属性</td>
                        <td class="text-left">购买数量</td>
                        <td class="text-left">商品单价</td>
						<td class="text-left">选择发货</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($orderGoods)): $i = 0; $__LIST__ = $orderGoods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$good): $mod = ($i % 2 );++$i;?><tr>
                            <td class="text-left"><a href="<?php echo U('/Admin/Goods/addEditGoods',array('id'=>$good['goods_id']));?>"><?php echo ($good["goods_name"]); ?></a>
                            </td>
                            <td class="text-left"><?php echo ($good["spec_key_name"]); ?></td>
                            <td class="text-left"><?php echo ($good["goods_num"]); ?></td>
                            <td class="text-right"><?php echo ($good["member_goods_price"]); ?></td>
                            <td class="text-right">
                            	<?php if($good['is_send'] == 1): ?>已发货
                            	<?php else: ?>
                            		<input type="checkbox" name="goods[]" value="<?php echo ($good["rec_id"]); ?>" checked="checked"><?php endif; ?>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
        <!--发货状态下课修改订单号-->
        <?php if($order['shipping_status'] != 1): ?><!--新订单列表 操作信息-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">发货信息</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td class="text-right col-sm-2 margin">发货单备注：</td>
                            <td colspan="3">
                            	<input type="hidden" name="order_id" value="<?php echo ($order["order_id"]); ?>">
                               <textarea name="note" placeholder="请输入操作备注" rows="3" class="form-control"></textarea>
                            </td>
                        </tr>
                        <tr>
                             <td colspan="4">
                                 <div class="form-group text-center">
                                        <button onclick="dosubmit()"  class="btn btn-primary" type="button">确认发货</button>
                                        <button onclick="history.go(-1)"  class="btn btn-primary" type="submit">返回</button>
                                 </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div><?php endif; ?>
        
                <!--新订单列表 操作记录信息-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">发货记录</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td class="text-center">操作者</td>
                        <td class="text-center">发货时间</td>
                        <td class="text-center">发货单号</td>
                        <td class="text-center">收货人</td>
                        <td class="text-center">发货物流</td>
                        <td class="text-center">备注</td>
                    </tr>
                    </thead>
                    <tbody>
                            <td class="text-center"><?php echo ($log["admin_id"]); ?></td>
                            <?php if($log != ''): ?><td class="text-center"><?php echo (date('Y-m-d H:i:s',$log["create_time"])); ?></td><?php endif; ?>
                            <?php if($log == ''): ?><td class="text-center"></td><?php endif; ?>
                            <td class="text-center"><?php echo ($log["invoice_no"]); ?></td>
                            <td class="text-center"><?php echo ($log["consignee"]); ?></td>
                            <td class="text-center"><?php echo ($log["shipping_name"]); ?></td>
                            <td class="text-center"><?php echo ($log["note"]); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
          </div>
	</form>
   </div>
 </section>
</div>
<script>
function dosubmit(){
	if($('#invoice_no').val() ==''){
		 layer.alert('请输入配送单号', {icon: 2});  // alert('请输入配送单号');
		return;
	}
	if($('#shipping_name').val() ==''){
		 layer.alert('请输入快递公司', {icon: 2});  // alert('请输入配送单号');
		return;
	}
	var a = [];
	$('input[name*=goods]').each(function(i,o){
		if($(o).is(':checked')){
			a.push($(o).val());
		}
	});
	if(a.length == 0){
		layer.alert('请选择发货商品', {icon: 2});  //alert('请选择发货商品');
		return;
	}
	$('#delivery-form').submit();
}
</script>
</body>
</html>