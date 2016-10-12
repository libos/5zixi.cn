<?php $this->start('rewrite_css'); ?>

.main_div{width:960px;margin:auto;margin-bottom:10px;}
.main_l{width:105px;text-align:left;font-size:14px;border: 1px solid #DEEBFF;padding:15px;}
.main_k{margin-bottom:5px;float:left;height: 600px; width: 135px;text-align:center;font-size:14px;border: 1px solid #DEEBFF;}
.main_l .n{font-weight:bold;}
.main_l li{height:24px;line-height:24px;}

.list_l{float:left;width:710px;text-align:left;}
.list_r{float:right;width:250px;}
.Search_Page{background:#f3f3f3;padding:3px;margin-top:5px;text-align:center;}
.List_Info{float:left;width:355px;text-align:left;border-bottom:1px dashed #cccccc;padding-top:9px;}
.List_InfoHead{overflow :hidden;line-height:20px;height:20px;font-weight:bold;font-size:14px;}
.List_InfoLine{overflow :hidden;line-height:18px;height:18px;color:#444;}

.List_InfoBodyL{float:left;}
.bookpic{height:165px;width:117px;padding:3px;border:1px solid #ddd;}
.List_InfoBodyR{float:right;width:215px;padding-top:5px;}
.List_InfoContent{text-indent: 2em;color:#666;padding-top:3px;}
.List_InfoBody{height:180px;padding:0px;margin-left:2px;}
.gray2 {color: #909090;}
.red2{color:#dc143c}
.side_title{height:24px;line-height:24px;font-weight:bold;text-align: center;}
.Info_RightList li{margin-left:15px;height:22px;line-height:22px;text-align:left;width:240px;overflow:hidden;}
<?php $this->end(); ?>
<?php
$NOVEL_TYPE = array('qingchun' => '青春' , 'yanqing'=>'言情','chuanyue'=>'穿越','wuxia' => '武侠','xuanhuan'=>'玄幻','wenxue'=>'文学','xuanyi'=>'悬疑','dushi'=>'都市','lishi'=>'历史','jingguan'=>'经管');
$NOVEL_LIST = array('qingchun' , 'yanqing','chuanyue', 'wuxia','xuanhuan','wenxue','xuanyi','dushi','lishi','jingguan');
$STATUS = array('Y'=>'已完结','N'=>'连载中');
?>
<div class="main_div">
    <div class="list_l">
        <div class="Search_Page" style="clear:both;"><span id="pager"> <?php echo $this->Paginator->counter(array(
      	'format' => __('<span class="l">共有书籍{:count}本</span><span class="r">' . $this->Paginator->prev( __('上一页'), array(), null, array('class' => 'prev disabled')) . " " . $this->Paginator->numbers(array('separator' => ' ')) . " " . $this->Paginator->next(__('下一页'), array(), null, array('class' => 'next disabled')) )
      	)); ?></span></div>
        <?php foreach ($books as $index => $book): ?>
          <?php $url = $this->Html->getPath($book['Book']['burl']); ?>
          <div class="List_Info">
              <div class="List_InfoBody">
                  <div class="List_InfoBodyL">
                      <a href="<?php echo $url; ?>" target="_blank">
                          <img src="<?php echo $this->Html->getCoverByFengmian_id($book['Book']['fengmian_id'],$book['img']); ?>" class="bookpic"></a></div>
                  <div class="List_InfoBodyR">
                      <div class="List_InfoHead">
                          <a href="<?php echo $url; ?>" target="_blank"><?php echo $book['Book']['name'] ?></a></div>
                      <div class="List_InfoLine">
                          作者：<a href="/search?q=<?php echo $book['Book']['author']; ?>" target="_blank"><?php echo $book['Book']['author'] ?></a></div>
                      <div class="List_InfoLine">
                        <?php $type_id = $NOVEL_LIST[$book['Book']['type']] ; ?>
                          类型：<a href="/<?php echo $type_id . ".html"; ?>" target="_blank"><?php echo $NOVEL_TYPE[$type_id]; ?></a>
                          状态：<?php echo $STATUS[$book['Book']['status']] ?></div>
                      <div class="List_InfoContent">
                          孤寂的行者，追逐阴影的脚步，这是盗贼的赞歌。带着一个一百八十级的大盗贼的记忆，回到了十年前，命运给聂言开了一个玩笑。曾经错过的、被夺走的，都要重新拿回来。然后搞一身神装，摧枯拉朽，... [<a href="/book/201306/27/id_XMzMwNjMz.html" target="_blank">阅读</a>][<a href="javascript:;" onclick="javascript:FavAdd(330633)" title="加入收藏">收藏</a>]</div>
                  </div>
              </div>
          </div>          
        <?php endforeach ?>

    
        <div class="Search_Page" style="clear:both;"><span id="pager">
          <?php echo $this->Paginator->counter(array(
      	'format' => __('<span class="l">共有书籍{:count}本</span><span class="r">' . $this->Paginator->prev( __('上一页'), array(), null, array('class' => 'prev disabled')) . " " . $this->Paginator->numbers(array('separator' => ' ')) . " " . $this->Paginator->next(__('下一页'), array(), null, array('class' => 'next disabled')) )
      	)); ?>
        </span>
    </div>
</div>
<div class="list_r">
    <!-- <div class="side_title">
        人气排行 ……</div>
    <div class="Info_RightList">
        <ul>
        </ul>
    </div>
   -->
    <div style="margin-left:15px;height: 600px;width: 120px;">
     
    </div>
</div>
</div>