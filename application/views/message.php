<?php include_once 'header.php' ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/common/css/message.css"/>
<div class="main">
	<div class="message-board">
    	<form action="<?php echo site_url('message') ?>" method="post" id="messageform">
			<dl class="cl">
            	<dt>主题类别：</dt>
                <dd>
                    <input type="radio" name="Message[type]" value="咨询" checked="checked" /><span>咨询</span>
                    <input type="radio" name="Message[type]" value="谏言" /><span>谏言</span>
                    <input type="radio" name="Message[type]" value="投诉" /><span>投诉</span>
                    <input type="radio" name="Message[type]" value="求助" /><span>求助</span>
                    <input type="radio" name="Message[type]" value="感谢" /><span>感谢</span>
                </dd>
            </dl>
            <dl class="cl">
            	<dt class="line-height-none">留言内容：</dt>
                <dd class="line-height-none"><textarea name="Message[comment]" rows="10"></textarea></dd>
            </dl>
            <dl class="cl">
            	<dt>真实姓名：</dt>
                <dd><input class="input-style" type="text" name="Message[name]" value="" /></dd>
                <dd class="font-red">请将个人信息填至此处，所有信息除工作人员外他人无权浏览。</dd>
            </dl>
            <dl class="cl">
            	<dt>联系方式：</dt>
            	<dd><input class="input-style" type="text" name="Message[phone]" value="" /></dd>
                <dd class="font-red">请将个人信息填至此处，所有信息除工作人员外他人无权浏览。</dd>
            </dl>
            <dl class="cl">
            	<dt>电子邮箱：</dt>
                <dd><input class="input-style" type="text" name="Message[email]" value="" /></dd>
                <dd class="font-red">请将个人信息填至此处，所有信息除工作人员外他人无权浏览。</dd>
            </dl>
            <div class="message-submit"><input type="button" onclick="checkformdata()" name="message-submit" value="" /></div>
        </form>
    </div>
</div>
<script type="text/javascript">
    function checkformdata() {
         var elem = $('textarea[name="Message[comment]"]');
         if(!elem.val()) {
             alert('留言内容不能为空');
             return false;
         }

         var elem = $('input[name="Message[name]"]');
         if(!elem.val()) {
             alert('姓名不能为空');
             return false;
         }

         var elem = $('input[name="Message[phone]"]');
         if(!elem.val()) {
                alert('联系方式不能为空');
                return false;
         }

        var elem = $('input[name="Message[email]"]');
        if(!elem.val()) {
            alert('邮箱不能为空');
            return false;
        }

        $("#messageform").submit();

    }
</script>
<?php include_once 'footer.php' ?>