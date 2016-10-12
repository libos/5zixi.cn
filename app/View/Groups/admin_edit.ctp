<?php $this->start('nav'); ?>
		<div class="breadcrumb_divider"></div> <a class="current">用户组修改</a>
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
  .form{
    width:20%;
    margin:auto;

  }
  fieldset input[type=text]
  {
    width:50%;
  }
  input{
    margin-left:20px;
  }
</style>

<div class="groups form">
<?php echo $this->Form->create('Group'); ?>
	<fieldset>
		<legend><?php echo __('用户组修改'); ?></legend>
	<?php
		echo $this->Form->input('gid');
		echo $this->Form->input('gname');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
