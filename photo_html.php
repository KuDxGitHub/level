
<?php
	//头部文件
	require '../public/_share/_head.php';
?>

<div class="hero is-primary">
	<div class="hero-body">
		<div class="columns is-gapless">
			<div class="column is-hidden-mobile is-1">
				<figure class="image is-64x64">
				  <img src="../img/tust.png">
				</figure>
			</div>
			<div class="column has-text-centered">
				<h1 class="title">人工智能学院学生宿舍管理系统<span class="is-hidden-mobile">&emsp;&emsp;</span></h1>
				<h2 class="subtitle">学生平台<span class="is-hidden-mobile">&emsp;&emsp;</span></h2>
			</div>
		</div>
	</div>
</div>
<section class="section">
	<div class="columns">
		<div class="column is-2 is-offset-1">
        <?php
				//菜单文件
				require './_share/_mune.php';
			?>
		</div>
		<div class="column is-8" data-aos="flip-right" data-aos-duration="800" data-aos-once="true">
			<div class="box">
				<h2 class="has-text-centered subtitle"><i class="fas fa-user"></i>&thinsp;个人信息</h2>
				<p class="has-text-centered"><span>😃&nbsp;</span><span id="helloMsg">你好！</span><span><?=$user_name?></span> 请在下方录入你的人脸信息</p>
                <br>
                <progress class="progress is-small is-primary" max="100">15%</progress>
            <table style="width: 100%;border-collapse:separate; border-spacing:0px 10px;">
					
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
//访问用户媒体设备的兼容方法
function getUserMedia(constrains,success,error){
    if(navigator.mediaDevices.getUserMedia){
        //最新标准API
        navigator.mediaDevices.getUserMedia(constrains).then(success).catch(error);
    } else if (navigator.webkitGetUserMedia){
        //webkit内核浏览器
        navigator.webkitGetUserMedia(constrains).then(success).catch(error);
    } else if (navigator.mozGetUserMedia){
        //Firefox浏览器
        navagator.mozGetUserMedia(constrains).then(success).catch(error);
    } else if (navigator.getUserMedia){
        //旧版API
        navigator.getUserMedia(constrains).then(success).catch(error);
    }else{
        alert("不支持的浏览器");
    }
}
//成功的回调函数
function success(stream){
    //兼容webkit内核浏览器
    var CompatibleURL = window.URL || window.webkitURL;
    //将视频流设置为video元素的源
    try {
        video.srcObject = stream;
    } catch (e) {
        video.src = CompatibleURL.createObjectURL(stream);
    }
    //播放视频
    video.play();
}
//异常的回调函数
function error(error){
   alert("访问用户媒体设备失败,"+error.name+""+error.message);
}
// function downloadCanvasIamge(selector, name) {
//     // 通过选择器获取canvas元素
//     var canvas = document.querySelector(selector)
//     // 使用toDataURL方法将图像转换被base64编码的URL字符串
//     var url = canvas.toDataURL('image/png')
//     // 生成一个a元素
//     var a = document.createElement('a')
//     // 创建一个单击事件
//     var event = new MouseEvent('click')
    
//     // 将a的download属性设置为我们想要下载的图片名称，若name不存在则使用‘下载图片名称’作为默认名称
//     a.download = name || '下载图片名称'
//     // 将生成的URL设置为a.href属性
//     a.href = url
    
//     // 触发a的单击事件
//     a.dispatchEvent(event)
// }
/**
 * 获取当前静态页面的参数
 * 返回值和使用方法类似java request的getparamater
 * 不同: 当取得的为数组(length>1)时调用toString()返回(逗号分隔每个元素)
 * @param {Object} name
 * @return {TypeName} 
 */
function getPara(name,search){//name为要取得的参数名
    var p = getParas(name,search);
    if(p.length==0){
        return null;
    }else if(p.length==1){
        return p[0];
    }else{
        return p.toString();
    }
}

/**获取当前静态页面的参数
 * 返回值和使用方法类似java request的getparamaterValues
 * @param {Object} name 要取出的参数名,可以在参数字符串中重复出现
 * @param {Object} search 手工指定要解析的参数字符串,默认为当前页面后跟的参数
 * @return {TypeName} 
 */
function getParas(name,search){//name为要取得的参数名
    if(!search){//如果没有指定search,则使用当前页面的参数
        search = window.location.search.substr(1);//1.html?a=1&b=2
    }
    var para = [];
    var pairs = search.split("&");//a=1&b=2&b=2&c=2&b=2
    for(var i=0;i<pairs.length;i=i+1){
        var sign = pairs[i].indexOf("="); 
        if(sign == -1){//如果没有找到=号，那么就跳过，跳到下一个字符串（下一个循环）。    
            continue; 
        }
        var aKey = pairs[i].substring(0,sign);
        if(aKey==name){
            para.push(unescape(pairs[i].substring(sign+1)));
        }
    }
    return para;
}
//开启摄像头
function captureInit(){
    if ((navigator.mediaDevices!=undefined && navigator.mediaDevices.getUserMedia!=undefined) 
            || navigator.getUserMedia!=undefined
            || navigator.webkitGetUserMedia!=undefined
            || navigator.mozGetUserMedia!=undefined){
        document.getElementById("help").style.display="none";
        //调用用户媒体设备，访问摄像头,改为触发事件
        getUserMedia({video:{width:imgWidth,height:imgHeight}},success,error);
        if(captureState==0){
            captureState=1;//标记此按钮已点击
        }
    } else {
        captureState=0;//异常标识按钮没点
        alert("你的浏览器不支持访问用户媒体设备或访问地址不是https开头,您可以点击右侧下载解决方案");
        document.getElementById("help").style.display="inline-block";
    }
}
//注册拍照按钮的单击事件
function capture(){
    //绘制画面
    if(captureState==0){
        alert("请先开启摄像头");
        return;
    }
    context.drawImage(video,0,0,imgWidth,imgHeight);//后面两个长宽
    //canvas.toDataURL("image/png");//即可得到base64编码
    captureState=2;
}
//确认按钮返回给父页面的函数
function queren(){
    if(captureState!=2){
        alert("请先开启摄像头并拍照");
        return;
    }
    var base64=canvas.toDataURL("image/jpeg");
    var pics={};
    pics.filetypeid=filetypeid;//返回给前端
    pics.base64=base64;
    if(window.opener){
        window.opener[cb](pics);// /FileUploadTmp/为项目临时文件夹相对路径
        window.close();
    }else if(window.parent){
        window.parent[cb](pics);
        window.parent.$("#dialog_ifr_html").dialog("close");//close会导致flash未执行完就销毁,页面JS报错
    }else{
        window.close();
    }
    // downloadCanvasIamge('canvas', '图片名称')
}
// 下载Canvas元素的图片
function downloadCanvasImage(selector, name) {
    // 通过选择器获取canvas元素
    var canvas = document.querySelector(selector)
    // 使用toDataURL方法将图像转换被base64编码的URL字符串
    var url = canvas.toDataURL('image/jpg')
    // 生成一个a元素
    var a = document.createElement('a')
    // 创建一个单击事件
    var event = new MouseEvent('click')
    name=document.getElementById("name").value;
    flat=document.getElementById("flat").value;
    // 将a的download属性设置为我们想要下载的图片名称，若name不存在则使用‘下载图片名称’作为默认名称
    a.download = name+"_"+flat || '下载图片名称'
    // 将生成的URL设置为a.href属性
    a.href = url
    
    // 触发a的单击事件
    a.dispatchEvent(event)
}


</script>

<div id="cameraBtn" class="column has-text-centered">
<input class="has-text-centered button is-warning  is-small" type="button" id="init" onclick="captureInit()" value="开启摄像头"/>
     <hr width="100%">

    <input class=" has-text-centered is-primary input is-outlined is-small" type="text" id="name" placeholder="请在此输入您的学号" style="width: 200px;">
    &nbsp;
    <div class="select has-text-centered is-primary is-outlined is-small" >
    <select name="flat" id="flat">
        <option value="" disabled selected>请选择你所在的公寓</option>
        <option value="13">13</option>
        <option value="15">15</option>
        <option value="16">16</option>
    </select>
<span id="help" style="display:none;"><a href="/static/ad/down/camera.doc">点此下载无法拍照的解决方案</a></span>
</div>
&nbsp;
<input class="has-text-centered button is-danger is-outlined is-small" type="button" id="capture" onclick="capture()" value="拍照"/>
   
   &nbsp;
       <input class="has-text-centered button is-link is-outlined is-small" type="button" id="queren" onclick="downloadCanvasImage('canvas','picture')" value="录入"/>
       
   
    

   
    
    
    
<div id="cameraDiv" class="column has-text-centered" >
    <!-- 视频流 -->
      <video id="video" autoplay style="width: 300px;height: 200px"></video>
     <!--描绘video截图-->
    <canvas id="canvas" width="300" height="200"></canvas>
    
</div>
<br>
<script type="text/javascript">//获取参数
var cb=getPara("cb")||"setImg";
var filetypeid=getPara("filetypeid")||"filetypeid";//附件类型id
var video=document.getElementById("video");//获取video标签
var canvas=document.getElementById("canvas");//获取canvas标签
var context=canvas.getContext("2d");//  获取canvas的上下文
var imgWidth=getPara("width")||"300";//这个值div的宽一致
var imgHeight=getPara("height")||"200";//这个值div的高一致
var captureState=0;//未开启,1已开启,2已拍照,为2才可点击确认按钮
// var style = getPara("style")||"big-btn-blue";//按钮样式
video.style.width=imgWidth;//设置video的宽高和canvas一致
video.style.height=imgHeight;//设置video的宽高和canvas一致
var st = style.split(",");//按钮样式
document.getElementById("init").className=st[0];//初始化按钮样式
document.getElementById("capture").className=st[1]||st[0];//拍照按钮样式
document.getElementById("queren").className=st[2]||st[0];//确认按钮样式
document.getElementById("help").className=st[3]||st[0];//下载按钮样式
</script>


<?php
	//脚部文件
	require '../public/_share/_photo.php';
?>
