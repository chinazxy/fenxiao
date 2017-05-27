<?php
namespace Mobile\Controller;
use Mobile\Logic\UsersLogic;

class IndexController extends PublicController {
    protected $pagesize =6;
    public function index(){
        //获取信购post的唯一标识值
        $fileContent = file_get_contents("php://input");
        if($fileContent){
            $login = new UsersLogic();
            $only = '1';
            $username ='';
            $password = '';
            $res = $login->login($username,$password,$only);
            if($res['status'] == 1) {
                session('user', $res['result']);
                session('user_id', $res['result']['user_id']);
                $nickname = empty($res['result']['nickname']) ? $username : $res['result']['nickname'];
                setcookie('uname', $nickname, null, '/');
                $cartLogic = new \Home\Logic\CartLogic();
                $cartLogic->login_cart_handle($this->session_id, $res['result']['user_id']);//用户登录后 需要对购物车 一些操作
                $upUser = M('users')->where('user_id = ' . $_SESSION['user_id'])->find();
            }
        }
        $list = M('ArticleCat')->where("cat_alias='new'")->find();
        $this->assign('list',$list);
        $aticle = M('Article')->where(array('cat_id'=>$list['cat_id'],'is_open'=>1))->order('publish_time desc')->limit(2)->select();
        $this->assign('article',$aticle);
        foreach ($aticle as $key=>$val){
            $aticle[$key]['content'] = htmlspecialchars_decode($val['content']);
        }
        $this->assign('article',$aticle);
    	$user = $this->user;
    	$goods = D('UserGoods');
    	//$goods_list = $goods->get_goods(1,0);
        clear_cart();
        $hot_goods = $goods->get_goods($user['user_id'],$user['parent_id'],'','','','is_hot','','goods_id DESC',"0,$this->pagesize");
        $hot_goods_all = $goods->get_goods($user['user_id'],$user['parent_id'],'','','','is_hot','','goods_id DESC');

        $thems = M('Brand')->where(array('is_hot'=>1))->order('sort')->select();
        $spec = D('SpecGoodsPrice');
        foreach ($hot_goods as $key=>$val){
            $ret = $spec->where(array('goods_id'=>$val['goodsid']))->count();
            $hot_goods[$key]['goods_id'] = $val['goodsid'];

            $rspec = $spec->where(array('goods_id'=>$val['goodsid']))->order('price1 asc')->find();
            if(!empty($user)){
                $hot_goods[$key]['price'] = $rspec['price'.$user['level']];
            }else{
                $hot_goods[$key]['price'] = $rspec['price'];
            }
            if(empty($ret)||empty($rspec)){
                $ret = 0;
                $rspec[key]=0;
            }
            $hot_goods[$key]['spec'] = $ret;
            $hot_goods[$key]['resp'] = $rspec['key'];
        }
        $this->assign('count',count($hot_goods_all));
        $this->assign('thems',$thems);
        $this->assign('hot_goods',$hot_goods);
        $this->display('index');
        //$this->display('index1');
    }


    /**
     * 加载更多热销产品
     */
    public function more_hot(){
        $user = $this->user;
        $page = I('page');
        if(is_numeric($page)){
            $limit = $page*$this->pagesize.",".$this->pagesize;
            $hot_goods = D('UserGoods')->get_goods($user['user_id'],$user['parent_id'],'','','','is_hot','','goods_id DESC',$limit);
            $thems = M('Brand')->order('sort')->limit(4)->select();
            $spec = D('SpecGoodsPrice');
            foreach ($hot_goods as $key=>$val){
                $hot_goods[$key]['goods_id'] = $val['goodsid'];
                $ret = $spec->where(array('goods_id'=>$val['goods_id']))->count();
                $rspec = $spec->where(array('goods_id'=>$val['goods_id']))->order('price1 asc')->find();
                if(empty($ret)||empty($rspec)){
                    $ret = 0;
                    $rspec[key]=0;
                }
                $hot_goods[$key]['spec'] = $ret;
                $hot_goods[$key]['resp'] = $rspec['key'];
            }
            if(!empty($hot_goods)){
                $this->ajaxReturn(array('status'=>1000,'data'=>$hot_goods));
            }else{
                $this->ajaxReturn(array('status'=>1001,'data'=>'没有更多了'));
            }
        }
        $this->ajaxReturn(array('status'=>1001,'data'=>'请求更多的参数错误'));

    }
    
    public function qualification(){
        $this->display();
    }
    
    public function user_book(){
        $user = M('users')->find(I('user_id'));
        $user['level'] = get_level($user['level'] );
        $account =  M('user_account')->where("user_id =".$user['user_id'])->find();
        if(!empty($account)){
            $user['account'] = $account['account_num'];
        }else{
            $user['account'] = '';
        }
        $this->assign('user',$user);
        
        $this->display();
    }

    /**
     * 商品列表页
     */
    public function goodsList(){
        $goodsLogic = new \Home\Logic\GoodsLogic(); // 前台商品操作逻辑类
        $id = I('get.id',0); // 当前分类id
        //$lists = getCatGrandson($id);
        $user = $this->user;
        $goods = D('UserGoods');
        $lists = $goods->get_goods($user['user_id'],$user['parent_id'],'',$id);
        $this->assign('lists',$lists);
        $this->display();
    }
    
    public function ajaxGetMore(){
    	$p = I('p',1);
    	$limit_down = $p*10;
    	$limit_up = ($p+1)*10;
    	//$favourite_goods = M('goods')->where("is_recommend=1 and is_on_sale=1")->order('goods_id DESC')->page($p,10)->select();//首页当前列表
    	$user = $this->user;
    	$goods = D('UserGoods');
    	$limit = "$limit_down,$limit_up";
    	$favourite_goods = $goods->get_goods($user['user_id'],$user['parent_id'],$goods_id='',$cat_id='',$brand_id='',$is_what='',$keyword='',$sort='sort',$limit='');
    	$this->assign('favourite_goods',$favourite_goods);
    	$this->display();
    }
	public function forget(){
		$mobile = $_POST['mobile'];
		$result = M('users')->where(array('mobile'=>$mobile))->find();
        if($result){
			echo json_encode(array('status'=>1002,'msg'=>'success')) ;
        }else{
			echo json_encode(array('status'=>1003,'msg'=>'error')) ;
		}
	}
    /*系统总库存接口*/
    public function GoodsApi(){
        $list = M('UserGoods')->where('uid=1')->join('up_goods ON up_goods.goods_id = up_user_goods.goods_id')->join('up_spec_goods_price ON up_spec_goods_price.goods_id = up_user_goods.goods_id')->select();
        foreach ($list as $key=>$val){
            $cate = M('GoodsCategory')->find($val['cat_id']);
            $list[$key]['cate_name'] = $cate['name'];
        }
        echo json_encode($list);
    }
    //合并信息
    public function do_copy(){
        $where['user_id'] = $where1['uid'] = $_SESSION['user_id'];
        $user = M('users');
        $user_goods = M('user_goods');
        $data = $user->where($where)->select();
        $data1 = $user_goods->join('RIGHT JOIN up_goods ON up_user_goods.goods_id = up_goods.goods_id')->where($where1)->select();
        $this->assign('data',$data);
        $this->assign('data1',$data1);
        $this->display();
    }
    //执行合并
    public function copy(){
        $where['user_id'] = $_SESSION['user_id'];
        $upUser = M('users')->where($where)->find();
        $ucUser = M('users','uc_')->where('certificate_no = '.$upUser['certificate_no'])->find();
        $uc_finance = M('finance','uc_');
        $account_log = M('account_log');
        $only = md5(md5(rand().time()));
        $account = array();
        if($account_log['desc']=='余额支付订单'){
            $account['u_log_type'] == '3';
        } elseif($account_log['desc']=='确认收货金额'){
            $account['u_log_type'] == '1';
        }elseif($account_log['desc']=='退货退款到余额'){
            $account['u_log_type'] == '9';
        }
        $log = array(
            'u_id' => $ucUser['u_id'],
            'f_logs_memo' =>$account_log['desc'],
            'f_logs_type'=>$account['type'],
            'f_logs_datetime'=>$account_log['change_time'],
            'f_logs_num'=>abs($account_log['user_money']),
            'user_id'=>$account_log['user_id']
        );
        mysql_query("BEGIN");
        $sql1 = "Update uc_users set user_id = '{$upUser[user_id]}',u_type = 3,only = '{$only},mobile = '{$upUser[mobile]}' where u_id = $ucUser[u_id]";
        $sql2 = "Update uc_finance set f_money = $uc_finance[f_money]+$upUser[user_money],pledge_money = $upUser[pledge_money],frozen_money = $upUser[frozen_money],user_id = $upUser[user_id] where u_id = $ucUser[u_id]";
        $ucsql1 = M('users','uc_')->execute($sql1);
        $ucsql2 = M('finance','uc_')->execute($sql2);
        $ucsql3 = M('finance_logs','uc_')->add($log);
        if($ucsql1 && $ucsql2 && $ucsql3){
            mysql_query("COMMIT");
        }else{
            mysql_query("ROLLBACK");
        }
        mysql_query("END");
        //将分销用户表数据备注为已合并的用户
        $upsql1 = "Update up_users set u_type = 2,only = '{$only}',user_money = 0,pledge_money = 0,frozen_money = 0 where user_id='{$where['user_id']}'";
        $upUser->where($where)->execute($upsql1);
        header('Location:'.U('index'));
    }
}