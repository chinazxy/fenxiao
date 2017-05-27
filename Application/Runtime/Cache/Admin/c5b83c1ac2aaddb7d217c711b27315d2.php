<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>诚享东方管理后台</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
 	<link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 --
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/Public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
    	folder instead of downloading all of them to reduce the load. -->
    <link href="/Public/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="/Public/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />   
    <!-- jQuery 2.1.4 -->
    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/Public/js/common.js"></script>
    <script src="/Public/js/myFormValidate.js"></script>    
    <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
    <script src="/Public/js/myAjax.js"></script>
    <script type="text/javascript">
    function delfunc(obj){
    	layer.confirm('确认删除？', {
    		  btn: ['确定','取消'] //按钮
    		}, function(){
    		    // 确定
   				$.ajax({
   					type : 'post',
   					url : $(obj).attr('data-url'),
   					data : {act:'del',del_id:$(obj).attr('data-id')},
   					dataType : 'json',
   					success : function(data){
   						if(data==1){
   							layer.msg('操作成功', {icon: 1});
   							$(obj).parent().parent().remove();
   						}else{
   							layer.msg(data, {icon: 2,time: 2000});
   						}
   						layer.closeAll();
   					}
   				})
    		}, function(index){
    			layer.close(index);
    			return false;// 取消
    		}
    	);
    }
    
    function selectAll(name,obj){
    	$('input[name*='+name+']').prop('checked', $(obj).checked);
    }    
    </script>        
  </head>
  <body style="background-color:#ecf0f5;">
 

<!--公共js 代码 --><script src="/Public/js/common.js" charset="utf-8" type="text/javascript"></script><!--公共js end代码 -->
<link href="/Public/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<script src="/Public/plugins/daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="/Public/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>

<!--以下是在线编辑器 代码 -->
<script type="text/javascript">
    /*
	 * 在线编辑器相 关配置 js 
	 *  参考 地址 http://fex.baidu.com/ueditor/
	 */
    window.UEDITOR_Admin_URL = "/Public/plugins/Ueditor/";
    var URL_upload = "<?php echo ($URL_upload); ?>";
    var URL_fileUp = "<?php echo ($URL_fileUp); ?>";
    var URL_scrawlUp = "<?php echo ($URL_scrawlUp); ?>";
    var URL_getRemoteImage = "<?php echo ($URL_getRemoteImage); ?>";
    var URL_imageManager = "<?php echo ($URL_imageManager); ?>";
    var URL_imageUp = "<?php echo ($URL_imageUp); ?>";
    var URL_getMovie = "<?php echo ($URL_getMovie); ?>";
    var URL_home = "<?php echo ($URL_home); ?>";
</script>
<script type="text/javascript" charset="utf-8" src="/Public/plugins/Ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/plugins/Ueditor/ueditor.all.min.js"> </script>
 <script type="text/javascript" charset="utf-8" src="/Public/plugins/Ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">  
  
    var editor;
    $(function () {
        //具体参数配置在  editor_config.js  中
        var options = {
            zIndex: 999,
            initialFrameWidth: "95%", //初化宽度
            initialFrameHeight: 400, //初化高度
            focus: false, //初始化时，是否让编辑器获得焦点true或false
            maximumWords: 99999, removeFormatAttributes: 'class,style,lang,width,height,align,hspace,valign'
            , //允许的最大字符数 'fullscreen',
            pasteplain: true, autoHeightEnabled: true,
            autotypeset: {
                mergeEmptyline: true,        //合并空行
                removeClass: true,           //去掉冗余的class
                removeEmptyline: false,      //去掉空行
                textAlign: "left",           //段落的排版方式，可以是 left,right,center,justify 去掉这个属性表示不执行排版
                imageBlockLine: 'center',    //图片的浮动方式，独占一行剧中,左右浮动，默认: center,left,right,none 去掉这个属性表示不执行排版
                pasteFilter: false,          //根据规则过滤没事粘贴进来的内容
                clearFontSize: false,        //去掉所有的内嵌字号，使用编辑器默认的字号
                clearFontFamily: false,      //去掉所有的内嵌字体，使用编辑器默认的字体
                removeEmptyNode: false,      // 去掉空节点
                                             //可以去掉的标签
                removeTagNames: {"font": 1},
                indent: false,               // 行首缩进
                indentValue: '0em'           //行首缩进的大小
            },
        	toolbars: [
                   ['fullscreen', 'source', '|', 'undo', 'redo',
                       '|', 'bold', 'italic', 'underline', 'fontborder',
                       'strikethrough', 'superscript', 'subscript',
                       'removeformat', 'formatmatch', 'autotypeset',
                       'blockquote', 'pasteplain', '|', 'forecolor',
                       'backcolor', 'insertorderedlist',
                       'insertunorderedlist', 'selectall', 'cleardoc', '|',
                       'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                       'customstyle', 'paragraph', 'fontfamily', 'fontsize',
                       '|', 'directionalityltr', 'directionalityrtl',
                       'indent', '|', 'justifyleft', 'justifycenter',
                       'justifyright', 'justifyjustify', '|', 'touppercase',
                       'tolowercase', '|', 'link', 'unlink', 'anchor', '|',
                       'imagenone', 'imageleft', 'imageright', 'imagecenter',
                       '|', 'insertimage', 'emotion', 'insertvideo',
                       'attachment', 'map', 'gmap', 'insertframe',
                       'insertcode', 'webapp', 'pagebreak', 'template',
                       'background', '|', 'horizontal', 'date', 'time',
                       'spechars', 'wordimage', '|',
                       'inserttable', 'deletetable',
                       'insertparagraphbeforetable', 'insertrow', 'deleterow',
                       'insertcol', 'deletecol', 'mergecells', 'mergeright',
                       'mergedown', 'splittocells', 'splittorows',
                       'splittocols', '|', 'print', 'preview', 'searchreplace']
               ]
        };
        editor = new UE.ui.Editor(options);
        editor.render("goods_content");  //  指定 textarea 的  id 为 goods_content

    }); 
</script>
<!--以上是在线编辑器 代码  end-->



<?php if($goodsInfo[is_promote] != 1): ?><style>
       .is_promote{ display:none;}
    </style><?php endif; ?>

<div class="wrapper">
    <div class="breadcrumbs" id="breadcrumbs">
	<ol class="breadcrumb">
	<?php if(is_array($navigate_admin)): foreach($navigate_admin as $k=>$v): if($k == '后台首页'): ?><li><a href="<?php echo ($v); ?>"><i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo ($k); ?></a></li>
	    <?php else: ?>
	        <li><a href="<?php echo ($v); ?>"><?php echo ($k); ?></a></li><?php endif; endforeach; endif; ?>
	</ol>
</div>

    <section class="content">
        <!-- Main content -->
        <div class="container-fluid">
            <div class="pull-right">

                <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回"><i class="fa fa-reply"></i></a>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-list"></i>商品详情</h3>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_tongyong" data-toggle="tab">通用信息</a></li>
<!--                        <li><a href="#tab_goods_desc" data-toggle="tab">描述信息</a></li>-->
                        <li><a href="#tab_goods_images" data-toggle="tab">商品相册</a></li>
                        <li><a href="#tab_goods_spec" data-toggle="tab">商品规格</a></li>                        
                     <!--<li><a href="#tab_goods_attr" data-toggle="tab">商品属性</a></li>-->
                    </ul>
                    <!--表单数据-->
                    <form method="post" id="addEditGoodsForm">
                    
                        <!--通用信息-->
                    <div class="tab-content">                 	  
                        <div class="tab-pane active" id="tab_tongyong">
                           
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td>商品名称:</td>
                                    <td>
                                        <input type="text" value="<?php echo ($goodsInfo["goods_name"]); ?>" name="goods_name" class="form-control" style="width:350px;"/>
                                        <span id="err_goods_name" style="color:#F00; display:none;"></span>                                        
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>商品简介:</td>
                                    <td>
	                                    <textarea rows="3" cols="50" name="goods_remark"><?php echo ($goodsInfo["goods_remark"]); ?></textarea>
                                        <span id="err_goods_remark" style="color:#F00; display:none;"></span>
                                         
                                    </td>                                                                       
                                </tr> -->
                                <tr>
                                    <td>商品货号</td>
                                    <td>                                                                               
                                        <input type="text" value="<?php echo ($goodsInfo["goods_sn"]); ?>" name="goods_sn" class="form-control" style="width:350px;"/>
                                        <span id="err_goods_sn" style="color:#F00; display:none;"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>商品分类:</td>
                                    <td>
                                      <div class="col-xs-3">
                                   
                                         <?php if(is_array($cat_list)): foreach($cat_list as $k=>$v): if(is_array($goodsInfo["cat_id"])): foreach($goodsInfo["cat_id"] as $key=>$ca): if($ca==$v['id']){ ?>
                                               <input type='checkbox' name='cat_id[]' checked='true' value="<?php echo ($v['id']); ?>"><?php echo ($v['name']); ?>
                                             <?php continue 2;}else{continue 1;} endforeach; endif; ?>
                                             <input type='checkbox' name='cat_id[]' value="<?php echo ($v['id']); ?>"><?php echo ($v['name']); endforeach; endif; ?> 
                                       <!--  <option value="0">请选择商品分类</option>                                      
                                                                                                                                 
                                               <option value="<?php echo ($v['id']); ?>" <?php if($v['id'] == $level_cat['1']): ?>selected="selected"<?php endif; ?> >
                                               		<?php echo ($v['name']); ?>
                                               </option> -->
                                             
                                   
                                      </div>
                                      
                                      <span id="err_cat_id" style="color:#F00; display:none;"></span>                                 
                                    </td>
                                </tr>                                 
<!--
                                <tr>
                                    <td>商品分类:</td>
                                    <td>
                                      <select name="cat_id" id="cat_id" class="form-control" style="width:250px;">
                                        <option value="">所有分类</option>
                                             <?php if(is_array($cat_list)): foreach($cat_list as $k=>$v): ?><option value="<?php echo ($v['id']); ?>" <?php if($v['id'] == $goodsInfo['cat_id'] ): ?>selected="selected"<?php endif; ?> >
                                               		<?php echo str_pad('',($v[level] * 5),'-',STR_PAD_LEFT); ?> <?php echo ($v['name']); ?>
                                               </option><?php endforeach; endif; ?>
                                      </select>                                    
                                    </td>
                                </tr>
-->                                
                                <tr>
                                    <td>商品品牌:</td>
                                    <td>
									<select name="brand_id" id="brand_id" class="form-control" style="width:250px;">
                                       		 <option value="">所有品牌</option>
                                            <?php if(is_array($brandList)): foreach($brandList as $k=>$v): ?><option value="<?php echo ($v['id']); ?>"  <?php if($v['id'] == $goodsInfo['brand_id'] ): ?>selected="selected"<?php endif; ?>>
                                               		<?php echo ($v['name']); ?>
                                               </option><?php endforeach; endif; ?>
                                      </select>                                    
                                    </td>
                                </tr>
                                <!--<tr>-->
                                    <!--<td>公司销售部价:</td>-->
                                    <!--<td>-->
                                       	 <!--<input type="text" value="<?php echo ($goodsInfo["price1"]); ?>" name="price1" class="form-control" style="width:150px;" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" />-->
                                        <!--<span id="err_shop_price" style="color:#F00; display:none;"></span>-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td>特约售价:</td>-->
                                    <!--<td>-->
                                       	 <!--<input type="text" value="<?php echo ($goodsInfo["price2"]); ?>" name="price2" class="form-control" style="width:150px;" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" />-->
                                        <!--<span id="err_shop_price" style="color:#F00; display:none;"></span>-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td>微一售价:</td>-->
                                    <!--<td>-->
                                       	 <!--<input type="text" value="<?php echo ($goodsInfo["price3"]); ?>" name="price3" class="form-control" style="width:150px;" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" />-->
                                        <!--<span id="err_shop_price" style="color:#F00; display:none;"></span>-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td>微二售价:</td>-->
                                    <!--<td>-->
                                       	 <!--<input type="text" value="<?php echo ($goodsInfo["price4"]); ?>" name="price4" class="form-control" style="width:150px;" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" />-->
                                        <!--<span id="err_shop_price" style="color:#F00; display:none;"></span>-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td>微三售价:</td>-->
                                    <!--<td>-->
                                       	 <!--<input type="text" value="<?php echo ($goodsInfo["price5"]); ?>" name="price5" class="form-control" style="width:150px;" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" />-->
                                        <!--<span id="err_shop_price" style="color:#F00; display:none;"></span>-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td>市场价:</td>-->
                                    <!--<td>-->
                                        <!--<input type="text" value="<?php echo ($goodsInfo["market_price"]); ?>" name="market_price" class="form-control" style="width:150px;" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" />-->
                                        <!--<span id="err_market_price" style="color:#F00; display:none;"></span>-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td>成本价:</td>-->
                                    <!--<td>-->
                                        <!--<input type="text" value="<?php echo ($goodsInfo["cost_price"]); ?>" name="cost_price" class="form-control" style="width:150px;" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" />-->
                                        <!--<span id="err_cost_price" style="color:#F00; display:none;"></span>-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <td>上传商品图片:</td>
                                    <td>
                                        <input type="button" value="上传图片"  onclick="GetUploadify(1,'','goods','call_back');"/>
                                        <input type="text" class="input-sm"  name="original_img" id="original_img" value="<?php echo ($goodsInfo["original_img"]); ?>"/>
                                        <?php if($goodsInfo['original_img'] != null): ?>&nbsp;&nbsp;
                                            <a target="_blank" href="<?php echo ($goodsInfo["original_img"]); ?>" id="original_img2">
                                                <img width="25" height="25" src="/Public/images/image_icon.jpg">
                                            </a><?php endif; ?>
                                        <span id="err_original_img" style="color:#F00; display:none;"></span>					                                        
                                    </td>
                                </tr>                                 
                                <!-- <tr>
                                    <td>商品重量:</td>
                                    <td>
                                        <input type="text" class="form-control" style="width:150px;" value="<?php echo ($goodsInfo["weight"]); ?>" name="weight" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" />&nbsp;克 (以克为单位)
                                        <span id="err_weight" style="color:#F00; display:none;"></span>					                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>是否包邮:</td>
                                    <td>
                                        是:<input type="radio" <?php if($goodsInfo[is_free_shipping] == 1): ?>checked="checked"<?php endif; ?> value="1" name="is_free_shipping" /> 
                                        否:<input type="radio" <?php if($goodsInfo[is_free_shipping] == 0): ?>checked="checked"<?php endif; ?> value="0" name="is_free_shipping" /> 
                                    </td>
                                </tr> -->                                
                                <!--<tr>-->
                                    <!--<td>库存数量:</td>-->
                                    <!--<td>-->
                                        <!--<?php if($goodsInfo[goods_id] > 0): ?>-->
                                            <!--<input type="text" value="<?php echo ($goodsInfo["store_count"]); ?>" class="form-control" style="width:150px;" name="store_count" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" />-->
                                        <!--<?php else: ?>-->
                                            <!--<input type="text" value="<?php echo ($upshop_config[basic_default_storage]); ?>" class="form-control" style="width:150px;" name="store_count" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" />                                         -->
                                        <!--<?php endif; ?>-->
                                        <!-- -->
                                        <!--<span id="err_store_count" style="color:#F00; display:none;"></span>					                                        -->
                                    <!--</td>-->
                                <!--</tr>-->
                                <!--<tr>
                                    <td>赠送积分:</td>
                                    <td>
                                        <input type="text" class="form-control" style="width:150px;" value="<?php echo ($goodsInfo["give_integral"]); ?>" name="give_integral" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" />
                                        <span id="err_give_integral" style="color:#F00; display:none;"></span>					                                        
                                    </td>
                                </tr>                                 
                                
                                <tr>
                                    <td>设置:</td>
                                    <td>
                                    	<input type="checkbox" checked="checked" value="<?php echo ($goodsInfo["is_on_sale"]); ?>" name="is_on_sale"/> 上架&nbsp;&nbsp;
	                                <input type="checkbox" checked="checked" value="<?php echo ($goodsInfo["is_free_shipping"]); ?>" name="is_free_shipping"/> 包邮&nbsp;&nbsp;
                                        <input type="checkbox" checked="checked" value="<?php echo ($goodsInfo["is_recommend"]); ?>" name="is_recommend"/>推荐&nbsp;&nbsp;
                                        <input type="checkbox" checked="checked" value="<?php echo ($goodsInfo["is_new"]); ?>" name="is_new"/>新品&nbsp;&nbsp;
                                    </td>
                                </tr>
                                -->
                                <tr>
                                    <td>商品关键词:</td>
                                    <td>
                                        <input type="text" class="form-control" style="width:350px;" value="<?php echo ($goodsInfo["keywords"]); ?>" name="keywords"/>用空格分隔
                                        <span id="err_keywords" style="color:#F00; display:none;"></span>
                                    </td>
                                </tr>                                    
                                <tr>
                                    <td>商品详情描述:</td>
                                    <td width="85%">
										<textarea class="span12 ckeditor" id="goods_content" name="goods_content" title=""><?php echo ($goodsInfo["goods_content"]); ?></textarea>
                                        <span id="err_goods_content" style="color:#F00; display:none;"></span>                                         
                                    </td>                                                                       
                                </tr>   
                                </tbody>                                
                                </table>
                        </div>
                         <!--其他信息-->
                         
                        <!-- 商品相册-->
                        <div class="tab-pane" id="tab_goods_images">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>                                    
                                    <td>                                    
                                    <?php if(is_array($goodsImages)): foreach($goodsImages as $k=>$vo): ?><div style="width:100px; text-align:center; margin: 5px; display:inline-block;" class="goods_xc">
                                            <input type="hidden" value="<?php echo ($vo['image_url']); ?>" name="goods_images[]">
                                            <a onclick="" href="<?php echo ($vo['image_url']); ?>" target="_blank"><img width="100" height="100" src="<?php echo ($vo['image_url']); ?>"></a>
                                            <br>
                                            <a href="javascript:void(0)" onclick="ClearPicArr2(this,'<?php echo ($vo['imgage_url']); ?>')">删除</a>
                                        </div><?php endforeach; endif; ?>
                                    
                                        <div class="goods_xc" style="width:100px; text-align:center; margin: 5px; display:inline-block;">
                                            <input type="hidden" name="goods_images[]" value="" />
                                            <a href="javascript:void(0);" onclick="GetUploadify(10,'','goods','call_back2');"><img src="/Public/images/add-button.jpg" width="100" height="100" /></a>
                                            <br/>
                                            <a href="javascript:void(0)">&nbsp;&nbsp;</a>
                                        </div>                                        
                                    </td>
                                </tr>                                              
                                </tbody>
                            </table>
                        </div>
                         <!--商品相册--> 
   
                        <!-- 商品规格-->
                        <div class="tab-pane" id="tab_goods_spec">
                            <table class="table table-bordered" id="goods_spec_table">
                                <tr>
                                    <td>商品类型:</td>
                                    <td>
                                      <select name="spec_type" id="spec_type" class="form-control" style="width:250px;">
                                        <option value="0">选择商品类型</option>
                                        <?php if(is_array($goodsType)): foreach($goodsType as $k=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"<?php if($goodsInfo[spec_type] == $vo[id]): ?>selected="selected"<?php endif; ?> ><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                                      </select>
                                    </td>
                                </tr>

                            </table>
                            <div id="ajax_spec_data"><!-- ajax 返回规格--></div>
                        </div>
                        <!-- 商品规格-->

                        <!-- 商品属性-->
                        <!--<div class="tab-pane" id="tab_goods_attr">-->
                            <!--<table class="table table-bordered" id="goods_attr_table">                                -->
                                <!--<tr>-->
                                    <!--<td>商品属性:</td>-->
                                    <!--<td>                                        -->
                                      <!--<select name="goods_type" id="goods_type" class="form-control" style="width:250px;">-->
                                        <!--<option value="0">选择商品属性</option>-->
                                        <!--<?php if(is_array($goodsType)): foreach($goodsType as $k=>$vo): ?>-->
                                            <!--<option value="<?php echo ($vo["id"]); ?>"<?php if($goodsInfo[goods_type] == $vo[id]): ?>selected="selected"<?php endif; ?> ><?php echo ($vo["name"]); ?></option>-->
                                        <!--<?php endforeach; endif; ?>                                        -->
                                      <!--</select>-->
                                    <!--</td>-->
                                <!--</tr>                                -->
                            <!--</table>-->
                        <!--</div>-->
                        <!-- 商品属性-->                                
                    </div>              
                    <div class="pull-right">
                        <input type="hidden" name="goods_id" value="<?php echo ($goodsInfo["goods_id"]); ?>">
                        <button  class="btn btn-primary" onclick="ajax_submit_form('addEditGoodsForm','<?php echo U('Goods/addEditGoods?is_ajax=1');?>');" title="" data-toggle="tooltip" type="button" data-original-title="保存">保存</button>
                    </div>
			    </form><!--表单数据-->
                </div>
            </div>
        </div>    <!-- /.content -->
    </section>
</div>




<script>
    /*
     * 以下是图片上传方法
     */
 
    // 上传商品图片成功回调函数
    function call_back(fileurl_tmp){
        $("#original_img").val(fileurl_tmp);
    	$("#original_img2").attr('href', fileurl_tmp);
    }
 
    // 上传商品相册回调函数
    function call_back2(paths){
        
        var  last_div = $(".goods_xc:last").prop("outerHTML");	
        for (i=0;i<paths.length ;i++ )
        {                    
            $(".goods_xc:eq(0)").before(last_div);	// 插入一个 新图片
                $(".goods_xc:eq(0)").find('a:eq(0)').attr('href',paths[i]).attr('onclick','').attr('target', "_blank");// 修改他的链接地址
            $(".goods_xc:eq(0)").find('img').attr('src',paths[i]);// 修改他的图片路径
                $(".goods_xc:eq(0)").find('a:eq(1)').attr('onclick',"ClearPicArr2(this,'"+paths[i]+"')").text('删除');
            $(".goods_xc:eq(0)").find('input').val(paths[i]); // 设置隐藏域 要提交的值
        } 			   
    }
    /*
     * 上传之后删除组图input     
     * @access   public
     * @val      string  删除的图片input
     */
    function ClearPicArr2(obj,path)
    {
    	$.ajax({
                    type:'GET',
                    url:"<?php echo U('Admin/Uploadify/delupload');?>",
                    data:{action:"del", filename:path},
                    success:function(){
                                  $(obj).parent().remove(); // 删除完服务器的, 再删除 html上的图片				 
                    }
		});
    }
 


/** 以下 商品属性相关 js*/
$(document).ready(function(){
	
    // 商品类型切换时 ajax 调用  返回不同的属性输入框
    $("#goods_type").change(function(){        
        var goods_id = $("input[name='goods_id']").val();
        var type_id = $(this).val();
            $.ajax({
                    type:'GET',
                    data:{goods_id:goods_id,type_id:type_id}, 
                    url:"/index.php/admin/Goods/ajaxGetAttrInput",
                    success:function(data){                            
                            $("#goods_attr_table tr:gt(0)").remove()
                            $("#goods_attr_table").append(data);
                    }        
            });			                
    });
	// 触发商品类型
	$("#goods_type").trigger('change');
});
 

// 属性输入框的加减事件
function addAttr(a)
{
	var attr = $(a).parent().parent().prop("outerHTML");	
	attr = attr.replace('addAttr','delAttr').replace('+','-');	
	$(a).parent().parent().after(attr);
}
// 属性输入框的加减事件
function delAttr(a)
{
   $(a).parent().parent().remove();
}
 

/** 以下 商品规格相关 js*/
$(document).ready(function(){
	
    // 商品类型切换时 ajax 调用  返回不同的属性输入框
    $("#spec_type").change(function(){        
        var goods_id = '<?php echo ($goodsInfo["goods_id"]); ?>';
        var spec_type = $(this).val();
            $.ajax({
                    type:'GET',
                    data:{goods_id:goods_id,spec_type:spec_type}, 
                    url:"<?php echo U('admin/Goods/ajaxGetSpecSelect');?>",
                    success:function(data){                            
                           $("#ajax_spec_data").html('')
                           $("#ajax_spec_data").append(data);
						   //alert('132');
						   ajaxGetSpecInput();	// 触发完  马上处罚 规格输入框
                    }
            });			                
    });
	// 触发商品规格
	$("#spec_type").trigger('change'); 
});



/** 以下是编辑时默认选中某个商品分类*/
$(document).ready(function(){

	<?php if($level_cat['2'] > 0): ?>// 商品分类第二个下拉菜单
		 get_category('<?php echo ($level_cat[1]); ?>','cat_id_2','<?php echo ($level_cat[2]); ?>');<?php endif; ?>
	<?php if($level_cat['3'] > 0): ?>// 商品分类第二个下拉菜单
		 get_category('<?php echo ($level_cat[2]); ?>','cat_id_3','<?php echo ($level_cat[3]); ?>');<?php endif; ?>

});

</script>
</body>
</html>