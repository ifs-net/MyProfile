<?php
 
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
  	$uid = $args['uid'];
	if (!pnModAPIFunc('UserDeletion','user','SecurityCheck',array('uid' => $uid))) {
	  	$result 	= _NOTHINGDELETEDNOAUTH;
	}
	else {
	  	// Here you should write your userdeletion routine.
	  	// Delete your database entries or anonymize them.
		DBUtil::deleteObjectByID('myprofile',$uid);
		$result = _MYPROFILEPROFILEDELETEDFOR." ".pnUserGetVar('uname',$uid);
	}
	return array(
			'title' 	=> _MYPROFILEMODULETITLE,
			'result'	=> $result

		);
}
?>