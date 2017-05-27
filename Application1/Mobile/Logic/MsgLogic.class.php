<?php
namespace Mobile\Logic;
use Think\Model;

class MsgLogic extends Model{
	public function get_unread($uid){
			$userMsg = M('UserMsg');
			$msgList = $userMsg->field(' group_concat(msg_id) as msg_id')->where(array('user_id'=>$uid,'status'=>0))->find();
			
			$msg = M('msg');
			if(empty($msgList['msg_id'])){
			    return array();
			}
			
			$where = array(
					'id'=>array(
							'in',$msgList['msg_id']//$msgList['msg_id']
					)
			);
			$unredList = $msg->where($where)->field('count(id) as count ,cate_id')->group('cate_id')->select();
		    return $unredList;
	}
	
	public function msg_list($id){
	    $user = session('user');
	    $userMsg = M('Msg');
	    $msgList = $userMsg->where(array('cate_id'=>$id,'user_id'=>array('in','0,'.$user['user_id'])))->select();
	    foreach ($msgList as $key=>$val){
	        $msgList[$key]['c_time'] = date('Y-m-d',$val['c_time']);
	    }
	    return $msgList;
	}
	public function send_msg($type,$order_sn,$user_id=""){
	    $msgMod = M('Msg');
	    $userMsg = M('UserMsg');
	    $user = session('user');
	    switch ($type) {
			case 1 :
				$data = array (
						'cate_id' => 1,
						'send_type' => 2,
						'user_id' => $user ['parent_id'],
						'title' => '您有一个新的未发货订单',
						'content' => $user ['mobile'] . '有新的下单,订单号为' . $order_sn,
						'c_time' => time () 
				);
				$msg_id = $msgMod->add ( $data );
				$map = array (
						'msg_id' => $msg_id,
						'user_id' => $user ['parent_id'] 
				);
				
				$useMsgId = $userMsg->add ( $map );
				
				if ($msg_id && $useMsgId) {
					return array (
							$msg_id,
							$useMsgId 
					);
				} else {
					return false;
				}
				break;
			case 2 :
				$data = array (
						'cate_id' => 1,
						'send_type' => 2,
						'user_id' => $user_id,
						'title' => '收到一条发货信息',
						'content' => '订单号为' . $order_sn . '已发货,请注意查收',
						'c_time' => time () 
				);
				$msg_id = $msgMod->add ( $data );
				$map = array (
						'msg_id' => $msg_id,
						'user_id' => $user ['parent_id'] 
				);
			
				$useMsgId = $userMsg->add ( $map );
				if ($msg_id && $useMsgId) {
					return array (
							$msg_id,
							$useMsgId 
					);
				} else {
					return false;
				}
				break;
			case 3 :  //退貨
				$data = array (
						'cate_id' => 1,
						'send_type' => 2,
						'user_id' => $user ['parent_id'],
						'title' => '收到一条退貨信息',
						'content' => '订单号为' . $order_sn . '申请退货,请处理',
						'c_time' => time () 
				);
				$msg_id = $msgMod->add ( $data );
				$map = array (
						'msg_id' => $msg_id,
						'user_id' => $user ['parent_id'] 
				);
				
				$useMsgId = $userMsg->add ( $map );
				if ($msg_id && $useMsgId) {
					return array (
							$msg_id,
							$useMsgId 
					);
				} else {
					return false;
				}
				break;
			case 4 :    //退貨处理
				$data = array (
						'cate_id' => 1,
						'send_type' => 2,
						'user_id' => $user_id,
						'title' => '收到一条退货处理信息',
						'content' => '订单号为' . $order_sn . '退货申请已处理，请注意查看货款！',
						'c_time' => time () 
				);
				$msg_id = $msgMod->add ( $data );
				$map = array (
						'msg_id' => $msg_id,
						'user_id' => $user_id 
				);
				
				$useMsgId = $userMsg->add ( $map );
				if ($msg_id && $useMsgId) {
					return array (
							$msg_id,
							$useMsgId 
					);
				} else {
					return false;
				}
				break;
			case 5 :    //解約
				$data = array (
						'cate_id' => 1,
						'send_type' => 2,
						'user_id' => $user_id,
						'title' => '收到一条解约申请信息',
						'content' => '用户' . $order_sn . '申请解约,请及时处理',
						'c_time' => time () 
				);
				$msg_id = $msgMod->add ( $data );
				$map = array (
						'msg_id' => $msg_id,
						'user_id' => $user_id 
				);
			
				$useMsgId = $userMsg->add ( $map );
				if ($msg_id && $useMsgId) {
					return array (
							$msg_id,
							$useMsgId 
					);
				} else {
					return false;
				}
				break;
				case 6 :    //解約处理
					$data = array (
					'cate_id' => 1,
					'send_type' => 2,
					'user_id' => $user_id,
					'title' => '收到一条解约处理信息',
					'content' => '您的解约申请已处理,请及时查看',
					'c_time' => time ()
					);
					$msg_id = $msgMod->add ( $data );
					$map = array (
							'msg_id' => $msg_id,
							'user_id' => $user ['parent_id']
					);
				
					$useMsgId = $userMsg->add ( $map );
					if ($msg_id && $useMsgId) {
						return array (
								$msg_id,
								$useMsgId
						);
					} else {
						return false;
					}
					break;
					case 7 :    //取消哦解約
						$data = array (
						'cate_id' => 1,
						'send_type' => 2,
						'user_id' => $user_id,
						'title' => '收到一条解约申请信息',
						'content' => '用户' . $order_sn . '取消申请解约,请查看',
						'c_time' => time ()
						);
						$msg_id = $msgMod->add ( $data );
						$map = array (
								'msg_id' => $msg_id,
								'user_id' => $user_id
						);
					
						$useMsgId = $userMsg->add ( $map );
						if ($msg_id && $useMsgId) {
							return array (
									$msg_id,
									$useMsgId
							);
						} else {
							return false;
						}
						break;
						case 8 :    //解約处理
							$data = array (
							'cate_id' => 1,
							'send_type' => 2,
							'user_id' => $user_id,
							'title' => '收到一条解约处理信息',
							'content' => '您的解约申请已处理,请及时查看',
							'c_time' => time ()
							);
							$msg_id = $msgMod->add ( $data );
							$map = array (
									'msg_id' => $msg_id,
									'user_id' => $user ['parent_id']
							);
					
							$useMsgId = $userMsg->add ( $map );
							if ($msg_id && $useMsgId) {
								return array (
										$msg_id,
										$useMsgId
								);
							} else {
								return false;
							}
							break;
		}
	}
}