<?php include_once 'header.php' ?>
<script type="text/javascript" src="<?php echo base_url();?>public/common/js/focus.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>public/common/js/terminator2.2.min.js"></script>
<div class="main cl">
	<div class="main-left fl">
        <div class="cl">
            <div id="focus" class="focus" style="">
                <div id="focus-pics" class="focus-pics">
                    <?php foreach($adv[2] as $val) { ?>
                    <div class="focus-img">
                        <a target="_blank" href="<?php echo $val['url'];?>"><img src="<?php echo base_url().'uploads/' . $val['img'];?>"></a>
                        <span class="shadow"><a target="_blank" href="<?php echo $val['url'];?>"><?php echo $val['title'];?></a></span>
                    </div>
                    <?php } ?>
                </div>
                <div class="focus-title-bg">
                    <div class="focus-title" id="focus-title">
                        <a href="javascript:void(0)" hidefocus="true" target="_self"><i>1</i></a>
                        <a href="javascript:void(0)" hidefocus="true" target="_self"><i>2</i></a>
                        <a href="javascript:void(0)" hidefocus="true" target="_self"><i>3</i></a>
                        <a href="javascript:void(0)" hidefocus="true" target="_self"><i>4</i></a>
                    </div>
                </div>
                <span class="prev"></span>
                <span class="next"></span>
            </div>
            <script type="text/javascript">
                Qfast.add('widgets', { path: "<?php echo base_url();?>public/common/js/terminator2.2.min.js", type: "js", requires: ['fx'] });
                Qfast(false, 'widgets', function () {
                    K.tabs({
                        id: 'focus',
                        conId: "focus-pics",
                        tabId:"focus-title",
                        tabTn:"a",
                        conCn: '.focus-img',
                        auto: 1,
                        effect: 'fade',
                        eType: 'click',
                        pageBt:true,
                        bns: ['.prev', '.next'],
                        interval: 3000
                    })
                })
            </script>
        </div>
        <div class="work-list cl border">
    		<div class="title">热门职位</div>
            <?php for($i = 0; $i < count($works); $i++) { ?>
        	<dl class="work-content cl<?php echo ($i%2 > 0) ? '' : ' marginr';?>">
            	<dt class="fl"><a href="<?php echo site_url('job/' . $works[$i]['autoid']) ?>" target="_blank"><img src="<?php echo base_url().'uploads/'.$works[$i]['banner'];?>" width="110" height="100" alt="<?php echo $works[$i]['workname'] ?>" /></a></dt>
                <dd class="fl">
                	<h4><a href="<?php echo site_url('job/' . $works[$i]['autoid']) ?>" target="_blank"><?php echo $works[$i]['workname'] ?>（<?php echo $works[$i]['numzhaopin'] ?>名）</a></h4>
                    <div class="company" title="<?php echo $works[$i]['companyname'] ?>"><?php echo $works[$i]['companyname'] ?></div>
                    <div class="time" title="招聘截止时间"><?php echo date('Y.m.d', $works[$i]['timeto']) ?></div>
                	<a class="check-more" href="<?php echo site_url('job/' . $works[$i]['autoid']) ?>" target="_blank">查看详情</a>
                </dd>
            </dl>
            <?php } ?>
        </div>
        <div class="pedia-list">
        	<div class="title">派遣百科</div>
            <div class="list-content cl">
            	<?php foreach($pedias as $key => $val) { ?>
            	<div class="pedia<?php echo ($key%2 > 0) ? '' : ' marginr';?>">
                	<h4><span class="category"><a href="<?php echo site_url('home/n/' . $val['catalog_id']);?>"><?php echo $val['catalog_name'];?></a></span><a href="<?php echo site_url('post/' . $val['id']) ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></h4>
					<div class="pedia-info"><span><?php echo date('Y年m月d日', $val['create_time']) ?></span><span>来源：<?php echo $val['copy_from'] ?></span></div>
                    <div class="pedia-description"><p><?php echo mb_substr($val['intro'], 0, 80); ?>...<a href="<?php echo site_url('post/' . $val['id']) ?>" target="_blank">Read More >></a></p></div>
                    <div class="tags">标签：
                        <?php
                            if($val['tags']) {
                                $tagsarr = explode(',', $val['tags']);
                                foreach($tagsarr as $v) {
                        ?>
                            <a href="http://<?php echo $this->input->server('HTTP_HOST') ?>/home/newskeywords.html?kw=<?php echo $v ?>" target="_blank"><?php echo $v ?></a>
                        <?php
                                }
                             }
                        ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="main-right fr">
    	<ul class="recommend-info">
        	<li class="recommend-info-title"></li>
            <?php
             if(!empty($wonderfulnews)) {
                 foreach($wonderfulnews as $k => $v) { ?>
            <?php if($k < 2) { ?>
        	<li class="pic-info cl">
            	<h4><a href="<?php echo site_url('post/' . $v['id']) ?>" title="<?php echo $v['title'];?>"><?php echo mb_substr($v['title'], 0, 18); ?></a></h4>
            	<img src="<?php echo 'uploads/' . $v['attach_file'] ?>" width="100" height="65" />
                <p class="description"><?php echo mb_substr($v['intro'], 0, 42); ?>...</p>
            </li>
            <?php } else { ?>
            <li class="li-style"><a href="<?php echo site_url('post/' . $v['id']) ?>" title="<?php echo $v['title'];?>"><?php echo mb_substr($v['title'], 0, 18); ?></a></li>
            <?php } ?>
            <?php } ?>
            <?php } ?>
        </ul>
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
        <?php foreach($adv[5] as $val) { ?>
        <div class="ad-pic"><a href="<?php echo $val['url'] ?>"><img src="<?php echo base_url().'uploads/'.$val['img'] ?>" width="300" height="179" alt="<?php echo $val['describe'] ?>" /></a></div>
        <?php } ?>
    </div>
</div>
<?php include_once 'footer.php' ?>