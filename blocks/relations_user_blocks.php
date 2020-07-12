<?php
//  -------------------------------------------------------------------------- //
//  [CONTENT RELATIONS MGR FOR XOOPS-R2]
//  Author: Toms Veilands [tomsys@tomsys.net] [www.tomsys.net] [AKA tomsys]
//  Credits: Xoops Team [www.xoops.org]
//  Version: 1.0
//  ReleaseDate: May 03, 2003
//  License: GPL - [http://www.gnu.org/licenses/gpl.html]
//  -------------------------------------------------------------------------- //

function relations_user_block_show() {
	global $xoopsDB, $xoopsUser, $xoopsModule, $xoopsConfig, $storytopic, $storyid, $page, $cid, $lid, $_SERVER, $xoopsOption, $op, $rows, $link_old_title, $link_title, $link_id, $moduleid;
	
	$isuser = !empty($xoopsUser) ? true : false;
	if ($isuser) {
		$isadmin = isset($xoopsUser) ? intval($xoopsUser->isAdmin()) : 0;
	}
	$moduleid = isset($xoopsModule) ? intval($xoopsModule->mid()) : '';
	//$dcatid = isset($cid) ? intval($cid) : 0;
	if (isset($xoopsModule)){
		        $sql  = "";
		        $sql  = !empty($moduleid) ? "SELECT a.urid, a.modid, b.title, b.url, a.visible FROM ".$xoopsDB->prefix('relacione')." a, ".$xoopsDB->prefix('relacione_uri')." b WHERE a.modid = $moduleid AND a.urid = b.urid " : "";
		        $sql .= !empty($cid) ? "AND a.downloadcatid = $cid " : "AND a.downloadcatid = 0 ";
		//$sql .= !empty($lid) && !empty($cid) ? "AND a.downloadlid = $lid " : "AND a.downloadlid = 0 ";
		        $sql .= !empty($storytopic) ? "AND a.topicid = $storytopic " : "AND a.topicid = 0 ";
		        $sql .= !empty($storyid) ? "AND a.storyid = $storyid " : "AND a.storyid = 0 ";
		//$sql .= !empty($page) && !empty($storyid) ? "AND a.storypageid = $page " : "AND a.storypageid = 0 ";
		        $sql .= empty($isadmin) ? "AND a.visible = 0 " : "";
		        $sql .= " ORDER BY 'url' ASC";
		      $result = $xoopsDB->queryF($sql);
		 $retStrAdmin = "";
		  $retStrUser = "";
		while ($myrow = $xoopsDB->fetchArray($result)) {
		$retStrAdmin .= ""
					 ."<a href=\"".XOOPS_URL."/modules/relations/ub_drop_userblock_single_link.php?link_id=".$myrow['urid']."\" title='WARNING - you will delete this link!'><img hspace='2' align='absmiddle' src='".XOOPS_URL."/modules/relations/images/remove.gif' border=0></a>"
					 ."<a href=\"".XOOPS_URL."/modules/relations/ub_coppy_to_bookmarks_link.php?link_id=".$myrow['urid']."&amp;link_title=".rawurlencode($myrow['title'])."&amp;link_url=".rawurlencode($myrow['url'])."&amp;moduleid=".$myrow['modid']."\" title='Coppy to the Bookmarks list'><img hspace='0' align='absmiddle' src='".XOOPS_URL."/modules/relations/images/edit.gif' border=0></a>";
					 if ($myrow['visible'] == 0) {
						$retStrAdmin .= "<a href=\"".XOOPS_URL."/modules/relations/ub_hide_userblock_link.php?link_id=".$myrow['urid']."\" title='Hide this link'><img hspace='2' align='absmiddle' src='".XOOPS_URL."/modules/relations/images/hide.gif' border=0></a>";
					 } else {
						$retStrAdmin .= "<a href=\"".XOOPS_URL."/modules/relations/ub_unhide_userblock_link.php?link_id=".$myrow['urid']."\" title='Unide this link'><img hspace='2' align='absmiddle' src='".XOOPS_URL."/modules/relations/images/unhide.gif' border=0></a>";
					 }
		 $retStrUser .= "<a href='".$myrow['url']."'>".$myrow['title']."</a></br>";	
		 $retStrAdmin  .= "<a href='".$myrow['url']."'>".$myrow['title']."</a></br>";
		}
			
	}
	$block = array();
	if (!empty($retStrAdmin)) {
		$block['UserAdminBlock'] =  "".$retStrAdmin;
	//}
		$block['UserBlock'] = "".$retStrUser;
	}
	return $block;
}
?>