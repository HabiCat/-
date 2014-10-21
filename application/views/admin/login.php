<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>管理登录 - 派遣管理系统</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/admin/css/login-style.css" />
</head>
<body>
<div id="login">
    <div class="wrapper">
        <div class="alert error" >&nbsp;</div>
        <div class="logo"></div>
        <div class="form">
            <form id="login-wrap" action="<?php echo site_url('webmaster/auth/login') ?>" method="post">
                <dl>
                    <dt>用户名</dt>
                    <dd> <input class="input-password" name="username" id="username" type="text" maxlength="50"></dd>
                    <dt>密&nbsp;&nbsp;&nbsp;&nbsp;码</dt>
                    <dd> <input class="input-password" name="password" id="password" type="password" maxlength="32"></dd>
                    <dd>
                        <input type="submit" name="login" class="input-login" value="">
                        <input type="reset" name="login" class="input-reset" value="">
                    </dd>
                </dl>
            </form>
        </div>
        <br class="clear-fix"/>
        <div class="copyright">Copyright&copy; <a title="bagecms" target="_blank" href="http://www.bagecms.com">bagecms.com</a>. All Thrusts Reserved.</div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url();?>public/js/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
$(function () {
   $('#yw0_button').onclick(function () {

   });
});
</script>
</body>
</html>