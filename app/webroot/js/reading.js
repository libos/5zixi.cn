function bg_click(a,b){for(var c=1;8>c;c++)document.getElementById("sk_bs0"+c).style.border="#999999 1px solid";document.getElementById("sk_bs0"+a).style.border="#999999 2px solid",document.body.style.backgroundColor=b}function font_click(a){document.getElementById("content_txt").style.fontSize=a}function save(){}function open_ysmenu(){document.getElementById("ys_menu").style.display="block"}function close_ysmenu(){document.getElementById("ys_menu").style.display="none"}function hei(){document.getElementById("content_txt").style.color="#000000",document.getElementById("x_menu").value="黑色",document.getElementById("x_menu").name="hei",save()}function red(){document.getElementById("content_txt").style.color="#ff3300",document.getElementById("x_menu").value="红色",document.getElementById("x_menu").name="red",save()}function blue(){document.getElementById("content_txt").style.color="#0000ff",document.getElementById("x_menu").value="蓝色",document.getElementById("x_menu").name="blue",save()}function lv(){document.getElementById("content_txt").style.color="#006600",document.getElementById("x_menu").value="绿色",document.getElementById("x_menu").name="lv",save()}function zong(){document.getElementById("content_txt").style.color="#660000",document.getElementById("x_menu").value="棕色",document.getElementById("x_menu").name="zong",save()}function autoSynHeight(a){setInterval(function(){var b=document.getElementById(a);null!=b&&void 0!==b&&setTimeout(function(){setHeight(b)},50)},50)}function setHeight(a){try{a.contentDocument?a.height=a.contentDocument.body.offsetHeight:a.contentWindow&&(a.height=a.contentWindow.document.body.scrollHeight)}catch(b){}}function currentmousey(){mousey=window.event.y}function initialize(){var a=2,b=document.getElementById("scrolltime");b&&(a=parseInt(document.getElementById("scrolltime").value),1>a&&(a=1),a>10&&(a=10)),timer=setTimeout("scrollwindow()",mousey/a)}function stopscroll(){clearInterval(timer)}function scrollwindow(){currentpos=document.body.scrollTop,window.scroll(0,++currentpos),currentpos!=document.body.scrollTop?stopscroll():initialize()}var mousey,currentpos,timer;document.ondblclick=initialize,document.onmousedown=stopscroll,document.onmousemove=currentmousey;