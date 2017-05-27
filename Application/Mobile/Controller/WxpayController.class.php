<?php
namespace Mobile\Controller;
use Think\Controller;
class WxpayController extends Controller {
    public function _initialize(){
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            exit('error');
        }
    }
    /**
     * @author 凡人 <fanren3150@qq.com> 
     */
    public function index(){
        import('Vendor.wxpay.wxpay');
        $config = C("WX_PAY_CONFIG");
        if (empty($config)) {
            $this->show('请设置微信支付配置');
        }
        $wxpay = new \wxpay($config);
        $wxpay->notify();
    }
    /**
     * 回调处理
     * @param array $data
     * @author 凡人 <fanren3150@qq.com> 
     * @return boolean
     */
    public function __notify($data) {
        if ($data['result_code'] == 'SUCCESS' && $data['return_code'] == 'SUCCESS') {
            \Think\Log::record("SUCCESS:" . $data['out_trade_no']);
            //此处应该更新一下订单状态，商户自行增删操作
            $out_trade_no = $data['out_trade_no'];
            if(is_numeric($out_trade_no)){
                $uid = $_SESSION['user_id'];
                $order_sn = $out_trade_no;
                $my = M('users')->query('select *from up_users where user_id = ' . $uid );
                $parent = M('users')->query('select *from up_users where user_id = ' . $my ['parent_id']);
                $orderInfo = M('order')->query("select *from up_order where order_sn={$order_sn} limit 1");
                $result1 = M('order')->query("update up_order set order_status=1,pay_status=1 where order_sn={$order_sn}");
                $result2 = M('order')->query("update up_order_action set order_status=1,pay_status=1,log_time=" . time () . ",status_desc='微信支付' where order_id={$orderInfo['order_id']}" );
                $result3 = M('users')->update ( "update up_users set frozen_money=frozen_money+{$data['total_fee']} where user_id={$my['parent_id']}" );
                $time = time ();
                $sql = "insert into up_msg (cate_id,send_type,user_id,title,content,c_time) values(1,2,{$my['parent_id']},'您有一个新的未发货订单','{$my['mobile']}有新的下单,订单号为{$order_sn}','{$time}')";
                $result4 = M('msg')->query( $sql );
                if ($my ['is_first'] == 1) {
                    $t = M('users')->query("update up_users set is_first=0 where user_id={$my['user_id']}");
                }
            }
            return true;
        } else {
            if ($data["return_code"] == "FAIL") {
                \Think\Log::record("【通信出错】:{$data['return_msg']}");
            } elseif ($data["result_code"] == "FAIL") {
                //此处应该更新一下订单状态，商户自行增删操作
                \Think\Log::record("【业务出错】:{$data['err_code']}--{$data['err_code_des']}");
            }
            return false;
        }
    }
}