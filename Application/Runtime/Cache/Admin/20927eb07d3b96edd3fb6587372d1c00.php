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
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                    	<i class="fa fa-list"></i>&nbsp;角色管理
                    </h3>
                </div>
                <div class="panel-body">
                <nav class="navbar navbar-default">	     
			        <div class="collapse navbar-collapse">
			          <form class="navbar-form form-inline" role="search">
			            <div class="form-group pull-right">
				            <a href="<?php echo U('Admin/role_info');?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>添加角色</a>
			            </div>		          
			          </form>		
			      	</div>
    			</nav>
	            <div class="table-responsive">
		             <table  class="table table-bordered table-striped">
		                <thead>
		                   <tr>
			                   <th>ID</th>
			                   <th>角色名称</th>
			                   <th>描述</th>
			                   <th>操作</th>
		                   </tr>
		                </thead>
						<tbody>
						  <?php if(is_array($list)): foreach($list as $k=>$vo): if($vo['role_id'] > 1): ?><tr role="row" align="center">
				                     <td><?php echo ($vo["role_id"]); ?></td>
				                     <td><?php echo ($vo["role_name"]); ?></td>
				                     <td><?php echo ($vo["role_desc"]); ?></td>
				                     <td>
				                      <a class="btn btn-primary" href="<?php echo U('Admin/role_info',array('role_id'=>$vo['role_id']));?>"><i class="fa fa-pencil"></i></a>
				                      <a class="btn btn-danger" href="javascript:void(0)" data-url="<?php echo U('Admin/roleDel');?>" data-id="<?php echo ($vo["role_id"]); ?>" onclick="delfun(this)"><i class="fa fa-trash-o"></i></a>
									 </td>
			                    </tr><?php endif; endforeach; endif; ?>
		                   </tbody>
		               </table>
		            </div>	 
	              	<div class="row">
	              	    <div class="col-sm-6 text-left"></div>
	                    <div class="col-sm-6 text-right"><?php echo ($page); ?></div>		
	              	</div>
	          </div>
	        </div>
       	</div>
      </div>
   </section>
</div>
<script>
function delfun(obj){
	if(confirm('确认删除')){		
		$.ajax({
			type : 'post',
			url : $(obj).attr('data-url'),
			data : {act:'del',role_id:$(obj).attr('data-id')},
			dataType : 'json',
			success : function(data){
				if(data==1){
					$(obj).parent().parent().remove();
				}else{
					layer.alert(data, {icon: 2});   //alert('用户名或密码不能为空');// alert(data);
				}
			}
		})
	}
	return false;
}
</script>  
</body>
</html>