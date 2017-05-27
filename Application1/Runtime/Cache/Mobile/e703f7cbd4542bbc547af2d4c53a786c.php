<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
<meta name="Generator" content="upshop v1.1" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="format-detection" content="telephone=no" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="applicable-device" content="mobile">
<title></title>
<meta http-equiv="keywords" content="<?php echo ($upshop_config['shop_info_store_keyword']); ?>" />
<meta name="description" content="<?php echo ($upshop_config['shop_info_store_desc']); ?>" />
<meta name="Keywords" content="upshop触屏版  upshop 手机版" />
<meta name="Description" content="upshop触屏版   upshop商城 "/>
<link rel="stylesheet" href="/Template/mobile/new/Static/css/zui.min.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/main.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/public.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/m.css">
<script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/common.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/modernizr.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/layer.js" ></script>
<!-- <?php echo ($upshop_config['shop_info_store_title']); ?> -->
</head>


<body>
<div class="header2">
	<a><i onClick="history.go(-1)"></i></a>
	<!--<a href="<?php echo U('Mobile/Index/index');?>" class="icon icon_home"></a>-->
	<aside class="top_bar" style="display:none">
		<div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
	</aside>
	<p>详情查看</p>
</div>
<script type="text/javascript" src="/Template/mobile/new/Static/js/mobile.js" ></script>
<div class="goods_nav hid" id="menu">
      <div class="Triangle">
        <h2></h2>
      </div>
      <ul>
        <li><a href="<?php echo U('Index/index');?>"><span class="menu1"></span><i>首页</i></a></li>
        <li><a href="<?php echo U('Cart/cart');?>"><span class="menu3"></span><i>购物车</i></a></li>
        <li style=" border:0;"><a href="<?php echo U('User/index');?>"><span class="menu4"></span><i>我的</i></a></li>
   </ul>
 </div> 
<div style="height:15px;"></div>
<style>
	.Dnone{display:none!important;}
</style>
<div class="z-jxs-detail" style="margin-top:15%">
	<div class="head clearfix">
		<?php if(empty($user["head_pic"])): ?><div class="img"><img class="img-circle" src="/Template/mobile/new/Static/images/user68.jpg"/></div>
			<?php else: ?>
			<div class="img"><img class="img-circle" src="/<?php echo ($user["head_pic"]); ?>"/></div><?php endif; ?>
		<div>
			<div class="col-xs-3"></div>
			<div class="col-xs-3"><?php echo ($user["user_name"]); ?></div>
			<div class="col-xs-3 text-primary"><?php echo ($user["level"]); ?></div>
		</div>
	</div>
	<div class="content"><?php echo ($user["my_desc"]); ?></div>
	<input type="hidden" id="uid" value="<?php echo ($user["user_id"]); ?>"/>
	<input type="hidden" id="my_id" value="<?php echo ($my_id); ?>">
</div>
<div class="z-footer">
	<?php if($type == 1): ?><div class="z-jxs-f col-xs-12">
			<?php if(($my_termination["id"] != '')and($my_termination["status"] < 3)): ?><button class="btn btn-lg btn-block btn-danger" data-toggle="modal" data-target="#myModal" id="step1">已申请解约</button>
				<?php else: ?>
				<button class="btn btn-lg btn-block btn-danger" data-toggle="modal" data-target="#myModal" id="step1">申请解约</button><?php endif; ?>
		</div><?php endif; ?>
	<?php if($termination != ''): ?><div class="z-jxs-f col-xs-12">
			<button class="btn btn-lg btn-block btn-info" data-toggle="modal" data-target="#myModal2">查看解约原因</button>
		</div><?php endif; ?>
</div>

<div class="modal modal-for-page fade jxs-modal" id="myModal" aria-hidden="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php if(empty($$termination)): else: ?>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
					<h4 class="modal-title">解约原因</h4>
				</div><?php endif; ?>
			<div class="modal-body">
				<textarea class="form-control" rows="3" placeholder="请输入解约原因" id="reason"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="quxiao1">取消</button>

				<?php if(($my_termination["id"] != '')and($my_termination["status"] < 3)): ?><button type="button" class="btn btn-primary" id="back">取消解约</button>
					<?php else: ?>
					<button type="button" class="btn btn-primary" id="sure">确定</button><?php endif; ?>
			</div>
		</div>
	</div>
</div>

<div class="modal modal-for-page fade jxs-modal" id="myModal2" aria-hidden="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
				<h4 class="modal-title">解约原因</h4>
			</div>
			<div class="modal-body"><?php echo ($termination["reason"]); ?></div>
			<div class="modal-footer">
				<?php if($termination["status"] != 2): ?><button type="button" class="btn btn-default" data-dismiss="modal"id="reback">拒绝</button>
					<button type="button" class="btn btn-primary" id="agree">同意解约</button><?php endif; ?>
			</div>
		</div>
	</div>
</div>
<!-- <script src="/Public/ihtml/js/jquery-1.9.1.min.js"></script> -->
<script src="/Public/ihtml/js/zui.min.js"></script>
<script type="text/javascript">
	$(function(){

		$('#agree').click(function(){
			var uid = $('#uid').val();
			$.post("<?php echo U('termination');?>",{uid:uid,type:'agree'},function(resp){
				if(resp){
					alert(resp.info);
					location.href ="<?php echo U('my_famil');?>";
				}
			});
		});
		$('#reback').click(function(){
			var uid = $('#uid').val();
			$.post("<?php echo U('termination');?>",{uid:uid,type:'reback'},function(resp){
				if(resp){
					alert(resp.info);
					location.href ="<?php echo U('my_famil');?>";
				}
			});
		});
		$('#step1').click(function(){
			var uid = $('#my_id').val();
			$.post("<?php echo U('get_termination');?>",{uid:uid},function(resp){
				if(resp.status){
					console.log(resp);
					$('#reason').text(resp.info);
					$('#reason').attr('readonly','readonly');
				}else{

				}
			});
		});
		$('#sure').click(function(){
			var reason = $('#reason').val();
			if($('#reason').attr('readonly')=='readonly'){
				$('#quxiao1').click();
			}else{
				$.post("<?php echo U('termination');?>",{reason:reason,type:'sure'},function(resp){
					if(resp){
						alert(resp.info);
						if(resp.status == 1){
							location.href ="<?php echo U('my_famil');?>";
						}
					}
				});
			}


		});
		$('#back').click(function(){
			$.post("<?php echo U('termination');?>",{type:'back'},function(resp){
				if(resp){
					alert(resp.info);
					location.href ="<?php echo U('my_famil');?>";
				}
			});
		});
		$('.modal').on('hide.zui.modal', function() {
			$(this).addClass('Dnone');
		})
		$('.btn').click(function(){
			$('.modal').removeClass('Dnone');
		})
	})
</script>
</body>
</html>