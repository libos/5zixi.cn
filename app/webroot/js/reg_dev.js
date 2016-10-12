var msg;
var li_ok = '/img/li_ok.png';
var li_err = '/img/li_err.gif'

function sl(st) {
    sl1 = st.length;
    strLen = 0;
    for (i = 0; i < sl1; i++) {
        if (st.charCodeAt(i) > 255) strLen += 2;
        else strLen++;
    }
    return strLen;
}

var msg = new Array(
"请输入4-14位字符，英文、数字的组合。",
"请输入4-14位字符，英文、数字的组合。",
"请输入6位以上字符，不允许空格。",
"请重复输入上面的密码。",
"请选择密码提示问题。",
"请输入提示的验证码",
"请输入您常用的电子邮箱地址。",
"必须同意注册协议才能注册。"
)

function CheckUser() {
    var chk = true
    if (chk) {
        var obj = document.getElementById("d_uname");
        var uName = document.getElementById("slug").value;
        var dataStr = {"action": "checkSlug", "slug": uName };
        $.ajax({
            type: "post",
            url: "/ajax_validate",
            dataType: "text",
            data: dataStr,
            success: function (result) {
                 if (result == "OK") {
                    obj.className = "d_ok";
                    obj.innerHTML = '用户名可以使用。';
                    document.getElementById("d_uname_img").src = li_ok;
                }
                else {
                    obj.className = "d_err";
                    obj.innerHTML = "该用户已存在。";
                    document.getElementById("d_uname_img").src = li_err;
                }
            },
            error: function () {
                alert("数据提交失败，请检查网络或重试。");
            }
        });
    }
    return chk;
}


function chk_reg() {
    var chk = true
    if (!out_uname()) { chk = false }
    if (!out_upwd1()) { chk = false }
    if (!out_upwd2()) { chk = false }
    if (!out_email()) { chk = false }
    if (!out_code()) { chk = false }
    if (!out_agree()) { chk = false }
    if (chk) {

        var uName = document.getElementById("slug").value;
        var uPass = document.getElementById("password").value;
        var uEmail = document.getElementById("email").value;
        var uSex = "0";
        var uCode = document.getElementById("code").value;
        var a = document.getElementsByName("sex");
        for (var i = 0; i < a.length; i++) {
            if (a[i].checked) {
                uSex = a[i].value;
            } 
        }
        var dataStr = { "action": "UserAdd", "code": uCode ,"slug":  escape(uName), "password": uPass, "email": uEmail, "sex": uSex };
        $.ajax({
            type: "post",
            url: "/register",
            dataType: "text",
            data: dataStr,
            success: function (result) {
                 if (result == "OK") {
                    document.getElementById("ob_reg").style.display = "none";
                    document.getElementById("regSuc").style.display = "block"; ;
                    cookieCheck();
                    document.getElementById("Login").style.display = "none";
                }
                else {
                     alert("用户名含有禁止字符！");
                }
                 document.getElementById('regbotton').disabled = false;
            },
            error: function () {
                alert("数据提交失败，请检查网络或重试。");
            }
         });
         return;
    }
}

function out_uname() {
    var obj = document.getElementById("d_uname");
    var str = document.getElementById("slug").value;
    var str2 = sl(str);
    var chk = true;
    if (str2 < 4 || str2 > 14) { chk = false }
    if (chk) {
        CheckUser();
    } else {
        obj.className = "d_err";
        obj.innerHTML = msg[0];
        document.getElementById("d_uname_img").src = li_err;
    }
    return chk;
}
function out_email() {
    var obj =document.getElementById("d_email");
    var str = document.getElementById("email").value;
    var chk = true;
    if (str == '' || !str.match(/^[\w\.\-]+@([\w\-]+\.)+[a-z]{2,4}$/ig)) { chk = false }
    if (chk) {
      var email = document.getElementById("email").value;
      var dataStr = {"action": "checkEmail", "email": email };
      $.ajax({
          type: "post",
          url: "/ajax_validate",
          dataType: "text",
          data: dataStr,
          success: function (result) {
               if (result == "OK") {
                  obj.className = "d_ok";
                  obj.innerHTML = 'Email可以使用。';
                  document.getElementById("d_uname_img").src = li_ok;
              }
              else {
                  obj.className = "d_err";
                  obj.innerHTML = "该Email已存在。";
                  document.getElementById("d_uname_img").src = li_err;
              }
          },
          error: function () {
              alert("数据提交失败，请检查网络或重试。");
          }
      });
    } else {
        obj.className = "d_err";
        obj.innerHTML = msg[6];
        document.getElementById("d_email_img").src = li_err;
    }
    return chk;
}
function out_agree() {
    var obj = document.getElementById("d_agree");
    var chk = true;
    if (document.getElementById("agreebox").checked == false) {
        chk = false;
    }
    if (chk) {
        obj.className = "d_ok";
        obj.innerHTML = '';
        document.getElementById("d_agree_img").src = li_ok;
    } else {
        obj.className = "d_err";
        obj.innerHTML = msg[7];
        document.getElementById("d_agree_img").src = li_err;
    }
    return chk;
}

function out_code() {
    var obj =document.getElementById("d_code");
    var str = document.getElementById("code").value;
    var dataStr = {"code": str};
        $.ajax({
            type: "post",
            url: "/captch_valid",
            dataType: "text",
            data: dataStr,
            success: function (result) {
                 if (result == "ok") {
                   obj.className = "d_ok";
                   obj.innerHTML = '验证码输入正确。';
                   document.getElementById("d_code_img").src = li_ok;
                }
                else {
                  obj.className = "d_err";
                  obj.innerHTML = msg[5];
                  document.getElementById("d_code_img").src = li_err;
                }
            },
            error: function () {
                alert("数据提交失败，请检查网络或重试。");
            }
         });
         return obj.className == "d_ok";
}

function out_upwd1() {
    var obj = document.getElementById("d_upwd1");
    var str = document.getElementById("password").value;
    var chk = true;
    if (str.indexOf(' ') != -1) {
      chk = false;
    }
    if (str == '' || str.length < 6 || str.length > 14) { chk = false; }
    if (chk) {
        obj.className = "d_ok";
        obj.innerHTML = '密码已经输入。';
        document.getElementById("d_upwd1_img").src = li_ok;
    } else {
        obj.className = "d_err";
        obj.innerHTML = msg[2];
        document.getElementById("d_upwd1_img").src = li_err;
    }
    return chk;
}

function out_upwd2() {
    var obj = document.getElementById("d_upwd2");
    var str = document.getElementById("password_confirm").value;
    var chk = true;
    if (str != document.getElementById("password").value || str == '') { chk = false; }
    if (chk) {
        obj.className = "d_ok";
        obj.innerHTML = '重复密码输入正确。';
        document.getElementById("d_upwd2_img").src = li_ok;
    } else {
        obj.className = "d_err";
        obj.innerHTML = msg[3];
        document.getElementById("d_upwd2_img").src = li_err;
    }
    return chk;
}

function on_input(objname) {
    var strtxt;
    var obj = document.getElementById(objname);
    obj.className = "d_on";
    switch (objname) {
        case "d_uname":
            strtxt = msg[0];
            break;
        case "d_udomain":
            strtxt = msg[1];
            break;
        case "d_upwd1":
            strtxt = msg[2];
            break;
        case "d_upwd2":
            strtxt = msg[3];
            break;
        case "d_code":
            strtxt = msg[5];
            break;
        case "d_email":
            strtxt = msg[6];
        case "d_agree":
            strtxt = msg[7];
            break;
    }
    obj.innerHTML = strtxt;
}
function DispPwdStrength(iN, sHL) {
    if (iN > 3) { iN = 3; }
    for (var i = 1; i < 4; i++) {
        var sHCR = "ob_pws0";
        if (i <= iN) { sHCR = sHL; }
        if (iN > 0) {
            document.getElementById("idSM" + i).className = sHCR;
        }
        if (iN > 0) {
            if (i <= iN) {
                document.getElementById("idSMT" + i).style.display = ((i == iN) ? "inline" : "none");
            }
        }
        else {
           document.getElementById("idSMT" + i).style.display = ((i == iN) ? "none" : "inline");
        }
    }
}

// 
// function readCookie2(code) {
// 
//       var dataStr = { "action": "GetSComment", "code": code };
//         $.ajax({
//             type: "post",
//             url: "/Ajax.aspx",
//             dataType: "text",
//             data: dataStr,
//             success: function (result) {
//                   document.getElementById("comment_list").innerHTML = result;
//             },
//             error: function () {
//                 alert("数据提交失败，请检查网络或重试。");
//             }
//          });
//          return;
// }
// 
//  