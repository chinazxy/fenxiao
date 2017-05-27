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
<title><?php echo ($upshop_config['shop_info_store_title']); ?></title>
<meta http-equiv="keywords" content="<?php echo ($upshop_config['shop_info_store_keyword']); ?>" />
<meta name="description" content="<?php echo ($upshop_config['shop_info_store_desc']); ?>" />
<meta name="Keywords" content="upshop触屏版  upshop 手机版" />
<meta name="Description" content="upshop触屏版   upshop商城 "/>
<link rel="stylesheet" href="/Template/mobile/new/Static/css/public.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/user.css">
<script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/common.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/modernizr.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/layer.js" ></script>
</head>

<link rel="stylesheet" href="/Template/mobile/new/Static/css/main.css">

<body>
<header>
<div class="tab_nav">
  <div class="header">
    <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
    <div class="h-mid">退货</div>
    <div class="h-right">
      <aside class="top_bar">
        <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
      </aside>
    </div>
  </div>
</div>
</header>
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
	<form name="return_form" id="return_form" autocomplete="off" method="post" enctype="multipart/form-data" >
		<div class="main_sq">
			<!--<div class="touchweb-com_searchListBox" id="goods_list">
		   		<li>
	                <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$goods['goods_id']));?>" class="item">
						<div class="pic_box">
	                        <img title="<?php echo ($goods['goods_name']); ?>" src="<?php echo (goods_thum_images($goods[goods_id],400,400)); ?>" />
						</div>
						<div class="title_box"><?php echo ($goods['goods_name']); ?></div>
					</a>
			    </li>
			</div>
		<div class="T_H">
			<div class="retu_sq"><a id="retu_a_sq" class="orange_sq">退货</a><input type="radio" style="display:;" checked="" value="0" name="type"></div>
			<div class="chan_sq"><a id="chec_a_sq">换货</a><input type="radio" style="display:;" value="1" name="type"></div>
		</div>-->
        <div class="cart">
			<?php if(is_array($goods)): foreach($goods as $key=>$g): ?><div class="product_list1" style="border-bottom:1px solid #ccc; margin:0 2%; ">
					<div class="product_box" style="margin-top:2%;padding-right:0;">
						<div class="product_box_img" style="left:0;"><img src="<?php echo ($g["img"]); ?>"></div>
						<div class="name" style="margin-bottom:10px;"><?php echo ($g["goods_name"]); ?><span class="stock" style="float:right">订单数量：<?php echo ($g["goods_num"]); ?></span></div>
						<div class="spec" style="margin-bottom:10px;"><i>规格:<?php echo ($g["spec_key_name"]); ?></i></div>
						<input type="hidden" value="<?php echo ($g["stock"]); ?>" class="user_stock">
						<div class="price">￥<?php echo ($g["member_goods_price"]); ?></div>
						<div class="cart_btn clearfix" style="border:none;margin:0;padding:0;background:none;border-top:none;position:absolute;right:0;bottom:15px;">
					<div class="f-right  goods_info" ><input type="hidden" name="goods_id[]"value="<?php echo ($g["goods_id"]); ?>"><input class="number p_ding" name="goods_num[]" type="text" value=" " onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^0-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^0-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"><input class="prices " name="goods_peice[]"type="hidden" value="<?php echo ($g["member_goods_price"]); ?>"/>单位(件)</div>
					
						<span class="cart_btn_a " style="visibility:hidden"><i></i><span>删除</span></span><input class="delet" type="hidden" value="160">
						
					</div>
					</div>
				
					
				</div><?php endforeach; endif; ?>
        </div>
        <style>
		body{background:#fff;}
		.cart_btn .cart_btn_a span{margin-left:0;}
		.number{width:50px;margin-left:5px;}
		</style>
        
		<div class="ques_sq">
			<div class="ques_desc_sq">
				<span style="width:100%;text-align:left;float:left;">问题描述</span>
				<div class="textarea_sq">
	                <textarea name="reason" id="reason" placeholder="请在此描述详细问题" style="width:96%;"></textarea>
				</div>
			</div>
		</div>	
		<div class="file_up_sq">
			<div class="file_sq">
				<div> 
					<div class="p_main" style="width:100%;">
                        <p>上传图片</p>
                        <a class="file" href="javascript:;"><div style="width:200px;height:200px;" id="fileList0"><img width="200" height="200"></div><input type="file" accept="image/*" name="return_imgs[]" onChange="handleFiles(this,0)"></a>
                        <!--<a class="file" href="javascript:;"><div style="width:60px;height:60px;" id="fileList1"><img width="60" height="60"></div><input type="file" accept="image/*" name="return_imgs[]" onChange="handleFiles(this,1)"></a>
                        <a class="file" href="javascript:;"><div style="width:60px;height:60px;" id="fileList2"><img width="60" height="60"></div><input type="file" accept="image/*" name="return_imgs[]" onChange="handleFiles(this,2)"></a>
                        <a class="file" href="javascript:;"><div style="width:60px;height:60px;" id="fileList3"><img width="60" height="60"></div><input type="file" accept="image/*" name="return_imgs[]" onChange="handleFiles(this,2)"></a>-->
                        <span style=" font-size:14px; display:block; width:100%; overflow:hidden">
                    </div>
				</div>
			</div>
		</div>
		<div class="ques_sq">
			<div class="ques_desc_sq">
				<span>快递单号</span>
				<div class="input_kd"><input name="return_sn" type="text" class="form-control" placeholder="请在此填入寄回快递单号" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[\u4e00-\u9fa5]/g,''))" onkeyup="this.value=this.value.replace(/[\u4e00-\u9fa5]/g,'')"></div>
			</div>
		</div>
		<div class="send sq">
			<!-- <div class="sendssq">
				<span>寄回地址：</span>
				<ul>
					<li>寄回地址：<?php echo ($upshop_config['shop_info_address']); ?></li>
					<li>上班时间：（周一至周五）08：00-19:00（周六日休息）</li>
					<li>客服电话：<?php echo ($upshop_config['shop_info_phone']); ?></li>
				</ul>
			</div> -->
		</div>
		<div class="submit_sq">
	        <a href="javascript:void(0)" onClick="submit_form();" name="btnSubmit"><s></s>提交</a>
		</div>
	</div>
      <input type="hidden" name="order_id" value="<?php echo ($order_id); ?>" />
      <input type="hidden" name="order_sn" value="<?php echo ($order_sn); ?>" />   
 </form>    
 
<script type="text/javascript">
  function submit_form()
  {
	  var user_stock = $('.user_stock').val();
	  var number = $('.number').val();
	  console.log(user_stock);
	  console.log(number);
	  if(number-user_stock>0){
		  alert('现库存不满足退货数量');
		  return;
	  }
	  var reason = $.trim($('#reason').val());
	  var return_imgs= $.trim($('#return_imgs').val());
	  var control = $.trim($('.form-control').val());
	  if(reason == '')
	  {
		  alert('请输入退换货原因');// alert('请输入退换货原因!');
		  return;
	  }
	  if(control =''){
		  alert('请输入快递单号');
		  return;
	  }
	  var ff = document.getElementsByName("return_imgs[]");
	  //if((ff[0].value.length + ff[1].value.length + ff[2].value.length + ff[3].value.length) == 0)
	  if(ff[0].value.length == 0)
	  {
		  if(!confirm('确定不传照片吗?'))
		  {
			  return;
		  }
      }
	  $('#return_form').submit();
  } 
   
   //  退换货颜色切换
	$(document).ready(function(){
			//$('#retu_a_sq').addClass('orange_sq');
			$('#retu_a_sq').click(function(){
				if ($(this).hasClass('orange_sq')) {
					$('#chec_a_sq').removeClass('orange_sq');
				} else{
					$(this).addClass('orange_sq');
					$(this).siblings('input').trigger('click');
					$('#chec_a_sq').removeClass('orange_sq');
				}
			});
			$('#chec_a_sq').click(function(){
				if ($(this).hasClass('orange_sq')) {
					$('#retu_a_sq').removeClass('orange_sq');
				} else{
					$(this).addClass('orange_sq');
					$(this).siblings('input').trigger('click');						
					$('#retu_a_sq').removeClass('orange_sq');
				}
			})

	})
	
window.URL = window.URL || window.webkitURL;
function handleFiles(obj,id) {
	fileList = document.getElementById("fileList"+id);
		var files = obj.files;
		img = new Image();
		if(window.URL){	
			
			img.src = window.URL.createObjectURL(files[0]); //创建一个object URL，并不是你的本地路径
			img.width = 200;
	    	img.height = 200;
			img.onload = function(e) {
				window.URL.revokeObjectURL(this.src); //图片加载后，释放object URL
			}
		    if(fileList.firstElementChild){
		         fileList.removeChild(fileList.firstElementChild);
		    } 
			fileList.appendChild(img);
		}else if(window.FileReader){
			//opera不支持createObjectURL/revokeObjectURL方法。我们用FileReader对象来处理
			var reader = new FileReader();
			reader.readAsDataURL(files[0]);
			reader.onload = function(e){	
		            img.src = this.result;
		            img.width = 200;
		            img.height = 200;
		            fileList.appendChild(img);
			}
	    }else
	    {
			//ie
			obj.select();
			obj.blur();
			var nfile = document.selection.createRange().text;
			document.selection.empty();
			img.src = nfile;
			img.width = 200;
		    img.height = 200;
			img.onload=function(){
			  
		    }
			fileList.appendChild(img);
	    }
}
	
</script>
</body>
</html>