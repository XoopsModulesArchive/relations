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
 // Jump from admin menu to the Link initial location page
//
 $link_id = !empty($link_id) ? intval($link_id) : 0;
     $sql = "SELECT home_url FROM ".$xoopsDB->prefix("relacione_uri")." where urid = $link_id";
  $result = $xoopsDB->queryF($sql);
   $myrow = $xoopsDB->fetchArray($result);
$home_url = $myrow['home_url'];

if (!empty($myrow['home_url'])) {		
		redirect_header($myrow['home_url'], 0, "Link was found, redirecting to that page");
	} else {
		redirect_header($HTTP_REFERER, 0, "Sorry, this link was not found on any page");
	}
exit();
?>