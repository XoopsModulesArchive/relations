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
$xoopsModule =& XoopsModule::getByDirname("relations");
if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) {
	redirect_header(XOOPS_URL."/",3,_NOPERM);
	exit();
} else {
if($xoopsDB->queryF("DELETE FROM ".$xoopsDB->prefix(relacione_tmpuri)." WHERE recid=".$link_id."")){
		$fintxt = "Link was erased successfully";
	} else {
		$fintxt = "Failure";
	}
		redirect_header($HTTP_REFERER,1,$fintxt);	
exit();
}
?>