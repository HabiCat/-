<?php include_once('header.php'); ?>

<div id="contentHeader">
    <h3>留言管理</h3>
    <div class="searchArea">
        <ul class="action left" >

        </ul>
        <div class="search right"> </div>
    </div>
</div>

<table border="0" cellpadding="0" cellspacing="0" class="content_list">
    <form method="post" action="<?php echo site_url('admin/messagebatch/delete')?>" name="cpform" >
        <thead>
        <tr class="tb_header">
            <th width="10%">ID</th>
            <th width="16%">姓名</th>
            <th width="16%">emial</th>
            <th width="8%">联系方式</th>
            <th width="8%">主题类别</th>
            <th width="8%">IP</th>
            <th width="8%">留言用户</th>
            <th width="15%">留言时间</th>
            <th width="16%">操作</th>
        </tr>
        </thead>
        <?php foreach ($datalist as $row):?>
            <tr class="tb_list">
                <td ><input type="checkbox" name="id[]" value="<?php echo $row['id']?>"><?php echo $row['id']?></td>
                <td ><a href="<?php echo site_url('admin/messageedit/' . $row['id']) ?>"><?php echo $row['name']?></a></td>
                <td ><?php echo $row['email']?></td>
                <td ><?php echo $row['phone']?></td>
                <td ><?php echo $row['type']?></td>
                <td><span ><?php echo $row['ip']?></span></td>
                <td ><?php if($row['userid']) { echo $row['useraccount']; } else { echo '匿名'; } ?></td>
                <td ><?php echo date('Y-m-d H:i',$row['createtime'])?></td>
                <td ><a href="<?php echo site_url('admin/messageedit/' . $row['id'])?>"><img src="<?php echo base_url()?>public/admin/images/update.png" align="absmiddle" /></a>&nbsp;&nbsp;<a href="<?php echo site_url('admin/messagebatch/delete/' . $row['id'])?>" class="confirmSubmit"><img src="<?php echo base_url()?>public/admin/images/delete.png" align="absmiddle" /></a></td>
            </tr>
        <?php endforeach;?>
        <tr class="operate">
            <td colspan="6"><div class="cuspages right">
                <?php echo $page ?>
                </div>
                <div class="fixsel">
                    <input type="checkbox" name="chkall" id="chkall" onclick="checkAll(this.form, 'id')" />
                    <label for="chkall">全选</label>
                    <select name="command">
                        <option>选择操作</option>
                        <option value="delete">删除</option>
                    </select>
                    <input id="submit_maskall" class="button confirmSubmit" type="submit" value="提交" name="maskall" />
                </div>
            </td>
        </tr>
    </form>
</table>

<?php include_once('footer.php'); ?>