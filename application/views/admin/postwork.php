<?php include_once('header.php'); ?>

    <div id="contentHeader">
        <h3>职位录入</h3>
        <div class="searchArea">
            <ul class="action left" >
                <li class="current"><a href="<?php echo site_url('admin/worklist/' . $companyid)?>" class="actionBtn"><span>返回</span></a></li>
            </ul>

        </div>
    </div>

    <script type="text/javascript" src="<?php echo base_url()?>public/js/jscolor/jscolor.js"></script>
    <form action="<?php echo site_url('admin/postwork/' . $companyid)?>" id="xform" name="xform" enctype="multipart/form-data" method="post">
        <table class="form_table">
            <tbody>

            <tr>
                <td class="tb_title">岗位名称：</td>
            </tr>
            <tr>
                <td><input size="60" maxlength="128" class="validate[required]" name="Work[workname]" id="Work_workname" type="text"></td>
            </tr>
            <tr>
                <td class="tb_title">招聘部门：</td>
            </tr>
            <tr>
                <td><input size="60" maxlength="128" class="validate[required]" name="Work[dept]" id="Work_dept" type="text"></td>
            </tr>
            <tr>
                <td class="tb_title">职位类别：</td>
            </tr>
            <tr>
                <td>
                    <!--<input size="60" maxlength="128" class="validate[required]" name="Work[jobkey]" id="Work_jobkey" type="text">-->
                    <input type="text" name="job_Type1" id="jobTextValue" class="select_gb2" value="不限">
                    <input type="hidden"  name="jobTypeValue1" id="jobHiddenValue" value="0">
                </td>
            </tr>

            <tr>
                <td class="tb_title">招聘人数：</td>
            </tr>
            <tr>
                <td><input size="60" maxlength="128" class="validate[required]" name="Work[numzhaopin]" id="Work_numzhaopin" type="text"></td>
            </tr>
            <tr>
                <td class="tb_title">起止日期：</td>
            </tr>
            <tr>
                <td>
                    <input onclick="javascript:WdatePicker()" size="30" maxlength="128" class="validate[required]" name="Work[timefrom]" id="Work_timefrom" type="text" value="">
                    至
                    <input onclick="javascript:WdatePicker()" size="30" maxlength="128" class="validate[required]" name="Work[timeto]" id="Work_timeto" type="text" value="">
                </td>
            </tr>
            <tr>
                <td class="tb_title">薪资待遇：</td>
            </tr>
            <tr>
                <td>
                    <select name="Work[moneykey]">
                        <?php foreach($this->config->item('moneykey') as $k => $v) { ?>
                            <option value="<?php echo $k ?>"><?php echo $v ?></option>
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
                        <label><input type="checkbox" name="Work[welfare][]" value="<?php echo $k ?>" /><?php echo $v ?></label>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td class="tb_title">工作地区：</td>
            </tr>
            <tr>
                <td><!--<input size="60" maxlength="128" class="validate[required]" name="Work[areakey]" id="Work_areakey" type="text">-->
                    <input type="text" name="job_Area" id="area1TextValue" class="select_gb2" value="不限" />
                    <input type="hidden" name="jobAreaValue" id="area1HiddenValue" value="0" /></td>
                </td>
            </tr>
            <tr>
                <td class="tb_title">职位描述：</td>
            </tr>
            <tr>
                <td><textarea id="describe" name="Work[describe]" style="width:700px;height:300px;"></textarea></td>
            </tr>
            <tr>
                <td class="tb_title">职位诱惑：</td>
            </tr>
            <tr>
                <td><input size="60" maxlength="128" class="validate[required]" name="Work[tempt]" id="Work_tempt" type="text"></td>
            </tr>
            <tr>
                <td class="tb_title">要求工作性质：</td>
            </tr>
            <tr>
                <td><!--<input size="60" maxlength="128" class="validate[required]" name="Work[jobnaturekey]" id="Work_jobnaturekey" type="text">-->
                    <input type="text" name="job_Company" id="jobnatureTextValue" class="select_gb2" value="全职">
                    <input type="hidden"  name="jobCompanyValue" id="jobnatureHiddenValue" value="350">
                </td>
            </tr>
            <tr>
                <td class="tb_title">要求户籍所在地：</td>
            </tr>
            <tr>
                <td><!--<input size="60" maxlength="128" class="validate[required]" name="Work[birthaddress]" id="Work_birthaddress" type="text">-->
                    <input type="text" name="live_Area" id="area2TextValue" class="select_gb2" value="不限">
                    <input type="hidden" name="liveAreaValue" id="area2HiddenValue" value="0">
                </td>
            </tr>
            <tr>
                <td class="tb_title">要求学历：</td>
            </tr>
            <tr>
                <td><!--<input size="60" maxlength="128" class="validate[required]" name="Work[edukey]" id="Work_edukey" type="text">-->
                    <input type="text" name="job_Edu" id="eduTextValue" class="select_gb2" value="不限" />
                    <input type="hidden"  name="jobEduValue" id="eduHiddenValue" value="0" />
                </td>
            </tr>
            <tr>
                <td class="tb_title">要求工作经验：</td>
            </tr>
            <tr>
                <td>
                    <select name="Work[expkey]">
                        <?php foreach($this->config->item('expkey') as $k => $v) { ?>
                        <option value="<?php echo $k ?>"><?php echo $v ?></option>
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
                            <option value="<?php echo $k ?>"><?php echo $v ?></option>
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
                            <option value="<?php echo $k ?>"><?php echo $v ?></option>
                        <?php } ?>
                    </select>
                    至
                    <select name="Work[maxage]">
                        <?php foreach($this->config->item('age') as $k => $v) { ?>
                            <option value="<?php echo $k ?>"><?php echo $v ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tb_title">面试须知：</td>
            </tr>
            <tr>
                <td><textarea id="notice" name="Work[notice]" style="width:700px;height:300px;"></textarea></td>
            </tr>
            <tr>
                <td class="tb_title">是否需要报名应聘：</td>
            </tr>
            <tr>
                <td>
                    <select name="p_type" id="p_type">
                        <option value="0">直接应聘</option>
                        <option value="1">报名应聘</option>
                    </select>
                </td>
            </tr>
            <tbody id="isshow" style="display: none">
            <tr>
                <td class="tb_title">报名协议：</td>
            </tr>
            <tr>
                <td><textarea id="protocol_content" name="protocol_content" style="width:700px;height:300px;"></textarea></td>
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