<?php
/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schie�l
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
 
/**
 * This function shows the content of the main MyProfile tab
 *
 * @return output
 */
function MyProfile_myprofileapi_tab ($args)
{
	$render = pnRender::getInstance('MyProfile');

	// get and assign some data
	$uid				= (int)FormUtil::getPassedValue('uid');
	$uname				= FormUtil::getPassedValue('uname');
	$overridetemplate 	= (int)FormUtil::getPassedValue('overridetemplate');
	$viewer_uid 		= pnUserGetVar('uid');
	$regdate			= pnUserGetVar('user_regdate',$uid);
	$dateformat 		= pnModGetVar('MyProfile','dateformat');
	$lastupdate			= pnModAPIFunc('MyProfile','user','getLastUpdate',array('uid'=>$uid));
	$profile			= pnModAPIFunc('MyProfile','user','getProfile',array('uid'=>$uid, 'uname'=>$uname));
	$settings			= pnModAPIFunc('MyProfile','user','getSettings',array('uid'=>$uid));
	$render->assign('profile',$profile);

	// we need to get the name of the first separator to avoid problems when separators are used as tabs
	$render->assign('separators_usetabs',	pnModGetVar('MyProfile','separators_usetabs'));
	$first_separator = mp_getFirstSeparator($profile);
	$render->assign('first_separator',$first_separator);

	// check for individual user permission settings
	$individualpermissions = pnModGetVar('MyProfile', 'individualpermissions');
	if ($individualpermissions == 1) {
		$individualpermission = (int)$settings['individualpermission'];
		// 0 = everybody, 1 = members, 2 = buddies only
		if ( 	(
				($individualpermission == 1) && 
				(!pnUserLoggedIn())
					||
				(($individualpermission == 2) && 
				pnModAvailable('ContactList') && 
				!pnModAPIFunc('ContactList','user','isBuddy',array(
						'uid1' 	=> $uid, 
						'uid2' 	=> pnUserGetVar('uid')	)))
				)
				
				&&
				
				($uid != $viewer_uid)
				 	) {
			return $render->fetch('myprofile_myprofile_tab_noaccess.htm');
		}
		
	}

	// now we shall do a check if individual template are allowed or not and if they are allowed use the template if there is one
	$individualtemplates = (int)pnModGetVar('MyProfile','individualtemplates');
	$render->assign('individualtemplates', $individualtemplates);
	if (($individualtemplates == 1) && ($overridetemplate != 1)) {
		// individual templating allowed; get user's template
		$template = $settings['individualtemplate'];
		if (isset($template) && (strlen($template) > 0)) {
			$toreplace1 = array();
			$toreplace2 = array();
			foreach ($profile as $data) {
			  	if ($data['fieldtype'] != 'SEPARATOR') {
					$toreplace1[] = '�'.$data['identifier'].'�';
					$toreplace2[] = $data['value'];
				}
			}
		  	$individualtemplate_content = str_replace($toreplace1,$toreplace2,$template);
		  	$render->assign('individualtemplate_content',$individualtemplate_content);
		}
	}

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
	$render->assign('pnmessagesavailable',	pnModAvailable('pnMessages'));
	$render->assign('contactlistavailable',	pnModAvailable('ContactList'));
	if (pnModAvailable('ContactList')) $render->assign('contactlist_nopublicbuddylist',	pnModGetVar('ContactList','nopublicbuddylist'));
	if (isset($lastlogin)) $render->assign('lastlogin',$lastlogin);

	// return output
	return $render->fetch('myprofile_myprofile_tab.htm');
}
?>