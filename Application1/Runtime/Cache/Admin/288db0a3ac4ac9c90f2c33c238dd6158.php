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
    <!-- Content Header (Page header) -->
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
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> 经销商信息</h3>
            </div>
            
            
                    <form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"></td>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:sort('user_id');">UID</a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:sort('user_id');">昵称</a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:sort('user_id');">上级经销商</a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:sort('level');">账号</a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:sort('total_amount');">时间</a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:sort('email');">原因</a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:sort('email');">已申请时间</a>
                                    </td>
                                    <!--<td class="text-left">
                                        <a href="javascript:sort('email');">状态</a>
                                    </td>-->
                                    <td class="text-left">操作</td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="selected[]" value="6">
                                            <input type="hidden" name="shipping_code[]" value="flat.flat">
                                        </td>
                                        <td class="text-right"><?php echo ($list["uid"]); ?></td>
                                        <td class="text-left"><?php echo ($list["username"]); ?></td>
                                        <td class="text-left"><?php echo (get_username($list["parent_id"])); ?></td>
                                        <td class="text-left"><?php echo ($list["mobile"]); ?></td>
                                        <td class="text-left"><?php echo (date('Y-m-d H:i',$list["create_time"])); ?></td>
                                        <td class="text-left"><?php echo ($list["reason"]); ?></td>
                                        <td class="text-left"><?php echo (get_termination_time($list["create_time"])); ?></td>
                                        <!--<td class="text-left"><?php echo (get_termination_status($list["status"])); ?></td>-->
                                        <td class="text-left">
                                            <a href="<?php echo U('Admin/user/change_termination_status',array('uid'=>$list['uid'],'status'=>1));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="同意">同意</a>
                                            <!--<a href="<?php echo U('Admin/user/change_termination_status',array('uid'=>$list['uid'],'status'=>2));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="调解">调解</a>-->
                                            <a href="<?php echo U('Admin/user/change_termination_status',array('uid'=>$list['uid'],'status'=>-1));?>" id="button-delete6" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="删除">删除</a>
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-6 text-left"></div>
                        <div class="col-sm-6 text-right"><?php echo ($page); ?></div>
                 </div>
                </div>
            </div>
          </div>
      </section>
</div>
                    
<script>
    $(".pagination  a").click(function(){
        var page = $(this).data('p');
        ajax_get_table('search-form2',page);
    });
</script>