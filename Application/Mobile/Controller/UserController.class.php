<?php
namespace Mobile\Controller;
use Mobile\Logic\UsersLogic;
use Think\Page;
use Think\Verify;
use Think\Template\Driver\Mobile;
use Mobile\Logic\MsgLogic;

class UserController extends MobileBaseController {

    /*
    * 初始化操作
    *
    */
    protected  $vconfig =    array(
        'fontSize'    =>    30,    // 验证码字体大小
        'length'      =>    4,     // 验证码位数
        'useNoise'    =>    false, // 关闭验证码杂点
    );
    public function _initialize() {
        parent::_initialize();
        $nologin = array(
            'login','get_city','pop_login','do_login','step_two','step_three','step_four','select_parent','logout','set_pwd','finished',
            'verifyHandle','reg','send_msg','find_pwd','check_validate_code',
            'forget_pwd','find_user','search_user','msg_later','check_captcha','mobile_exist','check_username','send_validate_code',
        );

        if(!$this->user_id && !in_array(ACTION_NAME,$nologin)){
            header("location:".U('Mobile/User/login'));
            exit;
        }
        $order_status_coment = array(
            'WAITPAY'=>'待付款 ', //订单查询状态 待支付
            'WAITSEND'=>'待发货', //订单查询状态 待发货
            'WAITRECEIVE'=>'待收货', //订单查询状态 待收货
            'WAITCCOMMENT'=>'待评价', //订单查询状态 待评价        
        );
        $this->assign('order_status_coment',$order_status_coment);
    }
    /*
     * 用户中心首页
     */
    public function index(){
        $logic = new UsersLogic();
        $user = $logic->get_info($this->user_id);
        //var_dump($user);exit;
        $user = $user['result'];
        if($user['u_type'] == 2){
            $finance = M('finance','uc_')->where('user_id ='.$user['user_id'])->find();
        }
        $parent = array();
        if(!empty($user['parent_id'])){
            $parent = $logic->get_info($user['parent_id']);
        }
        $user['level_name'] = $this->get_level($user['level']);
        $user_id = $user['user_id'];
        $model = M('users');
        $kids = $model->field('user_id')->where("parent_id = $user_id")->select();
        $kid = "";
        foreach($kids as $k => $v){
            $kid .= $v['user_id'].",";
        }
        $kid = rtrim($kid , ",");
        //计算订单数量
        $order = M('order');

        $kidWaitpayWhere =  "user_id IN ($kid) " . C('WAITPAY');
        $kidWaitpayNum = $order->where($kidWaitpayWhere)->count();
        $kidWaitsendWhere = "user_id IN ($kid) " . C('WAITSEND');
        $kidWaitsendNum = $order->where($kidWaitsendWhere)->count();
        $kidWaitreceiveWhere = "user_id IN ($kid) " . C('WAITRECEIVE');
        $kidWaitreceiveNum = $order->where($kidWaitreceiveWhere)->count();
        $kidReturningWhere = "user_id IN ($kid) " . C('RETURNING');
        $kidReturningNum = $order->where($kidReturningWhere)->count();
        $waitcommentWhere = "user_id = $user_id" . C('RETURNING');
        $waitcommentNum = $order->where($waitcommentWhere)->count();

        $this->assign('kidWaitPay' , $kidWaitpayNum);
        $this->assign('kidWaitSend' , $kidWaitsendNum);
        $this->assign('kidWaitReceive' , $kidWaitreceiveNum);
        $this->assign('kidReturning' , $kidReturningNum);
        $this->assign('waitpayNum' , $user['waitPay']);
        $this->assign('waitsendNum' , $user['waitSend']);
        $this->assign('waitreceiveNum' , $user['waitReceive']);
        $this->assign('waitcomentNum' , $waitcommentNum);
        $this->assign('parent',$parent);
        $userLogic = new \Mobile\Logic\UsersLogic();
        $this->assign('user',$user);
        $this->assign('finance',$finance);
        //$this->display();  //由mz注释  my 为新个人中心首页
        $this->display('my');
    }

    public function my_goods(){
        $list = M('UserGoods')->where('uid='.$this->user_id)->join('up_goods ON up_goods.goods_id = up_user_goods.goods_id')->select();
        foreach ($list as $key=>$val){
            $cate = M('GoodsCategory')->find($val['cat_id']);
            $list[$key]['cate_name'] = $cate['name'];
        }
        $this->assign('list',$list);
        $this->display();
    }
    public function pass_apply(){
        if(empty(I('id'))){
            echo "<script>alert('系统错误');location.href='my_famil'</script>";
            return;
        }
        $info = M('users')->find(I('id'));
		if($info['parent_id'] != 1){
        if($info['is_lock']==2){
            $data['is_lock'] = 3;
        }elseif($info['is_lock']==4){
            $data['is_lock'] = 0;
        }
		}
        M('users')->where(array('user_id'=>$info['user_id']))->save($data);
        $user_id = $info['user_id'];
        $this->send(8,'',$user_id);
        echo "<script>alert('操作成功');location.href='my_famil'</script>";
    }
    public function logout(){
        session('user',null);
        session_unset();
        session_destroy();
        //$this->success("退出成功",U('Mobile/Index/index'));
        header("location:".U('Mobile/index/index'));
    }
    /*
     * 账户资金
     */
    public function account(){
        $user = session('user');
        //获取账户资金记录
        $logic = new UsersLogic();
        $data = $logic->get_account_log($this->user_id,I('get.type'));
        $account_log = $data['result'];
        $this->assign('user',$user);
        $this->assign('account_log',$account_log);
        $this->assign('page',$data['show']);
        if($_GET['is_ajax'])
        {
            $this->display('ajax_account_list');
            exit;
        }
        $this->display();
    }
    public function coupon(){
        $logic = new UsersLogic();
        $data = $logic->get_coupon($this->user_id,$_REQUEST['type']);
        $coupon_list = $data['result'];
        $this->assign('coupon_list',$coupon_list);
        $this->assign('page',$data['show']);
        if($_GET['is_ajax'])
        {
            $this->display('ajax_coupon_list');
            exit;
        }
        $this->display();
    }
    /**
     *  登录页面
     */
    public function login(){
        if($this->user_id> 0){
            header("Location: ".U('Mobile/User/Index'));
        }
        $referurl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : U("Mobile/User/index");
        $this->assign('referurl',$referurl);
        $this->display('signup');
    }
    public function check_code($verify,$id=''){
        $Verify = new Verify();
        return  $Verify->check($verify,$id);
    }
    /*登录操作*/
    public function do_login(){
        if(!$this->check_code(I('verify'))){
            $this->ajaxReturn(0);
        }
        $username = I('post.username');
        $password = I('post.password');
        $username = trim($username);
        $password = trim($password);
        $only = '5';
        $logic = new UsersLogic();
        $res = $logic->login($username,$password,$only);
        if($res['status'] == 1) {
            session('user', $res['result']);
            session('user_id', $res['result']['user_id']);
            $nickname = empty($res['result']['nickname']) ? $username : $res['result']['nickname'];
            setcookie('uname', $nickname, null, '/');
            $cartLogic = new \Home\Logic\CartLogic();
            $cartLogic->login_cart_handle($this->session_id, $res['result']['user_id']);//用户登录后 需要对购物车 一些操作
            $upUser = M('users')->where('user_id = ' . $_SESSION['user_id'])->find();
            $sql = "select * from uc_users where uc_users.certificate_no = $upUser[certificate_no]";
            $getXin = mysql_query($sql);
            if (empty($getXin)) {
                $res['url'] = U('index/index');
            } else {
                if ($getXin['u_type'] == 1) {
                    M('finance', 'uc_')->where('u_id = ' . $getXin['u_id'])->find();
                    $res['url'] = U('index/do_copy');
                } elseif ($getXin['u_type'] == 3) {
                    $res['url'] = U('index/index');
                }
            }
            if ($res['result']['is_lock'] == 1) {
                $res['url'] = U('index');
            }
        }
        exit(json_encode($res));
    }
    /**
     *  注册
     */
    public function reg(){
        if(IS_POST){
            $logic = new UsersLogic();
            $username = I('post.username','');
            $password = I('post.password','');
            $password2 = I('post.password2','');;

            $data = $logic->reg($username,$password,$password2);
            if($data['status'] != 1)
                $this->error($data['msg']);

            session('user',$data['result']);
            session('user_id',$data['result']['user_id']);

            $this->success($data['msg'],U('Mobile/User/index'));
            exit;
        }
        $this->display('reg');
    }
    /**
     * 短信发送限定
     */
    public function msg_later(){
        $mobile=I('mobile');//手机号
        $k = session($mobile);
        if($k){
            $times =time()-$k;
            if($times<60){
                $this->ajaxReturn(array('status'=>1003,'res_time'=>(60-$times)));
            }else{
                session($mobile,null);
                $this->ajaxReturn(array('status'=>1000,'res_time'=>(60-$times)));
            }
        }
    }
    /**
     * 发送短信验证码
     *
     */
    public function send_msg(){
        $flag = 0;
        $params='';//要post的数据
        $mobile=I('mobile');//手机号
        $k = session($mobile);
        if($k){
            $times =time()-$k;
            if($times<60){
                $this->ajaxReturn(array('status'=>1003,'res_time'=>(60-$times)));
            }else{
                session($mobile,null);
            }
        }
        $verify = rand(123456, 999999);//获取随机验证码
        if(I('type')==1){
            $content = str_replace('%VERIFY%', $verify, C('REGISTER_MSG'));
        }else if(I('type')==2){
            $content = str_replace(array('%TEL%','%VERIFY%'), array($mobile,$verify), C('UPDATE_MSG'));
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
        //echo $argv['content'];
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
        if($con == '0'){
            session($mobile.I('time'),time());
            session($mobile.I('type'),$verify);
            $this->ajaxReturn(array('status'=>1000,'msg'=>$verify,'mobile'=>session($mobile),'type'=>$mobile.I('type')));
        }else{
            $this->ajaxReturn(array('status'=>1001,msg=>'短信发送失败，请重新发送'));
        }
    }
    public function mobile_exist(){
        $mobile = I('mobile');
        $result = M('users')->where(array('mobile'=>$mobile))->field('mobile')->find();
        if($result){
            $this->ajaxReturn(array('status'=>1001,'msg'=>'手机号码已被注册'));
        }
        //md5加密
        $password = md5(I('password'));
        $verify = I('verify');
        /*  $key = session($mobile.I('y'));
          $this->ajaxReturn(array('status'=>1002,'msg'=>I(),'verify'=>$key));
         if(session($mobile.'1')!=$verify){
             $this->ajaxReturn(array('status'=>1002,'msg'=>session($mobile.'1'),'verify'=>$verify));
         } */
        $this->ajaxReturn(
            array(
                'status'=>1000,
                'success'=>array(
                    'mobile'=>$mobile,
                    'password'=>$password,
                    'url'=>U('step_two'),
                )
            )
        );
    }
    /**
     *注册第二步
     */
    public function step_two(){
        $this->assign('mobile',I('mobile'));
        $this->assign('password',I('password'));
        $this->display('completeRegister');
    }
    public function step_three(){
        $up = array(
            'mobile'=>I('mobile'),
            'password'=>I('password'),
            'certificate_no'=>I('certificate'),
            'pic1' => I('pic1'),
            'pic2' => I('pic2')
        );
        //print_r($up);exit;
        $article = M('article')->find(5);
        $article['content'] = htmlspecialchars_decode($article['content']);
        $this->assign('article',$article);
        $levelMod = M('UserLevel');
        $level = array();
        $upuser['level'] = 1;
        $mylevel = 1;
        if(I('upmobile')){
            $userMod = M('users');
            $upuser = $userMod->where(array('mobile'=>I('upmobile')))->find();
            $mylevel = $upuser['level'];
            $level = $levelMod->find($mylevel);
            $up['parent_id'] =$upuser['user_id'];
            /*   if($upuser['level']>2){
                  $upuser['level'] = $upuser['level']-1;
              } */
        }
        if($mylevel<1){
            $mylevel =1;
        }
        //$parent_level = M('users')->where('user_id ='. $up['parent_id'])->field('level')->find();
        //$this->assign('pl',$parent_level);
        $this->assign('info',$up);
        $this->assign('username',I('username'));
        $this->assign('certificate',I('certificate'));
        //   $this->assign('level',$level);
        //?mobile=13459213269&password=e10adc3949ba59abbe56e057f20f883e&upmobile=13459213269
        $this->assign('levelList',$levelMod->where(array('level_id'=>array('gt',$mylevel)))->select());
        $this->display('selectLevel');
    }

    public function step_four(){
        $where = array(
            'mobile'=>I('mobile'),
            'username'=>I('username'),
            'certificate_no'=>I('certificate'),
            'province'=>I('province'),
            'city'=>I('city'),
            'password'=>I('password'),
            'parent_id'=>I('parent'),
            'level'=>I('level'),
            'reg_time'=>time(),
            'is_first'=>1,
            'head_pic'=>"Public/upload/head_pic/20160727/579849c0c9a65.jpg",
            'is_lock'=>1,
            'pic1' => I('pic1'),
            'pic2' => I('pic2')
        );
        //var_dump($where);exit;
		if($where['mobile'] == ""){
			exit;
		}
        $userMod = D('users');
        $t = $userMod->where(array('mobile'=>I('mobile')))->find();
        if($t){
            $this->error('已存在的用户',U('index'));
        }
        $result = $userMod->add($where);
        $user = $userMod->find($result);
        $this->user = $user;
        $this->user_id = $user['user_id'];
        session('user',$user);
        session('user_id',$user['user_id']);
        header("Location:".U('step_five'));
    }
    //注册第五步
    public function step_five(){
        $user = session('user');
        $result = D('UserLevel')->where(array('level_id'=>$user['level']))->find();
        $this->assign('user',$result);
        $this->display();
    }
    //重新审核
    public function again(){
        $id = I('id');
        $sql = "update up_users set is_out = 1 where user_id =".$id;
        $out = M('users')->execute($sql);
        if($out){
            header("Location: ".U('index'));
        }
    }
    //订单支付
    public function pay_order(){
        $type = I('type');
        $user = $this->user;
        //var_dump($user);exit;
        if($type==3){
            $result = D('UserLevel')->where(array('level_id'=>$user['level']))->find();
            $must_add = $result['amount']-$this->user['pledge_money'];
            $this->assign('must_add',$must_add);
            if($must_add==0){
                header("Location:".U('index'));
            }
        }
        if($type==2){
            $order = D('Order')->find(I('order_id'));
            $this->assign('order',$order);
        }
        if($user['u_type'] == 2){
            $finance = M('finance','uc_')->where('user_id ='.$user['user_id'])->find();
        }
        $this->assign('finance',$finance);
        $this->assign('user',$user);
        $this->display('pay');
    }
    //订单支付
    public function pay_now(){
        $pay_amount = I('pay_amount');
        $order_sn = I('order_sn');
        $type = I('type');
        $orderMod = M('order');
        $inwx=I('inwx');
        $orderInfo = $orderMod->where(array('order_sn'=>$order_sn))->find();
        $orderGoods = M('OrderGoods')->where(array('order_id'=>$orderInfo['order_id']))->select();
        foreach ($orderGoods as $key=>$val){
            $map = array(
                'uid'=>$this->user['parent_id'],
                'goods_id'=>$val['goods_id'],
                'spec_id'=>$val['spec_key'],
            );
            //$tmp = M('UserGoods')->where($map)->find();
            //$goods = M('goods')->where("goods_id = $map[goods_id]")->find();
            //if(!empty($tmp)){
            //    $data['stock'] = $tmp['stock']-$val['goods_num'];
            //    $data1['store_count'] = $goods['store_count'] - $val['goods_num'];
            //}
            //if($data['stock']>=0) {
                    M()->startTrans();
                    //$s1 = M('UserGoods')->where($map)->save($data);
                    //$s2 = M('goods')->where("goods_id = $map[goods_id]")->save($data1);
                    //$s3 = M('SpecGoodsPrice')->where("goods_id = $map[goods_id]")->save($data1);
					$s1 = M('UserGoods')->where($map)->setDec('stock',$val['goods_num']);
                    $s2 = M('goods')->where("goods_id = $map[goods_id]")->setDec('store_count',$val['goods_num']);
                    $s3 = M('SpecGoodsPrice')->where("goods_id = $map[goods_id]")->setDec('store_count',$val['goods_num']);
                    if ($s1 && $s2 && $s3) {
						$stock = M('UserGoods')->where($map)->find();
						if($stock['store_count']>=0){
							 M()->commit();
						}
						else
						{
							 M()->rollback();
							$this->ajaxReturn(array('status'=>0,msg=>'订单所包含商品库存不足'));
							 
						}
                       }
					   else {
                            M()->rollback();
						    $this->ajaxReturn(array('status'=>0,msg=>'下单失败'));
                       }
            //}
        }
        if(empty($orderInfo)){
            $this->ajaxReturn(array('status'=>0,msg=>'未找到该订单信息'));
        }
        if($orderInfo['pay_status']==1){
            $this->ajaxReturn(array('status'=>0,msg=>'您已支付过该订单'));
        }
        if($pay_amount>=0&&I('type')==0){
            $where['user_id'] = $_SESSION['user_id'];
            $up = M('users')->where($where)->find();
            //用户资金扣除
            //if($up['u_type'] == 1){
            mysql_query("BEGIN");
            $map['user_money']  = $this->user['user_money']-$pay_amount;
            $sql = "Update up_users set total_amount =total_amount+$pay_amount where user_id=$this->user_id ";
            if($map['user_money']<0){
                $this->ajaxReturn(array('status'=>0,msg=>'余额不足，无法支付'));
            }
            M('users')->execute($sql);
            $usrest = M('users')->where(array('user_id'=>$this->user_id))->save($map);
            $orest = $orderMod->where(array('order_id'=>$orderInfo['order_id']))->save(array('order_status'=>1,'pay_status'=>1,'pay_time'=>time()));
            $oarest = M('OrderAction')->where(array('order_id'=>$orderInfo['order_id']))->save(
                array(
                    'action_user'=>$this->user_id,
                    'order_status'=>1,
                    'pay_status'=>1,
                    'log_time'=>time(),
                    'status_desc'=>'余额支付'
                )
            );
            if($map && $usrest && $orest && $oarest){
                mysql_query('COMMIT');
            }else{
                mysql_query('ROLLBACK');
            }
            mysql_query("END");
            /*} elseif($up['u_type'] == 2){
                mysql_query("BEGIN");
                $finance = M('finance','uc_')->where("user_id = $this->user_id")->find();
                $map['f_money'] = $finance['f_money']-$pay_amount;
                $sql = "Update up_users set total_amount =total_amount+$pay_amount where user_id=$this->user_id ";
                if($map['f_money']<0){
                    $this->ajaxReturn(array('status'=>0,msg=>'余额不足，无法支付'));
                }
                M('users')->execute($sql);
                $usrest = M('finance','uc_')->where(array('user_id'=>$this->user_id))->save($map);
                $orest = $orderMod->where(array('order_id'=>$orderInfo['order_id']))->save(array('order_status'=>1,'pay_status'=>1,'pay_time'=>time()));
                $oarest = M('OrderAction')->where(array('order_id'=>$orderInfo['order_id']))->save(
                    array(
                        'action_user'=>$this->user_id,
                        'order_status'=>1,
                        'pay_status'=>1,
                        'log_time'=>time(),
                        'status_desc'=>'余额支付'
                    )
                );
                if($map && $usrest && $orest && $oarest){
                    mysql_query('COMMIT');
                }else{
                    mysql_query('ROLLBACK');
                }
                mysql_query("END");
            }*/
            if($this->user['is_first']==1){
                M('users')->where(array('user_id'=>$this->user_id))->save(array('is_first'=>0));
            }
            $this->user = M('users')->find($this->user_id);
            session('user',$this->user);
            $msgLog = new MsgLogic();
            $parent_id =$this->user['parent_id'];
            $parents = M('users')->where(array('user_id'=>$parent_id))->find();
            //上级收款转为冻结资金
            if($parents['u_type'] == 1) {
                $ts = M('users')->where(array('user_id' => $parent_id))->save(array('frozen_money' => ($parents['frozen_money'] + $pay_amount)));
                //1代表提醒上级发货
                $msgrest = $msgLog->send_msg(1, $order_sn);
                if($parent_id != 1){
                    $user_id = $this->user_id;
                    $this->send(4,$order_sn,$user_id);
                }
                $userData = array(
                    'user_id' => $this->user_id,
                    'user_money' => '-' . $pay_amount,
                    'change_time' => time(),
                    'order_id' => $orderInfo['order_id'],
                    'desc' => '余额支付订单'
                );
                $userAccouontLog = M('AccountLog')->add($userData);
            }
            elseif($parents['u_type'] == 2){
                $ts =M('finance','uc_')->where(array('user_id' => $parent_id))->save(array('frozen_money' => ($parents['frozen_money'] + $pay_amount)));
                //1代表提醒上级发货
                $msgrest = $msgLog->send_msg(1, $order_sn);
                $ucuser = M('users','uc_')->where($this->user_id)->find();
                $userData = array(
                    'u_id' => $ucuser['u_id'],
                    'user_id' => $this->user_id,
                    'f_logs_num' => $pay_amount,
                    'f_logs_datetime' => time(),
                    'f_logs_type' => '3',
                    'f_logs_info' => '余额支付订单'
                );
                $userAccouontLog = M('finance_logs','uc_')->add($userData);
            }
            $this->ajaxReturn(array('status'=>1,'ts'=>$ts,'ur'=>$usrest,'or'=>$orest,'oa'=>$oarest,'$msgrest' =>$msgrest));
        }else if($pay_amount>0&&I('type')==1){
            $this->ajaxReturn(array('status'=>2,url=>"http://".$_SERVER['SERVER_NAME']."/alipay.wap?money={$pay_amount}&order_sn={$orderInfo['order_sn']}&name=商品下单&open_address="."http://".$_SERVER['SERVER_NAME']));
        }else if($pay_amount>0&&I('type')==2)
        {
            import('Vendor.wxpay.wxpay');
            $config = C("WX_PAY_CONFIG");
            if (empty($config)) {
                $this->show('请设置微信支付配置');
            }
            $wxpay = new \wxpay($config);
            if($inwx==0)
            {
                $order = array(
                    "body" => '商品下单',
                    "product_id" => $orderInfo['order_sn'],
                    "order_sn" => $orderInfo['order_sn'],
                    "total_fee" => $pay_amount*100,
                    "url" => ""
                );
                $order['out_trade_no'] = $order['order_sn'];
                $pay_url = $wxpay->native($order);
                if ($pay_url === false) {
                    $this->show('获取支付链接失败：' . $wxpay->getError());
                    exit;
                }  else {
                    $wx=U("User/qrcode", array('text' => urlencode(urlencode($pay_url))));
                }
            }
            else {
                $order = array(
                    "body" => '商品下单',
                    "total_fee" => $pay_amount*100,
                    "url" => ""
                );
                $order['out_trade_no'] = $order['order_sn'];
                $wx=$wxpay->jsApiPay($order);
            }
            $this->ajaxReturn(array('status'=>3,'wx'=>$wx));
        }
        $this->ajaxReturn(I());
    }
    public function qrcode() {
        $text = I("text", 'QRcode', 'trim,urldecode');
        import('Vendor.phpqrcode.phpqrcode');
        \QRcode::png($text, false, 'H', 4, 1);
    }
	//缴纳保证金
	public function pay_bzj(){
        $must_add = I('must_add');
        $type=I('type');
        $inwx=I('inwx');
        if($must_add>0&&$type==0){
            $ac_pay=$must_add;
            $map['user_money']  = $this->user['user_money']-$ac_pay;
            $map['pledge_money'] = $this->user['pledge_money']+$ac_pay;
            if($map['user_money']<0){
                $this->ajaxReturn(array('status'=>0,msg=>'余额不足，无法支付'));
            }else{
                $u = M('users')->where(array('user_id'=>$this->user_id))->find();
                if($u['parent_id'] == 1){
                    $map['is_lock'] = 3;
                }else{
                    $user_id = $this->user_id;
                    $this->send(3,'',$user_id);
                    $map['is_lock'] = 2;
                }
                $usrest = M('users')->where(array('user_id'=>$this->user_id))->save($map);
            if($usrest){
                $bzj = array(
                    "user_id"=>$this->user_id,
                    "pledge_name"=>'余额缴纳',
                    "pledge_money"=>$map['pledge_money'],
                    "pledge_time"=>time()
                );
                M('pledge')->add($bzj);
                $msg = "缴纳保证金成功";
            }else{
                $msg = "系统错误，请联系管理员";
            }
			}
            $this->ajaxReturn(array('msg'=>$msg,'status'=>$usrest));
			exit;
        }else if($type==1&&$must_add>=0){
            $time = "bzj".date('YmdHis').$this->user_id;
            $this->ajaxReturn(array('status'=>2,url=>"http://".$_SERVER['SERVER_NAME']."/alipay.wap?money={$must_add}&order_sn={$time}&name=缴纳保证金&open_address="."http://".$_SERVER['SERVER_NAME']));
			exit;
        }else if($type==2&&$must_add>=0){
            $time = "bzj".date('YmdHis').$this->user_id;
            import('Vendor.wxpay.wxpay');
            $config = C("WX_PAY_CONFIG");
            if (empty($config)) {
                $this->show('请设置微信支付配置');
            }
            $wxpay = new \wxpay($config);
            if($inwx==0)
            {
                $order = array(
                    "body" => '缴纳保证金',
                    "product_id" => $time,
                    "order_sn" => "bzj".date('YmdHis').$this->user_id,
                    "total_fee" => $must_add*100,
                    "url" => ""
                );
                $order['out_trade_no'] = $order['order_sn'];
                $pay_url = $wxpay->native($order);
                if ($pay_url === false) {
                    $this->show('获取支付链接失败：' . $wxpay->getError());
                    exit;
                }  else {
                    $wx=U("User/qrcode", array('text' => urlencode(urlencode($pay_url))));
                }
            }
            else {
                $order = array(
                    "body" => '缴纳保证金',
                    "total_fee" => $must_add*100,
                    "url" => ""
                );
                $order['out_trade_no'] = $order['order_sn'];
                $wx=$wxpay->jsApiPay($order);
            }
            $this->ajaxReturn(array('status'=>3,'wx'=>$wx));
        }
    }
	 
    //充值
    public function sure_rechage(){
        if(is_numeric(I('money'))){
            $money = I('money');
            $time = "wcz".date('YmdHis').$this->user_id;
            header("Location:http://".$_SERVER['SERVER_NAME']."/alipay.wap?money={$money}&order_sn={$time}&name=充值&open_address="."http://".$_SERVER['SERVER_NAME']);
        }
    }

    public function select_parent(){
        $region = D('region');
        $provinceList = $region->where(array('level'=>1))->select();
        $this->assign('provinceList',$provinceList);
        $this->assign('post',I());
        $this->display('list');
    }

    public function get_city(){
        $region = D('region');
        $city = $region->where(array('parent_id'=>I('province'),'level'=>2))->select();
        $this->ajaxReturn($city);
    }
    /**
     * 获取经销商信息
     */
    public function search_user(){
        $userMod = M('users');
        $mobile = I('mobile');
        $username = I('username');
        if(empty($mobile)){
            $where = " username='".$username."' and is_lock=0";
        }else{
            $where = " mobile=".$mobile." and is_lock=0";
        }
        $result = $userMod->where($where)->find();
        if($result){
            $userLog  = new UsersLogic();
            $list = $userLog->get_children($result['user_id']);
            $result['count_child'] = count($list);
            if(I(type==2)){
                $result['levelName'] = $this->get_level($result['level']);
                if(!empty($result['province'])){
                    $province = M('region')->find($result['province']);
                }
                if(!empty($result['city'])){
                    $city = M('region')->find($result['city']);
                }
                $result['detailAdd'] = $province['name'].$city['name'];
                if(empty($result['detailAdd'])){
                    $result['detailAdd'] = "暂无设置代理地区";
                }
            }
            $this->ajaxReturn(array('status'=>1000,'msg'=>$result));
        }else{
            $this->ajaxReturn ( array (
                'status' => 1001,
                'msg' => '找不到该经销商'
            ) );
        }
    }
    public function find_user() {
        $userMod = M ( 'users' );
        $city = I ( 'city' );
        if (empty ( $city )) {
            $where = array (
                'province' => array (
                    'in',
                    '0,' . I('province')
                )
            );
        } else {
            $where = array (
                'province' => array (
                    'in',
                    '0,' . I ( 'province' )
                ),
                'city' => array (
                    'in',
                    '0,' . I ( 'city' )
                )
            );
        }

        $level = I ( 'level' );
        // for($i=($level-1);$i>=0;$i--){
        $where ['level'] = array (
            'ELT',
            $level

        );
        $where ['is_lock'] = 0;
        //$return = $userMod->where ( $where )->where("parent_id = 0")->select();
        $return = $userMod->where ( $where )->select ();
        if ($return) {
            foreach ( $return as $key => $val ) {
                $userLog = new UsersLogic ();
                $list = $userLog->get_children ( $val ['user_id'] );
                $return [$key] ['count_child'] = count ( $list );
                $return [$key] ['level'] = get_level ( $val ['level'] );
            }
            $this->ajaxReturn ( array (
                'status' => 1002,
                'msg' => '该地区没有您直接上级,已为您选择您可以选择的上级',
                'data' => $return
            ) );

        }
        //    }
    }
    /*
     * 订单列表
     * 此方法还需添加查看下级订单功能
     */
    public function order_list()
    {
        $where = ' user_id='.$this->user_id;
        //条件搜索 
        if(in_array(strtoupper(I('get.type')), array('WAITCCOMMENT','COMMENTED')))
        {
            $where .= " AND order_status in(2) AND shipping_status=1 AND pay_status=1 "; //代评价 和 已评价

        }
        elseif(I('get.type'))
        {

            $where .= C(strtoupper(I('get.type')));

        }
        //echo $where;exit;
        $count = M('order')->where($where)->count();
        $Page = new Page($count,10);

        $show = $Page->show();
        $order_str = "order_id DESC";
        $order_list = M('order')->order($order_str)->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach($order_list as $k => $v){
            $order_goods = M('order_goods')->field('goods_name,goods_num,member_goods_price,goods_id')->where("order_id = " . $v['order_id'])->select();
            foreach($order_goods as $kk => $vv){
                $good_img = M('goods')->field('original_img')->where("goods_id=" . $vv['goods_id'])->find();
                $order_goods[$kk]['good_img'] = $good_img;
            }
            $order_list[$k]['order_goods'] = $order_goods;
        }
        //var_dump($order_list);exit;
		//print_r($order_list);exit;
        //获取订单商品
        $model = new UsersLogic();
        foreach($order_list as $k=>$v)
        {
            $order_list[$k] = set_btn_order_status($v);  // 添加属性  包括按钮显示属性 和 订单状态显示属性
            $order_list[$k]['total_fee'] = $v['goods_amount'] + $v['shipping_fee'] - $v['integral_money'] -$v['bonus'] - $v['discount']; //订单总额
            $data = $model->get_order_goods($v['order_id']);
			$return = M('return_goods')->where("order_id =".$order_list[$k]['order_id'])->find();
		    $return = json_decode($return['goods_info'],true);
		    foreach($return as $key=>$val){
                $order_list[$k]['return_money'] += $val['goods_num']*$val['goods_price'];
            }
            $order_list[$k]['goods_list'] = $data['result'];
            $order_list[$k]['order_status_name'] = $this->get_order_status($v['order_status']);
        }
        $this->assign('order_status',C('ORDER_STATUS'));
        $this->assign('shipping_status',C('SHIPPING_STATUS'));
        $this->assign('pay_status',C('PAY_STATUS'));
        $this->assign('page',$show);
        $this->assign('lists',$order_list);
        $this->assign('active','order_list');
        $this->assign('active_status',I('get.type'));
        if($_GET['is_ajax'])
        {
            $this->display('ajax_order_list');
            exit;
        }
        $this->display('order_list_my');
    }
    
    /*
     * 可退货订单
     */
    public function order_ktlist()
    {
        $where = ' user_id='.$this->user_id;
        //条件搜索 
        if(I('get.type') == 'ketuihuo'){  //可退货单
             $where .= " AND order_status in(2)" ;
        }
        if(in_array(strtoupper(I('get.type')), array('WAITCCOMMENT','COMMENTED')))
        {
            $where .= " AND order_status in(2) AND shipping_status=1 AND pay_status=1 "; //代评价 和 已评价
        }
        elseif(I('get.type'))
        {
            $where .= C(strtoupper(I('get.type')));
        }
        $count = M('order')->where($where)->count();
        $Page = new Page($count,10);

        $show = $Page->show();
        $order_str = "order_id DESC";
        $order_list = M('order')->order($order_str)->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
		//print_r($order_list);exit;
        //获取订单商品
        $model = new UsersLogic();
        foreach($order_list as $k=>$v)
        {
            $order_list[$k] = set_btn_order_status($v);  // 添加属性  包括按钮显示属性 和 订单状态显示属性
            $order_list[$k]['total_fee'] = $v['goods_amount'] + $v['shipping_fee'] - $v['integral_money'] -$v['bonus'] - $v['discount']; //订单总额
            $data = $model->get_order_goods($v['order_id']);
			$return = M('return_goods')->where("order_id =".$order_list[$k]['order_id'])->find();
		    $return = json_decode($return['goods_info'],true);
		    foreach($return as $key=>$val){
                $order_list[$k]['return_money'] += $val['goods_num']*$val['goods_price'];
            }
            $order_list[$k]['goods_list'] = $data['result'];
            $order_list[$k]['order_status_name'] = $this->get_order_status($v['order_status']);
        }
        $this->assign('order_status',C('ORDER_STATUS'));
        $this->assign('shipping_status',C('SHIPPING_STATUS'));
        $this->assign('pay_status',C('PAY_STATUS'));
        $this->assign('page',$show);
        $this->assign('lists',$order_list);
        $this->assign('active','order_list');
        $this->assign('active_status',I('get.type'));
        if($_GET['is_ajax'])
        {
            $this->display('ajax_order_ktlist');
            exit;
        }
        $this->display('order_list_my');
    }
    /*
     * 订单列表
     */
    public function ajax_order_list(){

    }
    /*
     * 订单列表
    * 此方法还需添加查看下级订单功能
    */
    public function order_list_down()
    {
        $parent_id = $this->user_id;
        $child_id = M('users')->where("parent_id =  $parent_id")->field('user_id')->select();
        $child_id_in='(0';
        if($child_id){
            foreach ($child_id as $key=>$value){
                $child_id_in .= ','.$value['user_id'];
            }
        }
        $child_id_in .= ') ';
        $where = ' user_id  in '.$child_id_in;
        //条件搜索
        if(in_array(strtoupper(I('type')), array('WAITCCOMMENT','COMMENTED')))
        {
            $where .= " AND order_status in(1,4) "; //代评价 和 已评价
        }
        elseif(I('type'))
        {
            $where .= C(strtoupper(I('type')));
        }
        $where .= " and  pay_status = 1 ";
        $count = M('order')->where($where)->count();
        $Page = new Page($count,10);

        $show = $Page->show();
        $order_str = "order_id DESC";
        $order_list = M('order')->order($order_str)->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach($order_list as $k => $v){
            $order_goods = M('order_goods')->field('goods_name,goods_num,member_goods_price,goods_id')->where("order_id = " . $v['order_id'])->select();
            foreach($order_goods as $kk => $vv){
                $good_img = M('goods')->field('original_img')->where("goods_id=" . $vv['goods_id'])->find();
                $order_goods[$kk]['good_img'] = $good_img;
            }
            $order_list[$k]['order_goods'] = $order_goods;
        }
        //获取订单商品
        $model = new UsersLogic();
        foreach($order_list as $k=>$v)
        {
            $order_list[$k] = set_btn_order_status($v);  // 添加属性  包括按钮显示属性 和 订单状态显示属性
            $order_list[$k]['total_fee'] = $v['goods_amount'] + $v['shipping_fee'] - $v['integral_money'] -$v['bonus'] - $v['discount']; //订单总额
            $data = $model->get_order_goods($v['order_id']);
            $order_list[$k]['goods_list'] = $data['result'];
            $order_list[$k]['order_status_name'] = $this->get_order_status($v['order_status']);
        }
        $this->assign('order_status',C('ORDER_STATUS'));
        $this->assign('shipping_status',C('SHIPPING_STATUS'));
        $this->assign('pay_status',C('PAY_STATUS'));
        $this->assign('page',$show);
        $this->assign('lists',$order_list);
        $this->assign('active','order_list');
        $this->assign('active_status',I('get.type'));
        if($_GET['is_ajax'])
        {
            $this->display('ajax_order_list_down');
            exit;
        }
        $this->display('order_list_my_down');
    }


    /*
     * 订单列表
    */
    public function ajax_order_list_down(){

    }
    /*
     * 发货
     */
    public function fahuo(){
        $where['order_id'] = I('id');
        $courier_num = I('courier_num');
        $courier_name = I('courier_name');
        //---------------增减库存-------------------//
        $order = M('order')->where($where)->field('order_id,user_id,parent_id,order_sn')->find();
        $order_goods = M('order_goods')->where('order_id='.$order['order_id'])->select();

        /* 	foreach ($order_goods as $key=>$val){
                $maps = array(
                        'uid'=>$this->user_id,
                        'goods_id'=>$val['goods_id'],
                        'spec_id'=>$val['spec_key']
                );
                $t = M('UserGoods')->where($maps)->find();
                $t['stock'] = $t['stock']-$val['goods_num'];
                $t['up_time'] = time();
                $rest = M('UserGoods')->where($maps)->save($t);
            } */
        $msgLog = new MsgLogic();
        $msgLog->send_msg(2, $order['order_sn'],$order['user_id']);
        $model = new UsersLogic();
        $data = $model->get_order_goods($order['order_id']); //获取订单商品
        //$res_stock = D('UserGoods')->buyadd_user_store($order['user_id'],$order['parent_id'],$data);
        //---------------增减库存-------------------//
        $data['shipping_status'] = 1;
        $data['shipping_name'] = $courier_name;
        $data['shipping_code'] = $courier_num;
        $res = M('order')->where($where)->save($data);
        $order = $this->save_fahuo_info($where['order_id']);
        if($res){
            $order_id = I('id');
            $order_sn = M('order')->where('order_id ='.$order_id)->getField('order_sn');
            $user_id = M('order')->where('order_id ='.$order_id)->getField('user_id');
            $this->send(5,$order_sn,$user_id);
            $this->success('操作成功');
        }else{
            $this->error('操作失败');
        }

    }
    public function save_fahuo_info($order_id){
        $order = $this->getOrderInfo($order_id);
        $data['order_id'] = $order_id;
        $data['order_sn'] = $order['order_sn'];
        $data['delivery_sn'] = $this->get_delivery_sn();
        $data['zipcode'] = $order['zipcode'];
        $data['user_id'] = $order['user_id'];
        $data['admin_id'] = $this->user_id;
        $data['consignee'] = $order['consignee'];
        $data['mobile'] = $order['mobile'];
        $data['country'] = $order['country'];
        $data['province'] = $order['province'];
        $data['city'] = $order['district'];
        $data['district'] = $order['order_sn'];
        $data['address'] = $order['address'];
        $data['invoice_no'] = $order['shipping_code'];
        $data['shipping_code'] = $order['shipping_code'];
        $data['shipping_name'] = $order['shipping_name'];
        $data['shipping_price'] = $order['shipping_price'];
        $data['create_time'] = time();
        $did = M('delivery_doc')->add($data);
        return $did;
    }
    //获取订单详情
    public function getOrderInfo($order_id)
    {
        //  订单总金额查询语句
        $total_fee = " (goods_price + shipping_price - discount - coupon_price - integral_money) AS total_fee ";
        $sql = "SELECT *, " . $total_fee . " FROM __PREFIX__order WHERE order_id = '$order_id'";
        $res = M('order')->query($sql);
        //$res[0]['address2'] = $this->getAddressName($res[0]['province'],$res[0]['city'],$res[0]['district']);
        //$res[0]['address2'] = $res[0]['address2'].$res[0]['address'];
        return $res[0];
    }
    /**
     * 得到发货单流水号
     */
    public function get_delivery_sn()
    {
        /* 选择一个随机的方案 */send_http_status('310');
        mt_srand((double) microtime() * 1000000);
        return date('YmdHi') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }
    /*
     * 订单详情
     */
    public function order_detail(){
        $id = I('get.id');
        $type = I('type');
        $map['order_id'] = $id;
        // $map['user_id'] = $this->user_id;
        $order_info = M('order')->where($map)->find();
        $order_info = set_btn_order_status($order_info);  // 添加属性  包括按钮显示属性 和 订单状态显示属性
        if(!$order_info){
            $this->error('没有获取到订单信息');
            exit;
        }
        $return_goods = array();
        if($order_info['order_status']==6 || $order_info['order_status']==7){
            $return_goods = M('return_goods')->where("order_id = $id")->find();
            $return_goods = json_decode($return_goods['goods_info'],true);
            foreach($return_goods as $key=>$val){
                $order_info['return_money'] +=   $val['goods_num']*$val['goods_price'];
            }

        }
        //获取订单商品
        $model = new UsersLogic();
        $data = $model->get_order_goods($order_info['order_id']);
        foreach($data['result'] as $k=>$v){
            foreach($return_goods as $kk=>$vv){
                if($vv['goods_id'] == $v['goods_id']){
                    $data['result'][$k]['return_num'] = $vv['goods_num'];
                }
            }
        }
        $order_info['goods_list'] = $data['result'];
        $order_info['total_fee'] = $order_info['goods_price'] + $order_info['shipping_price'] - $order_info['integral_money'] -$order_info['coupon_price'] - $order_info['discount'];
        $region_list = get_region_list();
        $invoice_no = M('delivery_doc')->where("order_id=$id")->field('invoice_no')->find();
        $order_info['invoice_no']=$invoice_no['invoice_no'];
        //获取订单操作记录
        $order_action = M('order_action')->where(array('order_id'=>$id))->select();
        $this->assign('order_status',C('ORDER_STATUS'));
        $this->assign('shipping_status',C('SHIPPING_STATUS'));
        $this->assign('pay_status',C('PAY_STATUS'));
        $this->assign('region_list',$region_list);
        $this->assign('order_info',$order_info);
        $province = M('region')->find($order_info['province']);
        $city = M('region')->find($order_info['city']);
        $order_address = $province['name'].$city['name'].$order_info['address'];
        $this->assign('order_action',$order_action);
        $this->assign('or_add',$order_address);
        $this->assign('type',$type);
        $this->display('order_detail_my');
    }

    /*
     * 修改订单状态
      'ORDER_STATUS' => array(
        0 => '待确认',
        1 => '已确认',
        2 => '已收货',
        3 => '已取消',
        4 => '已完成',
        5 => '已作废',
    ),
    'SHIPPING_STATUS' => array(
        0 => '未发货',
        1 => '已发货',
        2 => '部分发货'
    ),
    'PAY_STATUS' => array(
        0 => '未支付',
        1 => '已支付',
    ),
     */
    public function change_order_status(){
        $id = I('get.id');
        $status = I('status');
        $res = M('order')->where("order_id = $id")->save("order_status = $status");
        if($res){
            $back['status']=1;
            $back['info'] ="操作成功";
        }else{
            $back['status']=0;
            $back['info'] ="操作失败";
        }
        $this->ajaxReturn($back);
    }
    /*
     * 取消订单
     */
    public function cancel_order(){
        $id = I('get.id');
        //检查是否有积分，余额支付
        $logic = new UsersLogic();
        $data = $logic->cancel_order($this->user_id,$id);
        if($data['status'] < 0)
            $this->error($data['msg']);
        $this->success($data['msg']);
    }

    /*
     * 用户地址列表
     */
    public function address_list(){
        $address_lists = get_user_address_list($this->user_id);
        $region_list = M('region');
        foreach ($address_lists as $key=>$val){
            $province =  $region_list->where(array('id'=>$val['province']))->find();
            $address_lists[$key]['province'] =$province['name'];
            $city = $region_list->where(array('id'=>$val['city']))->find();
            $address_lists[$key]['city']=$city['name'];
            $district = $region_list->where(array('id'=>$val['district']))->find();
            $address_lists[$key]['district'] = $district['name'];
            $address_lists[$key]['re_address'] =$address_lists[$key]['province'].$address_lists[$key]['city'].$address_lists[$key]['address'];
        }
        $this->assign('lists',$address_lists);
        //$this->display('address_list');
        $this->display('adress');
    }

    /*
     * 添加地址
     */
    public function add_address()
    {
        if(IS_POST)
        {
            $key = I('keys');
            $logic = new UsersLogic();
            $data = $logic->add_address($this->user_id,0,I('post.'));
            if($data['status'] != 1)
                $this->error($data['msg']);

            if(!empty($key)){
                $this->success($data['msg'],U('/Mobile/Cart/sure_buy')."?key=".$key,false,'返回购买页');
                exit();
            }
            $this->success($data['msg'],U('/Mobile/User/index'));
            exit();
        }
        $key = I('key');
        if(!empty($key)){

            $this->assign('keys',$key);
        }
        $p = M('region')->where(array('parent_id'=>0,'level'=> 1))->select();
        $this->assign('province',$p);
        //$this->display('edit_address');
        $this->display();

    }

    /*
     * 地址编辑
     */
    public function edit_address()
    {
        $id = I('id');
        $address = M('user_address')->where(array('address_id'=>$id,'user_id'=> $this->user_id))->find();
        if(IS_POST)
        {
            $logic = new UsersLogic();
            $data = $logic->add_address($this->user_id,$id,I('post.'));
            $this->success($data['msg'],U('/Mobile/User/address_list'),false,"返回上一级");
            exit();
        }
        //获取省份
        $p = M('region')->where(array('parent_id'=>0,'level'=> 1))->select();
        $c = M('region')->where(array('parent_id'=>$address['province'],'level'=> 2))->select();
        $d = M('region')->where(array('parent_id'=>$address['city'],'level'=> 3))->select();
        if($address['twon']){
            $e = M('region')->where(array('parent_id'=>$address['district'],'level'=>4))->select();
            $this->assign('twon',$e);
        }
        $this->assign('city',$c);
        $this->assign('province',$p);
        $this->assign('district',$d);
        $this->assign('address',$address);
        $this->display();
    }

    /*
     * 设置默认收货地址
     */
    public function set_default(){
        $id = I('get.id');
        $source = I('get.source');
        M('user_address')->where(array('user_id'=>$this->user_id))->save(array('is_default'=>0));
        $row = M('user_address')->where(array('user_id'=>$this->user_id,'address_id'=>$id))->save(array('is_default'=>1));
        $this->ajaxReturn(array(
            'status'=>$row
        ));
    }

    /*
     * 地址删除
     */
    public function del_address(){
        $id = I('get.id');

        $address = M('user_address')->where("address_id = $id")->find();
        if($address['is_default']==1){
            $set_deafult =  M('user_address')->where(array('user_id'=>$this->user_id))->find();
            M('user_address')->where(array('address_id'=>$set_deafult['address_id']))->save(array('is_default'=>1));
        }
        $row = M('user_address')->where(array('user_id'=>$this->user_id,'address_id'=>$id))->delete();
        $this->ajaxReturn(array('status'=>$row));
        // 如果删除的是默认收货地址 则要把第一个地址设置为默认收货地址
    }

    /*
     * 评论晒单
    
    public function comment(){
    	$user_id = $this->user_id;
    	$status = I('get.status');
    	$logic = new UsersLogic();
    	$result = $logic->get_comment($user_id,$status); //获取评论列表    
    	$this->assign('comment_list',$result['result']);       
        if($_GET['is_ajax'])
        {
            $this->display('ajax_comment_list');
            exit;
        }           
    	$this->display();
    }
 */
    /*
     *添加评论
    
    public function add_comment(){    
    	if(IS_POST){
    		// 晒图片
    		if($_FILES[comment_img_file][tmp_name][0])
    		{
    			$upload = new \Think\Upload();// 实例化上传类
    			$upload->maxSize   =    $map['author'] = (1024*1024*3);// 设置附件上传大小 管理员10M  否则 3M
    			$upload->exts      =    array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    			$upload->rootPath  =    './Public/upload/comment/'; // 设置附件上传根目录
    			$upload->replace   =    true; // 存在同名文件是否是覆盖，默认为false
    			//$upload->saveName  =  'file_'.$id; // 存在同名文件是否是覆盖，默认为false
    			// 上传文件
    			$upinfo  =  $upload->upload();
    			if(!$upinfo) {// 上传错误提示错误信息
    				$this->error($upload->getError());
    			}else{
    				foreach($upinfo as $key => $val)
    				{
    					$comment_img[] = '/Public/upload/comment/'.$val['savepath'].$val['savename'];
    				}
    				$add['img'] = serialize($comment_img); // 上传的图片文件
    			}
    		}
    		
    		$user_info = session('user');
    		$logic = new UsersLogic();
    		$add['goods_id'] = I('goods_id');
    		$add['email'] = $user_info['email'];
    		$hide_username = I('hide_username');
    		if(empty($hide_username)){
    			$add['username'] = $user_info['nickname'];
    		}
    		$add['order_id'] = I('order_id');
    		$add['service_rank'] = I('service_rank');
    		$add['deliver_rank'] = I('deliver_rank');
    		$add['goods_rank'] = I('goods_rank');
    		//$add['content'] = htmlspecialchars(I('post.content'));
    		$add['content'] = I('content');
    		$add['add_time'] = time();
    		$add['ip_address'] = getIP();
    		$add['user_id'] = $this->user_id;
    		
    		//添加评论
    		$row = $logic->add_comment($add);
    		if($row[status] == 1)
    		{
    			$this->success('评论成功',U('/Mobile/Goods/goodsInfo',array('id'=>$add['goods_id'])));
    			exit();
    		}
    		else
    		{
    			$this->error($row[msg]);
    		}
    	}
        $rec_id = I('rec_id');
        $order_goods = M('order_goods')->where("rec_id = $rec_id")->find();
        $this->assign('order_goods',$order_goods);
        $this->display();
    }
 */
    /*
     * 个人信息
     */
    public function userinfo(){
        $userLogic = new UsersLogic();
        $user_info = $userLogic->get_info($this->user_id); // 获取用户信息d
        $user_info = $user_info['result'];
        if(IS_POST){

            $time=time();
            $config = array(
                'maxSize'    =>    3145728,
                'rootPath'   =>    'Public/upload/head_pic/',
                'saveName'   =>    array('uniqid',''),
                'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
                'autoSub'    =>    true,
                'subName'    =>    array('date','Ymd'),
            );
            if($_FILES['file1']['error'][0]==0){
                $upload = new \Think\Upload($config);// 实例化上传类

                $info = $upload->upload();
                if(!$info){
                    //$this->error($upload->getError());
                }else{
                    $post['head_pic']=$config['rootPath'].$info['photo1']['savepath'].$info['photo1']['savename'];
                }
            }
            I('post.nickname') ? $post['nickname'] = I('post.nickname') : false; //昵称
            I('post.username') ? $post['username'] = I('post.username') : false; //昵称
            I('post.qq') ? $post['qq'] = I('post.qq') : false;  //QQ号码
            I('post.head_pic') ? $post['head_pic'] = I('post.head_pic') : false; //头像地址
            I('post.sex') ? $post['sex'] = I('post.sex') : false;  // 性别
            I('post.birthday') ? $post['birthday'] = strtotime(I('post.birthday')) : false;  // 生日
            I('post.province') ? $post['province'] = I('post.province') : false;  //省份
            I('post.city') ? $post['city'] = I('post.city') : false;  // 城市
            //     I('post.district') ? $post['district'] = I('post.district') : false;  //地区
            I('post.email') ? $post['email'] = I('post.email') : false; //昵称
            I('post.my_desc') ? $post['my_desc'] = I('post.my_desc') : false; //简介
            if(!$userLogic->update_info($this->user_id,$post))
                $this->error("保存失败",U('index'),false,"返回上一级");
            $this->success("操作成功",U('index'),false,"返回上一级");
            exit;
        }
        //  获取省份
        $province = M('region')->where(array('parent_id'=>0,'level'=>1))->select();
        //  获取订单城市
        $city =  M('region')->where(array('parent_id'=>$user_info['province'],'level'=>2))->select();
        //  获取订单地区
        //  $area =  M('region')->where(array('parent_id'=>$user_info['city'],'level'=>3))->select();


        $this->assign('province',$province);
        $this->assign('city',$city);
        //   $this->assign('area',$area);
        $this->assign('user',$user_info);
        $this->assign('sex',C('SEX'));
        //$this->display();
        $this->display('user_detail');
    }

    /*
     * 邮箱验证
    
    public function email_validate(){
        $userLogic = new UsersLogic();
        $user_info = $userLogic->get_info($this->user_id); // 获取用户信息
        $user_info = $user_info['result'];
        $step = I('get.step',1);
        //验证是否未绑定过
        if($user_info['email_validated'] == 0)
            $step = 2;
        //原邮箱验证是否通过
        if($user_info['email_validated'] == 1 && session('email_step1') == 1)
            $step = 2;
        if($user_info['email_validated'] == 1 && session('email_step1') != 1)
            $step = 1;
        if(IS_POST){
            $email = I('post.email');
            $code = I('post.code');
            $info = session('email_code');
            if(!$info)
                $this->error('非法操作');
            if($info['email'] == $email || $info['code'] == $code){
                if($user_info['email_validated'] == 0 || session('email_step1') == 1){
                    session('email_code',null);
                    session('email_step1',null);
                    if(!$userLogic->update_email_mobile($email,$this->user_id))
                        $this->error('邮箱已存在');
                    $this->success('绑定成功',U('Home/User/index'));
                }else{
                    session('email_code',null);
                    session('email_step1',1);
                    redirect(U('Home/User/email_validate',array('step'=>2)));
                }
                exit;
            }
            $this->error('验证码邮箱不匹配');
        }
        $this->assign('step',$step);
        $this->display();
    }
 */
    /*
    * 手机验证
   
    public function mobile_validate(){
        $userLogic = new UsersLogic();
        $user_info = $userLogic->get_info($this->user_id); // 获取用户信息
        $user_info = $user_info['result'];
        $step = I('get.step',1);
        //验证是否未绑定过
        if($user_info['mobile_validated'] == 0)
            $step = 2;
        //原手机验证是否通过
        if($user_info['mobile_validated'] == 1 && session('mobile_step1') == 1)
            $step = 2;
        if($user_info['mobile_validated'] == 1 && session('mobile_step1') != 1)
            $step = 1;
        if(IS_POST){
            $mobile = I('post.mobile');
            $code = I('post.code');
            $info = session('mobile_code');
            if(!$info)
                $this->error('非法操作');
            if($info['email'] == $mobile || $info['code'] == $code){
                if($user_info['email_validated'] == 0 || session('email_step1') == 1){
                    session('mobile_code',null);
                    session('mobile_step1',null);
                    if(!$userLogic->update_email_mobile($mobile,$this->user_id,2))
                        $this->error('手机已存在');
                    $this->success('绑定成功',U('Home/User/index'));
                }else{
                    session('mobile_code',null);
                    session('email_step1',1);
                    redirect(U('Home/User/mobile_validate',array('step'=>2)));
                }
                exit;
            }
            $this->error('验证码手机不匹配');
        }
        $this->assign('step',$step);
        $this->display();
    }
     */
    /*
public function collect_list(){
$userLogic = new UsersLogic();
$data = $userLogic->get_goods_collect($this->user_id);
$this->assign('page',$data['show']);// 赋值分页输出
$this->assign('goods_list',$data['result']);
if($_GET['is_ajax'])
{
$this->display('ajax_collect_list');
exit;
}
$this->display();
}
*/
    /*
     *取消收藏
    
    public function cancel_collect(){
       $collect_id = I('collect_id');
       $user_id = $this->user_id;
       if(M('goods_collect')->where("collect_id = $collect_id and user_id = $user_id")->delete()){
       		$this->success("取消收藏成功",U('User/collect_list'));
       }else{
       		$this->error("取消收藏失败",U('User/collect_list'));
       }
    }
 */
    /*
public function message_list()
{
C('TOKEN_ON',true);
if(IS_POST)
{
$this->verifyHandle('message');

$data = I('post.');
$data['user_id'] = $this->user_id;
$user = session('user');
$data['user_name'] = $user['nickname'];
$data['msg_time'] = time();
if(M('feedback')->add($data)){
$this->success("留言成功",U('User/message_list'));
        exit;
}else{
$this->error('留言失败',U('User/message_list'));
        exit;
}
}
$msg_type = array(0=>'留言',1=>'投诉',2=>'询问',3=>'售后',4=>'求购');
$count = M('feedback')->where("user_id=".$this->user_id)->count();
$Page = new Page($count,100);
$Page->rollPage = 2;
$message = M('feedback')->where("user_id=".$this->user_id)->limit($Page->firstRow.','.$Page->listRows)->select();
$showpage = $Page->show();
header("Content-type:text/html;charset=utf-8");
$this->assign('page',$showpage);
$this->assign('message',$message);
$this->assign('msg_type',$msg_type);
$this->display();
}
*/
    public function points(){
        $count = M('account_log')->where("user_id=".$this->user_id)->count();
        $Page = new Page($count,16);
        $account_log = M('account_log')->where("user_id=".$this->user_id)->order('log_id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $showpage = $Page->show();
        $this->assign('account_log',$account_log);
        $this->assign('page',$showpage);
        if($_GET['is_ajax'])
        {
            $this->display('ajax_points');
            exit;
        }
        $this->display();
    }
    /*
     * 密码修改
     */
    public function password(){
        //检查是否第三方登录用户
        $logic = new UsersLogic();
        $data = $logic->get_info($this->user_id);
        $user = $data['result'];
        if($user['mobile'] == ''&& $user['email'] == '')
            $this->error('请先到电脑端绑定手机',U('/Mobile/User/index'));
        if(IS_POST){
            $userLogic = new UsersLogic();
            $data = $userLogic->password($this->user_id,I('post.old_password'),I('post.new_password'),I('post.confirm_password')); // 获取用户信息
            if($data['status'] == -1)
                $this->error($data['msg']);
            $this->success($data['msg']);
            exit;
        }
        $this->display();
    }
    function forget_pwd(){
        if($this->user_id > 0){
            header("Location: ".U('User/Index'));
        }
        $username = I('tel');
        if(IS_POST){
            if(!empty($username)){

                $user = M('users')->where("email='$username' or mobile='$username'")->find();
                if($user){

                    $viry1 = session($username."2");
                    $viry2=  I('viry');
                    session('find_password',$user);

                    if($viry1!=$viry2){
                        $this->error("验证码错误",U('forget_pwd'));
                    }
                    header("Location: ".U('User/find_pwd'));
                    exit;
                }else{
                    $this->error("用户名不存在，请检查");
                }
            }
        }
        $this->display('forget_pwds');
    }

    function find_pwd(){
        if($this->user_id > 0){
            header("Location: ".U('User/Index'));
        }
        $user = session('find_password');
        if(empty($user)){
            $this->error("请先验证用户名",U('User/forget_pwd'));
        }
        $this->assign('user',$user);
        $this->display('find_pwds');
    }


    public function set_pwd(){
        if($this->user_id > 0){
            header("Location: ".U('User/Index'));
        }

        if(IS_POST){
            $password = I('post.password');
            $password2 = I('post.password2');
            if($password2 != $password){
                $this->error('两次密码不一致',U('User/set_pwd'));
            }

            $user = session('find_password');

            M('users')->where("user_id=".$user['user_id'])->save(array('password'=>encrypt($password)));

            header("Location:".U('User/login'));

        }
        $is_set = I('is_set',0);
        $this->assign('is_set',$is_set);
        $this->display();
    }

    //发送验证码
    public function send_validate_code(){
        $type = I('type');
        $send = I('send');
        $logic = new UsersLogic();
        $logic->send_validate_code($send, $type);
    }

    public function check_validate_code(){
        $code = I('post.code');
        $send = I('send');
        $logic = new UsersLogic();
        $logic->check_validate_code($code, $send);
    }

    /**
     * 验证码验证
     * $id 验证码标示
     */
    private function verifyHandle($id)
    {
        $verify = new Verify();
        if (!$verify->check(I('post.verify_code'), $id ? $id : 'user_login')) {
            $this->error("验证码错误");
        }
    }

    /**
     * 验证码获取
     */
    public function verify()
    {
        //验证码类型
        $type = I('get.type') ? I('get.type') : 'user_login';
        $config = array(
            'fontSize' => 40,
            'length' => 4,
            'useCurve' => true,
            'useNoise' => false,
        );
        $Verify = new Verify($config);
        $Verify->entry($type);
    }
    /**
     * 账户管理
     */
    public function accountManage()
    {
        $this->display();
    }
    public function order_confirm(){
        $id = I('get.id',0);
        $logic = new UsersLogic();
        $data = $logic->confirm_order($this->user_id,$id);
        if(!$data['status'])
            $this->error($data['msg']);
        $this->success($data['msg']);

    }
    /**
     * 可退货订单
     */
    public function return_order(){
        //$logic = new UsersLogic();
        $where['order_status'] = 2;
        $where['shipping_status'] = 1;
        $where['user_id'] = $this->user_id;
        $return_list = M('order')->where($where)->select();
        //dump(M()->_sql());dump($return_list);die;
        $this->assign('lists',$return_list);
        $this->display();
    }
    /**
     * 可退货订单详情
     */
    public function return_order_detail(){
        //
    }
    /**
     * 申请退货
     */
    public function return_goods()
    {
        $order_id = I('order_id',0);
        $order_sn = I('order_sn',0);
        $goods_id = I('goods_id',0);
        $return_goods = M('return_goods')->where("order_id = $order_id  and status in(0,1)")->find();
        if(!empty($return_goods))
        {
            $this->success('已经提交过退货申请!',U('Mobile/User/return_goods_info',array('id'=>$return_goods['id'])));
            exit;
        }
        if(IS_POST)
        {
            // 晒图片
            if($_FILES[return_imgs][tmp_name][0])
            {
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize   =    $map['author'] = (1024*1024*3);// 设置附件上传大小 管理员10M  否则 3M
                $upload->exts      =    array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                $upload->rootPath  =    './Public/upload/return_goods/'; // 设置附件上传根目录
                $upload->replace   =    true; // 存在同名文件是否是覆盖，默认为false
                //$upload->saveName  =  'file_'.$id; // 存在同名文件是否是覆盖，默认为false
                // 上传文件
                $upinfo  =  $upload->upload();
                if(!$upinfo) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                }else{
                    foreach($upinfo as $key => $val)
                    {
                        $return_imgs[] = '/Public/upload/return_goods/'.$val['savepath'].$val['savename'];
                    }
                    $data['imgs'] = implode(',', $return_imgs);// 上传的图片文件
                }
            }

            $data['order_id'] = $order_id;
            $data['order_sn'] = $order_sn;
            $data['goods_id'] = 0;
            $data['addtime'] = time();
            $data['user_id'] = $this->user_id;
            $data['return_sn'] = I('return_sn','');
            $flag = ture;
            $goods_num = I('goods_num');
            $goods_price = I('goods_peice');
            $goods_info = array();
            $goods_id = I('goods_id');
            $array_key = 0;
            $des_money = 0;
            foreach($goods_id as $k=>$v){
                if((int)$goods_num[$k] !=0){
                    $real_goods_num = M('order_goods')->where("order_id = $order_id and goods_id = $v")->getField('goods_num');
                    if($real_goods_num<$goods_num[$k]){ $this->error('退货数量超过购买数量！',U('Mobile/User/return_goods',array('order_id'=>$order_id,'order_sn'=>$order_sn)));die;}
                    $goods_info[$array_key]['goods_id'] = $v;
                    $goods_info[$array_key]['goods_num'] =$goods_num[$k];
                    $goods_info[$array_key]['goods_price'] = $goods_price[$k];
                    $res1 = M('user_goods')->where("uid=$this->user_id and goods_id = $v")->setDec('stock',$goods_num[$k]); //更改用户库存
                    //M('order_goods')->where("order_id = $order_id and goods_id = $v")->setDec('goods_num',$goods_num[$k]);  //更新订单商品数量
                    $des_money += $goods_num[$k] *$goods_price[$k];
                    $array_key++;
                }
            }
            if(count($goods_info)==0){
                $this->error('请填写退货数量',U('Mobile/User/return_goods',array('order_id'=>$order_id,'order_sn'=>$order_sn)));die;
            }else{
                $goods_info = json_encode($goods_info);
            }
            $logic = new UsersLogic();
            $user_info = $logic->get_info($this->user_id);
            $user_info = $user_info['result'];
            $data['parent_id'] = $user_info['parent_id'];
            $data['goods_info'] = $goods_info;

            $data['type'] = I('type'); // 服务类型  退货 或者 换货
            $data['reason'] = I('reason'); // 问题描述            
            M('return_goods')->add($data);
            $order_info =  M('order')->where("order_id = $order_id")->find();
            $data_order['order_status'] = 6;
            $data_order['coupon'] = $order_info['coupon'] - $des_money;
            //$data_order['order_amount'] = $order_info['order_amount'] - $des_money;
            //$data_order['total_amount'] = $order_info['total_amount'] - $des_money;  //sb产品说要更改订单金额  操蛋的又得改回来
            $res = M('order')->where("order_id = $order_id")->save($data_order);
            $msgLog = new MsgLogic();
            $msgLog->send_msg(3, $order_sn,$user_info['parent_id']);
            $user_id = $this->user_id;
            $this->send(6,$order_sn,$user_id);
            $this->success('申请成功,客服第一时间会帮你处理',U('Mobile/User/order_list'));
            exit;
        }

        $goods = M('order_goods')->where("order_id = $order_id")->field('goods_id,order_id,goods_name,goods_num,member_goods_price,spec_key,spec_key_name')->select();
        foreach($goods as $k=>$v){
            $goods[$k]['img'] = M('goods')->where("goods_id = $v[goods_id]")->getField('original_img');
            $ug = M('user_goods')->where(array('uid'=>$this->user_id,'goods_id'=>$v['goods_id'],'spec_id'=>$v['spec_key']))->field('stock')->find();
            $goods[$k]['stock'] = $ug['stock'];
        }
        $this->assign('goods',$goods);
        $this->assign('order_id',$order_id);
        $this->assign('order_sn',$order_sn);
        $this->assign('goods_id',$goods_id);
        $this->display();
    }
    /**
     * 退换货列表
     */
    public function return_goods_list()
    {
        $count = M('return_goods')->where("user_id = {$this->user_id}")->count();
        $page = new Page($count,100);
        $list = M('return_goods')->where("user_id = {$this->user_id}")->order("id desc")->limit("{$page->firstRow},{$page->listRows}")->select();
        $goods_id_arr = get_arr_column($list, 'goods_id');
        if(!empty($goods_id_arr))
            $goodsList = M('goods')->where("goods_id in (".  implode(',',$goods_id_arr).")")->getField('goods_id,goods_name');
        if($list){
            foreach($list as $key=>$value){
                $list[$key]['order_info']=M('order')->where("order_id = $value[order_id]")->find();
            }
        }
        foreach ($list as $key=>$val){
            $ret = M('order')->where(array('order_id'=>$val['order_id']))->find();
        }
        $this->assign('goodsList', $goodsList);
        $this->assign('list', $list);
        $this->assign('page', $page->show());// 赋值分页输出                    	    	
        if($_GET['is_ajax'])
        {
            $this->display('return_ajax_goods_list');
            exit;
        }
        $this->display();
    }

    /**
     *  退货详情
     */
    public function return_goods_info()
    {
        $id = I('id',0);
        $return_goods = M('return_goods')->where("id = $id")->find();
        if($return_goods['imgs'])
            $return_goods['imgs'] = explode(',', $return_goods['imgs']);
        $goods = M('goods')->where("goods_id = {$return_goods['goods_id']} ")->find();
        $order_info=M('order')->where("order_id = $return_goods[order_id]")->find();
        $this->assign('goods',$goods);
        $this->assign('order_info',$order_info);
        $this->assign('return_goods',$return_goods);
        $this->display();
    }
    /**
     * 下级退换货列表
     */
    public function return_goods_list_down()
    {
        $count = M('return_goods')->where("parent_id = {$this->user_id}")->count();
        $page = new Page($count,4);
        $list = M('return_goods')->where("parent_id = {$this->user_id}")->order("id desc")->limit("{$page->firstRow},{$page->listRows}")->select();
        $goods_id_arr = get_arr_column($list, 'goods_id');
        if(!empty($goods_id_arr))
            $goodsList = M('goods')->where("goods_id in (".  implode(',',$goods_id_arr).")")->getField('goods_id,goods_name');
        if($list){
            foreach($list as $key=>$value){
                $list[$key]['order_info']=M('order')->where("order_id = $value[order_id]")->find();
            }
        }
        $this->assign('goodsList', $goodsList);
        $this->assign('list', $list);
        $this->assign('page', $page->show());// 赋值分页输出
        if($_GET['is_ajax'])
        {
            $this->display('return_ajax_goods_list_down');
            exit;
        }
        $this->display();
    }
    /**
     *  下级退货详情
     */
    public function return_goods_info_down()
    {
        $id = I('id',0);
        if(IS_POST){
            $data['status'] =2;
            $return_goods = M('return_goods')->where("id = $id")->save($data);
            if($return_goods !== false){
                $back['info'] = '退货成功';
                $back['status'] =1;
                $return_goods_info = M('return_goods')->where("id = $id")->find();
                $money =0;
                $goods = json_decode($return_goods_info['goods_info'],true);
                foreach($goods as $val){
                    $money = $val['goods_num']*$val['goods_price'];
                    $res1 = M('user_goods')->where("uid=$this->user_id and goods_id = $val[goods_id]")->setInc('stock',$val['goods_num']);
                }
                $msgLog = new MsgLogic();
                $msgLog->send_msg(4, $return_goods_info['order_sn'],$return_goods_info['user_id']);
                //退款
                $order = M('order')->where("order_id = $return_goods_info[order_id]")->find();
                $data_order['order_status'] = 7;
                $res = M('order')->where("order_id = $return_goods_info[order_id]")->save($data_order);
                $sql_user_child = "update up_users set user_money = user_money + $money  where user_id = $order[user_id]";
                $sql_user_parent = "update up_users set user_money = user_money - $money where user_id = $order[parent_id]";
                $result1 = M('users')->execute($sql_user_child);
                $result2 = M('users')->execute($sql_user_parent);
            }else{
                $back['status'] =0;
                $back['info'] = '退货失败';
            }
            $this->ajaxReturn($back);die;
        }
        $return_goods = M('return_goods')->where("order_id = $id")->find();
        if($return_goods['imgs']) {
            $return_goods['imgs'] = explode(',', $return_goods['imgs']);
        }
        $goods_info = json_decode($return_goods['goods_info'],true);
        $order_goods = M('order_goods')->where("order_id = $id")->select();
        foreach($goods_info as $kk=>$vv){
            foreach($order_goods as $k=>$v){
                if($v['goods_id'] == $vv['goods_id']){
                    $goods = M('goods')->where(array('goods_id'=>$v['goods_id']))->select();
                }
            }
        }
        $order_info=M('order')->where("order_id = $return_goods[order_id]")->find();
        $this->assign('order_info',$order_info);
        $this->assign('goods',$goods);
        $this->assign('return_goods',$return_goods);
        $this->display();
    }
    /**
     *  下级退货详情

    public function return_goods_info_down(){
    $id = I('id',0);
    if(IS_POST){
        $data['status'] =2;
        $return_goods = M('return_goods')->where("id = $id")->save($data);
        if($return_goods !== false){
            $back['info'] = '退货成功';
            $back['status'] =1;
            $return_goods_info = M('return_goods')->where("id = $id")->find();
            $money =0;
            $goods = json_decode($return_goods_info['goods_info'],true);
            foreach($goods as $val){
                $money = $val['goods_num']*$val['goods_price'];
                $res1 = M('user_goods')->where("uid=$this->user_id and goods_id = $val[goods_id]")->setInc('stock',$val['goods_num']);
            }
            $msgLog = new MsgLogic();
            $msgLog->send_msg(4, $return_goods_info['order_sn'],$return_goods_info['user_id']);
            //退款
            $order = M('order')->where("order_id = $return_goods_info[order_id]")->find();
            $data_order['order_status'] = 7;
            $res = M('order')->where("order_id = $return_goods_info[order_id]")->save($data_order);
            //退款
            $up = M('users')->where("user_id = $order[user_id]")->find();
            if($up['u_type'] == 1) {
                mysql_query("BEGIN");
                $sql_user_child = "update up_users set user_money = user_money + $money  where user_id = $order[user_id]";
                $sql_user_parent = "update up_users set user_money = user_money - $money where user_id = $order[parent_id]";
                $result1 = M('users')->execute($sql_user_child);
                $result2 = M('users')->execute($sql_user_parent);
                if($result1 && $result2){
                    mysql_query('COMMIT');
                }else{
                    mysql_query('ROLLBACK');
                }
                mysql_query('END');
            }
            //对信购数据进行修改
            elseif($up['u_type'] == 2){
                //判断上级是否已经绑定信购
                $us = M('users')->where("user_id = $order[parent_id]")->find();
                if($us['u_type'] == 1){
                    mysql_query("BEGIN");
                    $sql_user_child = "update uc_finance set user_money = user_money + $money  where user_id = $order[user_id]";
                    $sql_user_parent = "update up_users set user_money = user_money - $money where user_id = $order[parent_id]";
                    $result1 = M('finance','uc_')->execute($sql_user_child);
                    $result2 = M('users')->execute($sql_user_parent);
                    if($result1 && $result2){
                        mysql_query('COMMIT');
                    }else{
                        mysql_query('ROLLBACK');
                    }
                    mysql_query('END');
                }
                elseif($us['u_type'] == 2) {
                    mysql_query("BEGIN");
                    $sql_user_child = "update up_finance set user_money = user_money + $money  where user_id = $order[user_id]";
                    $sql_user_parent = "update up_finance set user_money = user_money - $money where user_id = $order[parent_id]";
                    $result1 = M('finance', 'uc_')->execute($sql_user_child);
                    $result2 = M('finance', 'uc_')->execute($sql_user_parent);
                    if($result1 && $result2){
                        mysql_query('COMMIT');
                    }else{
                        mysql_query('ROLLBACK');
                    }
                    mysql_query('END');
                }
            }
        }else{
            $back['status'] =0;
            $back['info'] = '退货失败';
        }
        $this->ajaxReturn($back);die;
    }
    $return_goods = M('return_goods')->where("id = $id")->find();
    if($return_goods['imgs'])
        $return_goods['imgs'] = explode(',', $return_goods['imgs']);
    $goods = M('goods')->where("goods_id = {$return_goods['goods_id']} ")->find();
    $order_info=M('order')->where("order_id = $return_goods[order_id]")->find();
    $this->assign('order_info',$order_info);
    $this->assign('goods',$goods);
    $this->assign('return_goods',$return_goods);
    $this->display();
}*/

    /**
     * 解约操作
     * ps  暂时还缺 上级查看解约下级，用户解约状态查询
     */
public function termination(){
        $termination = M('temination');
        if(I('type') =='sure'){
            $logic = new UsersLogic();
            $user_info = $logic->get_info($this->user_id);
            $user = $user_info['result'];
            $is_have = $termination->where("uid = $user[user_id]")->find();
            if($is_have){
                if($is_have['status'] ==0){
                    $status = '管理员正在处理请等待。';
                }elseif($is_have['status'] ==1){
                    $status = '解约成功！';
                }elseif($is_have['status'] ==2){
                    $status = '待定。';
                }
                $back['status'] = 0;
                $back['info'] = '您已申请过了，'.$status;
                $this->ajaxReturn($back);die;
            }
            $reason = trim(I('reason',''));
            if($reason==''){
                $back['status'] = 0;
                $back['info'] = '请输入原因';
                $this->ajaxReturn($back);die;
            }
            $about_order = M('order')->where("parent_id = $user[user_id] and (order_status<2 or order_status=6) ")->select();
            $about_order_my = M('order')->where("user_id = $user[user_id] and (order_status<2 or order_status=6) ")->select();
            if($about_order || $about_order_my){
                $back['status'] = 0;
                $back['info'] = '您有未完成的订单，请先处理';
                $this->ajaxReturn($back);die;
            }
            $cash = M('users')->where("user_id = $user[user_id]")->find();
            if($cash['user_money'] != 0 || $cash['frozen_money'] != 0){
                $back['status'] = 0;
                $back['info'] = '您的资金未清空，请先处理';
                $this->ajaxReturn($back);die;
            }
            $data['uid'] = $user['user_id'];
            $data['parent_id'] = $user['parent_id'];
            $data['create_time'] = time();
            $data['reason'] = $reason;
            $data['mobile'] = $user['mobile'];
            $data['username'] = $user['username'];
            $parent_id=M('users')->where("user_id = $user[user_id]")->field('parent_id')->find();
            if($parent_id['parent_id'] == 1){
                $data['status'] = 1;
            }
            else{
                $user_id = $user['user_id'];
                $data['status']=0;
            }
            $res = $termination->add($data);
            if($res){
                $udata['is_temination'] = 2;
                $udata['is_lock'] = 0;
                M('users')->where("user_id = $user[user_id]")->save($udata);
                if($user['parent_id'] != 1) {
                    $user_id = $user['user_id'];
                    $this->send(7, '', $user_id);
                }
                $back['status'] = 1;
                $back['info'] = '申请成功';
            }else{
                $back['status'] = 0;
                $back['info'] = '申请失败';
            }
            $this->ajaxReturn($back);
        }elseif(I('type') =='agree'){
            $uid = I('uid');
            $data['status'] =1;
            $res = $termination->where("uid =$uid")->save($data);
            if($res !==false){
                $udata['is_temination'] = 3;
                $cdata['parent_id'] = 1;
                M('users')->where("user_id = $uid")->save($udata);
                M('users')->where("parent_id = $uid")->save($cdata);
                $msgLog = new MsgLogic();
                $msgLog->send_msg(6, '',$uid);
                $back['status'] = 1;
                $back['info'] = "操作成功";
            }else{
                $back['status'] =0;
                $back['info'] = "操作失败";
            }
            $this->ajaxReturn($back);
        }elseif(I('type') =='back'){
            $logic = new UsersLogic();
            $user_info = $logic->get_info($this->user_id);
            $user = $user_info['result'];
            $data['is_temination'] = 0;
            M('users')->where('user_id ='.$this->user_id)->save($data);
            $res = $termination->where("uid =$user[user_id]")->delete();
            if($res !==false){
                $msgLog = new MsgLogic();
                $msgLog->send_msg(7, $user['mobile'],$user['parent_id']);
                $back['status'] = 1;
                $back['info'] = "操作成功";
            }else{
                $back['status'] =0;
                $back['info'] = "操作失败";
            }
            $this->ajaxReturn($back);
        }elseif(I('type') =='reback'){
            $uid = I('uid');
            $data['is_temination'] =0;
            $user = M('users')->where("user_id = $uid")->save($data);
            $res = $termination->where("uid =$uid")->delete();
            if($res !==false){
                $msgLog = new MsgLogic();
                $msgLog->send_msg(8, '',$uid);
                $back['status'] = 1;
                $back['info'] = "操作成功";
            }else{
                $back['status'] =0;
                $back['info'] = "操作失败";
            }
            $this->ajaxReturn($back);
        }
    }
    /**
     * 查看待处理解约列表
     * 改变解约状态
     */
    public function termination_list(){
        $logic = new UsersLogic();
        $user_info = $logic->get_info($this->user_id);
        $user = $user_info['result'];
        $termination = M('termination');
        if(IS_POST){
            $uid =I('uid');
            $status = I('status');
            $res = $termination->where("uid = $uid")->save("status = $status");
            $res = M('users')->where("user_id = $uid")->save("status = 1");
            if($res){
                $back['status'] = 1;
                $back['info '] = "操作成功";
            }else{
                $back['status'] =0;
                $back['info'] = "操作失败";
            }
            $this->ajaxReturn($back);
        }else{
            $list = $termination->where("parent_id = $user[uid]")->select();
            $this->assign('list',$list);
            $this->display();
        }

    }
    /**
     * 查看解约状态
     */
    public function get_termination(){
        $uid = I('uid','');
        $termination = M('temination');
        $status = $termination->where("uid = $uid")->field('status,reason')->order('id desc')->limit(1)->select();
        if($status && $status[0][status]<3){
            $back['status'] = 1;
            switch ($status[0]['status']){
                case 0: $back['info']='已提交申请，管理员正在处理！  原因：'.$status[0]['reason'];break;
                case 1: $back['info']='解约成功！';break;
                case 2: $back['info']='已提交申请，管理员处理中！';break;
                case 3: $back['info']='已取消申请';break;
                case 4: $back['info']='已拒绝申请';break;
            }
        }else{
            $back['status'] = 0;
            $back['info '] = "未申请过";
        }

        $this->ajaxReturn($back);
    }
    /**
     * 我的上下级
     */
    public function my_famil(){
        $logic = new UsersLogic();
        $user_info = $logic->get_info($this->user_id);
        $user_info = $user_info['result'];
        $user = M('users');
        if($user_info['parent_id']){
            $parent = $user->where("user_id = $user_info[parent_id]")->field('user_id,nickname,username,mobile,level,head_pic,is_lock,is_temination')->find();
            $parent['level'] = $this->get_level($parent['level']);
        }
        $child = $user->where("parent_id = $user_info[user_id]")->field('user_id,nickname,username,mobile,level,is_lock,head_pic,is_temination')->select();
        foreach ($child as $key=>$value){
            $child[$key]['level'] =$this->get_level($value['level']);
            $ret = M('Temination')->where(array('uid'=>$value['user_id']))->find();
            /*if(!empty($ret)){
                if($ret['status']==0){
                    $child[$key]['jy']='解约申请中';
                }else if($ret['status']==2){
                    $child[$key]['jy']='解约调解中';
                }
            }*/

        }

        $this->assign('parent',$parent);
        $this->assign('child',$child);
        //dump($parent);dump($child);die;
        $this->display();
    }
    public function famil_detail(){
        $type = I('type');
        $uid = I('uid');
        $termination = M('temination')->where("uid = $uid")->find();
        $res = M('users')->where("user_id =$uid")->find();
        $res['level'] = $this->get_level($res['level']);
        if($type==1){
            $logic = new UsersLogic();
            $user_info = $logic->get_info($this->user_id);
            $user_info = $user_info['result'];
            $my_termination = M('temination')->where("uid =$user_info[user_id]")->find();
            $this->assign('my_termination',$my_termination);
            $this->assign('my_id',$user_info['user_id']);
        }
        $this->assign('user',$res);
        $this->assign('type',$type);
        $this->assign('termination',$termination);
        $this->display();
    }
    /**
     * 查看下级代理信息
     */
    public function view_child(){
        $child_id =I('id');
        $res = M('users')->where("user_id =$child_id")->find();
        $this->assign('child',$res);
        $this->display();
    }
    /*
     * 修改密码
     */
    public function change_pwd(){
        if(IS_POST){
            $old_pwd = I('old_pwd');
            $new_pwd = I('new_pwd');
            $new_pwd2 = I('new_pwd2');
            if($old_pwd=='' || $new_pwd=='' || $new_pwd2==''){
                $back['status'] =0;
                $back['info'] = '请输入新信息';
                $this->ajaxReturn($back);die;
            }else{
                $logic = new UsersLogic();
                $user_info = $logic->get_info($this->user_id);
                $user_info = $user_info['result'];
                $user = M('users');
                $res = $user->where("user_id = $user_info[user_id]")->field('password')->find();
                if(md5($old_pwd) ==$res['password']){
                    if($new_pwd != $new_pwd2){
                        $back['status'] =0;
                        $back['info'] = '两次输入密码不一致';
                        $this->ajaxReturn($back);die;
                    }else{
                        $data['password'] = md5($new_pwd);
                        $res1 = $user->where("user_id = $user_info[user_id]")->save($data);
                        if($res1){
                            $back['status'] =1;
                            $back['info'] = '修改成功';
                            session('user',null);
                            $this->ajaxReturn($back);die;
                        }else{
                            $back['status'] =0;
                            $back['info'] = '修改失败';
                            $this->ajaxReturn($back);die;
                        }
                    }
                }else{
                    $back['status'] =0;
                    $back['info'] = '输入密码错误';
                    $this->ajaxReturn($back);die;
                }
            }
        }
        $this->display();
    }
    /*
     * 用户充值提现页面
     */
    public function cash(){
        $logic = new UsersLogic();
        $user_info = $logic->get_info($this->user_id);
        $user_info = $user_info['result'];
        $user = M('users');
        $user_money = $user->where("user_id = $user_info[user_id]")->field('user_money,frozen_money,is_temination')->find();
        $this->assign('user_money',$user_money);
        $this->display();
    }
    /*
     * 用户提现
     */
    public function docash(){
        $logic = new UsersLogic();
        $user_info = $logic->get_info($this->user_id);
        $user_info = $user_info['result'];
        $account = M('user_account')->where("user_id = $user_info[user_id]")->select();
        if(IS_POST){
            $bank = I('bank');
            $money = I('money');
			
            if($bank =='' || $money ==''){
                $back['status'] =0;
                $back['info'] = '请选择提现账户并输入金额';
                $this->ajaxReturn($back);die;
            }else{
                $user_money = M('users')->where("user_id = $user_info[user_id]")->field('user_money')->find();
                $user = M('users')->where("user_id = $user_info[user_id]")->find();
                if($user['u_type'] == 1) {
                    if($user_money['user_money'] < $money){
                        $back['status'] =0;
                        $back['info'] = '用户余额不足';
                        $this->ajaxReturn($back);die;
                    }
                }elseif($user['u_type'] == 2){
                    $back['status'] =0;
                    $back['info'] = '请到信购界面执行提现';
                    $this->ajaxReturn($back);die;
                }
                $model =M();
                $flag =true;
                $data1['user_money'] = $user_info['user_money'] - $money;
				 
                $data1['frozen_money'] = $user_info['frozen_money'] + $money;
                $data2['user_id'] = $user_info['user_id'];
                $data2['user_name'] = $user_info['username'];
                $data2['mobile'] = $user_info['mobile'];
				//echo $user_info['frozen_money'];die;
                foreach($account as $key=>$value){
                    if($value['id']==$bank){
                        $data2['bank'] = $value['account_num'];
                    }
                }
                $data2['money'] = $money;
                $data2['create_time'] = time();
                $model->startTrans();
                $res1 = M('users')->where("user_id = $user_info[user_id]")->save($data1);
                if($res1){
                    $res2 = M('cash')->add($data2);
                    if(!$res2){
                        $flag =false;
                    }
                }else{
                    $flag =false;
                }
                if($flag){
                    $model->commit();
                    $back['status'] =1;
                    $back['info'] = '提现成功，处理中';
                    $this->ajaxReturn($back);die;
                }else{
                    $model->rollback();
                    $back['status'] =0;
                    $back['info'] = '提现失败';
                    $this->ajaxReturn($back);die;
                }
            }
        }
        $this->assign('account',$account);
        $this->assign('user_info',$user_info);
        $this->display();
    }
    /*
     * 用户充值提现列表
    */
    public function cash_list(){
        $logic = new UsersLogic();
        $user_info = $logic->get_info($this->user_id);
        $user_info = $user_info['result'];
        $list = M('cash')->where("user_id=$user_info[user_id] and status <> -1")->order('create_time desc')->select();
        foreach($list as $key=>$value){
            $list[$key]['status_desc'] = $this->get_cash_status($value['status']);
        }
        $this->assign('cash_list',$list);
        $this->display();
    }
    public function get_cash_status($status){
        $return = array(0=>'申请中',1=>'已提现',2=>'商家拒绝提现',-1=>'已过期');
        return $return[$status];
    }
    public function recharge(){
        $this->display();
    }
    //账户列表
    public function account_list(){
        $logic = new UsersLogic();
        $user_info = $logic->get_info($this->user_id);
        $user_info = $user_info['result'];
        $user_account = M('user_account');
        $account = $user_account->where("user_id = $user_info[user_id]")->select();
        $account_default = $user_account->where("user_id = $user_info[user_id] and `default` =1")->getField('id');
        $this->assign('default',$account_default);
        $this->assign('account',$account);
        $this->display();
    }
    //添加账户
    public function account_add(){
        if(IS_POST){
            $data['user_name'] = I('user_name','');
            $data['account_num'] = I('account_num','');
            $data['mobile'] = I('mobile','');
            $data['account_name'] = '支付宝';
            if($data['user_name']==''){
                $back['status'] =0;
                $back['info'] = '请输入用户名';
                $this->ajaxReturn($back);die;
            }
            if($data['account_num']==''){
                $back['status'] =0;
                $back['info'] = '请输入账号';
                $this->ajaxReturn($back);die;
            }
            if($data['mobile'] ==''){
                $back['status'] =0;
                $back['info'] = '请输入电话';
                $this->ajaxReturn($back);die;
            }
            $logic = new UsersLogic();
            $user_info = $logic->get_info($this->user_id);
            $user_info = $user_info['result'];
            $user_account = M('user_account');
            $have_account = $user_account->where("user_id = $user_info[user_id]")->select();
            if(!$have_account){
                $data['default'] =1;
            }else{
                $data['default'] =0;
            }
            $data['user_id'] = $user_info['user_id'];
            $res = $user_account->add($data);
            if($res){
                $back['status'] =1;
                $back['info'] = '添加成功';
                $this->ajaxReturn($back);die;
            }else{
                $back['status'] =0;
                $back['info'] = '添加失败';
                $this->ajaxReturn($back);die;
            }
        }
        $article = M('article')->find(6);
        $article['content'] = htmlspecialchars_decode($article['content']);
        $this->assign('article',$article);
        $this->display();
    }
    //修改账户状态、删除账户
    public function change_account_status(){
        $type = I('type');
        $id = I('id');
        $user_account = M('user_account');

        if($type==1){ //删除
            $res = $user_account->where("id=$id")->delete();
            if($res){
                $back['status'] =1;
                $back['info'] = '删除成功';
                $this->ajaxReturn($back);die;
            }else{
                $back['status'] =0;
                $back['info'] = '删除失败';
                $this->ajaxReturn($back);die;
            }
        }elseif($type==2){//默认
            $logic = new UsersLogic();
            $user_info = $logic->get_info($this->user_id);
            $user_info = $user_info['result'];
            $data['default'] =0;
            $data1['default'] =1;
            $user_account = M('user_account');
            $res = $user_account->where("user_id = $user_info[user_id]")->save($data);
            $res1 = $user_account->where("id=$id")->save($data1);
            if(($res !==false) && ($res1 !==false)){
                $back['status'] =1;
                $back['info'] = '设置成功';
                $this->ajaxReturn($back);die;
            }else{
                $back['status'] =1;
                $back['info'] = '设置失败';
                $this->ajaxReturn($back);die;
            }
        }

    }
    /**
     * 会员升级
     */
    public function add_level(){
        $logic = new UsersLogic();
        $user_info = $logic->get_info($this->user_id);
        $user_info = $user_info['result'];
        if($user_info['level']==2){
            $level_list='';
        }else{
            $level_list = M('user_level')->where("level_id <>0 and level_id>$user_info[level]")->select();
        }
        $this->assign('level_list',$level_list);
        $this->display();
    }
    /**
     * 获取等级
     */
    public function get_level($level){
        $level_array = array(1=>'公司',2=>'特约',3=>'微一',4=>'微二',5=>'微三');
        return $level_array[$level];
    }
    /**
     * 获取订单状态
     */
    public function get_order_status($order_status){
        $order_status_array = array(1=>'待付款',2=>'待发货',3=>'待收货',4=>'已完成');
        return $order_status_array[$order_status];
    }
}