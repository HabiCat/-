<?php include_once('header.php'); ?>

<div id="contentHeader">
    <h3>栏目管理</h3>
    <div class="searchArea">
        <ul class="action left" >
            <li class="current"><a href="<?php echo site_url('admin/categorycreate')?>" class="actionBtn"><span>录入</span></a></li>
        </ul>
        <div class="search right"> </div>
    </div>
</div>
<table class="content_list">
    <form method="post" action="<?php echo site_url('admin/categorybatch/delete')?>" name="cpform" >
        <tr class="tb_header">
            <th width="8%"> ID</th>
            <th width="8%"> 排序</th>
            <th width="50%">名称</th>
            <th width="15%">录入时间</th>
            <th>操作</th>
        </tr>
        <?php foreach ((array)$datalist as $row):?>
            <tr class="tb_list">
                <td ><input type="checkbox" name="id[]" value="<?php echo $row['id']?>">
                    <?php echo $row['id']?></td>
                <td ><input name="sortOrder[<?php echo $row['id']?>]" type="text" id="sortOrder[]" value="<?php echo $row['sort_order']?>" size="5" /></td>
                <td ><?php echo $row['str_repeat'] ?><a href="<?php echo site_url('admin/categoryedit/' . $row['id'])?>"><img src="<?php echo base_url()?>public/admin/images/insert.png" align="absmiddle" /></a> <a href="<?php echo site_url('admin/categoryedit/' . $row['id'])?>"><?php echo $row['catalog_name'] ?></a>
                    <?php if($row['attach_file']):?>
                        <img src="<?php echo base_url()?>public/admin/images/image.png" align="absmiddle" />
                    <?php endif;?></td>
                <td ><?php echo date('Y-m-d H:i',$row['create_time'])?></td>
                <td ><a href="<?php echo site_url('admin/categoryedit/' . $row['id'])?>"><img src="<?php echo base_url()?>public/admin/images/update.png" align="absmiddle" /></a>&nbsp;&nbsp;<a href="<?php echo site_url('admin/categorybatch/delete/' . $row['id'])?>" class="confirmSubmit"><img src="<?php echo base_url()?>public/admin/images/delete.png" align="absmiddle" /></a></td>
            </tr>
        <?php endforeach;?>
        <tr class="submit">
            <td colspan="9">
                <div class="cuspages right">
                    <?php //$this->widget('CLinkPager',array('pages'=>$pagebar));?>
                </div>
                <div class="fixsel">
                    <input type="checkbox" name="chkall" id="chkall" onclick="checkAll(this.form, 'id')" />
                    <label for="chkall">全选</label>
                    <select name="command">
                        <option>选择操作</option>
                        <option value="sortOrder">排序</option>
                        <option value="delete">删除</option>
                    </select>
                    <input id="submit_maskall" class="button confirmSubmit" type="submit" value="提交" name="maskall" />
                </div>
            </td>
        </tr>
    </form>
</table>
<?php include_once('footer.php'); ?>