<div class="books index">
	<h2><?php echo __('Books'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('bid'); ?></th>
			<th><?php echo $this->Paginator->sort('burl'); ?></th>
			<th><?php echo $this->Paginator->sort('uid'); ?></th>
			<th><?php echo $this->Paginator->sort('pass'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('author'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('lastid'); ?></th>
			<th><?php echo $this->Paginator->sort('decs'); ?></th>
			<th><?php echo $this->Paginator->sort('location'); ?></th>
			<th><?php echo $this->Paginator->sort('filesize'); ?></th>
			<th><?php echo $this->Paginator->sort('fengmian'); ?></th>
			<th><?php echo $this->Paginator->sort('collect'); ?></th>
			<th><?php echo $this->Paginator->sort('click'); ?></th>
			<th><?php echo $this->Paginator->sort('clickweekly'); ?></th>
			<th><?php echo $this->Paginator->sort('downloads'); ?></th>
			<th><?php echo $this->Paginator->sort('downloadsweekly'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($books as $book): ?>
	<tr>
		<td><?php echo h($book['Book']['bid']); ?>&nbsp;</td>
		<td><?php echo h($book['Book']['burl']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($book['User']['slug'], array('controller' => 'users', 'action' => 'view', $book['User']['uid'])); ?>
		</td>
		<td><?php echo h($book['Book']['pass']); ?>&nbsp;</td>
		<td><?php echo h($book['Book']['name']); ?>&nbsp;</td>
		<td><?php echo h($book['Book']['author']); ?>&nbsp;</td>
		<td><?php echo h($book['Book']['type']); ?>&nbsp;</td>
		<td><?php echo h($book['Book']['status']); ?>&nbsp;</td>
		<td><?php echo h($book['Book']['lastid']); ?>&nbsp;</td>
		<td><?php echo h($book['Book']['decs']); ?>&nbsp;</td>
		<td><?php echo h($book['Book']['location']); ?>&nbsp;</td>
		<td><?php echo h($book['Book']['filesize']); ?>&nbsp;</td>
		<td><?php echo h($book['Book']['fengmian']); ?>&nbsp;</td>
		<td><?php echo h($book['Book']['collect']); ?>&nbsp;</td>
		<td><?php echo h($book['Book']['click']); ?>&nbsp;</td>
		<td><?php echo h($book['Book']['clickweekly']); ?>&nbsp;</td>
		<td><?php echo h($book['Book']['downloads']); ?>&nbsp;</td>
		<td><?php echo h($book['Book']['downloadsweekly']); ?>&nbsp;</td>
		<td><?php echo h($book['Book']['created']); ?>&nbsp;</td>
		<td><?php echo h($book['Book']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $book['Book']['bid'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $book['Book']['bid'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $book['Book']['bid']), null, __('Are you sure you want to delete # %s?', $book['Book']['bid'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Book'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
