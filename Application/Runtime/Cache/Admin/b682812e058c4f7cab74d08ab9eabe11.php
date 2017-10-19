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
	             <div class="box-header">
	               	<nav class="navbar navbar-default">	     
				        <div class="collapse navbar-collapse">
				          <form class="navbar-form form-inline" action="<?php echo U('Admin/index');?>" method="post">
				            <div class="form-group">
				              	<input type="text" name="keywords" class="form-control" placeholder="搜索">
				            </div>
				            <button type="submit" class="btn btn-default">提交</button>
				            <div class="form-group pull-right">
					            <a href="<?php echo U('Admin/admin_info');?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>添加管理员</a>
				            </div>		          
				          </form>		
				      	</div>
	    			</nav>  
	             </div>	             
	             <div class="box-body">	               
	           		<div class="row">
	            	<div class="col-sm-12">
		              <table id="list-table" class="table table-bordered table-striped dataTable">
		                 <thead>
		                   <tr role="row">
			                   <th>ID</th>
			                   <th>用户名</th>
			                   <th>所属角色</th>
			                   <th>Email地址</th>
			                   <th>加入时间</th>
			                   <th>操作</th>
		                   </tr>
		                 </thead>
						<tbody>
						  <?php if(is_array($list)): foreach($list as $k=>$vo): ?><tr role="row" align="center">
		                     <td><?php echo ($vo["admin_id"]); ?></td>
		                     <td><?php echo ($vo["user_name"]); ?></td>
		                     <td><?php echo ($vo["role"]); ?></td>
		                     <td><?php echo ($vo["email"]); ?></td>
		                     <td><?php echo ($vo["add_time"]); ?></td>
		                     <td>
		                      <a class="btn btn-primary" href="<?php echo U('Admin/admin_info',array('admin_id'=>$vo['admin_id']));?>"><i class="fa fa-pencil"></i></a>
		                      <?php if($vo['admin_id'] > 1): ?><a class="btn btn-danger" href="javascript:void(0)" data-url="<?php echo U('Admin/adminHandle');?>" data-id="<?php echo ($vo["admin_id"]); ?>" onclick="delfun(this)"><i class="fa fa-trash-o"></i></a><?php endif; ?>
							</td>
		                   </tr><?php endforeach; endif; ?>
		                   </tbody>
		                 <tfoot>		                 
		                 </tfoot>
		               </table>	 
	               </div>
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
			data : {act:'del',admin_id:$(obj).attr('data-id')},
			dataType : 'json',
			success : function(data){
				if(data==1){
					$(obj).parent().parent().remove();
				}else{
					layer.alert(data, {icon: 2});   //alert('用户名或密码不能为空');// alert(data);
					layer.closeAll();
				}
			}
		})
	}
	return false;
}
</script> 
</body>
</html>