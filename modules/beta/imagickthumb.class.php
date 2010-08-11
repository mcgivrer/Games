<?php
class ImagickThumb {
	public function create($src,$dest,$thumbsize){
		$im = new Imagick( $src );
 
		/* Make the image a little smaller, maintain aspect ratio */
		$size = explode('x',$thumbsize);
		$im->thumbnailImage( $size[0], $size[1], true );
		 
		/* Round corners, web 2.0! */
		$im->roundCorners( 5, 5 );
		 
		/* Clone the current object */
		$shadow = $im->clone();
		 
		/* Set image background color to black
		        (this is the color of the shadow) */
		$shadow->setImageBackgroundColor( new ImagickPixel( 'black' ) );
		 
		/* Create the shadow */
		$shadow->shadowImage( 80, 3, 5, 5 );
		 
		/* Imagick::shadowImage only creates the shadow.
		        That is why the original image is composited over it */
		$shadow->compositeImage( $im, Imagick::COMPOSITE_OVER, 0, 0 );
		$shadow->writeImage($dest);
	}
}