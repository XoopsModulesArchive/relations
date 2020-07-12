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

if ( !is_object($xoopsUser) || !is_object($xoopsModule) || !$xoopsUser->isAdmin($xoopsModule->getVar('mid')) ) {
	exit("Access Denied");
} else {	
	xoops_cp_header();
		echo "<h4 style=\"border-bottom:2px red solid;padding:3px;\">Content Relations MGR - How to use it?</h4>			
			&nbsp;&nbsp;This is a very simple but powerful enough module to help web site admins to better organize existing portal content and also represent visitors with an extra information 
			block <b>{Related...}</b> what keeps a short link list to this site other pages - such as [News, Downloads, FAQ, etc]. User block can be easily binded 
			up to any installed Module what has it's own page (except system module) and separately to the <b>News</b> [Single - Article or Topic] or also 
			to the <b>Downloads</b> [Single - Category].<br>
			<br>			
			After successfull installation of this module you will be rewarded with two new Blocks:<br>
			<ul>
				<li>User Block - <b>{Related...}</b></li>
				<li>Admin Block - <b>{Relations Builder}</b></li>
			</ul>
			and also a very modest admin's page for managing existing links.<br>
			<br>
			&nbsp;&nbsp;The very first thing what you should do before kicking-off would be establishing a group access privilegies via Xoops Admin menu [System Admin => Groups], 
			you have to specify which user group will have an access to <b>{Relations Builder}</b> block and which group will have an access for <b>Related Content</b> Module Admin 
			rights also you have to give an access rights for <b>{Related...}</b> block to the groups of your own choice.<br>
			<br>
			&nbsp;&nbsp;Secondary you will have to specify on what pages new blocks will be available, you should enable both blocks on all pages 
			to make the system work properly, you don't have to worry about anything else, just go to your site, log in as admin and feel the power 
			of linked content.<br>
			<br>
			&nbsp;&nbsp;Additionally for better functionality and site look you should specify that <b>{Related...}</b> is either on the left or right column of your site 
			and <b>{Relations Builder}</b> shall be in the middle, otherwise the whole look of your site could get an unacceptable shape.<br>
			<br>
			&nbsp;&nbsp;Now, when you have finished with a setup you are ready to rock & roll and surprisingly it's very easy, remeber - you have to be logged in as 
			admin, then:
			<br>
			<ul>
				<li> - go to the page what you want to add to your <b>{Related...}</b> block and click <b>[Add URL]</b> from addmins block, then the current URL will be placed into the
				bookmarks list or you can call it a temporary link list.
				<li> - now you have to add a title for your new link, just edit and hit the <b>[Enter]</b> or click on <b>[Update]</b>.
				<li> - next step is that you have to go to the page where you want to place a single link from your bookmarked link list and click on the third icon in a row after 
				the link title and final magic will happen, link will be pasted in <b>{Related...}</b> block, so you can go to any other page and paste links from your bookmarks list...
				<li> ....everything else you will easily understand from the related icon titles or descriptions in the block.
			</ul>
			<p style=\"border-top:2px red solid;padding:3px;font-size:9px;\">
			<b>[Content Relations MGR]</b> is a free software, released under the <a target=\"_blank\" href=\"http://www.gnu.org/licenses/gpl.html\">GNU/GPL license.</a><br>
			Look for updates at <a target=\"_blank\" href=\"http://www.tomsys.net/\" style='font-weight: bold; color: #0099ee; text-decoration: none;'>[www.tomsys.net]</a>
			</p>
			";
	xoops_cp_footer();
}
?>