<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="<?php if(isset($description) && $description) { echo $description; } else { echo $this->description; } ?>" />
    <meta name="keywords" content="<?php if(isset($keyword) && $keyword) { echo $keyword; } else { echo $this->keyword; } ?>" />
    <title><?php echo $job['workname'] . "&nbsp;&nbsp;" . $this->title; ?></title>
    <link rel="icon" href="http://paiqian.111job.cn/favicon.ico" mce_href="http://paiqian.111job.cn/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/common/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/common/css/paiqian.css"/>
    <script type="text/javascript" src="<?php echo base_url();?>public/common/js/jquery-1.6.4.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>public/common/js/pq.js"></script>
</head>

<body>
<div id="top" class="cl">
    <div class="top-nav">
        <div class="nav-logo"><a class="logo" href="http://www.111job.cn/">华中人才网</a></div>
        <ul class="nav-main">
            <?php $selfurl = $_SERVER['PHP_SELF'];?>
            <li<?php echo current_url()==base_url() ? ' class="selected"' : '';?>><a href="<?php echo base_url(); ?>">首页</a></li>
            <li<?php echo strstr($selfurl,'job') ? ' class="selected"' : '';?>><a href="<?php echo site_url('jobs'); ?>">派遣职位</a></li>
            <li<?php echo strstr($selfurl,'new') ? ' class="selected"' : '';?>><a href="<?php echo site_url('news'); ?>">新闻动态</a></li>
            <li<?php echo strstr($selfurl,'wiki') ? ' class="selected"' : '';?>><a href="<?php echo site_url('wiki'); ?>">派遣百科</a></li>
            <li<?php echo strstr($selfurl,'message') ? ' class="selected"' : '';?>><a href="<?php echo site_url('message'); ?>">留言板</a></li>
        </ul>
        <div class="nav-button"><a class="login-person" href="http://www.111job.cn/person/login.php">个人登录</a>·<a class="register-person" href="http://www.111job.cn/person/register.php">注册</a><a class="login-company" href="http://www.111job.cn/company/login.php">企业登录</a>·<a class="register-company" href="http://www.111job.cn/company/register.php">注册</a></div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/common/css/job.css"/>
<div class="main cl">
	<div class="notice">华中人才提示您：在应聘过程中用人单位以任何名义向应聘者收取费用都属于违法行为（如押金、资料费、建档费、代收体检费、代刷淘宝信誉），请应聘者提高警惕！</div>
	<div class="job">
    	<h1 class="fl"><?php echo $job['workname'] ?>（<?php echo $job['numzhaopin'] ?>名）</h1>
        <div class="apply fr"><a href="<?php echo $job['protocol'] ? site_url('protocol/' . $job['autoid']): site_url('reply/' . $job['autoid']) ?>" style="color: white;">立即申请</a></div>
        <div class="cl"></div>
        <p class="job-point">职位诱惑：<?php echo $job['tempt']?></p>
    </div>
    <div class="main-left fl">
        <?php
            $moneykey = $this->config->item('moneykey');
            $area = $this->config->item('area');
            $jobmanagemen = $this->config->item('jobmanagemen');
            $education = $this->config->item('education');
        ?>
    	<div class="job-tags"><span><?php echo $moneykey[$job['moneykey']] ?>元/月</span><span><?php echo $area[$job['areakey']] ?></span><span><?php echo $jobmanagemen[$job['jobkey']] ?></span><span><?php echo $education[$job['edukey']] ?></span></div>
    	<div class="job-info"><span>发布时间：<?php echo date('Y-m-d H:i:s', $job['timepub']) ?></span><span>有效期：<?php echo date('Y-m-d', $job['timeto']) ?></span></div>
        <ul class="select-tab cl">
        	<li class="selected">职位描述</li>
            <li>公司简介</li>
        </ul>
        <div class="job-content">
            <?php echo $job['describe'] ?>
        </div>
        <div class="job-content hidden">
            <?php echo $job['info'] ?>
        </div>
    </div>
    <div class="main-right fr">
        <?php
            $number = $this->config->item('number');
            $companytype = $this->config->item('companytype');
            $industry = $this->config->item('industry');
        ?>
    	<ul class="company-info">
            <li><h4><?php echo $job['companyname'] ?></h4></li>
            <li>规模：<?php echo $number[$job['number']] ?></li>
            <li>性质：<?php echo $companytype[$job['nature']] ?></li>
            <li>领域：<?php echo $industry[$job['sector']] ?></li>
            <li>主页：<?php echo $job['site'] ?></li>
            <li>地址： <?php echo $job['address'] ?></li>
        </ul>
        <div class="similar-jobs">
        	<ul class="similar-tab cl">
            	<li class="selected">相似职位</li>
            	<li>猜你喜欢</li>
            </ul>
            <div class="recommend">
                <?php
                if(!empty($similarjobs)) {
                    foreach($similarjobs as $job) {
                ?>
            	<dl>
                	<dt><img src="<?php echo base_url();?>public/common/img/demo7.jpg" width="54" height="56" /></dt>
                    <dd><a href="<?php echo site_url('home/job/' . $job['autoid']) ?>"><?php echo $job['workname'] ?></a></dd>
                    <dd class="font-red"><?php echo $job['moneykey'] ? $moneykey[$job['moneykey']] . '元' : $moneykey[$job['moneykey']] ?></dd>
                    <dd><?php echo $job['companyname'] ?></dd>
                </dl>
                <?php
                    }
                }
                ?>
            </div>
            <div class="recommend hidden">
                <?php
                if(!empty($likejobs)) {
                    foreach($likejobs as $job) {
                ?>
                <dl>
                    <dt><img src="<?php echo base_url();?>public/common/img/demo8.jpg" width="54" height="56" /></dt>
                    <dd><a href="<?php echo site_url('home/job/' . $job['autoid']) ?>"><?php echo $job['workname'] ?></a></dd>
                    <dd class="font-red"><?php echo $job['moneykey'] ? $moneykey[$job['moneykey']] . '元' : $moneykey[$job['moneykey']] ?></dd>
                    <dd><?php echo $job['companyname'] ?></dd>
                </dl>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include_once 'footer.php' ?>