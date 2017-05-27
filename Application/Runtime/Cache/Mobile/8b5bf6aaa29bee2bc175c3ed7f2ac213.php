<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
<meta name="Generator" content="upshop v1.1" />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <title></title>
  <meta http-equiv="keywords" content="<?php echo ($upshop_config['shop_info_store_keyword']); ?>" />
  <meta name="description" content="<?php echo ($upshop_config['shop_info_store_desc']); ?>" />
  <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
  <link rel="stylesheet" href="/Template/mobile/new/Static/css/loginxin.css">
  <link rel="stylesheet" href="/Template/mobile/new/Static/css/public.css" >
  <style>
  .header_03{border-bottom:1px solid #000;}
  .tips .tishi{border-color:#000;background:#000;}
  </style>
  <!-- 系统提示-<?php echo ($upshop_config['shop_info_store_title']); ?> -->
  </head>

<body>
<header class="header_03">
  <div class="nl-login-title">
    <div class="h-left">
      <a class="sb-back" href="javascript:history.back(-1)" title="返回"></a>
    </div>
    <span style="text-align:center">系统提示</span>
  </div>
</header>
<div class="ng-form-zhu" style="text-align: center;font-size:16px;">
  <div class="tips_a">
      <?php if(isset($message)){ ?>
      <img src="/Template/mobile/new/Static/images/xin/icogantanhao.png"></div>
     <?php }else{ ?>
     <img src="/Template/mobile/new/Static/images/xin/icogantanhao-sb.png"></div>
     <?php }?>
  <div class="tips">
	  <?php if(isset($message)) { echo($message); ?>
	  <?php }else{?>
	  <?php echo($error); }?>
  </div>
      <div class="tips">
      <a href="<?php echo($jumpUrl); ?>"  id="href" style="color: #666;">
       <?php if(!empty($title)){ ?>
        <span class="tishi"><?php echo ($title); ?></span>
       <?php }else{ ?>
      	<span class="tishi">返回上一页</span>
      <?php } ?>
      </a>
      <a href="<?php echo U('Index/index');?>" style="color: #666;">
      	<span class="tishi">返回首页</span>
      </a>
   </div>
</div>
<script type="text/javascript">
   
(function(){
	var wait = 3,href = document.getElementById('href').href;
	var interval = setInterval(function(){
	var time = --wait;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 2000);
})();
 
</script>
</body>
</html>