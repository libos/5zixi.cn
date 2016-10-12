
function bg_click(i,color) {

    for (var j = 1; j < 8; j++) {
        document.getElementById('sk_bs0' + j).style.border = '#999999 1px solid';
    }
        document.getElementById('sk_bs0' + i).style.border = '#999999 2px solid';
    document.body.style.backgroundColor = color;
    
}
function font_click(size) {
    document.getElementById('content_txt').style.fontSize = size;   
}

function save() {
  
}

//选择字体菜单
function open_ysmenu() {
    document.getElementById("ys_menu").style.display = "block";
}
function close_ysmenu() {
    document.getElementById("ys_menu").style.display = "none";
}
//改变字体颜色
function hei() {
    document.getElementById("content_txt").style.color = "#000000";
    document.getElementById('x_menu').value = '黑色';
    document.getElementById('x_menu').name = 'hei';
    save();
}
function red() {
    document.getElementById("content_txt").style.color = "#ff3300";
    document.getElementById('x_menu').value = '红色';
    document.getElementById('x_menu').name = 'red';
    save();
}
function blue() {
    document.getElementById("content_txt").style.color = "#0000ff";
    document.getElementById('x_menu').value = '蓝色';
    document.getElementById('x_menu').name = 'blue';
    save();
}
function lv() {
    document.getElementById("content_txt").style.color = "#006600";
    document.getElementById('x_menu').value = '绿色';
    document.getElementById('x_menu').name = 'lv';
    save();
}
function zong() {
    document.getElementById("content_txt").style.color = "#660000";
    document.getElementById('x_menu').value = '棕色';
    document.getElementById('x_menu').name = 'zong';
    save();
}

//定时同步高度
function autoSynHeight(id) {
    setInterval(function () {
        var cf = document.getElementById(id);
        if (cf != null && cf !== undefined)
            setTimeout(function () { setHeight(cf); }, 50);
    }, 50);
}

function setHeight(e) {
    try {
        if (e.contentDocument) {
            e.height = e.contentDocument.body.offsetHeight;
        } else if (e.contentWindow) {
            e.height = e.contentWindow.document.body.scrollHeight;
        }
    } catch (ex) { }
}


var mousey, currentpos, timer; 
function currentmousey() {
 mousey = window.event.y;

//得到鼠标在网页中的Y坐标，请注意 event 的大小写

}
function initialize() {
    var tim = 2;
    var timeby = document.getElementById('scrolltime');
    if (timeby) {
        tim = parseInt(document.getElementById('scrolltime').value);
        if (tim < 1) {
            tim = 1;
        }
        if (tim > 10) {
            tim = 10;
        }
    }
    timer = setTimeout("scrollwindow()", mousey / tim);
//document.body.style.cursor="hand";
//用鼠标在网页中的Y坐标来决定执行scrollwindow()函数的频率，从而动态改变网页的滚动速度

}
function stopscroll(){
 clearInterval(timer);
//document.body.style.cursor="";
}
function scrollwindow(){
currentpos = document.body.scrollTop;
window.scroll(0,++currentpos); 
if (currentpos != document.body.scrollTop){
stopscroll();
}else{
initialize();
}
}
document.ondblclick = initialize;
document.onmousedown = stopscroll;
document.onmousemove = currentmousey; 
