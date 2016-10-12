<style type="text/css" media="screen">
.main_div {
width: 960px;
margin: auto;
margin-bottom: 10px;
}
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
.list_t{height:30px;line-height:30px;border-bottom:#ddd 1px solid;margin-bottom:10px;font-size:14px;font-weight:bold;color:#333;}
.list_t li{float:left;width:80px;}
.list_t .n{font-weight:bold;}
.r_banner{height:600px;width:120px;}
.list_ts{height:30px;line-height:30px;border-bottom:#ddd 1px solid;margin-bottom:10px;font-size:14px;font-weight:bold;color:#333;}
.list_ts li{float:left;width:80px;}
.list_ts .n{font-weight:bold;}
.list_div{margin-left:5px;}
.list_img{height:135px;width:95px;border:1px solid #ddd;padding:2px;}
.list_div a:link {color:#2269D1; text-decoration:underline;}
.list_div a:visited{color:#666; text-decoration:underline;}
.list_div a:hover {color: #DE2C31; text-decoration: none;}
.list_div .txt{padding-top:5px;line-height:150%;white-space:nowrap;overflow:hidden;width:120px;}
.list_div .pic{position:relative;}
.list_div li{float:left;height:260px;width:125px;color:#555;padding-left:5px;}
.list_div .dot{position:absolute;left:80px;top:120px;width:16px;height:16px;}
.list_div .dot a,.list_div .dot a:visited{width:16px;height:16px;background:url(/images/f1.png) no-repeat;display:block;}
.list_div .dot a:hover{width:16px;height:16px;background:url(/images/f2.png) no-repeat;}
.list_div .txt span{color:#000;}

.page_nav{clear:both;height:28px;line-height:28px;text-align:center;font-size:14px;color:#949294;}
.page_nav .current{color:#000;font-weight:bold;margin: 0 4px;}
.page_nav .t{width:30px; padding:2px 0;border:1px solid #e1e1e1; position:relative;_position:static;top:2px\9;*top:3px;_top:3px;text-align:center;}
.page_nav button {background:url(/images/button.png) no-repeat}
.page_nav button{position:relative; top:2px;top:-1px\0;*top:3px;width:39px;height:22px; margin:0 0 0 5px; border:0 none;text-indent:-9999px;overflow:hidden;cursor:pointer;}
.fontk {
padding: 2px 4px;
border: 1px solid #BDDFEF;
margin: 0 4px;
text-align:center;
font-family: Verdana;
}
a.fontk:link ,a.fontk:visited{color:#2169D6;text-decoration: none;}
a.fontk:hover {text-decoration:underline;}
</style>
<div class="main_div">
    <div style="float: left;">
        <div class="main_l">
            <div>
                查看方式：
                <ul>
                    <li><a href="/<?php echo $type . ".html?s=0"; ?>"><span class="n">最近更新</span></a></li><li><a href="/<?php echo $type . ".html?s=1"; ?>">最多关注</a></li><li><a href="/<?php echo $type . ".html?s=2"; ?>">最多收藏</a></li><li><a href="/<?php echo $type . ".html?s=3"; ?>">最多下载</a></li>
                </ul>
            </div>
            <div>
                按分类查看：
                <ul>
                    <li><a href="/allbooks.html">全部</a></li>
                    <?php foreach ($NOVEL_TYPE as $index => $value): ?>
                      <li><a href="/<?php echo $index . ".html"; ?>"><?php echo $value; ?></a></li>  
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
        <div class="main_k">

        </div>
    </div>
    <div class="main_m">
        <div class="list_t">
            书籍列表  <?php echo $typename; ?> 最新书籍</div>
        <div class="list_div">
            <div>
            </div>
            <ul>
            <?php foreach ($books as $index => $book): ?>
              <?php $url = $this->Html->getPath($book['Book']['burl']); ?>
              <li style="height:260px;width:125px; float:left"><div class="pic"><a href="<?php echo $url; ?>" target="_blank">
              <img src="<?php echo $this->Html->getCoverByFengmian_id($book['Book']['fengmian_id'],$book['img']); ?>" class="list_img" alt="<?php echo mb_substr($book['Book']['decs'],0,100) . "..."; ?>"></a>
              <div class="dot"><a href="javascript:;" onclick="javascript:AddTo(<?php echo $book['Book']['bid'] ?>)" title="加入收藏"></a></div></div>
              <div class="bookname"><a href="<?php echo $url; ?>" target="_blank"><?php echo $book['Book']['name'] ?></a></div>
              <div class="txt">作者：<span><?php echo $book['Book']['author']; ?></span>
              <br>大小：<span class="num"><?php echo $this->Html->formatSize($book['txt']['size']); ?></span>
              <br>上传：<a href="/shufang/<?php echo $book['Book']['uid'] ?>" target="_blank"><?php echo $book['User']['slug'] ?></a>
              </div></li>
            <?php endforeach ?>
</ul><div class="page_nav"><span id="pager"><?php $pages =  $this->Paginator->counter(array(
	'format' => __('<span class="l">第{:page}页 共{:pages}页&nbsp;&nbsp;</span><span class="r">' . $this->Paginator->prev( __('上一页'), array(), null, array('class' => 'prev disabled')) . " " . $this->Paginator->numbers(array('separator' => ' ')) . " " . $this->Paginator->next(__('下一页'), array(), null, array('class' => 'next disabled')) )
	)); 
    $pages = str_replace('qingchun',$type,$pages);
    echo $pages;
   ?>
    </span></div>
        </div>
    </div>
</div>