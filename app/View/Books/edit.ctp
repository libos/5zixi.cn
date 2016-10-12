<?php echo $this->Html->css('upload'); ?>
<?php echo $this->element('myshufang'); ?>
<?php $list = array('青春', '言情','穿越','武侠','玄幻','文学','悬疑','都市','历史','经管'); ?>
<div class="uc_r">
  <form method="post" action="/books/edit/<?php echo $this->request->data['Book']['bid'] ?>" id="form1" onsubmit="javascript:return checkform()">

    <div style="text-align:left">
      <div id="xcTitle" class="uc_t">修改电子书</div>
      <div style="padding:15px;">
          <table>
          <tbody>

          <tr>
            <td>书籍名称：</td><td><input name="bname" type="text" id="bname" class="my_textbox" value="<?php echo $this->request->data['Book']['name'] ?>"  style="width:320px;"> </td>
          </tr>
          <tr>
            <td>书籍作者：</td><td><input name="bauthor" type="text" id="bauthor" class="my_textbox" value="<?php echo $this->request->data['Book']['author'] ?>" style="width:150px;"></td>
          </tr>
          <tr>
          <td>书籍类型：</td><td><span id="bclass"><?php foreach ($list as $index => $value): ?>
              <input id="bclass_<?php echo $index ?>" type="radio" name="bclass" value="<?php echo $index ?>" <?php if ($this->request->data['Book']['type'] == $index): ?>checked="checked"<?php endif ?>><label for="bclass_0"><?php echo $value ?></label>
            <?php endforeach ?></span></td>
          </tr>
          <tr>
            <td>书籍类型</td>
            <td><input id="bstatus1" type="radio" name="bstatus" value="Y" <?php if ($this->request->data['Book']['status'] == 'Y'): ?>checked="checked"<?php endif ?>><label for="bstatus1">已完结</label><input id="bstatus2" type="radio" name="bstatus" <?php if ($this->request->data['Book']['status'] == 'N'): ?>checked="checked"<?php endif ?>><label for="bstatus2">未完结</label></td>
          </tr>
          <tr>
          <td valign="top">书籍介绍：</td><td><textarea name="bdesc" rows="2" cols="20" id="bdesc" class="my_textbox" style="height:120px;width:480px;"><?php echo $this->request->data['Book']['decs'] ?></textarea></td>
          </tr>
          <tr><td></td>
          <td><span style="color:green;">注意：填写正确的小说封面及简介，才有机会被推荐到书籍列表和首页。</span></td></tr>
          <tr><td>
            <input type="hidden" name="txtdoc" value="-1" id="txtdoc">
            <input type="hidden" name="imgdoc" value="-1" id="imgdoc">
          </td><td>
              <input type="submit" name="bupload" value="编辑" id="bupload" class="button3" style="height:40px;width:80px;margin-left:123px">
          </td></tr>
          </tbody>
          </table> 
    </div>  
   </div>
  </form>
</div>

