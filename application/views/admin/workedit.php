<?php include_once('header.php'); ?>

    <div id="contentHeader">
        <h3>职位录入</h3>
        <div class="searchArea">
            <ul class="action left" >
                <li class="current"><a href="<?php echo site_url('admin/worklist/' . $rs['companyid'])?>" class="actionBtn"><span>返回</span></a></li>
            </ul>

        </div>
    </div>

    <script type="text/javascript" src="<?php echo base_url()?>public/js/jscolor/jscolor.js"></script>
    <form action="<?php echo site_url('admin/workedit/' . $rs['autoid'])?>" id="xform" name="xform" enctype="multipart/form-data" method="post">
        <table class="form_table">
            <tbody>

            <tr>
                <td class="tb_title">岗位名称：</td>
            </tr>
            <tr>
                <td><input size="60" maxlength="128" class="validate[required]" name="Work[workname]" id="Work_workname" type="text" value="<?php echo $rs['workname'] ?>"></td>
            </tr>
            <tr>
                <td class="tb_title">招聘部门：</td>
            </tr>
            <tr>
                <td><input size="60" maxlength="128" class="validate[required]" name="Work[dept]" id="Work_dept" type="text" value="<?php echo $rs['dept'] ?>"></td>
            </tr>
            <tr>
                <td class="tb_title">职位类别：</td>
            </tr>
            <tr>
                <td>
                    <?php $jobmanagemen = $this->config->item('jobmanagemen'); ?>
                    <input type="text" name="job_Type1" id="jobTextValue" class="select_gb2" value="<?php echo $jobmanagemen[$rs['jobkey']] ?>">
                    <input type="hidden"  name="jobTypeValue1" id="jobHiddenValue" value="<?php echo $rs['jobkey'] ?>">
                </td>
            </tr>

            <tr>
                <td class="tb_title">招聘人数：</td>
            </tr>
            <tr>
                <td><input size="60" maxlength="128" class="validate[required]" name="Work[numzhaopin]" id="Work_numzhaopin" type="text" value="<?php echo $rs['numzhaopin'] ?>"></td>
            </tr>

            <tr>
                <td class="tb_title">起止日期：</td>
            </tr>
            <tr>
                <td>
                    <input onclick="javascript:WdatePicker()" size="30" maxlength="128" class="validate[required]" name="Work[timefrom]" id="Work_timefrom" type="text" value="<?php echo date('Y-m-d', $rs['timefrom']) ?>">
                    至
                    <input onclick="javascript:WdatePicker()" size="30" maxlength="128" class="validate[required]" name="Work[timeto]" id="Work_timeto" type="text" value="<?php echo date('Y-m-d', $rs['timeto']) ?>">
                </td>
            </tr>

            <tr>
                <td class="tb_title">薪资待遇：</td>
            </tr>
            <tr>
                <td>
                    <select name="Work[moneykey]">
                        <?php foreach($this->config->item('moneykey') as $k => $v) { ?>
                            <option value="<?php echo $k ?>" <?php if($k == $rs['moneykey']) echo 'selected="selected"' ?>><?php echo $v ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tb_title">福利补助：</td>
            </tr>
            <tr>
                <td>
                    <?php foreach($this->config->item('welfare') as $k => $v) { ?>
                        <label><input type="checkbox" name="Work[welfare][]" value="<?php echo $k ?>" <?php if(in_array($k, explode(',', $rs['welfare']))) echo 'checked="checked"' ?>/><?php echo $v ?></label>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td class="tb_title">工作地区：</td>
            </tr>
            <tr>
                <td>
                    <?php $area = $this->config->item('area'); ?>
                    <input type="text" name="job_Area" id="area1TextValue" class="select_gb2" value="<?php echo $area[$rs['areakey']] ?>" />
                    <input type="hidden" name="jobAreaValue" id="area1HiddenValue" value="<?php echo $rs['areakey'] ?>" /></td>
                </td>
            </tr>
            <tr>
                <td class="tb_title">职位描述：</td>
            </tr>
            <tr>
                <td><textarea id="describe" name="Work[describe]" style="width:700px;height:300px;"><?php echo $rs['describe'] ?></textarea></td>
            </tr>
            <tr>
                <td class="tb_title">职位诱惑：</td>
            </tr>
            <tr>
                <td><input size="60" maxlength="128" class="validate[required]" name="Work[tempt]" id="Work_tempt" type="text" value="<?php echo $rs['tempt'] ?>"></td>
            </tr>
            <tr>
                <td class="tb_title">要求工作性质：</td>
            </tr>
            <tr>
                <td>
                    <?php $jobnaturekey = $this->config->item('jobnaturekey'); ?>
                    <input type="text" name="job_Company" id="jobnatureTextValue" class="select_gb2" value="<?php echo $jobnaturekey[$rs['jobnaturekey']] ?>">
                    <input type="hidden"  name="jobCompanyValue" id="jobnatureHiddenValue" value="<?php echo $rs['jobnaturekey'] ?>">
                </td>
            </tr>
            <tr>
                <td class="tb_title">要求户籍所在地：</td>
            </tr>
            <tr>
                <td>
                    <input type="text" name="live_Area" id="area2TextValue" class="select_gb2" value="<?php echo $area[$rs['birthaddress']] ?>">
                    <input type="hidden" name="liveAreaValue" id="area2HiddenValue" value="<?php echo $rs['birthaddress'] < 0 ? 0 : $rs['birthaddress'] ?>">
                </td>
            </tr>
            <tr>
                <td class="tb_title">要求学历：</td>
            </tr>
            <tr>
                <td>
                    <?php $education = $this->config->item('education'); ?>
                    <input type="text" name="job_Edu" id="eduTextValue" class="select_gb2" value="<?php echo $education[$rs['edukey']] ?>" />
                    <input type="hidden"  name="jobEduValue" id="eduHiddenValue" value="<?php echo $rs['edukey'] ?>" />
                </td>
            </tr>
            <tr>
                <td class="tb_title">要求工作经验：</td>
            </tr>
            <tr>
                <td>
                    <select name="Work[expkey]">
                        <?php foreach($this->config->item('expkey') as $k => $v) { ?>
                        <option value="<?php echo $k ?>" <?php if($k == $rs['expkey']) echo 'selected="selected"' ?>><?php echo $v ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tb_title">要求性别：</td>
            </tr>
            <tr>
                <td>
                    <select name="Work[sex]">
                        <?php foreach($this->config->item('sex') as $k => $v) { ?>
                            <option value="<?php echo $k ?>" <?php if($k == $rs['sex']) echo 'selected="selected"' ?>><?php echo $v ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tb_title">要求年龄：</td>
            </tr>
            <tr>
                <td>
                    <select name="Work[minage]">
                        <?php foreach($this->config->item('age') as $k => $v) { ?>
                            <option value="<?php echo $k ?>" <?php if($k == $rs['minage']) echo 'selected="selected"' ?>><?php echo $v ?></option>
                        <?php } ?>
                    </select>
                    至
                    <select name="Work[maxage]">
                        <?php foreach($this->config->item('age') as $k => $v) { ?>
                            <option value="<?php echo $k ?>" <?php if($k == $rs['maxage']) echo 'selected="selected"' ?>><?php echo $v ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tb_title">面试须知：</td>
            </tr>
            <tr>
                <td><textarea id="notice" name="Work[notice]" style="width: 415px; height: 130px;"><?php echo $rs['notice'] ?></textarea></td>
            </tr>
            <tr>
                <td class="tb_title">是否需要报名应聘：</td>
            </tr>
            <tr>
                <td>
                    <select name="p_type" id="p_type">
                        <option value="0" <?php if($rs['protocol'] == 0) echo 'selected="selected"' ?>>直接应聘</option>
                        <option value="1" <?php if($rs['protocol'] == 1) echo 'selected="selected"' ?>>报名应聘</option>
                    </select>
                </td>
            </tr>
            <tbody id="isshow" <?php if($rs['protocol'] == 0) { ?>style="display: none"<?php } ?>>
            <tr>
                <td class="tb_title">报名协议：</td>
            </tr>
            <tr>
                <td><textarea id="protocol_content" name="protocol_content" style="width: 415px; height: 130px;"><?php echo $rs['content'] ?></textarea></td>
            </tr>
            </tbody>
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
            editor = K.create('textarea[id="describe"]', {
                allowFileManager : true,
                width : '566px',
                uploadJson : '<?php echo site_url('admin/postuploadimg') ?>'
            });
        });

        $("#jobTextValue").click(function() {
            Fn('lv2',['职位类别选择器',1],'job','job');
        });
        $("#area1TextValue").click(function() {
            Fn('lv3',['岗位所在地区选择器',1],'area','area1');
        });
        $("#jobnatureTextValue").click(function() {
            Fn('checkbox',['工作性质选择器',5],'jobnature','jobnature');
        });
        $("#area2TextValue").click(function() {
            Fn('lv3',['户籍现居地区选择器',1],'area','area2');
        });
        $("#eduTextValue").click(function() {
            Fn('radio',['学历要求选择器',1],'edu','edu');
        });

        $(function () {
            //jQuery("#select1  option:selected").text();
            $('#p_type').bind('change', function () {
                if($(this).val() == 0) {
                    $('#isshow').css('display', 'none');
                } else {
                    $('#isshow').css('display', 'block');
                }
            });
        });
    </script>
<?php include_once('footer.php'); ?>