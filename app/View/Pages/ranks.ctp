<?php $this->start('rewrite_css'); ?>
.main_div{width:960px;margin:auto;margin-bottom:10px;}
.topten .l{float:left;height:480px;margin:5px; width:306px;border:1px solid #ddd;}
.topten .t{height:28px;line-height:28px;background:#f7f7f7;font-weight:bold;text-align: center;}
.topten_box li{text-align:left;height:22px;line-height:22px;padding-left:10px;color:#DE1439;width:290;overflow:hidden;}
.topten_box li span{font-size:11px;color:#999;}
<?php $this->end(); ?>
<div class="main_div">
    <div class="topten">
        <div class="l">
            <div class="t">
                人气总排行</div>
            <div class="topten_box">
                <ul>
                  <?php foreach ($clicks as $index => $book): ?>
                    <li><b><?php echo $index ?></b>. <a href="<?php echo $this->Html->getPath($book['Book']['burl']) ?>" target="_blank"><?php echo $book['Book']['name'] ?></a> <span>(<?php echo $book['Book']['author'] ?>)</span></li>                    
                  <?php endforeach ?>
                </ul>
            </div>
        </div>
        <div class="l">
            <div class="t">
                下载总排行</div>
            <div class="topten_box">
                <ul>
                  <?php foreach ($downloads as $index => $book): ?>
                    <li><b><?php echo $index ?></b>. <a href="<?php echo $this->Html->getPath($book['Book']['burl']) ?>" target="_blank"><?php echo $book['Book']['name'] ?></a> <span>(<?php echo $book['Book']['author'] ?>)</span></li>                    
                  <?php endforeach ?>
                </ul>
            </div>
        </div>
        <div class="l">
            <div class="t">
                收藏总排行</div>
            <div class="topten_box">
                <ul>
                  <?php foreach ($collects as $index => $book): ?>
                    <li><b><?php echo $index ?></b>. <a href="<?php echo $this->Html->getPath($book['Book']['burl']) ?>" target="_blank"><?php echo $book['Book']['name'] ?></a> <span>(<?php echo $book['Book']['author'] ?>)</span></li>                    
                  <?php endforeach ?>
                </ul>
            </div>
        </div>
    </div>
</div>