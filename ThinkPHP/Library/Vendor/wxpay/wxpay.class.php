<?php
/**
 * @author 凡人 <fanren3150@qq.com> 
 */
class wxpay {
    public $appid = '';
    public $mchid = '';
    public $key = '';
    public $appsecret = '';
    
    public $sslcert_path = '';
    public $sslkey_path = '';
    
    public $notify_url = '';

    protected $values = array();
    
    public $error;
    
    public function __construct($config) {
        if (is_array($config)) {
            foreach($config AS $name => $value) {
                $this->setValue($name, $value);
            }
        }
        require_once VENDOR_PATH . "wxpay/lib/WxPay.Api.php";
        \WxPayConfig::setValue('appid', $this->appid);
        \WxPayConfig::setValue('mchid', $this->mchid);
        \WxPayConfig::setValue('key', $this->key);
        \WxPayConfig::setValue('appsecret', $this->appsecret);
    }
    
    public function setValue($name, $value) {
        $this->$name = $value;
    }
    
    public function getError() {
        return $this->error;
    }
    
    /**
     * 扫码支付
     * @param array $order 
     * <pre>
     * array(
     *  body 商品或支付单简要描述
     *  out_trade_no 商户系统内部的订单号,32个字符内、可包含字母
     *  total_fee  订单总金额，单位为分
     *  product_id  trade_type=NATIVE，此参数必传。此id为二维码中包含的商品ID，商户自行定义。
     * )
     * </pre>
     * @return boolean|payurl
     */
    public function native($order) {
        require_once VENDOR_PATH . "wxpay/native/WxPay.NativePay.php";
        $notify = new \NativePay();
        
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($order['body']);
        $input->SetOut_trade_no($order['out_trade_no']);
        $input->SetTotal_fee($order['total_fee']);//付款金额单位：分
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetNotify_url($this->notify_url);
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id($order['product_id']);
        
        if (isset($order['detail'])) { $input->SetDetail($order['detail']); }
        if (isset($order['attach'])) { $input->SetAttach($order['attach']); }
        if (isset($order['goods_tag'])) { $input->SetGoods_tag($order['goods_tag']); }
        
        $result = $notify->GetPayUrl($input);
        if ($result['result_code'] == 'SUCCESS' && $result['return_code'] == 'SUCCESS') {
            return $result["code_url"];
        }else{
            $this->error = "err_code : " . $result['err_code'] . "； err_code_des：" . $result['err_code_des'];
            return false;
        }
    }
    
    /**
     * 
     * @param array $order
     * <pre>
     * array(
     *  body 商品或支付单简要描述
     *  out_trade_no 商户系统内部的订单号,32个字符内、可包含字母
     *  total_fee  订单总金额，单位为分
     *  url 支付成功/失败跳转链接
     * )
     * </pre>
     * @return string|boolean
     */
    public function jsApiPay($order) {
        if (!$this->isWeChat()) {
            $this->error = "必须使用微信浏览器";
            return false;
        }
        require_once VENDOR_PATH . "wxpay/jsapi/WxPay.JsApiPay.php";
        
        $tools = new \JsApiPay();
        //①、获取用户openid
        $openId = $tools->GetOpenid();
        //②、统一下单
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($order['body']);
        $input->SetOut_trade_no($order['out_trade_no']);
        $input->SetTotal_fee($order['total_fee']);//付款金额单位：分
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetNotify_url($this->notify_url);
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        
        if (isset($order['detail'])) { $input->SetDetail($order['detail']); }
        if (isset($order['attach'])) { $input->SetAttach($order['attach']); }
        if (isset($order['goods_tag'])) { $input->SetGoods_tag($order['goods_tag']); }
        
        $unifiedOrder = \WxPayApi::unifiedOrder($input);
        if ($unifiedOrder['result_code'] == 'FAIL' || empty($unifiedOrder)) {
            $this->error = "err_code : " . $unifiedOrder['err_code'] . "； err_code_des：" . $unifiedOrder['err_code_des'];
            return false;
        }
        $jsApiParameters = $tools->GetJsApiParameters($unifiedOrder);
        return $jsApiParameters;
        //获取共享收货地址js函数参数
        //$editAddress = $tools->GetEditAddressParameters();
//        $jsPayScript = <<<EOT
//<script type="text/javascript">
//        var url = '{$order['url']}';
//	//调用微信JS api 支付
//	function jsApiCall() {
//            WeixinJSBridge.invoke(
//                'getBrandWCPayRequest',
//                {$jsApiParameters},
//                function(res){
//                    if(res.err_msg == 'get_brand_wcpay_request:ok') {
//                        if (url) {
//                            location.href = url;
//                        }else{
//                            alert('支付成功');
//                        }
//                    } else {
//                        if (url) {
//                            location.href = url;
//                        }else{
//                            alert('启动微信支付失败, 请检查你的支付参数. 详细错误为: ' + res.err_msg);
//                        }
//                    }
//                }
//            );
//	}
//
//	function callpay() {
//            if (typeof WeixinJSBridge == "undefined"){
//                if( document.addEventListener ){
//                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
//                }else if (document.attachEvent){
//                    document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
//                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
//                }
//            }else{
//                jsApiCall();
//            }
//	}
//        document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
//            WeixinJSBridge.call('hideToolbar');
//            WeixinJSBridge.call('hideOptionMenu');
//	});
//	</script>
//EOT;
//        
//        /* 生成支付按钮 */
//        $button = $jsPayScript . '<div><button type="button" class="btn btn-default" onclick="callpay()">立即使用微信支付</button></div>';
//        return $button;
    }
    private function isWeChat() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (stripos($user_agent, 'MicroMessenger') !== false) {
            return true;
        } else {
            return false;
        }
    }
    
    public function notify() {
        require_once VENDOR_PATH . "wxpay/notify.php";
        \WxPayConfig::setValue('appid', $this->appid);
        \WxPayConfig::setValue('mchid', $this->mchid);
        \WxPayConfig::setValue('key', $this->key);
        \WxPayConfig::setValue('appsecret', $this->appsecret);
        
        \Think\Log::record("begin notify");
        $notify = new \PayNotifyCallBack();
        $notify->Handle(false);
    }
    
    //查询订单
    public function queryOrder($out_trade_no) {
        $input = new \WxPayOrderQuery();
        $input->SetOut_trade_no($out_trade_no);
        $result = \WxPayApi::orderQuery($input);
        if (array_key_exists("return_code", $result) && array_key_exists("result_code", $result) && $result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS") {
            return $result;
        }
        return false;
    }
}