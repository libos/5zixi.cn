<style type="text/css" media="screen">
ol, ul {list-style: none;}blockquote, q {quotes:none;}blockquote:before, blockquote:after, q:before, q:after {content: '';content: none;}:focus {outline: 0;}ins {text-decoration: none;}del {text-decoration: line-through;}table {border-collapse: collapse;border-spacing: 0;}

a:link, a:visited, strong {color:#e15d46;}
a:hover {text-decoration:none;}
h1 {font-size:6em;font-family: 'Engagement', cursive;line-height:1.89em;text-shadow:1px 1px 0px #fff, 2px 2px 0px rgba(0, 0, 0, 0.1), 3px 3px 0px #fff, 4px 4px 0px rgba(0, 0, 0, 0.1), 5px 5px 0px #fff;}
.left {float:left;}
.right {float:right;}
form {width:560px;margin:0px auto;text-align:left;}
p {padding:23px 0px;border-top:1px dotted #c7c7c7;}
li {padding:26px 0px;border-top:1px dotted #c7c7c7;min-height:27px;}

label {
	float:left;
	width:180px;
}
input, 
select, 
textarea, 
button {
	background:#fff;
	font-size:1em;
	font-family:"HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-weight:300;
	color:#8c8a8b;
}

input[type=text], 
input[type=password], 
input[type=email], 
textarea {
	border:1px solid #c7c7c7;
	outline:5px solid rgba(0, 0, 0, 0.1);
	padding:3px 5px;
}

input[type=text]:focus, 
input[type=text]:active, 
textarea:active, 
textarea:focus {
	outline:5px solid rgba(0, 0, 0, 0.2);
}

textarea {
	height:174px;
}

button {
	background: #f2f2f2; /* Old browsers */
	background: -moz-linear-gradient(top, #f2f2f2 0%, #e8e8e8 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f2f2f2), color-stop(100%,#e8e8e8)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, #f2f2f2 0%,#e8e8e8 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, #f2f2f2 0%,#e8e8e8 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, #f2f2f2 0%,#e8e8e8 100%); /* IE10+ */
	background: linear-gradient(top, #f2f2f2 0%,#e8e8e8 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f2f2f2', endColorstr='#e8e8e8',GradientType=0 ); /* IE6-9 */
	-webkit-box-shadow: inset 0px 1px 0px 0px rgba(255, 255, 255, 1);
	-moz-box-shadow: inset 0px 1px 0px 0px rgba(255, 255, 255, 1);
	box-shadow: inset 0px 1px 0px 0px rgba(255, 255, 255, 1); 
	border-color: #eeeced #eeeced #9b9b9b;
    border-style: solid;
    border-width: 1px;
	-webkit-border-radius: 20px;
	-moz-border-radius: 20px;
	border-radius: 20px;
	padding:5px 30px;
	font-weight:bold;
	text-shadow:0px 1px 0px #fff;
	cursor:pointer;
}

button:hover {
	background:#f5f5f5;
}

button:focus, 
button:active {
	background:#e8e8e8;
}

button.action {
	background: #fa765f; /* Old browsers */
	background: -moz-linear-gradient(top, #fa765f 0%, #e15d46 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fa765f), color-stop(100%,#e15d46)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, #fa765f 0%,#e15d46 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, #fa765f 0%,#e15d46 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, #fa765f 0%,#e15d46 100%); /* IE10+ */
	background: linear-gradient(top, #fa765f 0%,#e15d46 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fa765f', endColorstr='#e15d46',GradientType=0 ); /* IE6-9 */
	-webkit-box-shadow: inset 0px 1px 0px 0px rgba(255, 179, 166, 1);
	-moz-box-shadow: inset 0px 1px 0px 0px rgba(255, 179, 166, 1);
	box-shadow: inset 0px 1px 0px 0px rgba(255, 179, 166, 1); 
	border-color: #fc7f6b #fc7f6b #d0432f;
	color:#b13e2d;
	text-shadow:0px 1px 0px #ffb3a5;
}

button.action:hover {
	background:#fa765f;
}

button.action:focus, 
button.action:active {
	background:#e15d46;
}

</style>

<form action="/feedback" method="post" accept-charset="utf-8">
	<ul>
        <li>
            <label for="email">邮箱</label><input type="email" required size="50" name="email" value="<?php if (isset($this->request->query['email'])): ?><?php echo htmlspecialchars(trim($this->request->query['email'])); ?><?php endif ?>" id="email">
        </li>
        <li>
          <label for="body">内容</label><textarea  name="body" required cols="50" rows="5" value="<?php if (isset($this->request->query['body'])): ?><?php echo htmlspecialchars(trim($this->request->query['body'])); ?><?php endif ?>" id="body"><?php if (isset($this->request->query['body'])): ?><?php echo htmlspecialchars(trim($this->request->query['body'])); ?><?php endif ?></textarea>
        </li>
        <li>
          <label for="captcha">验证码</label><input type="text" size="20" required name="captcha" value=""><img src="/img/captcha.jpg" title="看不清楚，点击换一张" onclick="this.src=this.src+'?'"  style="margin-left:20px;margin-bottom:-8px"   alt="看不清楚点击刷新">
        </li>
  </ul>

  <p style="text-align:center"><button type="submit" class="action" >提交</button></p>
</form>
