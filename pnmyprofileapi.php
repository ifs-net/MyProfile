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
	$uid	= (int)FormUtil::getPassedValue('uid');
	$uname	= FormUtil::getPassedValue('uname');
	$profile= pnModAPIFunc('MyProfile','user','getProfile',array('uid'=>$uid, 'uname'=>$uname));
	$render->assign('profile',$profile);

	// assign user name and uid
	if (isset($uid) && ($uid > 1)) $uname = pnUserGetVar('uname',$uid);
	else $uname = pnUserGetIDFromName($uid);
	$render->assign('uname',	$uname);
	$render->assign('uid',		$uid);
	$render->assign('regdate',	pnUserGetVar('user_regdate',$uid));
	// return output
	$output = $render->fetch('myprofile_myprofile_tab.htm');
	return $output;
//	echo DataUtil::convertToUTF8($output);
//	return;
}
?>