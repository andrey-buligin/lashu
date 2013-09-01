<?php

	/**
	 * Cache class 
	 * Used to cache data ..designied for mysql tables data keeping from http://pc.smartmedical.eu/
	 * We use cache file EVERYTIME when we need data from table, cache file updates himself after some period of time
	 * 
	 */
	
	class Cache{
		
		public static $cacheDir;
		public $fileName;
		public $filePath;
		public $remoteUrl;
		public $serialize;
		
		/************************************************************************************/
		/**
		 * Creating new cache object
		 *
		 * @param string $fileName - name of cache file(file is saved in $cacheDir.
		 * @param $remoteUrl - url of remote document, from which we going to upload data to cache
		 * @param boolean $serializedData - serialize/unserialize this cachefile or not (on saving and getting it content)
		 */
		
		function __construct($fileName = 'temp.txt', $remoteUrl, $serializedData = false) {
			
			self::$cacheDir = dirname(__FILE__).'/../DATABASE/cache_files';
			if (!file_exists(self::$cacheDir)){
				$created = mkdir(self::$cacheDir);
				if (!$created) {
					echo '<div style="text-align:center;color:red">You dont`t have permissions to mkdir</div>';	
				}
			}
			$this->filePath 	= self::$cacheDir.'/'.$fileName;
			$this->fileName 	= $fileName;
			$this->remoteUrl 	= $remoteUrl;
			$this->serialize 	= $serializedData;
		}
		
		
		/************************************************************************************/
		/**
		 * Creating of cache file. Using serialize if needed for saving array of data.
		 *
		 * @param mixed $data - content or array that we put into file
		 * @param string $filePath - full path to cache file (if isn`t specified we use filepath of our object)
		 */
		
		function setCache($data, $filePath = null){
			if (@$this->serialize) {
				$data = serialize($data);
			}
			file_put_contents(@$filePath ? $filePath : $this->filePath, $data);
		}	
		
		
		/************************************************************************************/
		/**
		 * Getting data from cache file. Using unserialize if needed.
		 *
		 * @param string $filePath - full path to cache file (if isn`t specified we use filepath of our object)
		 * @return string
		 */
		
		function getCache($filePath = null){
			$data = file_get_contents(@$filePath ? $filePath : $this->filePath);
			if (@$this->serialize) {
				$data = unserialize($data);
			}
			return $data;
		}	
			
		
		/************************************************************************************/
		/**
		 * Inserting content from specific url into cache file.
		 *
		 * @param string $filePath - full path to cache file (if isn`t specified we use filepath of our object)
		 * @param string $remoteUrl - url of remote document, from which we going to upload data to cache (if isn`t specified we use url of our object)
		 * @return boolean T/F if file was uploaded succesufully
		 */
		
		function uploadToCache($filePath = null, $remoteUrl = null){
			$remoteData = @self::getCache(@$remoteUrl ? $remoteUrl : $this->remoteUrl);
			if ($remoteData) {
				self::setCache($remoteData, $filePath);
				return true;
			} else {
				return false;
			}
		}		
		
		
		/************************************************************************************/
		/**
		 * Deliting cache file
		 *
		 * @param unknown_type - $full path to cache file (if isn`t specified we use filepath of our object)
		 * @return 
		 */
		
		function destroyCache($filePath = null){
			return unlink(@$filePath ? $filePath : $this->filePath);
		}
		
		
		/************************************************************************************/
		/**
		 * Checking cache file for existance and its last modif. time
		 * if file doesnt exist or it was modified $TIME seconds ago
		 * we try to create it from uploading it from specified url
		 * 
		 * @param string $filePath  - full filepath to our cachefile
		 * @param string $remoteUrl - remote url from which content we put into our cache file
		 * @param integer $time - second interval after which we need to try reupload cache file
		 * @return boolean - T/F if cache was updated
		 */
		
		function chechkCache($filePath = null, $remoteUrl = null, $time = 300) {
			
			$file = @$filePath  ? $filePath  :  $this->filePath;
			$url  = @$remoteUrl ? $remoteUrl :  $this->remoteUrl;
			if (!file_exists($file)) {
				$uploaded = self::uploadToCache($file, $url);
				return $uploaded;
			} else {
				if (filectime($file)+$time > time()) {
					return false;
				} else {
					$uploaded = self::uploadToCache($file, $url);
					return $uploaded;
				}
			}
		}
	}
	
?>