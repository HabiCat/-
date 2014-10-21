<?php include_once('header.php'); ?>

<div id="contentHeader">
    <h3>管理员</h3>
    <div class="searchArea">
        <ul class="action left" >
            <li><a href="<?php echo site_url('admin/usercreate')?>" class="actionBtn"><span>录入</span></a></li>
        </ul>
        <div class="search right"> </div>
    </div>
</div>
<table class="content_list">
    <form method="post" action="" name="cpform" >
        <tr class="tb_header">
            <th width="5%">ID</th>
            <th width="15%">用户 </th>
            <!--<th width="12%">组</th>-->
            <th width="18%">邮箱</th>
            <th width="13%">最后登录</th>
            <th >操作</th>
        </tr>
        <?php foreach ($datalist as $row):?>
            <tr class="tb_list">
                <td ><?php echo $row['id']?></td>
                <td ><?php echo $row['username']?></td>
                <td><span ><?php echo $row['email']?></span></td>
                <td ><?php echo $row['last_login'] ?></td>
                <td ><a href="<?php echo site_url('admin/useredit/' . $row['id'])?>"><img src="<?php echo base_url()?>public/admin/images/update.png" align="absmiddle" /></a>&nbsp;&nbsp;<a href="<?php echo site_url('admin/userbatch/delete/' . $row['id'])?>" class="confirmSubmit"><img src="<?php echo base_url()?>public/admin/images/delete.png" align="absmiddle" /></a></td>
            </tr>
        <?php endforeach;?>
        <tr>
            <td colspan="7">
                <div class="cuspages right">
                    <?php echo $page ?>
                </div>

                <!--<div class="fixsel">
                            <input type="checkbox" name="chkall" id="chkall" onclick="checkAll('prefix', this.form, 'opentid')" />
                            <label for="chkall">全选</label>
                            <input id="submit_maskall" class="btn" type="submit" value="屏蔽" name="maskall" />
                            <input id="submit_unmaskall" class="btn" type="submit" value="取消屏蔽" name="unmaskall" />
                        </div>--></td>
        </tr>
    </form>
</table>
<?php include_once('footer.php'); ?>
