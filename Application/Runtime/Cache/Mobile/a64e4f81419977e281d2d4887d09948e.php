<?php if (!defined('THINK_PATH')) exit(); if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><a href="<?php echo U('/Mobile/User/order_detail',array('id'=>$list['order_id'],'type'=>1));?>">
       <?php if(($list["order_status"] == 0) ): ?><div class="alert alert-danger z-order-list"><?php endif; ?>
       <?php if(($list["order_status"] == 1) and ($list["shipping_status"] == 0) and ($list["pay_status"] == 1)): ?><div class="alert alert-warning z-order-list"><?php endif; ?>
       <?php if(($list["order_status"] == 1) and ($list["shipping_status"] == 1) and ($list["pay_status"] == 1)): ?><div class="alert alert-success z-order-list"><?php endif; ?>    
       <?php if(($list["order_status"] == 3) or ($list["order_status"] == 5)): ?><div class="alert alert-primary z-order-list"><?php endif; ?>
       <?php if(($list["order_status"] == 1) and ($list["pay_status"] == 0)): ?><div class="alert alert-info z-order-list"><?php endif; ?>
       <?php if(($list["order_status"] == 2) or ($list["order_status"] == 4)): ?><div class="alert alert-info z-order-list"><?php endif; ?>
        <?php if(($list["order_status"] > 5)): ?><div class="alert alert-info z-order-list"><?php endif; ?>
            <div class="col-xs-12 clearfix z-order2-head">
                <div class="pull-right text-danger"></div>
                <div class=""><?php echo ($list[order_sn]); ?></div>
            </div>
            <div class="clearfix">
            	<div class="col-xs-9">
                	<div class="text-ellipsis"><?php echo ($good["goods_name"]); ?></div>
                    <div class="">订单金额：￥<?php echo ($list[order_amount]); ?></div>
                    <div class="">下单时间 &nbsp;&nbsp;<?php echo date("Y-m-d H:i:s",$list[add_time]);?></div>
                </div>
                <div class="col-xs-3 z-order-right">
                	<div>￥&nbsp;<?php echo ($list[order_amount]); ?></div>
                	<div><a class="btn btn-mini" href="<?php echo U('Mobile/User/return_goods',array('order_id'=>$list['order_id'],'order_sn'=>$list['order_sn'],'goods_id'=>$list['goods_id']));?>">退货</a></div>
                </div>
            </div>
        </div>
        </a><?php endforeach; endif; else: echo "" ;endif; ?>