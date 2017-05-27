<?php
namespace Admin\Controller;


use Think\AjaxPage;
use Think\Page;

class UserController extends BaseController {
    public function get_level($level){
        $level_array=array(1=>"公司销售部",2=>'特约',3=>'微一',4=>'微二',5=>'微三');
        return $level_array[$level];
    }
    public function index(){
        $this->display();
    }
    /**
     经销商申请
     */
    public function apply(){
        $condition = 'is_lock= 3 and is_out = 1 ';
        $list = M('users')->where($condition)->select();
        foreach ($list as $key=>$val){
            $list[$key]['level'] =$this->get_level($val['level']);
        }
        $this->assign('userList',$list);
        $this->display();    
    }
    
    public function pas_apply(){
        $id = I('id');
        $info = M('users')->find($id);
        if($info['is_lock']==3||$info['parent_id']==1){
            $where = array(
                 'is_lock'=>0,
                 'is_out'=>0
            );
            $list = M('users')->where(array(
                  'user_id'=>$id
            ))->save($where);
        }elseif ($info['is_lock']==2){
            $where = array(
                    'is_lock'=>4
            );
            $list = M('users')->where(array(
                    'user_id'=>$id
            ))->save($where);
        }
		if($where['is_lock'] == 0){
                $con = R('Mobile/Public/send',array(11,'',$id));
				$this->success('修改成功!'); 
			}
			else{
				$this->error('修改失败!');
			}
    }
    public function  out_apply(){
        $id = I('id');
        $sql = "update up_users set is_out = 2,is_lock = 2 where user_id =".$id;
        $out = M('users')->execute($sql);
        if($out){
            $this->success('您已经拒绝了该经销商申请!');
        }else{
            $this->error('对不起，拒绝失败!');
        }
    }
    
    /**
     * 保证金模块
     */
    
    public  function bzj(){
        if(!empty(I('mobile'))){
            $mobile = I('mobile');
            $list = M('users')->where('user_id !=1 and is_lock!=1 and mobile='.$mobile)->join('up_bzj ON up_bzj.uid = up_users.user_id ','LEFT')->select();
        }else{
            $list = M('users')->where('user_id !=1 and is_lock!=1 ')->join('up_bzj ON up_bzj.uid = up_users.user_id ','LEFT')->select();
        }
        
        $this->assign('list',$list);
        $this->display();
    }
    
  
    /**
     * 会员列表
     */
    public function ajaxindex(){
        // 搜索条件
        $condition = array();
        I('mobile') ? $condition['mobile'] = I('mobile') : false;
        I('email') ? $condition['email'] = I('email') : false;
        $sort_order = I('order_by').' '.' asc';
        $model = M('users');
        $count = $model->where($condition)->count();
        $Page  = new AjaxPage($count,10);
        //  搜索条件下 分页赋值
        foreach($condition as $key=>$val) {
            $Page->parameter[$key]   =   urlencode($val);
        }
        $show = $Page->show();
        $orderList = $model->where($condition)->order($sort_order)->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach ($orderList as $key=>$val){
            $orderList[$key]['level'] =$this->get_level($val['level']);
        }
        $this->assign('userList',$orderList);
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }

    /**
     * 会员详细信息查看
     */
    public function detail(){
        $uid = I('get.id');
        $user = D('users')->where(array('user_id'=>$uid))->find();
        //var_dump($user);exit;
		$pledge = M('pledge')->where(array('user_id'=>$uid))->find();
		$user['pledge_name'] = $pledge['pledge_name'];
		$user['pledge_time'] = $pledge['pledge_time'];
        //$level = M('user_level')->where("level_id>=$user[level]")->select();
        $level = M('user_level')->select();
        //$user = M()->table(array('up_users'=>'u','up_user_level'=>l))->where("u.user_id=$uid AND u.level=l.level_id")->find();
        if(!$user)
            exit($this->error('会员不存在'));
        if($user['parent_id'] !=0){
        	$parent = D('users')->where("user_id=$user[parent_id]")->field('username,nickname,user_id,mobile')->find();
        	$user['p_nickname'] = $parent['mobile'];
            $user['p_username'] = $parent['username'];
        }else{
        	$user['p_nickname'] = '无上级代理';
        }
        if(IS_POST){
            if($_POST['pledge_money'] != 0 && $_POST['is_lock'] == 1){
                    exit($this->error('需清空该用户保证金！'));
            }
            $password = I('post.password');
            if($password == ''){
                unset($_POST['password']);
            }else{
                $_POST['password'] = md5($_POST['password']);
            }
            adminLog('修改会员信息',__ACTION__);
			$mobile = M('users')->where(array('mobile'=>$_POST['mobile']))->where('user_id !='.$uid)->find();
			if($mobile){
				exit($this->error('所填手机号码已存在，请修改'));
			}
            $row = M('users')->where(array('user_id'=>$uid))->save($_POST);
            if($row) {
                if($_POST['is_lock'] == 1){
                    $sql = "update up_users set is_out = 1 WHERE user_id =".$uid;
                    M('users')->execute($sql);
					M('pledge')->where(array('user_id'=>$uid))->delete();
                }
				if($_POST['is_lock'] == 0){
                    $sql = "update up_users set is_out = 0 WHERE user_id =".$uid;
                    M('users')->execute($sql);
                }
                exit($this->success('修改成功'));
            }else {
                exit($this->error('未作内容修改或修改失败'));
            }
        }
        $this->assign('level',$level);
        //print_r($level);exit;
        $this->assign('user',$user);
        $this->display();
    }
	/**
	 * 查看下级代理
	 */
    public function show_child(){
    	$uid = I('id');
    	$this->assign('uid',$uid);
    	$this->display();
    }
    public function ajax_child(){
    	// 搜索条件
    	$condition = array();
    	I('mobile') ? $condition['mobile'] = I('mobile') : false;
    	I('email') ? $condition['email'] = I('email') : false;
    	$condition['parent_id'] =I('uid','-1');
    	$sort_order = I('order_by').' '.' asc';
    	$model = M('users');
    	$count = $model->where($condition)->count();
    	$Page  = new AjaxPage($count,10);
    	//  搜索条件下 分页赋值
    	foreach($condition as $key=>$val) {
    		$Page->parameter[$key]   =   urlencode($val);
    	}
    	$show = $Page->show();
    	$orderList = $model->where($condition)->order($sort_order)->limit($Page->firstRow.','.$Page->listRows)->select();
    	$this->assign('userList',$orderList);
    	$this->assign('page',$show);// 赋值分页输出
    	$this->display();
    }
    /**
     * 用户收货地址查看
     */
    public function address(){
        $uid = I('get.id');
        $lists = D('user_address')->where(array('user_id'=>$uid))->select();
        $regionList = M('Region')->getField('id,name');
        $this->assign('regionList',$regionList);
        $this->assign('lists',$lists);
        $this->display();
    }

    /**
     * 删除会员
     */
    public function delete(){
        $uid = I('get.id');
        $row = M('users')->where(array('user_id'=>$uid))->delete();
        if($row){
            adminLog('删除会员',__ACTION__);
            $this->success('成功删除会员');
        }else{
            $this->error('操作失败');
        }
    }

    /**
     * 账户资金记录
     */
    public function account_log(){
        $user_id = I('get.id');
        //获取类型
        $type = I('get.type');
        //获取记录总数
        $count = M('account_log')->where(array('user_id'=>$user_id))->count();
        $page = new Page($count);
        $lists  = M('account_log')->where(array('user_id'=>$user_id))->order('change_time desc')->/* limit($page->firstRow.','.$page->listRows)-> */select();
       
        $cash = M('Cash')->where(array('user_id'=>$user_id))->select();
        $rechage = M('UserRechage')->where(array('user_id'=>$user_id))->select();
      
        foreach ($cash as $key=>$val){
            if($val['status']==1){
                $val['desc'] = '提现成功记录';
            }elseif($val['status']==0){
                $val['desc'] = '提现申请中';
            }
            $val['change_time'] = $val['create_time'];
            $val['user_money'] = '-'.$val['money'];
           
            array_push($lists, $val);
        }
        foreach ($rechage as $key=>$val){
            $val['desc'] = '充值记录';
            $val['change_time'] = $val['time'];
            $val['user_money'] = $val['money'];
            array_push($lists, $val);
        }
      
      /*   dump($cash);
        dump($rechage); */
        $this->assign('user_id',$user_id);
      //  $this->assign('page',$page->show());
        $this->assign('lists',$lists);
        $this->display();
    }

    /**
     * 账户资金调节
     */
    public function account_edit(){
        $user_id = I('get.id');
        if(!$user_id > 0)
            $this->error("参数有误");
        if(IS_POST){
            //获取操作类型
            $m_op_type = I('post.money_act_type');
            $user_money = I('post.user_money');
            $user_money =  $m_op_type ? $user_money : 0-$user_money;

            $p_op_type = I('post.point_act_type');
            $pay_points = I('post.pay_points');
            $pay_points =  $p_op_type ? $pay_points : 0-$pay_points;

            $f_op_type = I('post.frozen_act_type');
            $frozen_money = I('post.frozen_money');
            $frozen_money =  $f_op_type ? $frozen_money : 0-$frozen_money;

            $desc = I('post.desc');
            if(!$desc)
                $this->error("请填写操作说明");
            if(accountLog($user_id,$user_money,$pay_points,$desc)){
                adminLog("会员账户资金调节",__ACTION__);
                $this->success("操作成功",U("Admin/User/account_log",array('id'=>$user_id)));
            }else{
                $this->error("操作失败");
            }
            exit;
        }
        $this->assign('user_id',$user_id);
        $this->display();
    }
    
    public function level(){
    	$act = I('GET.act','add');
    	$this->assign('act',$act);
    	$level_id = I('GET.level_id');
    	$level_info = array();
    	if($level_id){
    		$level_info = D('user_level')->where('level_id='.$level_id)->find();
    		$this->assign('info',$level_info);
    	}
    	$this->display();
    }
    
    public function levelList(){
    	$Ad =  M('user_level');
    	$res = $Ad->where('1=1')->order('level_id')->page($_GET['p'].',10')->select();
    	if($res){
    		foreach ($res as $val){
    			$list[] = $val;
    		}
    	}
    	$this->assign('list',$list);
    	$count = $Ad->where('1=1')->count();
    	$Page = new \Think\Page($count,10);
    	$show = $Page->show();
    	$this->assign('page',$show);
    	$this->display();
    }
    
    public function levelHandle(){
    	$data = $_POST;
    	if($data['act'] == 'add'){
    		$r = D('user_level')->add($data);
    	}
    	if($data['act'] == 'edit'){
    		$r = D('user_level')->where('level_id='.$data['level_id'])->save($data);
    	}
    	 
    	if($data['act'] == 'del'){
    		$r = D('user_level')->where('level_id='.$data['level_id'])->delete();
    		if($r) exit(json_encode(1));
    	}
    	 
    	if($r){
    	    adminLog('编辑等级',__ACTION__);
    		$this->success("操作成功",U('Admin/User/levelList'));
    	}else{
    		$this->error("操作失败",U('Admin/User/levelList'));
    	}
    }

    /**
     * 搜索用户名
     */
    public function search_user()
    {
        $search_key = trim(I('search_key'));        
        if(strstr($search_key,'@'))    
        {
            $list = M('users')->where(" email like '%$search_key%' ")->select();        
            foreach($list as $key => $val)
            {
                echo "<option value='{$val['user_id']}'>{$val['email']}</option>";
            }                        
        }
        else
        {
            $list = M('users')->where(" mobile like '%$search_key%' ")->select();        
            foreach($list as $key => $val)
            {
                echo "<option value='{$val['user_id']}'>{$val['mobile']}</option>";
            }            
        } 
        exit;
    }
    /**
     * 解约管理
     */
    public function termination_list(){
    	$temination =M('temination');
        $data = $temination->where('status = 1')->select();
        $count = $temination->where('status = 1')->count();
    	$Page = new \Think\Page($count,10);
    	$show = $Page->show();
    	$this->assign('page',$show);
    	$this->assign('data',$data);
    	$this->display();
    }
    /**
     * 解决处理
     */
    public function change_termination_status(){
    	$uid = I('uid',0);
    	$status = I('status',0);
    	if($uid && $status){
    		if($status == 1){  //同意解约
    			$data['status'] = 4;
                $udata['is_temination'] = 1;
                $udata['parent_id'] = 0;
				$boss['parent_id'] = 1;
                $down = M('users')->where('parent_id='.$uid)->save($boss);
                $res = M('temination')->where(array('uid'=>$uid))->save($data);
    		}
            if($status == -1){
                $res = M('temination')->where(array('uid'=>$uid))->delete();
                $udata['is_temination'] = 0;
    		}
            M('users')->where("user_id = $uid")->save($udata);
    		if($res){
    		    adminLog('解决处理解约',__ACTION__);
    			$this->success('操作成功');
    		}else{
    			$this->error('操作失败');
    		}
    		
    	}else{
    		$this->error('参数缺失');
    	}
    }
    //提现列表
    public function cash(){
    	$result = M('cash')->where('status <> -1')->order('create_time desc')->select();
    	foreach ($result as $key=>$val){
    	    $tmp = M('Users')->field('user_money')->find($val['user_id']);
    	    $result[$key]['user_money'] = $tmp['user_money'];
    	}
    	$this->assign('cash_list',$result);
    	
    	$this->display();
    }
    //提现操作
    public function change_cash_status(){
    	$id = I('id',0);
    	$status = I('status',0);
    	$user_id = I('user_id');
		$money = M('cash')->where("id=$id")-> getField('money');
    	if($id && $status){
    		if($status == 1){  //同意
    			$data['status'] = 1;
                $con = R('Mobile/Public/send',array(9,'',$user_id));
    		}elseif($status ==2){
    			$data['status'] = 2;  //拒绝
                $con = R('Mobile/Public/send',array(10,'',$user_id));
    		}elseif($status == -1){
    			$data['status'] = -1;  //删除
    		}
    		if($status == 1){
    			$res1 = M('users')->where("user_id = $user_id")->setDec('frozen_money',$money);
    		}elseif($status == 2){
    			$res1 = M('users')->where("user_id = $user_id")->setDec('frozen_money',$money);
    			$res1 = M('users')->where("user_id = $user_id")->setInc('user_money',$money);
    			
    		}
    		$res = M('cash')->where("id = $id")->save($data);
    		if($res){
    		    adminLog('提现处理',__ACTION__);
    			$this->success('操作成功');
    		}else{
    			$this->error('操作失败');
    		}
    	
    	}else{
    		$this->error('参数缺失');
    	}
    }
    
}