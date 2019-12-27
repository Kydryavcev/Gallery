<?php
require_once 'vendor/liv/ChangeImage.php';
use vendor\liv\ChangeImage\ChangeImage;

$imgDir = "img"; # name directory  
$errors = array();

@mkdir($imgDir, 0777); # creation of a directory in its absence

# uploading a file to the directory
if (@$_REQUEST['doUpload']) {
  $data = $_FILES['file'];
  $tmp = $data['tmp_name'];

  if (is_uploaded_file($tmp)) {
  $info = @getimagesize($tmp);
  $img = new SplFileInfo($info['mime']);
  echo $img;

    if (preg_match('{image/(.*)}is', $info['mime'], $p)) {

      $download = new ChangeImage;

      # check type of photo and create image
      if ($img == 'image/jpeg') {
        $download->downloadJpeg($tmp, $imgDir);
      }elseif ($img == 'image/png') {
        $download->downloadPng($tmp, $imgDir);
      }elseif ($img == 'image/gif') {
        $download->downloadGif($tmp, $imgDir);
      }else {
        $errors[] = "<h2>Данный тип изображений не поддерживается!</h2>";
      }

    } else {
      $errors[] = "<h2>Попытка добавить файл недопустимого формата!</h2>";
    }
  } else {
    $errors[] = "<h2>Ошибка закачки #{$data['error']}!</h2>";
  }
}
  
$photos = array();
foreach (glob("$imgDir/*") as $path) {
  $sz = getimagesize($path); 
  $tm = filemtime($path);    
  
  $photos[$tm] = [
    'time' => $tm,              
    'name' => basename($path),  
    'url'  => $path,            
    'w'    => $sz[0],           
    'h'    => $sz[1],           
    'wh'   => $sz[3]            
  ];
}
  
krsort($photos);  
  
require_once 'view.php';
?>