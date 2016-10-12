<style type="text/css" media="screen">
.fav_menu1{height:25px;line-height:25px;background:#F7F7F7 ;border-bottom:1px dashed #dedede;color:#666;}
.fav_menu1 .td1{float:left;width:90px;text-align:center}
.fav_menu1 .td2{float:left;width:290px;}
.fav_menu1 .td3{float:left;width:120px;}
.fav_menu1 .td4{float:left;width:240px;text-align:center}

.fav_line1{height:25px;line-height:25px;border-bottom:1px dashed #dedede;text-align:center;color:#999;}
.fav_line1 .td1{float:left;width:90px;}
.fav_line1 .td2{float:left;width:290px;text-align:left;}
.fav_line1 .td3{float:left;width:120px;text-align:left;}
.fav_line1 .td4{float:left;width:240px;}
.fav_line1 .td5{float:left;}

.fav_line1 a:link ,.fav_line1 a:visited{color: #2269D1; text-decoration:underline;}
.fav_line1 a:hover {color: #DB2C30; text-decoration:none;}
</style>
<?php echo $this->element('myshufang'); ?>

<?php
$NOVEL_TYPE = array('qingchun' => '青春' , 'yanqing'=>'言情','chuanyue'=>'穿越','wuxia' => '武侠','xuanhuan'=>'玄幻','wenxue'=>'文学','xuanyi'=>'悬疑','dushi'=>'都市','lishi'=>'历史','jingguan'=>'经管');
$NOVEL_LIST = array('qingchun' , 'yanqing','chuanyue', 'wuxia','xuanhuan','wenxue','xuanyi','dushi','lishi','jingguan');
?>
<div class="uc_r">
   <div class="uc_t">我的书架</div>
<div class="fav_menu1">
<div class="td1">类别</div><div class="td2">书名</div><div class="td3">作者</div><div class="td4">操作</div></div>
<?php if (empty($collects)): ?>
<div class="fav_line1">您还没有任何藏书！</div>     
<?php else: ?>

  <?php foreach ($collects as $index => $collect): ?>
       <div id="F636258" class="fav_line1">
<div class="td1"><a href="/<?php echo $NOVEL_LIST[$collect['Book']['type']] ?>" target="_blank"><?php echo $NOVEL_TYPE[$NOVEL_LIST[$collect['Book']['type']]] ?></a></div>
<div class="td2"><a href="<?php echo $this->Html->getPath($collect['Book']['burl']) ?>" target="_blank"><?php echo $collect['Book']['name']?></a></div>
<div class="td3">
<a href="/search/q_<?php echo $collect['Book']['author'] ?>" target="_blank"><?php echo $collect['Book']['author'] ?></a></div>
<div class="td4">
[<a title="浏览该书籍" href="<?php echo $this->Html->getPath($collect['Book']['burl']) ?>" target="_blank">阅读</a>][<form action="/favorite/delete" method="post" accept-charset="utf-8" style="display:inline"><input type="hidden" name="bid" value="<?php echo $collect['Collect']['bid']; ?>" id="bid"><input style="border:none;background:transparent;cursor:pointer;color: #2269D1;text-decoration: underline;" type="submit" onclick="return confirm('确认要删除此行收藏吗？')" title="删除本条收藏" value="删除">
</form>]</div>
</div>
  <?php endforeach ?>    
<?php endif ?>
<div class="fav_menu1">
<div class="td1"><?php
      	echo $this->Paginator->counter(array(
      	'format' => __('第{:page}页 共{:pages}页')
      	));
      	?>	
</div><div class="td2">
  &nbsp;
</div><div class="td5">  <?php
		echo $this->Paginator->prev(  __('上一页 '), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ' '));
		echo $this->Paginator->next(__(' 下一页') , array(), null, array('class' => 'next disabled'));
	?></div></div>
</div>