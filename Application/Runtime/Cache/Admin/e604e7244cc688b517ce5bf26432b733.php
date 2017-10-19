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
ul.group-list {
    width: 96%;
    min-width: 1000px;
    margin: auto 5px;
    list-style: disc outside none;
}
ul.group-list li {
    white-space: nowrap;
    float: left;
    width: 150px;
    height: 25px;
    padding: 3px 5px;
	list-style-type: none;
    list-style-position: outside;
    border: 0px;
    margin: 0px;
}
th.title {
    background: #F3F3F3;
    border-bottom: 1px solid #D7D7D7;
    font-weight: bold;
    white-space: nowrap;
}
</style>
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
		<div class="col-sm-12">		        	
			<form action="<?php echo U('Admin/Admin/roleSave');?>" id="roleform" method="post">
			<input type="hidden" name="role_id" value="<?php echo ($detail["role_id"]); ?>" />
			<table class="table table-bordered table-striped">
				<tr>
					<th>角色名称:</th>
					<td><div class="col-xs-6"><input type="text" class="form-control" name="data[role_name]" id="role_name" value="<?php echo ($detail["role_name"]); ?>"></div></td>
					<th >角色描述:</th>
					<td><textarea rows="2" name="data[role_desc]"><?php echo ($detail["role_desc"]); ?></textarea></td>
					<th>分配权限:</th>
					<th class=""><input class="allChoose" name="" onclick="choosebox(this)" type="checkbox">全部选中</th>
					<td class=""><a href="javascript:void(0)" onclick="roleSubmit()" class="btn btn-info">保存</a></td>
				</tr>
			</table>
			<table class="table table-bordered table-striped dataTable">
				<?php if(is_array($menu_tree)): foreach($menu_tree as $key=>$v): if(is_array($v["menu"])): foreach($v["menu"] as $key=>$vv): ?><tr>
							<td class="title left" style="padding-right:50px;">
								<?php echo ($v["title"]); ?> &gt; <?php echo ($vv["title"]); ?>
								<noempty name="vv.menu">
									<label class="right"><input type="checkbox" value="1" cka="mod-<?php echo ($vv["mod_id"]); ?>">全部子模块</label>
								</noempty>
							</td>
						</tr>
						<tr>
							<td>
								<ul class="group-list">
								<?php if(is_array($vv["menu"])): foreach($vv["menu"] as $key=>$vvv): ?><li><label><input type="checkbox" name="menu[]" <?php if($vvv[enable] == 1): ?>checked<?php endif; ?> value="<?php echo ($vvv["mod_id"]); ?>" ck="mod-<?php echo ($vv["mod_id"]); ?>"><?php echo ($vvv["title"]); ?></label></li><?php endforeach; endif; ?>
								<div class="clear-both"></div>
								</ul>
							</td>
						</tr><?php endforeach; endif; endforeach; endif; ?>
			</table>
			<div class="page-bar">
				<table>
					<tr>
						<td><label><input class="allChoose" name="" onclick="choosebox(this)" type="checkbox">全部选中</label></td>
						<td class="left"><a href="javascript:void(0)" onclick="roleSubmit()" class="btn btn-default">提交数据</a></td>			
						<td class="page-list"></td>
					</tr>
				</table>
			</div>
			</form>
		</div>
	</div></section>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$(":checkbox[cka]").click(function(){
		var $cks = $(":checkbox[ck='"+$(this).attr("cka")+"']");;
		if($(this).is(':checked')){
			$cks.each(function(){$(this).prop("checked",true);});
		}else{
			$cks.each(function(){$(this).removeAttr('checked');});
		}
	});
});

function choosebox(o){
	var vt = $(o).is(':checked');
	if(vt){
		$('input[type=checkbox]').prop('checked',vt);
	}else{
		$('input[type=checkbox]').removeAttr('checked');
	}
}

function roleSubmit(){
	if($('#role_name').val() == '' ){
		layer.alert('角色名称不能为空', {icon: 2});  //alert('少年，角色名称不能为空');
		return false;
	}
	$('#roleform').submit();
}
</script>
</body>
</html>