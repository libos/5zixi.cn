<style type="text/css" media="screen">
.index_r {
float: right;
width: 324px;
}
.post{
  float:left;
  width:590px;
  border: 1px solid red;
}
.index_login {
border: 1px solid red;
padding: 10px;
padding-left: 25px;
}
.i_loginline {
height: 34px;
line-height: 34px;
}
.index_login a, .index_login a:visited {
color: #2269D1;
text-decoration: underline;
}
.index_login .r {
float: left;
text-align: center;
margin-left: 10px;
width: 206px;
}
.index_login .l {
float: left;
margin-top: 2px;
width: 70px;
}
.index_login .r li {
float: left;
width: 90px;
height: 26px;
line-height: 26px;
border: 1px solid #A5D3F7;
margin: 3px 5px;
}
.userface_s {
border: 1px solid #EFEFEF;
padding: 3px;
width: 58px;
height: 58px;
}
.index_login .div {
height: 84px;
}
.index_log {
margin-top: 8px;
padding: 8px;
border: 1px solid #E5E5E5;
}
.index_rt {
font-weight: bold;
height: 24px;
line-height: 24px;
font-size: 14px;
}
.gray2 {
color: #909090;
}
.index_log a:link, .index_log a:visited {
color: #2269D1;
text-decoration: underline;
}
</style>
<?php
App::uses('Debugger', 'Utility');
?>
<?php $i=0; ?>
  <div class="post">
    <h1 class="float-left">最新热门书籍</h1>
    <div class="float-right">[<a href="/hotbooks">查看更多热门书籍</a>]</div>
  <table>                   
  <tbody>
      <?php include $path; ?>
  </tbody></table>
  
  </div>
  
  <div class="index_r">
    
      <div class="index_login">
        <?php if (!$islogin): ?>
          <div id="i_login" style="display: block;">
              <div class="t">
                   加入<span>我自习</span></div>
              <div class="i_loginline">
                  用户名：<input type="text" name="slug" id="login_slug" class="my_textbox" style="width: 150px;" onkeydown="keyEnter13('EnterOper',event)">　<input type="button" value="立即登录" id="EnterOper" name="EnterOper" onclick="homepageuserlogin()" class="button3"></div>
              <div class="i_loginline">
                  密　码：<input name="password" id="login_password"  type="password" class="my_textbox" style="width: 150px;" onkeydown="keyEnter13('EnterOper',event)">　<input type="checkbox" id="expires" name="Login_Exp" value="1" checked="checked">记住我</div>
              <a href="/signup">快速注册</a> <span id="Login_Text" style="color:red"></span>
          </div> 
        <?php else: ?>
          <div id="i_loginsuc">
            <div id="i_loginsuc" style="display: block;"><div class="div"><div class="t">Hi！<b><?php echo $cur['User']['slug'] ?></b> [<a href="/logout">退出</a>]</div><div class="l"><a href="/home"><img width="66" src="<?php echo $cur['User']['avatar'] ?>" class="userface_s"></a></div><div class="r"><ul><li><a href="/home" target="_blank">我的书包</a></li><li><a href="/shufang/<?php echo $cur['User']['uid'] ?>" target="_blank">我的首页</a></li><li><a href="/home/favorite" target="_blank">我的藏书</a></li><li><a href="/home/bookmark" target="_blank">我的书签</a></li></ul></div></div></div>
          </div>
        <?php endif ?>
      </div>
      <div style="clear:both"></div>
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
      <div class="index_log">
          <div class="index_rt">
              最新上传</div>
          <ul>
            <?php foreach ($latest as $index => $book): ?>
              <li><div class="l"><span class="gray2 timeago" title="<?php echo $book['Book']['created'] ?>"><?php echo $book['Book']['created'] ?></span> <a href="/shufang/<?php $book['User']['uid'] ?>"><?php echo $book['User']['slug'] ?></a> 上传了 <a href="/search/q_<?php echo $book['Book']['author'] ?>" target="_blank"><?php echo $book['Book']['author'] ?></a> 的《<a href="/book/<?php echo $book['Book']['burl'] ?>.html" target="_blank" title="<?php echo $book['Book']['name']; ?>"><?php echo $book['Book']['name']; ?></a>》</div></li>
            <?php endforeach ?>
              
            </ul>
      </div>
     
     
  </div>
    <script src="/js/md5.js" charset="utf-8"></script>  
    <script src="/js/ajax.js" charset="utf-8"></script>
    <script src="/js/jquery.timeago.js" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
      $('span.timeago.gray2').timeago();      
    });
    </script>
