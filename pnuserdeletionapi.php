<?php
/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schießl
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
 
 
/**
 * This file is a skeleton file that can be adopted by every module developer
 */
 
/**
 * Delete a user in the module "UserPictures"
 * 
 * @param	$args['uid']	int		user id
 * @return	array   
 */
function MyProfile_userdeletionapi_delUser($args)
{
    $dom = ZLanguage::getModuleDomain('MyProfile');
  	$uid = $args['uid'];
	if (!pnModAPIFunc('UserDeletion','user','SecurityCheck',array('uid' => $uid))) {
	  	$result 	= _NOTHINGDELETEDNOAUTH;
	}
	else {
	  	// Here you should write your userdeletion routine.
	  	// Delete your database entries or anonymize them.
		DBUtil::deleteObjectByID('myprofile',$uid);
		// delete templates - if there was one
		DBUtil::deleteObjectByID('myprofile_templates',$uid);
		// delete user if he is listed on any other "trust-lists"
		$tables = pnDBGetTables();
		$column = $tables['myprofile_confirmedusers_column'];
		$where = $column['confirmed_uid']." = ".$uid." OR ".$column['uid']." = ".$uid;
		DBUtil::deleteWhere('myprofile_confirmedusers',$where);
		$result = __('Profile data deleted for user', $dom)." ".pnUserGetVar('uname',$uid);
	}
	return array(
			'title' 	=> __('User-Profile', $dom),
			'result'	=> $result

		);
}