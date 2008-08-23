<?php

/**
 * show myprofile info box
 *
 * $args['uid']		int		user id
 */
function smarty_function_myprofile($args, &$smarty)
{
	$uid = $args['uid'];
    if(pnModAvailable('MyProfile')) {
    	// get user data;
	    $user = DBUtil::selectObjectByID('users', $uid, 'uid', null, null, null, false);
	    if (!is_array($user)) return false; // no user data?
	    $myprofile = unserialize($user['__ATTRIBUTES__']['myprofile']);
	    if (!isset($myprofile) || !is_array($myprofile)) $user['__ATTRIBUTES__']['myprofile'] = pnModAPIFunc('MyProfile','user','getProfile',array('uid' => $args['uid']));
	    // call function that creates render output
	    return pnModAPIFunc('MyProfile','plugin','myprofile',array('user' => $user));
    }
}      

?>
