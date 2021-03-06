<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" class="bg">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="robots" content="index,follow" />
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="format-detection" content="telphone=no, email=no" />
    <meta name="renderer" content="webkit">
    <meta name="keywords" content="cchen" />
    <meta name="description" content="诚享东方经销商下单系统" />
    <meta name="author" content="cchen, 719857499@qq.com" />
    <meta name="x5-page-mode" content="app">
    <title></title>
    <!-- 通用类 -->
    <link rel="stylesheet" href="/Public/jd/css/reset.css">
    <link rel="stylesheet" href="/Public/jd/css/bootstrap3.min.css">
    <!-- 插件类 独立性 -->
    <link rel="stylesheet" href="/Public/jd/css/plugin.css">
    <!-- 所有页面类 -->
    <link rel="stylesheet" href="/Public/jd/css/chencc.css">
    
    <style>
	.cc-group a{border-bottom: 1px solid #fff;padding-bottom: 2px;}
	@media (max-height:480px){
		.primary-text{margin-top:10px;margin-bottom:10px!important;}
		.cc-btn{margin-top:20px!important;}
	}
	</style>
</head>
<body class="body-bg">
    <!-- logo -->
    <div class="signup_box">
        <div class="logo">
            <img class="logo-img" src="/Public/jd/img/logo.png" alt="">
        </div>
        <div class="primary-text" style="margin-bottom:15px;">欢迎登录</div>
        <!-- 输入框 -->
        <div class="ccinput-group">
            <input id="tel" type="tel" class="ccinput-input tel" placeholder="手机号">
        
        </div>
         <div class="ccinput-group"> 
            <input id="password" type="password" class="ccinput-input pwd" placeholder="密码">    
        </div>
        <div class="ccinput-group">
            <input id="viry" type="text" class="ccinput-input viry" placeholder="验证码">
           <!--  <div id="mask" class="ccinput-label">验证码</div> -->
            <img id="" style="width:72px;height:30px;padding:0;" class="ccinput-label" src="<?php echo U('MobileBase/verify_c',array());?>" title="点击刷新"/> 
        </div>
    
        <div class="cc-group">
            <a href="<?php echo U('user/forget_pwd');?>" class="cc-group-href">忘记密码</a>
            <a href="<?php echo U('reg');?>" class="cc-group-href right">立即注册</a>
        </div>
        <!-- 登入 -->
        <a class="cc-btn" href="javascript:void(0);" style="margin-top:40px;">登录</a>
    </div>
    <!-- 品牌故事 -->
<!--     <div class="brand">
        <a class="brand-item" href="javascript:void(0);">
            <img src="/Public/jd/img/share.jpg" alt="" class="brand-img">
            <div class="brand-text">品牌故事</div>
        </a>
        <a class="brand-item" href="javascript:void(0);">
            <img src="/Public/jd/img/share.jpg" alt="" class="brand-img">
            <div class="brand-text">品牌故事</div>
        </a>
        <a class="brand-item" href="javascript:void(0);">
            <img src="/Public/jd/img/share.jpg" alt="" class="brand-img">
            <div class="brand-text">品牌故事</div>
        </a>
        <a class="brand-item" href="javascript:void(0);">
            <img src="/Public/jd/img/share.jpg" alt="" class="brand-img">
            <div class="brand-text">品牌故事</div>
        </a>
    </div> -->
    
    
    <!--<div class="up_alert ">-->
    	<!--<p><img src="/Public/jd/img/up_arrow.png" width="100"/></p>-->
    	<!--<div class="content">为了得到更好的用户体验，<br>请在右上角菜单中选择“在浏览器中打开”</div>-->
        <!--<a class="cc-btn-up">已在浏览器中</a>-->
    <!--</div>-->
    
    <script src="/Public/jd/js/jquery.js"></script>
    <script src="/Public/jd/js/plugin.min.js"></script>
    <script>
        $(function(){
			$('.signup_box').css('min-height',$(window).innerHeight());
			$('.up_alert .cc-btn-up').on('click',function(){
				$('.up_alert').hide();
			})
			
            var flag=true;
            var isclick=true;
            /* 倒计时 */
            function numDown(){
                clearInterval(timer);
                var timer,
                timerNum=60;
                var $mask=$("#mask");
                $mask.addClass("active");
                timer=setInterval(function(){
                    timerNum--;
                    var str="剩余"+timerNum+"秒";
                    $mask.text(str);
                    if(timerNum<=0){
                        clearInterval(timer);
                        flag=true;
                        $mask.text("重新获取").removeClass("active");                         
                    }
                },1000);
            };
            /* 验证码 */
            var verifyimg = $('.ccinput-label').attr("src");
             $(".ccinput-label").on("click",function(){
            	 if( verifyimg.indexOf('?')>0){  
                     $(this).attr("src", verifyimg);  
                 }else{  
                     $(this).attr("src", verifyimg.replace(/\?.*$/,''));  
                 } 
               /*  var tel=$("#tel").val().trim();
                var telPattern=/^[1][3578][0-9]{9}$/;
                var $mask=$(this);
                 if(tel==""||isNaN(tel)){
                    $.toast({text:"请输入手机号"});
                    return;
                };
                if(tel.length<11){
                    $.toast({text:"请输入11位手机号"});
                    return;
                }
                if(!telPattern.test(tel)){
                    $.toast({text:"请输入正确的手机号"});
                    return;
                } 
                if(flag){
                    flag=false;
                    $.toast({text:"正在发送..."});
                    $.ajax({
                        url:"",
                        type:"post",
                        data:tel,
                        success:function(res){
                            $.toast({text:"发送成功"});
                            numDown();
                        },
                        error:function(res){
                            $.toast({text:"发送失败"});
                            numDown();

                        }
                    });
                }  */  
            }); 
            /* 登录 */
            $(".cc-btn").on("click",function(){
                var tel=$(".tel").val().trim();
                var viry=$(".viry").val().trim();
                var pwd = $('.pwd').val().trim();
                var telPattern=/^[1][34578][0-9]{9}$/;
              
                if(tel==""||isNaN(tel)){
                    $.toast({text:"请输入手机号"});
                    return;
                };
                if(tel.length<11){
                    $.toast({text:"请输入11位手机号"});
                    return;
                }
                if(!telPattern.test(tel)){
                    $.toast({text:"请输入正确的手机号"});
                    return;
                }
                if(viry==""||isNaN(viry)){
                    $.toast({text:"请输入验证码"});
                    return;
                }
                if(viry.length!=4){
                    $.toast({text:"请输入4位正确的验证码"});
                    return;
                }
              
                if(isclick){
                    $.ajax({
                    	url : "<?php echo U('do_login');?>",
                        type:"post",
                        data:{username:tel,password:pwd,verify:viry},
                        success:function(res){
                        	if(res==0){
                        		alert('验证码错误');
                        		return;
                        	}
                        	 res  = JSON.parse(res);
                        	 console.log(res);
                        	 if(res.status !=1){
                                 alert(res.msg);
                             }else{
                                 top.location.href=res.url;
                             }
                        	  isclick=true;
                             return;
                          
                        },
                        error:function(res){
                            isclick=true;
                        },
                    });
                    
                }
                
            });
        });
    </script>
</body>
</html>