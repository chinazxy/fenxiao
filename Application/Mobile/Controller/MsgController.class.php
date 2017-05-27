<?php
namespace  Mobile\Controller;
use Mobile\Logic\MsgLogic;

class MsgController extends PublicController{
	public function index(){
	 
		$uid = $this->user_id;
		$msgLog = new MsgLogic();
		$result = $msgLog->get_unread($uid);
		$msgcateMod = D('MsgCate');
		$cateList =$msgcateMod->where(array('status'=>1))->field('id,type_name')->order('listorder desc')->select();
		foreach ($cateList as $key=>$val){
			foreach ($result as $k=>$v){
				if($v['cate_id']==$val['id']){
					$cateList[$key]['unred'] = $v['count'];
					break;
				}else{
				    $cateList[$key]['unred'] = 0;
				}
			}
		}
		$this->assign('cateList',$cateList);
		$this->display();
	}
	
	
	
	public function msg_list(){
	   $uid = $this->user_id;
	   $msgLog = new MsgLogic();
	   $list= $msgLog->msg_list(I('id'));
	   $result = $msgLog->get_unread($uid);
	   $this->assign('msglist',$list);
	   $this->display();
	}
	
	public function detail(){
	    $id = I('id');
	    $userMsg = M('UserMsg');
	    $msg  = $userMsg->where(array('msg_id'=>$id,'user_id'=>$this->user_id))->select();
	    $data = array(
	       'status'=>1,
	       'r_time'=>time()
	    );
	    $userMsg->where(array('msg_id'=>$id,'user_id'=>$this->user_id))->save($data);
	    $detail = M('msg')->find($id);
	    $detail['c_time'] = date('Y-m-d',$detail['c_time']);
        //this->assign)()
	    $this->assign('detail',$detail);
	    $this->display();
	}
}
