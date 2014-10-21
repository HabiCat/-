<?php include_once('header.php'); ?>

<div id="contentHeader">
    <h3>网站设置</h3>
</div>

<script type="text/javascript" src="<?php echo base_url()?>public/js/jscolor/jscolor.js"></script>
<form action="<?php echo site_url('admin/setting')?>" id="xform" name="xform" enctype="multipart/form-data" method="post">
    <table class="form_table">
        <tbody><tr>
            <td class="tb_title">seo标题：</td>
        </tr>
        <tr>
            <td><input size="60" class="validate[]" name="Setting[title]" id="Setting_title" type="text" value="<?php echo $globaldata['title'] ?>"></td>
        </tr>
        <tr>
            <td class="tb_title">seo关键字：</td>
        </tr>
        <tr>
            <td><textarea id="Setting_keyword" name="Setting[keyword]" rows="5" cols="50"><?php echo $globaldata['keyword'] ?></textarea></td>
        </tr>
        <tr>
            <td class="tb_title">seo描述：</td>
        </tr>
        <tr>
            <td><textarea rows="5" cols="50" name="Setting[description]" id="Setting_description"><?php echo $globaldata['description'] ?></textarea></td>
        </tr>
        </tbody>
        <tbody><tr class="submit">
            <td colspan="2"><input type="submit" name="editsubmit" value="提交" class="button" tabindex="3"></td>
        </tr>
        </tbody></table>
    <script type="text/javascript">
        $(function(){
            $("#xform").validationEngine();
        });
    </script>
</form>
<?php include_once('footer.php'); ?>