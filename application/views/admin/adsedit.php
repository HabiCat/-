<?php include_once('header.php'); ?>

<div id="contentHeader">
    <h3>内容管理</h3>
    <div class="searchArea">
        <ul class="action left" >
            <li class="current"><a href="<?php echo site_url('admin/ads')?>" class="actionBtn"><span>返回</span></a></li>
        </ul>

    </div>
</div>

<script type="text/javascript" src="<?php echo base_url()?>public/js/jscolor/jscolor.js"></script>
<form action="<?php echo site_url('admin/adsedit/' . $data['id'])?>" id="xform" name="xform" enctype="multipart/form-data" method="post">
    <table class="form_table">
        <tbody><tr>
            <td class="tb_title">标题：</td>
        </tr>
        <tr>
            <td><input size="60" maxlength="128" class="validate[required]" name="Ads[title]" id="Ads_title" type="text" value="<?php echo $data['title'] ?>"></td>
        </tr>
        <tr>
            <td class="tb_title">广告位置：</td>
        </tr>
        <tr>
            <?php $ads = $this->config->item('ads'); ?>
            <td>
                <select name="Ads[pos]" id="Ads_pos">
                    <?php foreach($ads as $k => $row) { ?>
                        <option value="<?php echo $k ?>" <?php if($k == $data['pos']) echo 'selected="selected"' ?>><?php echo $row ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="tb_title">广告文字：</td>
        </tr>
        <tr>
            <td><input size="20" maxlength="128" name="Ads[describe]" id="Ads_describe" type="text" value="<?php echo $data['describe'] ?>"></td>
        </tr>
        <tr>
            <td class="tb_title">广告链接：</td>
        </tr>
        <tr>
            <td><input size="60" maxlength="128" name="Ads[url]" id="Ads_url" type="text" value="<?php echo $data['url'] ?>"></td>
        </tr>
        <tr>
            <td class="tb_title">广告图片：</td>
        </tr>
        <tr>
            <td>
                <input class="validate[]" name="img" id="Post_img" type="file">
                <input type="hidden" name="hiddenimg" value="<?php echo $data['img'] ?>" />
                <img src="<?php echo '/uploads/' . $data['img'] ?>" />
            </td>
        </tr>
        <tr>
            <td class="tb_title">起止日期：</td>
        </tr>
        <tr>
            <td>
                <input onclick="javascript:WdatePicker()" value="<?php echo date('Y-m-d', $data['timefrom']); ?>" size="30" maxlength="128" class="validate[required]" name="Ads[timefrom]" id="Ads_timefrom" type="text" value="">
                至
                <input onclick="javascript:WdatePicker()" value="<?php echo date('Y-m-d', $data['timeto']); ?>" size="30" maxlength="128" class="validate[required]" name="Ads[timeto]" id="Ads_timeto" type="text" value="">
            </td>
        </tr>
        <tr>
            <td class="tb_title">是否上架：</td>
        </tr>
        <tr>
            <td>
                <select name="Ads[status]" id="Ads_status">
                    <option value="0" <?php if($data['status'] == 0) echo 'selected="selected"' ?>>下架</option>
                    <option value="1" <?php if($data['status'] == 1) echo 'selected="selected"' ?>>上架</option>
                </select>
            </td>
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
    <script type="text/javascript" src="<?php echo base_url() ?>public/js/My97DatePicker/WdatePicker.js"></script>
<?php include_once('footer.php'); ?>