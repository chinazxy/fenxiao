<?php if (!defined('THINK_PATH')) exit();?>
                    <form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" style="font-size:12px;">
                                <thead>
                                <tr>
                                    <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"></td>
                                    <td class="text-center">
                                        <a href="javascript:sort('order_sn');">订单编号</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:sort('order_sn');">下单账号</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:sort('consignee');">收货人</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:sort('consignee');">联系方式</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="">应付金额</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:sort('order_status');">订单状态</a>
                                    </td>
                                    <td class="text-center">支付状态</td>
                                    <td class="text-center">发货状态</td>
                                    <td class="text-center">支付方式</td>
                                    <td class="text-center">配送方式</td>
                                    <td class="text-center">
                                        <a href="javascript:sort('add_time');">下单时间</a>
                                    </td>
                                    <td class="text-center">操作</td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($orderList)): $i = 0; $__LIST__ = $orderList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                                        <td class="text-center">
                                        	<input type="checkbox" name="selected[]" value="6">
                                        	<input type="hidden" name="shipping_code[]" value="flat.flat">
                                        </td>
                                        <td class="text-center"><?php echo ($list["order_sn"]); ?></td>
                                        <td class="text-center"><?php echo ($list["user_mobile"]); ?></td>
                                        <td class="text-center"><?php echo ($list["consignee"]); ?></td>
                                        <td class="text-center"><?php echo ($list["mobile"]); ?></td>
                                     <!--    <td class="text-center"><?php echo ($list["total_price"]); ?></td> -->
                                        <td class="text-center"><?php echo ($list["order_amount"]); ?></td>
                                        <td class="text-center"><?php echo ($order_status[$list[order_status]]); if($list['is_cod'] == '1'): ?><span style="color: red">(货到付款)</span><?php endif; ?></td>
                                        <td class="text-center"><?php echo ($pay_status[$list[pay_status]]); ?></td>
                                        <td class="text-center"><?php echo ($shipping_status[$list[shipping_status]]); ?></td>
                                        <td class="text-center"><?php echo ($list["pay_name"]); ?></td>
                                        <td class="text-center"><?php echo ($list["shipping_name"]); ?></td>
                                        <td class="text-center"><?php echo (date('Y-m-d H:i',$list["add_time"])); ?></td>
                                        <td class="text-center">
                                            <a href="<?php echo U('Admin/order/detail',array('order_id'=>$list['order_id']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情"><i class="fa fa-eye"></i></a>
                                           <!-- <?php if(($list['order_status'] == 3) or ($list['order_status'] == 5)): ?><a style="display:none" href="<?php echo U('Admin/order/delete_order',array('order_id'=>$list['order_id']));?>"  data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="删除"><i class="fa fa-trash-o"></i></a>
                                        	<?php else: ?>
                                        		<a href="javascript:void(0)" data-toggle="tooltip" title="" class="btn btn-default disabled" data-original-title="查看"><i class="fa fa-trash-o"></i></a><?php endif; ?>-->
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-6 text-left"></div>
                        <div class="col-sm-6 text-right"><?php echo ($page); ?></div>
                    </div>
<script>
    $(".pagination  a").click(function(){
        var page = $(this).data('p');
        ajax_get_table('search-form2',page);
    });
</script>