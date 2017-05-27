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
				            <div class="navbar-form row">
				            	<button class="btn bg-navy" type="button" onclick="$('span[id^=\'icon_\']').trigger('click');"><i class="fa fa-angle-double-up"></i>收缩</button>
					            <a href="<?php echo U('Article/category');?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>新增分类</a>
				            </div>
				      	</div>
	    			</nav> 	               
	             </div><!-- /.box-header -->
	           <div class="box-body">
	           <div class="row">
	            <div class="col-sm-12">
	              <table id="list-table" class="table table-bordered table-striped">
	                 <thead>
	                   <tr role="row">
		                   <th  style="width: 350px;">分类名称</th>
		                   <th>分类类型</th>
		                   <th>描述</th>
		            <!--        <th>是否显示</th> -->
		             <!--       <th>排序</th> -->
		                   <th>操作</th>
	                   </tr>
	                 </thead>
					<tbody>
					  <?php if(is_array($cat_list)): foreach($cat_list as $k=>$vo): ?><tr role="row" align="center" class="<?php echo ($vo["level"]); ?>" id="<?php echo ($vo["level"]); ?>_<?php echo ($vo["cat_id"]); ?>">
	                     <td class="sorting_1" align="left" style="padding-left:<?php echo ($vo[level] * 4); ?>em"> 
	                      <?php if($vo["is_leaf"] != 1): ?><span class="glyphicon glyphicon-minus btn-warning"  id="icon_<?php echo ($vo["level"]); ?>_<?php echo ($vo["id"]); ?>" aria-hidden="true" onclick="rowClicked(this)" ></span>&nbsp;<?php endif; ?><span><?php echo ($vo["name"]); ?></span>
					     </td>					     
					     <td><?php echo ($vo["cat_alias"]); ?></td>
					     <td><?php echo ($vo["cat_desc"]); ?></td>
	                 <!--     <td>
                             <?php if($vo[show_in_nav] == 1): ?>显示    
                             <?php else: ?> 隐藏<?php endif; ?>
                         </td> -->
	               <!--   <td>                         
                            <input type="text"  class="input-sm" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onpaste="this.value=this.value.replace(/[^\d]/g,'')" onchange="updateSort('article_cat','cat_id','<?php echo ($vo["cat_id"]); ?>','sort_order',this)" size="4" value="<?php echo ($vo["sort_order"]); ?>" />
                         </td> -->
	                      <td>
	                      <a class="btn btn-primary" href="<?php echo U('Article/category',array('act'=>'edit','cat_id'=>$vo['cat_id']));?>"><i class="fa fa-pencil"></i></a>
	                      <?php if($vo["cat_type"] != 1): ?><a class="btn btn-danger" href="javascript:void(0)" data-url="<?php echo U('Article/categoryHandle');?>" data-id="<?php echo ($vo["cat_id"]); ?>" onclick="delfun(this)"><i class="fa fa-trash-o"></i></a>
						  <?php else: ?>
						  	<a class="btn btn-default disabled" href="javascript:void(0)"><i class="fa fa-trash-o"></i></a><?php endif; ?>
						</td>
	                   </tr><?php endforeach; endif; ?>
	                   </tbody>
	               </table></div></div>
		               <div class="row">
			               <div class="col-sm-5">
			               <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">分页</div></div>                                   
		               </div>
	             </div><!-- /.box-body -->
	           </div><!-- /.box -->
       		</div>
       </div>
     </section>
</div>
<script type="text/javascript">
     
// 以下是 bootstrap 自带的  js
function rowClicked(obj)
{
  span = obj;

  obj = obj.parentNode.parentNode;

  var tbl = document.getElementById("list-table");

  var lvl = parseInt(obj.className);

  var fnd = false;
  
  var sub_display = $(span).hasClass('glyphicon-minus') ? 'none' : '' ? 'block' : 'table-row' ;
  //console.log(sub_display);
  if(sub_display == 'none'){
	  $(span).removeClass('glyphicon-minus btn-info');
	  $(span).addClass('glyphicon-plus btn-warning');
  }else{
	  $(span).removeClass('glyphicon-plus btn-info');
	  $(span).addClass('glyphicon-minus btn-warning');
  }

  for (i = 0; i < tbl.rows.length; i++)
  {
      var row = tbl.rows[i];
      
      if (row == obj)
      {
          fnd = true;         
      }
      else
      {
          if (fnd == true)
          {
              var cur = parseInt(row.className);
              var icon = 'icon_' + row.id;
              if (cur > lvl)
              {
                  row.style.display = sub_display;
                  if (sub_display != 'none')
                  {
                      var iconimg = document.getElementById(icon);
                      $(iconimg).removeClass('glyphicon-plus btn-info');
                      $(iconimg).addClass('glyphicon-minus btn-warning');
                  }else{               	    
                      $(iconimg).removeClass('glyphicon-minus btn-info');
                      $(iconimg).addClass('glyphicon-plus btn-warning');
                  }
              }
              else
              {
                  fnd = false;
                  break;
              }
          }
      }
  }

  for (i = 0; i < obj.cells[0].childNodes.length; i++)
  {
      var imgObj = obj.cells[0].childNodes[i];
      if (imgObj.tagName == "IMG")
      {
          if($(imgObj).hasClass('glyphicon-plus btn-info')){
        	  $(imgObj).removeClass('glyphicon-plus btn-info');
        	  $(imgObj).addClass('glyphicon-minus btn-warning');
          }else{
        	  $(imgObj).removeClass('glyphicon-minus btn-warning');
        	  $(imgObj).addClass('glyphicon-plus btn-info');
          }
      }
  }

}

function delfun(obj){
	if(confirm('确认删除')){		
		$.ajax({
			type : 'post',
			url : $(obj).attr('data-url'),
			data : {act:'del',cat_id:$(obj).attr('data-id')},
			dataType : 'json',
			success : function(data){
				if(data==1){
					$(obj).parent().parent().remove();
				}else{
					layer.alert(data, {icon: 2});  //alert(data);
				}
			}
		})
	}
	return false;
}
</script>
</body>
</html>