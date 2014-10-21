<?php include_once('header.php'); ?>

<div id="contentHeader">
    <h3>内容管理</h3>
    <div class="searchArea">
        <ul class="action left">
            <li><a href="<?php echo site_url('admin/postcreate');?>" class="actionBtn"><span>录入</span></a></li>
        </ul>
        <div class="search right">
            <form action="<?php echo site_url('admin/post');?>" name="xform" id="searchForm" method="get" class="right">
            <select name="catalogId" id="catalogId">
                <option value="">=全部内容=</option>
                <?php foreach($categories as $catalog) { ?>
                    <option value="<?php echo $catalog['id']?>"><?php echo $catalog['str_repeat']?><?php echo $catalog['catalog_name']?></option>
                <?php } ?>
            </select>
            标题
            <input id="title" type="text" name="title" value="" class="txt" size="15"/>
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
    <form method="post" action="<?php echo site_url('admin/postbatch');?>" name="cpform" >
        <thead>
        <tr class="tb_header">
            <th width="10%">ID</th>
            <th>标题</th>
            <th width="16%">分类</th>
            <!--<th width="9%">浏览</th>-->
            <th width="15%">录入时间</th>
            <th width="8%">操作</th>
        </tr>
        </thead>
        <?php foreach ($posts as $row):?>
            <tr class="tb_list">
                <td ><input type="checkbox" name="id[]" value="<?php echo $row['id']?>"><?php echo $row['id']?></td>
                <td ><a href="<?php echo site_url('admin/postedit/' . $row['id']) ?>"><?php echo $row['title']?></a></td>
                <td ><?php echo $row['catalog_name']?></td>
                <!--<td><span ><?php //echo $row['view_count']?></span></td>-->
                <td ><?php echo date('Y-m-d H:i',$row['create_time'])?></td>
                <td ><a href="<?php echo site_url('admin/postedit/' . $row['id'])?>"><img src="<?php echo base_url()?>public/admin/images/update.png" align="absmiddle" /></a>&nbsp;&nbsp;<a href="<?php echo  site_url('admin/postbatch/delete/' . $row['id'])?>" class="confirmSubmit"><img src="<?php echo base_url()?>public/admin/images/delete.png" align="absmiddle" /></a></td>
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
