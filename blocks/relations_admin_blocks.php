<?php
//  -------------------------------------------------------------------------- //
//  [CONTENT RELATIONS MGR FOR XOOPS-R2]
//  Author: Toms Veilands [tomsys@tomsys.net] [www.tomsys.net] [AKA tomsys]
//  Credits: Xoops Team [www.xoops.org]
//  Version: 1.0
//  ReleaseDate: May 03, 2003
//  License: GPL - [http://www.gnu.org/licenses/gpl.html]
//  -------------------------------------------------------------------------- //

function relations_admin_block_show() {
	global $xoopsDB, $xoopsUser, $xoopsModule, $xoopsConfig, $storytopic, $storyid, $page, $cid, $lid, $_SERVER, $xoopsOption, $op, $rows, $link_old_title, $link_title, $link_id, $moduleid, $link_row;
	$isadmin  = isset($xoopsUser) ? intval($xoopsUser->isAdmin()) : 0;
	$moduleid = isset($xoopsModule) ? intval($xoopsModule->mid()) : "";	
	$myurl    = $_SERVER['PHP_SELF'];
	$myurl   .= !empty($_SERVER['QUERY_STRING']) ? "?".$_SERVER['QUERY_STRING'] : "";
	$block    = array(); 

if (!defined('XOOPS_ROOT_PATH') || !is_object($xoopsModule)) {
	return;
}

$xoopsMod =& XoopsModule::getByDirname("relations");
if ( !$xoopsUser->isAdmin($xoopsMod->mid()) ) {
	redirect_header(XOOPS_URL."/",3,_NOPERM);
	exit();
} else {

//start
/////////////////////////////// FORM REQUESTS START ///////////////////////////////
//
if (isset($HTTP_POST_VARS['op'])) {
	$op = trim($HTTP_POST_VARS['op']);
}
if (!empty($op)) {

	  /////////////////////////////////////////
	 // Quickupdate for Temp. bookmars form //------>
	//------>
	if ($op == 'bquickupdate') { // Quick update bookmark names
		$count = $rows;		
		for ( $r = 0; $r < $count; $r++ ) {								
			if ( $link_old_title[$r] != $link_title[$r]) {
				 $sql = "UPDATE ".$xoopsDB->prefix('relacione_tmpuri')." SET title='".$link_title[$r]."' WHERE recid='".$link_id[$r]."'";
				 $res = $xoopsDB->query($sql); //sorry no testing here yet
			}
		}
		redirect_header($HTTP_REFERER, 1, "Success");
	}	

	  /////////////////////////////////////////////////
	 // Insert new bookmark for Temp. bookmars form //------>
	//------>
	if ($op == 'add_bookmark') { // Insert new bookmark		
		$sql = "INSERT INTO ".$xoopsDB->prefix("relacione_tmpuri")." VALUES (NULL, $moduleid, '$myurl', 0, '-- New Link --')";
		if ($xoopsDB->queryF($sql)) {
			redirect_header($HTTP_REFERER, 1, "Success");
		} else {
			redirect_header($HTTP_REFERER, 1, "Failure");
		}
	}	

	  //////////////////////////////////
	 // Remove all bookmarks WARNING //------>
	//------>
	if ($op == 'drop_all_bookmarks') { // Remove all bookmarks
		$block['AdminBlock'] = "
			<table width='1px' cellspacing='0' cellpadding='0' align='center'>
				<tr>
					<td align='center'>
						<h4>Are You Sure?</h4>
						<div >						
							All bookmarks from this list will be removed<br>
							Please Confirm...<br><br>
						</div>						
					</td>
				</tr>
				<tr>
					<td align='center'><form name='Add URL' method='post' style='border:0px;padding:0px;'>
						<input type='hidden' name='op' value='remove_all_bookmarks_ok'>
						<input type='submit' value=' Yes ' style='border: #ee0000 1px solid; font: 10px verdana, arial, helvetica, sans-serif; background-color: #ee0000; color:#FFFFFF; font-weight:bold;'>
						<input type='button' value=' No ' onclick='location=\"".$HTTP_REFERER."\"' style='border: #336699 1px solid; font: 10px verdana, arial, helvetica, sans-serif; background-color: #336699; color:#FFFFFF; font-weight:bold;'>
						</form>
					</td>
				</tr>
			</table>
		";
		return $block;
	}

	  //////////////////////////////////
	 // Remove all bookmarks Proceed //------>
	//------>
	if ($op == 'remove_all_bookmarks_ok') { // Remove all bookmarks
		$sql = "DELETE FROM ".$xoopsDB->prefix("relacione_tmpuri");
		if ($xoopsDB->queryF($sql)) {
			redirect_header(XOOPS_URL, 1, "Success");
		} else {
			redirect_header(XOOPS_URL, 1, "Failure");
		}	
	}
}
//
/////////////////////////////// END FORM REQUESTS /////////////////////////////////
//end

//---------------------------------------------------------------------------------

//start
/////////////////////////////// BLOCK CONTENT START ///////////////////////////////
//

	  /////////////////////////////////////////////////	
	 // Module information section, value gathering //------>
	//------>	
	$recognized = "";
	$recognized .= isset($xoopsModule) ? "&raquo; ID : ".intval($xoopsModule->mid())." (".$xoopsModule->name().")"."<br>" : "";
	$recognized .= isset($storytopic)  ? "&raquo;&raquo; Topic ID : ".       $storytopic ."<br>" : "";
	$recognized .= isset($storyid)     ? "&raquo;&raquo; Story ID : ".       $storyid    ."<br>" : "";
	//$recognized .= isset($page)        ? "&raquo;&raquo;&raquo; Page ID : ". $page       ."<br>" : "";
	$recognized .= isset($cid)         ? "&raquo; Category ID : ".           $cid        ."<br>" : "";
	//$recognized .= isset($lid)         ? "&raquo;&raquo; Download ID : ".    $lid        ."<br>" : "";

	  //////////////////////////////////
     // Temporary bookmark list Form //------>
	//------>			
	$tmpuri = "";
	$sql = "SELECT * FROM ".$xoopsDB->prefix('relacione_tmpuri')." ORDER BY 'modid','recid' ASC";
	$result = $xoopsDB->query($sql); // error check, not implemented yet....
	$row = 0;
	while ($myrow = $xoopsDB->fetchArray($result)) {
		//$tmpuri .= "(".$myrow['recid'].") <a href='".$myrow['url']."' title='".$myrow['url']."'>".$myrow['title']."</a><br>";
		$tmpuri .= "<tr><td align='right'><input type='hidden' name='link_row' value='".$row."'>"
				  ."<input type='hidden' name='urid[$row]' value='".$myrow['urid']."'>"
				  ."<input type='hidden' name='link_old_title[$row]' value='".$myrow['title']."'>"
				  ."[".$myrow['modid']."]&nbsp;</td><td align='left' width='1px'><input type='text' name='link_title[$row]' value='".$myrow['title']."' size='60' maxlength='120'/></td>"
				  ."<td align='left'><input type='hidden' name='link_id[$row]' value='".$myrow['recid']."'><a href='".$myrow['url']."' title='".$myrow['url']."'><img hspace='2' align='top' src='".XOOPS_URL."/modules/relations/images/link.gif' border=0></a>"
				  ."<a href=\"".XOOPS_URL."/modules/relations/ab_drop_single_bookmark.php?link_id=".$myrow['recid']."\" title='WARNING - this will remove bookmark from here'><img align='absmiddle' src='".XOOPS_URL."/modules/relations/images/remove.gif' border=0></a>"
				  ."<a href=\"".XOOPS_URL."/modules/relations/ab_add_bookmark_to_users_block.php?link_url="
				  				.rawurlencode($myrow['url'])
								."&amp;link_title=".rawurlencode($myrow['title'])
								."&amp;module_id=". $moduleid
								. "&amp;topic_id=". $storytopic
								. "&amp;story_id=". $storyid
								//.  "&amp;page_id=". $page
								.    "&amp;dc_id=". $cid
								//.    "&amp;dl_id=". $lid
								. "&amp;home_url=". rawurlencode($myurl)
								."\" 
								title='Paste this bookmark in UsersBlock on this Page'><img hspace='2' align='absmiddle' src='".XOOPS_URL."/modules/relations/images/paste.gif' border=0></a></td>";
		 $tmpuri .=	!empty($myrow['urid']) ? "<td align='left'><a href=\"".XOOPS_URL."/modules/relations/ab_update_userblock_link.php?link_id=".$myrow['urid']."&amp;link_title=".rawurlencode($myrow['title'])."\" title='Update initial link in users view'><img align='absmiddle' src='".XOOPS_URL."/modules/relations/images/update.gif' border=0></a>"
											."<a href=\"".XOOPS_URL."/modules/relations/ab_jump_to_link_home.php?link_id=".$myrow['urid']."\" title='Initial location for this bookmark'><img hspace='2' align='absmiddle' src='".XOOPS_URL."/modules/relations/images/home.gif' border=0></a></td></tr>"
		 									: "<td align='left'>&nbsp;</td></tr>";
				  //."<a href=\"?op=paste&link_id=".$myrow['recid']."\" title='Save to users Block'><img align='top' src='".XOOPS_URL."/modules/relations/images/paste.gif' border=0></a><br>";
				  //."<input name='sub' type='image' value='op=paste' src='".XOOPS_URL."/modules/relations/images/paste.gif' alt='Post Linkn to users block' align='top' border='0'><br>";
		 $row++;		
	}
	$tmpuri = !empty($tmpuri) ? 
				"<div align='center' style='border-top:1px solid #FF4466;padding:2px;'>
					<form action='' method='post'><table align='center' width='50%' cellpadding='1px' cellspacing='1px' >".$tmpuri
				  ."</table>
				  	<input type='hidden' name='rows' value='$row'>
					<input type='hidden' name='op'   value='bquickupdate'><br>
					<input type='submit' value='Update'>
					<input type='reset'  value='Reset'>
					</form>		
				 </div>" : "";

				 
	  /////////////////////
     // Menu bar string //------>
	//------>
	
	    $menubar  = "<table cellspacing='0' cellpadding='0' style='border-top:1px solid #FF4466;'>
					<tr>
						<td align='left'><form name='AddCurrentURL' method='post' style='margin:2px 10px 0px 10px;'><input type='hidden' name='op' value='add_bookmark'><input type='submit' value='Add URL' style='border: #336699 1px solid; font: 10px verdana, arial, helvetica, sans-serif; background-color: #336699; color:#FFFFFF; font-weight:bold;'></form></td>";
						$menubar .= !empty($tmpuri) ? "<td align='right'><form name='DelAllBookmarks' method='post' style='margin:2px 10px 0px 10px;'><input type='hidden' name='op' value='drop_all_bookmarks'><input type='submit' value='Remove All'  style='border: #ee0000 1px solid; font: 10px verdana, arial, helvetica, sans-serif; background-color: #ee0000; color:#FFFFFF; font-weight:bold;'></form></td>" : "";
		$menubar  .= "</tr></table>";
	   
	  ///////////////////
     // Block Output  //------>
	//------>

			if (!empty($recognized)) { 
				$block['AdminBlock'] = 
					"<div style='padding:2px;'><b>Binding values</b><br>"
						.$recognized
					."</div>" 
					.$tmpuri				
					.$menubar;
			} //unset($block['AdminBlock']); // Sorry folks,<br>can't make any<br>related links here.<br>
	return $block;
	}
}

//
/////////////////////////////// BLOCK CONTENT END ///////////////////////////////
//

?>