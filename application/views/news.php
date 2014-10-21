<?php include_once 'header.php' ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/common/css/pq_news.css"/>
<div class="main cl">
	<div class="ad"><img src="<?php echo 'uploads/' . $adv[3][0]['img'];?>" width="960" height="247" alt="华中人才派遣事业：派遣到家，服务到人" /></div>
	<div class="main-left fl">
    	<div class="news-list-title"><div class="list-title-line"></div></div>
        <div class="news-list">
            <?php foreach($list as $val) { ?>
        	<div class="news cl">
            	<h4><a href="<?php echo site_url('post/' . $val['id']) ?>"><?php echo $val['title'] ?></a></h4>
                <div class="news-info"><span><?php echo date('Y年m月d日', $val['create_time']) ?></span><span>来源：<?php echo $val['copy_from'] ?></span></div>
                <div class="fl"><img src="<?php echo base_url().'uploads/'.$val['attach_file'] ?>" width="125" height="94" /></div>
                <div class="fr news-description">
                    <p><?php echo mb_substr($val['intro'], 0, 80); ?>...<a href="<?php echo site_url('post/' . $val['id']) ?>" target="_blank">Read More >></a></p>
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
            </div>
            <?php } ?>
            <div class="bottom-line"></div>
        </div>
        <div class="pagination"><?php echo $page; ?></div>
    </div>
    <div class="main-right fr">
    	<div class="paiqian-case">
        	<div class="paiqian-case-title"><div class="list-title-line"></div></div>
        	<ul>
                <?php for($i = 0; $i < min(count($wiki['al']), 8); $i++) { ?>
            	<li><a href="<?php echo site_url('post/' . $wiki['al'][$i]['id']) ?>"><?php echo mb_substr($wiki['al'][$i]['title'], 0, 20) ?></a></li>
                <?php } ?>
            </ul>
            <div class="bottom-line"></div>
        </div>
    	<div class="paiqian-info">
        	<div class="paiqian-info-title"><div class="list-title-line"></div></div>
        	<ul>
                <?php for($i = 0; $i < min(count($wiki['cs']), 8); $i++) { ?>
                    <li><a href="<?php echo site_url('post/' . $wiki['cs'][$i]['id']) ?>" target="_blank"><?php echo mb_substr($wiki['cs'][$i]['title'], 0, 20) ?></a></li>
                <?php } ?>
            </ul>
            <div class="bottom-line"></div>
        </div>
    	<div class="paiqian-law">
        	<div class="paiqian-law-title"><div class="list-title-line"></div></div>
        	<ul>
                <?php for($i = 0; $i < min(count($wiki['fl']), 8); $i++) { ?>
                    <li><a href="<?php echo site_url('post/' . $wiki['fl'][$i]['id']) ?>" target="_blank"><?php echo mb_substr($wiki['fl'][$i]['title'], 0, 20) ?></a></li>
                <?php } ?>
            </ul>
            <div class="bottom-line"></div>
        </div>
    </div>
</div>
<?php include_once 'footer.php' ?>