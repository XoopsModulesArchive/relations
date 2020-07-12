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
$sql = "UPDATE ".$xoopsDB->prefix('relacione')." SET visible = 0 WHERE urid = ".intval($link_id);
if($xoopsDB->queryF($sql)){
		$fintxt = "Now this link will be available from user view";
	} else {
		$fintxt = "Failure";
	}
		redirect_header($HTTP_REFERER,1,$fintxt);	
exit();
?>