<?php
/* * 
 * 功能：支付宝页面跳转同步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************页面功能说明*************************
 * 该页面可在本机电脑测试
 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
 * 该页面可以使用PHP开发工具调试，也可以使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyReturn
 */
session_start();
require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");
require_once 'mysql.php';
?>
<!DOCTYPE HTML>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代码
	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

	//商户订单号
	$out_trade_no = $_GET['out_trade_no'];

	//支付宝交易号
	$trade_no = $_GET['trade_no'];

	//交易状态
	$trade_status = $_GET['trade_status'];
    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
        $dns = 'mysql:host=127.0.0.1;dbname=shop';
        $connect = new DBAccess($dns,'root','root');
        $user = $_SESSION['user'];
        $order_sn = $_GET['out_trade_no'];
      
        if(is_numeric($order_sn)){
            header("Location:http://".$_SERVER['SERVER_NAME']."/Mobile/User/order_list/type/WAITSEND.html");
            exit();
            $orderInfo = $connect->getRow("select *from up_order where order_sn={$order_sn} limit 1");
            $result1 = $connect->update("update up_order set order_status=1,pay_status=1 where order_sn={$order_sn}");
            $result2 = $connect->update("update up_order_action set order_status=1,pay_status=1,log_time=".time().",status_desc='支付宝支付' where order_id={$orderInfo['order_id']}");
            $result3 = $connect->update("update up_users set frozen_money=frozen_money+{$_GET['total_fee']} where user_id={$user['parent_id']}");
            $time = time();
    		$sql = "insert into up_msg (cate_id,send_type,user_id,title,content,c_time) values(1,2,{$user['parent_id']},'您有一个新的未发货订单','{$user['mobile']}有新的下单,订单号为{$order_sn}','{$time}')";
    		$result4 = $connect->insert($sql);
    	    $id = $connect->lastInsertId();
    		$sql = "insert into up_user_msg (msg_id,user_id) values({$id},{$user['parent_id']})";
    		$result5 = $connect->insert($sql);
    		if($user['is_first']==1){
    		    $t = $connect->update("update up_users set is_first=0 where user_id={$user['user_id']}");
    		}
    		if($result1&&$result2&&$result3){
    		    $_SESSION['user'] = $connect->getRow("select *from up_users where  user_id={$user['user_id']}");
    		  
    		    exit();
    		}
        }else{
            header("Location:http://".$_SERVER['SERVER_NAME']."/Mobile/User/index");
            exit();
            $sql = "update up_users set pledge_money=pledge_money+{$_GET['total_fee']},is_lock=0 where user_id ={$user['user_id']}";
            $result1 = $connect->update($sql);
            $_SESSION['user'] = $connect->getRow("select *from up_users where user_id={$user['user_id']}");
            if($result1){
              
                exit();
            }
        }
		//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//如果有做过处理，不执行商户的业务程序
    }
    else {
      echo "trade_status=".$_GET['trade_status'];
    }
		
    
    
  
	echo "验证成功<br />";

	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    //如要调试，请看alipay_notify.php页面的verifyReturn函数
    echo "验证失败";
}
?>
        <title>支付宝手机网站支付接口</title>
	</head>
    <body>
    </body>
</html>