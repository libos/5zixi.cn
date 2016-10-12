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

.users_div{}
.users_div a:link ,.users_div a:visited{color:#2269D1; text-decoration:underline;}
.users_div a:hover {color: #DE2C31; text-decoration: none;}
.users_div .txt{padding-top:5px;line-height:150%;}
.users_div .pic{position:relative;}
.users_div li{float:left;height:190px;width:122px;color:#555;margin-left:10px;}
.users_div .txt span{color:#000;}

.userface_s{border:1px solid #EFEFEF;padding:3px; width:58px; height:58px;}

.uc_new{margin:0 40px;border-top:1px #ccc dashed;padding:10px;padding-left:20px;color:#444;}
.uc_new li{height:24px;line-height:24px;}
.uc_new li span{color:#888;}
</style>
<div class="main_div">
<div class="main_ls">
<div>
查看方式：
<ul>
<li><a href="users.html?s=0"><span class="n">贡献最多</span></a></li><li><a href="users.html?s=1">最新注册</a></li><li><a href="users.html?s=2">等级最高</a></li><li><a href="users.html?s=3">积分最高</a></li>
</ul>
</div>
</div>
<div class="main_ms">
  <?php $sex = array('M'=>'男','F'=>'女'); ?>
<div class="list_ts">会员列表</div>
  <div class="users_div"><ul>
<?php foreach ($users as $index => $user): ?>
  <li><div class="pic"><a href="/shufang/<?php echo $user['User']['uid'] ?>">
  <img src="<?php echo $user['User']['avatar'] ?>" class="userface_s"></a></div>
  <div class="txt"><b><a href="/space/<?php echo $user['User']['uid'] ?>"><?php echo $user['User']['slug']; ?></a></b><br>
  [<?php echo $class[$user['User']['class_id']]; ?>]<br>
  性别：<span><?php echo $sex[$user['User']['sex']]; ?></span><br>书籍：<span><?php echo $user['User']['uploads'] ?>本</span><br>
  积分：<span><?php echo $user['User']['credits']; ?></span></div></li>  
<?php endforeach ?>    


</ul><div class="page_nav"><span id="pager"><?php $pages =  $this->Paginator->counter(array(
	'format' => __('<span class="l">第{:page}页 共{:pages}页&nbsp;&nbsp;</span><span class="r">' . $this->Paginator->prev( __('上一页'), array(), null, array('class' => 'prev disabled')) . " " . $this->Paginator->numbers(array('separator' => ' ')) . " " . $this->Paginator->next(__('下一页'), array(), null, array('class' => 'next disabled')) )
	));
  echo $pages; 
  ?></span></div>
  </div></div>


</div>