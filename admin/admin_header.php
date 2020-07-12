<?php
//  -------------------------------------------------------------------------- //
//  [CONTENT RELATIONS MGR FOR XOOPS-R2]
//  Author: Toms Veilands [tomsys@tomsys.net] [www.tomsys.net] [AKA tomsys]
//  Credits: Xoops Team [www.xoops.org]
//  Version: 1.0
//  ReleaseDate: May 03, 2003
//  License: GPL - [http://www.gnu.org/licenses/gpl.html]
//  -------------------------------------------------------------------------- //

include '../../../../mainfile.php';
include XOOPS_ROOT_PATH.'/include/cp_functions.php';
if (is_object($xoopsUser)) {
	$module_handler =& xoops_gethandler('module');
	$xoopsModule =& $module_handler->getByDirname('system');
	if (!in_array(XOOPS_GROUP_ADMIN, $xoopsUser->getGroups())) {
		$sysperm_handler =& xoops_gethandler('groupperm');
		if (!$sysperm_handler->checkRight('system_admin', XOOPS_SYSTEM_COMMENT, $xoopsUser->getGroups())) {
			redirect_header(XOOPS_URL.'/', 3, _NOPERM);;
			exit();
		}
	}
} else {
	redirect_header(XOOPS_URL.'/', 3, _NOPERM);
	exit();
}
?>