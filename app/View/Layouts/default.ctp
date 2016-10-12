<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><?php echo $title_for_layout; ?> <?php echo "我自习 - 免费TXT电子书下载|全本小说分享平台|手机小说下载" ?></title>
	<?php echo $this->Html->charset(); ?>
  <meta name="keywords" content="我自习,免费小说,TXT小说下载,全本小说,TXT下载,TXT手机电子书,TXT小说,电子书,电子书籍,书库,图书,书,书籍,电子书下载,免费电子书">
  <meta name="description" content="TXT全本电子书分享网站-免费上传、下载、阅读。">
  <link href="favicon.ico" type="image/x-icon" rel="icon">
	<?php
    echo $this->Html->css('style');
    echo $this->Html->script('jquery');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
  <script type="text/javascript" charset="utf-8" src="/js/common.js"></script>
  <style type="text/css" media="screen">
  <?php echo $this->fetch('rewrite_css'); ?>
  </style>
<!-- 请置于所有广告位代码之前 -->
  <script type="text/javascript" src="http://cbjs.baidu.com/js/m.js"></script>

  <script>
  var _hmt = _hmt || [];
  (function() {
    var hm = document.createElement("script");
    hm.src = "//hm.baidu.com/hm.js?f70387f3963cf6467e17796a2e73c958";
    var s = document.getElementsByTagName("script")[0]; 
    s.parentNode.insertBefore(hm, s);
  })();
  </script>
</head>
<body>
	<div id="container">
		<div id="header">
      <div style="font:arial;text-align: center; margin: auto; width: 960px; background: #f7f7f7;height: 30px; line-height: 30px;margin-bottom:12px">
        <a href="http://m.5zixi.cn" target="_blank"><font color="red">我自习手机版</font></a>&nbsp;&nbsp;&nbsp;通告 本站禁止用户上传色情淫秽类、反动类、政治相关类等小说 如果发现将通报网安部门追究相应的法律责任。<a href="/feedback">不良内容及<span style="color:red">侵权举报</span>点这里留言</a> 
      </div>
      <div class="logo"><a href="/"><img src="/img/logo3.png" alt="我自习"></a><br><span class="subtitle">做最好的TXT电子书阅读平台</span></div>
      <div class="search">
        <div class="selectall">
          <form action="/search" method="get" accept-charset="utf-8">
            <input class="searchinput" name="q" value="<?php if ( $this->request->here == "/search"&& isset($this->request->query['q']) ): ?><?php echo htmlspecialchars($this->request->query['q']); ?><?php endif ?>">
            <input class="searchbuttom" type="submit" value=""><br>
          </form>
          <!-- <div class="clear padding-top white float-left">热门搜索：</div> -->
          <!-- <div class="hotsearch white padding-top"><?php echo "xiaoshu fdds xia fdds xiaoshu fdds xiaoshu fdds" ?></div> -->
        </div>
      </div>
      <div class="userbar">
        <?php if ($islogin): ?>
          <span><strong>Hi!&nbsp;&nbsp;</strong></span><span><?php echo $cur['User']['slug'] ?></span>
          [<a href="/home">我的书房</a>]
          <?php if ($isAdmin): ?>
          [<a href="/admin">后台管理</a>]  
          <?php endif ?>
          [<a href="/logout">退出</a>]
          <br>
          <a class="userbar_upload" href="/upload"><img src="/img/u_1.png" alt="上传小说">上传小说</a>|<a href="/feedback">反馈</a>|<a href="/help">帮助</a>
        <?php else: ?>
          [<a href="/signup">注册</a>]
          [<a href="/signin?url=<?php echo $this->request->here ?>">登陆</a>]
        <?php endif ?>
      </div>
      <?php
      $menu = array('users' => '会员','hotbooks' => '热门书籍', 'newest' => '最新书籍', 'qingchun' => '青春' , 'yanqing'=>'言情','chuanyue'=>'穿越','wuxia' => '武侠','xuanhuan'=>'玄幻','wenxue'=>'文学','xuanyi'=>'悬疑','dushi'=>'都市','lishi'=>'历史','jingguan'=>'经管','rank'=>'排行榜','allbooks'=>'全本书房');
      ?>
      <div class="menu clear">
        <div id="pointermenu2">
        <ul>
          <li><a href="/" <?php if ($this->request->here == '/'): ?>id="selected"<?php endif ?>>首页</a></li>
          <?php foreach ($menu as $url => $name): ?>
              <li><a href="/<?php echo $url . ".html"; ?>" <?php if ($this->Html->isHere($url)): ?>id="selected"<?php endif; ?>><?php echo $name; ?></a></li>
          <?php endforeach ?>
          <li><a href="#" id="rightcorner">&nbsp;</a></li>
        </ul>
        <div class="clear"></div>
        </div>
        <!-- <div class="special">
        </div> -->
      </div>
      <!-- Baidu Button BEGIN -->
      <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
      <a class="bds_renren">人人网</a>
      <a class="bds_tsina">新浪微博</a>
      <a class="bds_qzone">QQ空间</a>
      <a class="bds_tqq">腾讯微博</a>
      <a class="bds_t163">网易微博</a>
      <a class="bds_mshare">一键分享</a>
      <a class="bds_tieba">百度贴吧</a>
      <a class="bds_douban">豆瓣网</a>
      <a class="bds_kaixin001">开心网</a>
      <a class="bds_sqq">QQ好友</a>
      <a class="bds_hi">百度空间</a>
      <a class="bds_ty">天涯社区</a>
      <a class="bds_copy">复制</a>
      <span class="bds_more">更多</span>
      <a class="shareCount"></a>
      </div>
      <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=1258482" ></script>
      <script type="text/javascript" id="bdshell_js"></script>
      <script type="text/javascript">
      document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000);
      </script>
      <!-- Baidu Button END -->
      
		</div>
    
		<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
		<div class="footer" style="border-top:solid 1px #e8e8e8;clear:both;margin-top:14px;padding:3px">
		友情链接:<a href="baidu.com" target="_blank">百度搜索</a>&nbsp;&nbsp;<a href="http://hao.360.cn/" target="_blank" >360安全网址导航</a>&nbsp;&nbsp;<a href="http://se.360.cn/" target="_blank" >360安全浏览器</a>&nbsp;&nbsp;<a href="http://www.chinadmoz.com.cn/linkin.asp?id=85122" target="_blank" title="开放分类目录，收录各类优秀网站">开放分类目录</a>&nbsp;&nbsp;<a href="http://www.rrdir.com/linkin.asp?id=92006" target="_blank" title="人人目录，收录各类优秀网站">人人目录</a>
		</div>
		</div>
		<div id="footer">
      <div class="foot_nav"><a id="addHomePage" href="#">设为首页</a>　|　<a id="favorites" href="#">加入收藏</a>　|　广告合作　|　<a href="/signup" target="_blank">会员注册</a>　|　<a href="/feedback" target="_blank">意见反馈</a>　|　<a href="/changelog" target="_blank">更新记录</a>　</div>
      <div class="copyright">Copyright ©2013  <a href="http://www.5zixi.cn">5zixi.cn</a>Beta 京ICP备10206667号 All Rights Reserved. </div>
		</div>
	</div>
  <script type="text/javascript">  

      $(document).ready(function () {  

        $("#favorites").click(function () {  
          var ctrl = (navigator.userAgent.toLowerCase()).indexOf('mac') != -1 ? 'Command/Cmd' : 'CTRL';  
          if (document.all) {  
            window.external.addFavorite('http://5zixi.cn', '我自习 - 最好的TXT电子书阅读平台')  
          } else if (window.sidebar) {
            window.sidebar.addPanel('我自习 - 最好的TXT电子书阅读平台', 'http://5zixi.cn', "")  
          } else {
            alert('添加失败\n您可以尝试通过快捷键' + ctrl + ' + D 加入到收藏夹~')  
          }  
        })  

        $("#addHomePage").click(function () {  
          if (document.all) {
            document.body.style.behavior = 'url(#default#homepage)';  
            document.body.setHomePage("http://5zixi.cn");  
          } else {
            alert("设置首页失败，请手动设置！");
          }  
        })  

    });  
  </script>
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-19281868-15', '5zixi.cn');
  ga('send', 'pageview');


  </script>
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fa1743ee8a92f13d7821f7b114c7f58e1' type='text/javascript'%3E%3C/script%3E"));
</script>
<script src="http://rs.qiyou.com/view.php?uid=23422"></script>

<script src="http://p.qiyou.com/view.php?uid=23422"></script>
<?php if($this->request->here!="/"):?>
<?php endif;?>
</body>
</html>
