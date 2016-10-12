<?php
App::uses('AppShell', 'Console/Command');
define("BOOKSPATH",__DIR__ . "/../../webroot/books/");
define("VIEWSPATH",__DIR__ . "/../../webroot/views/");
define("MOBILEPATH",__DIR__ . "/../../webroot/mobile/");

class MobileJob extends AppShell
{
    public $uses = array('Book','Document');
    
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
  
    public function moblie_cache()
    {
      CakeResque::enqueue(
          'default',
          'MobileJob', 
          array('mobile_list')
      );
      CakeResque::enqueue(
          'default',
          'MobileJob', 
          array('mobile_create_homepage')
      );
      CakeResque::enqueue(
          'default',
          'MobileJob', 
          array('mobile_hot_new_all')
      );
      CakeResque::enqueue(
          'default',
          'MobileJob', 
          array('mobile_rank')
      );
    }
  
    public function mobile_list()
    {
      $list = array('青春','言情','穿越','武侠','玄幻','文学','悬疑','都市','历史','经管');
      $orders = array('最近更新','最多点击','最多收藏','最多下载');
      $ordersname = array('created','click','collect','downloads');
      $banner1 = '<div class="t3"><table><tbody><tr>';
      $banner3 = '</tr></tbody></table></div>';
      $banner2 = '';
     
      foreach ($list as $allindex => $allvalue){
        foreach ($orders as $orderindex => $ordervalue) {      
          //start banner
          $banner = "";
          $banner2 = '<td><a href="/">首页</a></td>';
          $i = 1;
          foreach ($list as $index => $value) {
            if ($index == $allindex) {
              $banner2 = $banner2 . '<td><a href="/listA' . $index . 'B0P1.html" id="A' . $index . '" class="daohang">' . $value . '</a></td>';
            }else {
              $banner2 = $banner2 . '<td><a href="/listA' . $index . 'B0P1.html" id="A' . $index . '">' . $value . '</a></td>';       
            }
            if ($index < 4) {
              if ($i % 4 == 0) {
                $banner2 = $banner2 . "</tr><tr>";
                $i = 0;
              }
            }else{
              if ($i % 5 == 0) {
                $banner2 = $banner2 . "</tr><tr>";
              }
            }

            $i++;
          }
    
          $banner2 = $banner2 . '<td><a href="/hotplusP1.html" id="c_11">热门</a></td><td><a href="/newestP1.html" id="c_12">最新</a></td><td><a href="/allbooksP1.html">书房</a></td><td><a href="/rank.html">排行</a></td>';
          $banner = $banner1 . $banner2 . $banner3;
          //end banner
        
          //start Homepage
          // if ($allindex == 0) {
          //   $this->create_homepage($banner);
          // }
          //end Homepage
        
        
          //start orders
          $order = "";
          $order1 = <<<END
  <div id="OrderList2"><table class="t4"><tbody><tr> 
END;
          $order3 = <<<END
  </tr></tbody></table></div>
END;
          $order2 = "";
          foreach ($orders as $index => $value) {
            $tmp = "";
            if ($orderindex == $index) {
              $tmp = <<<END
      <td><a href="/listA{$allindex}B{$index}P1.html" class="B{$index}"><span style="color:red;">{$value}</span></a></td>
END;
            }else{
              $tmp = <<<END
      <td><a href="/listA{$allindex}B{$index}P1.html" class="B{$index}">{$value}</a></td>
END;
            }
            $order2 = $order2 . $tmp;
          }        

          $order = $order1 . $order2 . $order3 .  '<div style="padding:3px"></div>';
          //end orders
          //start content
          $count = $this->Book->find('count',array('conditions'=>array('Book.type'=>$allindex,'Book.pass >=' => 12,'Book.burl !='=> '' )));
          $perpage = 26;
          $total = ceil($count / $perpage);
          if ($total == 0) {
            $total = 1;
          }
          for ($pagenum=1; $pagenum <=$total; $pagenum++) { 
            $books = $this->Book->find('all',array('limit'=>$perpage,'page'=>$pagenum,'recursive'=>-1,'order'=>'Book.' . $ordersname[$orderindex] . ' DESC','conditions'=>array('Book.type'=>$allindex,'Book.pass >=' => 12,'Book.burl !='=> '')));
            $listx1 = <<<END
            <div id="list"> <ul class="lists"> 
END;
            $next_pagenum = $pagenum + 1;
            $prev_pagenum = $pagenum - 1;
            $listx3 = "";
            $listx3 = <<<END
            </ul><div class="pager small bg1 pd12"><span class="count"><a href="/listA{$allindex}B{$orderindex}P1.html" title="首页">首页</a>&nbsp; <a href="/listA{$allindex}B{$orderindex}P{$prev_pagenum}.html" title="上页">上一页</a>&nbsp; <a href="/listA{$allindex}B{$orderindex}P{$next_pagenum}.html" title="下页">下一页</a>&nbsp;<a href="/listA{$allindex}B{$orderindex}P{$total}.html" title="尾页">尾页</a>&nbsp; 共{$total}页 </span></div></div>
END;
            if ($pagenum == 1) {
              $listx3 = "";
              $listx3 = <<<END
              </ul><div class="pager small bg1 pd12"><span class="count">首页  上一页  &nbsp;<a href="/listA{$allindex}B{$orderindex}P{$next_pagenum}.html" title="下页">下一页</a>&nbsp;<a href="/listA{$allindex}B{$orderindex}P{$total}.html" title="尾页">尾页</a>&nbsp; 共{$total}页 </span></div></div>
END;
            }
            if ($pagenum == $total) {
              $listx3 = "";
              $listx3 = <<<END
              </ul><div class="pager small bg1 pd12"><span class="count"><a href="/listA{$allindex}B{$orderindex}P1.html" title="首页">首页</a>&nbsp; <a href="/listA{$allindex}B{$orderindex}P{$prev_pagenum}.html" title="上页">上一页</a>&nbsp;  下一页 &nbsp; 尾页&nbsp; 共{$total}页 </span></div></div>
END;
            }
            if ($total == 1) {
              $listx3 = "";
              $listx3 = <<<END
              </ul><div class="pager small bg1 pd12"><span class="count">首页&nbsp; 上一页&nbsp;  下一页 &nbsp; 尾页&nbsp; 共{$total}页 </span></div></div>
END;
            }
            $listx2 = "";
            foreach ($books as $index => $book) {
              $desc = mb_substr($book['Book']['decs'],0,10);
              $tmp = <<<END
    <li class="li_bg"><a href="/book/{$book['Book']['burl']}.html"> <p>{$book['Book']['name']}</p> <p class="intro">{$desc}...</p></a></li>
END;
              $listx2 = $listx2 . $tmp;
            }
            
            $listx = $listx1 . $listx2 . $listx3 . '<div style="padding:3px"></div>';
          
            //start html
            $html = $banner . $order . $listx;
            //end html
            //start filename
            $filename = MOBILEPATH . $allindex . "/"  . $orderindex . "/" . "listA{$allindex}B{$orderindex}P{$pagenum}.html";
            $firstdir = MOBILEPATH . $allindex . "/" ;
            if (!file_exists($firstdir)) {
              mkdir($firstdir);
              chmod($firstdir,0777);
            }
            $secondir = MOBILEPATH . $allindex . "/"  . $orderindex . "/" ;
            if (!file_exists($secondir)) {
              mkdir($secondir);
              chmod($secondir,0777);
            }
            //end filename
            //start save file
            if (file_exists($filename)) {
              unlink($filename);
            }
    
            $f= @fopen($filename ,'w+');
            @fwrite($f,$html);
            @fclose($f);
            //end save file
          
          }
          //end contents
        
        }//order
      }  //allindex
    }    //function
  
    public function mobile_create_homepage()
    {
      $list = array('青春', '言情','穿越','武侠','玄幻','文学','悬疑','都市','历史','经管');
      //start banner
      $banner1 = '<div class="t3"><table><tbody><tr>';
      $banner3 = '</tr></tbody></table></div>';
      $banner2 = '';
      $banner2 = $banner2 . '<td><a href="/"  class="daohang">首页</a></td>';
    
      $i = 1;
      foreach ($list as $index => $value) {
        $banner2 = $banner2 . '<td><a href="/listA' . $index . 'B0P1.html" id="A' . $index . '">' . $value . '</a></td>';       
        if ($index < 4) {
          if ($i % 4 == 0) {
            $banner2 = $banner2 . "</tr><tr>";
            $i = 0;
          }
        }else{
          if ($i % 5 == 0) {
            $banner2 = $banner2 . "</tr><tr>";
          }
        }
        $i++;
      }
      
      $banner2 = $banner2 . '<td><a href="/hotplusP1.html" id="c_11">热门</a></td><td><a href="/newestP1.html" id="c_12">最新</a></td><td><a href="/allbooksP1.html">书房</a></td><td><a href="/rank.html">排行</a></td>';
      $banner = $banner1 . $banner2 . $banner3;
      //end banner
      //start search
      $search = <<<END
      <form class="index_search" action="/search" method="get"><table class="t5"><tbody><tr><td width="80%"><input name="q" id="kw" class="inpt" onclick="javascript:{if (this.value == '请输入关键字') this.value=''; };" value="请输入关键字"></td><td width="20%"><input type="submit" class="inpb" value="搜索"></td></tr></tbody></table></form>
END;
      //end search
      //start hot
      $hot = '<table class="title"><tbody><tr><td class="w12"></td><td>书籍推荐</td><td class="w12"></td></tr></tbody></table><ul class="lists">';
    
      $hot_book_list = $this->Book->find('all',array('limit'=>16,'order'=>array('Book.ext DESC'),'conditions'=>array('Book.pass >=' => 12,'Book.burl !='=>'')));
      foreach ($hot_book_list as $index => $book) {
        $type = $list[$book['Book']['type']];
        $tmp = <<<END
        <li class="li_bg"><a href="/book/{$book['Book']['burl']}.html"><font color="red">[{$type}]</font> {$book['Book']['name']} <span style="color: #999">({$book['Book']['author']})</span></a></li>
END;
        $hot = $hot . $tmp;
      }
      $hot = $hot . '</ul>' . '<div style="padding:3px"></div>';
      //end hot
      //start pop
      $pop = '<table class="title"><tbody><tr><td class="w12"></td><td>人气总排行</td><td class="w12"></td></tr></tbody></table><ul class="lists">';
      $poplist = $this->Book->find('all',array('limit'=>16,'order'=>array('Book.click DESC'),'conditions'=>array('Book.pass >=' => 12,'Book.burl !='=> '')));
      foreach ($poplist as $index => $book) {
        $type = $list[$book['Book']['type']];
        $tmp = <<<END
        <li class="li_bg"><a href="/book/{$book['Book']['burl']}.html"><font color="red">[{$type}]</font> {$book['Book']['name']} <span style="color: #999">({$book['Book']['author']})</span></a></li>
END;
        $pop = $pop . $tmp;
      }
      $pop = $pop . '</ul>' . '<div style="padding:3px"></div>';
      //end pop
    
      $html = $banner . $search . $hot . $pop;
    
      //start filename
      $filename = MOBILEPATH . "homepage/" .  "index.html";
      $filedir  = MOBILEPATH . "homepage/";
      if (!file_exists($filedir)) {
        @mkdir($filedir);
        @chmod($filedir,0777);
      }
      //end filename
      //start save file
      if (file_exists($filename)) {
        unlink($filename);
      }

      $f= @fopen($filename ,'w+');
      @fwrite($f,$html);
      @fclose($f);
      //end save file
    }
  
    public function mobile_hot_new_all()
    {
      $tt = array('hotplus'=>'热门','newest'=>'最新','allbooks'=>'书房');
      $order = array('hotplus'=>'ext','newest'=>'created','allbooks'=>'name');
      $list = array('青春', '言情','穿越','武侠','玄幻','文学','悬疑','都市','历史','经管');
      //start banner
      $banner1 = '<div class="t3"><table><tbody><tr>';
      $banner3 = '</tr></tbody></table></div>';
      $banner2 = '';
      $banner = "";
      $banner2 = $banner2 . '<td><a href="/" >首页</a></td>';

      $i = 1;
      foreach ($list as $index => $value) {
        $banner2 = $banner2 . '<td><a href="/listA' . $index . 'B0P1.html" id="A' . $index . '">' . $value . '</a></td>';       
        if ($index < 4) {
          if ($i % 4 == 0) {
            $banner2 = $banner2 . "</tr><tr>";
            $i = 0;
          }
        }else{
          if ($i % 5 == 0) {
            $banner2 = $banner2 . "</tr><tr>";
          }
        }

        $i++;
      }
      $banner2tt = $banner2;
      foreach ($tt as $allindex => $allvalue) {
          $banner2 = $banner2tt;
          foreach ($tt as $index => $value) {
            $tmp = <<<END
            <td><a href="/{$index}P1.html" id="c_11">{$value}</a></td>
END;
            if ($index == $allindex) {
              $tmp = <<<END
              <td><a href="/{$index}P1.html" id="c_11"  class="daohang">{$value}</a></td>
END;
            }
          
            $banner2 = $banner2 . $tmp;
          }
          $banner2 = $banner2 . '<td><a href="/rank.html">排行</a></td>';
          $banner = $banner1 . $banner2 . $banner3;
          //end banner
          //start content
          $count = $this->Book->find('count',array('conditions'=>array('Book.pass >=' => 12 , 'Book.burl !='=>'')));
          $perpage = 26;
          $total = ceil($count / $perpage);
          if ($total == 0) {
            $total = 1;
          }
          for ($pagenum=1; $pagenum <=$total; $pagenum++) { 
            $books = $this->Book->find('all',array('limit'=>$perpage,'page'=>$pagenum,'recursive'=>-1,'order'=>'Book.' . $order[$allindex] . ' DESC','conditions'=>array('Book.pass >=' => 12,'Book.burl !='=>'')));
          
            $listx1 = <<<END
            <div id="list"> <ul class="lists"> 
END;
            $next_pagenum = $pagenum + 1;
            $prev_pagenum = $pagenum - 1;
            $listx3 = "";
            $listx3 = <<<END
            </ul><div class="pager small bg1 pd12"><span class="count"><a href="/{$allindex}P1.html" title="首页">首页</a>&nbsp; <a href="/{$allindex}P{$prev_pagenum}.html" title="上页">上一页</a>&nbsp; <a href="/{$allindex}P{$next_pagenum}.html" title="下页">下一页</a>&nbsp;<a href="/{$allindex}P{$total}.html" title="尾页">尾页</a>&nbsp; 共{$total}页 </span></div></div>
END;
            if ($pagenum == 1) {
              $listx3 = "";
              $listx3 = <<<END
              </ul><div class="pager small bg1 pd12"><span class="count">首页  上一页  &nbsp;<a href="/{$allindex}P{$next_pagenum}.html" title="下页">下一页</a>&nbsp;<a href="/{$allindex}P{$total}.html" title="尾页">尾页</a>&nbsp; 共{$total}页 </span></div></div>
END;
            }
            if ($pagenum == $total) {
              $listx3 = "";
              $listx3 = <<<END
              </ul><div class="pager small bg1 pd12"><span class="count"><a href="/{$allindex}P1.html" title="首页">首页</a>&nbsp; <a href="/{$allindex}P{$prev_pagenum}.html" title="上页">上一页</a>&nbsp;  下一页 &nbsp; 尾页&nbsp; 共{$total}页 </span></div></div>
END;
            }
            if ($total == 1) {
              $listx3 = "";
              $listx3 = <<<END
              </ul><div class="pager small bg1 pd12"><span class="count">首页&nbsp; 上一页&nbsp;  下一页 &nbsp; 尾页&nbsp; 共{$total}页 </span></div></div>
END;
            }
            $listx2 = "";
            foreach ($books as $index => $book) {
              $desc = mb_substr($book['Book']['decs'],0,10);
              $tmp = <<<END
    <li class="li_bg"><a href="/book/{$book['Book']['burl']}.html"> <p>{$book['Book']['name']}</p> <p class="intro">{$desc}...</p>
END;
              if ($allindex == 'allbooks') {
                $tmp = $tmp . "<p class='intro fgreen'>作者：{$book['Book']['author']} 类别：{$list[$book['Book']['type']]}</p>";
              }
              $listx2 = $listx2 . $tmp . '</a></li>';
            }
          
            $listx = $listx1 . $listx2 . $listx3 . '<div style="padding:3px"></div>';
          
            //start html
            $html = $banner . $listx;
            //end html
            //start filename
            $filename = MOBILEPATH . $allindex . "/" . "{$allindex}P{$pagenum}.html";
            $firstdir = MOBILEPATH . $allindex . "/" ;
            if (!file_exists($firstdir)) {
              @mkdir($firstdir);
              @chmod($firstdir,0777);
            }
            //end filename
            //start save file
            if (file_exists($filename)) {
              unlink($filename);
            }
    
            $f= @fopen($filename ,'w+');
            @fwrite($f,$html);
            @fclose($f);
            //end save file
          
          }
          //end contents
          // ========================
    
      }// end for tt
    }  // end func
  
    public function mobile_rank()
    {
      $list = array('青春', '言情','穿越','武侠','玄幻','文学','悬疑','都市','历史','经管');
      //start banner
      $banner1 = '<div class="t3"><table><tbody><tr>';
      $banner3 = '</tr></tbody></table></div>';
      $banner2 = '';
      $banner2 = $banner2 . '<td><a href="/">首页</a></td>';
    
      $i = 1;
      foreach ($list as $index => $value) {
        $banner2 = $banner2 . '<td><a href="/listA' . $index . 'B0P1.html" id="A' . $index . '">' . $value . '</a></td>';       
        if ($index < 4) {
          if ($i % 4 == 0) {
            $banner2 = $banner2 . "</tr><tr>";
            $i = 0;
          }
        }else{
          if ($i % 5 == 0) {
            $banner2 = $banner2 . "</tr><tr>";
          }
        }

        $i++;
      }
      
      $banner2 = $banner2 . '<td><a href="/hotplus.html" id="c_11">热门</a></td><td><a href="/newest.html" id="c_12">最新</a></td><td><a href="/allbooksP1.html">书房</a></td><td><a href="/rank.html" class="daohang">排行</a></td>';
      $banner = $banner1 . $banner2 . $banner3;
      //end banner
      $html = $banner;
      foreach ($list as $index  => $value) {

        $pop = '<table class="title"><tbody><tr><td class="center">' . $value . '总排行</td></tr></tbody></table><ul class="lists">';
        
        $books = $this->Book->find('all',array('limit'=>12,'recursive'=>-1,'order'=>'Book.click DESC','conditions'=>array('Book.type'=>$index,'Book.pass >=' => 12,'Book.burl !='=>'')));
        
        foreach ($books as $ii => $book) {

          $tmp = <<<END
  <li class="li_bg"><a href="/book/{$book['Book']['burl']}.html"> <p>{$book['Book']['name']} ({$book['Book']['click']})</p></a></li>
END;
          $pop = $pop . $tmp ;
        }
        $pop = $pop . '</ul>';
        
        $html = $html . $pop;
      
      }
      //start filename
      $filename = MOBILEPATH . "rank/" . "rank.html";
      $firstdir = MOBILEPATH . "rank/" ;
      if (!file_exists($firstdir)) {
        @mkdir($firstdir);
        @chmod($firstdir,0777);
      }
      //end filename
      //start save file
      if (file_exists($filename)) {
        unlink($filename);
      }

      $f= @fopen($filename ,'w+');
      @fwrite($f,$html);
      @fclose($f);
      //end save file
    }
  

}
