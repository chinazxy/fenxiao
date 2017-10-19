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
 

<style>.orderby{width:50px;}</style>
<body>
<div class="wrapper">
	<section class="content">
	<div class="row">
		<form action="<?php echo U('System/ctlSave');?>" method="post" id="ctlform" name="ctlform">
			<table class="table table-bordered table-striped" id="toolbar">
				<tr>
					<th class="col-xs-2">模型标题:</th>
					<th class="col-xs-2">控制器</th>
					<th class="col-xs-2">Action</th>					
					<th class="col-xs-2">父级菜单:</th>
					<th class="col-xs-1">显示</th>
					<th class="orderby">排序</th>
					<th class="col-xs-2"><a href="javascript:void(0)" batch="add_new_line" onClick="add_new_line()">新增一行</a></th>
				</tr>
				<?php if(is_array($modules)): foreach($modules as $key=>$mod): ?><tr id="mod-ctl-<?php echo ($mod["mod_id"]); ?>">
						<td><input type="text" name="module[<?php echo ($mod["mod_id"]); ?>][title]" class="form-control" class="col-xs-3" value="<?php echo ($mod["title"]); ?>"></td>
						<td><input type="text" name="module[<?php echo ($mod["mod_id"]); ?>][ctl]" class="form-control" value="<?php echo ($mod["ctl"]); ?>"></td>
						<td><input type="text" name="module[<?php echo ($mod["mod_id"]); ?>][act]" class="form-control" value="<?php echo ($mod["act"]); ?>"></td>						
						<td>
							<select name="module[<?php echo ($mod["mod_id"]); ?>][parent_id]" class="form-control">
								<?php if(is_array($menu_tree)): foreach($menu_tree as $key=>$v): ?><optgroup label="<?php echo ($v["title"]); ?>">
										<?php if(is_array($v["menu"])): foreach($v["menu"] as $key=>$vv): ?><option value="<?php echo ($vv["mod_id"]); ?>"<?php if($vv["mod_id"] == $mod[parent_id]): ?>selected="selected"<?php endif; ?>><?php echo ($vv["title"]); ?></option><?php endforeach; endif; ?>
									</optgroup><?php endforeach; endif; ?>
							</select>
						</td>
						<td><input type="radio" name="module[<?php echo ($mod["mod_id"]); ?>][visible]" value="1" <?php if($mod["visible"] == 1): ?>checked<?php endif; ?>>是
							<input type="radio" name="module[<?php echo ($mod["mod_id"]); ?>][visible]" value="0" <?php if($mod["visible"] == 0): ?>checked<?php endif; ?>>否</td>
						<td><input type="text" name="module[<?php echo ($mod["mod_id"]); ?>][orderby]" class="form-control" value="<?php echo ($mod["orderby"]); ?>"></td>
						<td><a href="javascript:void(0)"   onClick="ctldelete(<?php echo ($mod["mod_id"]); ?>)">删除</a></td>
					</tr><?php endforeach; endif; ?>
			</table>
		</form>
	</div>
	<div class="pull-right"><input type="button" class="btn btn-primary" onClick="ctlsubmit()" value="提 交 数 据" /></div>
	</section>
	<select style="display:none" id="mod_tree">
		<?php if(is_array($menu_tree)): foreach($menu_tree as $key=>$v): ?><optgroup label="<?php echo ($v["title"]); ?>">
			<?php if(is_array($v["menu"])): foreach($v["menu"] as $key=>$vv): ?><option value="<?php echo ($vv["mod_id"]); ?>"<?php if($pid==$vv[mod_id]): ?>selected="selected"<?php endif; ?>><?php echo ($vv["title"]); ?></option><?php endforeach; endif; ?></optgroup><?php endforeach; endif; ?>	
	</select>
</div>
<script>
var kt = 0;

$(function(){
	//add_new_line();
});

function add_new_line(){
	var tmpstr = '';
	tmpstr += '<tr>';
	tmpstr += '<td class="col-xs-2"><input type="text" name="data['+kt+'][title]"  value=""></td>';
	tmpstr += '<td class="col-xs-2"><input type="text" name="data['+kt+'][ctl]"  value=""></td>';
	tmpstr += '<td class="col-xs-2"><input type="text" name="data['+kt+'][act]" value=""></td>';
	tmpstr += '<td class="col-xs-2">';
	tmpstr += '<select name="data['+kt+'][parent_id]">'
	tmpstr += $('#mod_tree').html();
	tmpstr += '</select></td>';
	tmpstr += '<td class="col-xs-1"><input type="radio" name="data['+kt+'][visible]" value="1">是<input type="radio" name="data['+kt+'][visible]" value="0">否</td>';
	tmpstr += '<td class="orderby"><input type="text" name="data['+kt+'][orderby]" value="50"></td>';
	tmpstr += '<td class="col-xs-2"><a href="###" batch="remove_item_line" onclick="remove_line(this)">取消</a></td>';
	tmpstr += '</tr>';
	$('#toolbar').append(tmpstr);
	kt++;
}

function remove_line(obj){
	$(obj).parent().parent().remove();
	kt--;
	return false;
}

function ctlsubmit(){
	data = $('#ctlform').serializeArray();
	$.ajax({
		type:'post',
		dataType:'json',
		url:"<?php echo U('System/ctlSave');?>",
		data:data,
		success:function(res){
			if(res.stat == 'ok'){
				window.parent.call_back(1);	
			}else{
				window.parent.call_back(0);	
			}
		}
	});
}

function ctldelete(val){
	window.confirm("确定继续,取消停止"); //可以选择去掉
	$.ajax({
		type:'post',
		dataType:'json',
		url:"<?php echo U('System/menuSave/');?>",
		data:{action:'del',mod_id:val},
		success:function(res){
			if(res.stat == 'ok'){
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