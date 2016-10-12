<?php

	Router::connect('/', array('controller' => 'pages', 'action' => 'home', 'home'));
    
  //Admin
  Router::connect('/admin/feedback/*', array('controller' => 'admin', 'action' => 'feedback'));
  Router::connect('/admin/books_reply/pass', array('controller' => 'admin', 'action' => 'books_reply_pass'));
  Router::connect('/admin/books_reply/reject', array('controller' => 'admin', 'action' => 'books_reply_reject'));  
  Router::connect('/admin/users_reply/pass', array('controller' => 'admin', 'action' => 'users_reply_pass'));
  Router::connect('/admin/users_reply/reject', array('controller' => 'admin', 'action' => 'users_reply_reject'));  
  Router::connect('/admin/books_reply/*', array('controller' => 'admin', 'action' => 'books_reply'));
  Router::connect('/admin/users_reply/*', array('controller' => 'admin', 'action' => 'users_reply'));
  Router::connect('/admin/update_mobile', array('controller' => 'admin', 'action' => 'update_mobile'));
  Router::connect('/admin/update_all', array('controller' => 'admin', 'action' => 'update_all'));  
  Router::connect('/admin/update_computer', array('controller' => 'admin', 'action' => 'update_computer'));
  Router::connect('/admin/update_pass', array('controller' => 'admin', 'action' => 'update_pass'));
  
  //Book
  Router::connect('/upload', array('controller' => 'books', 'action' => 'upload'));
  Router::connect('/uploadtxt',array('controller' => 'books', 'action' => 'upload_documents'));
  Router::connect('/uploadcover',array('controller' => 'books', 'action' => 'upload_documents'));  
  Router::connect('/ajaxcheck',array('controller' => 'books', 'action' => 'ajaxcheck'));
  Router::connect('/book/:url.html',array('controller'=>'books','action'=>'book'),array('pass'=>array('url')));
  Router::connect('/down/id_:url.html',array('controller'=>'books','action'=>'down'),array('pass'=>array('url')));
  Router::connect('/search',array('controller'=>'books','action'=>'search'));
  
  //Mobile
  Router::connect('/list:id.html',array('controller'=>'books','action'=>'m_list'),array('pass'=>array('id')));
  Router::connect('/hotplus.html',array('controller'=>'books','action'=>'sublist'));
  Router::connect('/allbooksP:page.html',array('controller'=>'books','action'=>'allbooks'),array('pass'=>array('page')));
  Router::connect('/hotplusP:page.html',array('controller' => 'books', 'action' => 'sublist'),array('pass'=>array('page')));
  Router::connect('/newestP:page.html', array('controller' => 'books', 'action' => 'sublist'),array('pass'=>array('page')));
  //Download
  Router::connect('/download/:url',array('controller'=>'books','action'=>'download'),array('pass'=>array('url')));
  Router::connect('/baiduyun/:url',array('controller'=>'books','action'=>'downloadBaidu'),array('pass'=>array('url')));
  
  
  //User Reg
  Router::connect('/signup', array('controller' => 'users', 'action' => 'signup'));
  Router::connect('/register', array('controller' => 'users', 'action' => 'register'));
  Router::connect('/img/captcha.jpg', array('controller' => 'users', 'action' => 'captcha'));
  Router::connect('/captch_valid', array('controller' => 'users', 'action' => 'captch_valid'));
  Router::connect('/ajax_validate', array('controller' => 'users', 'action' => 'ajax_validate'));
  
  //User Login
  Router::connect('/signin', array('controller' => 'users', 'action' => 'signin'));
  Router::connect('/login', array('controller' => 'users', 'action' => 'login'));  
  
  Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
  
  //User Home
  Router::connect('/home', array('controller' => 'users', 'action' => 'home'));
  Router::connect('/home/change_pwd', array('controller' => 'users', 'action' => 'change_pwd'));
  Router::connect('/home/favorite', array('controller' => 'users', 'action' => 'favorite'));
  Router::connect('/home/bookmark', array('controller' => 'users', 'action' => 'bookmark'));
  Router::connect('/home/shufang', array('controller' => 'users', 'action' => 'space_manage'));
  Router::connect('/home/books', array('controller' => 'users', 'action' => 'books'));
  Router::connect('/home/avatar', array('controller' => 'users', 'action' => 'avatar'));
  
  //Shufang  ----User
  
  Router::connect('/favorite/delete', array('controller' => 'users', 'action' => 'favorite_delete'));
  Router::connect('/spacereply/delete', array('controller' => 'users', 'action' => 'spacereply_delete'));
  Router::connect('/shufang/post', array('controller' => 'users', 'action' => 'space_post'),array('pass'=>array('id')));
  Router::connect('/shufang/:id', array('controller' => 'users', 'action' => 'space'),array('pass'=>array('id')));
  Router::connect('/shufang', array('controller' => 'users', 'action' => 'space'));
  //Static
  Router::connect('/contract', array('controller' => 'pages', 'action' => 'contract'));
  Router::connect('/help', array('controller' => 'pages', 'action' => 'help'));
  Router::connect('/feedback', array('controller' => 'pages', 'action' => 'feedback'));

  //Rank  
  Router::connect('/rank.html', array('controller' => 'pages', 'action' => 'ranks'));

  //Lists
  Router::connect('/hotbooks.html',array('controller' => 'books', 'action' => 'sublist'));
  Router::connect('/hotbooks',array('controller' => 'books', 'action' => 'sublist'));
  Router::connect('/users.html', array('controller' => 'users', 'action' => 'index'));
  Router::connect('/newest.html', array('controller' => 'books', 'action' => 'sublist'));
  Router::connect('/users', array('controller' => 'users', 'action' => 'index'));
  Router::connect('/newest', array('controller' => 'books', 'action' => 'sublist'));
  $arr = array('qingchun' , 'yanqing','chuanyue', 'wuxia','xuanhuan','wenxue','xuanyi','dushi','lishi','jingguan');
  foreach ($arr as $key => $value) {
    Router::connect('/' . $value . ".html", array('controller' => 'books', 'action' => 'listx'));
    Router::connect('/' . $value . "/*", array('controller' => 'books', 'action' => 'listx'));
  }
  Router::connect('/allbooks.html',array('controller' => 'books', 'action' => 'allbooks'));
  
	CakePlugin::routes();

	require CAKE . 'Config' . DS . 'routes.php';
