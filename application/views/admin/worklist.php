<?php include_once('header.php'); ?>

<div id="contentHeader">
    <h3>职位管理</h3>
    <div class="searchArea">
        <ul class="action left">
            <li><a href="<?php echo site_url('admin/postwork/' . $companyid);?>" class="actionBtn"><span>录入</span></a></li>
            <li><a href="<?php echo site_url('admin/companylist')?>" class="actionBtn"><span>返回</span></a></li>
        </ul>
        <div class="search right">
            <form action="<?php echo site_url('admin/worklist/' . $companyid);?>" name="xform" id="searchForm" method="get" class="right">
            职位名称
            <input id="title" type="text" name="workname" value="" class="txt" size="15"/>
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
            <th width="10%">ID</th>
            <th>职位名称</th>
            <th width="16%">公司名称</th>
            <th width="15%">录入时间</th>
            <th width="8%">操作</th>
        </tr>
        </thead>
        <?php foreach ($datalist as $row):?>
            <tr class="tb_list">
                <td ><input type="checkbox" name="id[]" value="<?php echo $row['autoid']?>"><?php echo $row['autoid']?></td>
                <td ><a href="<?php echo site_url('admin/workedit/' . $row['autoid']) ?>"><?php echo $row['workname']?></a></td>
                <td ><?php echo $row['companyname']?></td>
                <td ><?php echo date('Y-m-d H:i',$row['timepub'])?></td>
                <td ><a href="<?php echo site_url('admin/workedit/' . $row['autoid'])?>"><img src="<?php echo base_url()?>public/admin/images/update.png" align="absmiddle" /></a>&nbsp;&nbsp;<a href="<?php echo  site_url('admin/workbatch/delete/' . $row['autoid'])?>" class="confirmSubmit"><img src="<?php echo base_url()?>public/admin/images/delete.png" align="absmiddle" /></a></td>
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
