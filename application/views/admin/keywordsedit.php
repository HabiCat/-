<?php include_once('header.php'); ?>

<div id="contentHeader">
    <h3>内容管理</h3>
    <div class="searchArea">
        <ul class="action left" >
            <li class="current"><a href="<?php echo site_url('admin/keywords')?>" class="actionBtn"><span>返回</span></a></li>
        </ul>

    </div>
</div>

<script type="text/javascript" src="<?php echo base_url()?>public/js/jscolor/jscolor.js"></script>
<form action="<?php echo site_url('admin/keywordsedit/' . $result['id']) ?>" id="xform" name="xform" enctype="multipart/form-data" method="post">
    <table class="form_table">
        <tbody><tr>
            <td class="tb_title">关键字：</td>
        </tr>
        <tr>
            <td><input size="60" maxlength="128" class="validate[required]" name="Keywords[keywords]" id="Keywords_keywords" type="text" value="<?php echo $result['keywords'] ?>"></td>
        </tr>
        <tr>
            <td class="tb_title">链接URL：</td>
        </tr>
        <tr>
            <td><input size="60" maxlength="128" name="Keywords[url]" id="Keywords_url" type="text" value="<?php echo $result['url'] ?>"></td>
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