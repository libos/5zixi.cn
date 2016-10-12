<?php $this->start('nav'); ?>
		<div class="breadcrumb_divider"></div> <a class="current">小说评论审核</a>
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
$STATUS = array(0=>'待审',1=>'未通过',12=>'通过');
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
        <th>用户</th>
				<th>书名</th>
        <th>内容</th>
				<th>IP</th> 
        <th>发布时间</th>
        <th>状态</th>
				<th>操作</th> 
		</tr> 
	</thead> 
	<tbody> 
    <?php foreach ($bookreplies as $bookreply): ?>
		<tr> 
				<td><input type="checkbox" value="<?php echo $bookreply['Bookreply']['rid']; ?>"></td> 
        <td><?php if ($bookreply['Bookreply']['uid']==0): ?>游客<?php else: ?><?php echo $bookreply['User']['slug'];?><?php endif ?></td>
				<td><?php if ($bookreply['Book']['pass']  < 10): ?>
				  <?php echo $bookreply['Book']['name'] ?>
        <?php else: ?>
          <a href="/book/<?php echo $bookreply['Book']['burl'] ?>.html"><?php echo $bookreply['Book']['name'] ?></a>
				<?php endif ?></td>
				<td style="width:50%;word-break:break-all;"><?php echo nl2br($bookreply['Bookreply']['body']) ?></td> 
        <td ><?php echo $bookreply['Bookreply']['ip']; ?></td>
        <td class="timeago" title="<?php echo $bookreply['Book']['created'] ?>"><?php echo $bookreply['Book']['created'] ?></td>
        <td class="status"><?php echo $STATUS[$bookreply['Bookreply']['pass']] ?></td>
				<td>
				  <a href="#" class="pass"><img  src="/images/icn_alert_success.png" alt="通过"></a>
          <a href="#" class="reject"><img src="/images/icn_alert_error.png" alt="不通过"></a></td>

		</tr> 
    <?php endforeach; ?>
	</tbody>
	</table>

	</div><!-- end of #tab1 -->

	
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
      url:'/admin/books_reply/pass',
      type:'post',
      data:{'id':$(that).parent().parent().find('input[type=checkbox]').val()},
      dataType:'html',
      success:function(html) {
        if (html=='OK') {
          $(that).parent().parent().find('.status').html('<span style="color:red">通过</span>');
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
      url:'/admin/books_reply/reject',
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
  
});
</script>
<div style="clear:both;height:400px;">
  
</div>