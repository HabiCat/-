<?php include_once 'header.php' ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/common/css/paiqian.css"/>
<div class="main cl">
	<div class="main-left fl">
    	<div class="title-bar"><span class="light">职位详情</div>
        <div class="work-list">
            <?php for($i = 0; $i < count($result); $i++) { ?>
        	<dl class="work cl">
            	<dt class="fl"><a href="<?php echo site_url('home/job/' . $result[$i]['autoid']) ?>" target="_blank"><img src="<?php echo base_url();?>public/common/img/demo.jpg" width="200" height="131" alt="<?php echo $result[$i]['workname'] ?>" /></a></dt>
                <dd class="fl">
                	<h4><?php echo $result[$i]['workname'] ?>（<?php echo $result[$i]['numzhaopin'] ?>名）</h4>
                    <div class="more-info"><span class="company"><?php echo $result[$i]['companyname'] ?></span><span class="time" title="招聘截止时间"><?php echo date('Y.m.d', $result[$i]['timeto']) ?></span></div>
                	<p><?php echo mb_substr($result[$i]['describe'], 0, 100); ?></p>
                	<a class="more" href="<?php echo site_url('home/job/' . $result[$i]['autoid']) ?>">查看详情</a>
                </dd>
            </dl>
            <?php } ?>
        </div>
        <div class="pagination"><?php echo $page; ?></div>
    </div>
</div>

<?php include_once 'footer.php' ?>