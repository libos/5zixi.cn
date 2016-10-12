<?php echo $this->element('myshufang'); ?>
<style type="text/css" media="screen">
.uc_index {
height: auto ;
padding-bottom: 40px;
padding-top:0;
}  
.uc_info{
  padding:0;
  
}
.books_menu1 {
height: 25px;
line-height: 25px;
background: #F7F7F7;
text-align: left;
border-bottom: 1px dashed #dedede;
color: #666;
}
.books_menu1 .td1 {
float: left;
width: 200px;
text-align: center;
}
.books_menu1 .td2 {
float: left;
width: 310px;
}
.books_menu1 .td3 {
float: left;
width: 230px;
}
.books_line1 {
height: 140px;
line-height: 25px;
padding: 10px;
border-bottom: 1px dashed #dedede;
text-align: left;
color: #999;
}
.books_line1 .td1 {
float: left;
width: 190px;
text-align: center;
}
.books_line1 .td2 {
float: left;
width: 300px;
}
.books_line1 .td3 {
float: left;
width: 230px;
}
.list_img {
height: 135px;
width: 95px;
border: 1px solid #ddd;
padding: 2px;
}

</style>

<?php
$NOVEL_TYPE = array('qingchun' => '青春' , 'yanqing'=>'言情','chuanyue'=>'穿越','wuxia' => '武侠','xuanhuan'=>'玄幻','wenxue'=>'文学','xuanyi'=>'悬疑','dushi'=>'都市','lishi'=>'历史','jingguan'=>'经管');
$NOVEL_LIST = array('qingchun' , 'yanqing','chuanyue', 'wuxia','xuanhuan','wenxue','xuanyi','dushi','lishi','jingguan');

$STATUS = array(0=>'待审','1'=>'未通过',11=>'处理中...',12=>'通过',21=>'特别推荐',22=>'特别推荐');
$QUAN = array('Y'=>'已完结','N'=>'连载中',''=>'已完结');
?>
<div class="uc_r">
        <div class="uc_t">我贡献的小说</div>
      <div class="uc_info">
        <div class="uc_index">
          <div class="books_menu1">
            <div class="td1">封面</div><div class="td2">书籍资料</div><div class="td3">操作</div>
          </div>
          <?php if (empty($mybooks)): ?>
          <div class="fav_line1">您还没有任何书，<a href="/upload" target="_blank">开始上传</a>！</div>
          <?php else: ?>

            <?php foreach ($mybooks as $index => $book): ?>
              <?php $book = $book['Book']; ?>
              <div id="B<?php echo $book['burl'] ?>" class="books_line1">
                <div class="td1"><a target="_top" href="/book/<?php echo $book['burl'] ?>.html"><img width="102" height="120" src="<?php echo $this->Html->getcover($book['fengmian_id']); ?>" alt="<?php echo $NOVEL_TYPE[$NOVEL_LIST[$book['type']]]; ?>" class="list_img"></a>
                </div>
                <div class="td2"><a target="_top" href="/book/<?php echo $book['burl'] ?>.html"><b><?php echo $book['name'] ?></b></a><br>发布时间：<?php echo date('Y年m月d日',strtotime($book['created'])); ?><br>
                类型：<a href="/<?php echo $NOVEL_LIST[$book['type']] ?>" target="_blank"><?php echo $NOVEL_TYPE[$NOVEL_LIST[$book['type']]]; ?></a><br>大小：<?php echo $this->Html->getTextSize($book['txt_id']) ?>　收藏：<?php echo $book['collect'] ?>　人气：<span style="color:#008200;"><?php echo $book['click'] ?></span><br>状态：<span style="color:#ff5500;"><?php echo $QUAN[$book['status']] ?></span></div>
                <div class="td3">
                [<a title="我要续传" target="_top" href="/upload?bid=<?php echo $book['bid'] ?>">我要续传</a>]<br>[<a title="修改信息" target="_top" href="/books/edit/<?php echo $book['bid'] ?>">修改信息</a>]<br>[<a title="浏览该书籍" href="<?php echo  $this->Html->getPath($book['burl']) ?>" target="_blank">浏览该书籍</a>]<br>[<a title="查看内容" href="<?php echo $this->Html->getFullPath($book['created'],$book['burl'],$book['bid']); ?>" target="_blank">查看全文</a>]</div>
              </div>            
            <?php endforeach ?>
          <?php endif ?>
          <div class="books_menu1">
            <div class="td1"><?php
      	echo $this->Paginator->counter(array(
      	'format' => __('第{:page}页 共{:pages}页')
      	));
      	?></div><div class="td2">&nbsp;</div><div class="td3"><?php
      		echo $this->Paginator->prev(  __('上一页 '), array(), null, array('class' => 'prev disabled'));
      		echo $this->Paginator->numbers(array('separator' => ' '));
      		echo $this->Paginator->next(__(' 下一页') , array(), null, array('class' => 'next disabled'));
      	?></div>
          </div>
        </div>
      </div>    
</div>
