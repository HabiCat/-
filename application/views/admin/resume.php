<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>华中人才库</title>
    <link rel="stylesheet" type="text/css" href='<?php echo base_url();?>public/admin/css/common.css'>
    <script>
        window.onload=function(){
            table(document.getElementsByTagName("table")[0],2);
        }


        function deleteSelectItem(){
            var $form=document.forms[0];
            $form.action="_delete_batch.php";
            $form.submit();
        }

        function no_pass(){
            var $form=document.forms[0];
            $form.action="_on_pass.php";
            $form.submit();
        }
        function refreshResume(){
            var form=document.forms[0];
            var flag = 0, box = document.getElementsByName('checkbox[]');
            for(var i=0;i<box.length;i++){
                if(box[i].checked == true){
                    flag++;
                }
            }
            if(flag == 0){
                alert('请选择');
                return false;
            }else{
                form.action="_refreshResume.php";
                form.submit();
            }
        }

    </script>
</head>

<body>
<form method="get">
    <div class="wp">
        <table width="100%">
            <tr>
                <th><!--<a href="#" onclick="javascript:deleteSelectItem();">删</a>--></th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th><input type="text" name="text_user"  size="7" onkeydown="javascript:getKeyDown(this.form,event);" value=""/></th>
                <th><input type="text" name="text_num"  size="7" onkeydown="javascript:getKeyDown(this.form,event);" value=""/></th>
                <th><input type="text" name="text_name"  size="7" onkeydown="javascript:getKeyDown(this.form,event);" value="<?php //echo $name; ?>"/></th>
                <th><select name="sex" onchange="javascript:this.form.submit();">
                        <option value="" selected="selected">全</option>
                        <option value="1"<?php if($data['sex']=='1'){echo 'selected="selected"';} ?>>男</option>
                        <option value="0"<?php if($data['sex']=='0'){echo 'selected="selected"';} ?>>女</option>
                    </select></th>
                <th><input type="text" name="agekey"  size="7" onkeydown="javascript:getKeyDown(this.form,event);" value="<?php //echo $agekey; ?>"/></th>
                <th><select name="jobname" id="jobname" onchange="javascript:this.form.submit();">
                        <option value="0">全部</option>
                        <?php
                            $jobmanagemen = $this->config->item('jobmanagemen');
                            foreach($jobmanagemen as $k => $v) {
                        ?>
                        <option value="<?php echo $k ?>"><?php echo $v ?></option>
                        <?php } ?>
                    </select>
                </th>
                <th>&nbsp;</th>
                <th><input type="text" name="text_mobile"  size="7" onkeydown="javascript:getKeyDown(this.form,event);" value="<?php //echo $mobile; ?>"/></th>
                <th><input type="text" name="text_email"  size="7" onkeydown="javascript:getKeyDown(this.form,event);" value="<?php //echo $email; ?>"/></th>
                <th><input type="text" name="text_qq"  size="7" onkeydown="javascript:getKeyDown(this.form,event);" value="<?php //echo $qq; ?>"/></th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <th width="10"><input type="checkbox" name="checkboxtool" onclick="javascript:checkAll(this.form,'checkbox[]',this.checked);markAll(document.getElementsByTagName('table')[0],1,this.checked);"/></th>
                <th width="20"><a href="#" onclick="javascript:checkReverse(document.forms[0],'checkbox[]');markReverse(document.getElementsByTagName('table')[0],1);">反</a></th>
                <th width="20">完整度</th>
                <th width="30">更新时间</th>
                <th width="30">账号</th>
                <th width="50">姓名</th>
                <th width="20">性别</th>
                <th width="20">年龄</th>
                <th width="100">求职意向</th>
                <th width="50">固定电话</th>
                <th width="50">手机号</th>
                <th width="80">邮箱</th>
                <th width="50">QQ</th>
            </tr><?php
            $i = 1 + 10 * (max($this->input->get("page"), 1) - 1);
            foreach($result as $row) {
                ?><tr>
                <th><input type="checkbox" name="checkbox[]" value="<?php echo $row["personid"]; ?>" /></th>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row['wanzhengdu'];?>%</td>
                <td><?php echo substr($row['timerefresh'],0,10);?></td>
                <td><?php echo $row['useraccount'];?></td>
                <td><?php echo $row['personname'];?></td>
                <td><?php if($row['sex']==1){echo "男";}
                    else{echo "女";}
                    ?></td>
                <td><?php echo $row['agekey'];?></td>
                <td><?php
                    $arr='';
                    foreach(explode(',',$row['jobkey']) as $v){
                        $arr.=$jobmanagemen[$v].',';
                    }
                    echo trim($arr,',');
                    ?></td>
                <td><?php echo $row['tel'];?></td>
                <td><?php echo $row['mobile'];?></td>
                <td><?php echo $row['email'];?></td>
                <td><?php echo $row['qq'];?></td>
                </tr>
            <?php } ?>
        </table>
        <br />
        <div class="indexpage"><?php echo $page?></div>
    </div>
    <div class="keywords" style="margin:20px; padding-left:50px;">
        <input type="text" name="keywords" size="30" value="" /><input type="submit" name="keysubmit" value="搜索" /><label style="margin-left:20px; color:#F00;">*本关键词搜索只匹配简历的求职意向</label>
    </div>
</form>
</body>
</html>
<script type="text/javascript">
    function post(){
        var $f=document.forms[0];
        $f.action="get.php";
        $f.target="_blank";
        $f.submit();
    }

    function goPage($pageno){
        var $f=document.forms[0];
        $f.select_pageno.selectedIndex=$pageno-1;
        $f.submit();
    }
    function getKeyDown($form,$e){
        var $keycode;
        if(window.event){
            $keycode=$e.keyCode;
        }else if($e.which){
            $keycode=$e.which;
        }
        if($keycode==13){
            $form.submit();
            return false;
        }
    }
    <?php
    if($jobname!=''){
        echo '
        var jobSel = document.getElementById("jobname").options;
        for(var i=0;i<jobSel.length;i++){
            if(jobSel[i].value=='.$jobname.'){
                jobSel[i].style.background="#ccc";
                jobSel[i].selected=true;
            }
        }
        ';
    }
    ?>
</script>
