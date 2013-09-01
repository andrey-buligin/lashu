<?php 

require_once(dirname(__FILE__).'/../../../config/config.php');
require_once($_CFG['path_to_modules'].'/components/imgResizes.php');
require_once($_CFG['path_to_modules'].'/libraries/portfoliomanager.class/portfoliomanager.php');
require('upload.class.php');

/**
 * TODO: benchmark current imagemagick and Upload.class resizing methods.
 * Class used for uploading images for portfolio galleries module.
 * @author Bula
 *
 */
Class MultiUploadHandler extends UploadHandler {
    
    const TABLE_NAME = '_mod_portfolio';
    
    private $imagesQueue;
    private $sortId;
    private $categoryId;
    private $portfolioManager;
    
    function __construct($options=null) {
        global $_CFG;
        
        parent::__construct($options);
        
        $this->portfolioManager = new PortfolioManager;
        $this->categoryId = $_GET['id'] ? $_GET['id'] : 28;
        $this->options['upload_dir'] = $_CFG['path_to_images'].'/portfolio_original/';
        $this->options['upload_url'] = $this->getFullUrl().'/portfolio_original/';
        $this->options['image_versions'] = array(
            // Uncomment the following version to restrict the size of
            // uploaded images. You can also add additional versions with
            // their own upload directories:
            /*
            'large' => array(
                'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']).'/files/',
                'upload_url' => $this->getFullUrl().'/files/',
                'max_width' => 1920,
                'max_height' => 1200,
                'jpeg_quality' => 95
            ),
            */
            'thumbnail' => array(
                'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']).'/thumbnails/',
                'upload_url' => $_CFG['url_to_modules'].'libraries/multiupload/thumbnails/',
                'max_width' => 80,
                'max_height' => 80
            ) 
        );
    }
    
    protected function getFullUrl() {
        global $_CFG;
        
      	return $_CFG['url_to_images'];
    }
    
    private function insertImagesToDB() {
        if ( is_array($this->imagesQueue) ) {
            $query = "INSERT INTO ".self::TABLE_NAME." (created, category_id, sort_id, active, title_eng, description_eng, image_small) VALUES ".implode(',', $this->imagesQueue);
            //file_put_contents('my_log', 'time:'.date("d.m.Y H:i:s").' inserting:'.$query."\n", FILE_APPEND );
            $res = mysql_query($query);
            //file_put_contents('my_log', 'time:'.date("d.m.Y H:i:s").' mysql_error:'.mysql_error()."\n",FILE_APPEND );
        }
    }
    
    private function addImageToQueue( $imgData ) {
        if ( $this->sortId === null) {
            $this->sortId = @mysql_result(mysql_query("SELECT MAX(sort_id) FROM ".self::TABLE_NAME." WHERE category_id = ".$this->categoryId), 0, 0);
        }
        
        $imgTitle = $imgData->name;
        $file_path = $this->options['upload_dir'].$imgTitle;
        list($imgWidth, $imgHeight) = getimagesize($file_path);
        $image = array(
        			'alt'    => $imgTitle,
                    'width'  => $imgWidth,
                    'height' => $imgHeight,
                    'src'    => 'portfolio_original/'.$imgTitle
                 );
        
        $imgActualSize = filesize($file_path);
        if ($imgActualSize === $imgData->size) {
            $this->resizeRelevantImages( $image );
        }
        
        $this->imagesQueue[] = '('. time() .', 
        						 '. $this->categoryId .', 
        						 '. ++$this->sortId .',
        						  1, 
        						"'. mysql_real_escape_string($imgTitle) .'", 
        						"'. mysql_real_escape_string($imgTitle) .'", 
        						"'. mysql_real_escape_string(serialize($image)) .'")';
        return $image;
    }
    
    public function resizeRelevantImages( $image ) {
        $currentGallery = $this->portfolioManager->getCurrentPorfolioGallery();
		   
		$sizes = $this->portfolioManager->getSizesArray();
		$fixedSizes = $this->portfolioManager->getFixedSizesFlagArray();
		    
		//resizePortfolioImages( $image, $sizes, $fixedSizes );
    }
    
    public function post() {
        $upload = isset($_FILES[$this->options['param_name']]) ?
            $_FILES[$this->options['param_name']] : null;
        $info = array();
        
        if ($upload && is_array($upload['tmp_name'])) {
            
            // param_name is an array identifier like "files[]",
            // $_FILES is a multi-dimensional array:
            foreach ($upload['tmp_name'] as $index => $value) {
                $imgData = $this->handle_file_upload(
                    $upload['tmp_name'][$index],
                    isset($_SERVER['HTTP_X_FILE_NAME']) ?
                        $_SERVER['HTTP_X_FILE_NAME'] : $upload['name'][$index],
                    isset($_SERVER['HTTP_X_FILE_SIZE']) ?
                        $_SERVER['HTTP_X_FILE_SIZE'] : $upload['size'][$index],
                    isset($_SERVER['HTTP_X_FILE_TYPE']) ?
                        $_SERVER['HTTP_X_FILE_TYPE'] : $upload['type'][$index],
                    $upload['error'][$index],
                    $index
                );
                $info[] = $imgData;
                if ( !isset($imgData->error) ) {
                    $this->addImageToQueue($imgData);
                } else {
                    file_put_contents('my_log', 'time:'.date("d.m.Y H:i:s").' data came with error:'.$imgData->error."\n", FILE_APPEND );
                }
            }
            
        } elseif ($upload || isset($_SERVER['HTTP_X_FILE_NAME'])) {
            
            // param_name is a single object identifier like "file",
            // $_FILES is a one-dimensional array:
            $imgData = $this->handle_file_upload(
                isset($upload['tmp_name']) ? $upload['tmp_name'] : null,
                isset($_SERVER['HTTP_X_FILE_NAME']) ?
                    $_SERVER['HTTP_X_FILE_NAME'] : (isset($upload['name']) ?
                        $upload['name'] : null),
                isset($_SERVER['HTTP_X_FILE_SIZE']) ?
                    $_SERVER['HTTP_X_FILE_SIZE'] : (isset($upload['size']) ?
                        $upload['size'] : null),
                isset($_SERVER['HTTP_X_FILE_TYPE']) ?
                    $_SERVER['HTTP_X_FILE_TYPE'] : (isset($upload['type']) ?
                        $upload['type'] : null),
                isset($upload['error']) ? $upload['error'] : null
            );
            $info[] = $imgData;
            if ( !isset($imgData->error) ) {
                $this->addImageToQueue($imgData);
            } else {
                file_put_contents('my_log', 'time:'.date("d.m.Y H:i:s").' data came with error:'.$imgData->error."\n", FILE_APPEND );
            }
        }
        
        $this->insertImagesToDB();
        
        header('Vary: Accept');
        $json = json_encode($info);
        $redirect = isset($_REQUEST['redirect']) ?
            stripslashes($_REQUEST['redirect']) : null;
        if ($redirect) {
            header('Location: '.sprintf($redirect, rawurlencode($json)));
            return;
        }
        if (isset($_SERVER['HTTP_ACCEPT']) &&
            (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }
        echo $json;
    }
}
?>