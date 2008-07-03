<?php
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
		if (($field['public_status'] > $mystatus) && ($field['value']!="")) $field['value']=_MYPROFILENOPERMISSION;
		if (($field['active'] == '1') && ($field['shown'] == '1')) $profile[]=$field;
	}
	return $profile;
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
 * @param	$args['data']		myprofile object
 * @return	boolean
 */
function MyProfile_userapi_storeAsAttributes($args)
{
  	$obj	= $args['data'];
  	if (!isset($obj) || (!($obj['id'] > 1))) return false;
	// get user and attributes
    $user = DBUtil::selectObjectByID('users', $obj['id'], 'uid', null, null, null, false);
    if (!is_array($user)) return false; // no user data? 
	$user['__ATTRIBUTES__']['myprofile'] = serialize($obj);
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
 * get al neccessary style sheets
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
?>