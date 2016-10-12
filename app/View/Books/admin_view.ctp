<div class="books view">
<h2><?php echo __('Book'); ?></h2>
	<dl>
		<dt><?php echo __('Bid'); ?></dt>
		<dd>
			<?php echo h($book['Book']['bid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Burl'); ?></dt>
		<dd>
			<?php echo h($book['Book']['burl']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($book['User']['slug'], array('controller' => 'users', 'action' => 'view', $book['User']['uid'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pass'); ?></dt>
		<dd>
			<?php echo h($book['Book']['pass']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($book['Book']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Author'); ?></dt>
		<dd>
			<?php echo h($book['Book']['author']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($book['Book']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($book['Book']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lastid'); ?></dt>
		<dd>
			<?php echo h($book['Book']['lastid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Decs'); ?></dt>
		<dd>
			<?php echo h($book['Book']['decs']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Location'); ?></dt>
		<dd>
			<?php echo h($book['Book']['location']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Filesize'); ?></dt>
		<dd>
			<?php echo h($book['Book']['filesize']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fengmian'); ?></dt>
		<dd>
			<?php echo h($book['Book']['fengmian']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Collect'); ?></dt>
		<dd>
			<?php echo h($book['Book']['collect']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Click'); ?></dt>
		<dd>
			<?php echo h($book['Book']['click']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Clickweekly'); ?></dt>
		<dd>
			<?php echo h($book['Book']['clickweekly']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Downloads'); ?></dt>
		<dd>
			<?php echo h($book['Book']['downloads']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Downloadsweekly'); ?></dt>
		<dd>
			<?php echo h($book['Book']['downloadsweekly']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($book['Book']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($book['Book']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Book'), array('action' => 'edit', $book['Book']['bid'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Book'), array('action' => 'delete', $book['Book']['bid']), null, __('Are you sure you want to delete # %s?', $book['Book']['bid'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Books'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Book'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
