<?php echo $this->Html->css('upload'); ?>
<?php echo $this->element('myshufang'); ?>
<?php $list = array('青春', '言情','穿越','武侠','玄幻','文学','悬疑','都市','历史','经管'); ?>
<div class="uc_r">
  <form method="post" action="/upload" id="form1" onsubmit="javascript:return checkform()">

    <div style="text-align:left">
      <div id="xcTitle" class="uc_t">上传电子书（<a href="http://get.adobe.com/cn/flashplayer" target="_blank"><font color="red">如果没有上传按钮请下载flash插件</font></a>）</div>
      <div style="padding:15px;">
          <table>
          <tbody>
            <tr><td>上传书籍：</td>
              <td align="top">
                <div id="up1"><table style="width:70%"><tbody><tr><td class="ubtn"><div id="uploadtxtID"></div></td><td align="left"><div class="uinfo"><span class="redx">(格式为TXT的电子书,大小不超过20M)</span></div></td></tr></tbody></table>
                  <div id="fileQueue" class="uploadifyQueue"></div>
                 </div>
            </td>
          </tr>
          <tr>
            <td>书籍名称：</td><td><input name="bname" type="text" id="bname" class="my_textbox" <?php if (isset($this->request->query['bid'])): ?>value="<?php echo $thebook['Book']['name'] ?>[续传1]"<?php endif ?> onblur="javascript:ValidateBook(this.value);" style="width:320px;"> <a href="javascript:searchForCover()">搜索封面</a><input type="hidden" name="ishave" value="0" id="ishave"></td>
          </tr>
          <tr>
            <td>书籍作者：</td><td><input name="bauthor" type="text" id="bauthor" class="my_textbox" <?php if (isset($this->request->query['bid'])): ?>value="<?php echo $thebook['Book']['author'] ?>"<?php endif ?> onblur="javascript:AddBookNameTag(this.value);" style="width:150px;"></td>
          </tr>
          <tr>
          <td>书籍类型：</td><td><span id="bclass"><?php foreach ($list as $index => $value): ?>
              <input id="bclass_<?php echo $index ?>" type="radio" name="bclass" value="<?php echo $index ?>"<?php if (!isset($this->request->query['bid']) && $index == 0): ?>checked="checked" <?php else: ?> <?php if (isset($this->request->query['bid']) && $index == $thebook['Book']['type']): ?>checked="checked"<?php endif ?> <?php endif ?>><label for="bclass_0"><?php echo $value ?></label>
            <?php endforeach ?></span></td>
          </tr>
          <tr>
            <td>书籍类型</td>
            <td><input id="bstatus1" type="radio" name="bstatus" value="Y" checked><label for="bstatus1">已完结</label><input id="bstatus2" type="radio" name="bstatus" value="N"><label for="bstatus2">未完结</label></td>
          </tr>
          <tr>
            <td>书籍封面：</td>
            <td> 
              <span class="gray">
                <table style="width:80%"><tbody><tr><td class="ubtn"><div id="uploadcoverID"></div></td><td><div class="uinfo">(格式为jpg、gif、png,大小不超过300K,<span style="color:#008000">如无请留空！</span>)&nbsp;&nbsp;</div></td></tr></tbody></table>
                <div id="fileQueue2" class="uploadifyQueue"></div></div>
              </span>
            </td>
          </tr>
          <tr>
          <td valign="top">书籍介绍：</td><td><textarea name="bdesc" rows="2" cols="20" id="bdesc" class="my_textbox" style="height:120px;width:480px;"><?php if (isset($this->request->query['bid'])): ?><?php echo $thebook['Book']['decs'] ?><?php endif ?></textarea></td>
          </tr>
          <tr><td></td>
          <td><span style="color:green;">注意：填写正确的小说封面及简介，才有机会被推荐到书籍列表和首页。</span></td></tr>
          <tr><td>
            <input type="hidden" name="txtdoc" value="-1" id="txtdoc">
            <input type="hidden" name="imgdoc" value="-1" id="imgdoc">
          </td><td>
              <input type="submit" name="bupload" value="上传" id="bupload" class="button3" style="height:40px;width:80px;margin-left:123px">
          </td></tr>
          </tbody>
          </table> 
    </div>  
   </div>
  </form>
</div>
<script type="text/javascript" charset="utf-8">
var isupload=false;
</script>
<script src="/js/swfupload.js" charset="utf-8"></script>
<script src="/js/swfupload.queue.js" charset="utf-8"></script>
<script src="/js/upload.js" charset="utf-8"></script>
<script src="/js/fileprogress.js" charset="utf-8"></script>
<script src="/js/handlers.js" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function () {
  var uploadtxt,uploadcover;
  window.onload = function () {
    uploadtxt = new SWFUpload({
  		upload_url : "/uploadtxt",
      file_post_name: "Filedata",
      post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},
  		flash_url : "/flash/swfupload.swf",
  		file_size_limit : "20 MB",
      
			file_types : "*.txt",
			file_types_description : "TXT电子书",
			file_upload_limit : "0",
			file_queue_limit : "1",
      
			file_dialog_start_handler : fileDialogStart,
			file_queued_handler : fileQueued,
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_start_handler : uploadStart,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete,
      
			button_placeholder_id : "uploadtxtID",
			button_image_url : "/img/XPButtonUploadText_61x22.png",
			button_placeholder_id : "uploadtxtID",
      button_action : SWFUpload.BUTTON_ACTION.SELECT_FILE,
			button_width: 61,
			button_height: 22,

			custom_settings : {
				progressTarget : "fileQueue",
        docinput:"txtdoc"
			},
      debug: false
  	});
    uploadcover = new SWFUpload({
  		upload_url : "/uploadcover",
      file_post_name: "Filedata",
      post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},
  		flash_url : "/flash/swfupload.swf",
  		file_size_limit : "300 KB",
      
			file_types : "*.jpg;*.png;*.gif",
			file_types_description : "封面图片",
			file_upload_limit : "0",
			file_queue_limit : "1",
      
			file_dialog_start_handler : fileDialogStart,
			file_queued_handler : fileQueued,
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_start_handler : uploadStart,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete,
      
			button_image_url : "/img/upload.png",
			button_image_url : "/img/XPButtonUploadText_61x22.png",
			button_placeholder_id : "uploadcoverID",
      button_action : SWFUpload.BUTTON_ACTION.SELECT_FILE,
			button_width: 61,
			button_height: 22,
			custom_settings : {
				progressTarget : "fileQueue2",
        docinput:"imgdoc"
			},
      debug: false
  	});
  };
});
</script>