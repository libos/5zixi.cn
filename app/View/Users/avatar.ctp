<?php echo $this->element('myshufang'); ?>
<style type="text/css" media="screen">
.uc_index {
height: auto ;
padding-bottom: 40px;
padding-top: 20px;
}  
</style>
<link rel="stylesheet" href="/css/imgareaselect.css" type="text/css"   charset="utf-8">
<script type="text/javascript" charset="utf-8" src="/js/jquery.imgareaselect.min.js"></script>     
<?php
if(strlen($large_photo_exists)>0):
?>
<?php
	$current_large_image_width = $this->Html->getWidth($large_image_location);
	$current_large_image_height = $this->Html->getHeight($large_image_location);
?>
  <script type="text/javascript" charset="utf-8">
    function preview(img, selection) { 
    	var scaleX = <?php echo $thumb_width;?> / selection.width; 
    	var scaleY = <?php echo $thumb_height;?> / selection.height; 

    	$('#thumbnail + div > img').css({ 
    		width: Math.round(scaleX * <?php echo $current_large_image_width;?>) + 'px', 
    		height: Math.round(scaleY * <?php echo $current_large_image_height;?>) + 'px',
    		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
    		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
    	});
    	$('#x1').val(selection.x1);
    	$('#y1').val(selection.y1);
    	$('#x2').val(selection.x2);
    	$('#y2').val(selection.y2);
    	$('#w').val(selection.width);
    	$('#h').val(selection.height);
    } 

    $(document).ready(function () { 
    	$('#save_thumb').click(function() {
    		var x1 = $('#x1').val();
    		var y1 = $('#y1').val();
    		var x2 = $('#x2').val();
    		var y2 = $('#y2').val();
    		var w = $('#w').val();
    		var h = $('#h').val();
    		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
    			alert("You must make a selection first");
    			return false;
    		}else{
    			return true;
    		}
    	});
    }); 

    $(window).load(function () { 
      $('#thumbnail').imgAreaSelect({ aspectRatio: '1:<?php echo $thumb_height/$thumb_width;?>', onSelectChange: preview }); 
    });
  </script>
  <?php endif; ?>



<div class="uc_r">
        <div class="uc_t">
            修改头像</div>
      <div class="uc_info">
      <div class="uc_index">
    <?php if(strlen($large_photo_exists)>0): ?>
      <div style="margin-left:20px">
    		<h2>截取头像</h2>
    		<div align="center">
    			<img src="<?php echo $upload_path.$large_image_name.$_SESSION['user_file_ext'];?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" />
    			<div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width;?>px; height:<?php echo $thumb_height;?>px;">
    				<img src="<?php echo $upload_path.$large_image_name.$_SESSION['user_file_ext'];?>" style="position: relative;" alt="Thumbnail Preview" />
    			</div>
    			<br style="clear:both;"/>
    			<form name="thumbnail" action="/home/avatar" method="post">
    				<input type="hidden" name="x1" value="" id="x1" />
    				<input type="hidden" name="y1" value="" id="y1" />
    				<input type="hidden" name="x2" value="" id="x2" />
    				<input type="hidden" name="y2" value="" id="y2" />
    				<input type="hidden" name="w" value="" id="w" />
    				<input type="hidden" name="h" value="" id="h" />
    				<input type="submit" name="upload_thumbnail" value="保存头像" class="button3" id="save_thumb" />
    			</form>
    		</div>
     </div>
    <?php  else: ?>       
    <div style="margin-left:20px">
      	<h2>上传头像</h2>
        <div class="photocontainer"><img width="120" src="<?php echo $cur['User']['avatar'] ?>"></div>
      	<form name="photo" enctype="multipart/form-data" action="/home/avatar" method="post">
      	选择图片 <input type="file" name="image" size="30" /> <input type="submit" name="upload" class="button3" value="上传" />
      	</form>
    </div>
    <?php endif;?>
      </div>

      </div>
</div>
      
 
      