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
 // Park Selected bookmark in da Users Block
//
$xoopsModule =& XoopsModule::getByDirname("relations");
if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) {
	redirect_header(XOOPS_URL."/",3,_NOPERM);
	exit();
} else {
   $linktitle = !empty($linktitle) ? rawurldecode($linktitle) : "";
    $link_url = !empty($link_url)  ? rawurldecode($link_url)  : "";
	$topic_id = !empty($topic_id)  ? intval($topic_id)        : 0;
	$story_id = !empty($story_id)  ? intval($story_id)        : 0;
  	 $page_id = !empty($page_id)   ? intval($page_id)         : 0;
	   $dc_id = !empty($dc_id)     ? intval($dc_id)           : 0;
	   $dl_id = !empty($dl_id)     ? intval($dl_id)           : 0;
    $home_url = !empty($home_url)  ? rawurldecode($home_url)  : "";//$HTTP_REFERER;
	     $sql = "INSERT INTO ".$xoopsDB->prefix("relacione_uri")." VALUES (NULL, '$link_title', '$link_url','$home_url')";
	 $xoopsDB -> queryF($sql);
	$new_urid = $xoopsDB->getInsertId();
	     $sql = "INSERT INTO ".$xoopsDB->prefix("relacione")." VALUES (NULL, $new_urid, $module_id, $topic_id, $story_id, $page_id, $dc_id, $dl_id, '')";
	//echo $sql;
	if($xoopsDB->queryF($sql)){
		$fin_txt = "Pasted successfully";
	} else {
		$fin_txt = "Failure";
	}
	redirect_header($HTTP_REFERER,1,$fin_txt);
exit();
}
?>