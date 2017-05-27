<?php
namespace Mobile\Controller;
use Api\Logic\GoodsLogic;
use Think\Page;
class CartController extends PublicController {
    
    public $cartLogic; // 购物车逻辑操作类
    /**
     * 析构流函数
     */
    public function  __construct() {   
        parent::__construct();       
        $this->cartLogic = new \Home\Logic\CartLogic();
        $user = session('user');
        
       
        // 给用户计算会员价 登录前后不一样  
    }
    public function cart(){
        $spec = D('SpecGoodsPrice');
        $user = session('user');
        if(empty($user)){
           header("Location:".U('user/login'));
        }
        $usergoodsMod = D('UserGoods');
        $carList = $this->cartLogic->cartList($user);
        $count = 0;
        $goods_count = 0;
        foreach ($carList as $key=>$val){
            $ret = $spec->where(array('goods_id'=>$val['goods_id']))->count();
            $rspec = $spec->where(array('goods_id'=>$val['goods_id'],'key'=>$val['spec_key']))->order('price1 asc')->find(); 
            if(empty($rspec)){
                unset($carList[$key]);
            }else{       
                $goodinfo = D('goods')->find($val['goods_id']);

                $carList[$key]['spec'] = $ret;
                $carList[$key]['original_img'] = $goodinfo['original_img'];
                $carList[$key]['resp'] = $rspec['key'];
                $carList[$key]['key_name'] = $rspec['key_name'];
                $count += $val['goods_num']*$val['member_goods_price'];
                $goods_count+=$val['goods_num'];
                $map = array(
                    'uid'=>$user['parent_id'],
                    'goods_id'=>$val['goods_id'],
                    'spec_id'=>$rspec['key']
                );
                $arr = $usergoodsMod->where($map)->find();
                $carList[$key]['store'] = $arr['stock'];
            }
        }
        $this->assign('priceCount',$count);
        $this->assign('goods_count',$goods_count);
        $this->assign('cartList',$carList);
        $this->display('mycart');
    }
    /**
     * 将商品加入购物车
     */
    function addCart()
    {
        if(empty(session('user'))){
            $this->ajaxReturn(array('status'=>0,'msg'=>'请先登录'));
        }
        $goods_id = I("goods_id"); // 商品id
        $goods_num = I("goods_num");// 商品数量
        $goods_spec = I("goods_spec"); // 商品规格    
        $maps =array(
                'goods_id'=>$goods_id,
                'uid'=>$this->user['parent_id'],
                'spec_id'=>$goods_spec
        );
        $tmp = M('UserGoods')->where($maps)->find();
        if($tmp['stock']<$goods_num){
            exit(json_encode(array('status'=>3,'msg'=>'上级商品数量不足','word'=>$tmp)));
        }
        $result = $this->cartLogic->addCart($goods_id, $goods_num, $goods_spec); // 将商品加入购物车
        $cart_result = $this->cartLogic->cartList($this->user, 0,1);
        $number = 0;
        foreach ($cart_result as $key=>$val){
           $number+=$val['goods_num'];
        }
        $result['countCartGoods'] = $number;
        exit(json_encode($result)); 
    }
    
    function remove_cart(){
        $cart_id = I('id');
        $cartMod = M('cart');
        $result = $cartMod->where(array('id'=>$cart_id))->delete();
        $this->ajaxReturn(array('status'=>$result));
    }
    
    public function sure_buy(){
       $cart = I('is_cart');
        $parent = M('users')->where('user_id = '.$this->user['parent_id'])->field('is_temination')->find();
        if($this->user['is_lock']==1){
            $this->success('您尚未缴纳保证金',U('user/pay_order')."?type=3",1);
            exit();
        }elseif($this->user['is_lock']==2){
            $this->success('未通过审核',U('user/index'),1);
            exit();
        }elseif ($this->user['is_lock']==3){
            $this->success('后台未审核',U('user/index'),1);
            exit();
        }elseif($this->user['is_lock']==4){
            $this->success('上级未审核',U('user/index'),1);
            exit();
        }
        elseif($this->user['is_temination']==1){
            $this->success('抱歉，已解约用户无法购买商品',U('user/index'),1);
            exit();
        }
        elseif($this->user['is_temination']==2 || $this->user['is_temination']==3){
            $this->success('您已提出解约申请，无法购买商品',U('user/index'),1);
            exit();
        }elseif($parent['is_temination']==2 || $parent['is_temination']==3 ){
            $this->success('您的上级正在解约中，无法购买商品',U('user/index'),1);
            exit();
        }
    	if(1){
    	    $key  = I('key');
    	    if(!empty($key)){

    	        $_POST = unserialize(base64_decode($key));

    	    }
    		$buy_type = I('post.buy_type');
    		$address_lists = get_user_address_list($this->user_id);
    		
    		if(empty($address_lists)){
    		    $key = I();
    		    $request = serialize($key);
    		    $result = base64_encode($request);
    		    $this->success('您未设置收货地址',U('User/add_address')."?key=".$result,false,'设置收货地址');
    		    return;
    		}
    	    $region_list = M('region');
            foreach ($address_lists as $key=>$val){
	        	$province =  $region_list->where(array('id'=>$val['province']))->find();
	            $address_lists[$key]['province'] =$province['name'];
	            $city = $region_list->where(array('id'=>$val['city']))->find();
	            $address_lists[$key]['city']=$city['name'];
	            $district = $region_list->where(array('id'=>$val['district']))->find();
	            $address_lists[$key]['district'] = $district['name'];
	            $address_lists[$key]['re_address'] =$address_lists[$key]['province'].$address_lists[$key]['city'].$address_lists[$key]['district'].$address_lists[$key]['address'];
           		if($val['is_default']==1){
           			$address = $address_lists[$key];
           			$this->assign('address',$address);
           		}
            }
            /* $address_lists[1] = $address_lists[0];
            $address_lists[1]['address_id'] = 33;
            $address_lists[1]['is_default'] = 0; */
            $this->assign('addressList',$address_lists);
          
       //     $this->assign('add',$address);
    		if($buy_type==1){
    			$goods_id = I('post.goods_id');
    			$goods_num = I('post.goods_num');
    			$goods_spec = I('post.goods_spec');
    			$result = D('UserGoods')->get_goods($this->user['user_id'],$this->user['parent_id'],$goods_id);
    			$turn = M('SpecGoodsPrice')->where(array('key'=>$goods_spec,'goods_id'=>$goods_id))->find();
    			$result[0]['price'] = $turn['price'.$this->user['level']];
    			$result[0]['specname']  = explode(':', $turn['key_name']);
    			$result[0]['specname'] =$result[0]['specname'][1];
    			$result[0]['spec_key'] = $goods_spec;
    			$result[0]['number'] = $goods_num;
    			$result[0]['goods_id'] = $result[0]['goodsid'];
    			$count= $goods_num*$result[0]['price'];
    			$this->assign('count',$count);
    		}else if($buy_type==2){
    		    $tmp = $this->cartLogic->cartList(session('user')); // 获取购物车商品
    		   
    		    $return = array();
    		    $count = 0;
    		    foreach ($tmp as $key=>$val){
    		        $maps = array(
    		              'uid'=>$this->user['parent_id'],
    		              'spec_id'=>$val['spec_key'],
    		              'goods_id'=>$val['goods_id']
    		        );
    		        $userGoods = M('UserGoods')->where($maps)->find();
    		      
    		        if($val['goods_num']>$userGoods['stock']){
    		            $this->success('商品数量不足',U('index/index'),1);exit();
    		        }
    		        $result = D('UserGoods')->get_goods($this->user['user_id'],$this->user['parent_id'],$val['goods_id']);
    		        $turn = M('SpecGoodsPrice')->where(array('key'=>$val['spec_key'],'goods_id'=>$val['goods_id']))->find();
    		        $return[$key] =$result[0];
    		        $return[$key]['price'] = $turn['price'.$this->user['level']];
    		        $return[$key]['specname']=explode(':', $turn['key_name']);
    		        $return[$key]['specname'] =$return[$key]['specname'][1];
    		        $return[$key]['spec_key'] = $val['spec_key'];
    		        $return[$key]['goods_id'] = $val['goods_id'];
    		        $return[$key]['number'] =  $val['goods_num'];
    		        $count+= $val['goods_num']*$return[$key]['price'];
    		    };
    		    $this->assign('count',$count);
    		    $result = $return;
    		}else if($buy_type==3){
    		    $tmp = M('OrderGoods')->where('order_id='.I('order_id'))->select();
    		    $return = array();
    		    $count = 0;
    		    foreach ($tmp as $key=>$val){
    		        $result = D('UserGoods')->get_goods($this->user['user_id'],$this->user['parent_id'],$val['goods_id']);
    		        $turn = M('SpecGoodsPrice')->where(array('key'=>$val['spec_key'],'goods_id'=>$val['goods_id']))->find();
                    $return[$key] =$result[0];
    		        $return[$key]['price'] = $turn['price'.$this->user['level']];
    		        $return[$key]['specname']=explode(':', $turn['key_name']);
    		        $return[$key]['specname'] =$return[$key]['specname'][1];
    		        $return[$key]['spec_key'] = $val['spec_key'];
    		        $return[$key]['goods_id'] = $val['goods_id'];
    		        $return[$key]['number'] =  $val['goods_num'];
    		        $count+= $val['goods_num']*$return[$key]['price'];
    		    };
    		    $this->assign('count',$count);
    		    $result = $return;
    		}
            foreach($result as $k=>$v){
                $stock = M('user_goods')->where(array('uid'=>$this->user['parent_id'],'spec_id'=>$v['spec_key'],'goods_id'=>$v['goods_id']))->find();
                $result[$k]['stock'] = $stock['stock'];
            }
    		if($this->user['is_first']==1){
    		    $firstBuyMoney = M('UserLevel')->find($this->user['level']);
    		    $fmoney = $firstBuyMoney['discount'];
    		    if($fmoney>$count){
    		        $this->success("{$firstBuyMoney['level_name']}首次下单必须满{$fmoney}元。");
    		        exit();
    		    }
    		   
    		}
            $this->assign('cart',$cart);
    		$this->assign('goodsList',$result);
//            print_r($result);exit;
    		$this->display();
    	}
    }
    
    public function bulid_order(){
        $is_cart = I('is_cart');
    	$address= I('address_id');
    	$goodsList= I('goods_info');
        $region_list = M('UserAddress');
        $order = M('Order');
        $addressInfo = $region_list->where(array('address_id'=>$address))->find();
        if(empty($addressInfo)){
            $addressInfo = $region_list->where(array('user_id'=>$this->user_id))->find();
            $region_list->where(array('address_id'=>$addressInfo['address_id']))->save(array('is_default'=>1));
        }
    	$where = array(
//    		'order_sn'=>date('YmdHis').$this->user_id,
            'order_sn'=>date('ymdHis') . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT),
    		'user_id'=>$this->user_id,
    	    'country'=>1,
    		'consignee'=>$addressInfo['consignee'],
    		'province'=>$addressInfo['province'],
    		'city'=>$addressInfo['city'],
    		'address'=>$addressInfo['address'],
    		'zipcode'=>$addressInfo['zipcode'],
    		'mobile'=>$addressInfo['mobile'],
    		'pay_code'=>md5(time().$this->user_id),
    		'pay_name'=>'',    
    		'coupon_price'=>I('count'),
    		'order_amount'=>I('count'),
    		'total_amount'=>I('count'),
    		'add_time'=>time(),
    		'user_note'=>I('mark'),
    		'parent_id'=>$this->user['parent_id']
    	);
    	$goodsInfo = D('UserGoods');
    	$orderGoods = D('OrderGoods');
    	$orderAction = D('OrderAction');
    	    $user = session('user');
    	    $cart = $carList = $this->cartLogic->cartList($user);
    	  
    		$order_id = $order->add($where);
        if($is_cart == "is_cart") {
            foreach ($cart as $k => $v) {
                $result = M('cart')->where(array('id' => $v['id']))->delete();

            }
        }
    	
    		if(!$order_id){
    			return ;
    		}
    		
    		foreach ($goodsList as $key=>$val){
    			$goods_id =explode('/', $val);
    			$goods = $goodsInfo->get_goods($this->user['user_id'],$this->user['parent_id'],$goods_id[0]);
    			$turn = M('SpecGoodsPrice')->where(array('key'=>$goods_id[1],'goods_id'=>$goods_id[0]))->find();
    			$spec_key_name =explode(':',$turn['key_name']);
    			$goods_where = array(
    				'order_id'=>$order_id,
    				'goods_id'=>$goods_id[0],
    				'goods_name'=>$goods[0]['goods_name'],
    				'goods_num'=>$goods_id[2],
    				'spec_key'=>$goods_id[1],
    				'spec_key_name'=>$spec_key_name[1],
    				'is_send'=>0,
    				'member_goods_price'=>$turn['price'.$this->user['level']],
    			);
                $rest[] = $orderGoods->add($goods_where);
    		}
    		$action_where = array(
    				'order_id'=>$order_id,
    				'action_user'=>$this->user_id,
    				'order_status'=>0,
    				'action_note'=>"商品下单",
    				'log_time'=>time(),
    				'status_desc'=>'下单操作完成',
    		);
    		 
    		$act = $orderAction->add($action_where);
    		header("Location:".U('user/pay_order')."?type=2&order_id=".$order_id);	
    
    }
    /**
     * ajax 将商品加入购物车
     */
   /*  function ajaxAddCart()
    {
        $goods_id = I("goods_id"); // 商品id
        $goods_num = I("goods_num");// 商品数量
        $goods_spec = I("goods_spec"); // 商品规格
        $result = $this->cartLogic->addCart($goods_id, $goods_num, $goods_spec,$this->session_id,$this->user_id); // 将商品加入购物车
        exit(json_encode($result));
    } */

    /*
     * 请求获取购物车列表
     */
    public function cartList()
    {
        $cart_form_data = $_POST["cart_form_data"]; // goods_num 购物车商品数量
        $cart_form_data = json_decode($cart_form_data,true); //app 端 json 形式传输过来

        $unique_id = I("unique_id"); // 唯一id  类似于 pc 端的session id
        $user_id = I("user_id"); // 用户id
        $where = " session_id = '$unique_id' "; // 默认按照 $unique_id 查询
        $user_id && $where = " user_id = ".$user_id; // 如果这个用户已经等了则按照用户id查询
        $cartList = M('Cart')->where($where)->getField("id,goods_num,selected");

        if($cart_form_data)
        {
            // 修改购物车数量 和勾选状态
            foreach($cart_form_data as $key => $val)
            {
                $data['goods_num'] = $val['goodsNum'];
                $data['selected'] = $val['selected'];
                $cartID = $val['cartID'];
                if(($cartList[$cartID]['goods_num'] != $data['goods_num']) || ($cartList[$cartID]['selected'] != $data['selected']))
                    M('Cart')->where("id = $cartID")->save($data);
            }
            //$this->assign('select_all', $_POST['select_all']); // 全选框
        }

        $result = $this->cartLogic->cartList($this->user, $unique_id,0);
        exit(json_encode($result));
    }
    
    /**
     * 购物车第二步确定页面
     */
    public function cart2()
    {

        if($this->user_id == 0)
            $this->error('请先登陆',U('Mobile/User/login'));
        $address_id = I('address_id');
        if($address_id)
            $address = M('user_address')->where("address_id = $address_id")->find();
        else
            $address = M('user_address')->where("user_id = $this->user_id and is_default=1")->find();
        if(empty($address)){
        	header("Location: ".U('Mobile/User/add_address',array('source'=>'cart2')));
        }else{
        	$this->assign('address',$address);
        }

           

        $result = $this->cartLogic->cartList(session('user')); // 获取购物车商品
        if(empty($result)){
            $this->error ('你的购物车没有选中商品','Cart/cart');
        }     
        $this->assign('cartList', $result); // 购物车的商品
      
        $this->display();
    }

    /**
     * ajax 获取订单商品价格 或者提交 订单
     */
    public function cart3(){
                                
        if($this->user_id == 0)
            exit(json_encode(array('status'=>-100,'msg'=>"登录超时请重新登录!",'result'=>null))); // 返回结果状态
        
        $address_id = I("address_id"); //  收货地址id
        $shipping_code =  I("shipping_code"); //  物流编号        
        $invoice_title = I('invoice_title'); // 发票
        $couponTypeSelect =  I("couponTypeSelect"); //  优惠券类型  1 下拉框选择优惠券 2 输入框输入优惠券代码
        $coupon_id =  I("coupon_id"); //  优惠券id
        $couponCode =  I("couponCode"); //  优惠券代码
        $pay_points =  I("pay_points",0); //  使用积分
        $user_money =  I("user_money",0); //  使用余额        
        $user_money = $user_money ? $user_money : 0;

        if($this->cartLogic->cart_count($this->user_id,1) == 0 ) exit(json_encode(array('status'=>-2,'msg'=>'你的购物车没有选中商品','result'=>null))); // 返回结果状态
        if(!$address_id) exit(json_encode(array('status'=>-3,'msg'=>'请先填写收货人信息','result'=>null))); // 返回结果状态
        if(!$shipping_code) exit(json_encode(array('status'=>-4,'msg'=>'请选择物流信息','result'=>null))); // 返回结果状态
		
		$address = M('UserAddress')->where("address_id = $address_id")->find();
		$order_goods = M('cart')->where("user_id = {$this->user_id} and selected = 1")->select();
        $result = calculate_price($this->user_id,$order_goods,$shipping_code,0,$address[province],$address[city],$address[district],$pay_points,$user_money,$coupon_id,$couponCode);
                
		if($result['status'] < 0)	
			exit(json_encode($result));      	
	// 订单满额优惠活动		                
        $order_prom = get_order_promotion($result['result']['order_amount']);
        $result['result']['order_amount'] = $order_prom['order_amount'] ;
        $result['result']['order_prom_id'] = $order_prom['order_prom_id'] ;
        $result['result']['order_prom_amount'] = $order_prom['order_prom_amount'] ;
			
        $car_price = array(
            'postFee'      => $result['result']['shipping_price'], // 物流费
            'couponFee'    => $result['result']['coupon_price'], // 优惠券            
            'balance'      => $result['result']['user_money'], // 使用用户余额
            'pointsFee'    => $result['result']['integral_money'], // 积分支付
            'payables'     => $result['result']['order_amount'], // 应付金额
            'goodsFee'     => $result['result']['goods_price'],// 商品价格
            'order_prom_id' => $result['result']['order_prom_id'], // 订单优惠活动id
            'order_prom_amount' => $result['result']['order_prom_amount'], // 订单优惠活动优惠了多少钱            
        );
       
        // 提交订单        
        if($_REQUEST['act'] == 'submit_order')
        {            
            $result = $this->cartLogic->addOrder($this->user_id,$address_id,$shipping_code,$invoice_title,$coupon_id,$car_price); // 添加订单                        
            exit(json_encode($result));            
        }
            $return_arr = array('status'=>1,'msg'=>'计算成功','result'=>$car_price); // 返回结果状态
            exit(json_encode($return_arr));           
    }	
    /*
     * 订单支付页面
     */
    public function cart4(){

        $order_id = I('order_id');
        $order = M('Order')->where("order_id = $order_id")->find();
        // 如果已经支付过的订单直接到订单详情页面. 不再进入支付页面
        if($order['pay_status'] == 1){
            $order_detail_url = U("Mobile/User/order_detail",array('id'=>$order_id));
            header("Location: $order_detail_url");
        }

        $paymentList = M('Plugin')->where("`type`='payment' and status = 1 and  scene in(0,1)")->select();        
        //微信浏览器
        if(strstr($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')){
            $paymentList = M('Plugin')->where("`type`='payment' and status = 1 and code in('weixin','cod')")->select();            
        }        
        $paymentList = convert_arr_key($paymentList, 'code');

        foreach($paymentList as $key => $val)
        {
            $val['config_value'] = unserialize($val['config_value']);
            if($val['config_value']['is_bank'] == 2)
            {
                $bankCodeList[$val['code']] = unserialize($val['bank_code']);
            }
        }

        $bank_img = include 'Application/Home/Conf/bank.php'; // 银行对应图片
        $payment = M('Plugin')->where("`type`='payment' and status = 1")->select();
        $this->assign('paymentList',$paymentList);
        $this->assign('bank_img',$bank_img);
        $this->assign('order',$order);
        $this->assign('bankCodeList',$bankCodeList);
        $this->assign('pay_date',date('Y-m-d', strtotime("+1 day")));
        $this->display();
    }


    /*
    * ajax 请求获取购物车列表
    */
    public function ajaxCartList()
    {
        $post_goods_num = I("goods_num"); // goods_num 购物车商品数量
        $post_cart_select = I("cart_select"); // 购物车选中状态
        $where = " session_id = '$this->session_id' "; // 默认按照 session_id 查询
        $this->user_id && $where = " user_id = ".$this->user_id; // 如果这个用户已经等了则按照用户id查询

        $cartList = M('Cart')->where($where)->getField("id,goods_num,selected");

        if($post_goods_num)
        {
            // 修改购物车数量 和勾选状态
            foreach($post_goods_num as $key => $val)
            {
                $data['goods_num'] = $val;
                $data['selected'] = $post_cart_select[$key] ? 1 : 0 ;
                if(($cartList[$key]['goods_num'] != $data['goods_num']) || ($cartList[$key]['selected'] != $data['selected']))
                    M('Cart')->where("id = $key")->save($data);
            }
            $this->assign('select_all', $_POST['select_all']); // 全选框
        }


        $result = $this->cartLogic->cartList($this->user, $this->session_id,0,1);
        $result_select = $this->cartLogic->cartList($this->user, $this->session_id,1,1); // 选中的商品        
        if(empty($result_select['total_price']))
            $result_select['total_price'] = Array( 'total_fee' =>0, 'cut_fee' =>0, 'num' => 0, 'atotal_fee' =>0, 'acut_fee' =>0, 'anum' => 0);
        $this->assign('cartList', $result['cartList']); // 购物车的商品                
        $this->assign('total_price', $result_select['total_price']); // 总计       
        $this->display('ajax_cart_list');
    }

    /*
 * ajax 获取用户收货地址 用于购物车确认订单页面
 */
    public function ajaxAddress(){

        $regionList = M('Region')->getField('id,name');

        $address_list = M('UserAddress')->where("user_id = {$this->user_id}")->select();
        $c = M('UserAddress')->where("user_id = {$this->user_id} and is_default = 1")->count(); // 看看有没默认收货地址
        if((count($address_list) > 0) && ($c == 0)) // 如果没有设置默认收货地址, 则第一条设置为默认收货地址
            $address_list[0]['is_default'] = 1;

        $this->assign('regionList', $regionList);
        $this->assign('address_list', $address_list);
        $this->display('ajax_address');
    }

    /**
     * ajax 删除购物车的商品
     */
    public function ajaxDelCart()
    {
        $ids = I("ids"); // 商品 ids
        $result = M("Cart")->where(" id in ($ids)")->delete(); // 删除id为5的用户数据
        $return_arr = array('status'=>1,'msg'=>'删除成功','result'=>''); // 返回结果状态
        exit(json_encode($return_arr));
    }
}
