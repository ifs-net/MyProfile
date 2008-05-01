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
  	$data = DBUtil::selectObjectByID('myprofile_settings',(int)$args['uid']);
  	if (!(count($data)>0)) {
  	  	$data = array(	'id'			=> $args['uid'],
						'nocomments'	=> '0'		);
	    DBUtil::insertObject($data,'myprofile_settings',true);
	}
	return $data;
}

/**
 * store a new email address for a user
 *
 * @param	$args['uid']	int
 * @param	$args['email']	string
 * @return	boolean
 */
function MyProfile_userapi_updateEmail($args)
{
  	if (!isset($args['email'])) {
	    LogUtil::registerError(_MYPROFILENOEMAILGIVEN);
	    return false;
	}
	// todo
	return false;
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