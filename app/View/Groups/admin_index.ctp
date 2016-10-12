<?php $this->start('nav'); ?>
		<div class="breadcrumb_divider"></div> <a class="current">用户等级管理</a>
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

<h4 class="alert_warning" style="display:none">A Warning Alert</h4>

<h4 class="alert_error" style="display:none">An Error Message</h4>

<h4 class="alert_success" style="display:none">A Success Message</h4>
<article class="module width_3_quarter">
<header><h3 class="tabs_involved">用户组</h3>
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
		<li><a href="#tab1">用户组管理</a></li>
    <li><a href="#tab2">添加</a></li>
</ul>
</header>

<div class="tab_container">
	<div id="tab1" class="tab_content">
	<table class="tablesorter" cellspacing="0"> 
	<thead> 
		<tr> 
				<th width="20"><input type="checkbox" class="checkall" /></th> 
        <th>编号</th>
        <th>用户组名</th>
        <th>创建日期</th>
				<th>操作</th> 
		</tr> 
	</thead> 
	<tbody> 
    <?php foreach ($groups as $group): ?>
		<tr> 
				<td><input type="checkbox" value="<?php echo $group['Group']['gid']; ?>"></td> 
    		<td><?php echo h($group['Group']['gid']); ?>&nbsp;</td>
    		<td><?php echo h($group['Group']['gname']); ?>&nbsp;</td>
    		<td><?php echo h($group['Group']['created']); ?>&nbsp;</td>
				<td>	<?php echo $this->Html->link(__('编辑'), array('action' => 'edit', $group['Group']['gid'])); ?>
			<?php echo $this->Form->postLink(__('删除'), array('action' => 'delete', $group['Group']['gid']), null, __('Are you sure you want to delete # %s?', $group['Group']['gid'])); ?></td>

		</tr> 
    <?php endforeach; ?>
	</tbody>
	</table>

	</div><!-- end of #tab1 -->
	
</div><!-- end of .tab_container -->

</article><!-- end of content manager article -->
