
<?php $this->start('nav'); ?>
		<div class="breadcrumb_divider"></div> <a class="current">小说审核</a>
<?php $this->end(); ?>
<style type="text/css" media="screen">
  .width_3_quarter{
    width:95%;
  }
  #main .module header h3.tabs_involved{
    width:40%;
  }
  #tabbbb
  {
    float:left;
  }
  .tip
  {
    color:gray;
  }
</style>
<?php
$NOVEL_TYPE = array('qingchun' => '青春' , 'yanqing'=>'言情','chuanyue'=>'穿越','wuxia' => '武侠','xuanhuan'=>'玄幻','wenxue'=>'文学','xuanyi'=>'悬疑','dushi'=>'都市','lishi'=>'历史','jingguan'=>'经管');
$NOVEL_LIST = array('青春' , '言情','穿越', '武侠','玄幻','文学','悬疑','都市','历史','经管');
$STATUS = array(0=>'待审','1'=>'未通过',11=>'处理中...',12=>'通过',21=>'特别推荐',22=>'特别推荐');
$QUAN = array('Y'=>'已完结','N'=>'连载中',''=>'已完结');
?>
<h4 class="alert_warning" style="display:none">A Warning Alert</h4>

<h4 class="alert_error" style="display:none">An Error Message</h4>

<h4 class="alert_success" style="display:none">A Success Message</h4>
<article class="module width_3_quarter">
<header><h3 class="tabs_involved">小说审核</h3>
  <span id="tabbbb">
  	<p>
  	<?php
  	echo $this->Paginator->counter(array(
  	'format' => __('第{:page}页 共{:pages}页')
  	));
  	?>	
  	<?php
  		echo $this->Paginator->prev(  __('上一页 '), array(), null, array('class' => 'prev disabled'));
  		echo $this->Paginator->numbers(array('separator' => ' '));
  		echo $this->Paginator->next(__(' 下一页') , array(), null, array('class' => 'next disabled'));
  	?></p>
  	</span>

<ul class="tabs">
		<li><a href="#tab1">审核列表</a></li>
    <!-- <li><a href="#tab2">通过的</a></li> -->
</ul>
</header>

<div class="tab_container">
	<div id="tab1" class="tab_content">
	<table class="tablesorter" cellspacing="0"> 
	<thead> 
		<tr> 
				<th width="20"><input type="checkbox" class="checkall" /></th> 
        <th>封面</th>
				<th>书名</th>
        <th>上传者</th>
        <th>小说状态</th>
				<th>类型</th> 
				<th>作者</th> 
        <th>发布时间</th>
        <th>文件大小</th>
        <th>下载</th>
        <th>状态</th>
				<th>操作</th> 
		</tr> 
	</thead> 
	<tbody> 
    <?php foreach ($books as $book): ?>
		<tr> 
				<td><input type="checkbox" value="<?php echo $book['Book']['bid']; ?>"></td> 
        <td><img width="40" src="<?php echo $book['img']['link'];?>"></td>
				<td><?php if ($book['Book']['pass']  < 10): ?>
				  <?php echo $book['Book']['name'] ?>
        <?php else: ?>
          <a href="/book/<?php echo $book['Book']['burl'] ?>.html"><?php echo $book['Book']['name'] ?></a>
				<?php endif ?></td> 
        <td><?php echo $book['User']['slug'] ?></td>
        <td><?php echo $QUAN[$book['Book']['status']] ?></td>
				<td><?php echo $NOVEL_LIST[$book['Book']['type']]; ?></td> 
				<td><?php echo $book['Book']['author'] ?></td> 
        <td class="timeago" title="<?php echo $book['Book']['created'] ?>"><?php echo $book['Book']['created'] ?></td>
        <td ><?php echo $this->Html->formatSize($book['txt']['size']) ?></td>
        <td><a href="/admin/books/download/<?php echo $book['txt']['did'] ?>" target="_blank"><img src="/images/icn_download.png"></a></td>
        <td class="status"><?php echo $STATUS[$book['Book']['pass']] ?></td>
				<td><?php if ($book['Book']['pass'] != 11 && $book['Book']['pass'] != 12): ?>
				  <a href="#" class="pass"><img  src="/images/icn_alert_success.png" alt="通过"></a>
				<?php endif ?><?php if ($book['Book']['pass'] != 1): ?><a href="#" class="reject"><img src="/images/icn_alert_error.png" alt="不通过"></a><?php endif ?><?php if ($book['Book']['pass'] > 11): ?><a href="#" class="recommend"><img src="/images/ok_hand.png" alt="推荐"></a><?php endif ?></td>

		</tr> 
    <?php endforeach; ?>
	</tbody>
	</table>

	</div><!-- end of #tab1 -->
  <div class="tip">
    <h4>操作说明</h4>
    <p>1、操作按钮分别是：通过、拒绝、推荐</p>
    <p>2、书籍状态有：待审、未通过、处理中、通过、特别推荐</p>
    <p>3、点击通过，书籍将变为“处理中”，等待处理完成，书籍将会自动变为“通过”状态</p>
    <p>4、每点击推荐一次，书籍的推荐权重会增加</p>
  </div>
	
</div><!-- end of .tab_container -->

</article><!-- end of content manager article -->



<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
  $('.checkall').click(function(e) {
    e.stopPropagation();
    $('tbody input[type=checkbox]').attr('checked',$(this).attr('checked'));
  });

  $('.pass').click(function() {
    var that = this;
    $.ajax({
      url:'/admin/books/pass',
      type:'post',
      data:{'id':$(that).parent().parent().find('input[type=checkbox]').val()},
      dataType:'html',
      success:function(html) {
        if (html=='OK') {
          $(that).parent().parent().find('.status').html('<span style="color:red">处理中...</span>');
          $('.alert_success').html('通过成功。')
          $('.alert_success').show();
          setTimeout(function(){$('.alert_success').hide()},5000);
        }else{
          $('.alert_error').html('通过失败。').show();
          setTimeout(function(){$('.alert_error').hide()},5000);
        }
      }
    });
  });
  $('.reject').click(function() {
    var that = this;
    $.ajax({
      url:'/admin/books/deny',
      type:'post',
      data:{'id':$(that).parent().parent().find('input[type=checkbox]').val()},
      dataType:'html',
      success:function(html) {
        if (html=='OK') {
          $(that).parent().parent().find('.status').html('<span style="color:red">未通过</span>');
          $('.alert_success').html('不通过成功。')
          $('.alert_success').show();
          setTimeout(function(){$('.alert_success').hide()},5000);
        }else{
          $('.alert_error').html('不通过失败。').show();
          setTimeout(function(){$('.alert_error').hide()},5000);
        }
      }
    });
  });
  $('.recommend').click(function() {
    var that = this;
    $.ajax({
      url:'/admin/books/recommend',
      type:'post',
      data:{'id':$(that).parent().parent().find('input[type=checkbox]').val()},
      dataType:'html',
      success:function(html) {
        if (html=='OK') {
          $(that).parent().parent().find('.status').html('<span style="color:red">推荐</span>');
          $('.alert_success').html('推荐成功。')
          $('.alert_success').show();
          setTimeout(function(){$('.alert_success').hide()},5000);
        }else{
          $('.alert_error').html('推荐失败。').show();
          setTimeout(function(){$('.alert_error').hide()},5000);
        }
      }
    });
  });
  
});
</script>
<div style="clear:both;height:400px;">
  
</div>