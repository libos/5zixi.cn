<?php $this->start('nav'); ?>
		<div class="breadcrumb_divider"></div> <a class="current">常用</a>
<?php $this->end(); ?>
		<h4 class="alert_info">欢迎使用我自习管理系统。</h4>
		
		<article class="module width_full">
			<header><h3>常用</h3></header>
			<div class="module_content">
				<article class="stats_graph">
          <p>待审核数量：<span style="color:red"><?php echo $notdo ?></span><br></p>
          <p>正在处理数量：<?php echo $ingdo ?><br></p>
          <p>审核通过数量：<?php echo $done ?><br></p>
          <p><br>缓存更新：</p>
          <p><input class="alt_btn update_all" type="submit" value="更新下面前两个"></p>
          <p><input class="alt_btn update_mobile" type="submit" value="更新手机列表"></p>
          <p><input class="alt_btn update_computer" type="submit" value="更新电脑常用列表"></p>
          <p><input class="alt_btn update_pass" type="submit" value="重新生成所有通过的小说"></p>
				</article>
				<article class="stats_overview" style="margin-left:8px;padding-left:20px;width:70px">
					<div class="overview_today">
						<p class="overview_day">回复</p>
						<p class="overview_count"><?php echo $bookreply; ?></p>
						<p class="overview_type">小说</p>
						<p class="overview_count"><?php echo $spacereply; ?></p>
						<p class="overview_type">空间</p>
					</div>
        </article>
				<article class="stats_overview">
					<div class="overview_today">
						<p class="overview_day">小说</p>
						<p class="overview_count"><?php echo $downloads; ?></p>
						<p class="overview_type">下载</p>
						<p class="overview_count"><?php echo $clicks; ?></p>
						<p class="overview_type">点击</p>
					</div>
					<div class="overview_previous">
						<p class="overview_day">&nbsp;</p>
						<p class="overview_count"><?php echo $collects; ?></p>
						<p class="overview_type">收藏</p>
						<p class="overview_count"><?php echo $count; ?></p>
						<p class="overview_type">小说</p>
					</div>
				</article>
				<div class="clear"></div>
			</div>
		</article><!-- end of stats article -->
    
    <script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
      var update = function(type) {
        $.ajax({
          'url':'/admin/update_' + type,
          'type':'post',
          'dataType':'html',
          success:function(html) {
            if (html == 'ok') {
              $('.update_'+type).attr('disabled',true);
            }
          }
        });
      };
      $('.update_all').click(function() {
        update('all');
      });
      $('.update_mobile').click(function() {
        update('mobile');
      });
      $('.update_computer').click(function() {
        update('computer');
      });
      $('.update_pass').click(function() {
        update('pass');
      });
    });
    </script>