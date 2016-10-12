<!doctype html>
<html>

<head>
	<meta charset="utf-8"/>
	<title>后台 | 我自习</title>
	
	<link rel="stylesheet" href="/css/layout.css" type="text/css" media="screen" />
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="/css/ie.css" type="text/css" media="screen" />
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="/js/jquery-1.5.2.min.js" type="text/javascript"></script>
	<script src="/js/hideshow.js" type="text/javascript"></script>
	<script src="/js/jquery.tablesorter.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="/js/jquery.equalHeight.js"></script>
  <script type="text/javascript" src="/js/jquery.timeago.js"></script>
	<script type="text/javascript">
	$(document).ready(function() 
    	{ 
      	  $(".tablesorter").tablesorter(); 
   	 } 
	);
	$(document).ready(function() {

    $('.timeago').timeago();
	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});

});
    </script>
    <script type="text/javascript">
    $(function(){
        $('.column').equalHeight();
    });
</script>

</head>


<body>

	<header id="header">
		<hgroup>
			<h1 class="site_title"><a href="/admin">我自习-后台</a></h1>
			<h2 class="section_title">Dashboard</h2><div class="btn_view_site"><a href="/">返回主站</a></div>
		</hgroup>
	</header> <!-- end of header bar -->
	
	<section id="secondary_bar">
		<div class="user">
			<p><?php if ($islogin): ?>
			  <?php echo $cur['User']['slug']; ?>
			<?php endif ?> (<a href="/admin/feedback"><?php echo $newmsg; ?> Messages</a>)</p>
      <a class="logout_user" href="/logout" title="Logout">Logout</a>
		</div>
		<div class="breadcrumbs_container">
			<article class="breadcrumbs"><a href="/admin">管理面板</a> <?php echo $this->fetch('nav'); ?></article>
		</div>
	</section><!-- end of secondary bar -->
	
	<aside id="sidebar" class="column">
		<form class="quick_search">
			<input type="text" value="Quick Search" onfocus="if(!this._haschanged){this.value=''};this._haschanged=true;">
		</form>
		<hr/>
		<h3>审核</h3>
		<ul class="toggle">
			<li class="icn_new_article"><a href="/admin/books">小说审核</a></li>
			<li class="icn_edit_article"><a href="/admin/books_reply">小说评论</a></li>
			<li class="icn_categories"><a href="/admin/users_reply">空间评论</a></li>
			<li class="icn_tags"><a href="#">热门推荐</a></li>
		</ul>
		<h3>用户</h3>
		<ul class="toggle">
      <!-- <li class="icn_add_user"><a href="/admin/ranks">用户等级管理</a></li> -->
      <li class="icn_profile"><a href="/admin/ranks">用户等级管理</a></li> 
      <li class="icn_profile"><a href="/admin/groups">用户组管理</a></li> 
			<li class="icn_view_users"><a href="/admin/users">用户列表</a></li>
      <!-- <li class="icn_profile"><a href="#">用户信息</a></li> -->
		</ul>
		<h3>缓存</h3>
		<ul class="toggle">
			<li class="icn_folder"><a href="#">缓存列表</a></li>
			<li class="icn_photo"><a href="#">任务进度</a></li>
			<li class="icn_audio"><a href="#">任务操作</a></li>
			<li class="icn_video"><a href="#">操作记录</a></li>
		</ul>
		<h3>管理</h3>
		<ul class="toggle">
			<li class="icn_settings"><a href="#">选项</a></li>
			<li class="icn_security"><a href="#">系统安全</a></li>
			<li class="icn_jump_back"><a href="#">退出</a></li>
		</ul>
		
		<footer>
			<hr />
			<p><strong>Copyright &copy; 2013 我自习</strong></p>
			<p>Powered By <a href="/">我自习</a></p>
		</footer>
	</aside><!-- end of sidebar -->
	
	<section id="main" class="column">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
	</section>


</body>

</html>