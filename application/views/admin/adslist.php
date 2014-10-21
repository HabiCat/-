<?php include_once('header.php'); ?>

<div id="contentHeader">
    <div class="searchArea">
        <ul class="action left">
            <li><a href="<?php echo site_url('admin/adscreate');?>" class="actionBtn"><span>录入</span></a></li>
        </ul>
        <div class="search right">
            <form action="<?php echo site_url('admin/ads');?>" name="xform" id="searchForm" method="get" class="right">
            <?php $ads = $this->config->item('ads'); ?>
            <select name="pos" id="pos">
                <option value="">=全部内容=</option>
                <?php foreach($ads as $k => $ad) { ?>
                    <option value="<?php echo $k ?>"><?php echo $ad ?></option>
                <?php } ?>
            </select>
            广告标题
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
            <th>广告位置</th>
            <th>广告标题</th>
            <th>广告图片</th>
            <!--<th>广告文字</th>-->
            <th>广告链接</th>
            <th>开通时间</th>
            <th>结束时间</th>
            <th width="8%">操作</th>>
        </tr>
        </thead>
        <?php foreach ($result as $row):?>
            <tr class="tb_list">
                <td><input type="checkbox" name="id[]" value="<?php echo $row['id']?>"><?php echo $row['id']?></td>
                <td><?php echo $ads[$row['pos']] ?></td>
                <td><a href="<?php echo site_url('admin/adsedit/' . $row['id']) ?>"><?php echo $row['title']?></a></td>
                <td><img src="<?php echo '/uploads/' . $row['img']?>" width="150" height="100" /></td>
                <!--<td><?php //echo $row['describe']?></td>-->
                <td><?php echo $row['url']?></td>
                <td><?php echo date('Y-m-d', $row['timefrom']) ?></td>
                <td><?php echo date('Y-m-d', $row['timeto']) ?></td>
                <td>
                    <a href="<?php echo site_url('admin/adsbatch/status/' . $row['id'] . '/' . ($row['status'] ? 0 : 1) )?>"><?php echo $row['status'] ? '下架' : '上架' ?></a>
                    <a href="<?php echo site_url('admin/adsedit/' . $row['id'])?>"><img src="<?php echo base_url()?>public/admin/images/update.png" align="absmiddle" /></a>&nbsp;&nbsp;<a href="<?php echo site_url('admin/adsbatch/delete/' . $row['id'])?>" class="confirmSubmit"><img src="<?php echo base_url()?>public/admin/images/delete.png" align="absmiddle" /></a></td>
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