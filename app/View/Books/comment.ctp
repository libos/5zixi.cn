<div id="comment_list" class="comment_list">
  <div class="comment_page"><?php
        $this->Paginator->options(array('update' => '#comment_list'));
      	echo $this->Paginator->counter(array(
      	'format' => __('<span class="l">本页{:current}条 共{:count}条</span><span class="r">' . $this->Paginator->prev('<' . __('上一页'), array(), null, array('class' => 'prev disabled')) . " " . $this->Paginator->numbers(array('separator' => ' ')) . " " . $this->Paginator->next(__('下一页') . ' >', array(), null, array('class' => 'next disabled')) )
      	));
      	?></div><ul>
    <?php foreach ($brs as $index => $br): ?>
      <?php $url="/"; ?>
      <?php $name="游客"; ?>
      <?php if ($br['Bookreply']['uid']!=0): ?>
        <?php $url="/shufang/" . $br['Bookreply']['uid'] ?>
        <?php $name = $br['User']['slug']; ?>

      <?php endif ?><li><div class="t"><a href="<?php echo $url; ?>" target="_blank"><?php echo $name; ?></a> 发布于 <span class="timeago" title="<?php echo $br['Bookreply']['created'] ?>"></span></div><div class="content"><?php echo nl2br($br['Bookreply']['body']) ?></div><div class="reply"><a href="javascript:PostReply('<?php echo $name; ?>')">回复</a></div></li><?php endforeach ?></ul><div class="comment_page"><?php
        $this->Paginator->options(array('update' => '#comment_list'));
      	echo $this->Paginator->counter(array(
      	'format' => __('<span class="l">本页{:current}条 共{:count}条</span><span class="r">' . $this->Paginator->prev('<' . __('上一页'), array(), null, array('class' => 'prev disabled')) . " " . $this->Paginator->numbers(array('separator' => ' ')) . " " . $this->Paginator->next(__('下一页') . ' >', array(), null, array('class' => 'next disabled')) )
      	));
        echo $this->Js->writeBuffer();
      	?></span></div>
</div>