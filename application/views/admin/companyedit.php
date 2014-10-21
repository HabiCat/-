<?php include_once('header.php'); ?>

    <div id="contentHeader">
        <h3>公司信息修改</h3>
        <div class="searchArea">
            <ul class="action left" >
                <li class="current"><a href="<?php echo site_url('admin/companylist')?>" class="actionBtn"><span>返回</span></a></li>
                <li class="current"><a href="<?php echo site_url('admin/companycreate')?>" class="actionBtn"><span>录入</span></a></li>
            </ul>
        </div>
    </div>

    <script type="text/javascript" src="<?php echo base_url()?>public/js/jscolor/jscolor.js"></script>
    <form action="<?php echo site_url('admin/companyedit/' . $data['companyid'])?>" id="xform" name="xform" enctype="multipart/form-data" method="post">
        <table class="form_table">
            <tbody><tr>
                <td class="tb_title">公司名称：</td>
            </tr>
            <tr>
                <td><input size="60" maxlength="128" class="validate[required]" name="Company[companyname]" id="Company_companyname" type="text" value="<?php echo $data['companyname'] ?>"></td>
            </tr>
            <tr>
                <td class="tb_title">所属行业：</td>
            </tr>
            <tr>
                <td>
                    <?php $industry = $this->config->item('industry'); ?>
                    <input type="text" name="job_Industry" id="industryTextValue" class="select_gb2" value="<?php echo $industry[$data['sector']] ?>" />
                    <input type="hidden"  name="IndustryValue" id="industryHiddenValue" value="<?php echo $data['sector'] ?>">
                </td>
            </tr>

            <tr>
                <td class="tb_title">公司Banner：</td>
            </tr>
            <tr>
                <td>
                    <input class="validate[required]" name="banner" id="Company_banner" type="file">
                    <input type="hidden" name="hiddenbanner" value="<?php echo $data['banner'] ?>" />
                    <img src="<?php echo '/uploads/' . $data['banner'] ?>" />
                </td>
            </tr>
            <tr>
                <td class="tb_title">公司性质：</td>
            </tr>
            <tr>
                <td>
                    <?php $companytype = $this->config->item('companytype'); ?>
                    <input type="text" name="job_Company" id="companyTextValue" class="select_gb2" value="<?php echo $companytype[$data['nature']] ?>" />
                    <input type="hidden"  name="natureCompanyValue" id="companyHiddenValue" value="<?php echo $data['nature'] ?>">
                </td>
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
                    <input size="60" maxlength="128" class="validate[required]" name="Company[capital]" id="Company_capital" type="text" value="<?php echo $data['capital'] ?>">万元
                    <?php foreach($this->config->item('currency') as $k => $v) { ?>
                        <label><input type="radio" name="Company[currency]" value="<?php echo $k ?>" <?php if($data['currency'] == $k) echo 'checked="checked"' ?> /><?php echo $v ?></label>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td class="tb_title">员工人数：</td>
            </tr>
            <tr>
                <td>
                    <?php foreach($this->config->item('number') as $k => $v) { ?>
                        <label><input type="radio" name="Company[number]" value="<?php echo $k ?>" <?php if($data['number'] == $k) echo 'checked="checked"' ?> /><?php echo $v ?></label>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td class="tb_title">公司介绍：</td>
            </tr>
            <tr>
                <td><textarea id="info" name="Company[info]" style="width:700px;height:300px;"><?php echo $data['info'] ?></textarea></td>
            </tr>
            <tr>
                <td class="tb_title">联系人：</td>
            </tr>
            <tr>
                <td><input size="60" maxlength="128" class="validate[required]" name="Company[people]" id="Company_people" type="text" value="<?php echo $data['people'] ?>"></td>
            </tr>
            <tr>
                <td class="tb_title">手机号码：</td>
            </tr>
            <tr>
                <td><input size="60" maxlength="128" class="validate[required]" name="Company[mobile]" id="Company_mobile" type="text" value="<?php echo $data['mobile'] ?>"></td>
            </tr>
            <tr>
                <td class="tb_title">电话号码：</td>
            </tr>
            <tr>
                <td><input size="60" maxlength="128" class="validate[required]" name="Company[telephone]" id="Company_telephone" type="text" value="<?php echo $data['telephone'] ?>"></td>
            </tr>
            <tr>
                <td class="tb_title">传真：</td>
            </tr>
            <tr>
                <td><input size="60" maxlength="128" class="validate[required]" name="Company[fax]" id="Company_fax" type="text" value="<?php echo $data['fax'] ?>"></td>
            </tr>
            <tr>
                <td class="tb_title">电子邮箱：</td>
            </tr>
            <tr>
                <td><input size="60" maxlength="128" class="validate[required]" name="Company[email]" id="Company_email" type="text" value="<?php echo $data['email'] ?>"></td>
            </tr>
            <tr>
                <td class="tb_title">地区：</td>
            </tr>
            <tr>
                <td>
                    <?php $area = $this->config->item('area'); ?>
                    <input type="text" name="job_Area" id="areaTextValue" class="select_gb2" value="<?php echo $area[$data['area']] ?>">
                    <input type="hidden" name="areaValue" id="areaHiddenValue" value="<?php echo $data['area']; ?>">
                </td>
            </tr>
            <tr>
                <td class="tb_title">通讯地址：</td>
            </tr>
            <tr>
                <td><input size="60" maxlength="128" class="validate[required]" name="Company[address]" id="Company_address" type="text" value="<?php echo $data['address'] ?>"></td>
            </tr>
            <tr>
                <td class="tb_title">公司主页：</td>
            </tr>
            <tr>
                <td>
                    <input size="60" maxlength="128" class="validate[required]" name="Company[site]" id="Company_site" type="text" value="<?php echo $data['site'] ?>">
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