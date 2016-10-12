<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
class BooksController extends AppController {

	public $components = array('Paginator','RequestHandler');
  public $helpers = array('Js');
  public $uses = array('Document','User','Book','Rank','Bookreply','Collect','Search');
	public function index() {
		$this->Book->recursive = 0;
		$this->set('books', $this->Paginator->paginate());
	}

	public function view($id = null) {
		if (!$this->Book->exists($id)) {
			throw new NotFoundException(__('Invalid book'));
		}
		$options = array('conditions' => array('Book.' . $this->Book->primaryKey => $id));
		$this->set('book', $this->Book->find('first', $options));
	}
  
  public function ajaxcheck()
  {
    $this->autoRender = false;
    $name = $this->request->query['book'];
    $books = $this->Book->findByName($name);
    if (empty($books)) {
      return "NULL";
    }
    return "OK";
  }
	public function upload() {
    $this->set('title_for_layout','贡献小说');
		if ($this->request->is('post')) {

      if ($this->request->data['txtdoc'] == "-1") {
				$this->Session->setFlash("尚未上传书籍");
				return $this->redirect('/upload');
      }
      $cur = $this->current_user();
      $txtdoc = $this->Document->findByDid($this->request->data['txtdoc']);
      if (empty($txtdoc) or $txtdoc['Document']['uid'] != $cur['User']['uid']) {
				$this->Session->setFlash("尚未上传书籍");
				return $this->redirect('/upload');
      }
      if ($this->request->data['imgdoc'] == -1) {
        $data['Book']['fengmian_id'] = 0;
      }else{
        $data['Book']['fengmian_id'] = $this->request->data['imgdoc'];
      }      
      
      if ( $this->request->data['bname']=="" or $this->request->data['bauthor'] == "" or $this->request->data['bclass'] =="" or  $this->request->data['bdesc'] =="") {
				$this->Session->setFlash("请填写内容");
				return $this->redirect('/upload');
      }
      $data['Book']['uid'] = $cur['User']['uid'];
      $data['Book']['name'] = Sanitize::html($this->request->data['bname']);
      $data['Book']['author'] = Sanitize::html($this->request->data['bauthor']);
      $data['Book']['type'] = $this->request->data['bclass'];
      $data['Book']['decs'] = Sanitize::html($this->request->data['bdesc']);
      $data['Book']['txt_id'] = $this->request->data['txtdoc'];
      $data['Book']['status'] = $this->request->data['bstatus'] == 'Y' ? 'Y' : 'N';
      $this->Book->create();
			if ($this->Book->save($data)) {
        $this->Document->id = $this->request->data['txtdoc'];
        $this->Document->saveField('bid',$this->Book->id);
        $this->Document->id = $this->request->data['imgdoc'];
        $this->Document->saveField('bid',$this->Book->id);
        //上传分数
        $this->User->id = $cur['User']['uid'];
        $this->User->saveField('uploads',$cur['User']['uploads']+1);
        $this->updateRank($cur['User']);
        
        
				$this->Session->setFlash(__('您已上传等待审核'));
				return $this->redirect('/home/books');
			} else {
				$this->Session->setFlash(__('系统错误，请稍后重试。'));
			}
	  }
    if (isset($this->request->query['bid'])) {
      $this->set('thebook',$this->Book->find('first', array('recursive'=>-1,'conditions' => array('Book.bid' => $this->request->query['bid']))) );
    }
		$users = $this->Book->User->find('list');
		$this->set(compact('users'));
	}
  public function updateRank($user)
  {
    $this->Rank->recursive = -1;
    $rank = $this->Rank->find('first',array('conditions'=>array('Rank.cid'=>$user['class_id'])));
    $min = $rank['Rank']['min'];
    $max = $rank['Rank']['max'];
    if ($user['uploads'] + 1 > $min && $user['uploads']+1 <= $max ) {
      return;
    }
    $ranks = $this->Rank->find('all');
    $newrank_id = $rank['Rank']['cid'];
    $idx = 0;
    foreach ($ranks as $index => $rr) {
      if ($rr['Rank']['cid'] == $rank['Rank']['cid']) {
        $idx = $index;
      }
    }
    $idx = $idx+1;
    
    $newrank_id = $ranks[$idx]['Rank']['cid'];
    $this->User->id = $user['uid'];
    $this->User->saveField('class_id',$newrank_id);
    return;
  }
  public function upload_documents()
  {
    $this->autoRender = false;
    
    if (!$this->islogin()) {
      $this->HandleError("login");
      exit(0);
    }
    
    // if (!isset($_POST["PHPSESSID"])) {
    //       $this->HandleError("unset");
    //       exit(0);
    // }

    
  	$POST_MAX_SIZE = ini_get('post_max_size');
  	$unit = strtoupper(substr($POST_MAX_SIZE, -1));
  	$multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ? 1073741824 : 1)));

  	if ((int)$_SERVER['CONTENT_LENGTH'] > $multiplier*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
  		header("HTTP/1.1 500 Internal Server Error"); 
  		echo "文件过大。";
  		exit(0);
  	}
    $tt = time();
		$dir_name =  date("Ym",$tt);
    $dir_path = "/files/books/$dir_name/";
    $save_path = getcwd() . $dir_path;			
		if (!file_exists($save_path)) {
			mkdir($save_path);
      chmod($save_path,0777);
		}
    $day_name = date('d',$tt);
    $dir_path = $dir_path . $day_name . "/";
    $save_path = getcwd() . $dir_path;			 
		if (!file_exists($save_path)) {
			mkdir($save_path);
      chmod($save_path,0777);
		}
    
  	$upload_name = "Filedata";
  	$max_file_size_in_bytes = 209715200;			
  	$extension_whitelist = array("txt","jpg", "gif", "png");	
  	$valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-';	
	
    // Other variables
  	$MAX_FILENAME_LENGTH = 260;
  	$file_name = "";
  	$file_extension = "";
  	$uploadErrors = array(
          0=>"上传成功。",
          1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini",
          2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
          3=>"The uploaded file was only partially uploaded",
          4=>"No file was uploaded",
          6=>"Missing a temporary folder"
  	);


  // Validate the upload
  	if (!isset($_FILES[$upload_name])) {
  		$this->HandleError("No upload found in \$_FILES for " . $upload_name);
  		exit(0);
  	} else if (isset($_FILES[$upload_name]["error"]) && $_FILES[$upload_name]["error"] != 0) {
  		$this->HandleError($uploadErrors[$_FILES[$upload_name]["error"]]);
  		exit(0);
  	} else if (!isset($_FILES[$upload_name]["tmp_name"]) || !@is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
  		$this->HandleError("Upload failed is_uploaded_file test.");
  		exit(0);
  	} else if (!isset($_FILES[$upload_name]['name'])) {
  		$this->HandleError("File has no name.");
  		exit(0);
  	}
	
  // Validate the file size (Warning: the largest files supported by this code is 2GB)
  	$file_size = @filesize($_FILES[$upload_name]["tmp_name"]);
  	if (!$file_size || $file_size > $max_file_size_in_bytes) {
  		$this->HandleError("File exceeds the maximum allowed size");
  		exit(0);
  	}
	  
  	if ($file_size <= 0) {
  		$this->HandleError("File size outside allowed lower bound");
  		exit(0);
  	}

  // Validate file extension
  	$path_info = pathinfo($_FILES[$upload_name]['name']);
  	$file_extension = strtolower($path_info["extension"]);
  	$is_valid_extension = false;
  	foreach ($extension_whitelist as $extension) {
  		if (strcasecmp($file_extension, $extension) == 0) {
  			$is_valid_extension = true;
  			break;
  		}
  	}
  	if (!$is_valid_extension) {
  		$this->HandleError("Invalid file extension");
  		exit(0);
  	}
  // Validate file name (for our purposes we'll just remove invalid characters)
		$origin_file_name = $this->get_basename($_FILES[$upload_name]['name']);
		$cur = $this->current_user();
		$file_name = $cur['User']['uid'] . date("Ymd_His") . rand(10000,20000) . '.' . $file_extension;
    
  	if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
  		$this->HandleError("Invalid file name");
  		exit(0);
  	}


  // Validate that we won't over-write an existing file
  	if (file_exists($save_path . $file_name)) {
  		$this->HandleError("File with this name already exists");
  		exit(0);
  	}

  	if (!@move_uploaded_file($_FILES[$upload_name]["tmp_name"], $save_path . $file_name)) {
  		$this->HandleError("File could not be saved.");
  		exit(0);
  	}
    $data['Document']['uid'] = $cur['User']['uid'];
    $data['Document']['location'] = $save_path . $file_name ;
    $data['Document']['origin'] = $origin_file_name;
    $data['Document']['link'] = $dir_path . $file_name;
    $data['Document']['type'] = $file_extension;
    $data['Document']['size'] = $file_size;
    $this->Document->create();
    if ($this->Document->save($data)) {
      $did = $this->Document->id;
      return $did;
    }
    return "-1";
  	exit(0);
  }
	function get_basename($filename){  
    	return preg_replace('/^.+[\\\\\\/]/', '', $filename);  
 	} 
  function HandleError($message) {
  	echo $message;
  }
	public function edit($id = null) {
    $this->set('title_for_layout','编辑');
    if (!$this->islogin()) {
      $this->Session->setFlash(__('请先登录'));
      return $this->redirect('/');
    }
    $cur = $this->current_user();
		if (!$this->Book->exists($id)) {
			throw new NotFoundException(__('Invalid book'));
		}
		$options = array('conditions' => array('Book.' . $this->Book->primaryKey => $id));
		$book = $this->Book->find('first', $options);
    if (!$this->isAdmin() || $book['Book']['uid'] != $cur['User']['uid'] ) {
      $this->Session->setFlash(__('无权访问该书'));
      return $this->redirect('/');
    }
    
		if ($this->request->is(array('post', 'put'))) {
      $data['Book']['name'] = $this->request->data['bname'];
      $data['Book']['author'] = $this->request->data['bauthor'];
      $data['Book']['type'] = $this->request->data['bclass'];
      $data['Book']['decs'] = $this->request->data['bdesc'];
      $this->Book->id = $id;
			if ($this->Book->save($data)) {
				$this->Session->setFlash(__('编辑成功.'));
				return $this->redirect('/home/books');
			} else {
				$this->Session->setFlash(__('无法编辑。'));
			}
		} else {
			$options = array('conditions' => array('Book.' . $this->Book->primaryKey => $id));
			$this->request->data = $this->Book->find('first', $options);
		}
		$users = $this->Book->User->find('list');
		$this->set(compact('users'));
	}

  // public function delete($id = null) {
  //   $this->Book->id = $id;
  //   if (!$this->Book->exists()) {
  //     throw new NotFoundException(__('Invalid book'));
  //   }
  //   $this->request->onlyAllow('post', 'delete');
  //   if ($this->Book->delete()) {
  //     $this->Session->setFlash(__('The book has been deleted.'));
  //   } else {
  //     $this->Session->setFlash(__('The book could not be deleted. Please, try again.'));
  //   }
  //   return $this->redirect(array('action' => 'index'));
  // }

	public function admin_index() {
    $this->layout = 'admin';
		$this->Book->recursive = 0;
    $this->Paginator->settings = array('limit'=>40,'order'=>'Book.created DESC');
    $books = $this->Paginator->paginate('Book');
		$this->set('books', $books);
	}
  public function admin_pass()
  {
    $this->autoRender = false;
    if (!($this->request->is('ajax') || $this->request->is('post')) ) {
      return "ERR";
    }
    $book_id = $this->request->data['id'];
		if (!$this->Book->exists($book_id)) {
			throw new NotFoundException(__('Invalid book'));
		}
    $this->Book->recursive = 0;
   
    $book = $this->Book->read(null,$book_id);

    //积分增加
    $this->User->id = $book['Book']['uid'];
    $this->User->saveField('credits',$book['User']['credits'] + 5);
    
    // CakeResque::enqueueIn(
    //     1800,
    //     'default',
    //     'RecommandJob',
    //     array('related',$book_id)
    // );
    
    require_once ROOT . DS . 'app/Vendor/Resque/autoload.php';
    Resque::setBackend('redis://61e0c1510b2111e5:98398110Gslipt@61e0c1510b2111e5.m.cnqda.kvstore.aliyuncs.com:6379');
    
    $bid=$book['Book']['bid'];
    $did=$book['txt']['did'];
    
    $JobId = Resque::enqueue('jobs','BooksJob', compact('bid','did'), true);
   
    
    // echo "The job id is : ", $JobId , PHP_EOL;
    $this->Book->id = $book_id;
    if ($this->Book->saveField('jobid',$JobId) && $this->Book->saveField('pass',11)) {
      return 'OK';
    }
    return 'ERR';
  }
  public function admin_deny()
  {
    $this->autoRender = false;
    if (!($this->request->is('ajax') || $this->request->is('post'))) {
      return "ERR";      
    }
    $book_id = $this->request->data['id'];
		if (!$this->Book->exists($book_id)) {
			 return "ERR";
		}

    $this->Book->id = $book_id;
    if ($this->Book->saveField('pass',1)) {
      return 'OK';
    }
    return 'ERR';
  }
  public function admin_recommend()
  {
    $this->autoRender = false;
    if (!($this->request->is('ajax') && $this->request->is('post'))) {
      return "ERR";
    }
    $book_id = $this->request->data['id'];
		if (!$this->Book->exists($book_id)) {
			throw new NotFoundException(__('Invalid book'));
		}
    $this->Book->recursive = 0;
   
    $book = $this->Book->read(null,$book_id);
    if ($book['Book']['pass']<=11) {
      return "ERR";
    }
    $this->Book->id = $book_id;
    if ($this->Book->updateAll(array('Book.recommend'=>$book['Book']['recommend'] + 0.2,'Book.pass'=>22),array('Book.bid'=>$book_id)))     {
      return 'OK';
    }
    return 'ERR';
  }
  public function admin_download($id=null)
  {
    $this->autoRender = false;
		if (!$this->Document->exists($id)) {
			throw new NotFoundException(__('Invalid book'));
		}
		$options = array('conditions' => array('Document.' . $this->Document->primaryKey => $id));
		$doc = $this->Document->find('first', $options);
    $file = $doc['Document']['location'];
    $filename = preg_replace("([^\w\s\d\-_~,;:\[\]\(\]]|[\.]{2,})", '', $doc['Book']['name']) . ".txt";
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='. $filename);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        $this->Document->set(array('downloads' => ($doc['Document']['downloads'] + 1) ));
        $this->Document->save();
        exit;
    }
  }
  public function collect()
  {
    $this->autoRender = false;
    if (!$this->islogin()) {
      return "Login";
    }
    if (!$this->request->is('post')) {
      return "ERR";
    }
    $cur = $this->current_user();
    $this->Collect->create();
    $data['Collect']['bid'] = $this->request->data['bid'];
    $data['Collect']['uid'] = $cur['User']['uid'];
    $count = $this->Collect->find('count',array('conditions'=>array('Collect.uid'=>$data['Collect']['uid'])));
    // if ($count >30) {
    //   return "OVER";
    // }
    
    $this->Book->id = $data['Collect']['bid'];
    $book = $this->Book->read(null,$data['Collect']['bid']);
    $this->Book->saveField('collect',$book['Book']['collect'] + 1);
    if ($this->Collect->save($data)) {
      return "OK";
    }
    return "ERR";
  }

	public function download($url="")
	{
    $this->autoRender = false;
    $book = $this->Book->findByBurl($url);
    if (empty($book)) {
      throw new NotFoundException(__('不存在该书'));
      return;
    }
    if ($book['Book']['pass'] < 12) {
       throw new NotFoundException(__('不存在该书'));
      return;
    }
    $id = $book['Book']['txt_id'];
    // if (!$this->islogin()) {
    //   $this->Session->setFlash('请登录！');
    //   $this->redirect('/signin');
    //   return;
    // }
    if (!is_numeric($id)) {
      $this->Session->setFlash('非法访问！');
      $this->redirect('/');
      return;
    }
		if (!$this->Document->exists($id)) {
			throw new NotFoundException(__('Invalid book'));
		}
    $this->Document->recursive = 0;
    $doc = $this->Document->read(null,$id);
    if ($doc['Book']['pass'] < 10 ) {
      $this->Session->setFlash('非法访问！');
      $this->redirect('/');
      return;
    }
    $file = $doc['Document']['location'];
    $filename = str_replace(',','',str_replace(".",'',str_replace(".",'',$doc['Book']['name'])))  . "5zixi.cn.txt" ;
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='. $filename);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        // $this->Document->set(array('downloads' => ($doc['Document']['downloads'] + 1) ));
        // $this->Document->save();
        $this->Book->id = $book['Book']['bid'];
        $this->Book->saveField('downloads',$book['Book']['downloads'] + 1);
        // //积分减少
        // $this->User->id = $book['Book']['uid'];
        // $this->User->saveField('credits',$book['User']['credits'] - 1 );
        exit;
    }
	}
  public function downloadBaidu($url='')
  {
    $this->autoRender = false;
    // if (!$this->islogin()) {
    //   $this->Session->setFlash('请登录！');
    //   $this->redirect('/signin');
    //   return;
    // }
    $book = $this->Book->findByBurl($url);
    if (empty($book)) {
      throw new NotFoundException(__('不存在该书'));
      return;
    }
    if ($book['Book']['pass'] < 12) {
       throw new NotFoundException(__('不存在该书'));
      return;
    }
    $id = $book['Book']['txt_id'];

    if (!is_numeric($id)) {
      $this->Session->setFlash('非法访问！');
      $this->redirect('/');
      return;
    }
		if (!$this->Document->exists($id)) {
			throw new NotFoundException(__('Invalid book'));
		}
    $this->Document->recursive = 0;
    $doc = $this->Document->read(null,$id);
    
    $link = $doc['Document']['link'];

    require_once __DIR__ . '/Job/BaiduYun/BaiduPCS.class.php';
    $access_token = '23.1a63493452c4bcd2c099399f0c150e8f.2592000.1389342279.2252123692-1490235';
    $appName = '52shufang';
    $root_dir = '/apps' . '/' . $appName . '/';
    $link = substr($link,7);

    $path = $root_dir . $link;
    
    $this->Book->id = $book['Book']['bid'];
    $this->Book->saveField('downloadsweekly',$book['Book']['downloadsweekly'] + 1);
    $filename = str_replace(',','',str_replace(".",'',str_replace(".",'',$doc['Book']['name']))) . "5zixi.cn 我自习&nbsp;52书房52shufang.com." . $doc['Document']['type'];
    $downlink = 'https://pcs.baidu.com/rest/2.0/pcs/file?method=download&access_token=' . $access_token . '&path=' . $path;
    header('Content-Description: File Transfer');
    header('Content-Disposition:attachment;filename="' . $filename . '"');
    header('Content-Type:application/octet-stream');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    ob_clean();
    flush();
    readfile($downlink);
    exit;
    
    // $pcs = new BaiduPCS($access_token);
    // $filename = str_replace(',','',str_replace(".",'',str_replace(".",'',$doc['Book']['name']))) . "52书房52shufang.com." . $doc['Document']['type'];
    // header('Content-Disposition:attachment;filename="' . $filename . '"');
    // header('Content-Type:application/octet-stream');
    // $result = $pcs->download($path);
    // echo $result;
  }
  // public function admin_view($id = null) {
  //   if (!$this->Book->exists($id)) {
  //     throw new NotFoundException(__('Invalid book'));
  //   }
  //   $options = array('conditions' => array('Book.' . $this->Book->primaryKey => $id));
  //   $this->set('book', $this->Book->find('first', $options));
  // }

  // public function admin_add() {
  //   if ($this->request->is('post')) {
  //     $this->Book->create();
  //     if ($this->Book->save($this->request->data)) {
  //       $this->Session->setFlash(__('The book has been saved.'));
  //       return $this->redirect(array('action' => 'index'));
  //     } else {
  //       $this->Session->setFlash(__('The book could not be saved. Please, try again.'));
  //     }
  //   }
  //   $users = $this->Book->User->find('list');
  //   $this->set(compact('users'));
  // }

  // public function admin_edit($id = null) {
  //   if (!$this->Book->exists($id)) {
  //     throw new NotFoundException(__('Invalid book'));
  //   }
  //   if ($this->request->is(array('post', 'put'))) {
  //     if ($this->Book->save($this->request->data)) {
  //       $this->Session->setFlash(__('The book has been saved.'));
  //       return $this->redirect(array('action' => 'index'));
  //     } else {
  //       $this->Session->setFlash(__('The book could not be saved. Please, try again.'));
  //     }
  //   } else {
  //     $options = array('conditions' => array('Book.' . $this->Book->primaryKey => $id));
  //     $this->request->data = $this->Book->find('first', $options);
  //   }
  //   $users = $this->Book->User->find('list');
  //   $this->set(compact('users'));
  // }
  
  function search_split_terms($terms){

		$terms = preg_replace("/\"(.*?)\"/e", "search_transform_term('\$1')", $terms);
		$terms = preg_split("/\s+|,/", $terms);

		$out = array();

		foreach($terms as $term){

			$term = preg_replace("/\{WHITESPACE-([0-9]+)\}/e", "chr(\$1)", $term);
			$term = preg_replace("/\{COMMA\}/", ",", $term);

			$out[] = $term;
		}

		return $out;
	}

	function search_transform_term($term){
		$term = preg_replace("/(\s)/e", "'{WHITESPACE-'.ord('\$1').'}'", $term);
		$term = preg_replace("/,/", "{COMMA}", $term);
		return $term;
	}

	function search_escape_rlike($string){
		return preg_replace("/([.\[\]*^\$])/", '\\\$1', $string);
	}

	function search_db_escape_terms($terms){
    // $out = array();
    // foreach($terms as $term){
      // $out[] = '[[:<:]]'.AddSlashes($this->search_escape_rlike($term)).'[[:>:]]';
    // }
		return $terms;
	}
  
	function search_rx_escape_terms($terms){
		$out = array();
		foreach($terms as $term){
			$out[] = '\b'.preg_quote($term, '/').'\b';
		}
		return $out;
	}
	function search_sort_results($a, $b){

		$ax = $a['score'];
		$bx = $b['score'];

		if ($ax == $bx){ 
      return 0;
    }
		return ($ax > $bx) ? -1 : 1;
	}
  public function search()
  {
    $this->set('title_for_layout',"搜索");
    $terms = mysql_escape_string(htmlspecialchars($this->request->query['q']));
    $tmp_terms = $terms;
		$terms = $this->search_split_terms($terms);
    $terms_db = $this->search_db_escape_terms($terms);
    $terms_rx = $this->search_rx_escape_terms($terms);
    $orders = array("Book.created","Book.click","Book.collect","Book.downloads");
    $order = $orders[0];
    
    if (isset($this->request->query['sort'])) {
      $s = $this->request->query['sort'];
      if (!is_numeric($s)) {
        $s = 0;
      }
      $order = $orders[$s];
    }
		$parts = array();
		foreach($terms_db as $term_db){
	if(trim($term_db)=='') continue;
      $parts[] = "Book.name RLIKE '$term_db'";
      $parts[] = "Book.decs RLIKE '$term_db'";
      $parts[] = "Book.author RLIKE '$term_db'";
		}
    
    $this->Search->create();
    $search_data['Search']['keywords'] = $tmp_terms;
    $search_data['Search']['ip'] = $this->request->clientIp();
    $this->Search->save($search_data);
    
		$parts = implode(' OR ', $parts);
    $parts = "(" . $parts . ") and Book.pass >= 12";
    $this->Paginator->settings = array('limit'=>10,'conditions'=>$parts,'order'=>$order . ' DESC');
    $results = $this->Paginator->paginate('Book');
    $rows = array();
    foreach ($results as $index => $row) {
			$row['score'] = 0;
			foreach($terms_rx as $term_rx){
				$row['score'] += preg_match_all("/$term_rx/i", $row['Book']['name'], $null);
				$row['score'] += preg_match_all("/$term_rx/i", $row['Book']['decs'], $null);
				$row['score'] += preg_match_all("/$term_rx/i", $row['Book']['author'], $null);
			}
			$rows[] = $row;
		}
    
    uasort($rows, array($this,'search_sort_results'));
    $this->set('results',$results);
    $this->set('terms',$terms);
    $this->set('terms_rx',$terms_rx);
    
  }
  public function sublist($page='')
  {
    if (isset($this->is_mobile) && $this->is_mobile) {
       $typename = '最新书籍';
       $ccc = "newest";
       $arr = explode('/',$this->request->here);
       if (strpos($arr[1], 'newest') !== FALSE) {
         $typename = '最新书籍';         
         $ccc = "newest";
       }else if (strpos($arr[1], 'hotplus') !== FALSE) {
         $typename = '热门书籍';
         $ccc = "hotplus";
       }
       $this->set("title_for_layout",$typename);
       $this->set('path', getcwd() . "/mobile/{$ccc}/{$ccc}P{$page}.html");
       return;
    }
    $NOVEL_TYPE = array('qingchun' => '青春' , 'yanqing'=>'言情','chuanyue'=>'穿越','wuxia' => '武侠','xuanhuan'=>'玄幻','wenxue'=>'文学','xuanyi'=>'悬疑','dushi'=>'都市','lishi'=>'历史','jingguan'=>'经管');
    $NOVEL_LIST = array('qingchun' , 'yanqing','chuanyue', 'wuxia','xuanhuan','wenxue','xuanyi','dushi','lishi','jingguan');
    $orders = array("Book.created","Book.click","Book.collect","Book.downloads");
    $arr = explode('/',$this->request->here);
    if (strpos($arr[1], 'newest') !== FALSE) {
      $order = $orders[0];
      $typename = '最新书籍';
    }else if (strpos($arr[1], 'hotbooks') !== FALSE) {
      $order = $orders[2];
      $typename = '热门书籍';     
    }

    if (isset($this->request->query['s'])) {
      $s = $this->request->query['s'];
      if (!is_numeric($s)) {
        $s = 0;
      }
      $order = $orders[$s];
    }
  
    $this->Paginator->settings = array('conditions'=>array('Book.pass >=' => 12),'limit'=>24,'order'=> $order . ' DESC');
    $books = $this->Paginator->paginate('Book');
    
    $this->set('books',$books);
    $this->set('type','newest');
    $this->set('typename',$typename);
    $this->set('NOVEL_TYPE',$NOVEL_TYPE);
    $this->set('NOVEL_LIST',$NOVEL_LIST);
    $this->set('title_for_layout',$typename);
    $this->render('listx');
  }
  public function m_list($id="")
  {
    if (isset($this->is_mobile) && $this->is_mobile) {
       $this->set("title_for_layout","书籍列表");
       preg_match("/A([0-9]+)B([0-9]+)P([0-9]+)/i",$id,$dir);
       $this->set('path', getcwd() . "/mobile/{$dir[1]}/{$dir[2]}/list{$id}.html");
       return;
    }    
  }
  public function listx()
  {
    
    $NOVEL_TYPE = array('qingchun' => '青春' , 'yanqing'=>'言情','chuanyue'=>'穿越','wuxia' => '武侠','xuanhuan'=>'玄幻','wenxue'=>'文学','xuanyi'=>'悬疑','dushi'=>'都市','lishi'=>'历史','jingguan'=>'经管');
    $NOVEL_LIST = array('qingchun' , 'yanqing','chuanyue', 'wuxia','xuanhuan','wenxue','xuanyi','dushi','lishi','jingguan');
    $arr = explode('/',$this->request->here);
    if (strpos($arr[1], '.') !== FALSE) {
      $arr = explode('.',$arr[1]);
      $arr[1] = $arr[0];
    }
    $orders = array("Book.created","Book.click","Book.collect","Book.downloads");
    $order = $orders[0];
    if (isset($this->request->query['s'])) {
      $s = $this->request->query['s'];
      if (!is_numeric($s)) {
        $s = 0;
      }
      $order = $orders[$s];
    }
    $type_id = array_search($arr[1],$NOVEL_LIST);
    $this->Paginator->settings = array('conditions'=>array('Book.type'=>$type_id,'Book.pass >=' => 12),'limit'=>24,'order'=>$order . ' DESC');
    $books = $this->Paginator->paginate('Book');
    
    $this->set('books',$books);
    $this->set('type',$arr[1]);
    $this->set('typename',$NOVEL_TYPE[$NOVEL_LIST[$type_id]]);
    $this->set('title_for_layout',$NOVEL_TYPE[$NOVEL_LIST[$type_id]]);
    $this->set('NOVEL_TYPE',$NOVEL_TYPE);
    $this->set('NOVEL_LIST',$NOVEL_LIST);
  }
  public function allbooks($page='')
  {
    if (isset($this->is_mobile) && $this->is_mobile) {
       $this->set("title_for_layout","全本书房");
       $this->set('path', getcwd() . "/mobile/allbooks/allbooksP{$page}.html");
       return;
    }
    $this->Paginator->settings = array('conditions'=>array('Book.pass >=' => 12),'limit'=>30,'order'=>'Book.created DESC');
    $books = $this->Paginator->paginate('Book');
    $this->set('books',$books);
    $this->set('title_for_layout','全本书房');
  }
	public function admin_delete($id = null) {
		$this->Book->id = $id;
		if (!$this->Book->exists()) {
			throw new NotFoundException(__('Invalid book'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Book->delete()) {
			$this->Session->setFlash(__('The book has been deleted.'));
		} else {
			$this->Session->setFlash(__('The book could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
  function mb_str_split($string,$string_length=1) {
          if(mb_strlen($string) > $string_length || !$string_length) {
                  do {    
                          $c = mb_strlen($string);
                          $parts[] = mb_substr($string,0,$string_length);
                          $string = mb_substr($string,$string_length);
                  }while(!empty($string));
          } else {         
                  $parts = array($string);
          }
          return $parts;
  }
  public function resque()
  {
return; 
    $this->autoRender = false;
    CakeResque::enqueue(
        'default',
        'DataMigrate',
        array('migrate')
    );
    
    return;
    
    require_once ROOT . DS . 'app/Vendor/Resque/autoload.php';
    Resque::setBackend('redis://61e0c1510b2111e5:98398110Gslipt@61e0c1510b2111e5.m.cnqda.kvstore.aliyuncs.com:6379');
    
    $bid=21;
    $did=12;
    
    $JobId = Resque::enqueue('jobs','BooksJob', compact('bid','did'), true);
    echo "The job id is : ", $JobId , PHP_EOL;
    
    return;

    $this->autoRender = false;
    CakeResque::enqueue(
        'default',
        'DataMigrate',
        array('migrate')
    );
    
    return;
    
    CakeResque::enqueue(
        'default',
        'MobileJob',
        array('moblie_cache')
    );
    
    require_once ROOT . DS . 'app/Vendor/Resque/autoload.php';
    Resque::setBackend('redis://61e0c1510b2111e5:98398110Gslipt@61e0c1510b2111e5.m.cnqda.kvstore.aliyuncs.com:6379');
    
    $bid=21;
    $did=12;
    
    $JobId = Resque::enqueue('jobs','BooksJob', compact('bid','did'), true);
    echo "The job id is : ", $JobId , PHP_EOL;
    
    return;

    $books = $this->Book->find('all',array('limit'=>2,'page'=>1,'recursive'=>-1,'conditions'=>array()));
    debug($books);

    return;
    if (!$this->isAdmin()) {
			$this->Session->setFlash('权限不够');
      return $this->redirect('/');
    }
    CakeResque::enqueue(
        'default',
        'RecommandJob',
        array('hot_plus',date('Y-m-d',time()))
    );
    return false;
    CakeResque::enqueue(
        'default',
        'RecommandJob',
        array('related',20)
    );
    return;
    CakeResque::enqueue(
        'default',
        'RecommandJob',
        array('hot_plus',"20")
    );
    return;
    CakeResque::enqueueIn(
        10,
        'default',
        'RecommandJob',
        array('related',"20")
    );
    return;
    require_once ROOT . DS . 'app/Vendor/Resque/autoload.php';
    Resque::setBackend('127.0.0.1:6379');
    
    $bid=20;
    $did=5;
    
    $JobId = Resque::enqueue('jobs','BooksJob', compact('bid','did'), true);
    echo "The job id is : ", $JobId , PHP_EOL;
  }
  public function down($url='')
  {
    if (isset($this->is_mobile) && $this->is_mobile) {
       $this->set('path', getcwd() . "/mobile/down/{$url[0]}/{$url}.html");
       return;
    }
    $book = $this->Book->findByBurl($url);
    if (empty($book)) {
      throw new NotFoundException(__('不存在该书'));
      return;
    }
    if ($book['Book']['pass'] < 12) {
       throw new NotFoundException(__('不存在该书'));
      return;
    }
    $bid = $book['Book']['bid'];
    
    $created = strtotime($book['Book']['created']);
    $ye_mon  = date('Ym',$created);
    $day     = date('d',$created);
    $fullpath = '/books/' . $ye_mon . DS . $day . DS . $bid . DS . "id_" . $url . ".html";
    $hot_plus= getcwd() . '/views/small_hot_plus_list.html';
    $relatedpath = getcwd() . '/books/' . $ye_mon . DS . $day . DS . $bid . DS . "related_" . $url . ".html";
    
    $this->set('title_for_layout',$book['Book']['name'] . "下载页");
    $this->set('hot_plus',$hot_plus);
    $this->set('relatedpath',$relatedpath);    
    $this->set('book',$book);
    $this->set('fullpath',$fullpath);
  }
  public function book($url='')
  {
    if (isset($this->is_mobile) && $this->is_mobile) {
       $this->set('path', getcwd() . "/mobile/mbook/{$url[0]}/{$url}.html");
       return;
    }
    $book = $this->Book->findByBurl($url);
    if (empty($book)) {
      throw new NotFoundException(__('不存在该书'));
      return;
    }
    if ($book['Book']['pass'] < 12) {
      
      throw new NotFoundException(__('不存在该书'));
      return;
    }
    
    $bid = $book['Book']['bid'];
    $this->Paginator->settings = array(
          'conditions'=>array('Bookreply.bid'=>$bid,'Bookreply.pass'=>12),
          'limit' => 8,
          'order' =>'Bookreply.created DESC'
    );
    $this->Book->id = $bid;
    $this->Book->saveField('click',$book['Book']['click']+1);
    
    $brs = $this->Paginator->paginate('Bookreply');
    $br_count = $this->Bookreply->find('count');
    if ($this->request->is('ajax')) {
      $this->set('brs',$brs);
      $this->render('comment');
      return;
    }
    
    $created = strtotime($book['Book']['created']);
    $ye_mon  = date('Ym',$created);
    $day     = date('d',$created);
    $path    = getcwd() . '/books/' . $ye_mon . DS . $day . DS . $bid . DS . $url . ".html";
    $hot_plus= getcwd() . '/views/small_hot_plus_list.html';
    $relatedpath = getcwd() . '/books/' . $ye_mon . DS . $day . DS . $bid . DS . "related_" . $url . ".html";
    $rnd = $this->Rank->find('list');

    $this->set('title_for_layout',$book['Book']['name']);
    $this->set('hot_plus',$hot_plus);
    $this->set('path',$path);
    $this->set('book',$book);
    $this->set('rnd',$rnd);
    $this->set('rndpath',$relatedpath);    
    $this->set('brs',$brs);

  }

  
  public function comment()
  {
    $this->autoRender = false;

    if ($this->request->is('post')) {
      $bid = $this->request->data['book_id'];
  		if (!$this->Book->exists($bid)) {
          $this->Session->setFlash('不存在该书');
          $this->redirect('/');
          return;
  		}
      $this->Bookreply->create();
      $data['Bookreply']['bid']=$bid;
      if (mb_strlen(trim($this->request->data['comment_txt'])) < 6) {
        $this->Session->setFlash('评论内容过少');
        $this->redirect($_SERVER['HTTP_REFERER']);
      }
      $data['Bookreply']['body'] = Sanitize::html($this->request->data['comment_txt']);
      
      if ($this->islogin()) {
        $user = $this->current_user();
        $data['Bookreply']['uid'] = $user['User']['uid'];
      }else
      {
        $data['Bookreply']['uid'] = 0;
      }
      $data['Bookreply']['ip'] = $this->request->clientIp();;
      if ($this->Bookreply->save($data)) {
        $this->Session->setFlash('评论成功');
        $this->redirect($_SERVER['HTTP_REFERER']);
      }else
      {
        $this->Session->setFlash('评论失败');
        $this->redirect($_SERVER['HTTP_REFERER']);
      }
    }
  }

}
