<?php include_once('header.php'); ?>

<div id="contentHeader">
    <h3>内容管理</h3>
    <div class="searchArea">
        <ul class="action left" >
            <li class="current"><a href="<?php echo site_url('admin/post')?>" class="actionBtn"><span>返回</span></a></li>
            <li class="current"><a href="<?php echo site_url('admin/postcreate')?>" class="actionBtn"><span>录入</span></a></li>
        </ul>

    </div>
</div>

<script type="text/javascript" src="<?php echo base_url()?>public/js/jscolor/jscolor.js"></script>
<form action="<?php echo site_url('admin/postedit/' . $post['id'])?>" id="xform" name="xform" enctype="multipart/form-data" method="post">
    <table class="form_table">
        <tbody><tr>
            <td class="tb_title">标题：</td>
        </tr>
        <tr>
            <td><input size="60" maxlength="128" class="validate[required]" name="Post[title]" id="Post_title" type="text" value="<?php echo $post['title'] ?>"></td>
        </tr>
        <tr>
            <td class="tb_title">所属栏目：</td>
        </tr>
        <tr>
            <td><select name="Post[catalog_id]" id="Post_catalog_id">
                    <?php foreach($categories as $row) { ?>
                        <option value="<?php echo $row['id'] ?>" <?php if($row['id'] == $post['cid']) echo 'selected="selected"'; ?>><?php echo $row['str_repeat'] . $row['catalog_name'] ?></option>
                    <?php } ?>
                </select>
        </tr>
        <tr>
            <td class="tb_title">来源：</td>
        </tr>
        <tr>
            <td><input size="20" maxlength="128" name="Post[copy_from]" id="Post_copy_from" type="text" value="<?php echo $post['copy_from'] ?>">网址<input size="50" maxlength="128" name="Post[copy_url]" id="Post_copy_url" type="text" value="<?php echo $post['copy_url'] ?>"></td>
        </tr>
        <tr>
            <td class="tb_title">作者：</td>
        </tr>
        <tr>
            <td><input size="60" maxlength="128" name="Post[author]" id="Post_author" type="text" value="<?php echo $post['author'] ?>"></td>
        </tr>
        <tr>
            <td class="tb_title">跳转网址(此处若填写，则不显示内容)：</td>
        </tr>
        <tr>
            <td><input size="60" maxlength="128" name="Post[redirect_url]" id="Post_redirect_url" type="text" value="<?php echo $post['redirect_url'] ?>"></td>
        </tr>
        <tr>
            <td class="tb_title">封面图片：</td>
        </tr>
        <tr>
            <td>
                <input class="validate[]" name="cover" id="Post_cover" type="file">
                <input type="hidden" name="hiddencover" value="<?php echo $post['attach_file'] ?>" />
                <img src="<?php echo '/uploads/' . $post['attach_file'] ?>" />
            </td>
        </tr>
        <tr>
            <td class="tb_title">详细介绍：</td>
        </tr>
        <tr>
            <td><textarea id="content" name="Post[content]" style="width:700px;height:300px;"><?php echo $post['content'] ?></textarea></td>
        </tr>
        <tr>
            <td class="tb_title">摘要：</td>
        </tr>
        <tr>
            <td><textarea rows="5" cols="90" name="Post[intro]" id="Post_intro"><?php echo $post['intro'] ?></textarea></td>
        </tr>
        <tr>
            <td class="tb_title">Tags(逗号或空格隔开)：</td>
        </tr>
        <tr>
            <td><input size="50" maxlength="255" name="Post[tags]" id="Post_tags" type="text" value="<?php echo $post['tags'] ?>"></td>
        </tr>
        <!--<tr>
            <td class="tb_title">SEO标题：</td>
        </tr>
        <tr>
            <td><input size="50" maxlength="80" name="Post[seo_title]" id="Post_seo_title" type="text" value="<?php //echo $post['seo_title'] ?>"></td>
        </tr>-->
        <tr>
            <td class="tb_title">SEO关键字：</td>
        </tr>
        <tr>
            <td><input size="50" maxlength="80" name="Post[seo_keywords]" id="Post_seo_keywords" type="text" value="<?php echo $post['seo_keywords'] ?>"></td>
        </tr>
        <!--<tr>
            <td class="tb_title">SEO描述：</td>
        </tr>
        <tr>
            <td><textarea rows="5" cols="80" name="Post[seo_description]" id="Post_seo_description"><?php //echo $post['seo_description'] ?></textarea></td>
        </tr>-->
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
    <script type="text/javascript" charset="utf-8" src="<?php echo base_url() ?>public/js/kindeditor/kindeditor-min.js"></script>
    <script type="text/javascript">
        var editor;
        KindEditor.ready(function(K) {
            editor = K.create('textarea[id="content"]', {
                allowFileManager : true,
                uploadJson : '<?php echo site_url('admin/postuploadimg') ?>'
            });
        });
    </script>
<?php include_once('footer.php'); ?>