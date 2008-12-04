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
 * the main user function
 * 
 * @return       output       The main module page
 */
function MyProfile_user_main()
{
  	// load handler class
	Loader::requireOnce('modules/MyProfile/includes/classes/user/main.php');
    // Security check
    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_COMMENT)) return LogUtil::registerPermissionError();
	// Create output and call handler class
	$render = FormUtil::newpnForm('MyProfile');
	// Caching settings
    $render->caching = false;
    // Return the output
    return $render->pnFormExecute('myprofile_user_main.htm', new MyProfile_user_ProfileHandler());
}

/**
 * the search function
 * 
 * @return       output
 */
function MyProfile_user_search()
{
  	// load handler class
	Loader::requireOnce('modules/MyProfile/includes/classes/user/search.php');
    // Security check
    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_OVERVIEW)) return LogUtil::registerPermissionError();
	// Create output and assign data
	$render = FormUtil::newpnForm('MyProfile');
	// Caching settings
    $render->caching = false;
    // Return the output
    return $render->pnFormExecute('myprofile_user_search.htm', new MyProfile_user_SearchHandler());
}

/**
 * function to validate new email addresses
 * 
 * @param	$_GET['code']	string
 * @param	$_GET['uid']	user id
 * @return	output
 */
function MyProfile_user_validatemail()
{
  	// load handler class
	Loader::requireOnce('modules/MyProfile/includes/classes/user/validatemail.php');
	// Create output and assign data
	$render = FormUtil::newpnForm('MyProfile');
	// Caching settings
    $render->caching = false;
    // Return the output
    return $render->pnFormExecute('myprofile_user_validatemail.htm', new MyProfile_user_ValidateMailHandler());
}

/**
 * function to manage userlist that is allowed to view data declared as private
 * 
 * @return	output
 */
function MyProfile_user_confirmedusers()
{
  	// load handler class
	Loader::requireOnce('modules/MyProfile/includes/classes/user/confirmedusers.php');
    // Security check
    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_COMMENT)) return LogUtil::registerPermissionError();
    // check for delete action
    $delete = (int)FormUtil::getPassedValue('delete');
    if ($delete > 0) {
	  	if (!SecurityUtil::ConfirmAuthKey()) {
		    LogUtil::registerAuthIDError();
		   	return pnRedirect(pnModURL('MyProfile','user','confirmedusers'));
		}
	  	else {
	  		if (pnModAPIFunc('MyProfile','user','deleteConfirmedUser',array('confirmed_uid' => $delete))) {
			   	LogUtil::registerStatus(_MYPROFILEUSERDELETED);
			   	return pnRedirect(pnModURL('MyProfile','user','confirmedusers'));
			}
	  		else {
			    LogUtil::registerError(_MYPROFILEERRORDELETINGUSER);
			   	return pnRedirect(pnModURL('MyProfile','user','confirmedusers'));
			}			
		}
	}
	// Create output and assign data
	$render = FormUtil::newpnForm('MyProfile');
	// Caching settings
    $render->caching = false;
    // Return the output
    return $render->pnFormExecute('myprofile_user_confirmedusers.htm', new MyProfile_user_ConfirmedUsersHandler());
}

/**
 * This function loads the content of a tab
 *
 * @param	$_GET['modname']
 * @param	$_GET['uid']
 * @return	function's content
 */
function MyProfile_user_tab() {
	// get variables
  	$uid 			= (int)FormUtil::getPassedValue('uid');
  	$viewer_uid 	= pnUserGetVar('uid');
  	$modname 		= FormUtil::getPassedValue('modname');
  	// create output
  	$render = pnRender::getInstance('MyProfile');
	// go on now..
  	if (isset($modname) && pnModAvailable($modname)) {
	  	pnModLangLoad($modname);
	  	$output = pnModAPIFunc($modname,'myprofile','tab',array('uid'=>$uid));
	  	$ajax = (int)FormUtil::getPassedValue('ajax');
		if ($ajax == 1) {
			if (pnModGetVar('MyProfile','convertToUTF8') == 1) $output = DataUtil::convertToUTF8($output);
			echo $output;
			return true;
		}
		else {
			return $output;		
			return true;
		}
	}
	else return false;
}

/**
 * the user settings
 * 
 * @return       output       The main module page
 */
function MyProfile_user_settings()
{
  	// load handler class
	Loader::requireOnce('modules/MyProfile/includes/classes/user/settings.php');
    // Security check
    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_COMMENT)) return LogUtil::registerPermissionError();
	// Create output and assign data
	$render = FormUtil::newpnForm('MyProfile');
	// Caching settings
    $render->caching = false;
    // Return the output
    return $render->pnFormExecute('myprofile_user_settings.htm', new MyProfile_user_SettingsHandler());
}

/**
 * just a redirect to the display function to have the same function name
 * as the regular "Profile" module offers...
 */
function MyProfile_user_view()
{
  	return MyProfile_user_display();
}

/**
 * the main user function
 * 
 * @return       output       The main module page
 */
function MyProfile_user_display()
{
    // Security check
    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_OVERVIEW)) return LogUtil::registerPermissionError();

	// Add js		
	PageUtil::addVar('javascript','modules/MyProfile/pnjavascript/myprofile.js');
	
	// Create output and assign data
	$render 	= pnRender::getInstance('MyProfile');
	$uid		= FormUtil::getPassedValue('uid');
	$viewer_uid	= pnUserGetVar('uid');
	$uname		= FormUtil::getPassedValue('uname');

	// check for parameters and redirect to own profiel if there is no parameter
	if (!isset($uname) && !isset($uid) && pnUserLoggedIn()) {
		return pnRedirect(pnModURL('MyProfile','user','display',array('uid' => $viewer_uid)));
	}
	
	$uid = (int)$uid;

	// get Plugin
	$pluginname = FormUtil::getPassedValue('pluginname');
	if (!isset($pluginname)) $pluginname="MyProfile";

	// Caching settings
  	$render->cache_id = (int)pnUserLoggedIn().'-'.$uid.'-'.$pluginname;

	// redirect to the MyProfile display page with user id as parameter to acoid trouble with any mis-spelled usernames or special characters
	// but only if uid is not submitted.
	if (isset($uname)) {
		if (pnUserGetIDFromName($uname) > 1) {
			return pnRedirect(pnModURL('MyProfile','user','display',array('uid' => pnUserGetIDFromName($uname))));
		}
		else {
		  	// maybe the username has to be decoded due to some special characters...
		  	$last = FormUtil::getPassedValue('last');
		  	if (isset($last) && ($last == 1)) {
		  	  	// is the username utf8 encoded?
		  	  	$uname = utf8_decode($uname);
		  	  	if (pnUserGetIDFromName($uname) > 1) return pnRedirect(pnModURL('MyProfile','user','display',array('uid' => pnUserGetIDFromName($uname))));
				else return pnRedirect(pnModURL('MyProfile','user','display',array('uid' => -1)));
			}
		  	else {
		  	  	// perhaps there are some special html characters?
				return pnRedirect(pnModURL('MyProfile','user','display',array('uname' => html_entity_decode($uname), 'last' => 1)));
			}
		}
	}
	
	// We only reach this point if there is no uname parameter. Now we have to get the username for the profile
	// Guests are not allowed to have a profile page ;-)
	
	// get and assign online state of user
	$online = pnModAPIFunc('MyProfile','user','getOnline',array('uid' => $uid));
	if (is_array($online) && ($online[0]['id'] == $uid)) $render->assign('onlinestatus', 1);
	else $render->assign('onlinestatus', 0);

	// get profile
	$uname = pnUserGetVar('uname', $uid);
	if ($uid > 1) $profile = pnModAPIFunc('MyProfile','user','getProfile',array('uid'=>$uid, 'uname'=>$uname));
	if (	!isset($uname) 			||
			!(strlen($uname) > 0) 	||
			!($uid > 1) )	{
		// assign invalid user or user not found template
		$render = pnRender::getInstance('MyProfile');
		return $render->fetch('myprofile_user_display_invalid.htm');
	}
	
	$render->assign('profile',$profile);

	// assign user name and uid
	if (isset($uid) && ($uid > 1)) $uname = pnUserGetVar('uname',$uid);
	else $name = pnUserGetIDFromName($uid);
	$render->assign('uname',		$uname);
	$render->assign('uid',			$uid);
	$render->assign('viewer_uid',	$viewer_uid);
	$render->assign('plugin_noajax',pnModGetVar('MyProfile','plugin_noajax'));
	$render->assign('homelink',		pnGetBaseURL().pnModURL('MyProfile','user','tab',array('uid'=>$uid,'ajax'=>1,'modname'=>'MyProfile')));
	// ContactList plugin
	$render->assign('contactlistavailable',	pnModAvailable('ContactList'));
	if (pnModAvailable('ContactList')) $render->assign('contactlist_nopublicbuddylist',	pnModGetVar('ContactList','nopublicbuddylist'));
	
	$render->assign('pluginname',$pluginname);
	if (($pluginname != "MyProfile") && pnModAvailable($pluginname)) pnModLangLoad($pluginname);

    // get the plugins
    $plugins = pnModAPIFunc('MyProfile','admin','getPlugins',array('uid' => $uid));

    $render->assign('plugins',$plugins);
    // execute all "onLoad"-Funktions and sort out the invisible plugins
    pnModAPIFunc('MyMap','myprofile','onLoad');
    foreach ($plugins as $plugin) {
	  	pnModAPIFunc($plugin['loadname'],'myprofile','onLoad');
	}
	
	// and all necessary stylesheets
	pnModAPIFunc('MyProfile','user','addStyleSheets',array('plugins' => $plugins));	

	// let's combine myprofile with clickedme and call clickedme whenever 
	// anything (even a plugin) of a user was called
	if (($uid != $viewer_uid) && (pnModAvailable('ClickedMe'))) pnModAPIFunc('ClickedMe','user','addClick',array('clicked_uid' => $uid));

	// get the plugin output
	$output = pnModAPIFunc($pluginname,'MyProfile','tab',array('uid' => $uid, 'uname' => $uname));
	$render->assign('content',$output);
	
	// Return the output
    return $render->fetch('myprofile_user_display.htm');
}
?>