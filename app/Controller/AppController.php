<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {
  public $components = array('DebugKit.Toolbar'=> array(
     'panels' => array('DebugKitEx.Nosql', 'DebugKitEx.Resque')),'Session','Cookie','Paginator');
  
  public function beforeFilter() {
    parent::beforeFilter();
    $this->Cookie->name = 'shufang';
    $this->Cookie->time = 3600;  
    $this->Cookie->httpOnly = true;
    $this->Cookie->domain = '.5zixi.cn';
    $isAdmin = $this->isAdmin();
    if ($this->request->prefix == 'admin' || $this->request->prefix == 'admins') {
      if (!$isAdmin) {
    		$this->Session->setFlash("您无权访问该页面！");
    		$this->redirect('/');
    		return;
  	  }else
      {
        $this->loadModel('Feedback');
        $msg = $this->Feedback->find('count',array('conditions'=>array('Feedback.handle'=>0)));
        $this->set('newmsg',$msg);
      }
    }
    $this->set('isAdmin',$isAdmin);
    $islogin = $this->islogin();
    if ($islogin) {
      $cur = $this->current_user();
      $this->set('cur',$cur);
    }

    $this->set('islogin',$islogin);
    if ($this->request->isMobile() or $_SERVER['HTTP_HOST'] == "m.52shufang.pj" or $_SERVER['HTTP_HOST'] == "m.52shufang.com" or $_SERVER['HTTP_HOST'] == "m.5zixi.cn"){
        $this->is_mobile = true;
            $this->set('is_mobile', true );
            $this->autoRender = false;
    }
  }
  
  function afterFilter() {
      // if in mobile mode, check for a valid view and use it
      if (isset($this->is_mobile) && $this->is_mobile) {
          $view_file = file_exists( VIEWS . $this->name . DS . 'mobile/' . $this->action . '.ctp' );
          $layout_file = file_exists( LAYOUTS . 'mobile/' . $this->layout . '.ctp' );
          if($view_file || $layout_file){
              $this->render( ($view_file?'mobile/':'').$this->action, ($layout_file?'mobile/':'').$this->layout);
          }
      }
   }
   
   public function islogin()
   { 
     if ($this->Cookie->check('uid')) {
       $uid = $this->Cookie->read('uid');
       if ($uid != "") {
         return true;
       }
     }
     return false;
   }
   function val($value='')
   {
     return substr($value,0,strpos($value,'&'));
   }
   public function current_user()
   {
     $this->loadModel('User');
     $uid = $this->Cookie->read('uid');
     return $this->User->findByUid($this->val($uid));
   }
   public function isAdmin()
   {
     return $this->islogin() && ($this->isMaster() || $this->isAudit());
   }
   public function isMaster()
   {
     $cur = $this->current_user();
     if ($cur['Group']['gname'] == "管理员") {
       return true;
     }
     return false;
   }
   public function isAudit()
   {
     $cur = $this->current_user();
     if ($cur['Group']['gname'] == "审核员") {
       return true;
     }
     return false;
   }
}
