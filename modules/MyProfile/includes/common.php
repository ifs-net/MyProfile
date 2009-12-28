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
 * store user information for statistics
 */
function mp_storeStats() {
  	$laststats = pnModGetVar('MyProfile','laststats');
  	$ts = time();
  	$date = date("Y-m-d",$ts);
  	if (!isset($laststats) || ($laststats != $date)) {
  	  	// no stats for today => write stats into table!
  	  	$stats = mp_getInformation();
  	  	$stats['day'] = (int)mktime(12,0,0,date("m"),date("d"),date("Y"))/(60*60*24);
  	  	if ((int)DBUtil::selectObjectCountByID('myprofile_stats',$stats['day'], 'day') == 0) {
			DBUtil::insertObject($stats,'myprofile_stats');
		}
		pnModSetVar('MyProfile','laststats',$date);
	}
}
 
/**
 * get user information
 */
function mp_getInformation() {
  	// get db / table information
  	$tables = pnDBGetTables();
  	$users_column = $tables['users_column'];
  	$attributes_column = $tables['objectdata_attributes_column'];
  	$myprofile_column = $tables['myprofile_column'];
  	// get values
  	// all users of zikula
	$user_all = DBUtil::selectObjectCount('users');
	// all users with myprofile profile
	$myprofile_all = (int)DBUtil::selectObjectCount('myprofile');
	// active users zikula
	$where = $users_column['activated']." = 1";
	$user_active = (int)DBUtil::selectObjectCount('users',$where);
	// active users logged in in last two weeks
	$where = $users_column['activated']." = 1 AND ".$users_column['lastlogin']." >= '".date("Y-m-d H:i:s",(time()-60*60*24*14))."'";
	$user_14d = (int)DBUtil::selectObjectCount('users',$where);
	// active users logged in in last month
	$where = $users_column['activated']." = 1 AND ".$users_column['lastlogin']." >= '".date("Y-m-d H:i:s",(time()-60*60*24*30))."'";
	$user_30d = (int)DBUtil::selectObjectCount('users',$where);
	//... last two months
	$where = $users_column['activated']." = 1 AND ".$users_column['lastlogin']." >= '".date("Y-m-d H:i:s",(time()-60*60*24*60))."'";
	$user_60d = (int)DBUtil::selectObjectCount('users',$where);
	//... last three months
	$where = $users_column['activated']." = 1 AND ".$users_column['lastlogin']." >= '".date("Y-m-d H:i:s",(time()-60*60*24*90))."'";
	$user_90d = (int)DBUtil::selectObjectCount('users',$where);
	//... last nine months
	$where = $users_column['activated']." = 1 AND ".$users_column['lastlogin']." >= '".date("Y-m-d H:i:s",(time()-60*60*24*180))."'";
	$user_180d = (int)DBUtil::selectObjectCount('users',$where);
	//... last year
	$where = $users_column['activated']." = 1 AND ".$users_column['lastlogin']." >= '".date("Y-m-d H:i:s",(time()-60*60*24*365))."'";
	$user_365d = (int)DBUtil::selectObjectCount('users',$where);
	//online today or yesterday
	$where = $users_column['lastlogin']." > '".date("Y-m-d 00:00:00",(time()-60*60*24))."' AND ".$users_column['lastlogin']." < '".date("Y-m-d 23:59:59",(time()-60*60*24))."' ";
	$user_yesterday = (int)DBUtil::selectObjectCount('users',$where);
	//users requested account the last 30 days
	$where = $users_column['user_regdate']." >= '".date("Y-m-d H:i:s",(time()-60*60*24*30))."'";
	$user_new30d = (int)DBUtil::selectObjectCount('users',$where);
	// users marked as invalid email accounts
	$where = $attributes_column['attribute_name']." = 'myprofile_invalidemail'";
	$users_invalidemail = (int)DBUtil::selectObjectCount('objectdata_attributes',$where);
	// users marked as invalid email accounts and marker exists more than 30 days
	$where = $attributes_column['attribute_name']." = 'myprofile_invalidemail' AND oba_cr_date <= '".date("Y-m-d H:i:s",(time()-60*60*24*30))."'";
	$users_invalidemail_30d = (int)DBUtil::selectObjectCount('objectdata_attributes',$where);
	
	return array (
			'users' 			=> (int)$user_all,
			'users_active'		=> (int)$user_active,
			'users_yesterday'	=> (int)$user_yesterday,
			'users_14d'			=> (int)$user_14d,
			'users_30d'			=> (int)$user_30d,
			'users_60d'			=> (int)$user_60d,
			'users_90d'			=> (int)$user_90d,
			'users_180d'		=> (int)$user_180d,
			'users_365d'		=> (int)$user_365d,
			'users_new30d'		=> (int)$user_new30d,
			'myprofile'			=> (int)$myprofile_all,
			'noprofile'			=> (int)($user_all - $myprofile_all),
			'invalidemail'		=> (int)$users_invalidemail,
			'invalidemail30d'	=> (int)$users_invalidemail30d
		);
}

/**
 * get raw statistic data as text
 *
 */
function mp_getRawInformation() 
{
    $range = (int) FormUtil::getPassedValue('range');
    if ($range <= 0) {
        $interval = 180;
    } else {
        $interval = $range;
    }
   	$day = round((time()-($interval*24*60*60) ) / (24*60*60));
	$where = 'day > '.$day;
	$res = DBUtil::selectObjectArray('myprofile_stats',$where);
	foreach ($res as $item) {
		$day = date("Y-m-d",($item['day'])*(24*60*60));
		unset($item['day']);
		$c.=$day;
		foreach ($item as $key=>$value) {
		  	$c.=",".$value;
		}
		$c.="\n";
	}
	return $c;
}

/**
 * System Init Code
 *
 */
function mp_systemInit()
{
  	// Only interesting for users having an account
	if (!pnUserLoggedIn()) {
		return true;
	} else {
	  	pnUserSetVar('lastlogin',date("Y-m-d h:i:s",time()),pnUserGetVar('uid'));
	}
	
	// Integrate generation of statistics here
	mp_storeStats();

	// Do nothing in admin interface or if the used module's name is MyProfile
	$act_mod  = pnModGetName();
	$act_type = strtolower(FormUtil::getPassedValue('type'));
	$act_func = strtolower(FormUtil::getPassedValue('func'));
	if ((($act_mod == 'MyProfile') && ($act_func == '')) || ($act_type == 'admin') || ($act_type == 'ajax')) {
        return true;
	} 

	// First check: user needs a valid profile?
	if (pnModGetVar('MyProfile','mandatory') == 1)	{
	  	// Check for valid profile
	  	if (!pnModAPIFunc('MyProfile','user','hasValidProfile')) {
			// load language file
			pnModLangLoad('MyProfile','plugin');
			// register error message
			LogUtil::registerError(__('Your profile is outdated or incomplete - please check / complete / update your personal data', $dom));
			return pnRedirect(pnModURL('MyProfile','user','main'));
	  	}
	}
	
	// Is the user's email address invalid?
  	$attributes = pnUserGetVar('__ATTRIBUTES__');
  	if (
        (($attributes['myprofile_invalidemail'] == 1) && ($act_mod != 'MyProfile')) ||
        (($attributes['myprofile_invalidemail'] == 1) && ($act_mod == 'MyProfile') && (($act_func != 'settings') && ($act_func != 'validatemail'))) 
        ) {
	    // user has invalid email address
  	  	// load language file
  	  	pnModLangLoad('MyProfile','plugin');
  	  	// register error message
	    LogUtil::registerError(__('Your email address has to be updated before using this site! EMails came back to the administrator that did not reach you - valid email addresses are mandatory for this site! After changing your email address you will be able to use this site again!', $dom));
	    return pnRedirect(pnModURL('MyProfile','user','settings',array('mode' => 'email')));
	}

	// Nothing has to be done... everything seems to be great!
	return true;
}

/**
 * This function redirects to the profile management BEFORE a user can surf the page
 *
 */
function mp_checkForAccount()
{
    if (!pnUserLoggedIn()) return;
    $uid	= pnUserGetVar('uid');
    $module	= FormUtil::getPassedValue('module');
    if ($module=='MyProfile') return;
	// if the user has administration permissions a profile is not mandatory
    $profile = pnModAPIFunc('MyProfile','user','getProfile',array('uid'=>$uid));
    if (!$profile) {
		if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_ADMIN)) {
		modules_get_language();
		pnModLangLoad('MyProfile', 'user');
		LogUtil::registerError(__('Please fill out your personal profile first. This is neccessary before you can interact in this community!', $dom));
		return pnRedirect(pnModURL('MyProfile','user','main'));
		}
	}	
	return;
} 

/**
 * This function reads out the first separator id of a profile
 *
*/
function mp_getFirstSeparator($profile) {
  	foreach ($profile as $p) {
	    if ($p['fieldtype'] == 'SEPARATOR') {
		  	return $p['id'];
		}
	}
	return 0;
}