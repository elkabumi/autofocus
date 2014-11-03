<?php
/*
* File: SimpleImage.php
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 08/11/06
* Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
* 
* This program is free software; you can redistribute it and/or 
* modify it under the terms of the GNU General Public License 
* as published by the Free Software Foundation; either version 2 
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of 
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
* GNU General Public License for more details: 
* http://www.gnu.org/licenses/gpl.html
*
*/
define('IMAGE_WIDTH', 150);
define('IMAGE_HEIGHT',200);

class Image {
   
   var $image;
   var $image_type;
	var $src_w,$src_h;
   function load($filename) {
      $image_info = list($src_w, $src_h) = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image,$filename);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image,$filename);
      }   
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image);
      }   
   }
   function getWidth() {
      return imagesx($this->image);
   }
   function getHeight() {
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100; 
      $this->resize($width,$height);
   }
   function resize($width=IMAGE_WIDTH,$height=IMAGE_HEIGHT) {
      $new_image = imagecreatetruecolor($width, $height);	 
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;   	  
   }      
    function resizeToPhoto() {
		$width=IMAGE_WIDTH;
		$height=IMAGE_HEIGHT;
		$ori_w = $this->getWidth();
		$ori_h = $this->getHeight();
		
		if($ori_w < $ori_h)$this->resizeToWidth(150);
		else $this->resizeToHeight(200);
		
		$ori_w = $this->getWidth();
		$ori_h = $this->getHeight();
		if($ori_w/$ori_h == 3/4)return;
		$new_image = imagecreatetruecolor($width, $height);
		$x = 0;
		$y = 0;
		
		if($ori_w > $ori_h) $biggestSide = $ori_w; //find biggest length
		else $biggestSide = $ori_h;                      

		$cropPercent = 0.5; 
		$cropWidth   = $width; 
		$cropHeight  = $height; 
   
		if($width < $ori_w || $height < $ori_h)
		{
			//if($width<$ori_w )
			$x = ($ori_w - $cropWidth)/2;
			//if($height<$ori_h )
			$y = ($ori_h - $cropHeight)/2;
			
			
		}
		imagecopyresampled($new_image, $this->image, 0, 0, $x, $y, $width, $height, $cropWidth, $cropHeight);
		$this->image = $new_image;   
		echo $x.'-'.$y;
	  
   }      
   function resizePhoto() {
		$width=IMAGE_WIDTH;
		$height=IMAGE_HEIGHT;
		$ori_w = $this->getWidth();
		$ori_h = $this->getHeight();
		
		$new_image = imagecreatetruecolor($width, $height);
		$x = 0;
		$y = 0;
		/*if($width > $height) $biggestSide = $width; //find biggest length
		else $biggestSide = $height; 
		*/
		$ratio_orig = $this->getWidth()/$this->getHeight(); // = 2
		if ($width/$height > $ratio_orig) 
		{
			$width = $height*$ratio_orig;
		} 
		else 
		{
			$height = $width/$ratio_orig;
		}
		
		 if($ori_w > $ori_h) $biggestSide = $ori_w; //find biggest length
       else $biggestSide = $ori_h; 
                     
//The crop size will be half that of the largest side 
   $cropPercent = 0.5; // This will zoom in to 100% zoom (crop)
   $cropWidth   = $biggestSide*$cropPercent; 
   $cropHeight  = $biggestSide*$cropPercent; 
   
	  if($width < $ori_w || $height < $ori_h)
	  {
			if($width<$ori_w )$x = ($ori_w - $cropWidth)/2;
			if($height<$ori_h )$y = ($ori_h - $cropHeight)/2;
			
			
	  }
      imagecopyresampled($new_image, $this->image, 0, 0, $x, $y, $width, $height, $cropWidth, $cropHeight);
      $this->image = $new_image;   
	  echo $x.'-'.$y;
	  
   }   
}
