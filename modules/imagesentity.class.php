<?php
/**
 * ImageEntity is a class extension to allow Image management support for the Entity class.
 * @author Frédéric Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/08/08
 */
class ImagesEntity{
	static private $defaultImagesPath=null;
	static private $formatsAccepted=null;
	static private $thumbsSizes=null;
	static private $thumbsDefaultSize=null;

	protected $pictures = array();
	
	/**
	 * Intialize some defaut values
	 * - Base image path ($defaultImagesPath)
	 * - Image file format accepted ($formatsAccepted)
	 * - thumnails sizes to generate ($thumbsSizes)
	 * - default thumbnail size ($thumbsDefaultSize).
	 */
	public function __construct(){
		if(is_null(self::$defaultImagesPath)){
			__debug("Initialize default values from configuration file keys",__METHOD__,__CLASS__);
			self::$defaultImagesPath = __config('resources','path');
			self::$formatsAccepted  = __config('resources','formats');
			self::$thumbsSizes = __config('resources','thumbs_sizes');
			self::$thumbsDefaultSize = __config('resources','thumbs_default_size');
			__debug("imagesPath=".self::$defaultImagesPath.
					", formats=".self::$formatsAccepted.
					", thumbsSizes=[".print_r(self::$thumbsSizes,true)."]".
					", thumbsDefaultSize=".self::$thumbsDefaultSize,
					__METHOD__,__CLASS__);
		}
	}

	/**
	 * Parse resources directory for this entity inheriting this class and
	 * following the <code>$treetype</code> parameter, parse subdirectories to
	 * create the corresponding image and thumb attributes.
	 * if treeType="/support/title"
	 *  resources/Game/	 (base of the directory tree for the Game entity)
	 *	/x360			 (corresponding to the support attribut of the Game entity)
	 *	  /game_title	 (corresponding to the title attribut of the Game entity)
	 *		 /cover	   (sub-directory for cover images)
	 *		 /screenshots (sub-direcotry for screenshots images)
	 *		 /arts		(sub-direcotry for arts images)
	 * Corresponding attributes created for Game entity will be:
	 * game->attributes['cover'][n]
	 * game->attributes['screenshots'][n]
	 * game->attributes['arts'][n]
	 * 
	 * @param string $treeType '/' separated attribute list for images storing schema.
	 */
	public function loadImages($treeType="/id/",$categories=""){
		
		__debug("param: treeType='$treeType', categories='$categories', search for existing images into ".self::$defaultImagesPath,"loadImages",__CLASS__);
		$paths = $this->generateImagesPath($treeType);		
		$imagesAbsolutePath= $paths['absolute'];
		$imagesRelativePath= $paths['relative'];
		$categories = explode(',',$categories);
		//print_r($categories);
		if(file_exists($imagesAbsolutePath))
		{
			$dir = opendir($imagesAbsolutePath);
			while(false !== ($item = readdir($dir)))
			{
				if( 
					//((count($categories)>0 && isset($categories[$item])) || count($categories)==0) && 
					file_exists($imagesAbsolutePath."/".$item) 
					&& is_dir($imagesAbsolutePath."/".$item)
					)
				{
					$subdir = opendir($imagesAbsolutePath."/".$item."/");
					$subdirRelative = $imagesRelativePath."/".$item."/";
					$i=1;
					while(false !==($image = readdir($subdir)))
					{
						$file = $imagesAbsolutePath."/".$item."/".$image;
						$fileRelative = $subdirRelative.$image;
						if(is_file($file) 
								&& $image != "." 
								&& $image !=".." 
								&& $image !="Thumbs.db" 
								//&& preg_match('/(^\*)+[.]['.self::$formatsAccepted.']/',strtolower($image))
						){
							//echo("<pre>subdir=[$imagesAbsolutePath/$item]</pre>");
							//__debug("image=".$imagesAbsolutePath."/".$item."$image","loadImages",__CLASS__);
							$this->pictures[$item][$i]['image']=$fileRelative;
							
							if(!Image::getInstance(self::$thumbsSizes)->thumbsExists(
								$imagesAbsolutePath."/".$item."/thumbs/",
								self::$thumbsDefaultSize))
							{
								mkdir($imagesAbsolutePath."/".$item."/thumbs/");
								Image::getInstance(self::$thumbsSizes)->generateThumbs(
										$file,
										$imagesAbsolutePath."/".$item."/thumbs/",
										self::$thumbsDefaultSize);
							}
							foreach(explode(',',self::$thumbsSizes) as $thSize){
								$this->pictures[$item][$i]['thumb'][$thSize]=$imagesRelativePath."/".$item."/thumbs/".$thSize."/".basename($image,".jpg").".png";
							}
							Image::getInstance(explode(',',self::$thumbsSizes))->generateThumbs($file,$imagesAbsolutePath."/".$item."/thumbs/");
							$i++;
						}
					}
				}else{
					throw new Exception("Error during parsing image subdirectories into '".$imagesPath."'"); 
				}
			}
		}
	}
	
	/**
	 * Reutrn an Image. by default the cover.
	 * @param string $key Subdirectory image path.
	 * @param integer index Image number
	 * @param string thumb (optional) Size of the thumb.
	 */
	public function getPicture($key="default",$index=1,$thumb="",$default){
		
		if($thumb!=""){
			
			if(isset($this->pictures[$key][$index]['thumb'][$thumb])){
				return $this->pictures[$key][$index]['thumb'][$thumb];
			}else{
				return $this->pictures[$key][$index]['thumb'][self::$thumbsDefaultSize];
			}
		}else{
			
			return (isset($this->pictures[$key][$index]['image'])?$this->pictures[$key][$index]['image']:$default);
		}

	}
	/**
	 * Return all Images from <code>$key</code> category. by default the cover.
	 * @param string $key Subdirectory image path.
	 * @param integer index Image number
	 * @param string thumb (optional) Size of the thumb.
	 */
	public function getPictures($key="screenshots"){
		return (isset($this->pictures[$key])?$this->pictures[$key]:null);
	}
	
	/**
	 * Return Image thumbs. by default the cover.
	 * @param unknown_type $key
	 */
	public function getPictureThumb($key="default",$index=1, $default,$size=""){
		if($size==""){
			$size = self::$thumbsDefaultSize;
		}
		return (isset($this->pictures[$key][$index]['thumb'][$size])?$this->pictures[$key][$index]['thumb'][$size]:$default);
	}
	
	public function upload($treeType="id/"){
		
	}
	/**
	 * Generate an array containing bath absolute and relative path for image storing.
	 * @param $treeType
	 */
	public function generateImagesPath($treeType="id/"){
		$paths = array('relative'=>"",'absolute'=>"");
		$pathElements=explode('/',$treeType);
		$imagesPath="";
		foreach($pathElements as $pathElement)
		{
			if($pathElement!="")
			{
				$imagesPath .= "/".HtmlTools::encodeUrlParam(strtolower($this->attributes[$pathElement]));
			}
		}
		//echo "<pre>ImagesEntity.entityName=".$this->getInfo('entityName')."</pre>";
		$paths['absolute']= dirname(__FILE__)."/../".self::$defaultImagesPath.$this->getInfo('entityName').$imagesPath;
		$paths['relative']= self::$defaultImagesPath.$this->getInfo('entityName').$imagesPath;
		__debug("paths=['absolute'=>\"".print_r($paths['absolute'],true)."\", 'relative'=>\"".print_r($paths['relative'],true)."\"]","loadImages",__CLASS__);

		return $paths;
	}
}
?>