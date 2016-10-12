<?php $this->start('rewrite_css'); ?>
.main_div{width:960px;margin:auto;margin-bottom:10px;}
.main_l{width:105px;text-align:left;font-size:14px;border: 1px solid #DEEBFF;padding:15px;}
.main_k{margin-bottom:5px;float:left;height: 600px; width: 135px;text-align:center;font-size:14px;border: 1px solid #DEEBFF;}
.main_l .n{font-weight:bold;}
.main_l li{height:24px;line-height:24px;}
.main_l a:link ,.main_l a:visited{color: #2169D6; text-decoration: none}
.main_l a:hover {color: #DE2C31; text-decoration: none;}
.main_m{float:left;width:810px;text-align:left;margin-left:10px;}
.main_m a:link ,.main_m a:visited{color:#2269D1; text-decoration:underline;}
.main_divs{width:960px;margin:auto;margin-bottom:10px;}
.main_ls{float:left;width:105px;text-align:left;font-size:14px;border: 1px solid #DEEBFF;padding:15px;}
.main_ls .n{font-weight:bold;}
.main_ls li{height:24px;line-height:24px;}
.main_ls a:link ,.main_l a:visited{color: #2169D6; text-decoration: none}
.main_ls a:hover {color: #DE2C31; text-decoration: none;}
.main_ms{float:left;width:680px;text-align:left;margin-left:10px;}
.main_ms a:link ,.main_ms a:visited{color:#2269D1; text-decoration:underline;}
.main_rs{float:right;width:120px;}
.r_banner{height:600px;width:120px;}
.list_ts{height:30px;line-height:30px;border-bottom:#ddd 1px solid;margin-bottom:10px;font-size:14px;font-weight:bold;color:#333;}
.list_ts li{float:left;width:80px;}
.list_ts .n{font-weight:bold;}
.main_r{float:right;width:120px;}
.r_banner{height:600px;width:120px;}
.list_img{height:135px;width:95px;border:1px solid #ddd;padding:2px;}
.search_t{font-size:16px;font-weight:bold;height:40px;line-height:40px;margin-top:10px;}
.search_t .word{color:#FF003A;}
.search_box{}
.search_box li{height:150px;width:665px;margin-left:10px;border-bottom:1px dashed #ddd;margin-top:5px;clear:both;}
.search_box .dot{position:absolute;left:80px;top:120px;width:16px;height:16px;}
.search_box .dot a,.search_box .dot a:visited{width:16px;height:16px;background:url(/images/f1.png) no-repeat;display:block;}
.search_box .dot a:hover{width:16px;height:16px;background:url(/images/f2.png) no-repeat;}
.search_box .txt{float:left;padding-top:5px;line-height:150%;width:470px;}
.search_box .t{font-weight:bold;font-size:14px;}
.search_box .pic{float:left;position:relative;width:150px;margin-left:20px;}
.search_box .c{color:#666;}

.search_null{line-height:200%;border-top:1px solid #DEDBDE;margin-top:15px;padding-top:20px;}
.search_null .t{font-size:14px;}
.search_null span{font-weight:bold;color:#FF0039;}

.search_hot{margin-top:20px;text-align:center;}
.search_hot li{float:left;width:130px;height:200px;line-height:200%;}
.search_nav{height:28px;background:#E7E7E7;margin-bottom:15px;padding-left:10px;}
.search_nav li{float:left;padding-left:10px;padding-right:10px;height:24px;line-height:24px; margin-left:5px;margin-top:5px; text-align:center;font-size:14px;}
.search_nav .n{font-weight:bold;background:#fff;}
.search_nav .n a:link ,.search_nav .n a:visited{color: #111; text-decoration: none;}
.search_nav .n a:hover {color: #111;text-decoration: none; }
.search_nav .page_nav{width:200px;margin:auto;clear:both;height:28px;line-height:28px;text-align:center;font-size:14px;color:#949294;}
.page_nav {text-align:center}
.selected {background-color: #ffff66;color: #000; font-weight: bold;}
.page_nav .current{color:#000;font-weight:bold;margin: 0 4px;}
.page_nav .t{width:30px; padding:2px 0;border:1px solid #e1e1e1; position:relative;_position:static;top:2px\9;*top:3px;_top:3px;text-align:center;}
.page_nav button {background:url(/images/button.png) no-repeat}
.page_nav button{position:relative; top:2px;top:-1px\0;*top:3px;width:39px;height:22px; margin:0 0 0 5px; border:0 none;text-indent:-9999px;overflow:hidden;cursor:pointer;}

<?php $this->end(); ?>
<div class="main_div">
  <div class="main_m">
  <?php if (!isset($this->request->query['q']) || $this->request->query['q'] == ""): ?>
  <div class="search_t">请输入关键词</div>      
  <?php else: ?>
	<div class="search_t">搜索<span class="word"><?php echo htmlspecialchars($this->request->query['q']);?></span>相关书籍</div>      
  <?php endif ?>  
  
  <?php if (empty($results) && (isset($this->request->query['q']) && $this->request->query['q'] != "")){ ?>
    <div id="divResults" style="text-align:left"><div class="search_null"><div class="t">抱歉，没有找到与  “<span><?php echo htmlspecialchars($this->request->query['q']);?></span>”  有关的书籍</div><br>建议您：<br> 1. 请缩短关键字长度<br>2. 多个关键字请用空格隔开<br>3. 检查输入的关键字，再试试看<br>4. 我来补充书籍，<a href="/upload" target="_blank">点击上传</a></div></div>
  <?php }else if(!empty($results) && (isset($this->request->query['q']) && $this->request->query['q'] != "")){ ?>
    <?php $order = array('0'=>'发布日期','1'=>'人气次数','2'=>'收藏次数','3'=>'下载次数') ?>
    <?php $sort = 0;
    if (isset($this->request->query['sort'])) {
      $sort = $this->request->query['sort'];
    }
     ?>
        <?php $Type = array('青春' , '言情','穿越','武侠','玄幻','文学','悬疑','都市','历史','经管'); ?>
    <div id="divResults" style="text-align:left"><div class="search_nav"><ul>
      <?php foreach ($order as $index => $name): ?>
        <li <?php if ($sort == $index): ?>class="n"<?php endif ?>><a href="/search?q=<?php echo htmlspecialchars($this->request->query['q']); ?>&sort=<?php echo $index; ?>"><?php echo $name; ?></a></li>
      <?php endforeach ?></ul></div><div class="search_box"><ul>
      <?php foreach ($results as $index => $book): ?>
      <?php $url = $this->Html->getPath($book['Book']['burl']); ?>
      <?php $cover = $this->Html->getCoverByFengmian_id($book['Book']['fengmian_id'],$book['img']); ?>
      <?php $bid = $book['Book']['bid'] ?>
      <?php $name = $book['Book']['name'] ?>
      <?php $author = $book['Book']['author'] ?>
      <?php $type = $Type[$book['Book']['type']] ?>
      <?php $size = $this->Html->formatSize($book['txt']['size']) ?>
      <?php $uid = $book['User']['uid'] ?>
      <?php $slug = $book['User']['slug'] ?>
      <?php $desc = mb_substr($book['Book']['decs'],0,250); ?>
    <?php
    // $terms_html = $this->Html->search_html_escape_terms($terms);
    $data = <<<END
    <li><div class="pic"><a href="{$url}" target="_blank"><img src="{$cover}" class="list_img" ></a><div class="dot"><a href="javascript:;" onclick="javascript:AddTo({$bid})" title="加入收藏"></a></div></div><div class="txt"><span class="t"><a href="{$url}" target="_blank"><div>{$name}</div></a></span><div>作者：{$author} 类别：{$type} 大小：<span class="num">{$size}</span> 上传：<a href="/shufang/{$uid}" target="_blank">{$slug}</a></div><div class="c">{$desc}</div></div></li>
END;
    // debug($data);
    $data = $this->Html->search_highlight($data, $terms);
    // debug($terms_rx);
?>
    <?php echo $data; ?>
       
    <?php endforeach ?>
  </ul><div class="page_nav"><span id="pager">
  	<?php
  	echo $this->Paginator->counter(array(
  	'format' => __('第{:page}页 共{:pages}页')
  	));
  		echo $this->Paginator->prev(  __('上一页 '), array(), null, array('class' => 'prev disabled'));
  		echo $this->Paginator->numbers(array('separator' => ' '));
  		echo $this->Paginator->next(__(' 下一页') , array(), null, array('class' => 'next disabled'));
  	?>
  </span></div></div></div>
  <?php } ?>
 
 </div>
  <div class="main_r">
     <div class="r_banner">

     </div>
  </div>
</div>
