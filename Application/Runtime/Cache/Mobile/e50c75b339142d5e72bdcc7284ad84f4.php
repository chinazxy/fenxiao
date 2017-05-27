<?php if (!defined('THINK_PATH')) exit();?><!doctype>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE11">
<meta name="renderer" content="webkit|ie-comp|ie-stand"> 
<title></title>

<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

<link rel="stylesheet" href="/Public/css/main.css" type="text/css">
<script type="text/javascript" src="/Public/js/jquery-1.9.1.min.js"></script>
<style>
.bg_login .header2{background:#fff;color:#333;border-bottom:1px solid #000;}
.deposit .deposit_box h1{color:#fff;}
</style>
</head>

<body class="bg_login">
<div class="wrap">
	<!--头部-->
    <div class="header2">
    	<a><i></i><span></span></a>
        <a class="icon icon_home"></a>
        <p>保证金</p>
    </div>
    
    <div class="deposit">
    	<div class="deposit_box">
        	<h1><span>您的等级：</span><?php echo ($user["level_name"]); ?></h1>
        	<h1><span>您的保证金：</span>￥<?php echo ($user["amount"]); ?></h1>
        </div>
        <div class="deposit_a">
			<!--<h4 style="color:#fff;text-align:center;margin-bottom:10px;font-weight:normal;">请确保自己已经符合升级条件</h4>-->
			<a href="<?php echo U('pay_order');?>?type=3"  class="m_btn btn-block" style="background:#fff;color:#720E7E;">下一步</a>
		</div>
    </div>
    
    
</div>
<script type="text/javascript">

</script>
</body>
</html>