<?php if (!defined('THINK_PATH')) exit();?>
                    <form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"></td>
                                    </td>
                                    <td class="text-right">
                                        <a href="javascript:sort('user_id');">ID</a>
                                    </td>
                                     <td class="text-left">
                                        <a href="javascript:sort('mobile');">账号/手机号码</a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:sort('username');">姓名</a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:sort('certificate_no');">身份证号码</a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:sort('level');">等级</a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:sort('total_amount');">累计消费</a>
                                    </td>
                                
                                   
                                    <!--<td class="text-left">
                                        <a href="javascript:sort('pay_points');">积分</a>
                                    </td>-->
                                    <td class="text-left">
                                        <a href="javascript:sort('reg_time');">注册日期</a>
                                    </td>
                                    <td class="text-right">操作</td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($userList)): $i = 0; $__LIST__ = $userList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="selected[]" value="6">
                                            <input type="hidden" name="shipping_code[]" value="flat.flat">
                                        </td>
                                        <td class="text-right"><?php echo ($list["user_id"]); ?></td>
                                         <td class="text-left"><?php echo ($list["mobile"]); ?></td>
                                        <td class="text-left"><?php echo ($list["username"]); ?></td>
                                        <td class="text-left"><?php echo ($list["certificate_no"]); ?></td>
                                        <td class="text-left"><?php echo ($list["level"]); ?></td>
                                        <td class="text-left"><?php echo ($list["total_amount"]); ?></td>
                                        <!--<td class="text-left"><?php echo ($list["pay_points"]); ?></td>-->
                                        <td class="text-left"><?php echo (date('Y-m-d H:i',$list["reg_time"])); ?></td>
                                        <td class="text-right">
                                            <a href="<?php echo U('Admin/user/detail',array('id'=>$list['user_id']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情"><i class="fa fa-eye"></i></a>
                                            <a href="<?php echo U('Admin/user/address',array('id'=>$list['user_id']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="收货地址"><i class="fa fa-home"></i></a>
                                            <a href="<?php echo U('Admin/order/user_order',array('user_id'=>$list['user_id']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="订单查看"><i class="fa fa-shopping-cart"></i></a>
                                            <a href="<?php echo U('Admin/user/account_log',array('id'=>$list['user_id']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="账户"><i class="glyphicon glyphicon-yen"></i></a>
                                            <a href="javascript:" id="button-delete6" data-toggle="tooltip" title="" class="btn btn-danger delete_user" data-original-title="删除"><i class="fa fa-trash-o"></i><input type="hidden" class="uid" value="<?php echo ($list['user_id']); ?>"/></a>
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
    $(".delete_user").click(function(){
    	var statu = confirm("确定要删除该用户?");
        if(!statu){
            return false;
        }else{
        	var uid = $(this).find('input').val();
        	var url = "<?php echo U('Admin/user/delete');?>"+"/id/"+uid;
        	location.href = url;
        }
    });
</script>