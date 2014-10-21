<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $this->description; ?>" />
<meta name="keywords" content="<?php echo $this->keyword; ?>" />
<title><?php echo $this->title; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/common/css/common.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/common/css/apply.css"/>
<script type="text/javascript" src="<?php echo base_url();?>public/common/js/jquery-1.6.4.min.js"></script>
</head>

<body>
<div class="top cl">
    <div class="top-logo fl"><a class="logo" title="华中人才网" href="http://www.111job.cn/">华中人才网</a></div>
    <div class="top-backhome fr"><a href="#">返回首页</a></div>
</div>
<div class="main cl">
	<div class="main-left fl">
    	<div class="notice-content">
        	<h1><?php echo $result['workname'] ?>考试报名须知</h1>
        	<textarea rows="16"><?php echo $result['content'] ?></textarea>
            <form class="content" action="<?php echo site_url('reply/' . $result['autoid']) ?>" method="get">
            	<input type="submit" name="check-submit" value="立即申请" />
            </form>
        </div>
    </div>
    <div class="main-right fr">
    	<div class="main-right-title">了解更多招聘信息</div>
        <dl>
        	<dt><img src="<?php echo base_url();?>public/common/img/weixin.jpg" width="137" height="137" /></dt>
            <dd>官方微信</dd>
        </dl>
        <dl>
        	<dt><img src="<?php echo base_url();?>public/common/img/sina.jpg" width="137" height="137" /></dt>
            <dd>官方微博</dd>
        </dl>
    </div>
</div>
<?php include_once 'footer.php' ?>