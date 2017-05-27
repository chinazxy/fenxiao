<?php
namespace Mobile\Controller;
use Mobile\Logic\GoodsLogic;
use Think\AjaxPage;
use Think\Page;
use Mobile\Model\UserGoodsModel;

class GoodsController extends PublicController{
    public $pagesize =6;
    public function _initialize(){
        parent::_initialize();
    }
    public function index(){
       // $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
        $this->display();
    }

    /**
     * 分类列表显示
     */
    public function categoryList(){
        $this->display();
    }
    
    public function brandGoodsList(){
        $user = $this->user;
        $brand_id = I('get.id');
        $keyword = I('keyword');
        $goods = D('UserGoods');
        $cate_id = I('cate_id');
        $this->assign('id',$brand_id);
        $brandList =array();
        $order = I('order',0);
        if(!empty($keyword)){
            $keywordExist = M('Keyword')->where(array('keyword'=>$keyword))->find();
            if(empty($keywordExist)){
                $keymap = array(
                   'keyword'=>$keyword
                );
                M('Keyword')->add($keymap);
            }else{
                $keywordExist['times'] = $keywordExist['times']+1;
                M('Keyword')->where(array('keyword'=>$keyword))->save(array('times'=>$keywordExist['times']));
            }
        }
        $this->assign('order',$order);
        $this->assign('cate_id',$cate_id);
        $this->assign('keyword',$keyword);
        if($order==0){
            $order ="goods_id DESC";
        }else if($order ==1){
            $order = "price".$user['level']." ASC";
        }else if($order==2){
            $order = "price".$user['level']." DESC";
        }  
        $page = I('page',1);
        $limit = ($page-1)*$this->pagesize.",".$this->pagesize;
        //$uid,$parent_id=0,$goods_id='',$cat_id='',$brand_id='',$is_what='',$keyword='',$sort='sort',$limit=''
        $brandList = $goods->get_goods($user['user_id'],$user['parent_id'],'',$cate_id,$brand_id,"",$keyword,$order,$limit);
      
        $spec = D('SpecGoodsPrice');
        /*   foreach ($result as $key=>$val){
          if(is_numeric($brand_id)){
                if($val['brand_id']==$brand_id){ 
                    if(is_numeric($cate_id)){
                        if (is_numeric(strpos($val['cat_id'], $cate_id))){
                            $brandList[] = $val;
                        }
                    }else{
                        $brandList[] = $val;
                    }
                }
            }else if(!empty($keyword)){
                if(strpos($val['goods_name'], $keyword)||strpos($val['keywords'], $keyword)){
                    $brandList[] = $val;
                }
            }else if(is_numeric($cate_id)){
                if (is_numeric(strpos($val['cat_id'], $cate_id))){
                    $brandList[] = $val;
                }
            }else{ 
                $brandList[] = $val;
         //   }
        }*/
        
        foreach ($brandList as $key=>$val){
            
            $brandList[$key]['goods_id'] = $val['goodsid'];
            $ret = $spec->where(array('goods_id'=>$val['goodsid']))->count();
            $rspec = $spec->where(array('goods_id'=>$val['goodsid']))->order('price1 asc')->find();
            if(empty($ret)||empty($rspec)){
                $ret = 0;
                $rspec[key]=0;
            }
            if(!empty($user)){
                $brandList[$key]['price'] = $rspec['price'.$user['level']];
            }else{
                $brandList[$key]['price'] = $rspec['price'];
            }
            $brandList[$key]['spec'] = $ret;
            $brandList[$key]['resp'] = $rspec['key'];
        }
        $result  =  $goods->get_type_list();
        if(IS_AJAX){
            if(!empty($brandList)){
                $this->ajaxReturn(array('status'=>1000,'data'=>$brandList));
            }
            $this->ajaxReturn(array('status'=>1001,'data'=>'没有更多了'));
        }
        $this->assign('id',$brand_id);
        $this->assign('hot_goods',$brandList);
        $this->display('bgoods');
    }
    
    
    /**
     * 商品列表页
     */
    public function goodsList(){
    	
    	$filter_param = array(); // 帅选数组
    	$id = I('get.id',1); // 当前分类id
    	$brand_id = I('brand_id',0);
    	$spec = I('spec',0); // 规格
    	$attr = I('attr',''); // 属性
    	$sort = I('sort','goods_id'); // 排序
    	$sort_asc = I('sort_asc','asc'); // 排序
    	$price = I('price',''); // 价钱
    	$start_price = trim(I('start_price','0')); // 输入框价钱
    	$end_price = trim(I('end_price','0')); // 输入框价钱
    	if($start_price && $end_price) $price = $start_price.'-'.$end_price; // 如果输入框有价钱 则使用输入框的价钱   	 
    	$filter_param['id'] = $id; //加入帅选条件中
    	$brand_id  && ($filter_param['brand_id'] = $brand_id); //加入帅选条件中
    	$spec  && ($filter_param['spec'] = $spec); //加入帅选条件中
    	$attr  && ($filter_param['attr'] = $attr); //加入帅选条件中
    	$price  && ($filter_param['price'] = $price); //加入帅选条件中
         
    	$goodsLogic = new \Home\Logic\GoodsLogic(); // 前台商品操作逻辑类
    	// 分类菜单显示
    	$goodsCate = M('GoodsCategory')->where("id = $id")->find();// 当前分类
    	//($goodsCate['level'] == 1) && header('Location:'.U('Home/Channel/index',array('cat_id'=>$id))); //一级分类跳转至大分类馆
    	$cateArr = $goodsLogic->get_goods_cate($goodsCate);
    	 
    	// 帅选 品牌 规格 属性 价格
    	$cat_id_arr = getCatGrandson ($id);
        
    	$filter_goods_id = M('goods')->where("is_on_sale=1 and cat_id in(".  implode(',', $cat_id_arr).") ")->cache(true)->getField("goods_id",true);
    	
    	// 过滤帅选的结果集里面找商品
    	if($brand_id || $price)// 品牌或者价格
    	{
    		$goods_id_1 = $goodsLogic->getGoodsIdByBrandPrice($brand_id,$price); // 根据 品牌 或者 价格范围 查找所有商品id
    		$filter_goods_id = array_intersect($filter_goods_id,$goods_id_1); // 获取多个帅选条件的结果 的交集
    	}
    	if($spec)// 规格
    	{
    		$goods_id_2 = $goodsLogic->getGoodsIdBySpec($spec); // 根据 规格 查找当所有商品id
    		$filter_goods_id = array_intersect($filter_goods_id,$goods_id_2); // 获取多个帅选条件的结果 的交集
    	}
    	if($attr)// 属性
    	{
    		$goods_id_3 = $goodsLogic->getGoodsIdByAttr($attr); // 根据 规格 查找当所有商品id
    		$filter_goods_id = array_intersect($filter_goods_id,$goods_id_3); // 获取多个帅选条件的结果 的交集
    	}
    	 
    	$filter_menu  = $goodsLogic->get_filter_menu($filter_param,'goodsList'); // 获取显示的帅选菜单
    	$filter_price = $goodsLogic->get_filter_price($filter_goods_id,$filter_param,'goodsList'); // 帅选的价格期间
    	$filter_brand = $goodsLogic->get_filter_brand($filter_goods_id,$filter_param,'goodsList',1); // 获取指定分类下的帅选品牌
    	$filter_spec  = $goodsLogic->get_filter_spec($filter_goods_id,$filter_param,'goodsList',1); // 获取指定分类下的帅选规格
    	$filter_attr  = $goodsLogic->get_filter_attr($filter_goods_id,$filter_param,'goodsList',1); // 获取指定分类下的帅选属性
    	
    	$count = count($filter_goods_id);
    	$page = new Page($count,4);
    	if($count > 0)
    	{
    		$goods_list = M('goods')->where("goods_id in (".  implode(',', $filter_goods_id).")")->order("$sort $sort_asc")->limit($page->firstRow.','.$page->listRows)->select();
    		$filter_goods_id2 = get_arr_column($goods_list, 'goods_id');
    		if($filter_goods_id2)
    			$goods_images = M('goods_images')->where("goods_id in (".  implode(',', $filter_goods_id2).")")->cache(true)->select();
    	}
    	$goods_category = M('goods_category')->where('is_show=1')->cache(true)->getField('id,name,parent_id,level'); // 键值分类数组
    	$this->assign('goods_list',$goods_list);
    	$this->assign('goods_category',$goods_category);
    	$this->assign('goods_images',$goods_images);  // 相册图片
    	$this->assign('filter_menu',$filter_menu);  // 帅选菜单
    	$this->assign('filter_spec',$filter_spec);  // 帅选规格
    	$this->assign('filter_attr',$filter_attr);  // 帅选属性
    	$this->assign('filter_brand',$filter_brand);// 列表页帅选属性 - 商品品牌
    	$this->assign('filter_price',$filter_price);// 帅选的价格期间
    	$this->assign('goodsCate',$goodsCate);
    	$this->assign('cateArr',$cateArr);
    	$this->assign('filter_param',$filter_param); // 帅选条件
    	$this->assign('cat_id',$id);
    	$this->assign('page',$page);// 赋值分页输出
    	$this->assign('sort_asc', $sort_asc == 'asc' ? 'desc' : 'asc');
    	C('TOKEN_ON',false);
        
        if($_GET['is_ajax'])
            $this->display('ajaxGoodsList');
        else
            $this->display();
    }

    /**
     * 商品列表页 ajax 翻页请求 搜索
     */
    public function ajaxGoodsList() {
        $where ='';

        $cat_id  = I("id",0); // 所选择的商品分类id
        if($cat_id > 0)
        {
            $grandson_ids = getCatGrandson($cat_id);
            $where .= " WHERE cat_id in(".  implode(',', $grandson_ids).") "; // 初始化搜索条件
        }

        $Model  = new \Think\Model();
        $result = $Model->query("select count(1) as count from __PREFIX__goods $where ");
        $count = $result[0]['count'];
        $page = new AjaxPage($count,10);

        $order = " order by goods_id desc"; // 排序
        $limit = " limit ".$page->firstRow.','.$page->listRows;
        $list = $Model->query("select *  from __PREFIX__goods $where $order $limit");

        $this->assign('lists',$list);
        $html = $this->fetch('ajaxGoodsList'); //$this->display('ajax_goods_list');
       exit($html);
    }

    /**
     * 商品详情页
     */
    public function goodsInfo(){
        C('TOKEN_ON',true);
       
        $goodsLogic = new \Home\Logic\GoodsLogic();
        $goods_id = I("get.id");
        $goods = M('Goods')->where("goods_id = $goods_id")->find();
      
        $goods = D('UserGoods')->get_goods($user['user_id'],$user['parent_id'],$goods_id);
        $goods[0]['shop_price'] = $goods[0]['price'];
        $goods = $goods[0];
        if(empty($goods)){
        	$this->tp404('此商品不存在或者已下架');
        }
        if($goods['brand_id']){
            $brnad = M('brand')->where("id =".$goods['brand_id'])->find();
            $goods['brand_name'] = $brnad['name'];
        }
        $goods_images_list = M('GoodsImages')->where("goods_id = $goods_id")->select(); // 商品 图册        
        $goods_attribute = M('GoodsAttribute')->getField('attr_id,attr_name'); // 查询属性
        $goods_attr_list = M('GoodsAttr')->where("goods_id = $goods_id")->select(); // 查询商品属性表                        
		$filter_spec = $goodsLogic->get_spec($goods_id);  
        $goodsModel = new UserGoodsModel();
        $level = $this->user['level'];
        $price = 'price'.$level;
        $spec_goods_price  = M('spec_goods_price')->where("goods_id = $goods_id")->getField("key,$price as price,store_count"); // 规格 对应 价格 库存表
        //M('Goods')->where("goods_id=$goods_id")->save(array('click_count'=>$goods['click_count']+1 )); //统计点击数
       
    
        $this->assign('spec_goods_price', json_encode($spec_goods_price,true)); // 规格 对应 价格 库存表
      	$goods['sale_num'] = M('order_goods')->where("goods_id=$goods_id and is_send=1")->count();
       
        $this->assign('goods_attribute',$goods_attribute);//属性值    
       
        $this->assign('goods_attr_list',$goods_attr_list);//属性列表
        $this->assign('filter_spec',$filter_spec);//规格参数
        $this->assign('goods_images_list',$goods_images_list);//商品缩略图
		$goods['discount'] = round($goods['shop_price']/$goods['market_price'],2)*10;
		
		if(I('ajax')==1){
		    $spec = M('spec_goods_price')->where("goods_id = $goods_id")->field("goods_id,key,key_name,$price as price,store_count")->select();
		    $parent_id = $this->user['parent_id'];
		    $arr = array();
		    foreach ($spec as $k=>$v){
		        $maps  = "goods_id = $goods_id and uid = $parent_id and spec_id = {$v['key']}";
		        $tmp = M('UserGoods')->where($maps)->find();
		        $arr[$k] = $v;
		        if(empty($tmp)){
		            $arr[$k]['store_count'] = 0;
		        }else{
		            $arr[$k]['store_count'] =$tmp['stock'];
		        }
		    }
          
		    $this->ajaxReturn(array(
		        'goods'=>$goods,
		        'spec'=>$arr//M('spec_goods_price')->where("goods_id = $goods_id")->field("goods_id,key,key_name,$price as price,store_count")->select(),
		        
		    ));
		    exit();
		}
        $this->assign('goods',$goods);
        $this->display('productDetails');
    }

    /**
     * 商品详情页
     */
    public function productDetails(){
        //  form表单提交
        C('TOKEN_ON',true);
        $goodsLogic = new UserGoodsModel();
      
        $goods_id = I("get.id");
       // $goods_id = 11;
        $user  = session('user');
        $uid = $user['user_id'];
        $parent_id = M('users')->where(array('user_id'=>$uid))->getField('parent_id');
       
        $goods_info = $goodsLogic->get_goods($uid,$parent_id,$goods_id);
        $goods_info[0]['goods_id'] = $goods_id;
        $goods_type = M('goods_attr')->where(array('id'=>$goods_id))->getField('attr_value');
      
        $goods_img = M('goods_images')->where(array('goods_id'=>$goods_id))->select();
    
        $level = $user['level'];
        $price = 'price'.$level;
       
        $spc = M('spec_goods_price')->where(array('goods_id'=>$goods_id))->field('goods_id,key,key_name,'.$price )->select();
        $parent_id = $this->user['parent_id'];
        if (!$parent_id){
            $parent_id = '';
        }
        $tmp = array();
        $gui ='';
        foreach($spc as $key=>$vo){
            $tmp[] = $vo[$price];
            $arr = explode(':',$vo['key_name']);
            $spc[$key]['tmp'] = $arr[1];
            $gui .= $arr[1].' ';//规格
            $maps =array(
                'goods_id'=>$goods_id,
                'uid'=>$parent_id,
                'spec_id'=>$vo['key']
            );
            $tmp = M('UserGoods')->where($maps)->find();
          
            if(empty($tmp)){
                $spc[$key]['store_count'] = 0;
            }else{
                $spc[$key]['store_count'] =$tmp['stock'];
            }
        }
       
       /*  $spc[] = $tmp1;
       dump($spc);exit; */
      /*   $max = array_search(max($tmp), $tmp);
        $min = array_search(min($tmp), $tmp);
        if($max == $min){  */
        $total = $spc[0][$price];
      /*     }else{
            $total = '¥'.$tmp[$min].' ~ ¥'.$tmp[$max];
        }   */
        
        $goods_images_list = M('GoodsImages')->where("goods_id = $goods_id")->select(); // 商品 图册
      
      //  dump($goods_images_list);
        $this->assign('goods_img',$goods_images_list);
        $this->assign('goods',$goods_info[0]);
        $this->assign('img',$goods_img['image_url']);
        $this->assign('type',$goods_type);
        $this->assign('spc',$spc);
        $this->assign('price',$price);
        $this->assign('total',$total);
        $this->assign('gui',$gui);
        $this->display('productDetails');
      
    }

    /*
     * 商品评论
     */
    public function comment(){
        $goods_id = I("goods_id",'0');
        $this->assign('goods_id',$goods_id);
        $this->display();
    }

    /*
     * ajax获取商品评论
     */
    public function ajaxComment(){        
        $goods_id = I("goods_id",'0');        
        $commentType = I('commentType','1'); // 1 全部 2好评 3 中评 4差评
        if($commentType==5){
        	$where = "goods_id = $goods_id and parent_id = 0 and img !='' ";
        }else{
        	$typeArr = array('1'=>'0,1,2,3,4,5','2'=>'4,5','3'=>'3','4'=>'0,1,2');
        	$where = "goods_id = $goods_id and parent_id = 0 and ceil((deliver_rank + goods_rank + service_rank) / 3) in($typeArr[$commentType])";
        }
        $count = M('Comment')->where($where)->count();                
        
        $page = new AjaxPage($count,5);
        $show = $page->show();        
        $list = M('Comment')->where($where)->order("add_time desc")->limit($page->firstRow.','.$page->listRows)->select();
        $replyList = M('Comment')->where("goods_id = $goods_id and parent_id > 0")->order("add_time desc")->select();
        
        foreach($list as $k => $v){
            $list[$k]['img'] = unserialize($v['img']); // 晒单图片            
        }        
        $this->assign('commentlist',$list);// 商品评论
        $this->assign('replyList',$replyList); // 管理员回复
        $this->assign('page',$show);// 赋值分页输出        
        $this->display();        
    }
    
    /*
     * 获取商品规格
     */
    public function goodsAttr(){
        $goods_id = I("get.goods_id",'0');
        $goods_attribute = M('GoodsAttribute')->getField('attr_id,attr_name'); // 查询属性
        $goods_attr_list = M('GoodsAttr')->where("goods_id = $goods_id")->select(); // 查询商品属性表
        $this->assign('goods_attr_list',$goods_attr_list);
        $this->assign('goods_attribute',$goods_attribute);
       /*  dump($goods_attribute);
        dump($goods_attr_list);
        exit(); */
        $this->display();
    }
     /**
     * 商品搜索列表页
     */
    public function search(){
    	
    	$filter_param = array(); // 帅选数组
    	$id = I('get.id',0); // 当前分类id
    	$brand_id = I('brand_id',0);    	    	
    	$sort = I('sort','goods_id'); // 排序
    	$sort_asc = I('sort_asc','asc'); // 排序
    	$price = I('price',''); // 价钱
    	$start_price = trim(I('start_price','0')); // 输入框价钱
    	$end_price = trim(I('end_price','0')); // 输入框价钱
    	if($start_price && $end_price) $price = $start_price.'-'.$end_price; // 如果输入框有价钱 则使用输入框的价钱   	 
    	$filter_param['id'] = $id; //加入帅选条件中
    	$brand_id  && ($filter_param['brand_id'] = $brand_id); //加入帅选条件中    	    	
    	$price  && ($filter_param['price'] = $price); //加入帅选条件中
        $q = urldecode(trim(I('q',''))); // 关键字搜索
        $q  && ($_GET['q'] = $filter_param['q'] = $q); //加入帅选条件中
        if(empty($q))
            $this->error ('请输入搜索关键词');
        
    	$goodsLogic = new \Home\Logic\GoodsLogic(); // 前台商品操作逻辑类    	     
    	$filter_goods_id = M('goods')->where("is_on_sale=1 and goods_name like '%{$q}%'  ")->cache(true)->getField("goods_id",true);
    	
    	// 过滤帅选的结果集里面找商品
    	if($brand_id || $price)// 品牌或者价格
    	{
    		$goods_id_1 = $goodsLogic->getGoodsIdByBrandPrice($brand_id,$price); // 根据 品牌 或者 价格范围 查找所有商品id
    		$filter_goods_id = array_intersect($filter_goods_id,$goods_id_1); // 获取多个帅选条件的结果 的交集
    	}
    	  
    	$filter_menu  = $goodsLogic->get_filter_menu($filter_param,'goodsList'); // 获取显示的帅选菜单
    	$filter_price = $goodsLogic->get_filter_price($filter_goods_id,$filter_param,'goodsList'); // 帅选的价格期间
    	$filter_brand = $goodsLogic->get_filter_brand($filter_goods_id,$filter_param,'goodsList',1); // 获取指定分类下的帅选品牌    	 
    	
    	$count = count($filter_goods_id);
    	$page = new Page($count,4);
    	if($count > 0)
    	{
    		$goods_list = M('goods')->where("goods_id in (".  implode(',', $filter_goods_id).")")->order("$sort $sort_asc")->limit($page->firstRow.','.$page->listRows)->select();
    		$filter_goods_id2 = get_arr_column($goods_list, 'goods_id');
    		if($filter_goods_id2)
    			$goods_images = M('goods_images')->where("goods_id in (".  implode(',', $filter_goods_id2).")")->cache(true)->select();
    	}
    	$goods_category = M('goods_category')->where('is_show=1')->cache(true)->getField('id,name,parent_id,level'); // 键值分类数组
    	$this->assign('goods_list',$goods_list);
    	$this->assign('goods_category',$goods_category);
    	$this->assign('goods_images',$goods_images);  // 相册图片
    	$this->assign('filter_menu',$filter_menu);  // 帅选菜单     
    	$this->assign('filter_brand',$filter_brand);// 列表页帅选属性 - 商品品牌
    	$this->assign('filter_price',$filter_price);// 帅选的价格期间
    	$this->assign('goodsCate',$goodsCate);    	
    	$this->assign('filter_param',$filter_param); // 帅选条件    	
    	$this->assign('page',$page);// 赋值分页输出
    	$this->assign('sort_asc', $sort_asc == 'asc' ? 'desc' : 'asc');
    	C('TOKEN_ON',false);
        
        if($_GET['is_ajax'])
            $this->display('ajaxGoodsList');
        else
            $this->display();
    }
    
    /**
     * 商品搜索列表页
     */
    public function ajaxSearch()
    {

    }    
}