<?php
/*
 * 功能：支付宝服务器异步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
 *
 *
 * ************************页面功能说明*************************
 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
 * 该页面调试工具请使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyNotify
 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
 */
session_start ();
require_once ("alipay.config.php");
require_once ("lib/alipay_notify.class.php");
require_once 'mysql.php';

// 计算得出通知验证结果
$alipayNotify = new AlipayNotify ( $alipay_config );
$verify_result = $alipayNotify->verifyNotify ();

if ($verify_result) { // 验证成功
                     // ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                     // 请在这里加上商户的业务逻辑程序代
                     
    // ——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
                     
    // 获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
                     
    // 商户订单号
    
    $out_trade_no = $_POST ['out_trade_no'];
    
    // 支付宝交易号
    
    $trade_no = $_POST ['trade_no'];
    $uid = substr ( $out_trade_no, 17 );
    logResult ( $out_trade_no );
    // 交易状态
    $trade_status = $_POST ['trade_status'];
        echo "success"; // 请不要修改或删除
    if ($_POST ['trade_status'] == 'TRADE_FINISHED' || $_POST ['trade_status'] == 'TRADE_SUCCESS') {
        $dns = 'mysql:host=127.0.0.1;dbname=shop';
        $connect = new DBAccess ( $dns, 'root', 'root' );
        if (is_numeric ( $out_trade_no )) {
            $uid = substr ( $out_trade_no, 14 );
            $order_sn = $out_trade_no;
            $my = $connect->getRow ( 'select *from up_users where user_id = ' . $uid );
            $parent = $connect->getRow ( 'select *from up_users where user_id = ' . $my ['parent_id'] );
            $orderInfo = $connect->getRow ( "select *from up_order where order_sn={$order_sn} limit 1" );
			$orderGoods = $connect->getRows("select *from up_order_goods where order_id = ".$orderInfo['order_id']);
			$thistime = time();
			$sqls= "insert into up_account_log (user_id,user_money,change_time,`desc`,order_id) value({$uid},{$orderInfo['total_amount']},{$thistime},'支付宝购买商品',{$orderInfo['order_id']})";
			logResult($sqls);
		    $accountLog = $connect->insert($sqls);
			
			foreach($orderGoods as $key=>$val){
				$maps = array(
					'spec_id'=>$val['spec_key'],
					'uid'=>$my['parent_id'],
					'goods_id'=>$val['goods_id'],
				);
				$parent_goods = $connect->getRow("update up_user_goods set stock=stock-".$val['goods_num']." where spec_id =".$val['spec_key']." and uid=".$my['parent_id']." and goods_id=".$val['goods_id']);
				logResult("update up_user_goods set stock=stock-".$val['goods_num']." where spec_id =".$val['spec_key']." and uid=".$my['parent_id']." and goods_id=".$val['goods_id']);
			}
			$result1 = $connect->update ( "update up_order set order_status=1,pay_status=1 where order_sn={$order_sn}" );
            $result2 = $connect->update ( "update up_order_action set order_status=1,pay_status=1,log_time=" . time () . ",status_desc='支付宝支付' where order_id={$orderInfo['order_id']}" );
            $result3 = $connect->update ( "update up_users set frozen_money=frozen_money+{$_POST['total_fee']} where user_id={$my['parent_id']}" );
            $time = time ();
            $sql = "insert into up_msg (cate_id,send_type,user_id,title,content,c_time) values(1,2,{$my['parent_id']},'您有一个新的未发货订单','{$my['mobile']}有新的下单,订单号为{$order_sn}','{$time}')";
            $result4 = $connect->insert ( $sql );
            $id = $connect->lastInsertId ();
            $sql = "insert into up_user_msg (msg_id,user_id) values({$id},{$my['parent_id']})";
            $result5 = $connect->insert ( $sql );
            if ($my ['is_first'] == 1) {
                $t = $connect->update ( "update up_users set is_first=0 where user_id={$my['user_id']}" );
            }
        }else if(is_numeric(strpos($out_trade_no,'wcz'))){
            $sql = "update up_users set user_money = user_money+{$_POST['total_fee']} where user_id=".$uid;
            logResult($sql);
            $time = time();
            $connect->update($sql);
            $sql = "insert into up_user_rechage (user_id,money,time) values({$uid},'{$_POST['total_fee']}','{$time}')";
            $connect->update($sql);
            logResult($sql);
        }else if(is_numeric(strpos($out_trade_no,'bzj'))) {
			$userte=$connect->getRow ( 'select *from up_users where user_id = ' . $uid );
			logResult($userte);
			//$userte=M('up_users')->where(array('user_id'=>$uid))->find();
			if($userte['is_lock']==1)
			{
				$sql = "update up_users set is_lock=2 , pledge_money=pledge_money+{$_POST['total_fee']} where user_id=" . $uid;
				logResult ( $sql );
				$k = $connect->update ( $sql );
				logResult($k);
				$time = time();
				$sql = "insert into up_pledge (pledge_time,pledge_name,pledge_money,user_id) values('{$time}','支付宝缴纳保证金','{$_POST['total_fee']}',{$uid})";
				logResult($sql);
				$connect->update($sql);
			}
          
        }
        logResult($out_trade_no);
        
        // 判断该笔订单是否在商户网站中已经做过处理
        // 如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
        // 请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
        // 如果有做过处理，不执行商户的业务程序
        
        // 注意：
        // 退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
        
        // 调试用，写文本函数记录程序运行情况是否正常
        // logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
    }
    
    // ——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
    
 
                        
    // ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
} else {
    // 验证失败
    echo "fail";
    
    // 调试用，写文本函数记录程序运行情况是否正常
    // logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
}
?>