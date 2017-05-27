<?php
namespace Mobile\Controller;
use Home\Logic\UsersLogic;
use Think\Controller;
class MobileBaseController extends Controller {
    public $user = array();
    public $user_id = 0;
    public $session_id;
    public $weixin_config;
    public $cateTrre = array();
    /*
     * 初始化操作
     */
    public function _initialize() {
        $keyword = M('keyword')->order('times desc')->limit(4)->select();
        $this->assign('keywordList',$keyword);
        $cateList =M('GoodsCategory')->where(array('is_show'=>1))->select();
        $this->assign('cateList',$cateList);
        $this->session_id = session_id(); // 当前的 session_id
        $bannerList = M('Ad')->find(2);
        $bannerList['img'] = explode('@', $bannerList['ad_code']);
        $bannerList['link']= explode('@', $bannerList['ad_link']);
        $this->assign('bannerLink',$bannerList['link']);
        $this->assign('bannerImg',$bannerList['img']);
        $this->assign('web_config',tpCache('shop_info'));
        if(session('user'))
        {
            $this->assign('web_config',tpCache('shop_info'));
            $user = session('user');            
            $user = M('users')->where("user_id = {$user['user_id']}")->find();
            $this->user = $user;
            $this->user_id = $user['user_id'];
            session('user',$user);
            $this->assign('user',$user); //存储用户信息  
            $this->cartLogic = new \Home\Logic\CartLogic();
            $cart_result = $this->cartLogic->cartList($this->user, 0,1);
            $number = 0;
            $spec = D('SpecGoodsPrice');
            foreach ($cart_result as $key=>$val){
                $ret = $spec->where(array('goods_id'=>$val['goods_id']))->count();
                $rspec = $spec->where(array('goods_id'=>$val['goods_id'],'key'=>$val['spec_key']))->order('price1 asc')->find();
                if(empty($rspec)){
                    //修改过  原来$cartList
                    unset($cart_result[$key]);
                }else{
                    $number+=$val['goods_num'];
                }
            }
            $this->assign('countCartGoods',$number);
            $this->assign('cartList', $cart_result); // 购物车的商品 */
        }else
        {
            $this->user[user_id] = 0;
        }
        
        $this->assign('user_id',$this->user_id); 
       
        // 判断当前用户是否手机                
        if(isMobile())
            cookie('is_mobile','1',3600);
        else
            cookie('is_mobile','0',3600);
        //判断是否微信浏览器
       /*$this->cartLogic = new \Home\Logic\CartLogic();
         dump($cart_result);
         exit();
//        $cart_result = $this->cartLogic->cartList($this->user, 0,1);
//
//        $this->assign('cartList', $cart_result); // 购物车的商品 */
    }
    
    /**
     * 
     */
    public function verify_c($id=''){
        ob_clean();
        $Verify = new \Think\Verify();
        $Verify->fontSize = 18;
        $Verify->length   = 4;
        $Verify->useNoise = false;
        $Verify->codeSet = '0123456789';
        $Verify->imageW = 130;
        $Verify->imageH = 50;
        //$Verify->expire = 600;
        $Verify->entry($id);
    }
 


    public function GetOpenid()
    {
        if($_SESSION['openid'])
            return $_SESSION['openid'];
        //通过code获得openid
        if (!isset($_GET['code'])){
            //触发微信返回code码
            $baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].$_SERVER['QUERY_STRING']);
            $url = $this->__CreateOauthUrlForCode($baseUrl);
            Header("Location: $url");
            exit();
        } else {
            //获取code码，以获取openid
            $code = $_GET['code'];
            $data = $this->getOpenidFromMp($code);
            $_SESSION['openid'] = $data['openid'];
            return $data;
        }
    }



    /**
     *
     * 通过code从工作平台获取openid机器access_token
     * @param string $code 微信跳转回来带上的code
     *
     * @return openid
     */
    public function GetOpenidFromMp($code)
    {
        $url = $this->__CreateOauthUrlForOpenid($code);
        //初始化curl
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        /*
        if(WxPayConfig::CURL_PROXY_HOST != "0.0.0.0"
            && WxPayConfig::CURL_PROXY_PORT != 0){
            curl_setopt($ch,CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
            curl_setopt($ch,CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
        }
        */
        //运行curl，结果以jason形式返回
        $res = curl_exec($ch);
        curl_close($ch);
        //取出openid
        $data = json_decode($res,true);
        $this->data = $data;
        $openid = $data['openid'];
        return $data;
    }

    /**
     *
     * 构造获取code的url连接
     * @param string $redirectUrl 微信服务器回跳的url，需要url编码
     *
     * @return 返回构造好的url
     */
    private function __CreateOauthUrlForCode($redirectUrl)
    {
        $urlObj["appid"] = $this->weixin_config['appid'];
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["response_type"] = "code";
//        $urlObj["scope"] = "snsapi_base";
        $urlObj["scope"] = "snsapi_userinfo";
        $urlObj["state"] = "STATE"."#wechat_redirect";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
    }

    /**
     *
     * 构造获取open和access_toke的url地址
     * @param string $code，微信跳转带回的code
     *
     * @return 请求的url
     */
    private function __CreateOauthUrlForOpenid($code)
    {
        $urlObj["appid"] = $this->weixin_config['appid'];
        $urlObj["secret"] = $this->weixin_config['appsecret'];
        $urlObj["code"] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
    }

    /**
     *
     * 拼接签名字符串
     * @param array $urlObj
     *
     * @return 返回已经拼接好的字符串
     */
    private function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v)
        {
            if($k != "sign"){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }
    public function send($type,$order_sn='',$user_id=''){
        $flag = 0;
        $params='';
        switch($type){
            case 3 :
                $parent = M('users')->where('user_id='.$user_id)->getField('parent_id');
                $mobile = M('users')->where('user_id='.$parent)->getField('mobile');//手机号
                $content = C('DOWN_MSG');//提醒上级审核
                break;
            case 4 :
                $parent = M('users')->where('user_id='.$user_id)->getField('parent_id');
                $mobile = M('users')->where('user_id='.$parent)->getField('mobile');//手机号
                $content = str_replace('%ORDER%', $order_sn, C('ORDER_MSG'));//提醒上级发货短信
                break;
            case 5 :
                $mobile=M('users')->where('user_id='.$user_id)->getField('mobile');//手机号
                $content = str_replace('%ORDER%', $order_sn, C('FAHUO_MSG'));//提醒用户已发货
                break;
            case 6 :
                $parent = M('users')->where('user_id='.$user_id)->getField('parent_id');
                $mobile = M('users')->where('user_id='.$parent)->getField('mobile');//手机号
                $content = str_replace('%ORDER%', $order_sn, C('RETURN_MSG'));//提醒上级退货
                break;
            case 7 :
                $parent = M('users')->where('user_id='.$user_id)->getField('parent_id');
                $mobile = M('users')->where('user_id='.$parent)->getField('mobile');//手机号
                $content = C('BREAK_MSG');//提醒上级解约
                break;
            case 8 :
                $mobile=M('users')->where('user_id='.$user_id)->getField('mobile');//手机号
                $content = C('WATTING_MSG');//提醒用户等待审核
                break;
            case 9 :
                $mobile=M('users')->where('user_id='.$user_id)->getField('mobile');//手机号
                $content = C('CASHOK_MSG');//提醒用户提现成功
                break;
            case 10 :
                $mobile=M('users')->where('user_id='.$user_id)->getField('mobile');//手机号
                $content = C('CASHNO_MSG');//提醒用户提现被拒
                break;
            case 11:
                $mobile=M('users')->where('user_id='.$user_id)->getField('mobile');//手机号
                $content = C('THROUGH_MSG');//提醒用户审核通过
                break;
        }
        $argv = array(
            'name'=>'韩菲诗',     //必填参数。用户账号
            'pwd'=>'0CFFDBF0A5CB4079749FFDF9F52F',     //必填参数。（web平台：基本资料中的接口密码）
            'content'=>$content,   //必填参数。发送内容（1-500 个汉字）UTF-8编码
            'mobile'=>$mobile,   //必填参数。手机号码。多个以英文逗号隔开
            'stime'=>'',   //可选参数。发送时间，填写时已填写的时间发送，不填时为当前时间发送
            'sign'=>'【韩菲诗】',    //必填参数。用户签名。
            'type'=>'pt',  //必填参数。固定值 pt
            'extno'=>''    //可选参数，扩展码，用户定义扩展码，只能为数字
        );
        //构造要post的字符串
        foreach ($argv as $key=>$value) {
            if ($flag!=0) {
                $params .= "&";
                $flag = 1;
            }
            $params.= $key."="; $params.= urlencode($value);// urlencode($value);
            $flag = 1;
        }
        //短信接口
        $url = "http://web.duanxinwang.cc/asmx/smsservice.aspx?".$params; //提交的url地址
        $con= substr( file_get_contents($url), 0, 1 );  //获取信息发送后的状态
        return $con;
    }

}