<?php include_once('header.php'); ?>

<div id="contentHeader">
    <h3>公司录入</h3>
    <div class="searchArea">
        <ul class="action left" >
            <li class="current"><a href="<?php echo site_url('admin/companylist')?>" class="actionBtn"><span>返回</span></a></li>
            <li class="current"><a href="<?php echo site_url('admin/companycreate')?>" class="actionBtn"><span>录入</span></a></li>
        </ul>

    </div>
</div>

<script type="text/javascript" src="<?php echo base_url()?>public/js/jscolor/jscolor.js"></script>
<form action="<?php echo site_url('admin/companycreate')?>" id="xform" name="xform" enctype="multipart/form-data" method="post">
    <table class="form_table">
        <tbody><tr>
            <td class="tb_title">公司名称：</td>
        </tr>
        <tr>
            <td><input size="60" maxlength="128" class="validate[required]" name="Company[companyname]" id="Company_title" type="text"></td>
        </tr>
        <tr>
            <td class="tb_title">所属行业：</td>
        </tr>
        <tr>
            <td>
                <input type="text" name="job_Industry" id="industryTextValue" class="select_gb2" value="不限" />
                <input type="hidden"  name="IndustryValue" id="industryHiddenValue" value="0">
            </td>
        </tr>
        <!--<tr>
            <td><input size="60" maxlength="128" class="validate[required]" name="Company[sector]" id="Company_sector" type="text"></td>
        </tr>-->
        <tr>
            <td class="tb_title">公司Banner：</td>
        </tr>
        <tr>
            <td>
                <input class="validate[required]" name="banner" id="Company_banner" type="file">
            </td>
        </tr>
        <tr>
            <td class="tb_title">公司性质：</td>
        </tr>
        <tr>
            <td>
                <input type="text" name="job_Company" id="companyTextValue" class="select_gb2" value="不限" />
                <input type="hidden"  name="natureCompanyValue" id="companyHiddenValue" value="0">
                <!--<input size="60" maxlength="128" class="validate[required]" name="Company[nature]" id="Company_nature" type="text"></td>-->
        </tr>
        <tr>
            <td class="tb_title">成立日期：</td>
        </tr>
        <tr>
            <td><input size="60" maxlength="128" class="validate[required]" name="Company[birthday]" id="Company_birthday" type="text" onclick="javascript:WdatePicker()"></td>
        </tr>
        <tr>
            <td class="tb_title">注册资金：</td>
        </tr>
        <tr>
            <td>
                <input size="60" maxlength="128" class="validate[required]" name="Company[capital]" id="Company_capital" type="text">万元
                <?php foreach($this->config->item('currency') as $k => $v) { ?>
                <label><input type="radio" name="Company[currency]" value="<?php echo $k ?>" /><?php echo $v ?></label>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td class="tb_title">员工人数：</td>
        </tr>
        <tr>
            <td>
                <?php foreach($this->config->item('number') as $k => $v) { ?>
                    <label><input type="radio" name="Company[number]" value="<?php echo $k ?>" /><?php echo $v ?></label>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td class="tb_title">公司介绍：</td>
        </tr>
        <tr>
            <td><textarea id="info" name="Company[info]" style="width:700px;height:300px;"></textarea></td>
        </tr>
        <tr>
            <td class="tb_title">联系人：</td>
        </tr>
        <tr>
            <td><input size="60" maxlength="128" class="validate[required]" name="Company[people]" id="Company_people" type="text"></td>
        </tr>
        <tr>
            <td class="tb_title">手机号码：</td>
        </tr>
        <tr>
            <td><input size="60" maxlength="128" class="validate[required]" name="Company[mobile]" id="Company_mobile" type="text"></td>
        </tr>
        <tr>
            <td class="tb_title">电话号码：</td>
        </tr>
        <tr>
            <td><input size="60" maxlength="128" class="validate[required]" name="Company[telephone]" id="Company_telephone" type="text"></td>
        </tr>
        <tr>
            <td class="tb_title">传真：</td>
        </tr>
        <tr>
            <td><input size="60" maxlength="128" class="validate[required]" name="Company[fax]" id="Company_fax" type="text"></td>
        </tr>
        <tr>
            <td class="tb_title">电子邮箱：</td>
        </tr>
        <tr>
            <td><input size="60" maxlength="128" class="validate[required]" name="Company[email]" id="Company_email" type="text"></td>
        </tr>
        <tr>
            <td class="tb_title">地区：</td>
        </tr>
        <tr>
            <td>
                <input type="text" name="job_Area" id="areaTextValue" class="select_gb2" value="不限">
                <input type="hidden" name="areaValue" id="areaHiddenValue" value="0">
                <!--<input size="60" maxlength="128" class="validate[required]" name="Company[area]" id="Company_area" type="text">-->
            </td>
        </tr>
        <tr>
            <td class="tb_title">通讯地址：</td>
        </tr>
        <tr>
            <td>
                <input size="60" maxlength="128" class="validate[required]" name="Company[address]" id="Company_address" type="text">
            </td>
        </tr>
        <tr>
            <td class="tb_title">公司主页：</td>
        </tr>
        <tr>
            <td>
                <input size="60" maxlength="128" class="validate[required]" name="Company[site]" id="Company_site" type="text">
            </td>
        </tr>
        </tbody>
        <tbody><tr class="submit">
            <td colspan="2"><input type="submit" name="editsubmit" value="提交" class="button" tabindex="3"></td>
        </tr>
        </tbody></table>
    <script type="text/javascript">
        $(function(){
            //$("#xform").validationEngine();
        });
    </script>
</form>
    <script type="text/javascript" charset="utf-8" src="<?php echo base_url() ?>public/js/kindeditor/kindeditor-min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>public/js/My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>public/js/jquery.boxy.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/css/boxy/boxy.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/css/boxy_extends.css"/>
    <script type="text/javascript">
        var editor;
        KindEditor.ready(function(K) {
            editor = K.create('textarea[id="info"]', {
                allowFileManager : true,
                uploadJson : '<?php echo site_url('admin/postuploadimg') ?>'
            });
        });

        $("#industryTextValue").click(function() {
            Fn('checkbox',['行业类别选择器',1],'industry','industry');
        });
        $("#companyTextValue").click(function() {
            Fn('radio',['公司性质选择器',1],'company','company');
        });
        $("#areaTextValue").click(function() {
            Fn('lv3',['地区选择器',1],'area','area');
        });
    </script>
<?php include_once('footer.php'); ?>