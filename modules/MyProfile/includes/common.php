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
  	  	$stats['day'] = mktime(12,0,0,date("m"),date("d"),date("Y"))/(60*60*24);
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