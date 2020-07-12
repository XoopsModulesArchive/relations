<?php
//  -------------------------------------------------------------------------- //
//  [CONTENT RELATIONS MGR FOR XOOPS-R2]
//  Author: Toms Veilands [tomsys@tomsys.net] [www.tomsys.net] [AKA tomsys]
//  Credits: Xoops Team [www.xoops.org]
//  Version: 1.0
//  ReleaseDate: May 03, 2003
//  License: GPL - [http://www.gnu.org/licenses/gpl.html]
//  -------------------------------------------------------------------------- //

  //
 // Remove link from users Block
//
include '../../mainfile.php';
if (!empty($HTTP_REFERER) && $xoopsUser->isAdmin()) {
	$sql = "UPDATE ".$xoopsDB->prefix('relacione_tmpuri')." SET urid = 0 WHERE urid = ".intval($link_id);
	$success1 = $xoopsDB->queryF($sql) ? 1 : 0; 

	$sql = "DELETE FROM ".$xoopsDB->prefix('relacione')." WHERE urid = ".intval($link_id);
	$success = $xoopsDB->queryF($sql) ? 1 : 0;

	$sql = "DELETE FROM ".$xoopsDB->prefix('relacione_uri')." WHERE urid = ".intval($link_id);
		
	if($xoopsDB->queryF($sql) && $success){
		$fintxt = "Link was erased successfully";
	} else {
		$fintxt = "Failure";
	}
	redirect_header($HTTP_REFERER,1,$fintxt);	
}
redirect_header(XOOPS_URL,1);
exit();
?>