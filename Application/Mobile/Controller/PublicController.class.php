<?php
namespace Mobile\Controller;
use Think\Controller;
use Think\Template\Driver\Mobile;
use Home\Logic\UsersLogic;
use Home\Logic\CartLogic;

class PublicController extends MobileBaseController{
    public function _initialize() {
    	parent::_initialize();
    	if (empty($this->user_id)){
    	    /*    $logic = new UsersLogic();
    	       $res = $logic->login('13459213269','123456');
    	       session('user',$res['result']);
    	       session('user_id',$res['result']['user_id']);
    		   header("location:".U('Mobile/User/login'));
    	       header("location:".U('Mobile/index/index'));
    		   exit(); */
    	    $this->assign('is_login',0);
    	}else{
    	    $this->assign('user',session('user'));
    	    $this->assign('is_login',1);
    	}
    /* 	$user=session('user');
    	if($user['is_lock']==1){
    		header("location:".U('Mobile/User/index'));
    	}
    	$carLogic = new CartLogic();
    	$carList = $carLogic->cartList($user);
    	$goods_nums = 0;
    	foreach ($carList as $key=>$val){
    	    $goods_nums += $val['goods_num'];
    	}
    	$this->assign('gn',$goods_nums); */
    }
}