<style type="text/css" media="screen">
.fav_menu1{height:25px;line-height:25px;background:#F7F7F7 ;border-bottom:1px dashed #dedede;color:#666;}
.fav_menu1 .td1{float:left;width:90px;text-align:center}
.fav_menu1 .td2{float:left;width:290px;}
.fav_menu1 .td3{float:left;width:120px;}
.fav_menu1 .td4{float:left;width:240px;text-align:center}

.fav_line1{height:25px;line-height:25px;border-bottom:1px dashed #dedede;text-align:center;color:#999;}
.fav_line1 .td1{float:left;width:90px;}
.fav_line1 .td2{float:left;width:290px;text-align:left;}
.fav_line1 .td3{float:left;width:120px;text-align:left;}
.fav_line1 .td4{float:left;width:240px;}
.fav_line1 a:link ,.fav_line1 a:visited{color: #2269D1; text-decoration:underline;}
.fav_line1 a:hover {color: #DB2C30; text-decoration:none;}
</style>
<?php echo $this->element('myshufang'); ?>

<div class="uc_r">
   <div class="uc_t">我的书签</div>
<div class="fav_menu1">
<div class="td1">类别</div><div class="td2">书名(作者)</div><div class="td3">书签日期</div><div class="td4">操作</div></div>
       <div class="fav_line1">您还没有任何书签！</div>        
      </div>