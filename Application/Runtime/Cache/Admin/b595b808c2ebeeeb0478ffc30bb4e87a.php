<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>诚享东方管理后台</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Bootstrap 3.3.4 -->
    <link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
 	<link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 --
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link href="/Public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="/Public/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="/Public/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" /> 
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->   
    <!-- jQuery 2.1.4 -->
    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/Public/js/common.js"></script>
    <script src="/Public/js/upgrade.js"></script>
	<script src="/Public/js/layer/layer.js"></script><!--弹窗js 参考文档 http://layer.layui.com/--> 
    <style type="text/css">
    	#riframe{min-height:inherit !important}
    </style>
  </head>
<body class="skin-green-light sidebar-mini" style="overflow-y:hidden;">
<div class="wrapper">
  <header class="main-header">
      <!-- Logo -->
      <a href="/index.php/Admin/Index/index" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b></b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="/Public/images/TP-shop_logo.png" width="40" height="30">&nbsp;&nbsp;<b>诚享东方</b></span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
    
        <!--服务器升级-->
        <textarea id="textarea_upgrade" style="display:none;"><?php echo ($upgradeMsg["1"]); ?></textarea>                              
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
          <?php if($upgradeMsg[0] != null): ?><li>
                  <a href="javascript:void(0);" id="a_upgrade">
                      <i class="glyphicon glyphicon-upload"></i>
                      <span  style="color:#FF0;"><?php echo ($upgradeMsg["0"]); ?>&nbsp;</span>
                  </a>
               </li><?php endif; ?>
           <li>
              <a id='re_flash' href="#">
                  <i class=""></i>
                  <span >刷新</span>
              </a>
           </li>
           <li>
              <a href="/index.php" target="_blank">
                  <i class="glyphicon glyphicon-home"></i>
                  <span>网站前台</span>
              </a>
           </li>
           <li>
               <a href="<?php echo U('/Admin/System/cleanCache');?>">
                   <i class="glyphicon glyphicon glyphicon-refresh"></i>
                   <span>清除缓存</span>
               </a>
           </li>      
           <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!--  <img src="/Public/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
                <i class="glyphicon glyphicon-user"></i>
                <span class="hidden-xs">欢迎：<?php echo ($admin_info["user_name"]); ?></span>
              </a>
              <ul class="dropdown-menu">
                <li class="user-footer">
                  <div class="pull-left">
                  	<a href="javascript:void(0)" data-url="<?php echo U('Index/map');?>" class="btn btn-default btn-flat model-map">网站地图</a>
                   	<a href="<?php echo U('Admin/admin_info',array('admin_id'=>$admin_info['admin_id']));?>" target="rightContent" class="btn btn-default btn-flat">修改密码</a>
                   	<a href="<?php echo U('Admin/logout');?>" class="btn btn-default btn-flat">安全退出</a>
                  </div>
                </li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
            <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-street-view"></i>换肤</a></li>
          </ul>
        </div>
     </nav>
</header>
<script>
   $('#re_flash').on('click',function(){
	   document.getElementById('rightContent').contentWindow.location.reload(true);
   })
</script>

<aside class="main-sidebar" style="overflow-y:auto;">
      <section class="sidebar">
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </form>
        <!-- /.search form -->
        <ul class="sidebar-menu"> 
	      <?php if(is_array($menu_list)): foreach($menu_list as $k=>$vo): ?><li class="treeview">
        	    <a href="javascript:void(0)">
	              <i class="fa <?php echo ($vo["icon"]); ?>"></i><span><?php echo ($vo["title"]); ?></span><i class="fa fa-angle-left pull-right"></i>
	            </a>
	            <ul class="treeview-menu">
	            	<?php if(is_array($vo["submenu"])): foreach($vo["submenu"] as $kk=>$vv): ?><li onclick="makecss(this,<?php echo ($vv["mod_id"]); ?>)" id="menu_<?php echo ($vv["mod_id"]); ?>"><a href="<?php echo ($vv["url"]); ?>" target='rightContent'><i class="fa fa-circle-o"></i><?php echo ($vv["title"]); ?></a></li><?php endforeach; endif; ?>
	            </ul>
        	</li><?php endforeach; endif; ?>     
        </ul>
      </section>
</aside>

<section class="content-wrapper right-side" id="riframe" style="margin:0px;padding:0px;margin-left:230px;">
    <iframe id='rightContent' name='rightContent' src="<?php echo U('Admin/Index/welcome');?>" width='100%' frameborder="0"></iframe>
</section>

	<footer class="main-footer">
	   <div class="pull-right hidden-xs">
	    	诚享东方商城系统<b></b>
	   </div>
	   <strong>Copyright &copy; 2016 <a href="#">we will better</a></strong>
	</footer>

     <!-- Control Sidebar -->
     <aside class="control-sidebar control-sidebar-dark">
       <!-- Create the tabs -->
       <!--
       <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
         <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-at"></i></a></li>
         <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
       </ul>
       -->
       <!-- Tab panes -->
       <div class="tab-content">
      	<!-- Home tab content -->
         <div class="tab-pane" id="control-sidebar-home-tab">
         </div><!-- /.tab-pane -->
         <!-- Stats tab content -->
         <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
         <!-- Settings tab content -->
         <div class="tab-pane" id="control-sidebar-settings-tab">
         </div>
       </div>
     </aside>
   <div class="control-sidebar-bg"></div>
</div>

<script src="/Public/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/Public/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/Public/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
<script src="/Public/dist/js/app.js" type="text/javascript"></script>
<script src="/Public/dist/js/demo.js" type="text/javascript"></script>
 
<script type="text/javascript">
$(document).ready(function(){
	$("#riframe").height($(window).height()-100);//浏览器当前窗口可视区域高度
	$("#rightContent").height($(window).height()-100);
	$('.main-sidebar').height($(window).height()-50);
});

var tmpmenu = 1;
function makecss(obj,mod_id){
	$('#menu_'+tmpmenu).removeClass('active');
	$(obj).addClass('active');
	tmpmenu = mod_id;
}

$('.model-map').click(function(){
    var url = $(this).attr('data-url');
    layer.open({
        type: 2,
        title: '网站地图',
        shadeClose: true,
        shade: 0.8,
        area: ['70%', '60%'],
        content: url, 
    });
});

function callUrl(url){
	layer.closeAll('iframe');
	rightContent.location.href = url;
}
    var now_num = 0; //现在的数量
    var is_close=0;
    function ajaxOrderNotice(){
        var url = '<?php echo U("Order/ajaxOrderNotice");?>';
        if(is_close > 0)
            return;
        $.get(url,function(data){
            //有新订单且数量不跟上次相等 弹出提示
            if(data > 0 && data != now_num){
                now_num = data;
                if(document.getElementById('ordfoo').style.display == 'none'){
                    $('#orderAmount').text(data);
                    $('#ordfoo').show();
                }
            }
        })
//        setTimeout('ajaxOrderNotice()',5000);
    }
//setTimeout('ajaxOrderNotice()',5000);
</script>
<!-- 新订单提醒-s -->
<style type="text/css">
.fl{ float:left; margin-left:10px; margin-top:4px}
.fr{ float:right; margin-right:10px; margin-top:3px}
.orderfoods{ width:200px; border:1px solid #dedede; position:absolute; bottom:50px; z-index:999; right:10px; background-color:#00A65A;opacity:0.8;-webkit-opacity:0.8;filter:alpha(opacity=80);-moz-opacity:0.8;  }
.dor_head{ border-bottom:1px solid #dedede; height:28px; color:#FFF; font-size:12px}
.dor_head:after{ content:""; clear:both; display:block}
.dor_foot{ margin-top:6px; color:#FFF}
.dor_foot p{ padding:0 12px}
.te-in{ text-indent:2em;}
.dor_foot p span{ color:red}
.te-al-ce{ text-align:center}
</style>
<div id="ordfoo" class="orderfoods" style="">
	<div class="dor_head">
    	<p class="fl">新订单通知</p>
        <p onClick="closes();" id="close" class="fr" style="cursor:pointer">x</p>
    </div>
    <div class="dor_foot">
    	<p class="te-in">您有<span id="orderAmount"><?php echo ($order_amount); ?></span>个订单待处理</p>
        <p class="te-al-ce"><a href="<?php echo U('Order/index');?>" target='rightContent'><span>点击查看</span></a></p>
    </div>
</div>
<script type="text/javascript">
	function closes(){
        is_close = 1;
		document.getElementById('ordfoo').style.display = 'none';
	}
</script>
<!-- 新订单提醒-e -->
</body>
</html>