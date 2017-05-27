<?php
namespace Admin\Logic;
use Think\Model\RelationModel;

class OrderLogic extends RelationModel
{
    /**
     * @param array $condition  搜索条件
     * @param string $order   排序方式
     * @param int $start    limit开始行
     * @param int $page_size  获取数量
     */
    public function getOrderList($condition,$order='',$start=0,$page_size=20){
        $res = M('order')->where($condition)->limit("$start,$page_size")->order($order)->select();
        return $res;
    }
    /*
     * 获取订单商品详情
     */
    public function getOrderGoods($order_id){
        $sql = "SELECT g.*,o.*,(o.goods_num * o.member_goods_price) AS goods_total FROM __PREFIX__order_goods o ".
            "LEFT JOIN __PREFIX__goods g ON o.goods_id = g.goods_id WHERE o.order_id = $order_id";
        $res = $this->query($sql);
        return $res;
    }

    /*
     * 获取订单信息
     */
    public function getOrderInfo($order_id)
    {
        //  订单总金额查询语句
        $total_fee = " (goods_price + shipping_price - discount - coupon_price - integral_money) AS total_fee ";
        $sql = "SELECT *, " . $total_fee . " FROM __PREFIX__order WHERE order_id = '$order_id'";
        $res = $this->query($sql);
        $res[0]['address2'] = $this->getAddressName($res[0]['province'],$res[0]['city'],$res[0]['district']);
        $res[0]['address2'] = $res[0]['address2'].$res[0]['address'];
        return $res[0];
    }

    /*
     * 根据商品型号获取商品
     */
    public function get_spec_goods($goods_id_arr){
    	if(!is_array($goods_id_arr)) return false;
    		foreach($goods_id_arr as $key => $val)
    		{
    			$arr = array();
    			$goods = M('goods')->where("goods_id = $key")->find();
    			$arr['goods_id'] = $key; // 商品id
    			$arr['goods_name'] = $goods['goods_name'];
    			$arr['goods_sn'] = $goods['goods_sn'];
    			$arr['market_price'] = $goods['market_price'];
    			$arr['goods_price'] = $goods['shop_price'];
    			$arr['cost_price'] = $goods['cost_price'];
    			$arr['member_goods_price'] = $goods['shop_price'];
    			foreach($val as $k => $v)
    			{
    				$arr['goods_num'] = $v['goods_num']; // 购买数量
    				// 如果这商品有规格
    				if($k != 'key')
    				{
    					$arr['spec_key'] = $k;
    					$spec_goods = M('spec_goods_price')->where("goods_id = $key and `key` = '{$k}'")->find();
    					$arr['spec_key_name'] = $spec_goods['key_name'];
    					$arr['member_goods_price'] = $arr['goods_price'] = $spec_goods['price'];
    					$arr['bar_code'] = $spec_goods['bar_code'];
    				}
    				$order_goods[] = $arr;
    			}
    		}
    		return $order_goods;	
    }

    /*
     * 订单操作记录
     */
    public function orderActionLog($order_id,$action,$note=''){    	
        $order = M('order')->where(array('order_id'=>$order_id))->find();
        $data['order_id'] = $order_id;
        $data['action_user'] = session('admin_id');
        $data['action_note'] = $note;
        $data['order_status'] = $order['order_status'];
        $data['pay_status'] = $order['pay_status'];
        $data['shipping_status'] = $order['shipping_status'];
        $data['log_time'] = time();
        $data['status_desc'] = $action;
        if($action == 'delivery_confirm'){
        	order_give($order);//确认收货
        }
        return M('order_action')->add($data);//订单操作记录
    }

    /*
     * 获取订单商品总价格
     */
    public function getGoodsAmount($order_id){
        $sql = "SELECT SUM(goods_num * goods_price) AS goods_amount FROM __PREFIX__order_goods WHERE order_id = {$order_id}";
        $res = $this->query($sql);
        return $res[0]['goods_amount'];
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
     * 获取当前可操作的按钮
     */
    public function getOrderButton($order){
        /*
         *  操作按钮汇总 ：付款、设为未付款、确认、取消确认、无效、去发货、确认收货、申请退货
         * 
         */
    	$os = $order['order_status'];//订单状态
    	$ss = $order['shipping_status'];//发货状态
    	$ps = $order['pay_status'];//支付状态
        $btn = array();
         if($order['pay_code'] == 'cod') {
        	if($os == 0 && $ss == 0){
        		$btn['confirm'] = '确认订单';
        	}elseif($os == 1 && $ss == 0 ){
        		$btn['delivery'] = '去发货';
        		$btn['invalid'] = '取消订单';
        	}elseif($ss == 1 && $os == 1 && $ps == 0){
        		$btn['pay'] = '付款';
        	}
        }else{
        	if($ps == 0 && $os == 0){
        		$btn['pay'] = '付款';
        	}elseif($os == 0 && $ps == 1){
        		$btn['confirm'] = '确认';
        	}elseif($os == 1 && $ps == 1 && $ss==0){
        		//$btn['cancel'] = '取消订单';
				$btn['invalid'] = '取消订单';
        		$btn['delivery'] = '去发货';
        	}
        } 
        if($ss == 1 && $os == 1 && $ps == 1){
        	$btn['delivery_confirm'] = '确认收货';
        	//$btn['refund'] = '申请退货';
        }
		/*elseif($os == 2 || $os == 4){
        	$btn['refund'] = '申请退货';
        }
		/*elseif($os == 3 || $os == 5){
        	$btn['remove'] = '移除';
        }*/
        return $btn;
    }

    
    public function orderProcessHandle($order_id,$act){
    	$updata = array();
		$money = M('order')->where("order_id=$order_id")->find();
		$order = M('order_goods')->where("order_id=$order_id")->select();
		$user = M('order_action')->where("order_id=$order_id")->find();
    	switch ($act){
    		case 'pay': //付款
    			$updata['pay_status'] = 1;
    			$updata['pay_time'] = time();
				$updata['payfrom'] = 2;
				$goods = M('order_goods')->field('order_id,goods_id,goods_num')->where("order_id=$order_id")->select();
                    foreach ($goods as $val) {
                        mysql_query("BEGIN");
                            $res1 = M('user_goods')->where("uid = 1")->where(array('goods_id'=>$val[goods_id]))->setDec('stock', $val['goods_num']);
                            $res2 = M('goods')->where(array('goods_id'=>$val[goods_id]))->setDec('store_count', $val['goods_num']); //更改商品库存
                            $res3 = M('spec_goods_price')->where(array('goods_id'=>$val[goods_id]))->setDec('store_count', $val['goods_num']); //更改规格库存
						if($res1 && $res2 && $res3){
							//$res4 = M('user_goods')->where("uid = ".$user[action_user])->where(array('goods_id'=>$val[goods_id]))->setInc('stock', $val['goods_num']);
							mysql_query('COMMIT');
						}else{
							mysql_query('ROLLBACK');
						}
                        mysql_query('END');
                    }
    			break;
    		case 'pay_cancel': //取消付款
    			$updata['pay_status'] = 0;
    			break;
    		case 'confirm': //确认订单
    			$updata['order_status'] = 1;
    			break;
    		case 'cancel': //取消确认
    			$updata['order_status'] = 0;
    			break;
    		case 'invalid': //作废订单
    			$updata['order_status'] = 5;
				$updata['shipping_status'] = 3;
				$updata['pay_status'] = 0;
				//是否线下
				$payfrom = M('order')->field('payfrom')->where(array('order_sn'=>$money['order_sn']))->find() ;
				mysql_query("BEGIN");
				if($payfrom['payfrom'] == 1) {
					$r1 = M('users')->execute("update up_users set frozen_money = frozen_money - $money[order_amount] where user_id = 1");
				}
				foreach($order as $k=>$v){
					//echo $v['goods_num'].$v['goods_id'];
					$r2=M('user_goods')->where(array('uid'=>1,'goods_id'=>$v['goods_id']))->setInc('stock',$v['goods_num']);
					$r3=M('spec_goods_price')->where(array('goods_id'=>$v['goods_id']))->setInc('store_count',$v['goods_num']);
					$r4=M('goods')->where(array('goods_id'=>$v['goods_id']))->setInc('store_count',$v['goods_num']);
				//$r2 = M('user_goods')->execute("update up_user_goods set stock = stock + $v['goods_num'] where uid = 1 and goods_id = $v['goods_id']");
				//$r3 = M('spec_goods_price')->execute("update up_spec_goods_price set store_count =  store_count + $order[$k]['goods_num'] where goods_id = $v['goods_id']");
				//$r4 = M('goods')->execute("update up_goods set store_count = store_count + $v['goods_num'] where goods_id = $v['goods_id']");
				}
				if($r2 && $r3 && $r4){
					if($payfrom['payfrom'] == 1) {
						M('users')->execute("update up_users set user_money = user_money + $money[order_amount] where user_id = $user[action_user]");
						//M('user_goods')->execute("update up_user_goods set stock = stock - $order[goods_num] where uid = $user[action_user] and goods_id = $order[goods_id]");
					}
				    mysql_query('COMMIT');
				}else{
					mysql_query('ROLLBACK');
				}
				mysql_query("END");
    			break;
    		case 'remove': //移除订单
    			$this->delOrder($order_id);
    			break;
    		case 'delivery_confirm'://确认收货
    			$updata['order_status'] = 2;
    			$updata['confirm_time'] = time();
    			$updata['pay_status'] = 1;
				M('users')->execute("update up_users set frozen_money = frozen_money - $money[order_amount],user_money = user_money + $money[order_amount] where user_id = 1");
				$goods = M('order_goods')->field('order_id,goods_id,goods_num')->where("order_id=$order_id")->select();
				foreach ($goods as $val) {
				M('user_goods')->where("uid = ".$user[action_user])->where(array('goods_id'=>$val[goods_id]))->setInc('stock', $val['goods_num']);
				}
    			break;	
    		default:
    			return true;
    	}
		return M('order')->where("order_id=$order_id")->save($updata);//改变订单状态
    }
    
    /**
     *	处理发货单
     * @param array $data  查询数量
     */
    public function deliveryHandle($data){
		$order = $this->getOrderInfo($data['order_id']);
		$orderGoods = $this->getOrderGoods($data['order_id']);
		$selectgoods = $data['goods'];
		$data['order_sn'] = $order['order_sn'];
		$data['delivery_sn'] = $this->get_delivery_sn();
		$data['zipcode'] = $order['zipcode'];
		$data['user_id'] = $order['user_id'];
		$data['admin_id'] = session('admin_id');
		$data['consignee'] = $order['consignee'];
		$data['mobile'] = $order['mobile'];
		$data['country'] = $order['country'];
		$data['province'] = $order['province'];
		$data['city'] = $order['district'];
		$data['district'] = $order['order_sn'];
		$data['address'] = $order['address'];
		$data['shipping_code'] = $order['shipping_code'];
		//$data['shipping_name'] = $order['shipping_name'];
		$data['shipping_price'] = $order['shipping_price'];
		$data['create_time'] = time();
		$did = M('delivery_doc')->add($data);
		$is_delivery = 0;
		foreach ($orderGoods as $k=>$v){
			if($v['is_send'] == 1){
				$is_delivery++;
			}			
			if($v['is_send'] == 0 && in_array($v['rec_id'],$selectgoods)){
				$res['is_send'] = 1;
				$res['delivery_id'] = $did;
				$r = M('order_goods')->where("rec_id=".$v['rec_id'])->save($res);//改变订单商品发货状态
				$order_sn = $data['order_sn'];
				$user_id = $data['user_id'];
				$is_delivery++;
			}
		}
		
		if($is_delivery == count($orderGoods)){
			$updata['shipping_status'] = 1;
		}else{
			$updata['shipping_status'] = 2;
		}
		$arr = array(
			    "cate_id"=>1,
				"send_type"=>2,
				"user_id"=>$order['user_id'],
				"title"=>'您有一个新的发货提醒',
				"content"=>'订单号为'.$order['order_sn'].'已发货',
				"c_time"=>time()
			);
		M('msg')->add($arr);
		$con = R('Mobile/Public/send',array(5,$order_sn,$user_id));
		$updata['shipping_name'] = $data['shipping_name'];
		M('order')->where("order_id=".$data['order_id'])->save($updata);//改变订单状态
		$s = $this->orderActionLog($order['order_id'],'delivery',$data['note']);//操作日志
		adminLog("发货单处理",__ACTION__);
		return $s && $r;
    }
    /**
     * 获取地区名字
     * @param int $p
     * @param int $c
     * @param int $d
     * @return string
     */
    public function getAddressName($p=0,$c=0,$d=0){
        $p = M('region')->where(array('id'=>$p))->field('name')->find();
        $c = M('region')->where(array('id'=>$c))->field('name')->find();
        $d = M('region')->where(array('id'=>$d))->field('name')->find();
        return $p['name'].','.$c['name'].','.$d['name'].',';
    }

    /**
     * 删除订单
     */
    function delOrder($order_id){
    	$a = M('order')->where(array('order_id'=>$order_id))->delete();
    	$b = M('order_goods')->where(array('order_id'=>$order_id))->delete();
    	return $a && $b;
    }

}