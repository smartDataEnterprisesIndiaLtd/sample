<?php
/**
	* Component for File handling
	* 
	*
	* PHP versions 5.1.4
	* @filesource
	* @author     Sujeesh.V 
	* @link       http://www.supportresort.com/
	* @link       http://cribhut.com Cribhut
	* @copyright  Copyright © 2007 Cribhut
	* @version 0.0.1 
	*   - Initial release
	*/
class FileComponent extends Object {
	/**
	* Controller name
	* @access var
	*/
	var $controller;
	var $fileName;
	var $destPath;
	var $useHash = false;
	var $cleanName = false;

	 function startup( &$controller ) {
      		$this->controller = &$controller;
    	}

	 function getFileName()
	{
		return $this->fileName;
	}
	 function setFileName($fname)
	{	
		$this->fileName  = $fname;
	}
	 function setDestPath($path)
	{
		$this->destPath = $path;
	}
		
	 function uploadFile($originName,$tmp_name, $getRandomName =  False)
	{
		
		if(is_dir($this->destPath))	{
			
		$extDot = explode(".",$this->fileName);
		$ext = $extDot[count($extDot)-1];
		$this->fileName = ($getRandomName)?$this->getRandomFilename():$this->fileName;
		
		if(!strstr($this->fileName,".")) {
			$this->fileName .= ".".$ext;
		}
		
		
		//if($this->cleanName)	{
			$this->fileName = $this->clean_string(substr($this->fileName,0,strlen($this->fileName)-(strlen($ext) + 1))).".".$ext;
		//}
		
		$dest   = $this->destPath."/".$this->fileName;
		
		if(move_uploaded_file($tmp_name,$dest))	{
				chmod($dest,0777);
				return $this->fileName;
			}
			else {
				return false;
				
				}		
		}	else {
			echo 'Destination directory does not exists!';
			
		}
	}

/**
	@function:deleteFile
	@description: delete the old file
	@params:id
	@Created by: kulvinder
	@Modify:NULL
	@Created Date:Oct 29,2010
	*/
	 function deleteFile($oldFileName = null)
	{
		$destFile   = $this->destPath."/".$oldFileName;
		
		if( file_exists($destFile) ){
			@unlink($destFile);
		}
	}



	/**
	@function:deleteFile_bulkupload
	@description: delete the old file for bluk uploaded images from admin end
	@params:id
	@Created by: ramanpreet Pal Kaur
	@Modify:NULL
	@Created Date: April 11, 2011
	*/

	 function deleteFile_bulkupload($oldFileName = null)
	{
		if(file_exists($oldFileName) ){
			@unlink($oldFileName);
		}
	}





/* ********************************************************************************* */
	 function getRandomFileName()
	{	

		if($this->useHash===true)	{
				$fileName  = md5($this->controller->misc->generate_unique_string(10));
		}	else	{
				$fileName  = rand(1000,1000000);
		}		
		
		if($this->is_exists($fileName))
		{			
			$this->getRandomFileName();	
		}
		else
		{
			return $fileName;			
		}
	}
	 function is_exists($filename)
	{
		if(file_exists($this->destPath."/".$filename))
		{
			return true;
		} 
		else {
			return false;
		}

	}

	 function createHashValue($fileName){
		
		return md5(file_get_contents($fileName)+filesize($fileName));
	} 

	 function getFileExt($fileName)
	{
		return substr($fileName,strpos($fileName,"/")+1);
	}

	/* allow letters, numbers and underscore(-) only. removing anything else with underscore.
	for ex "myname is : No -- 007 i.e. Mr. Bond" will be changed to "myname_is_no_007_ie_mr_bond"
	*/
	 function clean_string($text)
	{
		$text = preg_replace('/[^\w]/', '_', $text);
		$text = preg_replace('/[\_\-]{1,}/', '_', $text);
		$text = preg_replace('/^\_?(.*?)\_?$/', '\1', $text);
		return strtolower($text);
	}
	
	
	
	//show date format
	function validateCsvFile($file_name){
		$file_name = strtolower(trim($file_name));
		$file_type = end(explode(".",$file_name));
		$acceptedFilesFormats = array('csv' ,'CSV' ) ;
		if( in_array($file_type , $acceptedFilesFormats) ){  // if in accepted formats
			return true;
		}else{
			return false;
		}
	}
	
	//show date format
	function validateImage($file_type){
		$file_type = trim($file_type);
		$acceptedFilesFormats = array('png','jpg','jpeg','gif', 'pjpeg') ;
		if( in_array(strtolower($file_type) , $acceptedFilesFormats) ){  // if in accepted formats
			return true;
		}else{
			return false;
		}
	}
	//show date format
	function validateGifJpgImage($file_type){
		$file_type = trim($file_type);
		$acceptedFilesFormats = array('jpg','jpeg','gif', 'pjpeg', 'pjpg') ;
		if( in_array(strtolower($file_type) , $acceptedFilesFormats) ){  // if in accepted formats
			return true;
		}else{
			return false;
		}
	}
}
?>