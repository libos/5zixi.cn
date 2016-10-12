<?php echo $this->element('myshufang'); ?>
<div class="uc_r">
     
   <div class="uc_t">修改用户密码</div>
    <div class="uc_modify">
   <div class="modify_title">我的用户名：<strong><?php echo $cur['User']['slug'] ?></strong></div>
   <div class="modify_title">旧密码：
     <span class="msg" style="color:Red;display:none;">不能为空！</span>
   </div>
   <div class="modify_textbox">
     <input name="OldPwd" type="password" id="OldPwd" class="my_textbox" style="width:230px;"> 请输入您的旧密码
   </div>
   <div class="modify_title">新密码：
     <span class="msg" style="color:Red;display:none;">不能为空！</span>
   </div>
   <div class="modify_textbox"><input name="NewPwd" type="password" id="NewPwd" class="my_textbox" style="width:230px;"> 请输入您的新密码,6-16个字符,可用英文字母、数字或符号</div>
   <div class="modify_title">确认新密码：  <span class="msg" style="color:Red;display:none;">不能为空！</span></div>
   <div class="modify_textbox"><input name="RePwd" type="password" id="RePwd" class="my_textbox" style="width:230px;"> 请确认您的新密码</div>
<br>
    <span id="PassWord"></span>
        <input type="submit" name="Edit" value="确认无误，立即修改" id="Edit" class="button3 ManagerButton">
		</div>
</div>


<script src="/js/md5.js" charset="utf-8"></script>  
<script type="text/javascript" charset="utf-8">
 $(document).ready(function () {
   $('input').change(function(){
     var val = $(this).val();
     if (val == "") {
       $(this).parent().prev().find('.msg').html("不能为空！").show();
     }else
     {
       $(this).parent().prev().find('.msg').hide();
     }
   });
   
   $('#NewPwd,#RePwd').change(function(){
     var np = $('#NewPwd').val();
     var rp = $('#RePwd').val();
     if (np != rp && rp!="") {
       $(this).parent().prev().find('.msg').html("两者密码不一致").show();
     }
     else
     {
       $(this).parent().prev().find('.msg').html("两者密码不一致").hide();
     }
   });
   
   $('.ManagerButton').click(function() {
     var chk = true;
     var ol = $('#OldPwd').val();
     var np = $('#NewPwd').val();
     var rp = $('#RePwd').val();
     
     chk = ol == "" ? false : chk;
     chk = np == "" ? false : chk;
     chk = rp == "" ? false :  chk;
     chk = np == rp ? chk :false;
     if (chk) {
       $(this).attr('disabled','disabled');
       $.ajax({
         url:'/users/change',
         type:'post',
         dataType:'text',
         data:{'ac':"changepassword",'old':md5(ol),'new':np},
         success:function(txt){
           if (txt == "ok") {
             alert("修改密码成功，请重新登录！");
             parent.location = '/signin';
             $(this).attr('disabled',false);
           }
           else
           {
             $('#OldPwd').parent().prev().find('.msg').html('密码不正确或新密码不合格').show();  
           }
         },
         error:function(){
         
         }
       });       
     }
   });
 });
</script>