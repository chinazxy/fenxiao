<?php
namespace Admin\Controller;


use Admin\Logic\PageLogic;
class MsgController extends BaseController {
    public function  index(){
        $userMsg = M('UserMsg');
        $msg = M('Msg');
        $msgCate = M('MsgCate');
        $cateList =($msgCate->select());
        $this->assign('cateList',$cateList);
        $this->display();
    }
    
    public function cate_detail(){
     
        if (IS_POST){
            $data = M('MsgCate')->create();
            M('MsgCate')->save();
            adminLog("消息分类编辑",__ACTION__);
            $this->success('编辑成功',U('index'));
        }else{
            $id = I('id');
            $result = M('MsgCate')->find($id);
            $this->assign('res',$result);
            $this->display();
        }
       
    }
    
    public function msg_list(){
        $id = I('id');
        $count  = M('Msg')->where(array('cate_id'=>$id))->count();
        $pagesize = 10;
        $page =I('p',1);
        $pageLog = new PageLogic($count,$pagesize);
        $pager = $pageLog->show();
        $limit = ($page-1)*$pagesize.','.$pagesize;
        $msgList = M('Msg')->where(array('cate_id'=>$id))->order('user_id asc')->limit($limit)->select();
        foreach ($msgList as $key=>$val){
            if($val['user_id']>0){
                $msgList[$key]['userInfo'] = M('Users')->find($val['user_id']); 
            }else{
                $msgList[$key]['userInfo'] =array(
                     'username'=>'所有人',
                     'mobile'=>''
                );
            }
        }
        $this->assign('pager',$pager);
        $this->assign('msgList',$msgList);
       
        $this->display();
    }
    
    public function delete(){
        $msg_id = I('msg_id');
        $rest1 = M('Msg')->where('id='.$msg_id)->delete();
        $rest2 = M('UserMsg')->where('msg_id='.$msg_id)->delete();
        if($rest1&&$rest2){
            adminLog("删除消息",__ACTION__);
            $a['status'] = 1;
        }else{
            $a['status'] =2;
        }
        $this->ajaxReturn($a);
    }
    public function add_msg(){
        if(IS_POST){
            $data = array(
                'cate_id'=>I('cate_id'),
                'title'=>I('title'),
                'send_type'=>I('send_type'),
                'content'=>I('content'),
                'c_time'=>time()
            );
            if (I('send_type')==2){
                $user = M('Users')->where('mobile='.I('mobile'))->find();
                if(empty($user)){
                      echo"<script>alert('找不到该用户');history.go(-1);</script>";  
                      exit;
                }
                $data['user_id'] = $user['user_id'];
                $where['user_id'] = $data['user_id'];
            }else{
                $data['user_id'] = 0;
                $where = "1=1";
            }
            $msg_id = M('Msg')->add($data);
          

            $userList = M('Users')->where($where)->select();
            foreach ($userList as $key=>$val){
                 M('UserMsg')->add(array(
                    'msg_id'=>$msg_id,
                    'user_id'=>$val['user_id'],
                    'status'=>0,
                    'r_time'=>0
                 ));

            }
            adminLog("添加消息",__ACTION__);
            $this->success('消息发送成功',U('msg_list').'?id='.I('cate_id'));
            exit();
        }
     
        $userList = M('Users')->select();
        $this->assign('userList',$userList);
        $this->assign('cate_id',I('id'));
        $this->display();
    }
}