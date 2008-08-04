<?php
/**
 * This function shows the content of the main MyProfile tab
 *
 * @return output
 */
function MyProfile_myprofileapi_tab ($args)
{
	$render = pnRender::getInstance('MyProfile');

	// get and assign some data
	$uid			= (int)FormUtil::getPassedValue('uid');
	$uname			= FormUtil::getPassedValue('uname');
	$viewer_uid 	= pnUserGetVar('uid');
	$regdate		= pnUserGetVar('user_regdate',$uid);
	$dateformat 	= pnModGetVar('MyProfile','dateformat');
	$lastupdate		= pnModAPIFunc('MyProfile','user','getLastUpdate',array('uid'=>$uid));
	$profile		= pnModAPIFunc('MyProfile','user','getProfile',array('uid'=>$uid, 'uname'=>$uname));
	$render->assign('profile',$profile);

	// assign user name and uid
	if (isset($uid) && ($uid > 1)) $uname = pnUserGetVar('uname',$uid);
	else $uname = pnUserGetIDFromName($uid);
	if (pnModGetVar('Users','savelastlogindate') == 1) $lastlogin = pnUserGetVar('lastlogin',$uid);	
	$render->assign('uname',				$uname);
	$render->assign('uid',					$uid);
	$render->assign('viewer_uid',			$viewer_uid);
	$render->assign('regdate',				$regdate);
	$render->assign('lastupdate',			$lastupdate);
	$render->assign('dateformat',			$dateformat);
	$render->assign('avatar',				pnUserGetVar('_YOURAVATAR',$uid));
	$render->assign('contactlistavailable',	pnModAvailable('ContactList'));
	$render->assign('pnmessagesavailable',	pnModAvailable('pnMessages'));
	if (pnModAvailable('ContactList')) $render->assign('contactlist_nopublicbuddylist',	pnModGetVar('ContactList','nopublicbuddylist'));
	if (isset($lastlogin)) $render->assign('lastlogin',$lastlogin);
		
	// return output
	return $render->fetch('myprofile_myprofile_tab.htm');
}
?>