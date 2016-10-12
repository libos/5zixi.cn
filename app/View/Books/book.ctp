<?php $this->start('rewrite_css'); ?>
.info_user{border:1px solid #ddd;padding:10px;height:70px;}
.info_user a:link ,.info_user a:visited{color: #3165CE; text-decoration: none}
.info_user a:hover {color: #FF6500; text-decoration:underline;}
.info_user .l{float:left;width:75px;}
.info_user .r{float:left;padding-top:5px;}
.info_ad{margin-top:10px;}
.info_l{float:left;width:630px;}
.info_2{float:left;}
.info_r{float:right;width:302px;}
.info_topten{border:1px solid #ddd;padding:10px;margin-top:10px;}
.info_topten li{height:22px;line-height:22px;color:#666;padding-left:5px;}

.info_samebook{border:1px solid #ddd;padding:10px;margin-top:10px;height:245px;}
.info_samebook li{float:left;height:116px;width:90px;color:#666;padding-left:3px;overflow:hidden;text-align:center;}
.info_samebook img{width:72px;height:96px;}
.comment{border:1px solid #DEEBFF;padding:3px;word-break:break-all;clear:both;margin-top:10px;}
.comment .head{height:28px;line-height:28px;padding:5px 10px;}
.comment .head .l{float:left;font-weight:bold;font-size:14px;}
.comment .head .r{float:right;}

.comment_list li{clear:both;margin-bottom:5px;}
.comment_list li .l{float:left;width:100px;height:80px;text-align:center;margin-top:5px;margin-left:10px;}
.comment_list li .r{float:right;width:595px;margin-right:15px;}

.comment_list .t{height:28px;background:#F7F7FF;line-height:28px;padding-left:5px;color:#333;text-align:left}
.comment_list span{color:#9C9A9C;}
.comment .reply{text-align:right;padding-right:10px;}
.comment .content{padding:5px;color:#333; text-align:left}

.comment a:link ,.comment a:visited{color: #2269D1; text-decoration:underline;}
.comment a:hover {color: #DB2C30; text-decoration:none;}

.comment_page{height:28px;line-height:28px;margin:0 8px;clear:both;}
.comment_page .l{float:left;}
.comment_page .r{float:right;}
.comment_page .c{font-weight:bold;color:#000;}

.comment_post{margin-left:24px;}
.comment_post .t{font-weight:bold;font-size:14px;height:28px;line-height:28px;}
.comment_post .txt{padding:5px;}
.comment_post .b{padding:11px;text-align:center;}
.comment_txt{border:1px solid #CECFCE;width:558px;border-top:1px solid #444;border-left:1px solid #444;border-bottom:1px solid #ccc;border-right:1px solid #ccc;color:#333;}
.list_null{text-align:center;color:#999;font-size:14px;font-weight:bold; height:70px;line-height:70px;}
.user_l{float:left;}
.user_r{float:right;width:730px;text-align:left;}
a{font-size:12px;color: #2269D1; text-decoration:underline;}
a:hover {color: #DB2C30; text-decoration:none;}
<?php $this->end(); ?>
<?php
include $path;
?>

<form name="form1" method="post" action="/books/comment" id="form1">
  <script type="text/javascript" charset="utf-8">
  function PostReply(who) {
    $('#comment_txt').focus();
    $('#comment_txt').val("@" + who + " " + $('#comment_txt').val());
  }
  </script>
    <div class="comment">
 <div class="head"><div class="l">网友评论(<span id="C_Num">0</span>)</div><div class="r"><a href="javascript:;" class="PostReply">发布评论</a></div></div>
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
         $this->Paginator->options(array('update' => '#comment_list','evalScripts' => true));
       	echo $this->Paginator->counter(array(
       	'format' => __('<span class="l">本页{:current}条 共{:count}条</span><span class="r">' . $this->Paginator->prev('<' . __('上一页'), array(), null, array('class' => 'prev disabled')) . " " . $this->Paginator->numbers(array('separator' => ' ')) . " " . $this->Paginator->next(__('下一页') . ' >', array(), null, array('class' => 'next disabled')) )
       	));
         echo $this->Js->writeBuffer();
       	?></span></div>
 </div>
  <div class="comment_post" id="comment_post">
  <div class="t">发表您的评论</div>
  <div class="txt">
    <input type="hidden" name="book_id" value="<?php echo $book['Book']['bid']; ?>" id="book_id">
    <textarea name="comment_txt" rows="8" cols="20" id="comment_txt" class="comment_txt" ></textarea>
  </div>
  <div class="b">
    <input type="submit" name="comment_post" class="button3" value="发表评论" ></div>
  
  </div>  </div>
</form>


</div>  
<?php
//*******
//这个div是用来结束include里面的div的
?>

<div class="info_r">
        <div class="info_user">
            <div class="l">
                <a href="/shufang/<?php echo $book['User']['uid'] ?>">
                    <img src="<?php echo $book['User']['avatar']; ?>" class="userface_s"></a>
            </div>
            <div class="r">
                上传：<b><a href="/shufang/<?php echo $book['User']['uid']; ?>"><?php echo $book['User']['slug']; ?></a></b> (<a href="/shufang/<?php echo $book['User']['uid']; ?>" target="_blank">参观书房</a>)<br>
                发布时间：<span class="gray2 timeago" title="<?php echo $book['Book']['created']; ?>"></span><br>
                书籍：<?php echo $book['User']['uploads']; ?>本 <span class="gray">(<a href="/help#class" target="_blank"><?php echo $rnd[$book['User']['class_id']]; ?></a>)</span>
            </div>
        </div>
        <div class="info_ad">

        </div>
        
        <?php include $rndpath; ?>
      <div class="index_log" style="text-align: center;">
     <!-- 广告位：首页右边第一个 -->
     <script type="text/javascript">
     document.write('<a style="display:none!important" id="tanx-a-mm_46924635_4290951_14546072"></a>');
     tanx_s = document.createElement("script");
     tanx_s.type = "text/javascript";
     tanx_s.charset = "gbk";
     tanx_s.id = "tanx-s-mm_46924635_4290951_14546072";
     tanx_s.async = true;
     tanx_s.src = "http://p.tanx.com/ex?i=mm_46924635_4290951_14546072";
     tanx_h = document.getElementsByTagName("head")[0];
     if(tanx_h)tanx_h.insertBefore(tanx_s,tanx_h.firstChild);
</script> 
<script src="http://a.alimama.cn/inf.js" type="text/javascript"></script>  

 </div>
 
        <?php include $hot_plus; ?>
    </div>
    
    
<script type="text/javascript" charset="utf-8" src="/js/jquery.timeago.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
      $(".timeago").timeago();
      $('.PostReply').click(function() {
        $('#comment_txt').focus();
      });
      
    });
</script>

