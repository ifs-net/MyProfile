<?php
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
	$render = FormUtil::newpnForm('MyProfile');
	$render->assign('fields',pnModAPIFunc('MyProfile','admin','getFields'));
	$render->assign('separators',pnModAPIFunc('MyProfile','admin','countSeparators'));
	$render->assign('uid',pnUserGetVar('uid'));
	$render->assign('notabs',pnModGetVar('MyProfile','notabs'));
	PageUtil::addVar('javascript','modules/MyProfile/pnjavascript/myprofile.js');   
    // Return the output
    return $render->pnFormExecute('myprofile_user_main.htm', new MyProfile_user_ProfileHandler());
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
		if ((int)FormUtil::getPassedValue('ajax')==1) {
//	  	  	echo DataUtil::convertToUTF8($output);
			echo $output;
		  	return true;
		}
		else {
		  	echo $output;
		  	return;
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

    // Return the output
    return $render->pnFormExecute('myprofile_user_settings.htm', new MyProfile_user_SettingsHandler());
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




/* ************************************ pnForm handler ********************************* */
class MyProfile_user_ProfileHandler
{
    var $id;
    function initialize(&$render)
    {	    
      	// Admins should be able to modify user's profile data
      	$load_uid = (int) FormUtil::getPassedValue('load_uid');
      	if (isset($load_uid) && (($load_uid) > 0) && (SecurityUtil::checkPermission('MyProfile::', '.$load_uid', ACCESS_ADMIN))) $this->id = $load_uid;
		else $this->id = (int)pnUserGetVar('uid');
		if ($this->id > 0) {
			$data = DBUtil::selectObjectByID('myprofile', $this->id);
			if (!isset($data)) unset($this->id);
			else {
				$render->assign($data);
				$this->load_uid=$load_uid;
			}
		}
		return true;
    }
    function handleCommand(&$render, &$args)
    {
		if ($args['commandName']=='update') {
		    // Security check 
		    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_COMMENT)) return LogUtil::registerPermissionError();

			// get the pnForm data and do a validation check
		    $obj = $render->pnFormGetValues();		    
		    if (!$render->pnFormIsValid()) return false;
			$obj['timestamp'] = date("Y-m-d",time());
			
		    if ($this->id > 0) {	// update an existing profile
		      	$obj['id']=$this->id;
				$result = DBUtil::updateObject($obj, 'myprofile');
		      	if ($result) LogUtil::registerStatus(_MYPROFILEFIELDUPDATED);
		      	else LogUtil::registerError(_MYPROFILEADDPROFILEFAILED);
			}
			else {					// create a new profile
				// if the user is created by the user himself we need his uid
				// otherwise we have to work with the load_uid value
				$load_uid = (int)FormUtil::getPassedValue('load_uid');
				if (($load_uid > 0) && (!pnModAPIFunc('MyProfile','user','getProfile',array('uid'=>$load_uid)) && SecurityUtil::checkPermission('MyProfile::','::', ACCESS_ADMIN)) ) $obj['id'] = $load_uid;
				else $obj['id'] = pnUserGetVar('uid');
			  	$this->id = $obj['id'];
			  	$thid->load_uid = $obj['id'];
				DBUtil::insertObject($obj, 'myprofile',true);
				LogUtil::registerStatus(_MYPROFILECREATED);
			}
			return pnRedirect(pnModURL('MyProfile','user','main',array('load_uid'=>$this->load_uid)));
		}
		return true;
    }
}

class MyProfile_user_SettingsHandler
{
    var $id;
    function initialize(&$render)
    {	    
      	// Admins should be able to modify user's profile data
		$this->id = (int)pnUserGetVar('uid');
		if ($this->id > 0) {
			// get settings
			$data = pnModAPIFunc('MyProfile','user','getSettings',array('uid'=>$this->id));
			$render->assign($data);
		}
		return true;
    }
    function handleCommand(&$render, &$args)
    {
		if ($args['commandName']=='update') {
		    // Security check 
		    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_COMMENT)) return LogUtil::registerPermissionError();

			// get the pnForm data and do a validation check
		    $obj = $render->pnFormGetValues();		    
		    if (!$render->pnFormIsValid()) return false;

	      	$obj['id']=$this->id;
	      	$result = DBUtil::updateObject($obj, 'myprofile_settings');
	      	if ($result) LogUtil::registerStatus(_MYPROFILESETTINGSUPDATED);

	      	// should the password be updated?
	      	if (isset($obj['1pass']) && ($obj['2pass'] == $obj['2pass'])) {
	      	  	if (strlen($obj['1pass'])>3) {
					 pnUserSetPassword($obj['1pass']); 
					 LogUtil::registerStatus(_MYPROFILEPASSWORDCHANGED);
				}
				else if (strlen($obj['1pass'])>0) LogUtil::registerError(_MYPROFILEPWDTOOSHORT);
			    
			}
			else if ((strlen($obj['1pass'])>0) || (strlen($obj['2pass'])>0)) {
			  	LogUtil::registerError(_MYPROFILEPASSWORDSINCORRECT);
			}
			
			// should the emailadress be changed?
			if (pnUserGetVar('email') != $obj['users_email']) {
			  	if (pnModGetVar('MyProfile','verifyemailaddress') == '1') LogUtil::registerStatus(_MYPROFILEMAILCHANGEREQUEST);
			  	else {
				    if (pnModAPIFunc('MyProfile','user','updateEmail',array('uid'=>pnUserGetVar('uid'),'email'=>$obj['users_email']))) LogUtil::registerStatus(_MYPROFILEEMAILCHANGED);
				}
			}
			return pnRedirect(pnModURL('MyProfile','user','settings'));
		}
		return true;
    }
}
?>