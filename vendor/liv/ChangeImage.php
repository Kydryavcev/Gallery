<?php
namespace vendor\liv\ChangeImage;

class ChangeImage
{
    # creating an image with the desired parameters
    public function create($image, $path)
    {

      $sx =  imagesx($image);
      $sy =  imagesy($image);

      $width  = 600;
      $height = 1000;

      $imageTrue = imagecreatetruecolor($width, $height);

      $a = $sx / $width;
      $b = $sy / $height;

      $zoom = 1;

      if ($a >= $b) {
        $zoom = $a;
      } else {
        $zoom = $b;
      }

      $sxTrue = $sx / $zoom;        
      $syTrue = $sy / $zoom;

      $paddingX = 0;
      $paddingY = 0;

      if (($sxTrue / $width) <= ($syTrue / $height)) {
        $paddingX = ($width - $sxTrue) / 2;
      }else {
        $paddingY = ($height - $syTrue) / 2;
      }
      
      imagecopyresized($imageTrue, $image, $paddingX, $paddingY, 0, 0, $sxTrue,  $syTrue, $sx, $sy);
      imagejpeg($imageTrue, "$path/".time()."foto.jpg");
    }
    
    public function downloadJpeg($tmp, $path)
    {        
      $image = imagecreatefromjpeg($tmp);
      self::create($image, $path);
    }

    public function downloadPng($tmp, $path)
    {        
      $image = imagecreatefrompng($tmp);

      self::create($image, $path);
    }

    public function downloadGif($tmp, $path)
    {        
      $image = imagecreatefrompng($tmp);

      self::create($image, $path);
    }
}
