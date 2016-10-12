<?php $this->start('nav'); ?>
		<div class="breadcrumb_divider"></div> <a class="current">反馈处理</a>
<?php $this->end(); ?>
<style type="text/css" media="screen">
.width_quarter{
  width:95%;
  margin-bottom:60px;
}
.message_list{
  height:650px;
}
#tabbbb{
  margin:auto;
  text-align:center;
}
</style>
<article class="module width_quarter">
	<header><h3>反馈信息</h3></header>
	<div class="message_list">
		<div class="module_content">
      <?php foreach ($feedbacks as $index => $feedback): ?>
			<div class="message"><p><?php echo nl2br($feedback['Feedback']['body']) ?></p>
			<p><strong><a href="mailto:<?php echo $feedback['Feedback']['email'] ?>"><?php echo $feedback['Feedback']['email'] ?></a></strong></p></div>
      <?php endforeach ?>
		</div>
	</div>
	<footer>
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

	</footer>
</article><!-- end of messages article -->
