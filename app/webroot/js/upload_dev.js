function searchForCover() {
    if (document.getElementById("bname").value == "") {
        alert("请输入书籍名称!");
        document.getElementById("bname").focus();
    }
    else {
        var url = "http://image.baidu.com/i?tn=baiduimage&ie=utf-8&word=" + document.getElementById("bname").value;
        window.open(url, "_blank");
    }
}

function escape2(str) {
    return escape(str).replace(/\+/g, "%2b");
}


function ValidateBook(strName) {
    if (strName == "") {
        document.getElementById("ishave").value = "1";
        return;
    } else {
        //CheckBookName(strName);
        htmlobj = $.ajax({ url: "/ajaxcheck?book=" + escape(strName), async: false });
        var result = htmlobj.responseText;
        if (result == "OK" ) {
            if (document.getElementById("bauthor").value == "") {
                document.getElementById("ishave").value = "1";
            }
            else {
                //document.getElementById("bname").value = document.getElementById("bname").value + "【" + document.getElementById("bauthor").value + "】";
                document.getElementById("bname").value = document.getElementById("bname").value;
            }
        }
        else {
            document.getElementById("ishave").value = "0";
            document.getElementById("bname").className = "my_textbox";
        }
    }
}

function AddBookNameTag(author) {
    if (author != "" && document.getElementById("ishave").value == "1") {
        //document.getElementById("bname").value = document.getElementById("bname").value + "【" + author + "】";
        document.getElementById("bname").value = document.getElementById("bname").value ;
        document.getElementById("ishave").value == "0";
    }
}

function checkform() {
    if (!isupload) {
        alert("请选择书籍上传!");
        document.getElementById("up1").className = "my_up_err";
        return false;
    }
    else {
        document.getElementById("up1").className = "";
    }
    if (document.getElementById("bname").value == "") {
        alert("请输入书籍名称!");
        document.getElementById("bname").focus();
        document.getElementById("bname").className = "my_textbox_err";
        return false;
    }
    else {
        document.getElementById("bname").className = "my_textbox";
    }
    if (document.getElementById("ishave").value == "1") {
        alert("书籍名称已经存在!");
        return false;
    }
    if (document.getElementById("bauthor").value == "") {
        alert("请输入书籍作者!");
        document.getElementById("bauthor").focus();
        document.getElementById("bauthor").className = "my_textbox_err";
        return false;
    }
    else {
        document.getElementById("bauthor").className = "my_textbox";
    }
    if (document.getElementById("bdesc").value == "") {
        alert("请输入书籍介绍!");
        document.getElementById("bdesc").focus();
        document.getElementById("bdesc").className = "my_textbox_err";
        return false;
    }
    else {
        document.getElementById("bdesc").className = "my_textbox_err";
    }
    return true;
}
