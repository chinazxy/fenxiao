var WxPay= {
    Pay: function (appId, timeStamp, nonceStr, package, signType, paySign,callback) {
        WeixinJSBridge.invoke('getBrandWCPayRequest', {
            "appId": appId,	//公众号名称，由商户传入
            "timeStamp":timeStamp,	//时间戳，自 1970 年以来的秒数
            "nonceStr": nonceStr, //随机串
            "package": package,
            "signType": signType,	//微信签名方式
            "paySign": paySign //微信签名
        }, function (res) {
            //alert(JSON.stringify(res));
            if (res.err_msg == "get_brand_wcpay_request:ok") {
                callback('ok');
            }
            else if (res.err_msg == "get_brand_wcpay_request:cancel")
            {
                callback('cancel');
            }
            else if (res.err_msg == "get_brand_wcpay_request:fail")
            {
                callback('fail');
            }
            // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg 将在用户支付成功后返回 ok，但并不保证它绝对可靠。
        });
    }
}