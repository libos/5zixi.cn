<?php
App::uses('AppController', 'Controller');


class AdminController extends AppController {
  public $uses = array('Document','User','Book','Rank','Bookreply','Feedback','Spacereply');
  public function beforeFilter() {
    parent::beforeFilter();
    $this->layout = 'admin';
    if (!$this->isAdmin()) {
  		$this->Session->setFlash("您无权访问该页面！");
  		$this->redirect('/');
  		return;
	  }
    $msg = $this->Feedback->find('count',array('conditions'=>array('Feedback.handle'=>0)));
    $this->set('newmsg',$msg);
  }
  public function update_all()
  {
    ini_set('memory_limit', '-1');
    $this->autoRender = false;
    if (!$this->request->is('post')) {
      return "ERR";
    }
    $this->update_mobile();
    $this->update_computer();
    return "ok";
  }
  public function update_mobile()
  {
    $this->autoRender = false;
    ini_set('memory_limit', '-1');
    if (!$this->request->is('post')) {
      return "ERR";
    }
    CakeResque::enqueue(
        'default',
        'MobileJob',
        array('moblie_cache')
    );
    return "ok";
  }
  public function update_computer()
  {
    $this->autoRender = false;
    ini_set('memory_limit', '-1');
    if (!$this->request->is('post')) {
      return "ERR";
    }
    CakeResque::enqueue(
        'default',
        'RecommandJob',
        array('hot_plus',date('Y-m-d',time()))
    );
    return "ok";
  }
  public function update_pass()
  {
    $this->autoRender = false;
    ini_set('memory_limit', '-1');
    if (!$this->request->is('post')) {
      return "ERR";
    }
    $books = $this->Book->find('all',array('conditions'=>array('Book.pass >=' => 12),'recursive'=>0,'order'=>'Book.created DESC'));
    foreach ($books as $index => $book) {
      require_once ROOT . DS . 'app/Vendor/Resque/autoload.php';
      Resque::setBackend('redis://61e0c1510b2111e5:98398110Gslipt@61e0c1510b2111e5.m.cnqda.kvstore.aliyuncs.com:6379');
    
      $bid=$book['Book']['bid'];
      $did=$book['txt']['did'];
    
      $JobId = Resque::enqueue('jobs','BooksJob', compact('bid','did'), true);
    }
    return "ok";    
  }
  
  
  
  
  public function index()
  {
    $result = $this->Book->query('SELECT sum(downloads) as a,sum(click) as b,sum(collect) as c,count(*) as d from books;');
    
    $this->set('downloads',$result[0][0]['a']);
    $this->set('clicks',$result[0][0]['b']);
    $this->set('collects',$result[0][0]['c']);
    $this->set('count',$result[0][0]['d']);
    $result = $this->Book->query('SELECT count(*) as a from books where pass=0;');
    $this->set('notdo',$result[0][0]['a']);
    $result = $this->Book->query('SELECT count(*) as a from books where pass=11;');
    $this->set('ingdo',$result[0][0]['a']);
    $result = $this->Book->query('SELECT count(*) as a from books where pass>11;');
    $this->set('done',$result[0][0]['a']);
    
    
    $result = $this->Bookreply->query('SELECT count(*) as a from bookreplies;');
    $this->set('bookreply',$result[0][0]['a']);
    $result = $this->Spacereply->query('SELECT count(*) as a  from spacereplies;');
    $this->set('spacereply',$result[0][0]['a']);
  }
  public function feedback()
  {
		$this->Feedback->recursive = 0;
    $this->Paginator->settings = array('order'=>'Feedback.created DESC','limit'=>20);
		$this->set('feedbacks', $this->Paginator->paginate('Feedback'));
  }
  
  public function users_reply()
  {
		$this->Spacereply->recursive = 0;
    $this->Paginator->settings = array('order'=>'Spacereply.created DESC','limit'=>20);
		$this->set('spacereplies', $this->Paginator->paginate('Spacereply'));
  }
  public function books_reply()
  {
		$this->Bookreply->recursive = 0;
    $this->Paginator->settings = array('order'=>'Bookreply.created DESC','limit'=>20);
		$this->set('bookreplies', $this->Paginator->paginate('Bookreply'));
  }
  
  
  
  public function books_reply_pass()
  {
    $this->autoRender = false;
    if (!($this->request->is('ajax') && $this->request->is('post'))) {
      return "ERR";
    }
    $id = $this->request->data['id'];
		if (!$this->Bookreply->exists($id)) {
			throw new NotFoundException(__('不存在该评论'));
		}
    $this->Bookreply->recursive = 0;
    $bookreply = $this->Bookreply->read(null,$id);
    $this->Bookreply->id = $id;
    if ($this->Bookreply->saveField('pass',12)) {
      return 'OK';
    }
    return 'ERR';
  }
  public function books_reply_reject()
  {
    $this->autoRender = false;
    if (!($this->request->is('ajax') && $this->request->is('post'))) {
      return "ERR";
    }
    $id = $this->request->data['id'];
		if (!$this->Bookreply->exists($id)) {
			throw new NotFoundException(__('不存在该评论'));
		}
    $this->Bookreply->recursive = 0;
    $bookreply = $this->Bookreply->read(null,$id);
    $this->Bookreply->id = $id;
    if ($this->Bookreply->saveField('pass',1))     {
      return 'OK';
    }
    return 'ERR';
  }
  
  public function users_reply_pass()
  {
    $this->autoRender = false;
    if (!($this->request->is('ajax') && $this->request->is('post'))) {
      return "ERR";
    }
    $id = $this->request->data['id'];
		if (!$this->Spacereply->exists($id)) {
			throw new NotFoundException(__('不存在该评论'));
		}
    $this->Spacereply->recursive = 0;
    $bookreply = $this->Spacereply->read(null,$id);
    $this->Spacereply->id = $id;
    if ($this->Spacereply->saveField('pass',12)) {
      return 'OK';
    }
    return 'ERR';
  }
  public function users_reply_reject()
  {
    $this->autoRender = false;
    if (!($this->request->is('ajax') && $this->request->is('post'))) {
      return "ERR";
    }
    $id = $this->request->data['id'];
		if (!$this->Spacereply->exists($id)) {
			throw new NotFoundException(__('不存在该评论'));
		}
    $this->Spacereply->recursive = 0;
    $bookreply = $this->Spacereply->read(null,$id);
    $this->Spacereply->id = $id;
    if ($this->Spacereply->saveField('pass',1))     {
      return 'OK';
    }
    return 'ERR';
  }
}
