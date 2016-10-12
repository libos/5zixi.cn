<?php
App::uses('Helper', 'View');
App::import("Model", "Document");  
App::import("Model", "Book");  
App::import("Model", "User");  
class AppHelper extends Helper {

  public function isHere($value='')
  {
    if (strpos($this->request->here,$value) !== false) {
      return true;
    }
    return false;
  }
  
  public function formatSize($bytes='')
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
  public function getPartBook($bid)
  {
    $model = new Book();
    $book = $model->find('first',array('recursive'=>-1,'conditions'=>array('Book.bid'=>$bid)));
    return $book;
  }
  public function getPath($value='')
  {
    return '/book/' . $value . ".html";
  }
  public function getFullPath($created,$burl,$bid)
  {
    $tt = strtotime($created);
    $ym = date('Ym',$tt);
    $dd = date('d',$tt);
    return "/books/" . $ym . "/" . $dd . "/" . $bid . "/" . "id_" .$burl . ".html";
  }
  public function getUser($value='')
  {
    $model = new User();
    $user = $model->findByUid($value);
    return $user;
  }
  public function getAvatar($value='')
  {
    if ($value == 0) {
      return '/img/avatar.png';
    }
    $model = new User();
    $user = $model->findByUid($value);
    if (empty($user)) {
      return '/img/avatar.png';
    }
    return $user['User']['avatar'];
  }
  public function getCoverByFengmian_id($fengmian_id,$img)
  {
    if ($fengmian_id == 0) {
      return '/img/nocover.jpg';
    }
    if (empty($img)) {
      return '/img/nocover.jpg';
    }
    return $img['link'];
  }
  public function getcover($value='')
  {
    if ($value == 0) {
      return '/img/nocover.jpg';
    }
    $model = new Document();
    $doc = $model->findByDid($value);
    if (empty($doc)) {
      return '/img/nocover.jpg';
    }
    return $doc['Document']['link'];
  }
  
  public function getTextSize($value='')
  {
    if ($value == 0) {
      return '0 Byte';
    }
    $model = new Document();
    $doc = $model->findByDid($value);
    if (empty($doc)) {
      return '0 Byte';
    }
    return $this->formatSize($doc['Document']['size']);
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
  
  public function search_highlight($text, $terms_rx){
    
  		$start = '(^|<(?:.*?.)>)';
  		$end   = '($|<(?:.*?)>)';

      return preg_replace(
  			"/$start(.*?)$end/se",
  			"StripSlashes('\\1').".
          "\$this->search_highlight_inner(StripSlashes('\\2'), \$terms_rx).".
  				"StripSlashes('\\3')",
  			$text
  		);
  }
  public function search_highlight_inner($text, $terms_rx){
  		foreach($terms_rx as $term_rx){

  			$text = preg_replace(
  					"/($term_rx)/ise",
  					"\$this->search_highlight_do(StripSlashes('\\1'))", 
  					$text
  				);
  		}
  		return $text;
  	}

  	function search_highlight_do($fragment){
  		return "<span class='selected'>$fragment</span>";
  	}
}
