<?php include_once('header.php'); ?>

<div id="contentHeader">
    <h3>管理员</h3>
    <div class="searchArea">
        <ul class="action left">
            <li><a href="<?php echo site_url('admin/userlist') ?>" class="actionBtn"><span>管理</span></a></li>
            <li><a href="<?php echo site_url('admin/usercreate') ?>" class="actionBtn"><span>录入</span></a></li>
        </ul>
        <div class="search right"> </div>
    </div>
</div>

<form name="xform" id="xform" action="<?php echo site_url('admin/usercreate') ?>" method="post">
    <table class="form_table">
        <tbody><tr>
            <td class="tb_title">用户：</td>
        </tr>
        <tr>
            <td><input size="30" maxlength="128" class="validate[required]" name="Admin[username]" id="Admin_username" type="text" /></td>
        </tr>
        <tr>
            <td class="tb_title">密码：</td>
        </tr>
        <tr>
            <td><input size="30" maxlength="50" value="" name="Admin[password]" id="Admin_password" type="text"></td>
        </tr>
        <tr>
            <td class="tb_title">邮箱：</td>
        </tr>
        <tr>
            <td><input size="30" maxlength="50" name="Admin[email]" id="Admin_email" type="text" value=""></td>
        </tr>
        <tr class="submit">
            <td> <input name="submit" type="submit" id="submit" value="提交" class="button"></td>
        </tr>
        </tbody></table>

    <script type="text/javascript">
        $(function(){
            $("#xform").validationEngine();
        });
    </script>
</form>
<?php include_once('footer.php'); ?>
