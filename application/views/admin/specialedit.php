<?php include_once('header.php'); ?>

    <script type="text/javascript">
        $(function(){
            $("#Catalog_parent_id").val(<?php echo $parentId ?>);
        });
    </script>

    <form name="xform" enctype="multipart/form-data" id="xform" action="<?php echo site_url('admin/specialedit/' . $special['specid']) ?>" method="post"><table class="form_table">
            <tbody><tr>
                <td class="tb_title">名称：</td>
            </tr>
            <tr>
                <td><input size="40" maxlength="128" class="validate[required]" name="Special[specname]" id="Special_specname" type="text" value="<?php echo $special['specname'] ?>"></td>
            </tr>

            <!--<tr>
                <td class="tb_title">列表模板：</td>
            </tr>
            <tr>
                <td><input size="40" maxlength="128" class="validate[required]" name="Special[tpllist]" id="Special_tpllist" type="text" value="<?php echo $special['tpllist'] ? $special['tpllist'] : 'list_special' ?>"></td>
            </tr>-->

            <tr>
                <td class="tb_title">专题文章选择：</td>
            </tr>
            <tr>
                <td>
                    <input size="40" maxlength="128" class="validate[required]" name="Special[postids]" id="Special_postids" type="text" value="<?php echo $special['postids'] ?>">
                    <input type="button" name="pickerpostids" id="pickerpostids" onclick="javascript: openpostlist()" value="获取文章" />
                </td>
            </tr>

            <tr>
                <td class="tb_title">专题介绍：</td>
            </tr>
            <tr>
                <td><textarea id="content" name="Special[content]" style="width:700px;height:300px;"><?php echo $special['content'] ?></textarea></td>
            </tr>
            <tr>
                <td class="tb_title">SEO标题：</td>
            </tr>
            <tr>
                <td><input size="50" maxlength="128" name="Special[seotitle]" id="Special_seo_title" type="text" value="<?php echo $special['seotitle'] ?>"></td>
            </tr>
            <tr>
                <td class="tb_title">SEO关键字：</td>
            </tr>
            <tr>
                <td><input size="50" maxlength="128" name="Special[keywords]" id="Special_keywords" type="text" value="<?php echo $special['keywords'] ?>"></td>
            </tr>
            <tr>
                <td class="tb_title">SEO描述：</td>
            </tr>
            <tr>
                <td><textarea rows="5" cols="80" name="Special[description]" id="Catalog_description"><?php echo $special['description'] ?></textarea></td>
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
        function putids(ids) {
            var old_ids = document.getElementById('Special_postids').value;
            if(ids.length > 0) {
                ids = ids.join(',');
                if(old_ids) {
                    old_ids += ',' + ids;
                } else {
                    old_ids = ids;
                }
            }
            document.getElementById('Special_postids').value = old_ids;
            window.close();
        }

        function openpostlist() {
            window.open ('<?php echo site_url('admin/postlist') ?>', 'newwindow', 'height=566, width=950, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=n o, status=no');
        }
    </script>
<?php include_once('footer.php'); ?>