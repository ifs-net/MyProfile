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
 * get a user's profile
 *
 * @param	$args['uid']		int
 * @param	$args['uname']		string
 * @return	array
 */
function MyProfile_userapi_getProfile($args)
{
  	// first check for given username
  	$uname = $args['uname'];
  	if (isset($uname)) $uid = pnUserGetIDFromName($uname);
 	else $uid = (int) $args['uid'];
  	// then check for user id
	$data = DBUtil::selectObjectByID('myprofile', $uid);	
	if (!(count($data)>0)) return false;
	
	// now combine with the fields
	$fields = pnModAPIFunc('MyProfile','admin','getFields');
	// status codes:
	// 0 = visible for guests 
	// 1 = visible for logged in users
	// 2 = visible for administrators only
	if (!pnUserLoggedIn()) $mystatus=0;	// guest
	else if (SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_ADMIN)) $mystatus=2; // admin
	else $mystatus=1; // registered users
	foreach ($fields as $field) {
		$field['value'] = $data[$field['identifier']];
		if (($field['public_status'] > $mystatus) && ($field['value']!="")) {
		  	if ($field['fieldtype'] != "DATE") $field['value']=_MYPROFILENOPERMISSION;
		  	else $field['value'] = "9999-12-31";
		}
		$identifier = $field['identifier'];
		if (($field['active'] == '1') && ($field['shown'] == '1')) $profile[$identifier]=$field;
	}
	return $profile;
}

/**
 * check for valid profile function
 *
 * This function checks if a user has a valid profile. 
 * A profile is invalid if it does not even exist or is outdated
 *
 * @param	$args['uid']	int
 * @return	boolean
 */
function MyProfile_userapi_hasValidProfile($args) {
	$uid = (int)$args['uid'];
	if (!($uid > 0)) $uid = pnUserGetVar('uid');
	$userattributes 	= pnUserGetVar('__ATTRIBUTES__',$uid);
  	$validuntil 		= $userattributes['myprofile_validuntil'];
  	if ($validuntil > 0) {
  	  	// valid until value is stored so the user has 
		// entered a valid profile for at least one time
		if (((int)pnModGetVar('MyProfile','validuntil') > 0) && ($validuntil < time())) return false;
		else return true;		    
	}
	else return false; // to user has not enterd valid profile data yet.
} 

/**
 * get the last update date of a users's profile
 *
 * @param	$args['uid']	int
 * @return	date
 */
function MyProfile_userapi_getLastUpdate($args) 
{
  	if (!((int)$args['uid'] > 0)) return false;
  	$obj = DBUtil::selectObjectByID('myprofile',(int)$args['uid']);
  	$date = $obj['timestamp'];
  	if ($date != '') return $date;
  	else return false;
}

/**
 * get user settings
 *
 * @param	$args['uid']	int
 * @return	array
 */
function MyProfile_userapi_getSettings($args)
{
    $uid = (int) $args['uid'];
    // get user and attributes
    $user = DBUtil::selectObjectByID('users', $uid, 'uid', null, null, null, false);
    if (!is_array($user)) return false; // no user data?
    if (!isset($user['__ATTRIBUTES__']) || (!isset($user['__ATTRIBUTES__']['myprofile_nocomments']))) {
        // userprefs for this user do not exist, create them with defaults
        $user['__ATTRIBUTES__']['myprofile_nocomments'] = 0;
        // store attributes
        DBUtil::updateObject($user, 'users', '', 'uid');
    }
    return array(
    				'id'				=> $uid,
					'nocomments' 		=> $user['__ATTRIBUTES__']['myprofile_nocomments'],
					'validationcode'	=> unserialize($user['__ATTRIBUTES__']['myprofile_validationcode'])
				);
}

/**
 * store user settings
 *
 * @param	$args['uid']		int
 * @param	$args['nocomments']	int
 * @return	array
 */
function MyProfile_userapi_setSettings($args)
{
	$uid = $args['uid'];
	$nocomments = $args['nocomments'];
	if (!(($nocomments >= 0) && ($nocomments <= 1))) $nocomments = 0;
	// get user and attributes
    $user = DBUtil::selectObjectByID('users', $uid, 'uid', null, null, null, false);
    if (!is_array($user)) return false; // no user data?
	$user['__ATTRIBUTES__']['myprofile_nocomments'] = $nocomments;
	// store attributes
	return DBUtil::updateObject($user, 'users', '', 'uid');
}

/**
 * store user attributes
 *
 * This function stores the timestamp till the profile will get 
 * invalid as attribute. If the validuntil value is set to 0 (never get
 * invalid) by the site admin, the actual timestamp gets stored as valid
 * until value. 
 * Additional information will be stored as attributes to the user if 
 * the admin configured myprofile to store the profile also as user attribute.
 *
 * @param	$args['data']		myprofile object
 * @return	boolean
 */
function MyProfile_userapi_storeAsAttributes($args)
{
  	$obj	= $args['data'];
  	if (!isset($obj) || (!($obj['id'] > 1))) return false;
	// get user and attributes
    $user = DBUtil::selectObjectByID('users', $obj['id'], 'uid', null, null, null, false);
    if (!is_array($user)) return false; // no user data? something is wrong!
    // store how long the profile will be valid
    $validuntil = (int)pnModGetVar('MyProfile','validuntil')+time();
	$user['__ATTRIBUTES__']['myprofile_validuntil'] = ($validuntil); 
    // store as attributes if needed
    // otherwise delete older, as attribute stored data
    $asattributes = pnModGetVar('MyProfile','asattributes');
	if ($asattributes == 1) $user['__ATTRIBUTES__']['myprofile'] = serialize($obj);
	else unset($user['__ATTRIBUTES__']['myprofile']);
	// store attributes serialized
	return DBUtil::updateObject($user, 'users', '', 'uid');				
}

/**
 * generate a verification code for a new email to activate this email
 * and store the new email as an attribute in the user's attributes
 *
 * @param	$args['email']		string
 * @return	boolean
 */
function MyProfile_userapi_generateVerificationCode($args)
{
	$uid = pnUserGetVar('uid');
	// get user and attributes
    $user = DBUtil::selectObjectByID('users', $uid, 'uid', null, null, null, false);
    if (!is_array($user)) return false; // no user data?
    
	// we first have to check if there is an active validation code
	$validationcode = $user['__ATTRIBUTES__']['myprofile_validationcode'];
	if (isset($validationcode)) {
	  	$validationcode = unserialize($validationcode);
		$requestban = pnModGetVar('MyProfile','requestban');
		$ban_timestamp = ($validationcode['request_date']+(24*60*60*$requestban));	// $requestban [days]
		if ($ban_timestamp < (time())) unset($validationcode);	// unset the code if the requestban-timelimit is over
		else { // print error message with requestban date
		  	LogUtil::registerError(_MYPROFILENONEWREQUESTBEFORE.' '.date(pnModGetVar('MyProfile','dateformat'),$ban_timestamp));
		  	return false;
		}
	}
	if (isset($validationcode)) return false;	// return false if there is an acitve validation code
	// generate verification code
	$chars = "abcdefghikmnopqrstuvwxyz";   
	mt_srand( (double) microtime() * 1000000); 
	for ($i=1;$i<=25;$i++) $c.=$chars[mt_rand(0,(strlen($chars)-1))];
	
	// an validation code has an expiry date
	// the date when a new validation code can be re-requested is not a
	// part of this array. This setting is to be configures in the MyProfile
	// main administration area.
    $validationcode = array (
    		'code' 			=> $c,
    		'email'			=> $args['email'],
    		'request_date'	=> time(),
    		'expire_date'	=> (time()+(60*60*24*pnModGetVar('MyProfile','expiredays')))
		);
	$user['__ATTRIBUTES__']['myprofile_validationcode'] = serialize($validationcode);

	// update attributes and store new validation code
	DBUtil::updateObject($user, 'users', '', 'uid');

    // send email
    $render = pnRender::getInstance('MyProfile');
    $render->assign('sitename',			pnConfigGetVar('sitename'));
    $render->assign('uid',				$uid);
    $render->assign('validationcode',	$validationcode);
    $render->assign('url',				pnGetBaseURL().pnModURL('MyProfile','user','validatemail',array('code' => $validationcode['code'],'uid' => $uid)));
    $render->assign('validuntil',		date(pnModGetVar('MyProfile','dateformat'),$validationcode['expire_date']));
    $render->assign('alternateurl',		pnGetBaseURL().pnModURL('MyProfile','user','validatemail'));
    $body = $render->fetch('myprofile_email_validationcode.htm');
    $subject = _MYPROFILEVALIDATIONCODEFOR.' '.pnUserGetVar('uname',$uid).' '._MYPROFILEAT.' '.pnConfigGetVar('sitename');
    pnMail($validationcode['email'], $subject, $body, array('header' => '\nMIME-Version: 1.0\nContent-type: text/plain'), false);
    return true;
	
}

/**
 * get all neccessary style sheets
 *
 * @param	$args['plugins']
 * @return	void
 */
function MyProfile_userapi_addStyleSheets($args) 
{
  	$plugins = $args['plugins'];
  	// load the plugin's standard style sheet
	foreach($plugins as $plugin) PageUtil::AddVar('stylesheet', ThemeUtil::getModuleStylesheet($plugin['loadname']));
	// also load all stylesheets of possible hooks
	// we'll do a check for every module and if it is hooked -> add the css sheet
    $mods = pnModGetUserMods();
    foreach ($mods as $mod) {
	  	if (pnModIsHooked($mod['name'],'MyProfile')) PageUtil::AddVar('stylesheet', ThemeUtil::getModuleStylesheet($mod['name']));
	}

}

/**
 * This function redirects to the profile management BEFORE a user can surf the page
 *
 * @return	redirection
 */
function MyProfile_userapi_checkForAccount()
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
		LogUtil::registerError(_MYPROFILEPLEASECREATEACCOUNTFIRST);
		return pnRedirect(pnModURL('MyProfile','user','main'));
		}
	}	
	return;
} 

/**
 * This function returns the profile of a user with identifier as array key
 * and the value as value
 *
 * To be used in other modules
 *
 * @param	$args['uid'] 	int
 * @param	$args['name']	string			optional, identifier to get just one user variable
 * @return	array
 */
function MyProfile_userapi_getUserVars($args) {
	$profile = MyProfile_userapi_getProfile($args);
	$identifier = $args['name'];
	foreach ($profile as $item) $res[$item['identifier']] = $item;
	if (isset($identifier)) return $res[$identifier];
	else return $res;
}

/**
 * get all birthdays for a day
 *
 * This function gets all users that celebrate their birthday today
 *
 * @param $args['datedatafield']				string		myprofile identifier for date
 * @param $args['restrictiondatafield']			string		myprofile identifier for restriction (opt)
 * @param $args['restrictiondatafieldvalue']	string		myprofile identifier for restriction vield value for true(opt)
 * @return array
 */
function MyProfile_userapi_getBirthdays($args)
{
    $datedatafield 				= $args['datedatafield'];
    $restrictiondatafield 		= $args['restrictiondatafield'];
    $restrictiondatafieldvalue 	= $args['restrictiondatafieldvalue'];
    
    // some checks
    if (!isset($datedatafield)) return null;
    if (
		isset($restrictiondatafield) && isset($restrictiondatafieldvalue) &&
		(strlen($restrictiondatafield)>0) && (strlen($restrictiondatafieldvalue))
		) {
	  	// construct where part for sql query
	  	$where = 'MyProfile_'.$restrictiondatafield.' = '.$restrictiondatafieldvalue.' AND ';
	}
	$date = "'%-".date("d-m",time())."'";
    $where.= 'MyProfile_'.$datedatafield.' LIKE '.$date;

	// This join information is the second join information so we have to use the prefix a. in the following where parts
	$joinInfo[] = array (	'join_table'          =>  'users',			// table for the join
							'join_field'          =>  'uname',			// field in the join table that should be in the result with
                         	'object_field_name'   =>  'uname',			// ...this name for the new column
                         	'compare_field_table' =>  'id',				// regular table column that should be equal to
                         	'compare_field_join'  =>  'uid');			// ...the table in join_table

    return DBUtil::selectExpandedObjectArray('myprofile',$joinInfo,$where,'',0,150);
}

/**
 * get latest registrations
 *
 * This function returns the latest registrations
 *
 * @param $args['numitems']	int	number of new members to fetch, 20 = default
 * @return array
 */
function MyProfile_userapi_getNewbies($args)
{
  	$numitems = $args['numitems'];
  	if (!isset($numitems) || (!($numitems > 0))) $numitems = 20;

	$joinInfo[] = array (	'join_table'          =>  'users',			// table for the join
							'join_field'          =>  'uname',			// field in the join table that should be in the result with
                         	'object_field_name'   =>  'uname',			// ...this name for the new column
                         	'compare_field_table' =>  'id',				// regular table column that should be equal to
                         	'compare_field_join'  =>  'uid');			// ...the table in join_table

    return DBUtil::selectExpandedObjectArray('myprofile',$joinInfo,$where,'id DESC',0,$numitems);
  	
}

/**
 * get online users
 *
 * This function returns users that are online
 *
 * @param $args['idletime']	int		idle time	(otherwise zikula default value is taken)
 * @param $args['orderby']	string	identifier(s)
 * @return array
 */
function MyProfile_userapi_getOnline($args)
{
  	$idletime = $args['idletime'];
  	if (!isset($idletime) || (!($idletime > 0))) $idletime = (pnConfigGetVar('secinactivemins') * 60);
  	$orderby = $args['orderby'];

	// join information to retrieve the users username also
	$joinInfo[] = array (	'join_table'          =>  'users',			// table for the join
							'join_field'          =>  'uname',			// field in the join table that should be in the result with
                         	'object_field_name'   =>  'uname',			// ...this name for the new column
                         	'compare_field_table' =>  'id',				// regular table column that should be equal to
                         	'compare_field_join'  =>  'uid');			// ...the table in join_table

	// join information because we need the join to the sessions table
	$joinInfo[] = array (	'join_table'          =>  'session_info',	// table for the join
							'join_field'          =>  'lastused',			// field in the join table that should be in the result with
                         	'object_field_name'   =>  'session_uid',	// ...this name for the new column
                         	'compare_field_table' =>  'id',				// regular table column that should be equal to
                         	'compare_field_join'  =>  'uid');			// ...the table in join_table

    $tables 		=& pnDBGetTables();
    $sess_column 	= &$tables['session_info_column'];
    $where = $sess_column['lastused']." > '".date("Y-m-d H:i:s",(time()-$idletime))."'";
    $res = DBUtil::selectExpandedObjectArray('myprofile',$joinInfo,$where,$orderby);
    // we just want every user once in the table (disctinct is not possible here or I am too stupid...)
    $in = array();
    $result = array();
    foreach ($res as $r) {
		$uid = $r['id'];
		if (!isset($in[$uid]) || ($in[$uid] != 1)) $result[] = $r;
		$in[$uid] = 1;
	}
    return $result;
}
?>