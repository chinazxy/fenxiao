<?php
namespace Mobile\Controller;
use Home\Logic\CartLogic;
use Think\Controller;
use Think\Page;
use Think\Verify;
class ArticleController extends PublicController {
    public function index(){       
        $article_id = I('article_id',1);
    	$article = D('article')->where("article_id=$article_id")->find();
    	$article['time']  = date('Y-m-d ',$article['publish_time']);
    	$article['content'] = htmlspecialchars_decode($article['content']);
    	$this->assign('article',$article);
        $this->display();
    }
 

    /**
     * 文章内列表页
     */
    public function articleList(){        
        $list = M('ArticleCat')->where("cat_alias='new'")->find();
        $this->assign('list',$list);
        $aticle = M('Article')->where(array('cat_id'=>$list['cat_id'],'is_open'=>1))->order('publish_time desc')->select();
       
        foreach ($aticle as $key=>$val){
            $aticle[$key]['content'] = htmlspecialchars_decode($val['content']);
        }
        $this->assign('article',$aticle);
        $this->display('new');
    }    
    /**
     * 文章内容页
     */
    public function article(){
    	$article_id = I('article_id',1);
    	$article = D('article')->where("article_id=$article_id")->find();
    	$article['content'] = htmlspecialchars_decode($article['content']);
    	$this->assign('article',$article);
        $this->display('index');
    }     
}