<!doctype html>
<html>
<head>
    <title>派遣职位发布系统</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/admin/css/manage.css">
    <script type="text/javascript" src="<?php echo base_url();?>public/js/jquery/jquery-1.7.1.min.js"></script>
</head>

<body scroll="no">
<div class="header">
    <div class="logo">rcpq.com</div>
    <div class="nav">
        <ul>
            <li index="0"><div><a href="<?php echo site_url('admin/setting') ?>" target="win" hidefocus>全局设置</a></div></li>
            <li index="1"><div><a href="<?php echo site_url('admin/companylist') ?>" target="win" hidefocus>公司管理</a></div></li>
            <li index="2"><div><a href="<?php echo site_url('admin/replylist') ?>" target="win" hidefocus>求职管理</a></div></li>
            <li index="3"><div><a href="<?php echo site_url('admin/category') ?>" target="win" hidefocus>资讯管理</a></div></li>
            <li index="4"><div><a href="<?php echo site_url('admin/userlist') ?>" target="win" hidefocus>用户管理</a></div></li>
        </ul>
    </div>
    <div class="logininfo"><span class="welcome"><img src="<?php echo base_url() ?>public/admin/images/user_edit.png" align="absmiddle"> 欢迎, <em><?php echo $this->session->userdata('username') ?></em> </span> <a href="<?php echo site_url('admin/useredit/' . $this->session->userdata('adminid')) ?>" target="win">修改密码</a> <a href="<?php echo site_url('webmaster/auth/logout') ?>" target="_top">退出登录</a> <a href="<?php echo base_url()?>" target="_blank">前台首页</a></div>
</div>
<div class="topline">
    <div class="toplineimg left" id="imgLine"></div>
</div>
<div class="main" id="main">
    <div class="mainA">
        <div id="leftmenu" class="menu">
            <ul index="0" class="left_menu">
                <li index="0"><a href="<?php echo site_url('admin/setting') ?>" target="win">网站设置</a></li>
                <li index="1"><a href="<?php echo site_url('admin/keywords') ?>" target="win">关键词管理</a></li>
                <li index="2"><a href="<?php echo site_url('admin/ads') ?>" target="win">广告管理</a></li>
            </ul>
            <ul index="1" class="left_menu">
                <li index="0"><a href="<?php echo site_url('admin/companylist') ?>" target="win">公司管理</a></li>
            </ul>
            <ul index="2" class="left_menu">
                <li index="0"><a href="<?php echo site_url('admin/replylist') ?>" target="win">报名考试</a></li>
                <li index="1"><a href="<?php echo site_url('admin/applylist') ?>" target="win">应聘简历</a></li>
                <li index="2"><a href="<?php echo site_url('admin/resume') ?>" target="win">华中人才库</a></li>
                <li index="3"><a href="<?php echo site_url('admin/labor') ?>" target="win">华中普工库</a></li>
            </ul>
            <ul index="3" class="left_menu">
                <li index="0"><a href="<?php echo site_url('admin/category') ?>" target="win">栏目管理</a></li>
                <li index="1"><a href="<?php echo site_url('admin/post') ?>" target="win">内容管理</a></li>
                <li index="2"><a href="<?php echo site_url('admin/special') ?>" target="win">专题管理</a></li>
                <li index="1"><a href="<?php echo site_url('admin/messages') ?>" target="win">留言管理</a></li>
                <li index="2"><a href="<?php echo site_url('admin/comment') ?>" target="win">评论管理</a></li>
            </ul>
            <ul index="4" class="left_menu">
                <li index="0"><a href="<?php echo site_url('admin/userlist') ?>" target="win">用户管理</a></li>
            </ul>
        </div>
    </div>
    <div class="mainB" id="mainB">
        <iframe src="index.php/admin/worklist" name="win" id="win" width="100%" height="100%" frameborder="0"></iframe>
    </div>
</div>
<script type="text/javascript">
    window.onload =window.onresize= function(){winresize();}
    function winresize()
    {
        function $(s){return document.getElementById(s);}
        var D=document.documentElement||document.body,h=D.clientHeight-90,w=D.clientWidth-160;
        $("main").style.height=h+"px";
        $("mainB").style.width=w+"px";
    }
    $(document).ready(function(){
        var s=document.location.hash;
        if(s==undefined||s==""){s="#0_0";}
        s=s.slice(1);
        var navIndex=s.split("_");
        $(".nav").find("li:eq("+navIndex[0]+")").addClass("active");
        var targetLink=$(".menu").find("ul").hide().end()
            .find(".left_menu:eq("+navIndex[0]+")").show()
            .find("li:eq("+navIndex[1]+")").addClass("active")
            .find("a").attr("href");
        $("#win").attr("src",targetLink);
        $(".nav").find("li").click(function(){
            $(this).parent().find("li").removeClass("active").end().end()
                .addClass("active");
            var index=$(this).attr("index");
            $(".menu").find(".left_menu").hide();
            $(".menu").find(".left_menu:eq("+index+")").show()
                .find("li").removeClass("active").first().addClass("active");
            document.location.hash=index+"_0";
        });
        $(".left_menu").find("li").click(function(){
            $(this).parent().find("li").removeClass("active").end().end()
                .addClass("active");
            document.location.hash=$(this).parent().attr("index")+"_"+$(this).attr("index");
        });
    });
</script>
</body>
</html>