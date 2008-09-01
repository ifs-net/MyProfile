<?php
/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schießl
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
 

Loader::requireOnce('modules/MyProfile/includes/userhandlers.php');

/**
 * the main user function
 * 
 * @return       output       The main module page
 */
function MyProfile_user_main()
{
    // Security check
    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_COMMENT)) return LogUtil::registerPermissionError();
	
	// Create output and assign data
	$uid 		= pnUserGetVar('uid');
	$settings 	= pnModAPIFunc('MyProfile','user','getSettings',array('uid' => $uid));
	$render = FormUtil::newpnForm('MyProfile');
	$render->assign('fields',pnModAPIFunc('MyProfile','admin','getFields'));
	$render->assign('separators',pnModAPIFunc('MyProfile','admin','countSeparators'));
	$render->assign('uid',$uid);
	$notabs = pnModGetVar('MyProfile','notabs');
	// if the user does not have a valid (incomplete / outdated) profile we should better
	// not use the tab-mode because the user might not see every field and only update / complete
	// the first tab
	if (!pnModAPIFunc('MyProfile','user','hasValidProfile')) $notabs = 1;
	$render->assign('notabs',$notabs);
	PageUtil::addVar('javascript','modules/MyProfile/pnjavascript/myprofile.js');   
    // Return the output
    return $render->pnFormExecute('myprofile_user_main.htm', new MyProfile_user_ProfileHandler());
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
	// Create output and assign data
	$render = FormUtil::newpnForm('MyProfile');
    // Return the output
    return $render->pnFormExecute('myprofile_user_validatemail.htm', new MyProfile_user_ValidateMailHandler());
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
		  	echo DataUtil::convertToUTF8($output);
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
    // Security check
    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_COMMENT)) return LogUtil::registerPermissionError();
		
	// Create output and assign data
	$render = FormUtil::newpnForm('MyProfile');
	
	// should just password or email management be shown?
	$mode = strtolower(FormUtil::getPassedValue('mode'));
	$render->assign('mode',$mode);
	$render->assign('noverification',pnModGetVar('MyProfile','noverification'));

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
	$uid		= (int)FormUtil::getPassedValue('uid');
	$viewer_uid	= pnUserGetVar('uid');
	$uname		= FormUtil::getPassedValue('uname');
	if (isset($uname) && (pnUserGetIDFromName($uname) > 1)) return pnRedirect(pnModURL('MyProfile','user','display',array('uid' => pnUserGetIDFromName($uname))));
	$render->assign('profile',pnModAPIFunc('MyProfile','user','getProfile',array('uid'=>$uid, 'uname'=>$uname)));

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
	
	$pluginname = FormUtil::getPassedValue('pluginname');
	if (!isset($pluginname)) $pluginname="MyProfile";
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