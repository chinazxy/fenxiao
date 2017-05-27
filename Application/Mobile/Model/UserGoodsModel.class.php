<?php

namespace Mobile\Model;
use Think\Model;

class UserGoodsModel extends Model{
	
	/**
	 * 获取上级商品列表
	 */
	public function get_goods($uid,$parent_id=0,$goods_id='',$cat_id='',$brand_id='',$is_what='',$keyword='',$sort='sort',$limit=''){
	    $parent_id = 0;
	   
	    if($goods_id !=''){
			$where['up_goods.goods_id'] = $goods_id;
		}
		if($cat_id){
			$where['up_goods.cat_id'] = array('like',"%$cat_id%");
		}
		if($brand_id){
			$where['up_goods.brand_id'] = $brand_id;
		}
		if($is_what){
			$where["up_goods.$is_what"] = 1;
		}
		if($keyword){
			$where['up_goods.keywords'] = array('like',"%$keyword%");
		}
		$where['is_on_sale'] = 1;
		if($parent_id==0){
			$field = $this->get_field($uid);
			$goods_list = M('goods')->field($field)->where($where)->order($sort)->limit($limit)->select();
		}else{
			$field = $this->get_field($uid,'up_goods.');
			$field .= ',up_user_goods.*';
			$goods_list = M('user_goods')->join('up_goods  on up_goods.goods_id = up_user_goods.goods_id')
				->field($field)->where($where)
				//添加group
				->order($sort)->group('up_user_goods.goods_id')->limit($limit)->select();
		};
		
		if($goods_list){
			return $goods_list;
		}else{
			return null;
		}
	}
	/**
	 * 获取上级等级
	 * @param unknown $parent_id
	 * @return \Think\mixed
	 */
	public function get_level($uid){
		$user= M('users')->where(array('user_id'=>$uid))->field('level')->find();
		return $user['level'];
	}
	/**
	 * 获取field 字段
	 * @param unknown $parent_id
	 * @return string
	 */
	public function get_field($uid,$table){

		switch($this->get_level($uid)){
			case 1: $price = "price1 as price,`store_count` as stock";break;
			case 2: $price = "$table`price2` as price";break;
			case 3: $price = "$table`price3` as price";break;
			case 4: $price = "$table`price4` as price";break;
			case 5: $price = "$table`price5` as price";break;
			default: $price = "$table`market_price` as price";break;
		}
		$field = "$table`goods_id` as goodsid,$table`cat_id`,$table`goods_sn`,$table`goods_name`,$table`click_count`,$table`brand_id`,$table`store_count`,$table`comment_count`,
				`weight`,$table`market_price` ,$price,`cost_price`,$table`keywords`,$table`goods_remark`,$table`goods_content`,$table`original_img` ,
				`is_real`,$table`is_on_sale`,$table`is_free_shipping`,$table`on_time`,$table`sort`,$table`is_recommend`,$table`is_new`,$table`is_hot`,$table`last_update` ,
				`goods_type`,$table`spec_type`, `give_integral`,$table`sales_sum`,$table`prom_type`,$table`prom_id`";
		return $field;
	}
	/**
	 * 获取商品图片
	 * @param unknown $goods_id
	 */
	public function get_goodsimg($goods_id){
		return M('GoodsImages')->where("goods_id = $goods_id")->field('image_url')->select();

	}
	/**
	 * 获取商品的规格  价格  不同等级用户返回不同价格
	 * @param 商品id $goods_id
	 * @param 用户等级（购买的人） $level
	 * @return \Think\mixed|boolean  如果存在该规格的商品返回商品规格  对应的价格
	 */
	public function get_spec($goods_id=0,$level=0){
		if($goods_id !=0 && $level !=0 && $level<=5){
			$res = M('SpecGoodsPrice')->field("goods_id,key,key_name,bar_code,price$level")->where("goods_id = $goods_id")->select();
			return $res;
		}else{
			return false;
		}
	}
	/**
	 * 获得用户库存  不同规格的商品视为不同的商品
	 * 在用户购买商品的时候，请先查询库存表 如果有该商品且规格相同，则添加库存，否则添加一条记录
	 */
	public function get_user_store($uid=0){
		return M('UserGoods')->where("uid =$uid")->order('goods_id desc,spec_id')->select();
	}
	/**
	 * 用户购买商品 添加相应库存
	 * @param int $uid  用户id
	 * @param array $info  商品数组 其中必须存在字段 
	 *  goods_id  商品id  
	 * spec_id 规格id   不存在规格 传  0
	 * num  购买数量
	 * 例如  $info = array(1=>array('goods_id'=>32223,'spec_id'=>12,num=>5),2=>array()...)
	 * @return array status  状态值  info 说明 
	 */
	public function buyadd_user_store($uid=0,$parent_id=0,$info=array()){
		if($uid ==0 || count($info)<1){  //购买商品少于1 返回
			$back['status'] = 0;
			$back['info'] ='用户不存在或者购买商品为空';
			return $back;die;
		}else{
			$user_goods = M('UserGoods');
			$flag = true;
			$user_goods->startTrans();
			foreach($info as $key=>$value){
				if($parent_id !=0){
					$flag = $user_goods->where("uid = $parent_id ,goods_id = $value[goods_id],spec_id = $value[spec_key]")->setDec('stock',$value['goods_num']); 
					if(!$flag){break;}  //如出现错误  跳出循环
				}
				$is_have = $user_goods->where("uid = $uid ,goods_id = $value[goods_id],spec_id = $value[spec_key]")->field('id,stock')->find();
				if($is_have){ // 存在该规格商品则添加
					$data['stock'] = $is_have['stock'] + $value['goods_num'];
					$data['up_time'] = time();
					$flag = $user_goods->where("uid = $uid ,goods_id = $value[goods_id],spec_id = $value[spec_key]")->save($data);
				}else{ //不存在该规格商品则添加
					$data['uid'] =$uid;
					$data['goods_id'] = $value['goods_id'];
					$data['spec_id'] =$value['spec_key'];
					$data['stock'] =$value['goods_num'];
					$data['up_time'] = time();
					$flag = $user_goods->add($data);
				}
				if(!$flag){break;}  //如出现错误  跳出循环
			}
			if($flag){
				$user_goods->commit();
				$back['status'] = 1;
				$back['info'] ='添加库存成功';
			}else{
				$user_goods->rollback();
				$back['status'] = 0;
				$back['info'] ='添加库存失败';
			}
			return $back;
		}
	}
	/**
	 * 用户自己更改用户库存或者有购买行为更改库存。注：更改库存只能减少
	 * @param unknown $uid
	 * @param unknown $spec_id
	 * @param unknown $num   更改数量（如减少1个商品则传入1）
	 */
	public function update_user_store($uid=0,$goods_id,$spec_id=0,$num=0){
		$res = M(UserGoods)->where("uid = $uid , goods_id = $goods_id,spec_id = $spec_id")->setDec($num);
	}

	public  function get_type_list(){
	    $value =  M('GoodsAttribute')->find();
	    $val = explode(",", $value['attr_values']);
	    return $value;
	}
}
