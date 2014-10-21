<?php include_once('header.php'); ?>

<div id="contentHeader">
    <h3>报名管理</h3>
    <div class="searchArea">
        <div class="search right">
            <form action="<?php echo site_url('admin/replylist');?>" name="xform" id="searchForm" method="get" class="right">
            <!--<a href="">普通应聘</a>
            <a href="">报名应聘</a>-->
            应聘者姓名
            <input id="title" type="text" name="name" value="" class="txt" size="15"/>
            <input name="searchsubmit" type="submit"  value="查询" class="button "/>
            <script type="text/javascript">
                $(function(){
                    $("#xform").validationEngine();
                });
            </script>
            </form>
        </div>
    </div>
</div>

<table border="0" cellpadding="0" cellspacing="0" class="content_list">
    <form method="post" action="<?php echo site_url('admin/workbatch');?>" name="cpform" >
        <thead>
        <tr class="tb_header">
            <th width="4%">ID</th>
            <th>应聘者姓名</th>
            <th>性别</th>
            <th>职位名称</th>
            <th>公司名称</th>
            <th>年龄</th>
            <th>学历</th>
            <th>专业</th>
            <th>毕业学校</th>
            <th>手机号</th>
            <th>身份证号</th>
            <th>应聘时间</th>
            <th>状态</th>
            <th width="8%">操作</th>
        </tr>
        </thead>
        <?php foreach ($datalist as $row):?>
            <tr class="tb_list">
                <td ><input type="checkbox" name="id[]" value="<?php echo $row['id']?>"><?php echo $row['id']?></td>
                <td ><a href="http://www.111job.cn/searchresume/resume_xy.php?resumeid=<?php echo $row['personid'] ?>" target="_blank"><?php echo $row['name']?></a></td>
                <td >
                    <?php
                        $sex = $this->config->item('sex');
                        echo $sex[$row['sex']];
                    ?>
                </td>
                <td ><?php echo $row['workname']?></td>
                <td ><?php echo $row['companyname']?></td>
                <td><?php echo $row['age']?></td>
                <td><?php echo $row['edu']?></td>
                <td><?php echo $row['major']?></td>
                <td ><?php echo $row['school']?></td>
                <td><?php echo $row['mobile']?></td>
                <td><?php echo $row['icard']?></td>
                <td ><?php echo date('Y-m-d H:i',$row['replytime'])?></td>
                <td ><?php if($row['isp']) { echo '报名应聘'; } else { echo '投简历'; } ?></td>
                <td ><a href="<?php echo  site_url('admin/replybatch/delete/' . $row['id'])?>" class="confirmSubmit"><img src="<?php echo base_url()?>public/admin/images/delete.png" align="absmiddle" /></a></td>
            </tr>
        <?php endforeach;?>
        <tr class="operate">
            <td colspan="6"><div class="cuspages right">
                <?php echo $page ?>
                </div>
                <div class="fixsel">
                    <input type="checkbox" name="chkall" id="chkall" onClick="checkAll(this.form, 'id')" />
                    <label for="chkall">全选</label>
                    <select name="command">
                        <option>选择操作</option>
                        <option value="delete">删除</option>
                    </select>
                    <input id="submit_maskall" class="button confirmSubmit" type="submit" value="提交" name="maskall" />
                </div></td>
        </tr>
    </form>
</table>
<?php include_once('footer.php'); ?>
