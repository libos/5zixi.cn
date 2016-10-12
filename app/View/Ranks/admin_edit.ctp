<?php $this->start('nav'); ?>
		<div class="breadcrumb_divider"></div> <a class="current">用户等级修改</a>
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

<div class="ranks form">
<?php echo $this->Form->create('Rank'); ?>
	<fieldset>
		<legend><?php echo __('用户等级修改'); ?></legend>
	  <?php echo $this->Form->input('cid'); ?>
    <div style="clear:both"></div>
    <?php echo $this->Form->input('cname');?>
    <div style="clear:both"></div>
    <?php echo $this->Form->input('min');?>
    <div style="clear:both"></div>
    <?php echo $this->Form->input('max');?>
    <div style="clear:both"></div>

	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>