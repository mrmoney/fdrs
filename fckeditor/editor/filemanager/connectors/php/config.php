<?php
/*
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2008 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 * Configuration file for the File Manager Connector for PHP.
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/libs(v1)/sun.session.php');
global $Config ;
$Config['enableThumbnail'] = false ;
// SECURITY: You must explicitly enable this "connector". (Set it to "true").
// WARNING: don't just set "$Config['Enabled'] = true ;", you must be sure that only
//		authenticated users can access this file or use some kind of session checking.
$Config['Enabled'] = true ;


// Path to user files relative to the document root.
//if(Power::UserValidate(array(1,2,3))){
//	$Config['UserFilesPath'] = '/member/' .System::getUserInfo('userId','member')  . '/images/' ;
//	$Config['Enabled'] = true ;
//}elseif(Power::ValidateSysUser(null,false)){
	$newdir='/attachement/fromeditor/' . date('Ymd') . '/';
	@mkdir(ROOT . $newdir);
	$Config['UserFilesPath'] = $newdir ;
	$Config['Enabled'] = true ;
//}else{
//	$Config['Enabled'] = false ;
//}

// Fill the following value it you prefer to specify the absolute path for the
// user files directory. Useful if you are using a virtual directory, symbolic
// link or alias. Examples: 'C:\\MySite\\userfiles\\' or '/root/mysite/userfiles/'.
// Attention: The above 'UserFilesPath' must point to the same directory.
$Config['UserFilesAbsolutePath'] = '' ;

// Due to security issues with Apache modules, it is recommended to leave the
// following setting enabled.
$Config['ForceSingleExtension'] = true ;

// Perform additional checks for image files.
// If set to true, validate image size (using getimagesize).
$Config['SecureImageUploads'] = true;

// What the user can do with this connector.
$Config['ConfigAllowedCommands'] = array('QuickUpload', 'FileUpload', 'GetFolders', 'GetFoldersAndFiles', 'CreateFolder') ;

// Allowed Resource Types.
$Config['ConfigAllowedTypes'] = array('File', 'Image', 'Flash', 'Media') ;

// For security, HTML is allowed in the first Kb of data for files having the
// following extensions only.
$Config['HtmlExtensions'] = array("html", "htm", "xml", "xsd", "txt", "js") ;

// After file is uploaded, sometimes it is required to change its permissions
// so that it was possible to access it at the later time.
// If possible, it is recommended to set more restrictive permissions, like 0755.
// Set to 0 to disable this feature.
// Note: not needed on Windows-based servers.
$Config['ChmodOnUpload'] = 0777 ;

// See comments above.
// Used when creating folders that does not exist.
$Config['ChmodOnFolderCreate'] = 0777 ;

/*
	Configuration settings for each Resource Type

	- AllowedExtensions: the possible extensions that can be allowed.
		If it is empty then any file type can be uploaded.
	- DeniedExtensions: The extensions that won't be allowed.
		If it is empty then no restrictions are done here.

	For a file to be uploaded it has to fulfill both the AllowedExtensions
	and DeniedExtensions (that's it: not being denied) conditions.

	- FileTypesPath: the virtual folder relative to the document root where
		these resources will be located.
		Attention: It must start and end with a slash: '/'

	- FileTypesAbsolutePath: the physical path to the above folder. It must be
		an absolute path.
		If it's an empty string then it will be autocalculated.
		Useful if you are using a virtual directory, symbolic link or alias.
		Examples: 'C:\\MySite\\userfiles\\' or '/root/mysite/userfiles/'.
		Attention: The above 'FileTypesPath' must point to the same directory.
		Attention: It must end with a slash: '/'

	 - QuickUploadPath: the virtual folder relative to the document root where
		these resources will be uploaded using the Upload tab in the resources
		dialogs.
		Attention: It must start and end with a slash: '/'

	 - QuickUploadAbsolutePath: the physical path to the above folder. It must be
		an absolute path.
		If it's an empty string then it will be autocalculated.
		Useful if you are using a virtual directory, symbolic link or alias.
		Examples: 'C:\\MySite\\userfiles\\' or '/root/mysite/userfiles/'.
		Attention: The above 'QuickUploadPath' must point to the same directory.
		Attention: It must end with a slash: '/'

	 	NOTE: by default, QuickUploadPath and QuickUploadAbsolutePath point to
	 	"userfiles" directory to maintain backwards compatibility with older versions of FCKeditor.
	 	This is fine, but you in some cases you will be not able to browse uploaded files using file browser.
	 	Example: if you click on "image button", select "Upload" tab and send image
	 	to the server, image will appear in FCKeditor correctly, but because it is placed
	 	directly in /userfiles/ directory, you'll be not able to see it in built-in file browser.
	 	The more expected behaviour would be to send images directly to "image" subfolder.
	 	To achieve that, simply change
			$Config['QuickUploadPath']['Image']			= $Config['UserFilesPath'] ;
			$Config['QuickUploadAbsolutePath']['Image']	= $Config['UserFilesAbsolutePath'] ;
		into:
			$Config['QuickUploadPath']['Image']			= $Config['FileTypesPath']['Image'] ;
			$Config['QuickUploadAbsolutePath']['Image'] 	= $Config['FileTypesAbsolutePath']['Image'] ;

*/

$Config['AllowedExtensions']['File']	= array('7z', 'aiff', 'asf', 'avi', 'bmp', 'csv', 'doc', 'docx', 'fla', 'flv', 'gif', 'gz', 'gzip', 'jpeg', 'jpg', 'mid', 'mov', 'mp3', 'mp4', 'mpc', 'mpeg', 'mpg', 'ods', 'odt', 'pdf', 'png', 'ppt', 'pptx', 'pxd', 'qt', 'ram', 'rar', 'rm', 'rmi', 'rmvb', 'rtf', 'sdc', 'sitd', 'swf', 'sxc', 'sxw', 'tar', 'tgz', 'tif', 'tiff', 'txt', 'vsd', 'wav', 'wma', 'wmv', 'xls', 'xlsx', 'xml', 'zip') ;
$Config['DeniedExtensions']['File']		= array() ;
$Config['FileTypesPath']['File']		= $Config['UserFilesPath'] . 'file/' ;
$Config['FileTypesAbsolutePath']['File']= ($Config['UserFilesAbsolutePath'] == '') ? '' : $Config['UserFilesAbsolutePath'].'file/' ;
$Config['QuickUploadPath']['File']		= $Config['UserFilesPath'] ;
$Config['QuickUploadAbsolutePath']['File']= $Config['UserFilesAbsolutePath'] ;

$Config['AllowedExtensions']['Image']	= array('bmp','gif','jpeg','jpg','png') ;
$Config['DeniedExtensions']['Image']	= array() ;
$Config['FileTypesPath']['Image']		= $Config['UserFilesPath'] . 'image/' ;
$Config['FileTypesAbsolutePath']['Image']= ($Config['UserFilesAbsolutePath'] == '') ? '' : $Config['UserFilesAbsolutePath'].'image/' ;
$Config['QuickUploadPath']['Image']		= $Config['UserFilesPath'] ;
$Config['QuickUploadAbsolutePath']['Image']= $Config['UserFilesAbsolutePath'] ;

$Config['AllowedExtensions']['Flash']	= array('swf','flv','avi','wmv','rm','mid','rm') ;
$Config['DeniedExtensions']['Flash']	= array() ;
$Config['FileTypesPath']['Flash']		= $Config['UserFilesPath'] . 'flash/' ;
$Config['FileTypesAbsolutePath']['Flash']= ($Config['UserFilesAbsolutePath'] == '') ? '' : $Config['UserFilesAbsolutePath'].'flash/' ;
$Config['QuickUploadPath']['Flash']		= $Config['UserFilesPath'] ;
$Config['QuickUploadAbsolutePath']['Flash']= $Config['UserFilesAbsolutePath'] ;

$Config['AllowedExtensions']['Media']	= array('aiff', 'asf', 'avi', 'bmp', 'fla', 'flv', 'gif', 'jpeg', 'jpg', 'mid', 'mov', 'mp3', 'mp4', 'mpc', 'mpeg', 'mpg', 'png', 'qt', 'ram', 'rm', 'rmi', 'rmvb', 'swf', 'tif', 'tiff', 'wav', 'wma', 'wmv') ;
$Config['DeniedExtensions']['Media']	= array() ;
$Config['FileTypesPath']['Media']		= $Config['UserFilesPath'] . 'media/' ;
$Config['FileTypesAbsolutePath']['Media']= ($Config['UserFilesAbsolutePath'] == '') ? '' : $Config['UserFilesAbsolutePath'].'media/' ;
$Config['QuickUploadPath']['Media']		= $Config['UserFilesPath'] ;
$Config['QuickUploadAbsolutePath']['Media']= $Config['UserFilesAbsolutePath'] ;


function ResizeImage($im,$maxwidth,$maxheight,$name){ 
	$width = imagesx($im); 
	$height = imagesy($im); 
	if(($maxwidth && $width > $maxwidth) || ($maxheight && $height > $maxheight)){ 
		if($maxwidth && $width > $maxwidth){ 
			$widthratio = $maxwidth/$width; 
			$RESIZEWIDTH=true; 
		} 
		if($maxheight && $height > $maxheight){ 
			$heightratio = $maxheight/$height; 
			$RESIZEHEIGHT=true; 
		}
	
		if($RESIZEWIDTH && $RESIZEHEIGHT){ 
			if($widthratio < $heightratio){ 
				$ratio = $widthratio; 
			}else{ 
				$ratio = $heightratio; 
			} 
		}elseif($RESIZEWIDTH){ 
			$ratio = $widthratio; 
		}elseif($RESIZEHEIGHT){ 
			$ratio = $heightratio; 
		}
		
		$newwidth = $width * $ratio; 
		$newheight = $height * $ratio; 
		if(function_exists("imagecopyresampled")){ 
			$newim = imagecreatetruecolor($newwidth, $newheight); 
			imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); 
		}else{ 
			$newim = imagecreate($newwidth, $newheight); 
			imagecopyresized($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); 
		} 
		imagejpeg($newim,$name); 
		imagedestroy($newim); 
	}else{ 
		imagejpeg($im,$name); 
	} 
} 
?>
