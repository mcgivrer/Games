<?php
class HtmlTools{
	public static function encodeUrlParam ( $string ){
		$string = trim($string);

		if ( ctype_digit($string) ){
			return $string;
		}else{
			// replace accented chars
			$accents = '/&([A-Za-z]{1,2})(grave|acute|circ|cedil|uml|lig);/';
			$string_encoded = htmlentities($string,ENT_NOQUOTES,'UTF-8');

			$string = preg_replace($accents,'$1',$string_encoded);

			// clean out the rest
			$replace = array('([\40])','([^a-zA-Z0-9-])','(-{2,})');
			$with = array('-','','-');
			$string = preg_replace($replace,$with,$string);
		}
		return strtolower($string);
	}
}
?>