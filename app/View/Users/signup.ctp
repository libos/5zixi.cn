
<form name="form" method="post" action="/register"   id="registerForm">
    <div class="reg_l">
        <div id="ob_reg">
            <div class="reg_title">
                新用户注册</div>
            <div class="reg_txt">
                我自习需要注册才能更好地为您服务，请相信，它值得您花30秒注册一个帐号。:)
            </div>
            <ul>
                <li class="r_left">
                    <label for="uname">
                      <img class="okimg" id="d_uname_img" src="">您的用户名：
                    </label>
                </li>
                <li class="r_right">
                    <input name="slug" type="text" value="" class="slug reg_textbox" id="slug"  onblur="out_uname();" onfocus="on_input('d_uname');"  size="30" maxlength="30">
                </li>
                <li class="r_msg">
                    <div class="d_default" id="d_uname">请输入4-14位字符，英文、数字的组合。</div>
                </li>
            </ul>
            <ul>
                <li class="r_left">
                    <label for="upwd">
                        <img class="okimg" id="d_upwd1_img" src="">输入登录密码：
                    </label>
                </li>
                <li class="r_right">
                   <input name="password" type="password" id="password" value="" maxlength="12" class="reg_textbox" onblur="out_upwd1();" onfocus="on_input('d_upwd1');" size="30">
                </li>
                <li class="r_msg">
                    <div class="d_default" id="d_upwd1">请输入6位以上字符，不允许空格。</div>
                </li>
            </ul>
            <ul>
                <li class="r_left">
                    <label for="repassword">
                        <img class="okimg" id="d_upwd2_img" src="">登录密码确认：
                    </label>
                </li>
                <li class="r_right">
                    <input id="password_confirm" onblur="out_upwd2();" onfocus="on_input('d_upwd2');" type="password" maxlength="20" size="30" name="password_confirm" class="reg_textbox">
                </li>
                <li class="r_msg">
                    <div class="d_default" id="d_upwd2">请重复输入上面的密码。</div>
                </li>
            </ul>
            <ul>
                <li class="r_left">选择性别： </li>
                <li class="r_right">
                  <label style="display:block;margin-bottom:5px;line-height:20px">
                    <input type="radio" name="sex" id="UserSexM" value="M" checked style="margin-top:4px;margin-right:3px" >先生
                  </label>
                  <label style="display:inline;margin-bottom:5px;line-height:20px">
                    <input type="radio" name="sex" id="UserSexF" value="F" style="margin-top:4px;margin-right:3px">女士
                  </label>
                </li>
            </ul>
            <ul>
                <li class="r_left">
                    <label for="email">
                        <img class="okimg" id="d_email_img" src="">电子邮箱：
                    </label>
                </li>
                <li class="r_right">
                    <input id="email" onblur="out_email();" onfocus="on_input('d_email');" maxlength="32" size="30" name="email" class="reg_textbox">
                </li>
                <li class="r_msg">
                    <div class="d_email" id="d_email">请输入您常用的电子邮箱地址。</div>
                </li>
            </ul>
            <ul>
                <li class="r_left">
                    <label for="code">
                        <img class="okimg" id="d_code_img" src="">输入验证码：</label>
                </li>
                <li class="r_right">
                    <input id="code" onblur="out_code();" onfocus="on_input('d_code');" maxlength="4" size="10" name="captcha" class="reg_textbox">
                    <img src="/img/captcha.jpg" title="看不清楚，点击换一张" onclick="this.src=this.src+'?'"  style="margin-top:-4px"valign="middle" alt="看不清楚点击刷新">
                </li>
                <li class="r_msg">
                    <div class="d_code" id="d_code">请输入提示的验证码</div>
                </li>
            </ul>
            <ul>
                <li class="r_left">
                    <label for="agree">
                        <img class="okimg" id="d_agree_img" src=""></label>
                </li>
                <li class="r_right">
                    <input type="checkbox" name="agreebox" id="agreebox" value="checkbox" checked="checked" tabindex="17">&nbsp;<a href="/contract" target="_blank">我已经阅读并同意注册协议</a></li>
                <li class="r_msg">
                    <div class="d_agree" id="d_agree">必须同意注册协议才能注册。</div>
                </li>
            </ul>
            <ul>
                <li class="r_left"></li>
                <li>
                    <input id="regbotton" onclick="chk_reg();" class="button3" type="button" value="提交注册信息" name="submit"><span id="save_stat"></span> </li>
            </ul>
        </div>
        
        <div id="regSuc" style="display: none;">
            <div class="Login_Title" style="color: #DC143C;">
                注册成功！</div>
            <div style="line-height: 24px; height: 24px; color: #666666;">
                请选择要跳转的页面</div>
            <div style="line-height: 25px; height: 25px;">
                1.<a href="/"><u>返回首页</u></a></div>
            <div style="line-height: 25px; height: 25px;">
                <!-- 2.<a href="/home"><u>进入我的书房</u></a></div> -->
        </div>
    </div>
    
    <div class="reg_r">
        <div class="reg_intro">
            <a href="/signin">已注册请登录</a>，注册后您可以<br>
            <br>
            <span class="t1">分享书籍</span><br>
            <span class="t2">独乐乐不如众乐乐，和朋友一起分享你的书籍！</span><br>
            <span class="t1">阅读书籍</span><br>
            <span class="t2">汇聚海量书籍，在线免费观看，支持书籍收藏、浏览书签等功能！</span><br>
            <span class="t1">下载书籍</span><br>
            <span class="t2">支持TXT格式全文下载！</span><br>
            <span class="t1">我的空间</span><br>
            <span class="t2">个性的私人空间，好友汇聚一堂！</span>
        </div>
    </div>

  
  </form> 
  <script src="/js/ajax.js" charset="utf-8"></script>  
  <script src="/js/reg.js" charset="utf-8"></script>