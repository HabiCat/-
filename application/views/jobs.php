<?php include_once 'header.php' ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/common/css/paiqian.css"/>
<div class="main cl">
	<div class="slogan"><img src="uploads/ads/slogan1.jpg" width="960" height="230" alt="华中人才派遣事业：派遣到家，服务到人"></div>
	<div class="main-left fl">
    	<div class="title-bar"><span class="light">热门招聘速递</span><span>新鲜</span><span>热门</span></div>
        <div class="work-list">
            <?php for($i = 0; $i < count($works); $i++) { ?>
        	<dl class="work cl">
            	<dt class="fl"><a href="<?php echo site_url('job/' . $works[$i]['autoid']) ?>" target="_blank"><img src="<?php echo base_url().'uploads/'.$works[$i]['banner'];?>" width="200" height="131" alt="<?php echo $works[$i]['workname'] ?>" /></a></dt>
                <dd class="fl">
                	<h4><a href="<?php echo site_url('job/' . $works[$i]['autoid']) ?>" target="_blank"><?php echo $works[$i]['workname'] ?>（<?php echo $works[$i]['numzhaopin'] ?>名）</a></h4>
                    <div class="more-info"><span class="company"><?php echo $works[$i]['companyname'] ?></span><span class="time" title="招聘截止时间"><?php echo date('Y.m.d', $works[$i]['timeto']) ?></span></div>
                	<div style="width:315px;"><?php echo mb_substr($works[$i]['describe'], 0, 100); ?></div>
                	<a class="more" href="<?php echo site_url('job/' . $works[$i]['autoid']) ?>" target="_blank">查看详情</a>
                </dd>
            </dl>
            <?php } ?>
        </div>
        <div class="pagination"><?php echo $page; ?></div>
    </div>
    <div class="main-right fr">
        <div class="recommend-work">
        	<div class="recommend-work-title"></div>
            <div class="recommend-bg"></div>
        	<dl>
                <?php foreach($recommendworks as $v) { ?>
            	<dt><?php echo $v[0][1]; ?></dt>
                <dd>
                <?php for($i = 1; $i <= count($v) - 1; $i++) { ?>
                <a href="<?php echo site_url('job/' . $v[$i]['autoid']) ?>"><?php echo $v[$i]['workname'] ?></a>
                <?php } ?>
                </dd>
                <?php } ?>
            </dl>
        </div>
        <!--div class="keywords">关键词，需要用js,预留位置</div-->
        <?php foreach($adv[4] as $val) { ?>
            <div class="ad-pic"><a href="<?php echo $val['url'] ?>"><img src="<?php echo 'uploads/' . $val['img'] ?>" width="300" height="179" alt="<?php echo $val['describe'] ?>" /></a></div>
        <?php } ?>
        <div class="weibo"><iframe width="100%" height="600" class="share_self"  frameborder="0" scrolling="no" src="http://widget.weibo.com/weiboshow/index.php?language=&width=0&height=600&fansRow=2&ptype=0&speed=300&skin=1&isTitle=0&noborder=1&isWeibo=1&isFans=0&uid=2624197701&verifier=a98ab59c&dpc=1"></iframe></div>
    </div>
</div>

<?php include_once 'footer.php' ?>