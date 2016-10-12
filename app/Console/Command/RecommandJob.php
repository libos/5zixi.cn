<?php
App::uses('AppShell', 'Console/Command');
define("BOOKSPATH",__DIR__ . "/../../webroot/books/");
define("VIEWSPATH",__DIR__ . "/../../webroot/views/");
define("MOBILEPATH",__DIR__ . "/../../webroot/mobile/");

class RecommandJob extends AppShell
{
    public $uses = array('Book','Document');
    
    public function hot_plus()
    {
      $books = $this->Book->find('list');
      foreach ($books as $id => $name) {
        $book = $this->Book->findByBid($id);
//	print_r($book);
        //$ext  = $book['Book']['recommend'] * ($book['Book']['collect'] * 2 + $book['Book']['downloads'] * 0.6 + $book['Book']['click']/($book['Book']['pagescount']+1)* 0.3);
        $ext  = 1.00 * ($book['Book']['collect'] * 2 + $book['Book']['downloads'] * 0.6 + $book['Book']['click']/($book['Book']['pagescount']+1)* 0.3);
        $this->Book->id = $id;
        $this->Book->saveField('ext',$ext);
      }
      
      $hot_book_list = $this->Book->find('all',array('limit'=>16,'order'=>array('Book.ext DESC'),'conditions'=>array('Book.pass >=' => 12,'Book.burl !=' => '')));
      $li = "";
      $home_td="<tr>";
      foreach ($hot_book_list as $index => $bookx) {
        $created = strtotime($bookx['Book']['created']);
        $ye_mon  = date('Ym',$created);
        $day     = date('d',$created);
        $book_id = $bookx['Book']['bid'];
        $url     = $bookx['Book']['burl'];

        $cover = '/img/nocover.jpg';           
        if ($bookx['Book']['fengmian_id']!=0) {
          $img = $this->Document->find('first',array('conditions'=>array('Document.did'=>$bookx['Book']['fengmian_id'])));
          if (isset($img['Document']['link'])) {
            $cover = $img['Document']['link'];
          }
        }
        $size = 0;
        if ($bookx['Book']['txt_id']!=0) {
          $doc = $this->Document->find('first',array('conditions'=>array('Document.did'=>$bookx['Book']['txt_id'])));
          if (isset($doc['Document']['size'])) {
            $size = $doc['Document']['size'];
          }
        }
        $size = $this->formatSize($size);
        $li = $li . "<li><a href='/book/$ye_mon/$day/$book_id/$url.html' target='_blank'>{$bookx['Book']['name']}</a> - {$bookx['Book']['author']}</li>";
        $tmp = <<<END
        <td style="width:190px">
            <table style="text-align:left;width:150px" class="hottable" cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td style="text-align:center">
                    <a href="/book/{$url}.html"><img alt="pic" width="101px" height="141px" src="{$cover}"></a>
                  </td>
                </tr>
                <tr>
                  <td class="padding-left"><a href="/book/{$url}.html">{$bookx['Book']['name']}</a></td>
                </tr>
                <tr>
                  <td class="padding-left">&nbsp;</td>
                </tr>
                <tr>
                  <td class="padding-left">作者：{$bookx['Book']['author']}
                </tr>
                <tr>
                  <td class="padding-left">大小：{$size}
                </tr>
                <tr>
                  <td class="padding-left">贡献：{$bookx['User']['slug']}
                </tr>
              </tbody>
            </table>
        </td>
END;
        if (($index+1)%4==0){
          $tmp = $tmp . "</tr><tr>";
        }
        $home_td = $home_td . $tmp;
      }
      $html = '<div class="info_topten"><div class="main_t">热门推荐</div><ul>' . $li . '</ul></div>';
      $tt = time();
      $created = date('Y/m/d H:i:s',$tt);
      $year_month = date('Y',$tt);
      $day = date('m',$tt);
      $yearpath = VIEWSPATH . $year_month;
      if (!file_exists($yearpath)) {
        @mkdir($yearpath);
        @chmod($yearpath,0777);
      }
      $book_dir = VIEWSPATH . $year_month . '/' . $day . '/';
      if (!file_exists($book_dir)) {
        @mkdir($book_dir);
        @chmod($book_dir,0777);
      }
      $hot_dir = $book_dir . "small_hot_plus_list.html";
      $home_hot = $book_dir . "home_hot_plus_list.html";
      
      if (file_exists($hot_dir)) {
        unlink($hot_dir);
      }
      if (file_exists($home_hot)) {
        unlink($home_hot);
      }
      ////Hot dir ====================small_hot_plus_list
      $fzl= @fopen($hot_dir ,'w+');
      @fwrite($fzl,$html);
      @fclose($fzl);
      
      ////// ========== general
      $hot_dir = VIEWSPATH .  "small_hot_plus_list.html";
      if (file_exists($hot_dir)) {
        unlink($hot_dir);
      }
      $fzl= @fopen($hot_dir ,'w+');
      @fwrite($fzl,$html);
      @fclose($fzl);
      
      //hot dir======================home_hot_plus_list
      $fzl= @fopen($home_hot ,'w+');
      @fwrite($fzl,$home_td);
      @fclose($fzl);
      
      $home_hot = VIEWSPATH .  "home_hot_plus_list.html";
      if (file_exists($home_hot)) {
        unlink($home_hot);
      }
      $fzl= @fopen($home_hot ,'w+');
      @fwrite($fzl,$home_td);
      @fclose($fzl);
      
      
      $d = new DateTime($this->args[0]);
      $d->modify('first day of next month');
      // CakeResque::enqueueAt(
      //     $d,
      //     'default',
      //     'RecommandJob', 
      //     array('hot_plus',$d->format('Y-m-d'))
      // );       
    }
    
    public function related()
    {
      $thebook = $this->Book->findByBid($this->args[0]);
      $this->Book->recursive = 1;
      $books = $this->Book->find('all',array('limit'=>6,'order'=>'Book.created DESC'));
      $li = "";
      if ($thebook['Book']['burl'] == '') {
        CakeResque::enqueueIn(
            1800,
            'default',
            'RecommandJob', 
            array('related',$this->arg[0])
        );
        return false;
      }
      foreach ($books as $index => $book) {
        $book['img']['link'] = "/img/nocover.jpg";
        if ($book['Book']['fengmian_id']!=0) {
          $img = $this->Document->find('first',array('conditions'=>array('Document.did'=>$book['Book']['fengmian_id'])));          
          if (isset( $img['Document'])) {
            $book['img'] = $img['Document'];            
          }
        }

        $txt = $this->Document->find('first',array('conditions'=>array('Document.did'=>$book['Book']['txt_id'])));
        $book['txt']['size'] = "0 byte";
        if (isset($txt['Document'])) {
          $book['txt'] = $txt['Document'];
        }
        $li = $li . '<li><a href="/book/' . $book['Book']['burl'] . '.html" target="_blank"><img src="' . $book['img']['link'] . '" alt="' . $book['Book']['name'] . '(' . $this->formatSize($book['txt']['size']) . ')"></a><br><a href="/book/' . $book['Book']['burl'] . '.html" target="_blank">' . $book['Book']['name'] . '</a></li>';
      }
      $html = '<div class="info_samebook"><div class="main_t">相关书籍</div><ul>' . $li .  '</ul></div>';
      
      $book_id = $this->args[0];
      $time = $thebook['Book']['created'];
      $tt = strtotime($time);
      $created = date('Y/m/d H:i:s',$tt);
      $year_month = date('Ym',$tt);
      $day = date('d',$tt);
      $yearpath = BOOKSPATH . $year_month;
      if (!file_exists($yearpath)) {
        @mkdir($yearpath);
        @chmod($yearpath,0777);
      }
      
      $book_dir = BOOKSPATH . $year_month . '/' . $day . '/';
      if (!file_exists($book_dir)) {
        @mkdir($book_dir);
        @chmod($book_dir,0777);
      }
      $book_dir_id = $book_dir . $book_id . "/";      //书的内容位置  以及 资料页位置
      if (!file_exists($book_dir_id)) {
        @mkdir($book_dir_id);
        @chmod($book_dir_id,0777);
      }
      $book_dir_id = $book_dir . $book_id . "/related_" . $thebook['Book']['burl'] . '.html';
      
      if (file_exists($book_dir_id)) {
        unlink($book_dir_id);
      }
    
      $fzl= @fopen($book_dir_id ,'w+');
      @fwrite($fzl,$html);
      @fclose($fzl);
      
      CakeResque::enqueueIn(
           604800,
          'default',
          'RecommandJob', 
          array('related',$this->args[0])
      );
    }
    
  
    private function formatSize($bytes)
    {
           if ($bytes >= 1073741824)
           {
             $bytes = number_format($bytes / 1073741824, 2) . ' GB';
           }elseif ($bytes >= 1048576)
           {
               $bytes = number_format($bytes / 1048576, 2) . ' MB';
           }
           elseif ($bytes >= 1024)
           {
               $bytes = number_format($bytes / 1024, 2) . ' KB';
           }
           elseif ($bytes > 1)
           {
               $bytes = $bytes . ' bytes';
           }
           elseif ($bytes == 1)
           {
               $bytes = $bytes . ' byte';
           }
           else
           {
               $bytes = '0 bytes';
           }
           return $bytes;
    }  
}
