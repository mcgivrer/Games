<?php
/**
 * Image manager and linked thumbs generator.
 * Will parse path and generate related thumbs, following the <code>$thumbsFormats</code>
 * list of defined size like "80x60" or "160x120".
 * Method <code>generateThumbs()</code> will load image and generate corresponding thumbs.
 * 
 * @author Frédéric Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/08/08
 *
 */
class Image{
	private static $_instance;
	
	private $thumbsFormats=array();
	private $thumbsFileFormat="png";

	public $imgTypes = array(
			1 => 'GIF',
			2 => 'JPG',
			3 => 'PNG',
			4 => 'SWF',
			5 => 'PSD',
			6 => 'BMP',
			7 => 'TIFF(intel byte order)',
			8 => 'TIFF(motorola byte order)',
			9 => 'JPC',
			10 => 'JP2',
			11 => 'JPX',
			12 => 'JB2',
			13 => 'SWC',
			14 => 'IFF',
			15 => 'WBMP',
			16 => 'XBM'
		);
	
	
	public function __construct($thumbsSizes){
		if($thumbsSises !=""){
			$thumbsFormats = $thumbsSizes;
		}
	}
	
	public function generateThumbs($image,$path){
		foreach($this->thumbsFormats as $format){
			if(!file_exists($path."/".$format)){
				mkdir($path."/".$format);
				$size = explode('x',$format);
				$split=explode('.',basename($image));
				$pathFileDest = $path."/".$format."/".$split[0].".png";
				
				$this->resizeImage($image, $pathFileDest, $size[0],$size[1],true);
			}
		}
	}
	public function thumbsExists($path,$format){
		if(file_exists($path.$format)){
			return true;
		}
		return false;
	}
	
	public function resizeImage($source_pic, 
			$destination_pic,
			$max_width,
			$max_height,
			$force=true,
			$options=array('shadow'=>array('offset_x'=>2,'offset_y'=>2,'blending'=>4,'alpha'=>80,'activate'=>true))){
		
		if(!file_exists($destination_pic) || $force){
			list($width,$height,$format)=getimagesize($source_pic);
	
			if($format==1){
				$src = imagecreatefromgif($source_pic);
			}elseif($format==2){
				$src = imagecreatefromjpeg($source_pic);
			}elseif($format==3){
				$src = imagecreatefrompng($source_pic);
			}
			
			$x_ratio = $max_width / $width;
			$y_ratio = $max_height / $height;
			
			if( ($width <= $max_width) && ($height <= $max_height) ){
				$tn_width = $width;
				$tn_height = $height;
				}elseif (($x_ratio * $height) < $max_height){
					$tn_height = ceil($x_ratio * $height);
					$tn_width = $max_width;
				}else{
					$tn_width = ceil($y_ratio * $width);
					$tn_height = $max_height;
			}
			if(isset($options['shadow']['activate']) && $options['shadow']['activate']==true){
				$tmp=imagecreatetruecolor($tn_width+$options['shadow']['offset_x'],$tn_height+$options['shadow']['offset_y']);
				//background
				$background=imagecolorallocatealpha($tmp, 0, 0, 0, 127);
				$shadow=imagecolorallocatealpha($tmp, 0, 0, 0, $options['shadow']['alpha']);
				$tmp=imagerectangle($tmp, 
									0,
									0,
									$tn_width+$options['shadow']['offset_x']+$options['shadow']['blending'], 
									$tn_height+$options['shadow']['offset_y']+$options['shadow']['blending'], 
									$background);
				//shadow
				for($i=0;$i<$options['shadow']['blending'];$i++){
					$tmp=imagerectangle($tmp, 
										$options['shadow']['offset_x']+$i,
										$options['shadow']['offset_y']+$i,
										$tn_width+$options['shadow']['offset_x']+$i, 
										$tn_height+$options['shadow']['offset_y']+$i, 
										$background);
				}
			}else{
				$tmp=imagecreatetruecolor($tn_width,$tn_height);		
			}
			imagealphablending($tmp,true);
			imagesavealpha($tmp, true);
			imagecopyresampled($tmp,$src,0,0,0,0,$tn_width, $tn_height,$width,$height);
			
			//calculate PNG image quality based on a 1-100% ratio
			$quality=85;
			$pngQuality = ($quality - 100) / 11.111111;
			$pngQuality = round(abs($pngQuality));
			// save image in PNG format for alpha channel.
			imagepng($tmp,$destination_pic,$pngQuality);
			
			//free temporary used memory for image manipulation.
			imagedestroy($src);
			imagedestroy($tmp);
		}
	}
	
	public function setThumbsFormat($thumbsFormat,$fileFormat="png"){
		if($thumbsFormat != ""){
			$this->thumbsFormats = $thumbsFormat;
		}
		$this->thumbsFileFormat = $fileFormat;
	}
	
	public static function getInstance($thumbsSizes){
		if(!isset(self::$_instance)){
			self::$_instance=new Image($thumbsSizes);
		}else{
			self::$_instance->setThumbsFormat($thumbsSizes);
		}
		return self::$_instance;
	}
}