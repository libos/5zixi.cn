function searchForCover(){if(""==document.getElementById("bname").value)alert("请输入书籍名称!"),document.getElementById("bname").focus();else{var a="http://image.baidu.com/i?tn=baiduimage&ie=utf-8&word="+document.getElementById("bname").value;window.open(a,"_blank")}}function escape2(a){return escape(a).replace(/\+/g,"%2b")}function ValidateBook(a){if(""==a)return document.getElementById("ishave").value="1",void 0;htmlobj=$.ajax({url:"/ajaxcheck?book="+escape(a),async:!1});var b=htmlobj.responseText;"OK"==b?""==document.getElementById("bauthor").value?document.getElementById("ishave").value="1":document.getElementById("bname").value=document.getElementById("bname").value:(document.getElementById("ishave").value="0",document.getElementById("bname").className="my_textbox")}function AddBookNameTag(a){""!=a&&"1"==document.getElementById("ishave").value&&(document.getElementById("bname").value=document.getElementById("bname").value,"0"==document.getElementById("ishave").value)}function checkform(){return isupload?(document.getElementById("up1").className="",""==document.getElementById("bname").value?(alert("请输入书籍名称!"),document.getElementById("bname").focus(),document.getElementById("bname").className="my_textbox_err",!1):(document.getElementById("bname").className="my_textbox","1"==document.getElementById("ishave").value?(alert("书籍名称已经存在!"),!1):""==document.getElementById("bauthor").value?(alert("请输入书籍作者!"),document.getElementById("bauthor").focus(),document.getElementById("bauthor").className="my_textbox_err",!1):(document.getElementById("bauthor").className="my_textbox",""==document.getElementById("bdesc").value?(alert("请输入书籍介绍!"),document.getElementById("bdesc").focus(),document.getElementById("bdesc").className="my_textbox_err",!1):(document.getElementById("bdesc").className="my_textbox_err",!0)))):(alert("请选择书籍上传!"),document.getElementById("up1").className="my_up_err",!1)}