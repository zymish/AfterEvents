<?php
if(!isset($site)) return;

/*
$trueUser = bool, if true forces permission of current user.  Disables usage of viewAs
$perm = array(<project>,<sub>,<sub>,<etc.>)
all = for all of that object, single overwrites.

*/
function checkPermission($perm,$trueUser = false,$userPerms = NULL)
{
	if($userPerms == NULL)
	{
		if(!isset($_SESSION['user'],$_SESSION['user']['permissions']))
			return false;
		else
		{
			if(!$trueUser && isset($_SESSION['viewAs']) && !empty($_SESSION['viewAs']['permissions'])):
				$userPerms = $_SESSION['viewAs']['permissions'];
			else:
				if($_SESSION['user']['status'] == '9') return true;
				$userPerms = $_SESSION['user']['permissions'];
			endif;
		}
	}
	
	foreach($perm as $value)
	{	
		if(isset($userPerms[$value])):
			if(!is_array($userPerms[$value])):
				return ($userPerms[$value] == '1')?true:false;
			else:
				$userPerms = $userPerms[$value];
			endif;
		else:
			if(isset($userPerms['all'])):
				if(!is_array($userPerms['all'])):
					return ($userPerms['all'] == '1')?true:false;
				else:
					$userPerms = $userPerms['all'];
				endif;
			else:
				return false;
			endif;
		endif;
	}
	return false;
}

function getCurrentUserID($trueUser = false)
{
	if(!$trueUser && isset($_SESSION['viewAs']) && !empty($_SESSION['viewAs']['uid'])):
		return $_SESSION['viewAs']['uid'];
	else:
		return $_SESSION['user']['uid'];
	endif;
}

if ( ! function_exists( 'exif_imagetype' ) ) {
    function exif_imagetype ( $filename ) {
        if ( ( list($width, $height, $type, $attr) = getimagesize( $filename ) ) !== false ) {
            return $type;
        }
    return false;
    }
}

if ( ! function_exists( 'money_format' ) ) {
    function money_format($format,$money) {
		$symbol = "$";
		$r = 2;
		$n = $money; 
		$c = is_float($n) ? 1 : number_format($n,$r);
		$d = '.';
		$t = ',';
		$sign = ($n < 0) ? '-' : '';
		$i = $n=number_format(abs($n),$r); 
		$j = (($j = $i.length) > 3) ? $j % 3 : 0;
	    return  $symbol.$sign .($j ? substr($i,0, $j) + $t : '').preg_replace('/(\d{3})(?=\d)/',"$1" + $t,substr($i,$j)) ;
    }
}

function uploadImage($src,$destFolder,$prefix = "")
{
	$type = exif_imagetype($src);
	switch($type)
	{
		case IMAGETYPE_GIF:
			$ext = '.gif';
			break;
		case IMAGETYPE_JPEG:
			$ext = '.jpeg';
			break;
		case IMAGETYPE_PNG:
			$ext = '.png';
			break;
		default:
			return false;	
	}
	return uploadFile($src,$destFolder,$prefix,$ext);
}

function uploadFile($src,$destFolder,$prefix = "",$name = "")
{
	if(!file_exists($destFolder))
		mkdir($destFolder,0755,true);
	
	if(empty($name)) $name = $src;
	
	$ext = end(explode(".", $name));
	
	do
	{
		$newName = uniqid($prefix).".".$ext;
	}while(file_exists($destFolder.$newName));
		
	if(move_uploaded_file($src,$destFolder.$newName))
	{
		return $newName;
	}else
		return false;
}

function logActivity($userID,$eventID,$display,$type,$details)
{
	global $db;
	
	$sql  = "INSERT INTO `activityLog` (`userID`,`eventID`,`display`,`actionType`,`actionDetails`,`timestamp`,`userIP`) ";
	$sql .= "VALUES ('".intval($userID)."','".intval($eventID)."','".$db->real_escape_string($display)."','".$db->real_escape_string($type)."','".$db->real_escape_string($details)."',NOW(),'".$_SERVER['REMOTE_ADDR']."')";
	$db->query($sql);
	if($db->error) error_log("SQL Error on logActivity: " . $db->error."\nSQL: ".$sql);
}

function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
{
    $str = '';
    $count = strlen($charset);
    while ($length--) {
        $str .= $charset[mt_rand(0, $count-1)];
    }
    return $str;
}

function real_escape_array($array)
{
	global $db;
	$output = array();
	if(!is_array($array))
		return $db->real_escape_string(trim($array));
	else foreach($array as $key => $value)
		$output[$db->real_escape_string($key)] = (is_array($value))?real_escape_array($value):$db->real_escape_string(trim($value));
	return $output;
}

function real_display_array($array)
{
	if(!is_array($array))
		return htmlspecialchars(trim($array));
	else foreach($array as $key => $value)
		$array[$key] = (is_array($value))?real_display_array($value):htmlspecialchars(trim($value));
	return $array;	
}

function clear_empty_array($array)
{
	if(!is_array($array))
		return $array;
	else foreach($array as $key => $value):
		$array[$key] = (is_array($value))?clear_empty_array($value):$value;
		if(empty($array[$key])) unset($array[$key]);
		endforeach;
	return $array;	
}

function real_array_merge($perm1,$perm2)
{
	if(is_array($perm2)):
		if(!is_array($perm1)) return $perm2;
		foreach($perm2 as $key => $value):
			if(is_array($value) && is_array($perm1[$key])) $perm1[$key] = real_array_merge($perm1[$key],$perm2[$key]);
			else if(isset($perm2[$key])) $perm1[$key] = $perm2[$key];
		endforeach;
	else:
		$perm1 = $perm2;
	endif;
	return $perm1;
}

function emailStrip($email)
{
	return preg_replace('/[^!#$%&\'*+-\/=?^_`{|}~.@a-zA-Z0-9]/','',$email);	
}

function normalize_array($array)
{
	$output = array();
	if(!is_array($array))
		return normalizeUtf8String(trim($array));
	else foreach($array as $key => $value)
		$output[$key] = (is_array($value))?normalize_array($value):normalizeUtf8String(trim($value));
	return $output;
}

function normalizeUtf8String($str)
{  
	return $str;
   	$s 	  = $str;
    // maps German (umlauts) and other European characters onto two characters before just removing diacritics
    $s    = preg_replace( '@\x{00c4}@u'    , "AE",    $s );    // umlaut Ä => AE
    $s    = preg_replace( '@\x{00d6}@u'    , "OE",    $s );    // umlaut Ö => OE
    $s    = preg_replace( '@\x{00dc}@u'    , "UE",    $s );    // umlaut Ü => UE
    $s    = preg_replace( '@\x{00e4}@u'    , "ae",    $s );    // umlaut ä => ae
    $s    = preg_replace( '@\x{00f6}@u'    , "oe",    $s );    // umlaut ö => oe
    $s    = preg_replace( '@\x{00fc}@u'    , "ue",    $s );    // umlaut ü => ue
    $s    = preg_replace( '@\x{00f1}@u'    , "ny",    $s );    // ñ => ny
    $s    = preg_replace( '@\x{00ff}@u'    , "yu",    $s );    // ÿ => yu
   
   
    // maps special characters (characters with diacritics) on their base-character followed by the diacritical mark
        // exmaple:  Ú => U´,  á => a`
    if(class_exists("Normalizer", $autoload = false))
		$s    = Normalizer::normalize( $s, Normalizer::FORM_D );
   
   
    $s    = preg_replace( '@\pM@u'        , "",    $s );    // removes diacritics
   
   
    $s    = preg_replace( '@\x{00df}@u'    , "ss",    $s );    // maps German ß onto ss
    $s    = preg_replace( '@\x{00c6}@u'    , "AE",    $s );    // Æ => AE
    $s    = preg_replace( '@\x{00e6}@u'    , "ae",    $s );    // æ => ae
    $s    = preg_replace( '@\x{0132}@u'    , "IJ",    $s );    // ? => IJ
    $s    = preg_replace( '@\x{0133}@u'    , "ij",    $s );    // ? => ij
    $s    = preg_replace( '@\x{0152}@u'    , "OE",    $s );    // Œ => OE
    $s    = preg_replace( '@\x{0153}@u'    , "oe",    $s );    // œ => oe \u00e9
   
    $s    = preg_replace( '@\x{00d0}@u'    , "D",    $s );    // Ð => D
    $s    = preg_replace( '@\x{0110}@u'    , "D",    $s );    // Ð => D
    $s    = preg_replace( '@\x{00f0}@u'    , "d",    $s );    // ð => d
    $s    = preg_replace( '@\x{0111}@u'    , "d",    $s );    // d => d
    $s    = preg_replace( '@\x{0126}@u'    , "H",    $s );    // H => H
    $s    = preg_replace( '@\x{0127}@u'    , "h",    $s );    // h => h
    $s    = preg_replace( '@\x{0131}@u'    , "i",    $s );    // i => i
    $s    = preg_replace( '@\x{0138}@u'    , "k",    $s );    // ? => k
    $s    = preg_replace( '@\x{013f}@u'    , "L",    $s );    // ? => L
    $s    = preg_replace( '@\x{0141}@u'    , "L",    $s );    // L => L
    $s    = preg_replace( '@\x{0140}@u'    , "l",    $s );    // ? => l
    $s    = preg_replace( '@\x{0142}@u'    , "l",    $s );    // l => l
    $s    = preg_replace( '@\x{014a}@u'    , "N",    $s );    // ? => N
    $s    = preg_replace( '@\x{0149}@u'    , "n",    $s );    // ? => n
    $s    = preg_replace( '@\x{014b}@u'    , "n",    $s );    // ? => n
    $s    = preg_replace( '@\x{00d8}@u'    , "O",    $s );    // Ø => O
    $s    = preg_replace( '@\x{00f8}@u'    , "o",    $s );    // ø => o
    $s    = preg_replace( '@\x{017f}@u'    , "s",    $s );    // ? => s
    $s    = preg_replace( '@\x{00de}@u'    , "T",    $s );    // Þ => T
    $s    = preg_replace( '@\x{0166}@u'    , "T",    $s );    // T => T
    $s    = preg_replace( '@\x{00fe}@u'    , "t",    $s );    // þ => t
    $s    = preg_replace( '@\x{0167}@u'    , "t",    $s );    // t => t
   
    // remove all non-ASCii characters
    $s    = preg_replace( '@[^\0-\x80]@u'    , "",    $s );
    $s = iconv('UTF-8','ASCII//TRANSLIT//IGNORE',$s);
   
    // possible errors in UTF8-regular-expressions
    if (empty($s))
        return $str;
    else
        return $s;
}