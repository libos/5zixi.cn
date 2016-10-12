function readCookie(name) {//读取Cookie 
    var cookieValue = "";
    var search = name + "]=";
    if (document.cookie.length > 0) {
        offset = document.cookie.indexOf(search);
        if (offset != -1) {
            offset += search.length;
            end = document.cookie.indexOf("%26", offset);
            if (end == -1) end = document.cookie.length;
            //cookieValue = unescape(document.cookie.substring(offset, end)) 
            cookieValue = document.cookie.substring(offset, end)
        }
    }
    return cookieValue;
}
function writeCookie(name, value) {//写入Cookie
    var Days = 300;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
    document.cookie = name + "=" + value + "&expires=" + exp.toGMTString();
}

function escape2(str) {
    return escape(str).replace(/\+/g, "%2b");
}

function cookieCheck() {
    if (readCookie("uid") != "") {
        loginxx();
        document.getElementById("LoginSuc").style.display = "block";
    }
    else {
        document.getElementById("Login").style.display = "block";
    }
}
function keyEnter13(button, event) {
    if (event.keyCode == 13) {
        //$(button).click();
        document.getElementById(button).click();
    }
}

function loginxx() {
     var dataStr = { "action": "CheckLogin", "State": "1"};
     $.ajax({
         type: "post",
         url: "/login",
         dataType: "text",
         data: dataStr,
         success: function (result) {
             if (result != "") {
                 document.getElementById("LoginSuc").innerHTML = result;
             }
         },
         error: function () {
           //  alert("数据提交失败，请检查网络或重试。");
         }
     });
    return;
}



function nouseLogin(s) {
    if (s == 0) {
        if (readCookie("uid") != "") {
            document.getElementById("i_loginsuc").style.display = "block";
        }
        else {
            document.getElementById("i_login").style.display = "block";
        }
    }
    //参数说明:s=0,1,2分别指"判断状态","登陆","退出"
    var uid = "";
    var uName = "";
    var uPass = "";
    var uExpires = 0;
    if (s == 1) {
        uName = document.getElementById("txtUser").value
        uPass = document.getElementById("txtPass").value
        //遍历得到选中的值
        //        var a=document.getElementsByName("expires") ; 
        //        for (var i=0;i<a.length ;i++ )
        //       { if( a[i].checked==true )
        //       {uExpires=a[i].value;
        //       }}
        if (!uName || !uPass) return;
        if (document.getElementById("expires").checked == true) {
            //  if (document.getElementsByName("expires").checked = true) {
            uExpires = 3650000;
        }
        document.getElementById("LoginBtn").disabled = true;
    }
    var dataStr = { "action": "nouseLogin", "State": s, "User": escape(uName), "Pass": uPass, "Expires": escape2(uExpires) };
    $.ajax({
        type: "post",
        url: "/login",
        dataType: "text",
        data: dataStr,
        success: function (result) {
            if (result == "LoginOut") {
                document.getElementById("i_loginsuc").style.display = "none";
                document.getElementById("i_login").style.display = "block";
                document.getElementById("LoginSuc").style.display = "none";
                document.getElementById("Login").style.display = "block";
                document.getElementById("LoginBtn").disabled = false;
                document.getElementById("txtPass").value = "";
            } else if (result == "Error") {
                alert("账号或密码错误！");
            }
            else if (result != "") {
                document.getElementById("i_loginsuc").innerHTML = result;
                document.getElementById("i_login").style.display = "none";
                document.getElementById("i_loginsuc").style.display = "block";
                cookieCheck();
            }
            document.getElementById("LoginBtn").disabled = false;
        },
        error: function () {
           // alert("数据提交失败，请检查网络或重试。");
        }
    });
    return;
}

function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function homepageuserlogin() {
    var uName = $("#login_slug").val();
    var uPass = $("#login_password").val();
    var uExpires = 0;
    if (!uName || !uPass) {
        document.getElementById("Login_Text").innerHTML = "账号和密码不能为空！";
        return;
    }
    if (document.getElementsByName("Login_Exp").checked = true) {
        uExpires = 3650000;
    }
    document.getElementById("EnterOper").disabled = true;
    var dataStr = { "action": "homepageuserlogin", "slug": escape(uName), "password": md5(uPass), "Expires": escape2(uExpires) };

    $.ajax({
        type: "post",
        url: "/login",
        dataType: "text",
        data: dataStr,
        success: function (result) {
            if (result == "Login") {
              var url = getUrlVars()["url"];
              if (!url) {
                url="/home";
              }
                    parent.location = url;
            } else {
                document.getElementById("Login_Text").innerHTML = "账号或密码错误！";
                document.getElementById("EnterOper").disabled = false;
            }
        },
        error: function () {
           // alert("数据提交失败，请检查网络或重试。");
        }
    });
    return;
}