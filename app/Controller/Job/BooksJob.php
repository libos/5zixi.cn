<?php
define("BOOKSPATH",__DIR__ . "/../../webroot/books/");
define("MOBILEBOOK",__DIR__ . "/../../webroot/mbook/");
// define("VIEWSPATH",__DIR__  . "/../../webroot/views/");
define("MOBILEPATH",__DIR__ . "/../../webroot/mobile/");
define("ENCODING","UTF-8");
require "/etc/database/setting.inc";
require_once __DIR__ . '/BaiduYun/BaiduPCS.class.php';
class BooksJob{
  private $type = array('qingchun' => '青春' , 'yanqing'=>'言情','chuanyue'=>'穿越','wuxia' => '武侠','xuanhuan'=>'玄幻','wenxue'=>'文学','xuanyi'=>'悬疑','dushi'=>'都市','lishi'=>'历史','jingguan'=>'经管');
  private $dsettings;
  private $typeIndex = array('qingchun', 'yanqing','chuanyue','wuxia' ,'xuanhuan','wenxue','xuanyi','dushi','lishi','jingguan');
  private $default;
  private $db;
  public function __construct()
  {  
     $this->default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' =>  $this->dsettings->mysql_host,
		'login' => $this->dsettings->mysql_user,
		'password' => $this->dsettings->mysql_pass,
		'database' => 'shufang',
		'prefix' => '',
    'encoding' => 'utf8',
	);

    $this->db = new PDO('mysql:host=' . $this->default['host'] . ';dbname=' . $this->default['database'] . ';charset=utf8', $this->default['login'], $this->default['password'], array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  }
  public function Book($bid="")
  {
    try {
       $stmt = $this->db->query("SELECT * FROM books where bid = " . $bid);
       return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $ex) {
      echo "Book Err";
    }
  }
  public function related()
  {
    try {
       $stmt = $this->db->query("SELECT * FROM books WHERE pass >= 12 ORDER BY RAND() LIMIT 10");
       return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $ex) {
      echo "Book Err";
    }
  }
  public function updateField($table='',$field='',$value='',$primaryKey='bid',$keyvalue="")
  {
    try {
       $stmt = $this->db->prepare("UPDATE $table SET " . $field . "= ? where $primaryKey = ?" );
       $stmt->execute(array($value,$keyvalue));
    } catch(PDOException $ex) {
      echo "Update Err";
      print_r($ex);
    }
  }
  public function Document($did="")
  {
    try {
       $stmt = $this->db->query("SELECT * FROM documents where did = " . $did);
       return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $ex) {
      echo "Document Err";      
    }
  }
  public function User($uid="")
  {
    try {
       $stmt = $this->db->query("SELECT * FROM users where uid = " . $uid);
       return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $ex) {
      echo "User Err";      
    }
  }
  public function Content($bid="",$body="")
  {
    try {
      $result = $this->db->prepare("INSERT INTO content (bid,body,created,modified) VALUES (?,?,NOW(),NOW())");
      $result->execute(array($bid, $body));
      return $insertId = $this->db->lastInsertId();
    } catch(PDOException $ex) {
      echo "Content Err" ;
      print_r($ex);
    }

  }
  public function uploadBaidu($file_location,$dir)
  {
    //请根据实际情况更新$access_token与$appName参数
    $access_token = '23.1a63493452c4bcd2c099399f0c150e8f.2592000.1389342279.2252123692-1490235';
    //应用目录名
    $appName = '52shufang';
    //应用根目录
    $root_dir = '/apps' . '/' . $appName . '/';

    //上传文件的目标保存路径，此处表示保存到应用根目录下
    $targetPath = $root_dir . $dir . "/";
    //要上传的本地文件路径
    $file = $file_location;
    //文件名称
    $fileName = basename($file);
    //新文件名，为空表示使用原有文件名
    $newFileName = '';

    $pcs = new BaiduPCS($access_token);
    
    $baidupath = $targetPath . $fileName;
    
    
    if (!file_exists($file)) {
    	exit('文件不存在，请检查路径是否正确');
    } else {
      try {
         $delete_exists = $pcs->deleteSingle($baidupath); 
      } catch (Exception $e) {
        
      }      
    	$fileSize = filesize($file);
    	$handle = fopen($file, 'rb');
    	$fileContent = fread($handle, $fileSize);

    	$result = $pcs->upload($fileContent, $targetPath, $fileName, $newFileName);
    	fclose($handle);
      $result = json_decode($result);
      if (isset($result->error_msg)) {
        echo "$file_location";
        print_r($result);
      }
    }
  }
  function downloadBaidu($link='')
  {
    //请根据实际情况更新$access_token与$appName参数
    $access_token = '23.1a63493452c4bcd2c099399f0c150e8f.2592000.1389342279.2252123692-1490235';
    //应用目录名
    $appName = '52shufang';
    //应用根目录
    $root_dir = '/apps' . '/' . $appName . '/';
    $link = substr($link,6);
    //文件路径
    $path = $root_dir . $link;
    $fileName = basename($link);
    // $pcs = new BaiduPCS($access_token);
    $downlink = 'https://pcs.baidu.com/rest/2.0/pcs/file?method=download&access_token=' . $access_token . '&path=' . $path;
    header('Content-Description: File Transfer');
    header('Content-Disposition:attachment;filename="' . $fileName . '"');
    header('Content-Type:application/octet-stream');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
     // header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($downlink);
    exit;
    // $result = $pcs->download($path);
    // echo $result;
  }
  function formatSize($bytes)
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

  function mb_str_split($string,$string_length=1) {
          if(mb_strlen($string) > $string_length || !$string_length) {
                  do {    
                          $c = mb_strlen($string);
                          $parts[] = mb_substr($string,0,$string_length,ENCODING);
                          $string = mb_substr($string,$string_length,$c,ENCODING);
                  }while(!empty($string));
          } else {         
                  $parts = array($string);
          }
          return $parts;
  }
  public function perform() {
    $bid = $this->args['bid'];
    if($bid==null)
    {  
      $bid=1;
    }
    $book = $this->Book($bid);
    $file_id = $this->args['did'];
    if($file_id == null){
       $file_id=1;
    }    
    $file = $this->Document($file_id);
    if (empty($book)) {
      echo "\n\nERROR BID\n\n BID=$bid;DID=$file_id;\n\n";
    }
    if (empty($file)) {
      echo "\n\nERROR DID\n\n BID=$bid;DID=$file_id;\n\n";
    }
    $fengmian_id = $book[0]['fengmian_id'];
    $fengmian = $this->Document($fengmian_id);
    // print_r($file);

    $location = $file[0]['location'];
    if (!file_exists($location)) {
      echo "\n\nERROR LOCATION\n\n BID=$bid;DID=$file_id;\n\n";
    }
    
    $dddir  = substr(dirname($file[0]['link']),6);
    $this->uploadBaidu($location,$dddir);
    // $this->downloadBaidu($file[0]['link']);
    //读取数据
    $f = @fopen($location, 'r');
    $content = @fread($f, filesize($location));
    @fclose($f);
    $content = @iconv('gb2312','utf-8//IGNORE',$content);
    $content = str_replace("书包网","我自习",$content);
    $content = str_ireplace("bookbao.com","5zixi.cn",$content);
    $prefix  = mb_substr($content,0,540) . "...";
    $content_array = $this->mb_str_split($content,40000);
    $content = nl2br(preg_replace('/ /','　',htmlentities($content,ENT_QUOTES | ENT_IGNORE,"UTF-8"))); //防止把<br>也分开了
    
    //---分页
    $count = mb_strlen($content);
    $page_count = count($content_array);
    //---BookData
    $bookName = $book[0]['name'];
    $book_id = $book[0]['bid'];
    
    $this->updateField('books','pagescount',$page_count,'bid',$book_id);
    $url = $book[0]['burl'];
    
    //-----生成独一无二的BURL
    if ($url == '') {
      $url = uniqid(substr(base64_encode(mt_rand()),2,5));
      $this->updateField('books','burl',$url,'bid',$book_id);
    }
    $user_id = $book[0]['uid'];
    $user = $this->User($user_id);
    $user_name = $user[0]['slug'];
    $author = $book[0]['author'];
    $time = $book[0]['created'];

    //---路径
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
    $book_url = "/books/" . $year_month . '/' . $day . '/';
    if (!file_exists($book_dir)) {
      @mkdir($book_dir);
      @chmod($book_dir,0777);
    }
    $book_dir_id = $book_dir . $book_id . "/";      //书的内容位置  以及 资料页位置
    
    /******
    *       全文地址  /{books}/{year.month}/{day}/{id}/id_{burl}.html
    *       分节地址  /{books}/{year.month}/{day}/{id}/id_{burl}_1.html
    *       资料地址  /{books}/{year.month}/{day}/{id}/{burl}.html
    *******/
    
    
    $book_url_id = $book_url . $book_id . "/";      //书的内容的URL
    $book_dir_id_main = "/books/" ;        //书的资料页URL
    if (!file_exists($book_dir_id)) {
      @mkdir($book_dir_id);
      @chmod($book_dir_id,0777);
    }
    $quanwen_location = $book_dir_id . "id_" . $url . ".html";
    $quanwen_url      = $book_url_id . "id_" . $url . ".html";
    
    $ziliao_location  = $book_dir_id . $url . ".html";
    $ziliao_url       = "/book/" . $url . ".html";
    
    // $parts_location   = $book_dir_id . "id_" . $url . "_x.html";
    $parts_url        = $book_url_id . "id_" . $url . "_1.html";
   ////这里可能没有！！加上 
    $bookFengmian = $fengmian[0]['link'];
     #print_r($fengmian);
    #echo $bookFengmian;

    $fileSize = $this->formatSize($file[0]['size']);
    $collect  = $book[0]['collect'];
    $typeEng = $this->typeIndex[$book[0]['type']];
    $typeName = $this->type[$typeEng];
    
    $info1 = <<<END
      <style>
    .info_div{font-size:12px;}
    .info_div .l{float:left;}
    .info_div .r{float:right;padding:5px;width:440px; }
    .info_div .r1{ padding:5px; }
    .info_t{font-size:16px;font-weight:bold;height:40px;line-height:40px;padding-left:10px;}
    .info_img{padding:5px;border:1px solid #BFDCEC;width:160px;height:226px;margin-bottom: 5px;}
    .book_content{font-size:12px;border-top:1px solid #BFDCEC;padding-top:10px;text-indent: 2em;color:#333;overflow:hidden;margin-bottom:10px;}
    .book_author{height:24px;line-height:24px;}

    .info_copy span{height:26px;line-height:26px;margin:10px 0;}
    .info_copy .box{border:1px solid #CECFCE;height:22px;line-height:22px;width:310px;background:#f7f7f7;color:#555;}
    .info_copy .box1{border:1px solid #CECFCE;height:22px;line-height:22px;width:410px;background:#f7f7f7;color:#555;}
    .info_copy .but{border:1px solid #CECFCE;height:26px;line-height:26px;background:url(/img/ula.jpg);}

    .info_ad{margin-top:10px;}
    .info_l{float:left;width:630px;}
    .info_2{float:left;}
    .info_r{float:right;width:302px;}
    .info_topten{border:1px solid #ddd;padding:10px;margin-top:10px;}
    .info_topten li{height:22px;line-height:22px;color:#666;padding-left:5px;}

    .info_samebook{border:1px solid #ddd;padding:10px;margin-top:10px;height:245px;}
    .info_samebook li{float:left;height:116px;width:90px;color:#666;padding-left:3px;overflow:hidden;text-align:center;}
    .info_samebook img{width:72px;height:96px;}
    .info_ads{text-align: center; width: 650px; margin-top: 6px;clear:both;}
    
    .info_views{width:618px;margin:auto;border:1px solid #BDDFEF;margin-top:10px;padding:5px; text-align:center; clear:left;}

    .info_views ul li{ font-size:14px;height:24px;line-height:24px;padding-left:5px; padding-right:5px; display:inline-block; *float:left;width:280px;overflow: hidden;white-space: nowrap;-o-text-overflow: ellipsis;text-overflow: ellipsis; }
    .info_views ul li a{ word-break:keep-all;}
    .info_views ul li a:hover {color: #DB2C30; text-decoration:none;}
    ul, li {margin: 0;padding: 0;border: 0;list-style: none;}
    .info_buttondiv{clear:both;height:40px;line-height:40px;margin-top:10px;}
    .info_button{height:26px;line-height:26px;float:left;text-align:center;width:90px;margin-right:10px;}
    a.info_button,a.info_button:visited{font-size:12px; background:url(/img/ula.jpg); border:1px solid #ddd;display:block;}
    a.info_button:hover{font-size:12px;background:url(/img/ulb.jpg); border:1px solid #A7D4E0;}
    a.info_button:visited{ background:url(/img/ula.jpg); border:1px solid #ddd;display:block;}
    </style>
      <div class="info_l">
              <div class="info_div">
                  <div class="info_t">{$bookName}</div>
                  <div class="l">
                      <img src="{$bookFengmian}" alt="{$bookName}" class="info_img">
                  </div>
                  <div class="r">
                      <div class="book_author">
                          作者:<a href="/search?q={$author}" target="_blank">{$author}</a> 大小:{$fileSize} 类型:<a href="/{$typeEng}" target="_blank">{$typeName}</a>
                          收藏:{$collect}</div>
                      <div class="book_content">
                         {$prefix}更新时间：{$created}</div>
                      <div class="info_copy">
                          <span>推荐给朋友：</span>
                          <input type="text" id="myurl" value="http://www.5zixi.cn{$ziliao_url}" class="box">
                          <input type="button" value="复制" class="but" onclick="copyUrl($('myurl').value)">
                      </div>
      				<div style="text-align:left;height:24px;line-height:24px;"> 
                        下载： <a href="/down/id_$url.html" target="_blank">{$bookName}TXT下载</a>
      <br>                 
      阅读： <a href="{$quanwen_url}" target="_blank">{$bookName}全文阅读</a>
                      </div>
                  </div>
              </div>
              <div class="info_ads">
              </div>
        
              <div class="info_views">
                  <div style="font-size: 14px; font-weight: bold; padding-left: 5px;">
                      分节阅读</div>
                  <ul>
END;
    $info2 = "";
    for ($i=1;$i <= count($content_array); $i++) {
      if ($i%2==1) {
        $info2 = $info2 . "<li class='n'><a href='" .  $book_url_id . "id_" . $url . "_{$i}.html" . "' target='_blank'>{$bookName}_分节阅读_{$i}</a></li>";
      }else
      {
        $info2 = $info2 . "<li><a href='" .  $book_url_id . "id_" . $url . "_{$i}.html" . "' target='_blank'>{$bookName}_分节阅读_{$i}</a></li>";
      }
        
    }

    $info3 = <<<END
                  </ul>
              </div>
              <div style="text-align: center;">
                  <div class="info_buttondiv" style="width: 640px; padding-left: 110px">
                      <a href="javascript:;" onclick="javascript:AddTo({$book_id})" class="info_button">收藏书籍</a>
                      <a href="/down/id_$url.html" target="_blank" class="info_button">下载书籍</a>
                      <a href="{$quanwen_url}" target="_blank" class="info_button">全文阅读</a>
                      <a href="{$parts_url}" target="_blank" class="info_button" style="color: Red">分节阅读</a>
                  </div>
              </div>
<!--</div>-->
END;

    $info = $info1 . $info2 . $info3;
    
    if (file_exists($ziliao_location)) {
      unlink($ziliao_location);
    }
    
    $fzl= @fopen($ziliao_location ,'w+');
    @fwrite($fzl,$info);
    @fclose($fzl);
    
    $suffix = "_全文阅读";
    $first = <<<END
          <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
          <html>
          <head>
              <title>$bookName - 我自习 5zixi.cn</title>
              <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
              <meta name="keywords" content="$bookName">
              <meta name="description" content="{$bookName}全文阅读, {$bookName}TXT下载,{$bookName}全集, {$bookName}最新章节">
              <link href="favicon.ico" type="image/x-icon" rel="icon">
              <link rel="stylesheet" type="text/css" href="/css/style.css">
              <script type="text/javascript" src="/js/jquery.js"></script>
              <script type="text/javascript" charset="utf-8" src="/js/common.js"></script>
              <script>
              var _hmt = _hmt || [];
              (function() {
                var hm = document.createElement("script");
                hm.src = "//hm.baidu.com/hm.js?f70387f3963cf6467e17796a2e73c958";
                var s = document.getElementsByTagName("script")[0]; 
                s.parentNode.insertBefore(hm, s);
              })();
              </script>
          </head>
      
          <body>
              <div id="container">
                  <div id="header">
                      <div class="view_top">
                      <div class="l"><a href="/"><img src="/img/logo3.png" alt="我自习 - 做最好的TXT电子书阅读平台"></a></div>
                      <div class="r">上传：<a href="/space/$user_id">$user_name</a> | <a href="/down/id_$url.html" target="_blank">下载全本</a> | <a href="{$ziliao_url}">书籍资料页</a> | <a href="/">返回首页</a><br><span>(双击鼠标开启屏幕滚动，鼠标上下控制速度)</span></div></div>
                          <div id="ksw_pagebody">
                                <div class="sk_gb" style="z-index:1;">
                                <div id="beijingse">
                                <div class="sk_wz">选择背景色：</div>
                                <span id="skbglist">
                                <div class="sk_bs01" id="sk_bs01" onclick="javascript:bg_click('1','#f1f5f9');"></div> 
                                <div class="sk_bs02" id="sk_bs02" onclick="javascript:bg_click('2','#f1f2e8');"></div>
                                <div class="sk_bs03" id="sk_bs03" onclick="javascript:bg_click('3','#f1ebde');"></div>
                                <div class="sk_bs04" id="sk_bs04" onclick="javascript:bg_click('4','#f1f0ee');"></div>
                                <div class="sk_bs05" id="sk_bs05" onclick="javascript:bg_click('5','#F1F3E9');"></div>
                                <div class="sk_bs06" id="sk_bs06" onclick="javascript:bg_click('6','#F5E9ED');"></div>
                                <div class="sk_bs07" id="sk_bs07" onclick="javascript:bg_click('7','#FFF3F7');"></div>
                                </span>
                                浏览字体：[ <span id="fonts"><a id="18px" onclick="javascript:font_click('18px');">大</a> <a id="14px" onclick="javascript:font_click('14px');">中</a> <a id="12px" onclick="javascript:font_click('12px');">小</a></span> ] &nbsp;
                                </div>
                                <div id="yanse">
                                字体颜色：<input name="" type="text" value="黑色" id="x_menu" onmousemove="open_ysmenu()" onmouseout="close_ysmenu()">
                                <ul id="ys_menu" style="display: none;" onmousemove="open_ysmenu()" onmouseout="close_ysmenu()">
                                  <li value="黑色" id="hei"><a href="javascript:hei()">黑色</a></li>
                                  <li value="红色" id="red"><a href="javascript:red()">红色</a></li>
                                  <li value="绿色" id="lv"><a href="javascript:lv()">绿色</a></li>
                                  <li value="蓝色" id="blue"><a href="javascript:blue()">蓝色</a></li>
                                  <li value="棕色" id="zong"><a href="javascript:zong()">棕色</a></li>
                                </ul>
                                双击鼠标滚屏:
                                <input type="text" size="2" value="5" id="scrolltime">(1最慢,10最快）
                                </div>
                                </div>
                            </div>
                    
                        <!-- Baidu Button BEGIN -->
                        <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
                        <a class="bds_renren">人人网</a>
                        <a class="bds_tsina">新浪微博</a>
                        <a class="bds_qzone">QQ空间</a>
                        <a class="bds_tqq">腾讯微博</a>
                        <a class="bds_t163">网易微博</a>
                        <a class="bds_mshare">一键分享</a>
                        <a class="bds_tieba">百度贴吧</a>
                        <a class="bds_douban">豆瓣网</a>
                        <a class="bds_kaixin001">开心网</a>
                        <a class="bds_sqq">QQ好友</a>
                        <a class="bds_hi">百度空间</a>
                        <a class="bds_ty">天涯社区</a>
                        <a class="bds_copy">复制</a>
                        <span class="bds_more">更多</span>
                        <a class="shareCount"></a>
                        </div>
                        <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=1258482" ></script>
                        <script type="text/javascript" id="bdshell_js"></script>
                        <script type="text/javascript">
                        document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000);
                        </script>
                        <!-- Baidu Button END -->
                  </div>
                  <div id="content" class="reading">
                      <div class="title">
                        
                          
END;
      $first_2 = <<<END
                        <a href="{$ziliao_url}">{$bookName}</a>{$suffix}
END;
      $first_3 = <<<END
                        <a onclick="javascript:AddTo({$book_id});" title="加入书房" href="javascript:;"><img src="/img/addto.png" border="0" style="cursor: hand;"></a>
                      </div>
                      <div class="info">
                        <div class="view_info">
                         作者:{$author} 章节列表:<a href="{$ziliao_url}" style="color:#2C6A99;">{$bookName}</a> 下载:<a href="/down/id_$url.html" style="color:#2C6A99;">{$bookName}TXT下载</a> 时间:{$created}
                          </div>
                      </div>
                      <div class="ads">

                      </div>
                      <div class="content">
                        <div id="content_txt">
END;
      $third = <<<END
                        <div style="text-align:center"><br><a href="{$ziliao_url}">返回书籍页</a></div>
                      </div>
                    </div>      <div class="index_log" style="text-align: center;">
     <!-- 广告位：首页右边第一个 -->
     <script type="text/javascript">
     document.write('<a style="display:none!important" id="tanx-a-mm_46924635_4290951_14546072"></a>');
     tanx_s = document.createElement("script");
     tanx_s.type = "text/javascript";
     tanx_s.charset = "gbk";
     tanx_s.id = "tanx-s-mm_46924635_4290951_14546072";
     tanx_s.async = true;
     tanx_s.src = "http://p.tanx.com/ex?i=mm_46924635_4290951_14546072";
     tanx_h = document.getElementsByTagName("head")[0];
     if(tanx_h)tanx_h.insertBefore(tanx_s,tanx_h.firstChild);
</script> 
<script src="http://a.alimama.cn/inf.js" type="text/javascript"></script>  

 </div>
                    <div id="footer">
                      <div class="foot_nav"><a id="addHomePage" href="#">设为首页</a>　|　<a id="favorites" href="#">加入收藏</a>　|　广告合作　|　<a href="/signup" target="_blank">会员注册</a>　|　<a href="/feedback" target="_blank">意见反馈</a>　|　<a href="/changelog" target="_blank">更新记录</a>　</div>
                    <div class="copyright">Copyright ©2013  <a href="http://5zixi.cn">5zixi.cn</a> Beta All Rights Reserved. </div>
              		</div>
                  <script type="text/javascript"src="/js/reading.js"></script>
             </div><!-- container-->
             <script>
             (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
             (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
             m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
             })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

             ga('create', 'UA-19281868-15', '5zixi.cn');
             ga('send', 'pageview');
 
             </script>
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fa1743ee8a92f13d7821f7b114c7f58e1' type='text/javascript'%3E%3C/script%3E"));
</script>
<script src="http://rs.qiyou.com/view.php?uid=23422"></script> 
<script src="http://p.qiyou.com/view.php?uid=23422"></script>
         </body>
        </html>
END;
    
    $quanwen = $first . $first_2 . $first_3 . $content . $third;
    if (file_exists($quanwen_location)) {
      unlink($quanwen_location);
    }

    $fqw= @fopen($quanwen_location ,'w+');
    @fwrite($fqw,$quanwen);
    @fclose($fqw);

    ////////////////////start mobile/////////////////
    /****************************
    *     mobile 资料页  /book/{$burl}.html(判断是mobile)    实际位置 /mobile/mbook/{$burl[0]第一个字符}/{$burl}.html
    *     mobile 阅读页  /mbook/{year_month}/{day}/{id}/id_{burl}_{page}.html
    *     mobile 下载页  /down/id_{$burl}.html(判断是mobile) 实际位置 /mobile/down/{$burl[0]第一个字符}/{$burl}.html
    ****************************/
    $params = array('bookName' => $bookName,
                    'book_id'  => $bid,
                    'author'   => $author,
                    'user_name'=> $user_name,
                    'fileSize' => $fileSize,
                    'typeEng'  => $typeEng,
                    'typeName' => $typeName,
                    'created'  => $created,
                    'book_id'  => $book_id,
                    'desc'     => $book[0]['decs'],
                    'burl'     => $url,
                    'cover'    => $bookFengmian,
                    'collect'  => $collect,
                    'page_count'=>$page_count,
                    'year_month'=>$year_month,
                    'day'       =>$day,
                    );
    $related = $this->related();
    $related_html = "";
    foreach ($related as $index => $rb) {
      $tmp = <<<END
      <li class="li_bg"><a href="/book/{$rb['burl']}.html">{$rb['name']}</a></li>
END;
      $related_html = $related_html . $tmp;
    }
    $this->mobile_info($params,$related_html);  //info
    $this->mobile_down($params,$related_html);  //down
    // $this->mobile_cache(); //content
    ////////////////////end mobile////////////////

    ///////=======    related
    $li = "";
    foreach ($related as $index => $rb) {
      $coverimg = "/img/nocover.jpg";
      if ($rb['fengmian_id']!=0) {
        $img = $this->Document($rb['fengmian_id']);
        if (isset( $img[0])) {
          $coverimg = $img[0]['link'];            
        }
      }
      
      $txt = $this->Document($rb['txt_id']);
      $bsize = "0";
      if (isset($txt[0])) {
        $bsize = $txt[0]['size'];
      }
      $li = $li . '<li><a href="/book/' . $rb['burl'] . '.html" target="_blank"><img src="' . $coverimg . '" alt="' . $rb['name'] . '(' . $this->formatSize($bsize) . ')"></a><br><a href="/book/' .  $rb['burl'] . '.html" target="_blank">' . $rb['name'] . '</a></li>';
    }
    $hhhtml = '<div class="info_samebook"><div class="main_t">相关书籍</div><ul>' . $li .  '</ul></div>';
 
    $related_part_filename = $book_dir_id . "related_" . $url . '.html';
    if (file_exists($related_part_filename)) {
      unlink($related_part_filename);
    }

    $f= @fopen($related_part_filename ,'w+');
    @fwrite($f,$hhhtml);
    @fclose($f);
    
    //////========    end related
    for ($i=1; $i <= $page_count; $i++) { 
      $cur_page = $i ;
      $second="";
      $first_page = 1;
      $prev_page = $i - 1;
      $next_page = $i + 1;
      $last_page = $page_count;
      $part_content  = $content_array[$cur_page-1];
      $part_content = nl2br(preg_replace('/ /','　',htmlentities($part_content,ENT_QUOTES | ENT_IGNORE,"UTF-8")));
      $suffix = "_分节阅读_$cur_page";
      $first_2 = <<<END
                        <a href="{$ziliao_url}">{$bookName}</a>{$suffix}
END;
      if ($cur_page > 1 and $cur_page < $last_page) {
        $second  = <<<END
                            {$part_content}
                            <div class="view_page">本文字数<b>{$count}</b>，每页显示<b>40000</b>字 <b>{$cur_page}/{$page_count}</b>页<br><a href="{$book_url_id}id_{$url}_{$first_page}.html">首页</a> <a href="{$book_url_id}id_{$url}_{$prev_page}.html">上一页</a> <a href="{$book_url_id}id_{$url}_{$next_page}.html">下一页</a> <a href="{$book_url_id}id_{$url}_{$last_page}.html">尾页</a></div>
                          </div>
END;
      }
      if ($cur_page == 1) {
        $second  = <<<END
                              {$part_content}
                              <div class="view_page">本文字数<b>{$count}</b>，每页显示<b>40000</b>字 <b>{$cur_page}/{$page_count}</b>页<br>首页 上一页 <a href="{$book_url_id}id_{$url}_{$next_page}.html">下一页</a> <a href="{$book_url_id}id_{$url}_{$last_page}.html">尾页</a></div>
                            </div>
END;
      }
      if ($cur_page == $page_count) {
        $second  = <<<END
                             {$part_content}
                            <div class="view_page">本文字数<b>{$count}</b>，每页显示<b>40000</b>字 <b>{$cur_page}/{$page_count}</b>页<br><a href="{$book_url_id}id_{$url}_{$first_page}.html">首页</a> <a href="{$book_url_id}id_{$url}_{$prev_page}.html">上一页</a> 下一页 尾页</div>
                          </div>
END;
      }
      
      /////////////////////start mobile/////////////////////
      $addon = array( 'suffix' => $suffix, 
                      'cur_page' => $cur_page,
                      'prev_page'=> $prev_page,
                      'next_page'=> $next_page,
                      'last_page'=> $last_page,
                      'page_count'=> $page_count
                    );
      $this->mobile_cache($params,$part_content,$addon); //content
      //////////////////////end mobile////////////////////
      
      
      $parts_location   = $book_dir_id . "id_" . $url . "_{$cur_page}.html";
      
      $part_cache = $first . $first_2 . $first_3 . $second . $third;
      if (file_exists($parts_location)) {
        unlink($parts_location);
      }
      
      $fpart = @fopen($parts_location ,'w+');
      @fwrite($fpart,$part_cache);
      @fclose($fpart);
      $this->updateField('books','pass',12,'bid',$book_id);
      
    }

  }
  public function mobile_info($book,$related_html)
  {
    //$bookName,$cover,$author,$type,$size,$desc
    // $params = array('bookName' => $bookName,
    //                 'book_id'  => $bid,
    //                 'author'   => $author,
    //                 'user_name'=> $user_name,
    //                 'fileSize' => $fileSize,
    //                 'typeEng'  => $typeEng,
    //                 'typeName' => $typeName,
    //                 'created'  => $created,
    //                 'book_id'  => $book_id,
    //                 'desc'     => xxx,
    //                 'burl'     => $url,
    //                 'cover'    => $bookFengmian,
    //                 'collect'  => $collect,
    //                 );

    $html1 = <<<END
  	<title> {$book['bookName']} - 我自习 - 免费TXT电子书下载|全本小说分享平台|手机小说下载-书籍列表</title>
    <div class="t3"><table><tbody><tr><td><a href="/">首页</a></td><td><a href="/listA0B0P1.html" id="A0">青春</a></td><td><a href="/listA1B0P1.html" id="A1">言情</a></td><td><a href="/listA2B0P1.html" id="A2">穿越</a></td><td><a href="/listA3B0P1.html" id="A3">武侠</a></td></tr><tr><td><a href="/listA4B0P1.html" id="A4">玄幻</a></td><td><a href="/listA5B0P1.html" id="A5">文学</a></td><td><a href="/listA6B0P1.html" id="A6">悬疑</a></td><td><a href="/listA7B0P1.html" id="A7">都市</a></td><td><a href="/listA8B0P1.html" id="A8">历史</a></td></tr><tr><td><a href="/listA9B0P1.html" id="A9">经管</a></td><td><a href="/hotplusP1.html" id="c_11">热门</a></td><td><a href="/newestP1.html" id="c_12">最新</a></td><td><a href="/allbooksP1.html">书房</a></td><td><a href="/rank.html">排行</a></td></tr></tbody></table></div>
    <div style="padding:3px"></div>
    <table class="title">
            <tbody>
                <tr>
                    <td class="w12">
                    </td>
                    <td id="BookName" class="fgreen">{$book['bookName']}</td>
                    <td class="w12">
                    </td>
                </tr>
            </tbody>
    </table>
    <table class="bookinfo">
            <tbody><tr>
                <td class="w12">
                </td>
                <td id="BookFaces" width="100px" class="center pdy12"><img src="{$book['cover']}" width="80px" height="112px"></td>

                <td class="pdy12">
                    <p id="Author"><em>作者:</em>{$book['author']}</p>
                    <p id="ClassName"><em>类别:</em>{$book['typeName']}</p>
                    <p id="FileSize"><em>大小:</em>{$book['fileSize']}</p>
                </td>
                <td class="w12">
                </td>
            </tr>
        </tbody>
    </table>
    <table>
            <tbody><tr>
                <td class="w12">
                </td>
                <td class="center">
                    <a href="/mbook/{$book['year_month']}/{$book['day']}/{$book['book_id']}/id_{$book['burl']}_1.html" id="views_s" class="btn_red">开始阅读</a>
                </td>
                <td class="center">
                    <a href="/down/id_{$book['burl']}.html" id="downa" class="btn_gray" target="_blank">下载书籍</a>
                </td>
                <td class="w12">
                </td>
            </tr>
        </tbody>
    </table>
    <div id="Content" class="pd12 bg2 mgt12 f13">[简介]{$book['desc']}.....</div>
    <div class="pdx12">
            <p class="f13 fc1">
                更新：<label id="UpdateDate" class="fc2">{$book['created']}</label>
            </p>
    </div>
    <table class="t4">
            <tbody><tr>
                <td>
                    --目录--
                </td>
            </tr>
        </tbody>
    </table>
    <ul id="viewsLi" class="lists chapter_list">
END;
    $html2 = "";
    for ($i=0; $i < $book['page_count']; $i++) {
      $index = $i + 1;
      $tmp = <<<END
      <li class="li_bg"> <a href="/mbook/{$book['year_month']}/{$book['day']}/{$book['book_id']}/id_{$book['burl']}_{$index}.html">{$book['bookName']}_分节阅读_{$index}</a> </li>
END;
      $html2 = $html2 . $tmp;
    }
    
    
    $html3 = <<<END
     <!-- <li class="li_bg"> <script language="javascript" src="/js/wapad.js"></script></li>-->
    </ul>
    <table class="title">
            <tbody>
                <tr>
                    <td class="w12">
                    </td>
                    <td>
                        相关书籍
                    </td>
                    <td class="w12">
                    </td>
                </tr>
            </tbody>
    </table>
    <ul id="xgbooklist" class="lists">{$related_html}</ul>  
    <div style="padding:3px"></div>
END;
    $html = $html1 . $html2 . $html3;
    
    //start filename
    $filename = MOBILEPATH . 'mbook/' . $book['burl'][0] . '/' . $book['burl'] . ".html";
    $firstdir = MOBILEPATH . "mbook/" ;
    if (!file_exists($firstdir)) {
      mkdir($firstdir);
      chmod($firstdir,0777);
    }
    $secondir = MOBILEPATH . 'mbook/' . $book['burl'][0] . '/';
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
  public function mobile_cache($book,$part_content,$addon)
  {
    // $params = array('bookName' => $bookName,
    //                 'author'   => $author,
    //                 'user_name'=> $user_name,
    //                 'fileSize' => $fileSize,
    //                 'typeEng'  => $typeEng,
    //                 'typeName' => $typeName,
    //                 'created'  => $created,
    //                 'book_id'  => $book_id,
    //                 'desc'     => xxx,
    //                 'burl'     => $url,
    //                 'cover'    => $bookFengmian,
    //                 'collect'  => $collect,
    //                 );
    // $addon = array( 'suffix' => $suffix, 
    //                 'cur_page' => $cur_page,
    //                 'prev_page'=> $prev_page,
    //                 'next_page'=> $next_page,
    //                 'last_page'=> $last_page,
    //                 'page_count'=> $page_count
    //               );
    $cur_page   = $addon['cur_page'];
    $prev_page  = $addon['prev_page'];
    $last_page  = $addon['last_page'];
    $page_count = $addon['page_count'];
    $next_page  = $addon['next_page'];
    
    $nav = "";
    $pager = "";
      if ($cur_page > 1 and $cur_page < $last_page) {
        $nav  = <<<END
        <table class="bg1 read_nav"><tbody><tr>
          <td id="currentPage" width="30%" class="center"><a href="/mbook/{$book['year_month']}/{$book['day']}/{$book['book_id']}/id_{$book['burl']}_{$addon['prev_page']}.html">上一页</a> </td>
          <td id="backbook1" width="40%" class="center"><a href="/book/{$book['burl']}.html">目　录</a></td>
          <td id="Next" width="30%" class="txtright pdx12"><a href="/mbook/{$book['year_month']}/{$book['day']}/{$book['book_id']}/id_{$book['burl']}_{$addon['next_page']}.html">下一页</a> </td>
        </tr></tbody></table>
END;
        $pager = <<<END
  <div class="pdx12 chapter_pager"><table><tbody><tr>
    <td id="currentPage1" width="30%" class="center"><a href="/mbook/{$book['year_month']}/{$book['day']}/{$book['book_id']}/id_{$book['burl']}_{$addon['prev_page']}.html">上一页</a> </td>
    <td id="backbook" width="30%" class="center"><a href="/book/{$book['burl']}.html">目　录</a></td>
    <td id="Next1" width="30%" class="center"><a href="/mbook/{$book['year_month']}/{$book['day']}/{$book['book_id']}/id_{$book['burl']}_{$addon['next_page']}.html">下一页</a> </td>
  </tr></tbody></table></div>
END;
      }
      if ($cur_page == 1) {
        $nav  = <<<END
        <table class="bg1 read_nav"><tbody><tr>
          <td id="backbook1" width="40%" class="center"><a href="/book/{$book['burl']}.html">目　录</a></td>
          <td id="Next" width="30%" class="txtright pdx12"><a href="/mbook/{$book['year_month']}/{$book['day']}/{$book['book_id']}/id_{$book['burl']}_{$addon['next_page']}.html">下一页</a> </td>
        </tr></tbody></table>
END;
        $pager = <<<END
  <div class="pdx12 chapter_pager"><table><tbody><tr>
    <td id="backbook" width="30%" class="center"><a href="/book/{$book['burl']}.html">目　录</a></td>
    <td id="Next1" width="30%" class="center"><a href="/mbook/{$book['year_month']}/{$book['day']}/{$book['book_id']}/id_{$book['burl']}_{$addon['next_page']}.html">下一页</a> </td>
  </tr></tbody></table></div>
END;
      }
      if ($cur_page == $page_count) {
        $nav  = <<<END
        <table class="bg1 read_nav"><tbody><tr>
          <td id="currentPage" width="30%" class="center"><a href="/mbook/{$book['year_month']}/{$book['day']}/{$book['book_id']}/id_{$book['burl']}_{$addon['prev_page']}.html">上一页</a> </td>
          <td id="backbook1" width="40%" class="center"><a href="/book/{$book['burl']}.html">目　录</a></td>
        </tr></tbody></table>
END;
        $pager = <<<END
  <div class="pdx12 chapter_pager"><table><tbody><tr>
    <td id="currentPage1" width="30%" class="center"><a href="/mbook/{$book['year_month']}/{$book['day']}/{$book['book_id']}/id_{$book['burl']}_{$addon['prev_page']}.html">上一页</a> </td>
    <td id="backbook" width="30%" class="center"><a href="/book/{$book['burl']}.html">目　录</a></td>
  </tr></tbody></table></div>
END;

      }
     
    
    $html = <<<END
    <!--?xml version="1.0" encoding="UTF-8" ?-->
    <!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml"><head>
    	<title> {$book['bookName']}  - 我自习 - 免费TXT电子书下载|全本小说分享平台|手机小说下载-书籍列表</title>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  <meta name="keywords" content="{$book['bookName']},我自习,52书房,免费小说,TXT小说下载,全本小说,TXT下载,TXT手机电子书,TXT小说,电子书,电子书籍,书库,图书,书,书籍,电子书下载,免费电子书">
      <meta name="description" content="TXT全本电子书分享网站-免费上传、下载、阅读。">
      <meta name="MobileOptimized" content="320">
      <meta name="format-detection" content="telephone=no">
      <meta name="viewport" content="width=320,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
      <link rel="stylesheet" href="/css/mobile.css" type="text/css" media="screen" charset="utf-8">
      <script type="text/javascript" src="/js/jquery.js" charset="utf-8"></script>
      <script>
      var _hmt = _hmt || [];
      (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?f70387f3963cf6467e17796a2e73c958";
        var s = document.getElementsByTagName("script")[0]; 
        s.parentNode.insertBefore(hm, s);
      })();
      </script>
    </head>
    <body>
          	<div id="container">
          		<div id="header">
                <table id="user_zone" class="t2">
                    <tbody>
                        <tr>
                            <td class="w12">
                            </td>
                            <td align="left">
                                我自习手机版
                            </td>
                            <td align="right">
                               m.5zixi.cn
                            </td>
                            <td class="w12">
                            </td>
                        </tr>
                    </tbody>
                  </table>
          		</div>
          		<div id="content">
          			<div class="t3">
                  <table><tbody><tr><td><a href="/">首页</a></td><td><a href="/listA0B0P1.html" id="A0">青春</a></td><td><a href="/listA1B0P1.html" id="A1">言情</a></td><td><a href="/listA2B0P1.html" id="A2">穿越</a></td><td><a href="/listA3B0P1.html" id="A3">武侠</a></td></tr><tr><td><a href="/listA4B0P1.html" id="A4">玄幻</a></td><td><a href="/listA5B0P1.html" id="A5">文学</a></td><td><a href="/listA6B0P1.html" id="A6">悬疑</a></td><td><a href="/listA7B0P1.html" id="A7">都市</a></td><td><a href="/listA8B0P1.html" id="A8">历史</a></td></tr><tr><td><a href="/listA9B0P1.html" id="A9">经管</a></td><td><a href="/hotplusP1.html" id="c_11">热门</a></td><td><a href="/newestP1.html" id="c_12">最新</a></td><td><a href="/allbooksP1.html">书房</a></td><td><a href="/rank.html">排行</a></td></tr></tbody></table>
                </div><div style="padding:3px"></div>
                <div class="read_content">
                  {$nav}
                  <div class="pdx12 mgt12">
                      <table>
                          <tbody>
                              <tr>
                                  <td>
                          <a id="bg_day" href="javascript:;" class="fb">白天</a> <a id="bg_night" href="javascript:;">黑夜</a>
                                  </td>
                                  <td class="txtright">
                                      <a id="fs_f24" href="javascript:;">大</a> <a id="fs_f20" href="javascript:;" class="fb">中</a> <a id="fs_f16" href="javascript:;">小</a>
                                  </td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
                  <div class="chapter_content pd12">
                      <h1 id="BookName">{$book['bookName']}_{$addon['suffix']}</h1>
                      <span id="Content" class="f20">
                      <!--======================================================================================-->
                      <!--======================================================================================-->            
                      {$part_content}
                      </span>
                  </div>
                  {$pager}
                </div>
                
                <div style="padding:3px"></div>      <div class="index_log" style="text-align: center;">
     <!-- 广告位：首页右边第一个 -->
     <script type="text/javascript">
     document.write('<a style="display:none!important" id="tanx-a-mm_46924635_4290951_14546072"></a>');
     tanx_s = document.createElement("script");
     tanx_s.type = "text/javascript";
     tanx_s.charset = "gbk";
     tanx_s.id = "tanx-s-mm_46924635_4290951_14546072";
     tanx_s.async = true;
     tanx_s.src = "http://p.tanx.com/ex?i=mm_46924635_4290951_14546072";
     tanx_h = document.getElementsByTagName("head")[0];
     if(tanx_h)tanx_h.insertBefore(tanx_s,tanx_h.firstChild);
</script> 
<script src="http://a.alimama.cn/inf.js" type="text/javascript"></script>  

 </div>
 
                <div class="mini_footer">
                        <table>
                            <tbody><tr>
                                <td width="50%">
                                    ©我自习
                                </td>
                                <td width="50%" class="txtright">
                                    <a href="#top">回顶部↑</a>
                                </td>
                            </tr>
                        </tbody></table>
                </div>
              </div>
    	      </div>
            <script type="text/javascript" charset="utf-8">

            $(document).ready(function(){	
            	  $("#bg_day").click(function(){ d(0);});
                $("#bg_night").click(function(){ d(1); });
                $("#fs_f24").click(function(){ e(1); });
            		$("#fs_f20").click(function(){ e(0); });
                $("#fs_f16").click(function(){ e(2); }); 
            });
            function d(a) {
                "1" == a ? ($("div.read_content").addClass("night"), $("#bg_day").removeClass("fb"), $("#bg_night").addClass("fb")) : ($("div.read_content").removeClass("night"), $("#bg_day").addClass("fb"), $("#bg_night").removeClass("fb"))
            }
            function e(a) {
            		    a = parseInt(a);
            		    switch (a) {
            		        case 1: a = "f24";
            		            break;
            		        case 2: a = "f16";
            		            break;
            		        default: a = "f20"
            		    }
            		    $("div.chapter_content span").removeClass().addClass(a);
            		    $("#fs_" +
            			a).addClass("fb").siblings("a").removeClass("fb")
            };
            </script>
            <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-19281868-15', '5zixi.cn');
            ga('send', 'pageview');

            </script>
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fa1743ee8a92f13d7821f7b114c7f58e1' type='text/javascript'%3E%3C/script%3E"));
</script>
<script src="http://p.qiyou.com/view.php?uid=23422"></script>
    </body></html>
END;
        //start filename
        $filename = MOBILEBOOK . $book['year_month'] . '/' . $book['day'] . '/' . $book['book_id'] . '/id_' .  $book['burl'] . "_"  .  $cur_page . ".html";
        $firstdir = MOBILEBOOK . $book['year_month'] . '/' ;
        if (!file_exists($firstdir)) {
          mkdir($firstdir);
          chmod($firstdir,0777);
        }
        $secondir = MOBILEBOOK . $book['year_month'] . '/' . $book['day'] . '/';
        if (!file_exists($secondir)) {
          mkdir($secondir);
          chmod($secondir,0777);
        }
        $thirdir = MOBILEBOOK . $book['year_month'] . '/' . $book['day'] . '/' . $book['book_id'] . '/';
        if (!file_exists($thirdir)) {
          mkdir($thirdir);
          chmod($thirdir,0777);
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
  
  public function mobile_down($book,$related_html)
  {
    $html = <<<END
    <div class="t3"><table><tbody><tr><td><a href="/">首页</a></td><td><a href="/listA0B0P1.html" id="A0">青春</a></td><td><a href="/listA1B0P1.html" id="A1">言情</a></td><td><a href="/listA2B0P1.html" id="A2">穿越</a></td><td><a href="/listA3B0P1.html" id="A3">武侠</a></td></tr><tr><td><a href="/listA4B0P1.html" id="A4">玄幻</a></td><td><a href="/listA5B0P1.html" id="A5">文学</a></td><td><a href="/listA6B0P1.html" id="A6">悬疑</a></td><td><a href="/listA7B0P1.html" id="A7">都市</a></td><td><a href="/listA8B0P1.html" id="A8">历史</a></td></tr><tr><td><a href="/listA9B0P1.html" id="A9">经管</a></td><td><a href="/hotplusP1.html" id="c_11">热门</a></td><td><a href="/newestP1.html" id="c_12">最新</a></td><td><a href="/allbooksP1.html">书房</a></td><td><a href="/rank.html">排行</a></td></tr></tbody></table></div>
    <div style="padding:3px"></div>
    <table class="t4"><tbody><tr><td id="BookName"><a href="/book/{$book['burl']}.html">{$book['bookName']}</a>下载地址</td></tr></tbody></table>
    <ul class="lists chapter_list">
            <li class="li_bg"><a href="/download/{$book['burl']}" id="downa1" target="_blank">TXT本地下载</a></li>
            <li class="li_bg"><a href="/baiduyun/{$book['burl']}" id="downa2" target="_blank">百度云下载</a></li>
    </ul><a name="author_book"></a><div style="padding:3px"></div>
    <table class="title"><tbody><tr><td class="w12"></td><td>相关书籍</td><td class="w12"></td></tr></tbody></table>
    <ul id="xgbooklist" class="lists">{$related_html}</ul>
END;
    
    //start filename
    $filename = MOBILEPATH . 'down/' . $book['burl'][0] . '/' . $book['burl'] . ".html";
    $firstdir = MOBILEPATH . "down/" ;
    if (!file_exists($firstdir)) {
      mkdir($firstdir);
      chmod($firstdir,0777);
    }
    $secondir = MOBILEPATH . 'down/' . $book['burl'][0] . '/';
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

}
