<?php
//  -------------------------------------------------------------------------- //
//  [CONTENT RELATIONS MGR FOR XOOPS-R2]
//  Author: Toms Veilands [tomsys@tomsys.net] [www.tomsys.net] [AKA tomsys]
//  Credits: Xoops Team [www.xoops.org]
//  Version: 1.0
//  ReleaseDate: May 03, 2003
//  License: GPL - [http://www.gnu.org/licenses/gpl.html]
//  -------------------------------------------------------------------------- //

include '../../mainfile.php';
$link_title = !empty($link_title) ? rawurldecode($link_title) : "";
$xoopsModule =& XoopsModule::getByDirname("relations");
if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) {
	redirect_header(XOOPS_URL."/",3,_NOPERM);
	exit();
} else {
$sql = "UPDATE ".$xoopsDB->prefix('relacione_uri')." SET title = '$link_title' WHERE urid = ".intval($link_id);
if($xoopsDB->queryF($sql)){
		$fintxt = "User view updated successfully";
	} else {
		$fintxt = "Failure";
	}
		redirect_header($HTTP_REFERER,0,$fintxt);	
exit();
}
?>