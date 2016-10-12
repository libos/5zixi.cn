<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
class UsersController extends AppController {
  public $components = array('Session',
         'Captcha' => array(
             'rotate' => true
         )
  );
  public $uses = array('User','Book','Rank','Spacereply','Collect','Bookmark');
  public function captch_valid()
  {
    $this->autoRender = false;
    if ($this->request->is('post')) {
      $code = $this->request->data['code'];
      $origin = $this->Captcha->getCode();
      if ($code == $origin) {
        return "ok";
      }else{
        return "null";
      }
    }
  }
  public function captcha()  {
      $this->autoRender = false;
      $this->Captcha->generate();
  }

  public function ajax_validate()
  {
    $this->autoRender = false;
    if ($this->request->is('post')) {
      $action = $this->request->data['action'];
      if ($action == 'checkSlug') {
        $data = trim($this->request->data['slug']);
        if (!preg_match("/[a-zA-Z0-9_]{3,14}$/",$data)) {
          return "null";
        }
        $arr = $this->User->findAllBySlug($data);
        
        if (empty($arr)) {
          return "OK";
        }else{
          return "NULL";
        }
      }
      else if ($action == 'checkEmail') {
        $data = $this->request->data['email'];
        $arr = $this->User->findAllByEmail($data);
        
        if (empty($arr)) {
          return "OK";
        }else{
          return "NULL";
        }
      }
    }
  }
  
	public function index() {
    $this->set('title_for_layout','会员列表');
		$this->User->recursive = -1;
    $this->set('class',$this->Rank->find('list'));
    $orders = array("User.uploads","User.created","User.class_id","User.credits");
    $order = $orders[0];
    if (isset($this->request->query['s'])) {
      $s = $this->request->query['s'];
      if (!is_numeric($s)) {
        $s = 0;
      }
      $order = $orders[$s];
    }
    $this->Paginator->settings = array('limit'=>24,'order'=>$order . ' DESC');
		$this->set('users', $this->Paginator->paginate('User'));
	}

	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}
  public function signin()
  {  
    if ($this->islogin()) {
      $this->Session->setFlash(__('您已经登陆.'));
      $this->redirect('/home');
    }
    $this->set('title_for_layout','登陆');
  }
  public function login($value='')
  {
    $this->autoRender = false;
    if (!$this->request->is('post')) {
      $this->Session->setFlash(__('请求来源不正确。'));
      $this->redirect('/');
    }
    if ($this->islogin()) {
      $this->Session->setFlash(__('您已经登陆.'));
      $this->redirect('/home');
    }
    $action = $this->request->data['action'];
    $expire = $this->request->data['Expires'];
    if ($expire == 0) {
      $expire = 7200;
    }
    if ($action == "homepageuserlogin") {
      $slug = trim($this->request->data['slug']);
      $md5password = $this->request->data['password'];
      $user = $this->User->findBySlug($slug);
      if (empty($slug)) {
        return "null";
      }
      
      $salt = $user['User']['salt'];
      $pass = $user['User']['password'];
      $md5 = $this->recypher($md5password,$salt);
      if ($pass == $md5) {
        $this->Cookie->write('uid', $user['User']['uid'] . "&pwd=" . $md5password . "&expires=" . $expire,false,$expire);
        return "Login";
      }else{
        return "null";
      }
    }
  }
  public function logout()
  {
    $this->autoRender = false;
    if (!$this->islogin()) {
      $this->Session->setFlash(__('您尚未登陆.'));
      $this->redirect('/');
    }
    $this->Cookie->delete('uid');
    // setcookie("shufang[uid]",'');
    $this->Session->setFlash(__('成功退出.'));
    $this->redirect('/');
  }
  
  public function signup()
  {
    if ($this->islogin()) {
      $this->Session->setFlash(__('您已经登陆.'));
      $this->redirect('/home');
    }
    $this->set('title_for_layout','注册');	
  }
  public function generate_salt()
  {
    $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
    $i = 0;
    $salt = "";
    while ($i < 15) {
        $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
        $i++;
    }
    return $salt;
  }
  public function cypher($password='',$salt='')
  {
    return md5(md5($password) . "." . $salt);
  }
  public function recypher($md5password='',$salt='')
  {
    return md5($md5password . "." . $salt);
  }
	public function register() {
		$this->autoRender = false;
    if ($this->islogin()) {
      $this->Session->setFlash(__('您已经登陆.'));
      $this->redirect('/home');
    }
		if ($this->request->is('post')) {
      $code = $this->request->data['code'];
      $origin = $this->Captcha->getCode();
      if ($code != $origin) {
        return "null";
      }
      $data['User']['slug'] = trim($this->request->data['slug']);
      if (!preg_match("/[a-zA-Z0-9_]{3,14}$/",$data['User']['slug'])) {
        return "null";
      }
      $data['User']['email'] = trim($this->request->data['email']);
      if (strpos($this->request->data['password'],' ') !== false) {
        return "null";
      }
      $data['User']['salt'] = $this->generate_salt();
      $pass = $this->cypher($this->request->data['password'], $data['User']['salt'] );
      $data['User']['password'] = $pass;
      $data['User']['sex'] = $this->request->data['sex'];
      $data['User']['regip'] = $this->request->clientIp();
      $data['User']['lastip']= $this->request->clientIp();
      
			$this->User->create();
			if ($this->User->save($data)) {
			  return "OK";
			} else {
			  return "null";
			}
		}
	}

  public function change_pwd()
  {
    if(!$this->islogin()) {
      $this->Session->setFlash(__('您尚未登陆.'));
      $this->redirect('/');
    }
  }
  public function change()
  {
  	$this->autoRender = false;
    if(!$this->islogin()) {
      $this->Session->setFlash(__('您尚未登陆.'));
      $this->redirect('/');
    }
    $op = $this->request->data['old'];
    $cur = $this->current_user();
    $salt = $cur['User']['salt'];
    if ($cur['User']['password'] != $this->recypher($op,$salt)) {
      return "ERROR";
    }
    $np = $this->request->data['new'];
    $new_salt = $this->generate_salt();
    $new_pass = $this->cypher($np,$new_salt);
    $this->User->id = $cur['User']['uid'];
    $this->User->saveField('password',$new_pass);
    $this->User->saveField('salt',$new_salt);
    $this->Cookie->delete('uid');
    return "ok";
  }
	// public function edit($id = null) {
//     if (!$this->User->exists($id)) {
//       throw new NotFoundException(__('Invalid user'));
//     }
//     if ($this->request->is(array('post', 'put'))) {
//       $this->User->uid = $id;
//       if ($this->User->save($this->request->data)) {
//         $this->Session->setFlash(__('The user has been saved.'));
//         return $this->redirect(array('action' => 'index'));
//       } else {
//         $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
//       }
//     } else {
//       $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
//       $this->request->data = $this->User->find('first', $options);
//     }
//     $groups = $this->User->Group->find('list');
//     $this->set(compact('groups'));
//   }


  public function home()
  {
    $this->set('title_for_layout','个人主页');
    $this->set("class" ,$this->Rank->find('list')); 
  }
 
  public function space($id='')
  {
    $this->set('title_for_layout','个人主页');
    if ($id == '') {
      if ($this->islogin()) {
        $user = $this->current_user();
        $id =   $user['User']['uid'];
      }else
      {
				$this->Session->setFlash('您尚未登录或无此用户。');
				return $this->redirect('/');
      }
    }else
    {
  		if (!$this->User->exists($id)) {
  			throw new NotFoundException(__('无此用户'));
  		}
  		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
  		$user = $this->User->find('first', $options);
    }
    $this->Paginator->settings = array('conditions'=>array('Spacereply.owner'=>$user['User']['uid'],'Spacereply.pass >='=>12,'Spacereply.deleted'=>'N'),'order'=>'Spacereply.created DESC','recursive'=>0,'limit'=>10);
    $this->User->id = $user['User']['uid'];
    $this->User->saveField('incount',$user['User']['incount']+1);
		$this->set('spacereplies', $this->Paginator->paginate('Spacereply'));
    
    $this->set('title_for_layout',$user['User']['slug'] . '个人空间');
    $this->set('user',$user);
  }
  public function space_post()
  {
    $this->autoRender = false;
    if ($this->request->is('post')) {

      $data['Spacereply']['owner'] = $this->request->data['owner'];
      if ($this->islogin()) {
        $cur = $this->current_user();
        $uid = $cur['User']['uid'];  
        if (isset($this->request->data['reply']) && $this->request->data['reply'] != 0 ) {
            $reply = $this->request->data['reply'];
          	if (!$this->Spacereply->exists($reply)) {
      				$this->Session->setFlash('评论失败。');
      				return $this->redirect($_SERVER['HTTP_REFERER']);
            }
            $rrrr = $this->Spacereply->findByRid($reply);
            if ($rrrr['Spacereply']['reply']!=null) {
      				$this->Session->setFlash('评论失败。');
      				return $this->redirect($_SERVER['HTTP_REFERER']);
            }
            
            if ($reply!=0) {
              if ($uid ==$data['Spacereply']['owner']) {
                $this->Spacereply->id = $reply;
                if ($this->Spacereply->saveField('reply',Sanitize::html($this->request->data['body']))) {
          				$this->Session->setFlash('评论成功。');
          				return $this->redirect($_SERVER['HTTP_REFERER']);
                }else{
            				$this->Session->setFlash('评论失败。');
            				return $this->redirect($_SERVER['HTTP_REFERER']);
                }
            }else{
        				$this->Session->setFlash('评论失败。');
        				return $this->redirect($_SERVER['HTTP_REFERER']);
            }
          }
        }
      }else{
        $uid = 0;
      }

      $data['Spacereply']['body'] = Sanitize::html($this->request->data['body']);        
      $data['Spacereply']['uid'] = $uid;
      $data['Spacereply']['ip'] = $this->request->clientIp();
      $this->Spacereply->create();
      if ($this->Spacereply->save($data)) {
				$this->Session->setFlash('评论成功。');
				return $this->redirect($_SERVER['HTTP_REFERER']);
      }
      else{
				$this->Session->setFlash('评论失败。');
				return $this->redirect($_SERVER['HTTP_REFERER']);
      }
    }
  }
  
  public function space_manage()
  {
    $this->set('title_for_layout','空间评论管理');
    if (!$this->islogin()) {
			$this->Session->setFlash('您尚未登录或无此用户。');
			return $this->redirect('/');
    }
    $cur = $this->current_user();
    $this->Paginator->settings = array('conditions'=>array('Spacereply.owner'=>$cur['User']['uid'],'Spacereply.pass >='=>12,'Spacereply.deleted'=>'N'),'order'=>'Spacereply.created DESC','recursive'=>0,'limit'=>2);
    
		$this->set('spacereplies', $this->Paginator->paginate('Spacereply'));
  }
  public function spacereply_delete()
  {
    $this->autoRender = false;
    if (!$this->islogin()) {
			$this->Session->setFlash('您尚未登录或无此用户。');
			return $this->redirect('/');
    }
    $cur = $this->current_user();
    $rid = $this->request->query['rid'];
  	if (!$this->Spacereply->exists($rid)) {
			$this->Session->setFlash('删除失败。');
			return $this->redirect($_SERVER['HTTP_REFERER']);
    }
    $rrrr = $this->Spacereply->findByRid($rid);
    if ($rrrr['Spacereply']['owner'] != $cur['User']['uid']) {
			$this->Session->setFlash('认证失败，删除失败。');
			return $this->redirect($_SERVER['HTTP_REFERER']);
    }
    $this->Spacereply->id = $rid;
    if ($this->Spacereply->saveField('deleted','Y')) {
			$this->Session->setFlash('删除成功。');
			return $this->redirect('/home/shufang');
    }
    else{
			$this->Session->setFlash('删除失败。');
			return $this->redirect($_SERVER['HTTP_REFERER']);
    }
  }
  public function favorite()
  {
     $this->set('title_for_layout','书架收藏管理');
     if (!$this->islogin()) {
 			$this->Session->setFlash('您尚未登录或无此用户。');
 			return $this->redirect('/');
     }
     $cur = $this->current_user();
     $this->Paginator->settings = array('conditions'=>array('Collect.uid'=>$cur['User']['uid']),'order'=>'Collect.created DESC','recursive'=>0,'limit'=>2);
 		$this->set('collects', $this->Paginator->paginate('Collect'));
  }
  public function favorite_delete()
  {
    $this->autoRender = false;
    if (!$this->islogin()) {
			$this->Session->setFlash('您尚未登录或无此用户。');
			return $this->redirect('/');
    }
    $cur = $this->current_user();
    $bid = $this->request->data['bid'];
    
    $ccc = $this->Collect->find('first',array('conditions'=>array('Collect.uid'=>$cur['User']['uid'],'Collect.bid'=>$bid)));
    if (empty($ccc)) {
			$this->Session->setFlash('删除失败。');
			return $this->redirect($_SERVER['HTTP_REFERER']);
    }
    $this->Collect->deleteAll(array('Collect.uid'=>$cur['User']['uid'],'Collect.bid'=>$bid), false);
		$this->Session->setFlash('删除成功。');
		return $this->redirect($_SERVER['HTTP_REFERER']);
  }
  public function bookmark()
  {
     $this->set('title_for_layout','书签管理');
     if (!$this->islogin()) {
 			$this->Session->setFlash('您尚未登录或无此用户。');
 			return $this->redirect('/');
     }
     // $cur = $this->current_user();
  }
  public function books()
  {
    $this->set('title_for_layout','您上传的小说');
    if (!$this->islogin()) {
			$this->Session->setFlash('您尚未登录或无此用户。');
			return $this->redirect('/');
    }
    $cur = $this->current_user();
    $this->Paginator->settings = array('conditions'=>array('Book.uid'=>$cur['User']['uid'],'Book.pass >=' => 12),'order'=>'Book.created DESC','recursive'=>-1);
		$this->set('mybooks', $this->Paginator->paginate('Book'));
  }

  public function avatar()
  {
    $this->set('title_for_layout','修改头像');
    if (!$this->islogin()) {
			$this->Session->setFlash('您尚未登录或无此用户。');
			return $this->redirect('/');
    }
    $large_photo_exists = "";
    $this->set('large_photo_exists',$large_photo_exists);
    if ($this->request->is('post')) {
      $cur = $this->current_user();
      // if (!isset($_SESSION['random_key']) || strlen($_SESSION['random_key'])==0){
      $_SESSION['random_key'] = strtotime($cur['User']['created']) . $cur['User']['uid'];
      // $_SESSION['user_file_ext'] = "";
      // }
      $year_month = date('Ym',time());  
      $upload_dir = getcwd() . "/avatar"; 
      $upload_path = $upload_dir."/{$year_month}/";
      $upload_link = "/avatar/{$year_month}/";
      if(!file_exists($upload_path)){
      	@mkdir($upload_path, 0777);
      	@chmod($upload_path, 0777);
      }
      $large_image_prefix = "resize_"; 	
      $thumb_image_prefix = "thumbnail_";
      $large_image_name = $large_image_prefix.$_SESSION['random_key'];
      $thumb_image_name = $thumb_image_prefix.$_SESSION['random_key'];
      $max_file = "3"; 							
      $max_width = "1500";						
      $thumb_width = "120";					
      $thumb_height = "120";
      $_SESSION['user_file_ext'] ='.jpg';
      $this->set('thumb_height',$thumb_height);
      $this->set('thumb_width',$thumb_width);
      $allowed_image_types = array('image/pjpeg'=>"jpg",'image/jpeg'=>"jpg",'image/jpg'=>"jpg",'image/png'=>"png",'image/x-png'=>"png",'image/gif'=>"gif");
      $allowed_image_ext = array_unique($allowed_image_types); 
      $image_ext = "";	// initialise variable, do not change this.
      foreach ($allowed_image_ext as $mime_type => $ext) {
          $image_ext.= strtoupper($ext)." ";
      }
      $large_image_location = $upload_path.$large_image_name.$_SESSION['user_file_ext'];
      $thumb_image_location = $upload_path.$thumb_image_name.$_SESSION['user_file_ext'];

      if (file_exists($large_image_location)){
      	if(file_exists($thumb_image_location)){
      		$thumb_photo_exists = "<img src=\"".$upload_link.$thumb_image_name.$_SESSION['user_file_ext']."\" alt=\"Thumbnail Image\"/>";
      	}else{
      		$thumb_photo_exists = "";
      	}
         	$large_photo_exists = "<img src=\"".$upload_link.$large_image_name.$_SESSION['user_file_ext']."\" alt=\"Large Image\"/>";
      } else {
         	$large_photo_exists = "";
          $thumb_photo_exists = "";
      }
      
      if (isset($_POST["upload"])) { 
      	$userfile_name = $_FILES['image']['name'];
      	$userfile_tmp = $_FILES['image']['tmp_name'];
      	$userfile_size = $_FILES['image']['size'];
      	$userfile_type = $_FILES['image']['type'];
      	$filename = basename($_FILES['image']['name']);
      	$file_ext =strtolower(pathinfo($filename, PATHINFO_EXTENSION)); //strtolower(substr($filename, strrpos($filename, '.') + 1));
        
	$large_image_location = $upload_path.$large_image_name. "." . $file_ext;
        $thumb_image_location = $upload_path.$thumb_image_name. "." . $file_ext;
      	if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
      		foreach ($allowed_image_types as $mime_type => $ext) {
      			if($file_ext==$ext && $userfile_type==$mime_type){
      				$error = "";
      				break;
      			}else{
      				$error = "只允许上传 <strong>".$image_ext."</strong> 格式<br />";
      			}
      		}
      		//check if the file size is above the allowed limit
      		if ($userfile_size > ($max_file*1048576)) {
      			$error.= "文件最大 ".$max_file."MB";
      		}
		
      	}else{
      		$error= "请选择文件上传";
      	}
        
      	if (strlen($error)==0){
		
      		if (isset($_FILES['image']['name'])){
			
      			$_SESSION['user_file_ext']=".".$file_ext;
			
      			move_uploaded_file($userfile_tmp, $large_image_location);
      			@chmod($large_image_location, 0777);
			
      			$width = $this->getWidth($large_image_location);
      			$height = $this->getHeight($large_image_location);
      			//Scale the image if it is greater than the width set above
      			if ($width > $max_width){
      				$scale = $max_width/$width;
      				$uploaded = $this->resizeImage($large_image_location,$width,$height,$scale);
      			}else{
      				$scale = 1;
      				$uploaded = $this->resizeImage($large_image_location,$width,$height,$scale);
      			}
      			//Delete the thumbnail file so the user can create a new one
      			if (file_exists($thumb_image_location)) {
      				unlink($thumb_image_location);
      			}
      		}
          $large_link = $upload_link.$large_image_name.$_SESSION['user_file_ext'];
          $this->set('large_photo_exists',$large_link);
          $this->set('large_image_location_link',$large_link);
          $this->set('large_image_location',$large_image_location);
          $this->set('large_image_name',$large_image_name);
          $this->set('upload_path',$upload_link);
          // header("location:".'/home/avatar');
          // exit();
      	}else{
    			$this->Session->setFlash($error);
    			return $this->redirect('/home/avatar');
      	}    
      }
      if (isset($_POST["upload_thumbnail"])) {

      	$x1 = $_POST["x1"];
      	$y1 = $_POST["y1"];
      	$x2 = $_POST["x2"];
      	$y2 = $_POST["y2"];
      	$w = $_POST["w"];
      	$h = $_POST["h"];
      	$scale = $thumb_width/$w;
      	$cropped = $this->resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);

          
        $this->User->id = $cur['User']['uid'];
        $aaa = explode('webroot',$cropped);
        $this->User->saveField('avatar', $aaa[1]);
      	//Reload the page again to view the thumbnail
        // header("location:".'/home/avatar');
        // exit();
      }
      
      
    }
  }
 
	public function admin_index() {
    $this->layout = 'admin';
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

	public function admin_view($id = null) {
    $this->layout = 'admin';
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

	public function admin_add() {
    $this->layout = 'admin';
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

	public function admin_edit($id = null) {
    $this->layout = 'admin';
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

	public function admin_delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}


  //You do not need to alter these functions
  function resizeImage($image,$width,$height,$scale) {
  	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
  	$imageType = image_type_to_mime_type($imageType);
  	$newImageWidth = ceil($width * $scale);
  	$newImageHeight = ceil($height * $scale);
  	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
  	switch($imageType) {
  		case "image/gif":
  			$source=imagecreatefromgif($image); 
  			break;
  	    case "image/pjpeg":
  		case "image/jpeg":
  		case "image/jpg":
  			$source=imagecreatefromjpeg($image); 
  			break;
  	    case "image/png":
  		case "image/x-png":
  			$source=imagecreatefrompng($image); 
  			break;
    }
  	imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
	
  	switch($imageType) {
  		case "image/gif":
  	  		imagegif($newImage,$image); 
  			break;
        	case "image/pjpeg":
  		case "image/jpeg":
  		case "image/jpg":
  	  		imagejpeg($newImage,$image,90); 
  			break;
  		case "image/png":
  		case "image/x-png":
  			imagepng($newImage,$image);  
  			break;
      }
	
  	chmod($image, 0777);
  	return $image;
  }
  //You do not need to alter these functions
  function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
  	$imageType = image_type_to_mime_type($imageType);
	
  	$newImageWidth = ceil($width * $scale);
  	$newImageHeight = ceil($height * $scale);
  	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
  	switch($imageType) {
  		case "image/gif":
  			$source=imagecreatefromgif($image); 
  			break;
  	    case "image/pjpeg":
  		case "image/jpeg":
  		case "image/jpg":
  			$source=imagecreatefromjpeg($image); 
  			break;
  	    case "image/png":
  		case "image/x-png":
  			$source=imagecreatefrompng($image); 
  			break;
    	}
  	imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
  	switch($imageType) {
  		case "image/gif":
  	  		imagegif($newImage,$thumb_image_name); 
  			break;
        	case "image/pjpeg":
  		case "image/jpeg":
  		case "image/jpg":
  	  		imagejpeg($newImage,$thumb_image_name,90); 
  			break;
  		case "image/png":
  		case "image/x-png":
  			imagepng($newImage,$thumb_image_name);  
  			break;
      }
  	chmod($thumb_image_name, 0777);
  	return $thumb_image_name;
  }
  //You do not need to alter these functions
  function getHeight($image) {
  	$size = getimagesize($image);
  	$height = $size[1];
  	return $height;
  }
  //You do not need to alter these functions
  function getWidth($image) {
  	$size = getimagesize($image);
  	$width = $size[0];
  	return $width;
  }
}
