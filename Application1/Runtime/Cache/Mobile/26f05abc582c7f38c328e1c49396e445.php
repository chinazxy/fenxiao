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
    <title>完善注册</title>
    <!-- 通用类 -->
    <link rel="stylesheet" href="/Public/jd/css/reset.css">
    <link rel="stylesheet" href="/Public/jd/css/bootstrap3.min.css">
    <!-- 插件类 独立性 -->
    <link rel="stylesheet" href="/Public/jd/css/plugin.css">
    <!-- 所有页面类 -->
    <link rel="stylesheet" href="/Public/jd/css/chencc.css">
    
    <style>
	html{min-height:100%;}
	h4{font-size:16px;}
	.friend h4{color:#fff;text-align:left;margin-top:-10px;margin-bottom:15px;}
	</style>
</head>
<body class="body-bg">
    <!-- 空白填充 -->
    <div style="height:30px;"></div>
    <!-- 输入框 -->
	<h4 style="width:90%;margin:0 auto;color:#fff;">请输入注册人真实姓名：</h4>
    <div class="ccinput-group ccbg-muted">
        <input id="username" type="text" class="ccinput-input" placeholder="" style="padding:8px 0;margin-bottom:15px;">
    </div>
        <h4 style="width:90%;margin:0 auto;color:#fff;">请输入注册人身份证号码：</h4>
    <div class="ccinput-group ccbg-muted">
        <input id="certificate" type="text" class="ccinput-input" placeholder="" style="padding:8px 0;margin-bottom:15px;">
    </div>
    <h4 style="width:90%;margin:0 auto;color:#fff;">请上传身份证正反面照片：</h4>
    <div class="ccinput-group ccbg-muted" style="text-align: center;">
        <form enctype="multipart/form-date" method="post" id="form1">
        
                <div class="col-sm-3">
                    <div style="width:90%;margin:0 auto;color:#fff;">身份证正面</div>
                </div>
                <div class="col-sm-9 big-photo">
                    <div id="preview1">
                        <img id="imghead1" border="0" src="/Public/img/photo_icon.png"  height="90" onclick="$('#previewImg1').click();">
                     </div>         
                    <input type="file" onchange="previewImage1(this)" style="display: none;" id="previewImg1" name="img1">
                </div>
        </form>
        <form enctype="multipart/form-date" method="post" id="form2">
                <div class="col-sm-3">
                    <div style="width:90%;margin:0 auto;color:#fff;">身份证反面</div>
                </div>
                <div class="col-sm-9 big-photo">
                    <div id="preview2">
                        <img id="imghead2" border="0" src="/Public/img/photo_icon.png"  height="90" onclick="$('#previewImg2').click();">
                     </div>         
                    <input type="file" onchange="previewImage2(this)" style="display: none;" id="previewImg2" name="img2">
                </div>
        </form><br>
    
    </div><div id="add"></div>
	<h4 style="width:90%;margin:0 auto;color:#fff;">若您有推荐人，请输入推荐人手机号码</h4>
    <div class="ccinput-group ccbg-muted">
        <input id="tel" type="tel" class="ccinput-input" placeholder="请输入推荐人ID:" onkeyup="value=value.replace(/[^\d]/g,'') ">
        <div id="mask" class="ccinput-label" style="background:#fff;color:#720e7e;">查找</div>
    </div>
    <!-- 推荐人 -->
    <div class="friend">
    </div>
    <div class="no-friend">
         <a  disabled="true" id='next' class="no-friend-href cc-btn cc-btnBlue" href="#" style="background:#fff;">下一步</a>
        <a id='next_step' class="no-friend-href cc-btn cc-btnBlue" href="#" style="background:#fff;">我没有推荐人></a>
       
    </div>
    <script src="/Public/jd/js/jquery.js"></script>
    <script src="/Public/jd/js/plugin.min.js"></script>
    <script src="/Public/jd/js/jquery-form.js"></script>
    <script type="text/javascript">
    function previewImage1(file)
        {
          var MAXWIDTH  = 90; 
          var MAXHEIGHT = 90;
          var div = document.getElementById('preview1');
          //console.log(file.files[0])
          if (file.files && file.files[0])
          {
              div.innerHTML ='<img id=imghead1 onclick=$("#previewImg1").click()>';
              var img = document.getElementById('imghead1');
              img.onload = function(){
                var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
                img.width  =  rect.width;
                img.height =  rect.height;
//                 img.style.marginLeft = rect.left+'px';
                img.style.marginTop = rect.top+'px';
              }
              var reader = new FileReader();
              reader.onload = function(evt){img.src = evt.target.result;}
              reader.readAsDataURL(file.files[0]);
          }
          else //兼容IE
          {
            var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
            file.select();
            var src = document.selection.createRange().text;
            div.innerHTML = '<img id=imghead1>';
            var img = document.getElementById('imghead1');
            img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
            var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
            status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
            div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
          }
                     $('#form1').ajaxSubmit({
                      url:"<?php echo U('Upload/uploadimg');?>",
                      type:"POST",
                      dateType : "JSON",
                      //date:$('#form1').serialize(),
                      success:function(e){
                        console.log(e)
                        var json = eval( '(' + e + ')' ); 
                      if (json.ret == 1) {
                        alert('上传成功');
                          $('input[name="pic1"]').remove();
                        $('#add').html($("#add").html()+"<input type='hidden' name='pic1' value='idcard"+json.msg+"'/>");
                      }else{
                        alert(e.msg);
                      } 
                      },
                      error:function(msg){
                      alert("出错了");
                      }
                     });
        }
        function previewImage2(file)
        {
          var MAXWIDTH  = 90; 
          var MAXHEIGHT = 90;
          var div = document.getElementById('preview2');
          if (file.files && file.files[0])
          {
              div.innerHTML ='<img id=imghead2 onclick=$("#previewImg2").click()>';
              var img = document.getElementById('imghead2');
              img.onload = function(){
                var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
                img.width  =  rect.width;
                img.height =  rect.height;
//                 img.style.marginLeft = rect.left+'px';
                img.style.marginTop = rect.top+'px';
              }
              var reader = new FileReader();
              reader.onload = function(evt){img.src = evt.target.result;}
              reader.readAsDataURL(file.files[0]);
          }
          else //兼容IE
          {
            var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
            file.select();
            var src = document.selection.createRange().text;
            div.innerHTML = '<img id=imghead2>';
            var img = document.getElementById('imghead2');
            img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
            var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
            status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
            div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
          }

                     $('#form2').ajaxSubmit({
                      url:"<?php echo U('Upload/uploadimg2');?>",
                      type:"POST",
                      dateType : "JSON",
                      //date:$('#form1').serialize(),
                      success:function(e){
                        var jsonObj = eval( '(' + e + ')' ); 
                      if (jsonObj.ret == 1) {
                        alert('上传成功');
                          $('input[name="pic2"]').remove();
                        $('#add').html($("#add").html()+"<input type='hidden' name='pic2' value='idcard"+jsonObj.msg+"'/>");
                      }else{
                        alert(e.msg);
                      } 
                      },
                      error:function(msg){
                      alert("出错了");
                      }
                     });
        }
        function clacImgZoomParam( maxWidth, maxHeight, width, height ){
            var param = {top:0, left:0, width:width, height:height};
            if( width>maxWidth || height>maxHeight ){
                rateWidth = width / maxWidth;
                rateHeight = height / maxHeight;
                
                if( rateWidth > rateHeight ){
                    param.width =  maxWidth;
                    param.height = Math.round(height / rateWidth);
                }else{
                    param.width = Math.round(width / rateHeight);
                    param.height = maxHeight;
                }
            }
            param.left = Math.round((maxWidth - param.width) / 2);
            param.top = Math.round((maxHeight - param.height) / 2);
            return param;
        }
    </script>
    <script>
 

        $(function(){
        	$('#next_step').on('click',function(){
        		
        		var username = $('#username').val().trim();
        		if(username==""){
        			 $.toast({text:"请输入您的姓名"});
        			 return;
        		}
                var pic1 = $('input[name="pic1"]').val();
                var pic2 = $('input[name="pic2"]').val();
                if (pic1 == "" || pic1 == undefined) {
                    $.toast({text:"请上传身份证正面照片"});
                    return;
                }
                if (pic2 == "" || pic2 == undefined) {
                    $.toast({text:"请上传身份证反面照片"});
                    return;
                }
                var certificate = $('#certificate').val().trim();
                var certPattern=/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/;
                if(certificate==""){
            		$.toast({text:"请输入您的身份证号码"});
            		return;
            	}
                if(!certPattern.test(certificate)) {
                    $.toast({text: "请输入正确的身份证号码"});
                    return;
                }
                var url = "<?php echo U('step_three');?>?pic1="+pic1+"&pic2="+pic2+"&mobile=<?php echo ($mobile); ?>&password=<?php echo ($password); ?>";
        		url = url+"&username="+username+"&certificate="+certificate;
        		location.href=url;
        	})
            var flag=true;
            $(".friend-item").on("click",getactive);

            $('#next').on("click",function(){
                /* if($(this).attr('href')=='#'){
                 $.toast({text:"请选择您的推荐人"});
                 } */
                //var exist = $(".friend-item").attr('class');
                //var ky = exist.indexOf('active');
                var tel = $('#tel').val().trim();
                var username = $('#username').val().trim();
                var upmobile = $(".friend-item").find('.par_id').val();
                var certificate = $('#certificate').val().trim();
                var active = $("#mask").hasClass('active');
                var certPattern=/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/;
                if(!tel||!active){
                    $.toast({text:"请填写您的推荐人"});
                    return;
                }
                if(username==""){
                    $.toast({text:"请输入您的姓名"});
                    return;
                }
                if(certificate==""){
                    $.toast({text:"请输入您的身份证号码"});
                    return;
                }
                if(!certPattern.test(certificate)) {
                    $.toast({text: "请输入正确的身份证号码"});
                    return;
                }
                var pic11 = $('input[name="pic1"]').val();
                var pic22 = $('input[name="pic2"]').val();
                if (pic11 == "" || pic11 == undefined) {
                    $.toast({text:"请上传身份证正面照片"});
                    return;
                }
                if (pic22 == "" || pic22 == undefined) {
                    $.toast({text:"请上传身份证反面照片"});
                    return;
                }
                location.href="<?php echo U('step_three');?>?pic1="+pic11+"&pic2="+pic22+"&mobile=<?php echo ($mobile); ?>&password=<?php echo ($password); ?>&upmobile="+upmobile+"&username="+username+"&certificate="+certificate;
            })
            
            function getactive(){
            	   $(".friend-item").removeClass("active");
                   $(this).addClass("active");
                  
                  
                   $('#next').text('下一步');
                //   $('#next').attr('href',"<?php echo U('step_three');?>?mobile=<?php echo ($mobile); ?>&password=<?php echo ($password); ?>&upmobile="+upmobile);
            }
            function createItem(arr){
            	   console.log(arr);
                   $(".friend-item").remove();
                    var $a=$("<a />",{class:"friend-item"});
                    var $img=$("<img />",{class:"friend-img",src: "/"+arr.head_pic});
                    var $info=$("<div />",{class:"friend-info"});
                    var $nick=$("<div />",{class:"friend-nick",text:arr.nickname});
                    var $ok=$("<div />",{class:"friend-ok"});
               //     var $name=$("<div />",{class:"friend-name",text:'经销商等级'+arr.level});
                    var $num=$("<div />",{class:"friend-num",text:"服务经销商："+arr.count_child + "人"});
                    var $introduce=$("<div />",{class:"friend-introduce",text:"个人简介:"+arr.my_desc});
                    var $removeBtn = $("<div />",{class:"friend-removeBtn",text:"重新验证"});
                    var $id = $("<input/>",{class:'par_id',type:'hidden',value:arr.mobile});
                    $info.append($nick);
                    
                    $a.append($img,$ok,$info,$num,$introduce, $id,$removeBtn);
                    $removeBtn.on('click',removeBtn);
                    $a.on("click",getactive);
				//	$(".friend").append('<h4>请点击选择经销商</h4>')
                    $(".friend").append($a);
            }
            function removeBtn(){
            	window.location.reload()
            	return;
            }
           
            $("#mask").on("click",function(){
                var tel=$("#tel").val().trim();
                var telPattern=/^[1][34578][0-9]{9}$/;
                if(tel==""||isNaN(tel)){
                    $.toast({text:"请输入手机号"});
                    return ;
                }
                if(tel.length<11){
                    $.toast({text:"请输入11位手机号"});
                    return;
                }
                if(!telPattern.test(tel)){
                    $.toast({text:"请输入正确的手机号"});
                    return;
                }
                if(flag){
                    flag = false;
                    var mobile = tel;
                    $.get("<?php echo U('search_user');?>",{mobile:mobile},function(data){
                        if(data.status==1000){
                            $('#mask').addClass('active');
                            flag=true;
                            createItem(data.msg);
                        }else if(data.status==1001){
                            flag=true;
                            alert(data.msg);
                        }
                    })
                }
            })
        });
    </script>
</body>
</html>