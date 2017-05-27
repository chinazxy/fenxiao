<?php if (!defined('THINK_PATH')) exit();?>
                    <form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:sort_list('order_sn');">订单编号</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0);">商品名称</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:sort_list('type');">类型</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)">退货快递单号</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:sort_list('addtime');">申请日期</a>
                                    </td>
                                    <td class="text-center"><a href="javascript:void(0);">状态</a></td>
                                    <td class="text-center">操作</td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$items): $mod = ($i % 2 );++$i;?><tr>
                                        <td class="text-center"><a href="<?php echo U('Admin/order/detail',array('order_id'=>$items['order_id']));?>"><?php echo ($items["order_sn"]); ?></a></td>
                                        <td class="text-center">
                                            <?php if(is_array($items['goods_info'])): $i = 0; $__LIST__ = $items['goods_info'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$kk): $mod = ($i % 2 );++$i; echo ($kk[goodinfom][goods_name]); ?> <br><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </td>
                                        <td class="text-center">
                                        	<?php if($items[type] == 0): ?>退货<?php endif; ?>
                                        	<?php if($items[type] == 1): ?>换货<?php endif; ?>                                            
                                        </td>
                                        <td class="text-center"><?php echo ($items["return_sn"]); ?></td>
                                        <td class="text-center"><?php echo (date('Y-m-d H:i',$items["addtime"])); ?></td>
                                        <td class="text-center">
                                        	<?php if($items[status] == 0): ?>未处理<?php endif; ?>
                                        	<?php if($items[status] == 2): ?>已完成<?php endif; ?>                                        
                                        </td>
                                        <td class="text-center">
                                            <a href="<?php echo U('Admin/order/return_info',array('id'=>$items['id']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情"><i class="fa fa-eye"></i></a>
                                            <?php if($items[status] == 0): ?><a href="javascript:void(0);" onclick="if(confirm('确定要拒绝用户退货吗?')) location.href='<?php echo U('Admin/order/return_del',array('id'=>$items['id']));?>';" id="button-delete6" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="删除"><i class="fa fa-trash-o"></i></a><?php endif; ?>
                                            <?php if($items[status] == 2): ?><a href="javascript:void(0);"  data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="删除" style="background: #cccccc;border-color: #cccccc"><i class="fa fa-trash-o"></i></a><?php endif; ?>
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