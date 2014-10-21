<?php include_once('header.php'); ?>

<div id="contentHeader">
    <h3>留言回复</h3>
    <div class="searchArea">
        <ul class="action left" >
            <li class="current"><a href="<?php echo site_url('admin/message')?>" class="actionBtn"><span>返回</span></a></li>
        </ul>

    </div>
</div>

<script type="text/javascript" src="<?php echo base_url()?>public/js/jscolor/jscolor.js"></script>
<form action="<?php echo site_url('admin/messageedit/' . $data['id'])?>" id="xform" name="xform" enctype="multipart/form-data" method="post">
    <table class="form_table">
        <tbody><tr>
            <td class="tb_title">姓名：</td>
        </tr>
        <tr>
            <td><?php echo $data['name'] ?></td>
        </tr>
        <tr>
            <td class="tb_title">留言内容：</td>
        </tr>
        <tr>
            <td><textarea id="comment" name="M[comment]" style="width:400px;height:150px;" disabled="disabled"><?php echo $data['comment'] ?></textarea></td>
        </tr>
        <tr>
            <td class="tb_title">回复内容：</td>
        </tr>
        <tr>
            <td><textarea id="reply" name="M[reply]" style="width:400px;height:150px;"><?php echo $data['reply'] ?></textarea></td>
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