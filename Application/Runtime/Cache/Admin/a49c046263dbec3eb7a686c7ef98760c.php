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
 


 <section class="content">
       <div class="table-responsive">
            
             <table class="table table-bordered table-hover">
                <thead>
            <tr>
              
             
                <td class="text-left">
                    <a href="javascript:sort('goods_name');">商品名称</a>
                </td>
                                           
                <td class="text-left">
                    <a href="javascript:sort('cat_id');">分类</a>
                </td>

                <td class="text-left">
                    <a href="javascript:sort('key_name');">规格属性</a>
                </td>
              <td class="text-left">
                    <a href="javascript:void(0);">库存</a>
                </td>

            </tr>
            </thead>
              <tbody>
                <?php if(is_array($list)): foreach($list as $key=>$l): ?><tr>
               
                        <td><?php echo ($l["goods_name"]); ?></td>
                        <td><?php echo ($l["cate_name"]); ?></td>
                        <td><?php echo ($l["key_name"]); ?></td>
                        <td><input type='hidden' value='<?php echo ($l["spec_id"]); ?>'><input class='stock' type='number' value='<?php echo ($l["stock"]); ?>'><input type='hidden' value='<?php echo ($l["goods_id"]); ?>'></td>
                    </tr><?php endforeach; endif; ?>
              </tbody>          
             </table>
      <div class="table-responsive">
 </section>
<div class="kc" style="width:280px;height:100px;line-height:100px;text-align:center;font-size:24px;border:1px solid #ccc;border-radius:6px;background:#fff;position:fixed;top:50%;left:50%;margin:-50px 0 0 -140px;display:none;">库存修改成功</div>
 <script>
 $(function(){
	 $('.stock').blur(function(){
		
	     var re =/^(0|[1-9]\d*)$/;
         if(!re.test($(this).val())){alert('请输入正确库存');return;}

		 var stock = $(this).val();
		 var spec_id = $(this).prev().val();
		 console.log(spec_id);
		
		 var goods_id = $(this).next().val();
		 console.log(goods_id);
		 $.get("<?php echo U('change_stock');?>",{spec_id:spec_id,goods_id:goods_id,stock:stock},function(data){
			
			if(data!=1){
				alert('修改库存失败');
			}else{
        $('.kc').show();
        setTimeout(function(){
          $('.kc').hide()
        },700)
      }
		 })
	 })
 })
 
 </script>