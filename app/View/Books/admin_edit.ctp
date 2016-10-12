<div class="books form">
<?php echo $this->Form->create('Book'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Book'); ?></legend>
	<?php
		echo $this->Form->input('bid');
		echo $this->Form->input('burl');
		echo $this->Form->input('uid');
		echo $this->Form->input('pass');
		echo $this->Form->input('name');
		echo $this->Form->input('author');
		echo $this->Form->input('type');
		echo $this->Form->input('status');
		echo $this->Form->input('lastid');
		echo $this->Form->input('decs');
		echo $this->Form->input('location');
		echo $this->Form->input('filesize');
		echo $this->Form->input('fengmian');
		echo $this->Form->input('collect');
		echo $this->Form->input('click');
		echo $this->Form->input('clickweekly');
		echo $this->Form->input('downloads');
		echo $this->Form->input('downloadsweekly');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Book.bid')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Book.bid'))); ?></li>
		<li><?php echo $this->Html->link(__('List Books'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
