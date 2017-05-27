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
		
    <section class="content ">
        <!-- Main content -->
        <div class="container-fluid">
            <div class="pull-right">
                <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回"><i class="fa fa-reply"></i></a>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-list"></i>退换货</h3>
                </div>
                <div class="panel-body ">   
                    <!--表单数据-->
                    <form method="post" id="return_form" action="<?php echo U('Admin/Order/return_info');?>">                    
                        <!--通用信息-->
                    <div class="tab-content col-md-10">                 	  
                        <div class="tab-pane active" id="tab_tongyong">                           
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td class="col-sm-2">订单编号：</td>
                                    <td class="col-sm-8">
                                        <a href="<?php echo U('Admin/order/detail',array('order_id'=>$return_goods['order_id']));?>"><?php echo ($return_goods["order_sn"]); ?></a>
                                    </td>
                                </tr>  
                                <tr>
                                    <td>用户：</td>
                                    <td>                    
					                    <?php echo ($user["username"]); ?>
                                    </td>
                                </tr>  
                                <tr>
                                    <td>申请日期：</td>
                                    <td>                    
					                    <?php echo (date("Y-m-d H:i",$return_goods["addtime"])); ?>
                                    </td>
                                </tr>                                  
                                <tr>
                                    <td>退货详情：</td>
                                    <td>
									<?php if(is_array($goods)): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($i % 2 );++$i; if($goods[return_num] != ''): ?><p><?php echo ($goods[goods_name]); ?> 退货：<?php echo ($goods[return_num]); ?>件  价格：<?php echo ($goods[member_goods_price]); ?></p>  <!--<a href="<?php echo U('/Admin/Goods/addEditGoods',array('id'=>$good['goods_id']));?>" target="_blank"></a>--><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>退货快递单号：</td>
                                    <td><?php echo ($return_goods["return_sn"]); ?></td>
                                </tr>
                                <tr>
                                    <td>金额：</td>
                                    <td>
                                     <div class="form-group col-xs-3" style="display:none">
										<select  name="type"  class="form-control">
                                             <option value="0" <?php if($return_goods['type'] == 0): ?>selected="selected"<?php endif; ?>>退货</option>
                                             <option value="1" <?php if($return_goods['type'] == 1): ?>selected="selected"<?php endif; ?>>换货</option>
                                        </select>
                                      </div>
                                          ￥<?php echo ($return[return_money]); ?>
                                    </td>
                                </tr>  
                                <tr>
                                    <td>退货描述：</td>
                                    <td>                    
					                    <textarea name="reason" id="reason" cols="" rows="" readonly="readonly" class="area" style="width:400px; height:120px;"><?php echo ($return_goods['reason']); ?></textarea>                                        
                                    </td>
                                </tr>  
                                <tr>
                                    <td>用户上传照片：</td>
                                    <td>
                                         <?php if(is_array($return_goods[imgs])): $i = 0; $__LIST__ = $return_goods[imgs];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><a href="<?php echo ($item); ?>" target="_blank"><img src="<?php echo ($item); ?>" width="85" height="85" /></a>&nbsp;&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>                      					
                                    </td>
                                </tr>                                    
                                <tr>
                                    <td>状态：</td>
                                    <td>
                                    <div class="form-group  col-xs-3">
										<select class="form-control" name="status" <?php if($return_goods['status'] == 2): ?>DISABLED<?php endif; ?>>
                                             <option value="0" <?php if($return_goods['status'] == 0): ?>selected="selected"<?php endif; ?>>未处理</option>
                                             <!--<option value="1" <?php if($return_goods['status'] == 1): ?>selected="selected"<?php endif; ?>>处理中</option>-->
                                             <option value="2" <?php if($return_goods['status'] == 2): ?>selected="selected"<?php endif; ?>>已完成</option>
                                        </select>
                                         </div>

                                    </td>
                                </tr>     
                                <tr>
                                    <td>处理备注：</td>
                                    <td>                    
					                    <textarea name="remark" id="remark" cols="" rows=""  class="area" style="width:400px; height:120px;"><?php echo ($return_goods['remark']); ?></textarea>                                        
                                    </td>
                                </tr>                                                                                                                                                          
                                </tbody> 
                                <tfoot>
                                	<tr>
                                	<td><input type="hidden" name="id" value="<?php echo ($id); ?>">
                                	</td>
                                	<td class="text-right"><input class="btn btn-primary" type="submit"  value="保存" <?php if($return_goods['status'] == 2): ?>DISABLED<?php endif; ?>></td></tr>
                                </tfoot>                               
                                </table>
                        </div>                           
                    </div>              
			    	</form><!--表单数据-->
                </div>
            </div>
        </div>
    </section>
</div>
<script>
function adsubmit(){
	$('#handleposition').submit();
}
</script>
</body>
</html>