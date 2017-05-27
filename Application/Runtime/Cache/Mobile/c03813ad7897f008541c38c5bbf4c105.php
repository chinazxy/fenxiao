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
    <title>推荐列表</title>
    <!-- 通用类 -->
    <link rel="stylesheet" href="/Public/jd/css/reset.css">
    <link rel="stylesheet" href="/Public/jd/css/bootstrap3.min.css">
    <!-- 插件类 独立性 -->
    <link rel="stylesheet" href="/Public/jd/css/plugin.css">
    <!-- 所有页面类 -->
    <link rel="stylesheet" href="/Public/jd/css/chencc.css">
    <style>
	html{min-height:100%;}
	</style>
</head>
<body class="body-bg">
    <!-- 空白填充 -->
    <div style="height:30px;"></div>
    <div class="city">
        <div class="city-title">选择所在地区：</div>
    </div>
    <div class="city">
        <select class="city-select active" name="" id="select1">
               <option value='0'>请选择</option>
               <?php if(is_array($provinceList)): foreach($provinceList as $key=>$province): ?><option value='<?php echo ($province["id"]); ?>'><?php echo ($province["name"]); ?></option><?php endforeach; endif; ?> 
        </select>
        <select  class="city-select" name="" id="select2">
        	
        </select>
        <div class="city-search btn">查找</div>
    </div>
    <!-- 推荐人 -->
    <div class="friend">
    </div>
    <a href="javascript:void(0);" class="ccNext-btn" style="background:#fff;color:#720E7E;">下一步</a>
    <form action="<?php echo U('step_four');?>"   method="POST"  id='subform'>
    <input type='hidden'  name='mobile'  value="<?php echo ($post["mobile"]); ?>"/>
    <input type='hidden'  name='password'  value="<?php echo ($post["password"]); ?>"/>
    <input type='hidden'  name='level'  value="<?php echo ($post["level"]); ?>"/>
    <input type='hidden'  name='pic1'  value="<?php echo ($post["pic1"]); ?>"/>
    <input type='hidden'  name='pic2'  value="<?php echo ($post["pic2"]); ?>"/>
    <input type='hidden' name='certificate' value='<?php echo ($post["certificate"]); ?>'/>
    <input type='hidden'  name='username' value='<?php echo ($post["username"]); ?>'/>
    <input type='hidden' id='parent_id'  name='parent'  value=""/>
    <input type='hidden' name='province' id='province' value=""/>
     <input type='hidden' name='city' id='city' value=""/>
    </form>
    <script src="/Public/jd/js/jquery.js"></script>
    <script src="/Public/jd/js/plugin.min.js"></script>
    <script>
        $(function(){
            var flag1=true;
            /* 选择城市 */
            $("#select1").on("change",function(){
                var optionParren=$(this).val();
            	$('#select2').empty();
        		if(optionParren==1||optionParren==338||optionParren==10543||optionParren==31929||optionParren==0){
        	         console.log(optionParren);
        			$('#select2').empty();
        			$('#select2').hide();
        			return;
        	}
                if(flag1){
                    flag1=false;
                    $.ajax({
                        url:"<?php echo U('get_city');?>",
                        type:"post",
                        data:{province:optionParren},
                        success:function(res){
                        	flag1 = true;
                        	console.log(res);
                        	$('#select2').show();
                            $("#select2").html("");
                           $.each(res,function(key,obj){
                            	console.log(obj.name);
                                var $option=$("<option  />",{text:obj.name,value:obj.id});
                                $("#select2").append($option);
                            });
                        },
                        error:function(){
                        	flag1 = true;
                            $("#select2").html("");
                            citys.map(function(obj,num){
                                var $option=$("<option />",{text:obj});
                                $("#select2").append($option);
                            });
                        }
                    });
                }
            });
            function createItem(arr){
            	console.log(arr);
            //    $(".friend-item").remove();
                 var $a=$("<a />",{class:"friend-item"});
                 var $img=$("<img />",{class:"friend-img",src: "/"+arr.head_pic});
                 var $info=$("<div />",{class:"friend-info"});
                 var $nick=$("<div />",{class:"friend-nick",text:"昵称："+arr.nickname});
                 var $ok=$("<div />",{class:"friend-ok"});
                 var $name=$("<div />",{class:"friend-introduce",text:"等级："+arr.level});
                 var $num=$("<div />",{class:"friend-num",text:"服务经销商数："+arr.count_child});
                 var $introduce=$("<div />",{class:"friend-introduce",text:"个人简介:"+arr.my_desc});
                 var $id = $("<input/>",{class:'par_id',type:'hidden',value:arr.user_id});
                 $info.append($nick,$name);
                 $a.append($img,$ok,$info,$num,$introduce,$id);
                 $a.on("click",getactive);
                 $(".friend").append($a);
         }
            
            $(".friend-item").on("click",getactive);
            function getactive(){
            	   $(".friend-item").removeClass("active");
                   $(this).addClass("active");
                   $('#parent_id').val($(this).find('.par_id').val());
            }
            
            var flag2=true;
            $(".city-search").on("click",function(){
            	var level = <?php echo ($post["level"]); ?>;
              	var province = $("#select1").val();
            	var city = $("#select2").val();
            	var level = <?php echo ($post["level"]); ?>;
             			/* console.log(province);
             			console.log(city);
             			console.log(level); */
                if(flag2){
                	if(province!=0){
                		$.get("<?php echo U('find_user');?>",{province:province,city:city,level:level},function(data){
                			
                			$(".friend-item").remove();
                			 if(data.status==1000||data.status==1002){
                				 var bata = new Array();
                				 var sortkey = new Array();
                				 $.each(data.data,function(index,value){
                                   
                                     if(value.province!=0){
                                    	 bata.push(value);
                                     }
                                 })
                                 if(bata.length==0){
                                	 alert('未获取到您选择的区域的经销商，您有以下可选择经销商列表');	
                                	 sortkey = data.data;
                                 }else{
                                	 sortkey = bata;
                                 }
                				 $('#city').val(city);
                				 $('#province').val(province);
                                 if(bata.length==0){
                                     var value = sortkey[0];
                                     createItem(value);
                                 }else {
                                     $.each(sortkey, function (index, value) {
                                         console.log(value);
                                         createItem(value);
                                     })
                                 }
                			 }
                		})
                	}
                }
            });
            
            var flag2=true;
            /* 下一步 */
            $(".ccNext-btn").on("click",function(){
                var shop=$(".friend-item.active");
                var tt=shop.find(".friend-name").text();
                 console.log(tt);
                if(shop.length==0){
                    $.toast({text:"请选择地区搜索获取经销商列表"});
                    return;
                }
               $('#subform').submit(); 
               
            });
        });
    </script>
</body>
</html>