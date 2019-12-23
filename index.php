<?php
  $imgDir = "img";    
  @mkdir($imgDir, 0777);  
  
  if (@$_REQUEST['doUpload']) {
    $data = $_FILES['file'];
    $tmp = $data['tmp_name'];
    
    if (is_uploaded_file($tmp)) {
      $info = @getimagesize($tmp);
      
      if (preg_match('{image/(.*)}is', $info['mime'], $p)) {
          

        $name = "$imgDir/".time().".".$p[1];
        
        move_uploaded_file($tmp, $name);
      } else {
        echo "<h2>Попытка добавить файл недопустимого формата!</h2>";
      }
    } else {
      echo "<h2>Ошибка закачки #{$data['error']}!</h2>";
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
  
?>
<!DOCTYPE html>
<html lang='ru'>
<head>
  <title>Простейший фотоальбом с возможностью закачки</title>
  <meta charset='utf-8'>
</head>
<body>
<form action="<?=$_SERVER['SCRIPT_NAME']?>" method="POST" enctype="multipart/form-data">
<input type="file" name="file"><br>
<input type="submit" name="doUpload" value="Закачать новую фотографию">
<hr>
</form>
<?php foreach($photos as $n=>$img) {?>
  <p><img 
   src="<?=$img['url']?>"
   <?=$img['wh']?> 
   alt="Добавлена <?=date("d.m.Y H:i:s", $img['time'])?>"
  >
<?php } ?>
</body>
</html>