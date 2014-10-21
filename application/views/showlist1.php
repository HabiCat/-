<script src="<?php echo base_url();?>public/js/jquery/jquery-1.7.1.min.js" ></script>
<script language="javascript">
    //函数跳转到指定页面
    function gotoPage(page)
    {
        document.getElementById("page").value = page;  //隐藏表单的页控件
        document.getElementById("searchForm").submit();
    }

    //函数:回来第1页
    function gotoFirstPage()
    {
        document.getElementById("page").value = 1;  //隐藏表单的页控件
    }
</script>

<!-- 表单参考如下 -->
<form name="searchForm" id="searchForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <!-- 下面是个隐藏页面号码值控件 -->
    <input type="hidden" name="page" id="page" size=30 value=""   />

    <!-- 下面是个查找条件值控件 -->
    <input type="text" name="title" id="title" size=30 value="<?php echo $title ?>"   />

    <!-- 提交控钮,注意id和name不要把值设成"submit",我将其改为"submit1" -->
    <!-- 不然在gotoPage()函数里与表单的提交事件submit()有冲突,导至函数不运行 -->
    <!-- 这个提交按钮还增加了一个单击事件gotoFirstPage() -->
    <!-- 作用就是无论何时当你点击查找按钮后页面都会是第1页,其实就是将隐藏的页面控制值设为1 -->
    <input name="submit1" id="submit1" onclick="gotoFirstPage()" type="submit" value="查  找" size=30 />
</form>

<?php foreach($data as $row) { ?>
<p>&nbsp;&nbsp;<?php echo $row['title'] ?></p>
<?php } ?>
<div>
<?php echo $p; ?>
</div>
<!-- 当然这样改了后,还应该改改原来的分页函数,1.增页分页码链接的单击事件 -->
<!-- 2.让<A>标签href的值为"#",作用当然就是不要<A>标签点击后,页面跳转,只让单击事件来提交表单取得指定页面 -->
<!-- 我尽量在少改动原函数的情况下,只在href后面增加"#?",因为这个原函数在href后面带有"?"号,实际我只要在在最前面增加一个#号就OK,原函数修改如下 -->
