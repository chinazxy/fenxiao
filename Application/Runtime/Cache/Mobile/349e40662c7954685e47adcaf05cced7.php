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

<style>
.float_left{float:left;font-size:12px;text-align:left}
.float_right{float:right;font-size:12px;width:50%;text-align:right;}
.font_size{font-size:13px;}
    .bottom_border {border-bottom: 1px solid #ccc;margin-bottom: 8px;padding-bottom: 5px;}
</style>

<body class="z-color-white">
    <header>
        <div class="tab_nav">
            <div class="header">
                <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
                <div class="h-mid">我的订单</div>
                <div class="h-right">
                    <aside class="top_bar">
                        <div onClick="show_menu();
                                $('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
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

<div id="tbh5v0">
    <!--------筛选 form 表单 开始-------------->
    <form action="<?php echo U('Mobile/order_list/ajax_order_list');?>" name="filter_form" id="filter_form">
        <div class="z-order-list-head clearfix"><a class="col-xs-6" style="color:#666;" href="<?php echo U('/Mobile/User/order_list');?>">我的订单</a><a class="col-xs-6" href="<?php echo U('/Mobile/User/order_list_down');?>">下级订单</a></div>
        <div class="z-order-head clearfix">
            <ul>
                <li style="width:16.6%;"><a href="<?php echo U('/Mobile/User/order_list');?>" class="tab_head <?php if($_GET[type] == ''): ?>on<?php endif; ?>" >全部</a></li>
                <li style="width:16.6%;"><a href="<?php echo U('/Mobile/User/order_list',array('type'=>'WAITPAY'));?>"      class="tab_head <?php if($_GET[type] == 'WAITPAY'): ?>on<?php endif; ?>">待付款</a></li>
                <li style="width:16.6%;"><a href="<?php echo U('/Mobile/User/order_list',array('type'=>'WAITSEND'));?>"     class="tab_head <?php if($_GET[type] == 'WAITSEND'): ?>on<?php endif; ?>">待发货</a></li>
                <li style="width:16.6%;"><a href="<?php echo U('/Mobile/User/order_list',array('type'=>'WAITRECEIVE'));?>"  class="tab_head <?php if($_GET[type] == 'WAITRECEIVE'): ?>on<?php endif; ?>">待收货</a></li>
                <li style="width:16.6%;"><a href="<?php echo U('/Mobile/User/order_list',array('type'=>'RETURNING'));?>"  class="tab_head <?php if($_GET[type] == 'RETURNING'): ?>on<?php endif; ?>">退货中</a></li>
                <li style="width:16.6%;"><a href="<?php echo U('/Mobile/User/order_list',array('type'=>'WAITCCOMMENT'));?>" class="tab_head <?php if($_GET[type] == 'WAITCCOMMENT'): ?>on<?php endif; ?>">已完成</a></li>
            </ul>
        </div>     

        <div class="order ajax_return">
            <?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><a href="<?php echo U('/Mobile/User/order_detail',array('id'=>$list['order_id'],'type'=>1));?>">

                    <?php if(($list["order_status"] == 0) ): ?><div class="alert alert-danger z-order-list"><?php endif; ?>
                    <?php if(($list["order_status"] == 1) and ($list["shipping_status"] == 0) and ($list["pay_status"] == 1)): ?><div class="alert alert-warning z-order-list"><?php endif; ?>
                    <?php if(($list["order_status"] == 1) and ($list["shipping_status"] == 1) and ($list["pay_status"] == 1)): ?><div class="alert alert-success z-order-list"><?php endif; ?>    
                    <?php if(($list["order_status"] == 3) or ($list["order_status"] == 5)): ?><div class="alert alert-primary z-order-list"><?php endif; ?>
                    <?php if(($list["order_status"] == 1) and ($list["pay_status"] == 0)): ?><div class="alert alert-info z-order-list"><?php endif; ?>
                    <?php if(($list["order_status"] == 2) or ($list["order_status"] == 4)): ?><div class="alert alert-info z-order-list"><?php endif; ?>
                    <?php if(($list["order_status"] > 5)): ?><div class="alert alert-info z-order-list"><?php endif; ?>

                    <div class="col-xs-12 clearfix z-order2-head">
                        <div class="pull-right text-danger"><?php echo ($list[order_status_desc]); ?></div>
                        <div class=""><?php echo ($list[order_sn]); ?></div>
                    </div>
                    <div class="clearfix">
                        <?php if(is_array($list[order_goods])): $i = 0; $__LIST__ = $list[order_goods];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="col-xs-12 clearfix bottom_border">
                                <div class="col-xs-3"><img width="95px" height="95px" src="<?php echo ($vo["good_img"]["original_img"]); ?>"/></div>
                                <div class="col-xs-9 z_kpo" style="margin-top:10px;">
                                    <div class="text-ellipsis  margin_bottom3 font_size"><?php echo ($vo["goods_name"]); ?></div>
                                    <div class="clearfix" style="margin-top:5px;">
                                        <div class="font_size13 margin_bottom3 float_left font_size">数量 * <?php echo ($vo["goods_num"]); ?></div>
                                        <div class="font_size13 margin_bottom3 float_right font_size">RMB : <?php echo ($vo["member_goods_price"]); ?></div>
                                    </div>
                                </div>	</div><?php endforeach; endif; else: echo "" ;endif; ?>
						<div class="col-xs-12 ">
						   <div class="text-ellipsis  margin_bottom3 float_left"><?php echo ($good["goods_name"]); ?></div>
                            <div class="font_size13 margin_bottom3 float_right">订单金额：￥<?php echo ($list[order_amount]); ?></div>
                            <div class="font_size13 margin_bottom3 float_left">下单时间 &nbsp;&nbsp;<?php echo date("Y-m-d H:i:s",$list[add_time]);?></div>
							 <?php if($list[return_money] == '' ): endif; ?>
                            <?php if($list[return_money] != '' ): ?><div class="float_right">退款金额：￥<?php echo ($list[return_money]); ?></div><?php endif; ?>
                            <!-- <?php if($list["cancel_btn"] == 1): ?><div><a class="btn btn-mini" href="javascript::" onClick="cancel_order(<?php echo ($list["order_id"]); ?>)">取消订单</a></div><?php endif; ?> -->
                         
                            <!-- <?php if($list["receive_btn"] == 1): ?><div><a class="btn btn-mini" href="<?php echo U('Mobile/User/order_confirm',array('id'=>$list['order_id']));?>">收货确认</a></div><?php endif; ?>
                            <?php if($list["receive_btn"] == 1): ?><div><a class="btn btn-mini" href="<?php echo U('Mobile/User/return_goods',array('order_id'=>$list['order_id'],'order_sn'=>$list['order_sn'],'goods_id'=>$list['goods_id']));?>">我要退货</a></div><?php endif; ?>    
                            <?php if($list["comment_btn"] == 1): ?><div><a class="btn btn-mini" href="<?php echo U('/Mobile/User/order_detail',array('id'=>$list['order_id']));?>">评价</a></div><?php endif; ?>
                            <?php if($list["shipping_btn"] == 1): ?><div><a class="btn btn-mini" href="http://www.kuaidi100.com/" target="_blank">查看物流</a></div><?php endif; ?> -->
                        
						</div>
                
						   <?php if($list["pay_btn"] == 1): ?><div class="lodiv"><a class="btn btn-mini bt_in" href="<?php echo U('User/pay_order',array('order_id'=>$list['order_id'],'type'=>2));?>">立即付款</a></div><?php endif; ?>
                    </div>
                    </div>


                </a><?php endforeach; endif; else: echo "" ;endif; ?>  
        </div>
        <!--查询条件-->
        <input type="hidden" name="type" value="<?php echo $_GET['type'];?>" class="type" />
    </form>   
    <?php if(!empty($lists)): ?><div id="getmore" style="font-size:.24rem;text-align: center;color:#888;padding:.25rem .24rem .4rem; clear:both">
            <a href="javascript:void(0)" onClick="ajax_sourch_submit()">点击加载更多</a>
        </div><?php endif; ?> 
    <div style="height:80px;"></div>
    <!-- <div class="footer" >
	      <div class="links"  id="TP_MEMBERZONE"> 
	      		<?php if($user_id > 0): ?><a href="<?php echo U('User/index');?>"><span><?php echo ($user["nickname"]); ?></span></a><a href="<?php echo U('User/logout');?>"><span>退出</span></a>
	      		<?php else: ?>
	      		<a href="<?php echo U('User/login');?>"><span>登录</span></a><a href="<?php echo U('User/reg');?>"><span>注册</span></a><?php endif; ?>
	      		<a href="#"><span>反馈</span></a><a href="javascript:window.scrollTo(0,0);"><span>回顶部</span></a>
		  </div>
	      <ul class="linkss" >
		      <li>
		        <a href="#">
		        <i class="footerimg_1"></i>
		        <span>客户端</span></a></li>
		      <li>
		      <a href="javascript:;"><i class="footerimg_2"></i><span class="gl">触屏版</span></a></li>
		      <li><a href="<?php echo U('Home/Index/index');?>" class="goDesktop"><i class="footerimg_3"></i><span>电脑版</span></a></li>
	      </ul>
	  	 <p class="mf_o4">备案号:<?php echo ($upshop_config['shop_info_record_no']); ?><br/>&copy; 2005-2016 upshop多商户V1.2 版权所有，并保留所有权利。</p>
</div> -->
<div class='wrap fot'>
	<div class="footer">
	    	<a id="jump1"class="cc-href" href="<?php echo U('Mobile/Index/index');?>"><i class="ccIcons-product"></i><span>产品</span></a>
	        <a id="jump2"class="cc-href" href="<?php echo U('Mobile/User/order_list');?>"><!-- <i class="footer_order_label"></i> --><i class="ccIcons-order"></i><span>订单</span></a>
	        <a id="jump3"class="cc-href" href="<?php echo U('Mobile/Msg/index');?>"><i class="ccIcons-toast"></i><span>通知</span></a>
	        <a id="jump4"class="cc-href" href="<?php echo U('User/index');?>"><i class="ccIcons-user"></i><span>我的</span></a>
	</div>
</div>   
</div>


<script language="javascript">
    var page = 1;

    /*** ajax 提交表单 查询订单列表结果*/
    function ajax_sourch_submit()
    {
        var type = $('.type').val();
        page += 1;
        console.log(type);
        $.ajax({
            type: "POST",
            url: "<?php echo U('Mobile/User/order_list',array('type'=>$_GET['type']),'');?>/is_ajax/1/p/" + page, //+tab,			
            //data : $('#filter_form').serialize(),
            success: function(data)
            {
                if (data == '')
                    $('#getmore').hide();
                else
                {
                    console.log(data);
                    $(".ajax_return").append(data);
                    $(".m_loading").hide();
                }
            }
        });
    }

//取消订单
    function cancel_order(id) {
        if (!confirm("确定取消订单?"))
            return false;
        location.href = "/index.php?m=Mobile&c=User&a=cancel_order&id=" + id;
    }

</script>
</body>
</html>