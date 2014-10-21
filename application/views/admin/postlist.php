<?php include_once('header.php'); ?>

<div id="contentHeader">
    <div class="searchArea">
        <div class="search right">
            <form action="<?php echo site_url('admin/postlist');?>" name="xform" id="searchForm" method="get" class="right">
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
    <form method="post" action="" name="cpform" >
        <thead>
        <tr class="tb_header">
            <th width="10%">ID</th>
            <th>标题</th>
            <th width="16%">分类</th>
            <th width="15%">录入时间</th>
        </tr>
        </thead>
        <?php foreach ($posts as $row):?>
            <tr class="tb_list">
                <td ><input type="checkbox" name="id[]" value="<?php echo $row['id']?>"><?php echo $row['id']?></td>
                <td ><a href="<?php echo site_url('admin/postedit/' . $row['id']) ?>" style="<?php echo $row['title_style']?>"><?php echo $row['title']?></a></td>
                <td ><?php echo $row['catalog_name']?></td>
                <!--<td><span ><?php //echo $row['view_count']?></span></td>-->
                <td ><?php echo date('Y-m-d H:i',$row['create_time'])?></td>
            </tr>
        <?php endforeach;?>
        <tr class="operate">
            <td colspan="6"><div class="cuspages right">
                <?php echo $page ?>
                </div>
                <div><input type="button" name="btn_postids" id="btn_postids" value="确定" /></div>
            </td>
        </tr>
    </form>
</table>
<script type="text/javascript">
document.getElementById('btn_postids').onclick = function () {
    var id_nodes = document.getElementsByName('id[]');
    var ids = [];
    for(i = 0; i < id_nodes.length; i++) {
        if(id_nodes[i].checked) {
            ids.push(id_nodes[i].value);
        }
    }
    window.opener.putids(ids);
}
</script>
<?php include_once('footer.php'); ?>