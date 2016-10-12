<div class="users view">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Uid'); ?></dt>
		<dd>
			<?php echo h($user['User']['uid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Slug'); ?></dt>
		<dd>
			<?php echo h($user['User']['slug']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($user['User']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($user['User']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Salt'); ?></dt>
		<dd>
			<?php echo h($user['User']['salt']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sex'); ?></dt>
		<dd>
			<?php echo h($user['User']['sex']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Uploads'); ?></dt>
		<dd>
			<?php echo h($user['User']['uploads']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Incount'); ?></dt>
		<dd>
			<?php echo h($user['User']['incount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($user['Group']['gname'], array('controller' => 'groups', 'action' => 'view', $user['Group']['gid'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Regip'); ?></dt>
		<dd>
			<?php echo h($user['User']['regip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lastip'); ?></dt>
		<dd>
			<?php echo h($user['User']['lastip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Avatar'); ?></dt>
		<dd>
			<?php echo h($user['User']['avatar']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($user['User']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($user['User']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['uid'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['uid']), null, __('Are you sure you want to delete # %s?', $user['User']['uid'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Books'), array('controller' => 'books', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Books'), array('controller' => 'books', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Books'); ?></h3>
	<?php if (!empty($user['Books'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Bid'); ?></th>
		<th><?php echo __('Burl'); ?></th>
		<th><?php echo __('Uid'); ?></th>
		<th><?php echo __('Pass'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Author'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Lastid'); ?></th>
		<th><?php echo __('Decs'); ?></th>
		<th><?php echo __('Location'); ?></th>
		<th><?php echo __('Filesize'); ?></th>
		<th><?php echo __('Fengmian'); ?></th>
		<th><?php echo __('Collect'); ?></th>
		<th><?php echo __('Click'); ?></th>
		<th><?php echo __('Clickweekly'); ?></th>
		<th><?php echo __('Downloads'); ?></th>
		<th><?php echo __('Downloadsweekly'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Books'] as $books): ?>
		<tr>
			<td><?php echo $books['bid']; ?></td>
			<td><?php echo $books['burl']; ?></td>
			<td><?php echo $books['uid']; ?></td>
			<td><?php echo $books['pass']; ?></td>
			<td><?php echo $books['name']; ?></td>
			<td><?php echo $books['author']; ?></td>
			<td><?php echo $books['type']; ?></td>
			<td><?php echo $books['status']; ?></td>
			<td><?php echo $books['lastid']; ?></td>
			<td><?php echo $books['decs']; ?></td>
			<td><?php echo $books['location']; ?></td>
			<td><?php echo $books['filesize']; ?></td>
			<td><?php echo $books['fengmian']; ?></td>
			<td><?php echo $books['collect']; ?></td>
			<td><?php echo $books['click']; ?></td>
			<td><?php echo $books['clickweekly']; ?></td>
			<td><?php echo $books['downloads']; ?></td>
			<td><?php echo $books['downloadsweekly']; ?></td>
			<td><?php echo $books['created']; ?></td>
			<td><?php echo $books['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'books', 'action' => 'view', $books['bid'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'books', 'action' => 'edit', $books['bid'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'books', 'action' => 'delete', $books['bid']), null, __('Are you sure you want to delete # %s?', $books['bid'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Books'), array('controller' => 'books', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
