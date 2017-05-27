<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="robots" content="index,follow" />
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="format-detection" content="telphone=no, email=no" />
    <meta name="renderer" content="webkit">
    <meta name="keywords" content="cchen" />
    <meta name="description" content="诚享东方经销商下单系统" />
    <meta name="author" content="cchen, 719857499@qq.com" />
    <meta name="x5-page-mode" content="app">
    <title>选择等级</title>
    <!-- 通用类 -->
    <link rel="stylesheet" href="/Public/jd/css/reset.css">
    <link rel="stylesheet" href="/Public/jd/css/bootstrap3.min.css">
    <!-- 插件类 独立性 -->
    <link rel="stylesheet" href="/Public/jd/css/plugin.css">
    <!-- 所有页面类 -->
    <link rel="stylesheet" href="/Public/jd/css/chencc.css">

    <style>
        html{min-height:100%;}
        .cc-btn.cc-lg:link{color:#720E7E;}
        .close_box{text-align:right;margin:-10px 0 0 0;padding-right:10px;}
        .close_box .ccslider-close{display:inline-block;}
        .ccslider-content{}
        .ccslider-content .col-xs-12{font-size:12px;}
    </style>
</head>
<body class="body-bg">
<!-- 空白填充 -->
<div style="height:30px;"></div>
<!-- 等级 -->
<div class="level">
    <?php if(is_array($levelList)): foreach($levelList as $key=>$le): if(empty($level)){ ?>
        <div class="level-item">
            <div class="level-name"><?php echo ($le["level_name"]); ?></div>
            <div class="level-text"><?php echo ($le["describe"]); ?></div>
            <input type='hidden' value="<?php echo ($le["level_id"]); ?>" class="level_id" />
        </div>
        <?php }else{ if($level['level_id']==$le['level_id']){ ?>
        <div class="level-item">
            <div class="level-name"><?php echo ($le["level_name"]); ?></div>
            <div class="level-text"><?php echo ($le["describe"]); ?></div>
            <input type='hidden' value="<?php echo ($le["level_id"]); ?>" class="level_id" />
        </div>
        <?php break; }} endforeach; endif; ?>
</div>
<!-- 侧边栏 -->
<div class="ccslider">
    <div class="ccslider-content">
        <div class="close_box"><a class="ccslider-close icons icons-close"></a></div>
        <div class="col-xs-12"><?php echo ($article["content"]); ?></div>
    </div>
</div>
<div class="note">
    <input class="note-checkbox" id="cbox" type="checkbox">
    <label class="note-label" for="cbox">同意</label>
    <a class="note-href" href="javascript:void(0);">《诚享东方经销商等级协议》</a>
    <input type='hidden'  value="<?php echo ($info["parent_id"]); ?>"/>
</div>
<a href="javascript:void(0);" class="cc-btn cc-lg">下一步</a>
<form id='form' method='POST' action="<?php echo U('step_four');?>" >
    <input type='hidden' name='username' value='<?php echo ($username); ?>'/>
    <input type='hidden' name='mobile' value='<?php echo ($info["mobile"]); ?>'/>
    <input type='hidden' name='pic1' value='<?php echo ($info["pic1"]); ?>'/>
    <input type='hidden' name='pic2' value='<?php echo ($info["pic2"]); ?>'/>
    <input type='hidden' name='password' value='<?php echo ($info["password"]); ?>'/>
    <input type='hidden' name='certificate' value='<?php echo ($info["certificate_no"]); ?>'/>
    <input class='parent' type='hidden' name='parent' value='<?php echo ($info["parent_id"]); ?>'/>
    <input class='myle' type='hidden' name='level' value='' />
</form>
<script src="/Public/jd/js/jquery.js"></script>
<script src="/Public/jd/js/plugin.min.js"></script>
<script>
    $(function(){
        /* 侧边栏开启 */
        $(".note-href").on("click",function(){

            $(".ccslider").fadeIn("fast").addClass("active");
        });
        /* 侧边栏关闭 */
        $(".ccslider-close").on("click",function(){
            $(".ccslider").removeClass("active").fadeOut("fast");
        });

        var isclick=true;
        /* 选择微商 */
        $(".level-item").on("click",function(){
            $(".level-item").removeClass("active");
            $(this).addClass("active");
            $('.myle').val($(this).find('.level_id').val());
            console.log($(this).find('.level_id').val());
        });
        /* 下一步 */
        $(".cc-btn").on("click",function(){
            var level=$(".level-item.active");
            var levelIndex=level.index();
            var $cbox=$("#cbox")[0].checked;
            if(level.length!=1){
                $.toast({text:"请选择经销商"});
                return ;
            }
            if($cbox==false){
                $.toast({text:"请同意协议"});
                return ;
            }
            if(isclick){
                var level=$('.myle').val();
                var agree=$('.agree:checked').val();
                var parent = $.trim($('.parent').val());
                if(level&&parent){
                    $('#form').submit();
                    return ;
                }else{
                    $('#form').attr('action',"<?php echo U('select_parent');?>");
                    $('#form').submit();
                    return;
                }
            }

        });
    });
</script>
</body>
</html>