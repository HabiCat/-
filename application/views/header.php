<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="<?php if(isset($description) && $description) { echo $description; } else { echo $this->description; } ?>" />
    <meta name="keywords" content="<?php if(isset($keyword) && $keyword) { echo $keyword; } else { echo $this->keyword; } ?>" />
    <title><?php if(isset($title) && $title) { echo $title; } else { echo $this->title; } ?>&nbsp;&nbsp;<?php
        if(isset($breadcrumbs) && !empty($breadcrumbs)) {
            $level = '';
            foreach($breadcrumbs as $v) {
                $level .= $comma . $v;
                $comma = '_';
            }

            echo $level;
        }
    ?></title>
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
            <li<?php echo strstr($selfurl,'wiki') || strstr($selfurl,'pedia') ? ' class="selected"' : '';?>><a href="<?php echo site_url('wiki'); ?>">派遣百科</a></li>
            <li<?php echo strstr($selfurl,'message') ? ' class="selected"' : '';?>><a href="<?php echo site_url('message'); ?>">留言板</a></li>
        </ul>
        <div class="nav-button"><a class="login-person" href="http://www.111job.cn/person/login.php">个人登录</a>·<a class="register-person" href="http://www.111job.cn/person/register.php">注册</a><a class="login-company" href="http://www.111job.cn/company/login.php">企业登录</a>·<a class="register-company" href="http://www.111job.cn/company/register.php">注册</a></div>
    </div>
</div>
