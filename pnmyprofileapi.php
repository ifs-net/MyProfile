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
	$regdate	= pnUserGetVar('user_regdate',$uid);
	$lastupdate	= pnModAPIFunc('MyProfile','user','getLastUpdate',array('uid'=>$uid));
	$dateformat = pnModGetVar('MyProfile','dateformat');
	if (pnModGetVar('Users','savelastlogindate') == 1) $lastlogin = pnUserGetVar('lastlogin',$uid);	
	$render->assign('uname',	$uname);
	$render->assign('uid',		$uid);
	$render->assign('regdate',	$regdate);
	$render->assign('lastupdate',$lastupdate);
	$render->assign('dateformat',$dateformat);
	if (isset($lastlogin)) $render->assign('lastlogin',$lastlogin);
	// return output
	$output = $render->fetch('myprofile_myprofile_tab.htm');
	return $output;
//	echo DataUtil::convertToUTF8($output);
//	return;
}
?>