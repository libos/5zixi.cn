<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
class PagesController extends AppController {
  public $components = array('Session',
         'Captcha' => array(
             'rotate' => true
         )
  );
	public $uses = array('User','Book','Feedback');
  
	public function home() {
     if (isset($this->is_mobile) && $this->is_mobile) {
        $this->set("title_for_layout","");
        $this->set('path', getcwd() . '/mobile/homepage/index.html');
        return;
     }
      $this->set("title_for_layout","");
      $books = $this->Book->find('all',array('limit'=>16,'conditions'=>array('Book.pass >' => 11)));
      $this->set('books',$books);
      $latest = $this->Book->find('all',array('limit'=>12,'order'=>'Book.created DESC','conditions'=>array('Book.pass >' => 11)));
      $this->set('latest',$latest);
      $this->set('path',getcwd() . '/views/home_hot_plus_list.html');
	}
  
  public function contract()
  {
    $this->set("title_for_layout","协议");
  }
  public function help()
  {
    $this->set("title_for_layout","帮助");

  }
  public function feedback()
  {
    $this->set("title_for_layout","反馈");
    if ($this->request->is('post')) {
      $code = $this->request->data['captcha'];
      $origin = $this->Captcha->getCode();
      if ($code != $origin) {
        $this->Session->setFlash(__('验证码错误.'));
        $this->redirect('/feedback?email=' . $this->request->data['email'] . '&body=' . str_replace("\r", "",str_replace("\n","",$this->request->data['body'])));
        return;
      }

      $this->Feedback->create();
      $data['Feedback']['email'] = $this->request->data['email'];
      $data['Feedback']['body'] = Sanitize::html($this->request->data['body']);
      $data['Feedback']['ip'] = $this->request->clientIp();
      
      if ($this->Feedback->save($data)) {
        $this->Session->setFlash(__('反馈成功，我们将尽快处理。'));
        $this->redirect('/feedback');
        return;
      }
      
    }
  }
  public function ranks()
  {
    if (isset($this->is_mobile) && $this->is_mobile) {
       $this->set("title_for_layout","小说排行榜");
       $this->set('path', getcwd() . '/mobile/rank/rank.html');
       return;
    }
    $this->set('title_for_layout','小说排行榜');
    $clicks = $this->Book->find('all',array('recursive'=>-1,'order'=>'Book.click DESC','conditions'=>array('Book.pass >' => 11)));
    $downloads = $this->Book->find('all',array('recursive'=>-1,'order'=>'Book.downloads DESC','conditions'=>array('Book.pass >' => 11)));
    $collects = $this->Book->find('all',array('recursive'=>-1,'order'=>'Book.collect DESC','conditions'=>array('Book.pass >' => 11)));
    $this->set('clicks',$clicks);
    $this->set('downloads',$downloads);
    $this->set('collects',$collects);
  }
}
