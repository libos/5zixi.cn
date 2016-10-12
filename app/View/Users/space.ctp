<?php $this->start('rewrite_css'); ?>
.main_div {
width: 960px;
margin: auto;
margin-bottom: 10px;
}

.space_title{height:35px;line-height:35px;text-align:left;padding-left:30px;background:#f7f7f7;margin-bottom:5px;border:1px solid #DEDFDE;}
.space_title span{font-size:16px;font-weight:bold;margin-right:20px;}

.space_info{width:220px;border:1px solid #ddd;height:280px;margin-bottom:8px;}
.space_infobox{padding-top:10px;width:150px;margin:auto;text-align:center}


.space_info li{text-align:left;height:24px;line-height:24px;width:200px;overflow:hidden;padding-left:18px;color:#666;background: url(/images/icon_arrowB.gif) no-repeat 8px 9px;}

.space_info li a:link ,.space_info li a:visited{color:#2269D1; text-decoration:underline;}
.space_info li a:hover {color: #DE2C31; text-decoration: none;}

.space_t{height:26px;line-height:26px;background:#f7f7f7;text-align:left; background:url(/images/space_tbg.jpg) repeat-x;padding-left:20px;color:#333; font-size:14px;font-weight:bold;margin-bottom:5px;}
.space_books{border:1px solid #ddd;}
.space_booksdiv{padding:12px;margin-left:15px;overflow:hidden; height:1%; }
.space_tl{float:left;}
.space_more{float:right;padding-right:20px;font-size:12px;font-weight:normal;}
.space_txt{text-align:left;width:150px;margin:auto;line-height:160%;}

.space_null{height:45px;line-height:45px;color:#666;text-align:center;}

.user_l{float:left;}
.user_r{float:right;width:730px;text-align:left;}

.my_textbox{height:22px;line-height:22px;border-top:1px solid #444;border-left:1px solid #444;border-bottom:1px solid #ccc;border-right:1px solid #ccc;}
.comment{border:1px solid #DEEBFF;padding:3px;word-break:break-all;clear:both;margin-top:10px;}
.comment .head{height:28px;line-height:28px;padding:5px 10px;}
.comment .head .l{float:left;font-weight:bold;font-size:14px;}
.comment .head .r{float:right;}

.comment_list li{clear:both;margin-bottom:5px;}
.comment_list li .l{float:left;width:100px;height:80px;text-align:center;margin-top:5px;margin-left:10px;}
.comment_list li .r{float:right;width:555px;margin-right:15px;}

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
.comment_post .b{padding:11px;}
.comment_txt{border:1px solid #CECFCE;width:558px;border-top:1px solid #444;border-left:1px solid #444;border-bottom:1px solid #ccc;border-right:1px solid #ccc;color:#333;}
.photocontainer {width: 120px;margin-top: 10px;background: url("/img/bg_120.gif") no-repeat left top;padding: 7px 12px 12px 7px;}
<?php $this->end(); ?>
<div class="main_div">
<div class="space_title"><span><?php echo $user['User']['slug'] ?>的个人空间</span> <a class="urlCopied" href="/shufang/<?php echo $user['User']['uid'] ?>">http://<?php echo $_SERVER['HTTP_HOST'] ?>/shufang/<?php echo $user['User']['uid'] ?></a> [<a class="copyUrl" href="#">复制</a>]</div>
<div class="user_l">
  <div class="space_info">
  <div class="space_t">个人资料</div>
  <div class="space_infobox">
    <div class="photocontainer">
      <img src="<?php echo $user['User']['avatar'] ?>" width="120" alt="<?php echo $user['User']['slug'] ?>的头像">
    </div>
    <div class=""><?php echo $user['User']['slug'] ?></div>
  <div class="space_txt">
  上传书籍:<?php echo  $user['User']['uploads']?>本<br>
  书房金币:<?php echo $user['User']['credits'] ?>刀<br>
  书房人气:<?php echo $user['User']['incount'] ?>气<br>
</div></div>
</div>
 <div class="space_info">
 <div class="space_t">我的最新收藏</div>
 <?php if (empty($user['Collects'])): ?>
<ul> <div class="space_null">暂时还没有收藏</div></ul>
 <?php else: ?>
   <ul>
     <?php foreach ($user['Collects'] as $index => $book): ?>
       <?php $book = $this->Html->getPartBook($book['bid']); ?>
       <li><a href="/book/<?php echo $book['Book']['burl']; ?>" target="_blank"><?php echo $book['Book']['name']?></a> <?php echo $book['Book']['author'] ?></li> 
     <?php endforeach ?>
   </ul>   
 <?php endif ?>
</div>
</div>
<div class="user_r">
<div class="space_books">
<div class="space_t"><span class="space_tl">我上传的书籍</span><span class="space_more"><a href="/users/all/<?php echo $user['User']['uid'] ?>">查看全部</a></span></div>
<div class="space_booksdiv">
<div class="list_div">
<?php if (empty($user['Books'])): ?>
  <ul><div class="space_null">暂时还没有书籍</div></ul></div></div> 
<?php else: ?>
  <ul>
    <?php $i=0; ?>
    <?php foreach ($user['Books'] as $index => $book): ?>
      <?php if ($i < 16): ?>
        <?php $i++; ?>
        <?php else: ?>
        <?php break; ?>
      <?php endif ?>
      <li style="height:260px;width:125px; float:left"><div class="pic"><a href="<?php echo $this->Html->getPath($book['burl']); ?>" target="_blank">
      <img src="<?php echo $this->Html->getcover($book['fengmian_id']) ?>" class="list_img" width="102" height="120" alt="<?php echo $book['name'] ?> 简介：<?php echo mb_substr($book['decs'],0,20) ?>..."></a>
      <div class="dot"><a href="#" class="" title="加入收藏"></a></div></div>
      <div class="bookname"><a href="<?php echo $this->Html->getPath($book['burl']); ?>" target="_blank"><?php echo $book['name'] ?></a></div>
      <div class="txt">作者：<span><?php echo $book['author'] ?></span>
      <br>大小：<span class="num"><?php echo $this->Html->getTextSize($book['txt_id']); ?></span>
      <br>上传：<a href="/shufang/<?php echo $user['User']['uid'] ?>" target="_blank"><?php echo $user['User']['slug']; ?></a>
      </div></li>      
    <?php endforeach ?>
  </ul>
<?php endif ?>
</div>
<div>
    <div class="comment">
 <div class="head"><div class="l">网友留言(<span id="C_Num"><?php echo count($user['Spacereplies']) ?></span>)</div><div class="r"><a href="#" class="postReply">我要留言</a></div></div>
  <div class="comment_list" id="comment_list">
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
    <ul>
      <?php foreach ($spacereplies as $index  => $spacereply): ?>

        <?php if ($spacereply['Spacereply']['uid']==0): ?>
          <li><div class="l"><a href="#" target="_blank"><img width="66" height="66" src="/img/avatar.png"></a></div><div class="r"><div class="t"><a href="#" target="_blank">游客</a> 的留言 </div><div class="content"><?php echo nl2br($spacereply['Spacereply']['body']); ?><?php echo $spacereply['Spacereply']['created']?></span></div></div></li>
        <?php else: ?>
          <li><div class="l"><a href="/shufang/<?php echo $spacereply['Spacereply']['uid'] ?>" target="_blank"><img width="66" height="66" src="<?php echo $spacereply['User']['avatar'] ?>"></a></div><div class="r"><div class="t"><a href="/shufang/<?php echo $spacereply['Spacereply']['uid'] ?>" target="_blank"><?php echo $spacereply['User']['slug'] ?></a> 的留言 </div><div class="content"><?php echo nl2br($spacereply['Spacereply']['body']) ?><br><?php if ($spacereply['Spacereply']['reply'] != null): ?>
              <span style="color:red">[主人回复]:</span><br><?php echo nl2br($spacereply['Spacereply']['reply']) ?>
            <?php endif ?></div><div class="reply"><?php if ($user['User']['uid'] == $cur['User']['uid'] && $spacereply['Spacereply']['reply'] == null): ?>
              <a href="#" class="master_reply" data-slug="<?php echo $spacereply['User']['slug'] ?>" data-reply="<?php echo $spacereply['Spacereply']['rid']; ?>">回复</a>
            <?php endif ?><span><?php echo $spacereply['Spacereply']['created']?></span></div></div></li>
        <?php endif ?>
      <?php endforeach ?>
    </ul>
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
 </div>
 <form action="/shufang/post" method="post" accept-charset="utf-8">
    <div class="comment_post" id="comment_post">
      <div class="t comment_msg">写下我的留言</div>
      <div class="txt">
        <?php if ($user['User']['uid'] == $cur['User']['uid']): ?><input type="hidden" name="reply" value="0" id="reply_rid"><?php endif; ?>
        <input type="hidden" name="owner" value="<?php echo $user['User']['uid'] ?>" id="owner">
        <textarea name="body" rows="8" cols="20" id="comment_txt" class="comment_txt" ></textarea>
      </div>
      <div class="b" style="margin:auto;width:200px;"><input type="submit" name="comment_post" class="button3" value="发布评论"  ></div>
    </div>
 </form>
</div>

  </div>
  </div>
</div>

<script type="text/javascript" src="/js/jquery.zclip.min.js"></script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
    $('a.copyUrl').zclip({
        path:'/flash/ZeroClipboard.swf',
        copy:function(){return $('a.urlCopied').html();}
    });
    $( document ).on('click','a.postReply',function(){
      $('#comment_txt').focus();
      $('#reply_rid').val(0);
      $('.comment_msg').html('写下我的留言');
      return false;
    });
    <?php if ($user['User']['uid'] == $cur['User']['uid']): ?>
    $('a.master_reply').click(function() {
      var rid = $(this).attr('data-reply');
      var rname = $(this).attr('data-slug');
      $('#reply_rid').val(rid);
      $('.comment_msg').html('给 ' + rname + '留言<a href="#" class="postReply">我要留言</a>');
      return false;
    });
    <?php endif; ?>
});
</script>



