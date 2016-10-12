<?php echo $this->element('myshufang'); ?>

<div class="uc_r">
        <div class="uc_t">您的书房</div>
      <div class="uc_info">
        <div class="uc_index">
          <div class="l"><div class="photocontainer"><img width="120" src="<?php echo $cur['User']['avatar'] ?>"></div><a href="/home/avatar">上传头像</a></div>
          <div class="r"><ul><li>用户名:<b><?php echo $cur['User']['slug'] ?></b> (<a href="/shufang/<?php echo $cur['User']['uid'] ?>" target="_blank">浏览我的个人页</a>)</li>
    <li>UID:<?php echo $cur['User']['uid'] ?></li>
    <li>上传书籍：<?php echo $cur['User']['uploads'] ?> 本</li>
    <li>会员等级：<a href="/help#class" target="_blank"><?php echo $cur['User']['class_id'] ?>级 - <?php echo $class[$cur['User']['class_id']] ?></a></li>
    <li>书房金币：<?php echo $cur['User']['credits'] ?> 刀 <a href="/help#score" target="_blank">积分规则</a></li>
    <li>注册时间：<?php echo $cur['User']['created'] ?></li></ul></div>
        </div>
      </div>    
</div>