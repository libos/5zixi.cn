<?php
App::uses('AppShell', 'Console/Command');
define("BOOKSPATH",__DIR__ . "/../../webroot/books/");
define("VIEWSPATH",__DIR__ . "/../../webroot/views/");
define("MOBILEPATH",__DIR__ . "/../../webroot/mobile/");

class DataMigrate extends AppShell
{
   public $uses = array('Book','Document','Tmp');

   public function migrate()
   {
     $type_list = array('青春'=>0,'言情'=>1,'穿越'=>2,'武侠'=>3,'玄幻'=>4,'文学'=>5,'悬疑'=>6,'都市'=>7,'历史'=>8,'经管'=>9);
     $list_tmp = $this->Tmp->find('all',array('order'=>'rand()'));
     $former_dir = "/alidata/root/xiaoshuo/books/";
     $target_dir = "/alidata/www/shufang/app/webroot/files/books/";
     $target_href = "/files/books/";
     $uids = array(2,3,4,5,6);
     foreach ($list_tmp as $id => $tmp_book) {
       
       $txt_id = -1;
       $img_id = -1;
       $book_id = -1;
       
       $target_dirx = "";
       $target_hrefx = "";
       $file_id = $tmp_book['Tmp']['fileid'];
       $uid = $uids[$id%5];
       $former_file = $former_dir . $file_id . ".txt";
       $former_img =  $former_dir . $file_id . ".jpg";
       if(filesize($former_file) == 0)
	{
		continue;
	}
       $tttime = strtotime($tmp_book['Tmp']['created']);
       $dir = date("Ym",$tttime);
       $target_dirx = $target_dir . $dir  . "/" ;
       $target_hrefx = $target_href . $dir . "/";
       if (!file_exists($target_dirx)) {
         mkdir($target_dirx);
         chmod($target_dirx,0777);
       }
       $target_dirx = $target_dirx . date("d",$tttime) . "/";
       $target_hrefx = $target_hrefx  . date("d",$tttime) . "/";
       if (!file_exists($target_dirx)) {
         mkdir($target_dirx);
         chmod($target_dirx,0777);
       }
       //dir 
       //name
       $file_name = $uid . date("Ymd_His",$tttime) . rand(10000,20000) . '.txt';
       $img_name =  $uid . date("Ymd_His",$tttime) . rand(10000,20000) . '.jpg';
       
       $target_img = $target_dirx . $img_name;
       $target_href_img = $target_hrefx . $img_name;
       
       $target_dirx = $target_dirx . $file_name;
       $target_hrefx = $target_hrefx . $file_name;
       
       if (!copy($former_file,$target_dirx)) {
         echo "error copy txt";
       }
       @chmod($target_dirx,0777);
       $this->Document->create();
       $txt['Document']['uid'] = $uid;
       $txt['Document']['status'] = 0;
       $txt['Document']['origin'] = $file_id + ".txt";
       $txt['Document']['location'] = $target_dirx;
       $txt['Document']['link'] = $target_hrefx;
       $txt['Document']['type'] = "txt";
       $txt['Document']['size'] = filesize($target_dirx);
       if ($this->Document->save($txt)) {
	 $txt_id = $this->Document->id;
       }
      
       
       // if( == "f9839e24eb39d3a5a3b639f59b0fc2e6" or "3574750d66faae84599af62ff87531a1"){
       if(!file_exists($former_img)){
         $img_id = 0;
       }else{
         if (!copy($former_img,$target_img)) {
           echo "error copy txt";
         }
         @chmod($target_img,0777);
         $this->Document->create();
         $img['Document']['uid'] = $uid;
         $img['Document']['status'] = 0;
         $img['Document']['origin'] = $file_id + ".jpg";
         $img['Document']['location'] = $target_img;
         $img['Document']['link'] = $target_href_img;
         $img['Document']['type'] = "jpg";
         $img['Document']['size'] = filesize($target_img);
         if ($this->Document->save($img)) {
           $img_id = $this->Document->id;
         }
       }
       
       if ($txt_id == -1) {
         echo "error" + $list_tmp;
         continue;
       }
       $this->Book->create();
       $book['Book']['name'] = $tmp_book['Tmp']['name'];
       $book['Book']['uid'] = $uid;
       $book['Book']['pass'] = 0;
       $book['Book']['author'] = $tmp_book['Tmp']['author'];
       $book['Book']['decs'] = $tmp_book['Tmp']['decs'];
       $book['Book']['type'] = $type_list[trim($tmp_book['Tmp']['type'])];
       $book['Book']['txt_id'] = $txt_id;
       $book['Book']['filesize'] = 0;
       $book['Book']['fengmian_id'] = $img_id;
       if ($this->Book->save($book)) {
         $book_id = $this->Book->id;
       }
       if ($book_id == -1) {
         continue;
       }
       $this->Document->id = $txt_id;
       $this->Document->saveField('bid',$book_id);
       
       if ($img_id != 0) {
         $this->Document->id = $img_id;
         $this->Document->saveField('bid',$book_id);
       }
       
       //END FOREACH 
     }
   }
  
}
