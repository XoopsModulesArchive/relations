<?php
//  -------------------------------------------------------------------------- //
//  [CONTENT RELATIONS MGR FOR XOOPS-R2]
//  Author: Toms Veilands [tomsys@tomsys.net] [www.tomsys.net] [AKA tomsys]
//  Credits: Xoops Team [www.xoops.org]
//  Version: 1.0
//  ReleaseDate: May 03, 2003
//  License: GPL - [http://www.gnu.org/licenses/gpl.html]
//  -------------------------------------------------------------------------- //


include '../../../include/cp_header.php';

if ( file_exists("../language/".$xoopsConfig['language']."/admin.php") ) {
	include "../language/".$xoopsConfig['language']."/admin.php";
} else {
	include "../language/english/admin.php";
}


if ( !is_object($xoopsUser) || !is_object($xoopsModule) || !$xoopsUser->isAdmin($xoopsModule->getVar('mid')) ) {
	exit("Access Denied");
} else {	
	if ( isset($HTTP_POST_VARS) ) {
		foreach ( $HTTP_POST_VARS as $k => $v ) {
			${$k} = $v;
	  	}
	}
	
	$modselect = isset($HTTP_GET_VARS['modselect']) ? intval($HTTP_GET_VARS['modselect']) : 0;
		$limit = isset($HTTP_GET_VARS['limit'])     ? intval($HTTP_GET_VARS['limit'])     : 0;
		$start = isset($HTTP_GET_VARS['start'])     ? intval($HTTP_GET_VARS['start'])     : 0;
	   $hidden = isset($HTTP_GET_VARS['hidden'])    ? intval($HTTP_GET_VARS['hidden'])    : 0;
    $searchstr = isset($HTTP_GET_VARS['searchstr']) ?   trim($HTTP_GET_VARS['searchstr']) : '';
		   $op = isset($HTTP_GET_VARS['op'])        ?   trim($HTTP_GET_VARS['op'])        : 'list';	   

	$modselect = isset($HTTP_POST_VARS['modselect']) ? intval($HTTP_POST_VARS['modselect']) : $modselect;
		$limit = isset($HTTP_POST_VARS['limit'])     ? intval($HTTP_POST_VARS['limit'])     : $limit;
		$start = isset($HTTP_POST_VARS['start'])     ? intval($HTTP_POST_VARS['start'])     : $start;
	   $hidden = isset($HTTP_POST_VARS['hidden'])    ? intval($HTTP_POST_VARS['hidden'])    : $hidden;
    $searchstr = isset($HTTP_POST_VARS['searchstr']) ?   trim($HTTP_POST_VARS['searchstr']) : $searchstr;	   
		   $op = isset($HTTP_POST_VARS['op'])        ?   trim($HTTP_POST_VARS['op'])        : $op;
	   
	switch ($op) {
		case 'quickupdate':
			$count = $rows;		
			for ( $r = 0; $r < $count; $r++ ) {								
				if ( $link_old_title[$r] != $link_title[$r]) {
					 $sql = "UPDATE ".$xoopsDB->prefix('relacione_uri')." SET title='".$link_title[$r]."' WHERE urid='".$link_id[$r]."'";
					 $res = $xoopsDB->query($sql); //sorry no testing here yet
				}
				if ( $link_old_visible[$r] != $link_visible[$r]) {
					 $sql = "UPDATE ".$xoopsDB->prefix('relacione')." SET visible='".$link_visible[$r]."' WHERE urid='".$link_id[$r]."'";
					 $res = $xoopsDB->query($sql); //sorry no testing here yet
				}
			}
			redirect_header($HTTP_REFERER, 1, _RC_DBSUCCESS);
		break;
		case 'delconfirm':
			xoops_cp_header();
			$confirm_values = array('rec_id'    => $rec_id,
									'modselect' => $modselect,
									'hidden'    => $hidden,
									'limit'     => $limit,
									'start'     => $start,
									'searchstr' => $searchstr,
									'op'		=> 'delete');
									//'op'        => array(' Yes '=>'delete','no'=>'resume'));
			xoops_confirm($confirm_values,'index.php', _RC_RUSURE."<br><br>\"".$linktitle."\"", _RC_CONFIRM);			
		break;
		case 'delete':
			$sql = "UPDATE ".$xoopsDB->prefix('relacione_tmpuri')." SET urid = 0 WHERE urid = ".intval($rec_id);
			$success1 = $xoopsDB->queryF($sql) ? 1 : 0; 

			$sql = "DELETE FROM ".$xoopsDB->prefix('relacione')." WHERE urid = ".intval($rec_id);
			$success = $xoopsDB->queryF($sql) ? 1 : 0;

			$sql = "DELETE FROM ".$xoopsDB->prefix('relacione_uri')." WHERE urid = ".intval($rec_id);
		
			if($xoopsDB->queryF($sql) && $success){
				$fintxt = _RC_DBSUCCESS;
			} else {
				$fintxt = _RC_DBFAILURE;
			}
			redirect_header('index.php?modselect='.$modselect.'&amp;hidden='.$hidden.'&amp;limit='.$limit.'&amp;start='.$start,1,$fintxt);
		break;
		case 'bookmark':			
			echo $link_title[1];
			   $link_id = !empty($link_id)    ? intval($link_id)          : 0;
			  $moduleid = !empty($moduleid)   ? intval($moduleid)         : 0;
			 $linktitle = !empty($linktitle)  ? trim($linktitle)  : "";
			  $link_url = !empty($link_url)   ? trim($link_url)   : "";
			$sql = "INSERT INTO ".$xoopsDB->prefix("relacione_tmpuri")." VALUES (NULL, $moduleid, '$link_url', $link_id, '$linktitle') ";
			if ($xoopsDB->queryF($sql)) {
				redirect_header($HTTP_REFERER, 1, _RC_DBSUCCESS);
			} else {
				redirect_header($HTTP_REFERER, 1, _RC_DBFAILURE);
			}
		break;
		case 'list':
			xoops_cp_header();
			echo "<h4 style=\"border-bottom:2px red solid;padding:3px;\">"._RC_MODULETITLE."</h4>";
			make_link_list();
		break;		
		default:
			echo $op;
			redirect_header($HTTP_REFERER, 1, _RC_OPNONEXIST);
		break;
	}
	xoops_cp_footer();
}

function make_link_list(){
		global $xoopsDB, $xoopsConfig, $searchstr, $modselect, $start, $limit, $hidden, $op, $rows;
		$result = $xoopsDB->query('SELECT count(*) FROM '.$xoopsDB->prefix('relacione'));
		$totalz  = $xoopsDB->fetchArray($result);
		$total = $totalz['count(*)'];
		echo _RC_TOTAL." - (<b>".$total."</b>), ";
		
		$limit_array = array(10, 30, 60, 100);
		if (!in_array($limit, $limit_array)) {
			$limit = 60;
		}
		
		$module_handler =& xoops_gethandler('module');
		$installed_mods =& $module_handler->getObjects();
		$modnames		= array();
		$dropdown       = "<option value=''>"._RC_ALLMODULES."</option>";
		foreach ($installed_mods as $module) {
			$modnames[$module->getVar('mid')] = $module->getVar('name');
			if (($module->getVar('dirname') == 'news') ||
				($module->getVar('dirname') == 'mydownloads')) {
					$sel="";
				if ($module->getVar('mid') == $modselect) {
					$sel = ' selected="selected"';
				}
				$dropdown .= "<option".$sel." value='".$module->getVar('mid')."'>".$module->getVar('name')."</option>";
			}
		}
		$limdrop = '';
		foreach ($limit_array as $k) {
			$sel = '';
			if (isset($limit) && $k == $limit) {
				$sel = ' selected="selected"';
			}
			$limdrop .= '<option value="'.$k.'"'.$sel.'>'.$k.'</option>';
		}
		$sql_hidden = "";
		if(($hidden) == 0) {
			$hidedrop = '<option value="0">'._RC_SHOWALL.'</option>
						<option value="1">'._RC_SHOWONLYHIDDEN.'</option>
						<option value="2">'._RC_SHOWONLYVISIBLE.'</option>';
		} elseif (($hidden) == 1) {
			$hidedrop = '<option value="0">'._RC_SHOWALL.'</option>
						<option selected="selected" value="1">'._RC_SHOWONLYHIDDEN.'</option>
						<option value="2">'._RC_SHOWONLYVISIBLE.'</option>';
						$sql_hidden = 'visible = 1 ';
		} elseif(($hidden) == 2) {
			$hidedrop = '<option value="0">'._RC_SHOWALL.'</option>
						<option selected="selected" value="1">'._RC_SHOWONLYHIDDEN.'</option>
						<option selected="selected" value="2">'._RC_SHOWONLYVISIBLE.'</option>';
						$sql_hidden = 'visible != 1 ';
		} 
		
		$sql1  = "SELECT * FROM ".$xoopsDB->prefix('relacione')." a, ".$xoopsDB->prefix('relacione_uri')." b WHERE a.urid = b.urid "; 		
		$sql = !empty($modselect) ? "AND a.modid = ".$modselect : "";
		$sql .= !empty($sql_hidden) ? " AND a.".$sql_hidden : "";
		$sql .= !empty($searchstr) ? " AND b.title LIKE '%".$searchstr."%'" : "";		
		$sql .= !empty($order) ? " ORDER BY ".$order : " ORDER BY modid, title ";
		$sql1 .= $sql." LIMIT ".$start." , ".$limit;
		
		$sql2  = "SELECT count(*) FROM ".$xoopsDB->prefix('relacione')." a, ".$xoopsDB->prefix('relacione_uri')." b WHERE a.urid = b.urid ";
		$sql2 .= $sql;
		
	    $result = $xoopsDB->query($sql1);		 
		  $rows = $xoopsDB->getRowsNum($result);
		  
		$result2 = $xoopsDB->query($sql2);		 
	  $selected_recz = $xoopsDB->fetchArray($result2);
	  $selected_recs = $selected_recz['count(*)'];
	  	echo _RC_SELECTEDBYCRITERIA." - (".$selected_recs.")";
		  
		  	     
		 echo "<form action='index.php' method='get'>
		 		<label>"._RC_CRITERIA.": </label>
				<select name='modselect' >".$dropdown."</select>				
				<select name='hidden'    >".$hidedrop."</select>
				<select name='limit'     >".$limdrop."</select>
				<label> <br>              "._RC_TITLECONTAINS.": </label>
				<input  type='text' name='searchstr' value='".stripslashes($searchstr)."' size='20' maxlength='20'>
				<input  type='submit' value='Go' >
		 	   </form>
		 	  ";
		 
		 
		 if ($rows > 0) {         
         echo "<form action='index.php' method='post'><table class=\"outer\" border=0 cellpadding=0 cellspacing=1 width=\"100%\">"
		     ."<th colspan=\"9\" align='center'>"."&raquo;&nbsp;"._RC_SELECTEDBYCRITERIA."&nbsp;&laquo;"."</th>"
             ."<tr class=\"head\">
			      <td align=\"center\">              "._RC_ID.        "</td>
				  <td align=\"center\">              "._RC_MODULE.    "</td>
				  <td width=\"85%\">                 "._RC_TITLE.     "</td>
				  <td align=\"center\" width=\"1%\"> "._RC_HIDDEN.    "</td>
				  <td colspan=\"5\" align=\"center\">"._RC_OPERATIONS."</td>
			  </tr>";  
		 $row = 0;		 
		 while($data_item = $xoopsDB->fetchArray($result)) {
		 $liner = $row % 2;		 	
		 	if ($liner == 0) { 
				echo "<tr class=\"odd\">" ;
			} else {
				echo "<tr class=\"even\">" ;
			}
			if ($data_item['visible'] == 1) {
				$vis_checked = "checked";
			} else {
				$vis_checked = "";
			}
			echo 
			"		<td align=\"center\">
						<input type='hidden' name='row'           value='".$row."'>											
						<input type='hidden' name='link_id[$row]' value='".$data_item['urid']."'>".$data_item['urid']."
					</td>
					<td align=\"center\"><input type='hidden' name='module_id[$row]'      value='".$data_item['modid']."'>".$modnames[$data_item['modid']]."</td>
					<td align=\"left\"  ><input type='hidden' name='link_old_title[$row]' value='".$data_item['title']."'>
									     <input type='text'   name='link_title[$row]'     value='".$data_item['title']."' size='60' maxlength='120' />
					</td>
					
					<td align=\"center\"><input type='hidden' name='link_old_visible[$row]' value='".$data_item['visible']."'>
					<input style='border:0px; background-color: TRANSPARENT;' type='checkbox' name='link_visible[$row]' value='1' $vis_checked /></td>
					<td align=\"center\"><a href=\"".$data_item['url']."\" target='url_window'>"._RC_TARGETLINK."</a></td>
					<td align=\"center\"><a href=\"".$data_item['home_url']."\" target='home_window'>"._RC_HOMELINK."</a></td>
					<td align=\"center\"><a href=\"./index.php?op=bookmark"
																		."&amp;link_id="    .$data_item['urid']
																		."&amp;moduleid="   .$data_item['modid']
																		."&amp;linktitle="  .$data_item['title']
																		."&amp;link_url="   .$data_item['url']																		
																		."&amp;modselect="  .$modselect
																		."&amp;hidden="     .$hidden
																		."&amp;limit="      .$limit
																		."&amp;start="      .$start
																		."&amp;searchstr="  .$searchstr."\">"._RC_BOOKMARKLINK."</a></td>"
					//<td align=\"center\"><a href=\"./index.php?op=edit&id=".$data_item['id']."\">"._RC_EDITLINK."</a></td>
					."<td align=\"center\"><a href=\"./index.php?op=delconfirm"
																		."&amp;rec_id="    .$data_item['urid']
																		."&amp;linktitle=" .$data_item['title']
																		."&amp;modselect=" .$modselect
																		."&amp;hidden="    .$hidden
																		."&amp;limit="     .$limit
																		."&amp;start="     .$start
																		."&amp;searchstr=" .$searchstr."\">"._RC_DELETELINK."</a></td>
			</tr>";
			$row++;			
        }
		echo "<tr class=\"foot\"><td colspan=\"9\" align=\"center\">
								 <input type='hidden' name='rows' 		value='$row'>
								 <input type='hidden' name='modselect'  value='".$modselect."'>
								 <input type='hidden' name='hidden'     value='".$hidden."'>
								 <input type='hidden' name='limit'      value='".$limit."'>
								 <input type='hidden' name='searchstr'  value='".$searchstr."'>
								 <input type='hidden' name='op'   		value='quickupdate'>
								 <input type='submit' name='update'		value='"._RC_UPDATE."'>
								 <input type='reset'  name='reset'		value='"._RC_RESET."'>
								 </td>
			  </tr>"
			."</table></form>";
			
		if ($selected_recs > $limit) {
			include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
			$nav = new XoopsPageNav($selected_recs, $limit, $start, 'start', 'op=list&amp;limit='.$limit.'&amp;sort='.$sort.'&amp;order='.$order.'&amp;modselect='.$modselect.'&amp;hidden='.$hidden);
			echo _RC_PAGES." ".$nav->renderNav()."";
		}
	}
}




?>