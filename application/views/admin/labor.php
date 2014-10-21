<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>华中普工库</title>
    <link rel="stylesheet" type="text/css" href='<?php echo base_url();?>public/admin/css/common.css'>
    <script>
        window.onload=function(){
            table(document.getElementsByTagName("table")[0],2);

        }
        function deleteSelectItem(){
            var $from=document.forms[0];
            $from.action="_delete_batch.php";
            $from.submit();
        }

    </script>
</head>
<body>
<form method="get" action="">
    <div id="head"><div>普技工管理</div></div>
    <table width="100%">
        <tr>
            <th height="25" colspan="2"><a href="#" onclick="javascript:deleteSelectItem();">删</a></th>
            <th width="10%"><input type="text" name="text_name"  size="8" onkeydown="javascript:getKeyDown(this.form,event);" value="<?php echo $data['p_name']; ?>"/></th>
            <th width="8%"><select name="select_sex" onchange="javascript:this.form.submit();">
                    <option value="2" <?php if($data['select_sex']==2){echo 'selected="selected"';} ?>>全</option>
                    <option value="1" <?php if($data['select_sex']==1){echo 'selected="selected"';} ?>>男</option>
                    <option value="0" <?php if($data['select_sex']==0){echo 'selected="selected"';} ?>>女</option>
                </select></th>
            <th width="8%"><select name="select_age"onchange="javascript:this.form.submit();">
                    <option value="">全</option>
                    <?php
                    for($i=18;$i<=60;$i++){
                        if($select_age!=$i){
                            echo ' <option value="'.$i.'">'.$i.'</option>';
                        }else{
                            echo ' <option value="'.$i.'" selected="selected">'.$i.'</option>';
                        }
                    }
                    ?>
                </select></th>
            <th width="7%"><input name="text_place" type="text"onkeydown="javascript:getKeyDown(this.form,event);" value="<?php echo $data['text_place']; ?>" size="6"/></th>

            <th width="10%"><select name="select_job" onchange="javascript:this.form.submit();">
                    <option value="0">全部</option>
                    <?php
                    $jobmanagemen = $this->config->item('jobmanagemen');
                    foreach($jobmanagemen as $kk=>$vv){
                        if($job_type==$kk){
                            if($kk=='326'||$kk=='348'||$kk=='354'||$kk=='310'||$kk=='344'||$kk=='352'){
                                echo "<option value=\"$kk\" selected=\"selected\">$vv</option>";
                            }else{
                                echo "<option value=\"$kk\" selected=\"selected\">&nbsp;&nbsp;&nbsp;&nbsp;$vv</option>";
                            }
                        }else{
                            if($kk=='326'||$kk=='348'||$kk=='354'||$kk=='310'||$kk=='344'||$kk=='352'){
                                echo "<option value=\"$kk\">$vv</option>";
                            }else{
                                echo "<option value=\"$kk\">&nbsp;&nbsp;&nbsp;&nbsp;$vv</option>";
                            }

                        }

                    }
                    ?>
                </select></th>

            <td width="10%">&nbsp;</td>
            <th colspan="2"><input type="text" name="text_from"  size="6" onkeydown="javascript:getKeyDown(this.form,event);" value="<?php echo $data['text_from']; ?>"/>
                ~
                <input type="text" name="text_to"  size="6" onkeydown="javascript:getKeyDown(this.form,event);" value="<?php echo $data['text_to']; ?>"/></th>
            <th colspan="2"><a href="<?php echo site_url('admin/labor') ?>">显示全部</a></th>
        </tr>
        <tr>
            <th width="4%"><input type="checkbox" name="checkboxtool" onclick="javascript:checkAll(this.form,'checkbox[]',this.checked);markAll(document.getElementsByTagName('table')[0],1,this.checked);"/></label></th>
            <th width="6%"><a href="#" onclick="javascript:checkReverse(document.forms[0],'checkbox[]');markReverse(document.getElementsByTagName('table')[0],1);">反选</a></th>
            <th>用户名</th>
            <th>性别</th>
            <th>年龄</th>
            <th>地区</th>
            <th>工种</th>
            <th>电话</th>
            <th width="12%">注册时间</th>
            <th width="8%">审核状态</th>
        </tr>
        <?php
        $i = 1 + 10 * (max($this->input->get("page"), 1) - 1);
        foreach($result as $row) {
        ?>
            <tr>
                <th><input type="checkbox" name="checkbox[]" value="<?php echo $row["autoid"]; ?>" /></th>
                <label>
                    <th><?php echo $i++;?></th>
                    <td><?php echo $row['p_name'];?></td>
                    <td><?php if($row['p_sex']==1){ echo '男';}else{ echo '女';}?></td>
                    <td><?php echo $row['p_age'];?></td>
                    <td><?php echo $row['p_place']; ?></td>
                    <td><?php echo $jobmanagemen[$row['p_job']];?></td>
                    <td><?php echo $row['p_phone'];?></td>
                    <td><?php echo $row['intime'];?></td>
                    <td width="6%"><?php if($row['flag']){ echo '审核通过';}else{ echo '审核未通过'; }?></td>
            </tr>
        <?php
        }
        ?>
    </table>

    <!--翻页程序-->
    <div><?php echo $page; ?></div>
</form>
<script type="text/javascript">
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
</script>
</body>
</html>