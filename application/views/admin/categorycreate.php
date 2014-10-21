<?php include_once('header.php'); ?>

<script type="text/javascript">
    $(function(){
        $("#Catalog_parent_id").val(<?php echo $parentId ?>);
    });
</script>

    <form name="xform" enctype="multipart/form-data" id="xform" action="<?php echo site_url('admin/categorycreate') ?>" method="post"><table class="form_table">
            <tbody><tr>
                <td class="tb_title">名称：</td>
            </tr>
            <tr>
                <td><input size="40" maxlength="128" class="validate[required]" name="Catalog[catalog_name]" id="Catalog_catalog_name" type="text" value=""></td>
            </tr>
            <tr>
                <td class="tb_title">所属分类：</td>
            </tr>
            <tr>
                <td><select name="Catalog[parent_id]" id="Catalog_parent_id">
                        <option value="0">==顶级分类==</option>
                        <?php foreach($datalist as $row) { ?>
                        <option value="<?php echo $row['id'] ?>"><?php echo $row['str_repeat'] . $row['catalog_name'] ?></option>
                        <?php } ?>
                    </select></td>
            </tr>
            <tr>
                <td class="tb_title">每页显示数量(0或空表示默认20条)：</td>
            </tr>
            <tr>
                <td class="tb_title"><input size="5" maxlength="5" name="Catalog[page_size]" id="Catalog_page_size" type="text" value="0"></td>
            </tr>

            <!--<tr>
                <td class="tb_title">列表模板：</td>
            </tr>
            <tr>
                <td><input size="40" maxlength="128" class="validate[required]" name="Catalog[template_list]" id="Catalog_template_list" type="text" value="list_text"></td>
            </tr>
            <tr>
                <td class="tb_title">内容页模板：</td>
            </tr>
            <tr>
                <td><input size="40" maxlength="128" class="validate[required]" name="Catalog[template_show]" id="Catalog_template_show" type="text" value="show_post"></td>
            </tr>-->
            <tr>
                <td class="tb_title">跳转地址：</td>
            </tr>
            <tr>
                <td><input size="60" maxlength="128" name="Catalog[redirect_url]" id="Catalog_redirect_url" type="text" value=""> 若填写此地址则直接跳转到链接地址</td>
            </tr>
            <tr>
                <td class="tb_title">栏目介绍：</td>
            </tr>
            <tr>
                <td><textarea id="content" name="Catalog[content]" style="width:700px;height:300px;"></textarea></td>
            </tr>
            <tr>
                <td class="tb_title">SEO标题：</td>
            </tr>
            <tr>
                <td><input size="50" maxlength="128" name="Catalog[seo_title]" id="Catalog_seo_title" type="text" value=""></td>
            </tr>
            <tr>
                <td class="tb_title">SEO关键字：</td>
            </tr>
            <tr>
                <td><input size="50" maxlength="128" name="Catalog[seo_keywords]" id="Catalog_seo_keywords" type="text" value=""></td>
            </tr>
            <tr>
                <td class="tb_title">SEO描述：</td>
            </tr>
            <tr>
                <td><textarea rows="5" cols="80" name="Catalog[seo_description]" id="Catalog_seo_description"></textarea></td>
            </tr>
            <tr class="submit">
                <td><input type="submit" name="editsubmit" value="提交" class="button" tabindex="3"></td>
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