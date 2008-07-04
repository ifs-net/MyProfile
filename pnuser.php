<?php

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
	$render->assign('notabs',pnModGetVar('MyProfile','notabs'));
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
  	$render = pnRender::getInstance('MyProfile');
  	$uid = (int)FormUtil::getPassedValue('uid');
  	$modname = FormUtil::getPassedValue('modname');
  	if (isset($modname) && pnModAvailable($modname)) {
	  	pnModLangLoad($modname);
	  	$output = pnModAPIFunc($modname,'myprofile','tab',array('uid'=>$uid));
		if ((int)FormUtil::getPassedValue('ajax',0,GET)==1) echo DataUtil::convertToUTF8($output);
		else echo $output;
		return true;
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
	$render = pnRender::getInstance('MyProfile');
	$uid	= (int)FormUtil::getPassedValue('uid');
	$uname	= FormUtil::getPassedValue('uname');
	if (isset($uname) && (pnUserGetIDFromName($uname) > 1)) return pnRedirect(pnModURL('MyProfile','user','display',array('uid' => pnUserGetIDFromName($uname))));
	$render->assign('profile',pnModAPIFunc('MyProfile','user','getProfile',array('uid'=>$uid, 'uname'=>$uname)));

	// assign user name and uid
	if (isset($uid) && ($uid > 1)) $uname = pnUserGetVar('uname',$uid);
	else $name = pnUserGetIDFromName($uid);
	$render->assign('uname',	$uname);
	$render->assign('uid',		$uid);
	$render->assign('homelink',	pnModURL('MyProfile','user','tab',array('uid'=>$uid,'ajax'=>1,'modname'=>'MyProfile')));
	
	$pluginname = FormUtil::getPassedValue('pluginname');
	if (!isset($pluginname)) $pluginname="MyProfile";
	$render->assign('pluginname',$pluginname);
	if (($pluginname != "MyProfile") && pnModAvailable($pluginname)) pnModLangLoad($pluginname);

    // get the plugins
    $plugins = pnModAPIFunc('MyProfile','admin','getPlugins');

    $render->assign('plugins',$plugins);
    // execute all "onLoad"-Funktions and sort out the invisible plugins
    pnModAPIFunc('MyMap','myprofile','onLoad');
    foreach ($plugins as $plugin) {
	  	pnModAPIFunc($plugin['loadname'],'myprofile','onLoad');
	}
	
	// and all necessary stylesheets
	pnModAPIFunc('MyProfile','user','addStyleSheets',array('plugins' => $plugins));	
	
	// Return the output
    return $render->fetch('myprofile_user_display.htm');
}
?>