<?php
	/**
	* Image Component
	* 
	*
	* PHP versions 5.1.4
	* @filesource
	* @author     Sujeesh.V 
	* @link       http://www.supportresort.com/
	* @link       http://cribhut.com Cribhut
	* @copyright  Copyright ª 2007 Cribhut
	* @version 0.0.1 
	*   - Initial release
	*/

 class ThumbComponent extends Object {
	/**
	* If set to true new image will be saved to a  file
	* @access var
	*/
	var $save_to_file = true;
	/**
	* Quality for jpeg and png
	* @access var
	*/
	var $image_quality = 100;
	/**
	* Resulting image type
	* @access var
	*/
	var $image_type = 0;
	/**
	* Maximum Image size
	* @access var
	*/
	var $max_x = 100;
	var $max_y = 100;
	/**
	* Image folder
	* @access var
	*/
	var $image_folder = 'img';
	/**
	* Thumb image folder
	* @access var
	*/
	var $thumb_folder ='img/category/Thumb';
	/**
	* image resource
	* @access var
	*/
	var $img_res  =NULL;
	/**
	* Constructor.
	* @param NULL 
	**/
/*
	function  __construct($img_options = NULL)
	{
		/*if(!empty($img_options)) {
			$this->save_to_file = isset($img_options['save_to_file'])?$img_options['save_to_file']:true;
			$this->image_quality = isset($img_options['quality'])?$img_options['quality']:100;
			$this->image_type = isset($img_options['type'])?$img_options['type']:0;
			$this->max_x = isset($img_options['max_x'])?$img_options['max_x']:100;
			$this->max_y = isset($img_options['max_y'])?$img_options['max_y']:100;
		}
		
	}*/

	function isExists($image_name,$thumb = false)
	{
		$fldr = $thumb?$this->thumb_folder:$this->image_folder; 
		if(file_exists($fldr."/".$image_name)) { 
			return true;
		} else {
			return false;
		}
	}

	function saveImage($filename,$thumb = true)
	{ 
		$res = null;
		if(!$this->isExists($filename,$thumb)) { 
		    	switch($this->image_type) {
				case 1 :  if($this->save_to_file) { 	
					   	$res = imagegif($this->img_res,$this->thumb_folder."/".$filename,100);
						chmod($this->thumb_folder."/".$filename,0777);
					  } else {
						header("Content-type: image/gif");
        					$res = imagegif($this->img_res);
					  }
					   break;
				case 2 :  if($this->save_to_file) {	
					   	$res = imagejpeg($this->img_res,$filename,$this->image_quality);
					  } else {
						header("Content-type: image/jpeg");
        					$res = imagejpeg($this->img_res,NULL,$this->image_quality);
					  }
					   break; 
				case 3 :  if($this->save_to_file) {	
					   	$res = imagepng($this->img_res,$filename,$this->image_quality);
					  } else {
						header("Content-type: image/png");
        					$res = imagepng($this->img_res);
					  }
					   break; 
			
			}
		}
		return $res;

	}
	function imageCreateFromType($filename) 
	{
 		$res = null;
		
// 		$filename = $this->image_folder."/".$filename;
 		switch ($this->image_type) {
  			case 1:
     				$res = ImageCreateFromGif($filename);
     				break;
   			case 2:
     				$res = ImageCreateFromJpeg($filename);
     				break;
   			case 3:
    				$res = ImageCreateFromPNG($filename);
     				break;
  		}
  		return $res;
	}
	function  createThumbnail($from_file)
	{
		 if(!$this->isExists($from_file)) {
			return false;
		 }
		 if($this->isExists('thumb_'.$from_file,true)) {
			return 'thumb_'.$from_file;
		  }
		
	
		 list($orig_x, $orig_y, $orig_img_type, $img_sizes) = GetImageSize($this->image_folder."/".$from_file);
		 $this->image_type = $orig_img_type;
// 		 if($orig_x > $this->max_x || $orig_y > $this->max_y) { 
// 		 	$x = $orig_x / $this->max_x;
// 			$y  = $orig_y / $this->max_y;
// 			if($x > $y) {
// 				$this->max_x = $orig_x/$this->max_x;
// 			} else {
// 				$this->max_y  = $orig_y/$this->max_y;
// 			}
// 			
// 		 } else { 
			
		 	if($this->save_to_file) {
// 				copy($this->image_folder."/".$from_file,$this->thumb_folder."/"."Thumb1_".$from_file);
			} else {
      				switch ($image_type) {
        			case 1:
           				 header("Content-type: image/gif");
           				 readfile($from_name);
          				 break;
        			case 2:
            				header("Content-type: image/jpeg");
            				readfile($from_name);
          				break;
        			case 3:
           				header("Content-type: image/png");
            				readfile($from_name);
          				break;
      				}
    			}
// 		 return;
// 		}
		// Get new dimensions
		list($width, $height) = getimagesize($this->image_folder."/".$from_file);
		$new_width = 120;//$orig_x * 0.5;
        $new_height = 100;//  $orig_y * 0.5;
		// $this->max_x = 25;$this->max_y=24;
  		$hx = (100 / ($width / $new_width)) * .01;
		$hx = @round ($new_height * $hx);

		$wx = (100 / ($new_height / $h)) * .01;
		$wx = @round ($new_width * $wx);

		if ($hx < $new_width) {
			$new_height = (100 / ($width / $new_width)) * .01;
			$new_height = @round ($height * $new_height);
		} else {
			$new_width = (100 / ($height / $new_height)) * .01;
			$new_width = @round ($width * $new_width);
		}
		if ($this->image_type == 1) {
   		 	// should use this function for gifs (gifs are palette images)
    			$ni = imagecreate($new_width, $new_height);
  		} else {
   			 // Create a new true color image
    			$ni = ImageCreateTrueColor($new_width, $new_height);
  		}    			$ni = ImageCreateTrueColor($new_width, $new_height);

// 		$image_p = imagecreatetruecolor($new_width, $new_height);
		$image = $this->imageCreateFromType($this->image_folder."/".$from_file);
// 		$image = imagecreatefromgif($this->image_folder."/".$from_file);
		imagecopyresampled($ni, $image, 0, 0, 0, 0,$new_width, $new_height,$width,$height);
		copy($this->image_folder."/".$from_file,$this->thumb_folder."/"."thumb_".$from_file);
		// Output
		if(imagegif($ni, $this->thumb_folder."/"."thumb_".$from_file, 100)) {
			return "thumb_".$from_file;
		} else {
			echo "failed ... :( ";
		}

		
// 	
	}
	function getResized($id, &$mime, $imgFolder, $newWidth=false, $newHeight=false, $bgcolor="#F8B031", $resample=true, $cache=false, $cacheFolder=false, $cacheClear=false, $tempFolder=false)
	{//die("sdfdsxgsdfa");
		
		$img = $imgFolder . $id;
		list($oldWidth, $oldHeight, $type) = getimagesize($img); 
		$ext = $this->image_type_to_extension($type);
		$mime = image_type_to_mime_type($type);
		//echo $cacheFolder;
		//echo $tempFolder;
		//die('asdfasf');
		if ($cache AND is_writeable($cacheFolder))
		{
			$dest = $cacheFolder . $id;
			//. '_' . $newWidth . 'x' . $newHeight;
		}
		else if (is_writeable($tempFolder))
		{
			$dest = $tempFolder . $id;
		}
		else
		{
			echo "You must set either a cache folder or temporal folder for image processing. And the folder has to be writable.";
			exit();
		}
		
		if ($newWidth OR $newHeight)
		{
			if($cacheClear && file_exists($dest))
			{	
				unlink($dest);
			}
			
			/*
			if($cache AND file_exists($dest))
			{
				$i = fopen($dest, 'rb');
			}
			else
			{
			*/
			//echo "new".$newWidth;
			//echo "old".$oldWidth;
			
				if(($newWidth > $oldWidth) && ($newHeight > $oldHeight)) 
				{
					$applyWidth = $oldWidth;
					$applyHeight = $oldHeight;
				} 
				else
				{
					if(($newWidth/$newHeight) < ($oldWidth/$oldHeight)) 
					{
						$applyHeight = $newWidth*$oldHeight/$oldWidth;
						$applyWidth = $newWidth;
					} 
					else
					{
						$applyWidth = $newHeight*$oldWidth/$oldHeight;
						$applyHeight = $newHeight;
					}
				}
				
				switch($ext)
				{
					case 'gif' :
						$oldImage = imagecreatefromgif($img);
						//$newImage = imagecreate($newWidth, $newHeight);
						$newImage = imagecreatetruecolor($newWidth, $newHeight);
						break;
					case 'png' :
						$oldImage = imagecreatefrompng($img);
						$newImage = imagecreatetruecolor($newWidth, $newHeight);
						break;
					case 'jpg' :
						$oldImage = imagecreatefromjpeg($img);
						$newImage = imagecreatetruecolor($newWidth, $newHeight);
						break;
					case 'jpeg' :
						$oldImage = imagecreatefromjpeg($img);
						$newImage = imagecreatetruecolor($newWidth, $newHeight);
						break;
					default :
						return false;
						break;
				}
				$red	=	15;
				$green	=	117;
				$blue	=	188;
				sscanf($bgcolor, "%2x%2x%2x", $red, $green, $blue);
				$newColor = ImageColorAllocate($newImage, $red, $green, $blue); 
				imagefill($newImage,0,0,$newColor);
				
				if ($resample==true)
				{
					
					imagecopyresampled($newImage, $oldImage, ($newWidth-$applyWidth)/2, ($newHeight-$applyHeight)/2, 0, 0, $applyWidth, $applyHeight, $oldWidth, $oldHeight);
				}
				else
				{
					//echo $newImage;
					//echo  $oldImage;
					imagecopyresized($newImage, $oldImage, ($newWidth-$applyWidth)/2, ($newHeight-$applyHeight)/2, 0, 0, $applyWidth, $applyHeight, $oldWidth, $oldHeight);
				}
	//die;
				
					switch($ext)
					{
						case 'gif' :
							//imagegif($newImage, $dest);
						imagepng($newImage, $dest);
							break;
						case 'png' :
							imagepng($newImage, $dest);
							break;
						case 'jpg' :
							imagejpeg($newImage, $dest);
							break;
						case 'jpeg' :
							imagejpeg($newImage, $dest);
							break;
						default :
							return false;
							break;
					}
				
				//imagedestroy($newImage);
				//imagedestroy($oldImage);
				//$i = fopen($dest, 'rb');
			//}

		}
		else
		{
			//$i = fopen($img, 'rb');
		}
		
		//return $i;
	}

	function getBanner($id, &$mime, $imgFolder, $newWidth=false, $newHeight=false, $bgcolor="#FFFFFF", $resample=true, $cache=false, $cacheFolder=false, $cacheClear=false, $tempFolder=false)
	{//die("sdfdsxgsdfa");
		$img = $imgFolder . $id;
		list($oldWidth, $oldHeight, $type) = getimagesize($img); 
		$ext = $this->image_type_to_extension($type);
		$mime = image_type_to_mime_type($type);

		if ($cache AND is_writeable($cacheFolder))
		{
			$dest = $cacheFolder . $id;
			//. '_' . $newWidth . 'x' . $newHeight;
		}
		else if (is_writeable($tempFolder))
		{
			$dest = $tempFolder . $id;
		}
		else
		{
			echo "You must set either a cache folder or temporal folder for image processing. And the folder has to be writable.";
			exit();
		}
		
		if ($newWidth OR $newHeight)
		{
			if($cacheClear && file_exists($dest))
			{	
				unlink($dest);
			}
			
			/*
			if($cache AND file_exists($dest))
			{
				$i = fopen($dest, 'rb');
			}
			else
			{
			*/
			//echo "new".$newWidth;
			//echo "old".$oldWidth;
			
				
				
					
						$applyWidth = $newWidth;
						$applyHeight = $newHeight;
					
		}
				
				switch($ext)
				{
					case 'gif' :
						$oldImage = imagecreatefromgif($img);
						//$newImage = imagecreate($newWidth, $newHeight);
						$newImage = imagecreatetruecolor($newWidth, $newHeight);
						break;
					case 'png' :
						$oldImage = imagecreatefrompng($img);
						$newImage = imagecreatetruecolor($newWidth, $newHeight);
						break;
					case 'jpg' :
						$oldImage = imagecreatefromjpeg($img);
						$newImage = imagecreatetruecolor($newWidth, $newHeight);
						break;
					case 'jpeg' :
						$oldImage = imagecreatefromjpeg($img);
						$newImage = imagecreatetruecolor($newWidth, $newHeight);
						break;
					default :
						return false;
						break;
				}
				$red	=	255;
				$green	=	255;
				$blue	=	255;
				sscanf($bgcolor, "%2x%2x%2x", $red, $green, $blue);
				$newColor = ImageColorAllocate($newImage, $red, $green, $blue); 
				imagefill($newImage,0,0,$newColor);
				
				if ($resample==true)
				{
					
					imagecopyresampled($newImage, $oldImage, ($newWidth-$applyWidth)/2, ($newHeight-$applyHeight)/2, 0, 0, $applyWidth, $applyHeight, $oldWidth, $oldHeight);
				}
				else
				{
					//echo $newImage;
					//echo  $oldImage;
					imagecopyresized($newImage, $oldImage, ($newWidth-$applyWidth)/2, ($newHeight-$applyHeight)/2, 0, 0, $applyWidth, $applyHeight, $oldWidth, $oldHeight);
				}
	//die;
				
					switch($ext)
					{
						case 'gif' :
							//imagegif($newImage, $dest);
						imagepng($newImage, $dest);
							break;
						case 'png' :
							imagepng($newImage, $dest);
							break;
						case 'jpg' :
							imagejpeg($newImage, $dest);
							break;
						case 'jpeg' :
							imagejpeg($newImage, $dest);
							break;
						default :
							return false;
							break;
					}
				
				//imagedestroy($newImage);
				//imagedestroy($oldImage);
				//$i = fopen($dest, 'rb');
			//}

		
		
		//return $i;
	}
	
	function image_type_to_extension($imagetype)
	{
	if(empty($imagetype)) return false;
		switch($imagetype)
		{
			case IMAGETYPE_GIF    : return 'gif';
			case IMAGETYPE_JPEG    : return 'jpg';
			case IMAGETYPE_PNG    : return 'png';
			case IMAGETYPE_SWF    : return 'swf';
			case IMAGETYPE_PSD    : return 'psd';
			case IMAGETYPE_BMP    : return 'bmp';
			case IMAGETYPE_TIFF_II : return 'tiff';
			case IMAGETYPE_TIFF_MM : return 'tiff';
			case IMAGETYPE_JPC    : return 'jpc';
			case IMAGETYPE_JP2    : return 'jp2';
			case IMAGETYPE_JPX    : return 'jpf';
			case IMAGETYPE_JB2    : return 'jb2';
			case IMAGETYPE_SWC    : return 'swc';
			case IMAGETYPE_IFF    : return 'aiff';
			case IMAGETYPE_WBMP    : return 'wbmp';
			case IMAGETYPE_XBM    : return 'xbm';
			default                : return false;
		}
	}
//EXPLANATION OF PARAMETERS For:getResized
/*
$id, String with name of the image file. Example: myphoto.jpg, 33.gif, file0000, etc... The file is analysed for image headers, so file extensions are not important)

&$mime, Var thats passed as a reference, the function assigns the mime type to it, so the view can output the header.

$imgFolder, String with the complete path to the image file. 

$newWidth=false, New width, in pixels, of the image... if none is passed, then the image is rendered at the original size.

$newHeight=false, New height, in pixels, of the image... if none is passed, then the image is rendered at the original size.

$bgcolor="000000", hexadecimal color for the background of the image. This shows when you resize an image to a new proportion. Instead of distortion, bars with this color are rendered. If the var is ommited, black bars are rendered

$resample=true, Boolean for resampling the image when resizing, if set to false image is resized without interpolating pixels, While this uses less computing resources, the visual result is poor.

$cache=false, If set true, a file is written for each resizing job, so in case its called twice, the saved files is passed, avoiding a repeated computing job.

$cacheFolder=false, The folder where cached files should be written, must be writable.

$cacheClear=false, If set true, the function will delete the cached image and write a new one. Useful for administration backends.

$tempFolder=false, in case cache is set false, a temporal folder is required for rendered images, i havent coded yet the function that cleans the temporal folder.
)
*/	
 }