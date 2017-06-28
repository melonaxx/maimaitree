<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit"/>
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no,minimal-ui"/>
    <title>智能信息管理平台</title>
    <style>
        body{background:#d9d9d9 url(https://static.gensee.com/webcast/static/tra/images/education_loginbg.gif) repeat-x top;
            margin:0;
            padding:0;}
    </style>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <meta name="renderer" content="webkit"/>
    <link rel="Shortcut Icon" href="/images/backend/favicon.png" type="image/x-icon">
    <link href="https://static.gensee.com/webcast/static/tra/css/jquery-ui-1.8.17.custom.css" rel="stylesheet" />
    <link href="https://static.gensee.com/webcast/static/tra/css/education.css" rel="stylesheet" />
    <link href="https://static.gensee.com/webcast/branding/default/tra/zh_CN/css/education_login.css" rel="stylesheet"/>
    <script language="javascript" type="text/javascript" src="https://static.gensee.com/webcast/static/tra/js/jquery-1.7.1.min.js"></script>
    <script language="javascript" type="text/javascript" src="https://static.gensee.com/webcast/static/tra/js/jquery-ui-1.8.17.custom.min.js"></script>
    <script language="javascript" type="text/javascript" src="https://static.gensee.com/webcast/static/tra/js/jquery.validate.min.js"></script>
    <script language="javascript" type="text/javascript" src="https://static.gensee.com/webcast/static/tra/js/lang/i18nUtil.js"></script>
    <script language="javascript" type="text/javascript" src="https://static.gensee.com/webcast/static/tra/js/lang/common_lang.js"></script>
    <script language="javascript" type="text/javascript" src="https://static.gensee.com/webcast/static/tra/js/lang/jquery_message_i18n.js"></script>
    <script language="javascript" type="text/javascript" src="https://static.gensee.com/webcast/static/tra/js/jquery.ajaxError.js"></script>
    <script language="javascript" type="text/javascript" src="https://static.gensee.com/webcast/static/tra/js/countdown.js"></script>
    <script language="javascript" type="text/javascript" src="https://static.gensee.com/webcast/static/tra/js/paging.js"></script>
    <script language="javascript" type="text/javascript" src="https://static.gensee.com/webcast/static/tra/js/line.js"></script>
    <script language="javascript" type="text/javascript" src="https://static.gensee.com/webcast/static/tra/js/branding/dealImage.js"></script>
    <script type="text/javascript" src="https://static.gensee.com/webcast/static/tra/js/zclip/jquery.zclip.min.js"></script>
    <script type="text/javascript" src="https://static.gensee.com/webcast/static/tra/js/jquery.qrcode.min.js"></script>

    <script type="text/javascript">
    $(function(){

        $("#passwordInput").keydown(function(e) {
            if (e.keyCode == 13) {
                $("#passwordInput").blur();
                doEnter();
            }
        });
        if ($("#nameInput").val() == '') {
            $("#nameInput").focus();
        }else{
            $("#passwordInput").focus();
        }
        if (navigator.userAgent.toLowerCase().indexOf("chrome") >= 0){
            var _interval = window.setInterval(function (){
                var autofills = $('input:-webkit-autofill');
                if (autofills.length > 0){
                    window.clearInterval(_interval); // stop polling
                    autofills.each(function(){
                        var clone = $(this).clone(true, true);
                        $(this).after(clone).remove();
                    });
                }
            }, 20);
        }
    });
    function showMsg(msg){
        $("#education_loginerror").show();
        if(msg)
            $("#msgSpan").html(msg);

    }
    function doEnter() {
        if($("#nameInput").val()==''){
            showMsg('请输入登录账号');
            return;
        }
        if($("#passwordInput").val()==''){
            showMsg('请输入登录密码');
            return;
        }
        $("#form1").submit();
    }
    </script>

</head>

<body>
<div id="education_loginmid">

    <img src="/images/backend/login_title.png" border="0" />

    <form method="post" action="/training/site/login" id="form1">
        <input type="hidden" name="redirectUrl" value=""/>
        <input type="hidden" name="errorUrl" value=""/>
        <span style="+margin:0px 0px 10px 0px;_margin:0px 0px 10px 0px;display:inline-block;width:71px;height: 40px;float:left;text-align:right;">用户名：</span><span class="education_input_bg "><input type="text" id="nameInput" name="name" value="" class="education_loginmidtext" /></span>
        <span class="password-span" style="+margin:0px 0px 10px 0px; _margin:0px 0px 10px 0px; *margin: 40px 0px 10px -70px; display: inline-block; width:71px; height: 40px; float:left; text-align: right;">密码：</span><span class="education_input_bg education_input_bg_margin"><input id="passwordInput" type="password" name="password" value="" class="education_loginmidtext education_loginmidtext-t"  /></span>
        <div id="education_loginerror" style="margin-top:5px;line-height: 30px;width: 250px;display: none;float:left;" class="ui-state-error ui-corner-all">
            <span style="float: left; margin:10px;" class="ui-icon ui-icon-alert"></span><span id="msgSpan" style="float:left;"></span>
        </div>
        <input type="button" onclick="doEnter()"  class="WorldCat" value="请登录" id="education_loginmidbutton"/>

    </form>
</div>
</body>
</html>


