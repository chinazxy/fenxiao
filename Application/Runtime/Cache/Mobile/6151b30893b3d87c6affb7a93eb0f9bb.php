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

    <link rel="stylesheet" href="/Public/jd/css/chencc.css">
<style>
	.goods_nav{top:50px;}
	.ccslider .ccslider-content{padding-top:70px;}
	.close_box{text-align:right;margin:-10px 0 0 0;padding-right:10px;}
.close_box .ccslider-close{display:inline-block;}
</style>
<body>

<div id="pageContent">
	<div class="header2">
    	<a onClick="history.go(-1)"><i></i><span></span></a>
        <!--<a href="<?php echo U('Mobile/Index/index');?>" class="icon icon_home"></a>-->
        <aside class="top_bar">
         <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
       </aside>
        <p>添加帐户</p>
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
    <div style="height:45px;"></div>
	<div class="centent_box">
        <div class="z-div bo_bo clearfix">
            <div class="col-xs-3 bo_ob">真实姓名</div>
            <div class="col-xs-8"><input type="text" name="user_name" class="user_name form-control" placeholder=""></div>
        </div>
        <div class="z-div bo_bo clearfix">
            <div class="col-xs-3 bo_ob">支付宝帐户</div>
            <div class="col-xs-8"><input type="text" name="account_num" class="account_num form-control" placeholder="" onkeyup="this.value=this.value.replace(/[\u4e00-\u9fa5]/g,'')" ></div>
        </div>
        <div class="z-div bo_bo clearfix">
            <div class="col-xs-3 bo_ob">手机号码</div>
            <div class="col-xs-8"><input type="text" name="mobile" class="mobile form-control" placeholder="" onkeyup="this.value=this.value.replace(/[^0-9-]+/,'');" ></div>
        </div>
        
        <div class="text-center z-page-btn"><input type="checkbox" id="radio" value="1"/><a class="z-color-main xieyi">诚享东方提现协议</a></div>
        <div class="z-padding-3x z-page-btn" id="button" style="background:none;"><a class="btn btn-lg btn-block z-bg-main">同意协议并绑定</a></div>
	</div>
</div>
<!-- 侧边栏 -->
    <div class="ccslider">
        <div class="ccslider-content">
        	<div class="close_box"><a class="ccslider-close icons icons-close"></a></div>
            <div class="col-xs-12"><?php echo ($article["content"]); ?></div>
        </div>
    </div>
<script>
	$(function(){
		/* 侧边栏开启 */
			$(".xieyi").on("click",function(){
				$(".ccslider").fadeIn("fast");
				setTimeout(function(){
					$(".ccslider").addClass("active");
				},10)
			});
			/* 侧边栏关闭 */
            $(".ccslider-close").on("click",function(){
                $(".ccslider").removeClass("active").fadeOut("fast");
            });
		$("#button").click(function(){
		    var mobile = $(".mobile").val();
		    var user_name = $('.user_name').val();
			var account_num = $(".account_num").val();
			var pay = /[\u4E00-\u9FA5]+/;
			var email = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
			var telPattern=/^[1][34578][0-9]{9}$/;
			var reg = /^[^\s]*$/;
			if(user_name == ""){
			    alert('姓名不能为空');
				return;
			}
			if(!reg.test(user_name)){
				alert('姓名格式不正确');
				return;
			}
			if($('#radio').attr("checked") !='checked'){
				alert('请同意提现协议！');
				return;
			}
			if(account_num == ""){
			    alert("支付宝帐号不能为空");
				return;
			}
			if(pay.test(account_num)){
			    alert("支付宝帐号不能为中文");
				return;
			}
			if(!email.test(account_num) && !telPattern.test(account_num)){
			    alert("支付宝帐号格式错误");
				return;
			}
			if(mobile==""||isNaN(mobile)){
			        alert('请输入手机号');
                    return;exit;
                };
                if(mobile.length<11){
				    alert('请输入11位手机号');
                    return;
                }
                if(!telPattern.test(mobile)){
				    alert('请输入正确的手机号');
                    return;
                }
			$.post('',{user_name:user_name,account_num:account_num,mobile:mobile},function(resp){
				if(resp.status){
					alert(resp.info);
					location.href="<?php echo U('index');?>";
				}else{
					alert(resp.info);
				}
			});
		});
	});
</script>
</body>
</html>