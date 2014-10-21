<?php include_once 'header.php' ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/common/css/pq_news.css"/>
<style type="text/css">
#tags { width: 645px; height: 20px; }
#tags li { float: left; padding-left: 5px; }
#tags li a {display: block; border: 1px solid #6289b4; width: 20px; height: 20px; text-align: center;}
.selectTag { font-size: 14px; font-weight: bold; }
</style>
<div class="main cl">
	<div class="main-left fl margin-top">
    	<div class="path">
            <?php foreach($breadcrumbs as $k => $v) { ?>
            <a href="<?php echo site_url('home/lists/' . $k) ?>"><?php echo $v ?></a> >>
            <?php } ?>
            <a href="<?php echo $this->input->server('PHP_SELF') ?>">正文</a>
        </div>
    	<div class="article">
        	<h1><?php echo $post['title'] ?></h1>
            <div class="art-info"><span>来源：<?php echo $post['copy_from'] ?></span><span><?php echo date('Y年m月d日', $post['last_update_time']) ?></span><span>评论</span></div>
            <div class="content">
                <?php if(!empty($pagenews)) { ?>
                <div id="tagContent">
                    <?php foreach($pagenews as $k => $v) { ?>
                    <div class="tagContent" id="tagContent<?php echo $k ?>"><?php echo $v ?></div>
                    <?php } ?>
                </div>
                <?php } else {
                    echo $post['content'];
                }
                ?>
                <?php if(!empty($pagenews)) { ?>
                <ul id="tags">
                    <?php foreach($pagenews as $k => $v) { ?>
                    <li><a onclick="selectTag('tagContent<?php echo $k ?>',this)" href="javascript:void(0)"><?php echo $k+1 ?></a></li>
                    <?php } ?>
                </ul>
                <?php } ?>
            </div>
            <div class="article-tags">
                <?php foreach($post['tags'] as $v) { ?>
                <a href="<?php echo site_url('home/newskeywords') . '?kw=' . $v ?>"><?php echo $v ?></a>
                <?php } ?>
            </div>
            <div class="share-button">
                <div class="bshare-custom">分享到：<div class="bsPromo bsPromo2"></div><a title="分享到QQ空间" class="bshare-qzone"></a><a title="分享到新浪微博" class="bshare-sinaminiblog"></a><a title="分享到人人网" class="bshare-renren"></a><a title="分享到微信" class="bshare-weixin"></a><a title="分享到腾讯微博" class="bshare-qqmb"></a><a title="分享到豆瓣" class="bshare-douban"></a><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a></div>
				<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=3&amp;lang=zh"></script>
				<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>            
            </div>
            <div class="related-news">
            	<div class="related-news-title cl"><em>您可能感兴趣的文章</em></div>
            	<ul>
                    <?php foreach($interestnews as $v) { ?>
                	<li><a href="<?php echo site_url('post/' . $v['id']) ?>"><?php echo $v['title'] ?></a><span><?php echo date('Y/m/d', $v['last_update_time']) ?></span></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="comment">
            	<div class="comment-input"><img src="<?php echo base_url();?>public/common/img/demo6.jpg" width="645" height="115" /></div>
                <div class="comments">
                	<div class="comment-content">
                    	评论列表
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-right fr margin-top">
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
                    <li><a href="<?php echo site_url('post/' . $wiki['cs'][$i]['id']) ?>"><?php echo mb_substr($wiki['cs'][$i]['title'], 0, 20) ?></a></li>
                <?php } ?>
            </ul>
            <div class="bottom-line"></div>
        </div>
        <div class="weibo"><iframe width="100%" height="500" class="share_self"  frameborder="0" scrolling="no" src="http://widget.weibo.com/weiboshow/index.php?language=&width=0&height=500&fansRow=2&ptype=0&speed=300&skin=1&isTitle=0&noborder=1&isWeibo=1&isFans=0&uid=2624197701&verifier=a98ab59c&dpc=1"></iframe></div>
        <?php foreach($adv[6] as $val) { ?>
            <div class="ad"><img src="<?php echo '/uploads/' . $val['img'] ?>" width="300" height="90" /></div>
        <?php } ?>
    </div>
</div>

<script type=text/javascript>
    function selectTag(showContent,selfObj){
        // 操作标签
        var tag = document.getElementById("tags").getElementsByTagName("li");
        var taglength = tag.length;
        for(i=0; i<taglength; i++){
            tag[i].className = "";
        }
        selfObj.parentNode.className = "selectTag";
        // 操作内容
        for(i=0; j=document.getElementById("tagContent"+i); i++){
            j.style.display = "none";
        }
        document.getElementById(showContent).style.display = "block";

    }
</script>
<?php include_once 'footer.php' ?>