<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit User'); ?></legend>
	<?php
		echo $this->Form->input('uid');
		echo $this->Form->input('slug');
		echo $this->Form->input('email');
		echo $this->Form->input('password');
		echo $this->Form->input('salt');
		echo $this->Form->input('sex');
		echo $this->Form->input('uploads');
		echo $this->Form->input('incount');
		echo $this->Form->input('group_id');
		echo $this->Form->input('regip');
		echo $this->Form->input('lastip');
		echo $this->Form->input('avatar');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.uid')), null, __('Are you sure you want to delete # %s?', $this->Form->value('User.uid'))); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Books'), array('controller' => 'books', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Books'), array('controller' => 'books', 'action' => 'add')); ?> </li>
	</ul>
</div>
