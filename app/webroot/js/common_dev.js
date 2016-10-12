$(document).ready(function(){
  $('.addto').click(function(){
    var that = this;
    $.ajax({
      url:'/books/collect',
      type:'post',
      dataType:'html',
      success:function(html){
        if (html=="OK") {
          alert("收藏成功");
        }
      }
    });
  });
});

function AddTo(id) {
  $.ajax({
    url:'/books/collect',
    type:'post',
    dataType:'html',
    data:{"bid":id},
    success:function(html){
      if (html=="OK") {
        alert("收藏成功");
      }
    }
  });
}