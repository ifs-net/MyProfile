<?php
/**
 * @package      MyProfile
 * @version      $Id$
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
			  	LogUtil::registerError(__('The username you specified does not exist', $dom));
			  	return false;
			}
			else if ($uid == $confirmed_uid) {
			  	LogUtil::registerError(__('I hope you trust yourself, but you cannot add your own username to your list', $dom));
			  	return false;
			}
			else if (in_array($confirmed_uid,pnModAPIFunc('MyProfile','user','getCustomFieldList',array('uid' => $uid)))) {
			  	LogUtil::registerError(__('User already marked', $dom));
			  	return false;
			}
			else {
			  	$obj = array(	'uid'			=> $uid,
				  				'confirmed_uid'	=> $confirmed_uid);
			  	if (!DBUtil::insertObject($obj,'myprofile_confirmedusers')) {
				  	LogUtil::registerError(__('An error occured while trying to add the user to your list', $dom));
				  	return false;
				} 
			}
			LogUtil::registerStatus(__('User was added to the list', $dom));
			return pnRedirect(pnModURL('MyProfile','user','confirmedusers'));
		}
		return true;
    }
}

