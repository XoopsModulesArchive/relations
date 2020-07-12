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

  //////////////////////////////////////////////////
 // Fetch URL into the temp. list
//
   $link_id = !empty($link_id)    ? intval($link_id)          : 0;
  $moduleid = !empty($moduleid)   ? intval($moduleid)         : 0;
$link_title = !empty($link_title) ? rawurldecode($link_title) : "";
  $link_url = !empty($link_url)   ? rawurldecode($link_url)   : "";

$sql = "INSERT INTO ".$xoopsDB->prefix("relacione_tmpuri")." VALUES (NULL, $moduleid, '$link_url', $link_id, '$link_title') ";
if ($xoopsDB->queryF($sql)) {
		redirect_header($HTTP_REFERER, 1, "Success");
	} else {
		redirect_header($HTTP_REFERER, 1, "Failure");
	}
exit();
?>