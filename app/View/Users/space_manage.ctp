<style type="text/css" media="screen">
.M_Box {
width: 650px;
background-color: #f7f7f7;
padding: 5px;
}
.M_Box1 {
float: left;
width: 200px;
}
.M_Box2 {
float: left;
line-height: 22px;
width: 200px;
}
</style>
<?php echo $this->element('myshufang'); ?>

<div class="uc_r">
     
   <div class="uc_t">空间留言管理</div>
   
<div class="uc_modify">
  <?php if (empty($spacereplies)): ?>
    <div class="space_null">暂时还没有评论</div>
  <?php endif ?>
  <table id="DataList1" class="Info_Comment1" cellspacing="0" border="0" style="border-collapse:collapse;">
  	<tbody>
      <?php foreach ($spacereplies as $index => $spacereply): ?>
        <tr>
    		<td style="color:#333333;">
          <div class="M_Box1">发布人:<a href="/shufang/<?php echo $spacereply['Spacereply']['uid'] ?>" target="_blank"><span class="userslug" style="font-weight:bold;"><?php echo $spacereply['User']['slug'] ?></span></a></div><div class="M_Box2"></div><div style="float:left;line-height:22px;"><span class="posttime"><?php echo $spacereply['Spacereply']['created'] ?></span></div>
    <div style="float:right;width:100px">
      <form action="/spacereply/delete" type="post"><input type="hidden" name="rid" value="<?php echo $spacereply['Spacereply']['rid'] ?>" id="rid"><input type="submit" name="delete" value="删除" onclick="return confirm('是否确认删除？');" class="delete button3" class="ManagerButton"></form>
      </div></div>
    <div style="clear:both;width:100%;border: #dedede 1px dashed;border-bottom:1px #000 solid;padding:5px;"><span class="comment_body" style="padding-left:8px"><?php echo nl2br($spacereply['Spacereply']['body']); ?></span><br>
  </div></td>
    	</tr>
      <?php endforeach ?>
  </tbody></table>
  <span id="pager">
    <div class="comment_page">
    	<span class="l">
    	<?php
    	echo $this->Paginator->counter(array(
    	'format' => __('第{:page}页 共{:pages}页')
    	));
    	?>	
      </span>
    	<span class="r">
      <?php
    		echo $this->Paginator->prev(  __('上一页 '), array(), null, array('class' => 'prev disabled'));
    		echo $this->Paginator->numbers(array('separator' => ' '));
    		echo $this->Paginator->next(__(' 下一页') , array(), null, array('class' => 'next disabled'));
    	?></p>
      </span>
    </div>
    
  </span>
        <br>
        
            
    </div>  </div>