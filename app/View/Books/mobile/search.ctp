<div class="t3"><table><tbody><tr><td><a href="/" >首页</a></td><td><a href="/listA0B0P1.html" id="A0">青春</a></td><td><a href="/listA1B0P1.html" id="A1">言情</a></td><td><a href="/listA2B0P1.html" id="A2">穿越</a></td><td><a href="/listA3B0P1.html" id="A3">武侠</a></td></tr><tr><td><a href="/listA4B0P1.html" id="A4">玄幻</a></td><td><a href="/listA5B0P1.html" id="A5">文学</a></td><td><a href="/listA6B0P1.html" id="A6">悬疑</a></td><td><a href="/listA7B0P1.html" id="A7">都市</a></td><td><a href="/listA8B0P1.html" id="A8">历史</a></td></tr><tr><td><a href="/listA9B0P1.html" id="A9">经管</a></td><td><a href="/hotplusP1.html" id="c_11">热门</a></td><td><a href="/newestP1.html" id="c_12">最新</a></td><td><a href="/allbooksP1.html">书房</a></td><td><a href="/rank.html">排行</a></td></tr></tbody></table></div>
<form class="index_search" action="/search" method="get"><table class="t5"><tbody><tr><td width="80%"><input name="q" id="kw" class="inpt" onclick="javascript:{if (this.value == '请输入关键字') this.value=''; };" value="请输入关键字"></td><td width="20%"><input type="submit" class="inpb" value="搜索"></td></tr></tbody></table></form>


<div style="padding:3px"></div>


<table class="title">
        <tbody>
            <tr>
                <td class="w12">
                </td>
                <td>
                    关键词：<label class="fgreen"> <?php if (!isset($this->request->query['q']) || $this->request->query['q'] == ""): ?>请输入关键词<?php else: ?><?php echo htmlspecialchars($this->request->query['q']);?><?php endif ?></label>
                </td>
                <td class="w12">
                </td>
            </tr>
        </tbody>
</table>

 
  
  <?php if (empty($results) && (isset($this->request->query['q']) && $this->request->query['q'] != "")){ ?>
   <div class="search_null"><div class="t">抱歉，没有找到与  “<span><?php echo htmlspecialchars($this->request->query['q']);?></span>”  有关的书籍</div><br>建议您：<br> 1. 请缩短关键字长度<br>2. 多个关键字请用空格隔开<br>3. 检查输入的关键字，再试试看<br></div>
  <?php }else if(!empty($results) && (isset($this->request->query['q']) && $this->request->query['q'] != "")){ ?>
      <?php $Type = array('青春' , '言情','穿越','武侠','玄幻','文学','悬疑','都市','历史','经管'); ?>
  <ul class="lists"> 
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
    <li class="li_bg"><a href="{$url}">
               <p>{$name}</p>
               <p class="intro">
                  {$desc}....</p>
               <p class="intro fgreen">
                   作者：{$author} 大小：{$size}  类别：{$type}</p>
    </a></li> 
END;
    // debug($data);
    $data = $this->Html->search_highlight($data, $terms);
    // debug($terms_rx);
?>
    <?php echo $data; ?>

    <?php endforeach ?>
  </ul>
  <div class="pager small bg1 pd12"><span class="count">  	<?php
    	echo $this->Paginator->counter(array(
    	'format' => __('第{:page}页 共{:pages}页')
    	));
    		echo $this->Paginator->prev(  __('上一页 '), array(), null, array('class' => 'prev disabled'));
    		echo $this->Paginator->numbers(array('separator' => ' '));
    		echo $this->Paginator->next(__(' 下一页') , array(), null, array('class' => 'next disabled'));
    	?></span></div>  
  
  <?php } ?>
  
  




<div style="padding:3px"></div>
