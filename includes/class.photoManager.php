<?php
/* class.photoManager.php
.---------------------------------------------------------------------------.
	Build By Strider Agostinelli (strider@boundlessether.com)
'---------------------------------------------------------------------------'
*/

class photoManager {

	/*
	$type can be = 'concourse' or 'meetGreet'
	*/
	function getEventPhotos($eventID,$type = 'concourse')
	{
		global $db;
		$eventID = intval($eventID);
		$type = $db->real_escape_string($type);
		if(empty($eventID) || !in_array($type,array('concourse','meetGreet')))
			return false;
		
		$sql = "SELECT * FROM `eventPhotos` WHERE `eventID` = '".$eventID."' AND `type` = '".$type."'";
		return $db->query($sql);
	}
	
	/*
	$type can be = 'concourse' or 'meetGreet'
	*/
	function uploadNewEventPhoto($src,$eventID,$type = 'concourse')
	{
		global $db,$eventManager;
		$eventID = intval($eventID);
		$type = $db->real_escape_string($type);
		if(empty($eventID) || !in_array($type,array('concourse','meetGreet')))
			return false;
			
		$event = $eventManger->getEventByID($eventID);
		if(!$event) 
			return false;
			
		$projectID = intval($event['projectID']);
		if(empty($projectID))
			return false;
			
		$filePath = UPLOAD_PATH.$projectID."/".$eventID."/";
		
		$fileName = uploadImage($src,$filePath);
		$this->createThumbnail($filePath.$fileName,$filePath."thumbs/".$fileName);
		/*
		$sql = "INSERT INTO `eventPhotos` (`eventID`,`type`,`fileName`,`uploaded`) VALUES ('".$eventID."','".$type."','".$db->real_escape_string($fileName)."',NOW())";
		$db->query($sql);
		if($db->error):
			error_log("MYSQL ERROR on photoManger->uploadNewEventPhoto(): ".$db->error);
			return false;
		endif;
		return true;*/
	}
	
	function createThumbnail($src,$dest,$width=200,$height=200)
	{
		$sizes = $this->getImageSizeInBox($src,$width,$height);
		$origWidth = $sizes[0];
		$origHeight = $sizes[1];
		$resizedWidth = $sizes[2];
		$resizedHeight = $sizes[3];
		
		$imageOutput = imagecreatetruecolor($resizedWidth, $resizedHeight);	
		
		$type = exif_imagetype($src);
		switch($type)
		{
			case IMAGETYPE_GIF:
				$imageSource = imagecreatefromgif($src);
				break;
			case IMAGETYPE_JPEG:
				$imageSource = imagecreatefromjpeg($src);
				break;
			case IMAGETYPE_PNG:
				$imageSource = imagecreatefrompng($src);
				break;
			default:
				return false;	
		}
		
		imagealphablending( $imageOutput, false );
		imagesavealpha( $imageOutput, true );
		imagecopyresampled($imageOutput, $imageSource, 0, 0, 0, 0, $resizedWidth, $resizedHeight, $origWidth, $origHeight);
		
		if(!file_exists(dirname($dest)))
			mkdir(dirname($dest),0755,true);
		
		switch($type)
		{
			case IMAGETYPE_GIF:
				imagegif($imageOutput, $dest);
				break;
			case IMAGETYPE_JPEG:
				imagejpeg($imageOutput, $dest);
				break;
			case IMAGETYPE_PNG:
				imagepng($imageOutput, $dest);
				break;
			default:
				return false;	
		}
		
		imagedestroy($imageOutput);
		imagedestroy($imageSource);
		
		return true;
	}
	
	function getImageSizeInBox($sourceImageFilePath, $maxResizeWidth, $maxResizeHeight) 
	{
		// Get width and height of original image
		$size = getimagesize($sourceImageFilePath);
		if($size === false) return false; // Error
		$origWidth = $size[0];
		$origHeight = $size[1];
		
		// Change dimensions to fit maximum width and height
		$resizedWidth = $origWidth;
		$resizedHeight = $origHeight;
		if($resizedWidth > $maxResizeWidth) {
		$aspectRatio = $maxResizeWidth / $resizedWidth;
		$resizedWidth = round($aspectRatio * $resizedWidth);
		$resizedHeight = round($aspectRatio * $resizedHeight);
		}
		if($resizedHeight > $maxResizeHeight) {
		$aspectRatio = $maxResizeHeight / $resizedHeight;
		$resizedWidth = round($aspectRatio * $resizedWidth);
		$resizedHeight = round($aspectRatio * $resizedHeight);
		}
		
		// Return an array with the original and resized dimensions
		return array($origWidth, $origHeight, $resizedWidth, 
		$resizedHeight);
	}
	
}
?>
