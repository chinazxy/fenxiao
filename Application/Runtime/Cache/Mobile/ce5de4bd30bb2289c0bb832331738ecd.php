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
</head>
<body class="body-bg">
    <!-- logo -->
    <div class="signup_box">
        <div class="logo">
            <img class="logo-img" src="/Public/jd/img/logo.png" alt="">
        </div>
        <div class="primary-text">注册</div>
        <!-- 输入框 -->
          <div class="ccinput-group">
            <input id="tel" type="tel" class="ccinput-input" placeholder="手机号">
          
        </div>
        <!-- 输入框 -->
        <div class="ccinput-group">
            <input id="pos1" type="password" class="ccinput-input" placeholder="6~16位包含字母和数字的密码">
            <div id="show" class="ccinput-label">显示</div>
        </div>
         <div class="ccinput-group">
            <input id="pos2" type="password" class="ccinput-input" placeholder="请再次输入密码">
            <div id="show2" class="ccinput-label">显示</div>
        </div>
        <div class="ccinput-group">
            <input id="inputMask" type="tel" class="ccinput-input" placeholder="验证码">
              <div id="mask" class="ccinput-label">获取验证码</div>
        </div>
        <!-- 输入框 -->
    
        <!-- 下一步 -->
        <a class="cc-btn" href="javascript:void(0);">下一步</a>
	</div>
    <script src="/Public/jd/js/jquery.js"></script>
    <script src="/Public/jd/js/plugin.min.js"></script>
    <script>
        $(function(){
			$('.signup_box').css('min-height',$(window).innerHeight());
            var revery = "";
        	function numDown(num){
                clearInterval(timer);
                var timer,
                timerNum=num;
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
            
            
            $('#tel').on('blur',function(){
                var tel = $(this).val();
                
                $.get("<?php echo U('msg_later');?>",{mobile:tel},function(data){
                	
                	if(data.status==1003){
                		 numDown(data.res_time);
                	}
                })
            })
            
            
         	var flag = true;  
            $("#mask").on("click",function(){
            	var tel=$("#tel").val().trim();
                var telPattern=/^[1][34578][0-9]{9}$/;
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
             	   $.post("<?php echo U('send_msg');?>",{mobile:tel,type:1},function(data){
             		 
             		 if(data.status==1000){
             			 revery = data.msg;
             			 console.log(revery);
             			 numDown(60);
             		 }else if(data.status==1003){
             			console.log(data);
             			$.toast({text:'还要'+data.res_time+'秒才可重新发送短信'});
             			numDown(data.res_time);
             			 
             		 }else{
             			 flag = false;
             			 $.toast({text:'短信发送失败,请重新发送 '});
             		 }
           	   	   })
                }   
            });
            var isclick=true;
            /* 显示 */
            $("#show").on("click",function(){
                if($(this).hasClass("active")){
                    $(this).removeClass("active").text("显示");
                    $("#pos1").attr("type","password");
                }else {
                    $(this).addClass("active").text("隐藏");
                    $("#pos1").attr("type","text");
                }
            });
            $("#show2").on("click",function(){
                if($(this).hasClass("active")){
                    $(this).removeClass("active").text("显示");
                    $("#pos2").attr("type","password");
                }else {
                    $(this).addClass("active").text("隐藏");
                    $("#pos2").attr("type","text");
                }
            });
            /* 下一步 */
            $(".cc-btn").on("click",function(){
                var tel=$("#tel").val().trim();
                var inputMask=$("#inputMask").val().trim();
                var pos=$("#pos1").val().trim();
                var pos2 =$("#pos2").val().trim();
                var telPattern=/^[1][3578][0-9]{9}$/;
                var posPattern=/(?!^[0-9]+$)(?!^[A-z]+$)(?!^[^A-z0-9]+$)^.{6,16}$/;
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
                if(inputMask==""||isNaN(inputMask)){
                    $.toast({text:"请输入验证码"});
                    return;
                }
				if(!posPattern.test(pos)){
				    $.toast({text:"请输入6~16位包含字母和数字的密码"});
					return;
				}
                if(pos==""){
                    $.toast({text:"请输入密码"});
                    return;
                }
                if(pos!=pos2){
                	 $.toast({text:"两次密码输入不一致"});
					 return;
                }
              
                if(isclick){
                	if(inputMask!=revery){
                		 $.toast({text:"验证码错误"});
                		 return;
                	}
             	   $.post("<?php echo U('mobile_exist');?>",{type:1,mobile:tel,password:pos,password2:pos2,verify:inputMask},function(data){
             		   console.log(data);
            		   if(data.status==1000){
            			   console.log(data);
            			   window.location.href  = data.success.url+"?mobile="+data.success.mobile+"&password="+data.success.password;
            		   }else if(data.status==1001){
            			        if(window.confirm('当前手机号已注册，请直接登录')){
            			        	window.location.href ="<?php echo U('user/login');?>";
            			            return true;
            			         }
            		   }else if(data.status==1002){
            			   alert('验证码错误');
            		   }
            	   })
              }
           });
        });
    </script>
</body>
</html>