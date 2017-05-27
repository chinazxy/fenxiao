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
 

<link href="/Public/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<script src="/Public/plugins/daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="/Public/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<div class="wrapper">
    <!-- Content Header (Page header) -->
    <div class="breadcrumbs" id="breadcrumbs">
	<ol class="breadcrumb">
	<?php if(is_array($navigate_admin)): foreach($navigate_admin as $k=>$v): if($k == '后台首页'): ?><li><a href="<?php echo ($v); ?>"><i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo ($k); ?></a></li>
	    <?php else: ?>
	        <li><a href="<?php echo ($v); ?>"><?php echo ($k); ?></a></li><?php endif; endforeach; endif; ?>
	</ol>
</div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-list"></i> 消息列表  </h3>
                    </div>
                   <div class="panel-body">
                    <div class="tab-content">                    
                        <div class="tab-pane active" id="tab_tongyong">
                             <table class="table table-bordered">
                                <tbody>
                                  
                                    <tr>
                                       <th width="12%">消息标题</th>
                                       <th width="12%">接收用户</th>
                                       <th width="12%">用户联系方式</th>
                                       <th width="52%">消息内容</th>
                                       <th width='12%'>操作</th>
                                    </tr>
                                  <?php if(is_array($msgList)): foreach($msgList as $key=>$msg): ?><tr>
                                       <td><?php echo ($msg["title"]); ?></td>
                                       <td><?php echo ($msg["userInfo"]["username"]); ?></td>
                                       <td><?php echo ($msg["userInfo"]["mobile"]); ?></td>
                                       <td><textarea style='width:90%;height:70px;'><?php echo ($msg["content"]); ?></textarea></td>
                                       <th width='10%'><a class='delete' href='javascript:;'>删除</a><input type='hidden' value="<?php echo ($msg["id"]); ?>" /></th>
                                    </tr><?php endforeach; endif; ?> 
                                </tbody>                                 
                                </table>
                                <?php echo ($pager); ?>
                        </div>
                   </div>
                </div>
             </div>
        </div>
        <script>
           $('.delete').on('click',function(){
        	   var parent = $(this).parents('tr');
        	   console.log(parent);
        	   var msg_id = $(this).next().val();
        	 
        	   $.get("<?php echo U('delete');?>",{msg_id:msg_id},function(data){
        		   if(data.status==1){
        			   window.location.reload();
        		   }else{
        			   alert('删除失败');
        		   }
        	   })
           })
        </script>
     </section>