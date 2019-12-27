<!DOCTYPE html>
<html lang='ru'>
<head>
  <title>Фотоальбом</title>
  <meta charset='utf-8'>
</head>
<body>
<!-- errors output -->
<?php for ($i=0; $i < count($errors); $i++) {?>
  <strong><?= $errors[$i] ?></strong><br>
<?php } ?>
<!-- end errors output -->
<form action="<?=$_SERVER['SCRIPT_NAME']?>" method="POST" enctype="multipart/form-data">
<input type="file" name="file"><br>
<input type="submit" name="doUpload" value="Закачать новую фотографию">
<hr>
</form>
<!-- photo album output -->
<?php foreach($photos as $n=>$img) {?>
  <p><img 
   src="<?=$img['url']?>"
   <?=$img['wh']?> 
   alt="Добавлена <?=date("d.m.Y H:i:s", $img['time'])?>"
  >
<?php } ?>
<!-- end photo album output -->
</body>
</html>
