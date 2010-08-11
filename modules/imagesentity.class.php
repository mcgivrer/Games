<?php
/**
 * ImageEntity is a class extension to allow Image management support for the Entity class.
 * @author Frédéric Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/08/08
 */
class ImagesEntity{
	static private $defaultImagesPath;
	static private $formatsAccepted;
	static private $thumbsSizes;
	static private $thumbsDefaultSize;

	protected $pictures = array();
	
	/**
	 * Intialize some defaut values
	 * - Base image path ($defaultImagesPath)
	 * - Image file format accepted ($formatsAccepted)
	 * - thumnails sizes to generate ($thumbsSizes)
	 * - default thumbnail size ($thumbsDefaultSize).
	 */
	public function __construct(){
		if(self::$defaultImagesPath!=""){
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
		if(file_exists($imagesAbsolutePath))
		{
			$dir = opendir($imagesAbsolutePath);
			while(false !== ($item = readdir($dir)))
			{
				if( 
					//(($categories!="" && strpos($categories,$item)!=false) || $categories=="") && 
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
								&& $image !=".Thumbs" 
								//&& preg_match('/(^\*)+[.]['.self::$formatsAccepted.']/',strtolower($image))
						){
							__debug("image=".$imagesAbsolutePath."/".$item."$image","loadImages",__CLASS__);
							$this->pictures[$item][$i]['image']=$fileRelative;
							
							if(!Image::getInstance($thumbsSizes)->thumbsExists(
								$imagesAbsolutePath."/".$item."/thumbs/",
								self::$thumbsDefaultSize))
							{
								Image::getInstance($thumbsSizes)->generateThumbs(
										$file,
										$imagesAbsolutePath."/".$item."/thumbs/",
										self::$thumbsDefaultSize);
							}
							$this->pictures[$item][$i]['thumb']=$imagesRelativePath."/".$item."/thumbs/".self::$thumbsDefaultSize."/".basename($image,".jpg").".png";
							//ImagickThumb::create($file,$imagesAbsolutePath."/".$item."/thumbs/".basename($image,".jpg").".png","80x120");
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
				return $this->pictures[$key][$index]['thumb'];
			}
		}else{
			
			return (isset($this->pictures[$key][$index]['image'])?$this->pictures[$key][$index]['image']:$default);
		}

	}
	
	/**
	 * Return Image thumbs. by default the cover.
	 * @param unknown_type $key
	 */
	public function getPictureThumb($key="default",$index=1,$default){
		return (isset($this->pictures[$key][$index]['thumb'])?$this->pictures[$key][$index]['thumb']:$default);
	}
	/**
	 * TODO Code this part to store images.
	 * @param string $treeType
	 * @param FileObjectArray $files
	 */
	
	public function upload($treeType="id/",$files){
		
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
		//__debug("paths=['absolute'=>\"".print_r($paths['absolute'],true)."\", 'relative'=>\"".print_r($paths['relative'],true)."\"]","loadImages",__CLASS__);

		return $paths;
	}
}
?>