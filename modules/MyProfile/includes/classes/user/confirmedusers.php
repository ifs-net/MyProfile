<?php
/**
 * @package      MyProfile
 * @version      $Id: $
 * @author       Florian Schießl
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

class MyProfile_user_ConfirmedUsersHandler
{
	function initialize(&$render)
	{	    
	  	// Admins should be able to modify user's profile data
		$users = pnModAPIFunc('MyProfile','user','getCustomFieldList',array(
			'uid' 			=> pnUserGetVar('uid'),
			'excludeowner' 	=> 1));
		$render->assign('users',	$users);
		$render->assign('authid',	SecurityUtil::generateAuthKey());
		return true;
    }
	function handleCommand(&$render, &$args)
	{
		if ($args['commandName']=='update') {
			// get the pnForm data and do a validation check
		    $obj = $render->pnFormGetValues();		    
		    if (!$render->pnFormIsValid()) return false;
			
			// check username
			$uid = (int)pnUserGetVar('uid');
			$confirmed_uid = (int)pnUserGetIDFromName($obj['uname']);
			if (!($confirmed_uid > 1)) {
			  	LogUtil::registerError(_MYPROFILEUSERNOTFOUND);
			  	return false;
			}
			else if ($uid == $confirmed_uid) {
			  	LogUtil::registerError(_MYPROFILEDONOTADDYOURSELF);
			  	return false;
			}
			else if (in_array($confirmed_uid,pnModAPIFunc('MyProfile','user','getCustomFieldList',array('uid' => $uid)))) {
			  	LogUtil::registerError(_MYPROFILEUSERALREADYADDED);
			  	return false;
			}
			else {
			  	$obj = array(	'uid'			=> $uid,
				  				'confirmed_uid'	=> $confirmed_uid);
				prayer($obj);
			  	if (!DBUtil::insertObject($obj,'myprofile_confirmedusers')) {
				  	LogUtil::registerError(_MYPROFILEUSERADDERROR);
				  	return false;
				} 
			}
			LogUtil::registerStatus(_MYPROFILEUSERADDED);
			return pnRedirect(pnModURL('MyProfile','user','confirmedusers'));
		}
		return true;
    }
}

