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
 

<style>
.iconspan{
	padding:1px;
}
</style>
<div class="wrapper">
     <form method="post" id="handlepost" action="<?php echo U('System/menuSave');?>">
      <input type="hidden" name="mod_id" value="<?php echo ($menu["mod_id"]); ?>">
      <div class="tab-content col-md-10">                 	  
          <div class="tab-pane active" id="tab_tongyong">                           
	        <table class="table table-bordered">
	            <tbody>
	            <tr>
	                <td class="col-sm-2">菜单名称：</td>
	                <td class="col-sm-8">
	                    <input type="text" class="form-control" name="title" value="<?php if($action == 'edit'): echo ($menu["title"]); endif; ?>" >                                                         
	                </td>
	            </tr> 
	            <tr>
	            <td>上级菜单：</td>
	            <td>
		   		<?php if(($menu["module"] == 'top') and ($action == 'edit')): ?>顶级菜单
				<?php else: ?>						
				<select name="parent_id" id="parent_id" value="<?php echo ($menu["parent_id"]); ?>">	
					<?php if(!$menu && !$pid) echo '<option value="0">顶级菜单</option>'; ?>		
					<?php if(is_array($tree)): foreach($tree as $key=>$v): ?><option value="<?php echo ($v["mod_id"]); ?>" <?php if(($v["mod_id"] == $menu[parent_id]) or ($v["mod_id"] == $pid )): ?>selected="selected"<?php endif; ?>>&nbsp;&nbsp;|--<?php echo ($v["title"]); ?></option><?php endforeach; endif; ?>
				</select><?php endif; ?>                          
	            </td>
	            </tr>
	            <tr>
	            	<td>图标：</td>
	            	<td>
	            		<div class="row">
	            			<span class="iconspan"><input type="radio" <?php if($menu["icon"] == 'fa-tasks'): ?>checked<?php endif; ?> name="icon" value="fa-tasks">&nbsp;&nbsp;<i class="fa fa-tasks"></i></span>
	            			<span class="iconspan"><input type="radio" <?php if($menu["icon"] == 'fa-cog'): ?>checked<?php endif; ?> name="icon" value="fa-cog">&nbsp;&nbsp;<i class="fa fa-cog"></i></span>
	            			<span class="iconspan"><input type="radio" <?php if($menu["icon"] == 'fa-dashboard'): ?>checked<?php endif; ?> name="icon" value="fa-dashboard">&nbsp;&nbsp;<i class="fa fa-dashboard"></i></span>
	            			<span class="iconspan"><input type="radio" <?php if($menu["icon"] == 'fa-retweet'): ?>checked<?php endif; ?> name="icon" value="fa-retweet">&nbsp;&nbsp;<i class="fa fa-retweet"></i></span>
	            			<span class="iconspan"><input type="radio" <?php if($menu["icon"] == 'fa-navicon'): ?>checked<?php endif; ?> name="icon" value="fa-navicon">&nbsp;&nbsp;<i class="fa fa-navicon"></i></span>
	            			<span class="iconspan"><input type="radio" <?php if($menu["icon"] == 'fa-table'): ?>checked<?php endif; ?> name="icon" value="fa-table">&nbsp;&nbsp;<i class="fa fa-table"></i></span>
	            			<span class="iconspan"><input type="radio" <?php if($menu["icon"] == 'fa-bar-chart'): ?>checked<?php endif; ?>  name="icon" value="fa-bar-chart">&nbsp;&nbsp;<i class="fa fa-bar-chart"></i></span>
	            		</div>
	            		<div class="row">
	            			<span class="iconspan"><input type="radio"  <?php if($menu["icon"] == 'fa-plug'): ?>checked<?php endif; ?> name="icon" value="fa-plug">&nbsp;&nbsp;<i class="fa fa-plug"></i></span>
	            			<span class="iconspan"><input type="radio"  <?php if($menu["icon"] == 'fa-book'): ?>checked<?php endif; ?> name="icon" value="fa-book">&nbsp;&nbsp;<i class="fa fa-book"></i></span>
	            			<span class="iconspan"><input type="radio"  <?php if($menu["icon"] == 'fa-flag'): ?>checked<?php endif; ?> name="icon" value="fa-flag">&nbsp;&nbsp;<i class="fa fa-flag"></i></span>
	            			<span class="iconspan"><input type="radio"  <?php if($menu["icon"] == 'fa-home'): ?>checked<?php endif; ?> name="icon" value="fa-home">&nbsp;&nbsp;<i class="fa fa-home"></i></span>
	            			<span class="iconspan"><input type="radio"  <?php if($menu["icon"] == 'fa-pencil'): ?>checked<?php endif; ?> name="icon" value="fa-pencil">&nbsp;&nbsp;<i class="fa fa-pencil"></i></span>
	            			<span class="iconspan"><input type="radio"  <?php if($menu["icon"] == 'fa-star'): ?>checked<?php endif; ?> name="icon" value="fa-star">&nbsp;&nbsp;<i class="fa fa-star"></i></span>
	            			<span class="iconspan"><input type="radio"  <?php if($menu["icon"] == 'fa-user'): ?>checked<?php endif; ?> name="icon" value="fa-user">&nbsp;&nbsp;<i class="fa fa-user"></i></span>
	            		</div>
	            	</td>
	            </tr>
	            <tr>
	                <td>排序：</td>
	                <td><input type="text" name="orderby" value="<?php if($menu["orderby"] > 0): echo ($menu["orderby"]); else: ?>50<?php endif; ?>" /></td>
	            </tr>
	            </tbody> 
	            <tfoot>
	            	<tr>
	            	<td><input type="hidden" name="action" value="<?php echo ($action); ?>">
	            	</td>
	            	<td class="text-right"><input class="btn btn-primary" type="button" onclick="dataSave()" value="保存"></td></tr>
	            </tfoot>                               
	          </table>
	          </div>                           
	      </div>              
</form>
</div>
<script type="text/javascript">
	function dataSave(){
		var title = $('input[name="title"]').val();
		var parent_id = $('#parent_id').val();
		var orderby = $('input[name="orderby"]').val();
		var action = $('input[name="action"]').val();
		var mod_id = $('input[name="mod_id"]').val();
		var icon = $('input:radio[name="icon"]:checked').val();
		$.ajax({
			url : "<?php echo U('System/menuSave');?>",
			data : {title:title,parent_id:parent_id,orderby:orderby,action:action,mod_id:mod_id,icon:icon},
			type : 'post',
			dataType : 'json',
			success :function(data){
				if(data.stat=='ok'){
					window.parent.call_back(1);	
				}else{
					window.parent.call_back(0);
				}						
			}			
		});		
	}
</script>
</body>
</html>