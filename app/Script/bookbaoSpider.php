<?php
require_once('simplehtmldom.php');
ini_set ('memory_limit', '800M');
date_default_timezone_set('Asia/Shanghai');
$list = array('青春', '言情','穿越','武侠','玄幻','文学','悬疑','都市','历史','经管');
$BASE_URL1 = "http://www.bookbao.com/booklist-p_";
$BASE_URL1_5 = "-t_0-o_0.html";
$BASE_URL2 = "http://www.bookbao.com/QuanBook/List_1.html";
// $filecounter = 70789;
$filecounter =100983;
// $filecounter = 51464;
$limit0 = 10;
$limit1 = 50;
$limit2 = 76;
$default = array(
	'datasource' => 'Database/Mysql',
	'persistent' => false,
	'host' => 'localhost',
	'login' => 'root',
	'password' => 'jknlff8-pro-17m7755',
	'database' => 'shufang',
	'prefix' => '',
  'encoding' => 'utf8',
);

$html = new simple_html_dom();
$mhtml = new simple_html_dom();
for ($i=5; $i <= 5; $i++) { 
// for ($i=10; $i <= $limit0; $i++) { 
  $xxxxxx = 1;
  if ($i == 7) {
    $xxxxxx = 37;
  }
  if ($i == 9) {
    $xxxxxx = 44;
  }
  if ($i == 8) {
    $xxxxxx = 34;
  }
  
  if ($i == 10) {
    $xxxxxx = 25;
  }
  if ($i == 5) {
    $xxxxxx = 42;
  }
  
  for ($j=$xxxxxx; $j < $limit1; $j++) { 
    $url = $BASE_URL1 . $j . "-c_" . $i . $BASE_URL1_5;
    unset($html);
    $html = new simple_html_dom();
    $html->load_file($url);
    $ele = $html->find('.list_div ul li');
    try {
      $test = 0;
      while(!is_array($ele)) {
        sleep(120);
        print_r($url);
        print_r($ele);
        unset($html);
        $html = new simple_html_dom();
        $html->load_file($url);
        print_r($html->plaintext);
        $ele = $html->find('.list_div ul li');
        print_r($ele);
        $test ++ ;
        if ($test > 10) {
          break;
        }
      }
      
      foreach ($ele as $li) {
        echo $filecounter . ".";
        $txt = $li->innertext;
        // echo $txt;
        // echo iconv("GB2312","UTF-8//IGNORE",$txt);
        $link = $li->find('a', 0)->href;
        $bookname = @iconv("GB2312","UTF-8//IGNORE",$li->find('.bookname', 0)->plaintext);
        // print_r($bookname);
        $img = $li->find('.list_img', 0)->src;
        $author = @iconv("GB2312","UTF-8//IGNORE",$li->find('.txt span', 0)->plaintext);
        // print_r($author);
        $type = $list[$i-1];
        // echo "\n";
        // break;
        // continue;
        // echo $link . "\n";
        // echo $bookname . "\n";
        // echo $img . "\n";
        // echo $author . "\n";
        $bid = explode('/',$link);
        $bid = explode('.',substr($bid[6],3));
        $bid = $bid[0];
        $mlink = str_replace('www.','m.',$link);
        // echo $mlink;
        $mhtml->load_file($mlink);
        // print_r($mhtml);
        $desc = "";
      
        $mcontent = $mhtml->find('#Content',0);
        if ($mcontent != "") {
          $desc = mb_substr($mcontent->plaintext,8);
        }  
      
        // echo $desc;
        echo "*";
        $download_link = "http://down2.bookbao.com/UserDown.aspx?id={$bid}&rnd=" . date('YmdHis',time());
        download($img,$filecounter);
        download($download_link,$filecounter,'txt');
        echo "#";
        //////mysql
          $db = new PDO('mysql:host=' . $default['host'] . ';dbname=' . $default['database'] . ';charset=utf8', $default['login'], $default['password'], array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
          try {
            $result = $db->prepare("INSERT INTO tmp (id,name,author,type,decs,fileid,created) VALUES (NULL,?,?,?,?,?,NOW())");
            $result->execute(array($bookname,$author,$type,$desc,$filecounter));
            // return $insertId = $db->lastInsertId();
          } catch(PDOException $ex) {
            echo "INSERT Err" ;
            print_r($ex);
          }
        //////
        echo "@";
        $filecounter ++ ;
        // $html->clear();
      }
    } catch (Exception $e) {
      print_r($e);
      sleep(120000);
    }
    $html->clear(); 
    // unset($html);
  }
}


for ($i=1; $i < $limit2; $i++) { 
  
}




function is_iterable($var)
{
    return $var !== null 
        && (is_array($var) 
            || $var instanceof Iterator 
            || $var instanceof IteratorAggregate
            );
}

function download($url,$id,$extx="")
{
  set_time_limit(0);
  $ext = $extx;
  if ($ext =="") {
    $ext = basename($url);
    $ext = explode('.',$ext);
    $ext = $ext[1];
  }
  $filename = dirname(__FILE__) . "/../tmp/books/{$id}.{$ext}";
  if (file_exists($filename)) {
    unlink($filename);
  }
  $fp = fopen($filename, 'w+');
  $ch = curl_init(str_replace(" ","%20",$url));
  
  curl_setopt($ch, CURLOPT_TIMEOUT, 100);
  curl_setopt ($ch, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
  curl_setopt($ch, CURLOPT_FILE, $fp);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_exec($ch);
  curl_close($ch);
  fclose($fp);
}


?>