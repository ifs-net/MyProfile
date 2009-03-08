<?php
/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schießl
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

// load myprofile library 
Loader::requireOnce('modules/MyProfile/includes/common.php');

/**
 * the main administration function
 *
 * @return       output       The main module admin page.
 */
function MyProfile_admin_main()
{    
    // Security check 
    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_ADMIN)) return LogUtil::registerPermissionError();
    // Create output
    $render = pnRender::getInstance('MyProfile');
    // Return output
    return $render->fetch('myprofile_admin_main.htm');
}

/**
 * display interesting module information
 *
 * @return       output
 */
function MyProfile_admin_information()
{    
    // Security check 
    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_ADMIN)) return LogUtil::registerPermissionError();
    // Create output
    $render = pnRender::getInstance('MyProfile');
    // get information
    $info = mp_getInformation();
	$max = DBUtil::selectObjectCount('users');
	$render->assign('max',$max);
    PageUtil::addVar('javascript','http://static.simile.mit.edu/timeplot/api/1.0/timeplot-api.js');
	$render->assign($info);
    // Return output
    return $render->fetch('myprofile_admin_information.htm');
}

/**
 * display interesting module information
 *
 * @return       output
 */
function MyProfile_admin_getInformationRawData()
{    
	// Security Check
    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_ADMIN)) return LogUtil::registerPermissionError();
  	// rendering instance
  	$render = pnRender::getInstance('MyProfile');
	// get Raw information data
	$info = mp_getRawInformation();
	$render->assign('info',$info);
    $output = $render->fetch('myprofile_admin_information_rawdata.htm');
    print $output;
    return true;
}

/**
 * the main administration function
 *
 * @return       output
 */
function MyProfile_admin_mainsettings()
{    
  	// load handler class
	Loader::requireOnce('modules/MyProfile/includes/classes/admin/settings.php');
    // Security check 
    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_ADMIN)) return LogUtil::registerPermissionError();
    // Create output
    $render = FormUtil::newpnForm('MyProfile');
    // Return output
    return $render->pnFormExecute('myprofile_admin_mainsettings.htm', new myProfile_admin_settingsHandler());
}

/**
 * consistence check for the myprofile database
 *
 * @return       output      
 */
function MyProfile_admin_findorphans()
{    
    // Security check 
    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_ADMIN)) return LogUtil::registerPermissionError();
    // rebuild table definition. many errors might be avoidable by this
    pnModAPIFunc('MyProfile','admin','updateTableDefinition');
    // Create output and assign some data
    $render = pnRender::getInstance('MyProfile');
    // the clean-up command will be handled in the getOrphans function
    $render->assign('orphans',	pnModAPIFunc('MyProfile','admin','getOrphans'));
    $render->assign('authid',	SecurityUtil::generateAuthKey());
    // Return output
    return $render->fetch('myprofile_admin_findorphans.htm');
}

/**
 * plugin settings
 *
 * @return       output       
 */
function MyProfile_admin_plugins()
{    
    // Security check 
    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_ADMIN)) return LogUtil::registerPermissionError();
    // Create output
    $render = pnRender::getInstance('MyProfile');
    // get the plugins
    $render->assign('plugins',pnModAPIFunc('MyProfile','admin','getPlugins'));
    // Return output
    return $render->fetch('myprofile_admin_plugins.htm');
}

/**
 * import functions
 *
 * @return       output       The main module admin page.
 */
function MyProfile_admin_import()
{    
    // Security check 
    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_ADMIN)) return LogUtil::registerPermissionError();
    
    // Reset step counter?
    $reset = FormUtil::getPassedValue('action',null,'GET');
    if (isset($reset) && ($reset == 'reset')) {
	  	pnModDelVar('MyProfile','pnProfileStep');
	  	LogUtil::registerStatus(_MYPROFILESTEPSRESETDONE);
	}

	// check if config file is writable
	if (!pnModAPIFunc('MyProfile','admin','checkConfigFile')) {
	  	$render = pnRender::getInstance('MyProfile');
	  	$render->assign('id',(int)FormUtil::getPassedValue('id'));
	  	return $render->fetch('myprofile_admin_configfailure.htm');
	}

    // Check for import call
    $source = FormUtil::GetPassedValue('source',null,'GET');
    if (isset($source) && (($source == 'pnProfile') || ($source == 'Profile'))) {
		if (!SecurityUtil::confirmAuthKey()) LogUtil::registerAuthIDError();
		else pnModAPIFunc('MyProfile','admin','import',array('source'=>$source));
	}
    // Create output
    $render = pnRender::getInstance('MyProfile');
    // Assign data
    $pnProfileStep = pnModGetVar('MyProfile','pnProfileStep');
    if (!($pnProfileStep) || !isset($pnProfileStep) || (!($pnProfileStep > 0) && !($pnProfileStep < 6))) {
	  	$pnProfileStep=1;
	  	pnModSetVar('MyProfile','pnProfileStep',1);
	}
    $render->assign('pnProfileStep',		$pnProfileStep);
    $render->assign('pnprofileavailable',	pnModAvailable('pnProfile'));
    $render->assign('profileavailable',		pnModAvailable('Profile'));
    $render->assign('authid',				SecurityUtil::generateAuthKey());
    // Return output
    return $render->fetch('myprofile_admin_import.htm');
}

/**
 * ajax call to store the new field-list
 *
 * @return	output
 */
function MyProfile_admin_ajaxSaveList()
{
    // Security check
    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_ADMIN)) return LogUtil::registerPermissionError();
	// store the new order    
	pnModAPIFunc('MyProfile','admin','ajaxSaveList',array('list'=> FormUtil::getPassedValue('myprofile_list')));
    return true;
}

/**
 * ajax call to store the new field-list
 *
 * @return	output
 */
function MyProfile_admin_saveList()
{
	$order = unserialize(FormUtil::getPassedValue('order'));
    // Security check
    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_ADMIN)) return LogUtil::registerPermissionError();
 	// store the new order    
	pnModAPIFunc('MyProfile','admin','ajaxSaveList',array('list'=>$order));
    LogUtil::registerStatus(_MYPROFILEELEMENTMOVED);
    return pnRedirect(pnModURL('MyProfile','admin','fields'));
}

/**
 * edit a user's profile data as an admininstrator
 *
 * @return       redirection
 */
function MyProfile_admin_editProfile()
{    
	$uid 		= FormUtil::getPassedValue('uid');
	$uname 		= FormUtil::getPassedValue('uname');
	$email 		= FormUtil::getPassedValue('email');
	$trans_uid 	= pnUserGetIDFromName($uname);
	// inclusion to get users via email
	if (strlen($email) > 3) {
		$tables 		= pnDBGetTables();
		$users 			= $tables['users'];
		$users_column 	= $tables['users_column'];
		$where = "WHERE ".$users_column['email']." like '".$email."'";
		$res = DBUtil::selectObjectArray('users',$where);
		if (count($res) > 1) {
		  	// more than one user was found
		  	$msg = _MYPROFILEMORETHANONEUSERFOUND.': ';
		  	foreach($res as $r) $msg.= $r['uname'].', ';
		  	$msg.= _MYPROFILECHOOSEONEUSER;
		  	LogUtil::registerError($msg);
		}
		else if (count($res) == 1) {
		  	// one user found. redirect to management page
		  	$uid = $res['id'];
		  	return pnRedirect(pnModURL('MyProfile','user','main',array('load_uid' => $uid)));
		}
		else {
		  	// email address not found
			LogUtil::registerError(_MYPROFILEEMAILNOTEXISTENT);
		}
	}
	else if (isset($uname) && ($trans_uid > 0)) {
	  	return pnRedirect(pnModURL('MyProfile','user','main',array('load_uid'=>$trans_uid)));
	}
	else if (isset($uid) && ($uid > 0)) {
	  	return pnRedirect(pnModURL('MyProfile','user','main',array('load_uid'=>$uid)));
	}
	else {
	  	LogUtil::registerError(_MYPROFILEUNOTFOUND);
	}
	return pnRedirect(pnModUrl('MyProfile','admin','main'));
}

/**
 * the main administration function
 *
 * @return       output       The main module admin page.
 */
function MyProfile_admin_update()
{    
    // Security check 
    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_ADMIN)) return LogUtil::registerPermissionError();
    $changetable = FormUtil::getPassedValue('changetable');
    if ($changetable == 1) {
	  	DBUtil::ChangeTable('myprofile');
	  	return pnRedirect(pnModURL('MyProfile','admin','fields'));
	}
    else {
		pnModAPIFunc('MyProfile','admin','updateTableDefinition');
		return pnRedirect(pnModURL('MyProfile','admin','update',array('changetable'=>1)));
	}
}

/**
 * the main administration function
 *
 * @return       output       The main module admin page.
 */
function MyProfile_admin_fields()
{
    // Security check 
    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_ADMIN)) return LogUtil::registerPermissionError();
    // Create output object
    $render = pnRender::getInstance('MyProfile');
   	// add the data to the template
   	$fields = pnModAPIFunc('MyProfile','admin','addOrderLinkToFields',array('fields'=>pnModAPIFunc('MyProfile','admin','getFields')));
   	// if there are no fields defined we can automatically 
	// forward the user to the "add field" page
	if (count($fields)==0) return pnRedirect(pnModURL('MyProfile','admin','addField'));
   	$render->assign('fields',$fields);
	$render->assign('ajaxurl',pnGetBaseUrl().pnModURL('MyProfile','admin','ajaxSaveList'));
    // Return the output that has been generated by this function
    return $render->fetch('myprofile_admin_fields.htm');
}

/**
 * add new fields
 *
 * @return       output 
 */
function MyProfile_admin_addField()
{
    // Security check 
    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_ADMIN)) return LogUtil::registerPermissionError();
    
	// some config file checks
	if (!pnModAPIFunc('MyProfile','admin','checkConfigFile')) {
	  	$render = pnRender::getInstance('MyProfile');
	  	$render->assign('id',(int)FormUtil::getPassedValue('id'));
	  	return $render->fetch('myprofile_admin_configfailure.htm');
	}

  	// load handler class
	Loader::requireOnce('modules/MyProfile/includes/classes/admin/addfield.php');
    // Create output
    $render = FormUtil::newpnForm('MyProfile');

    PageUtil::addVar('javascript','modules/MyProfile/pnjavascript/myprofile.js');
    
    // Return the output
    return $render->pnFormExecute('myprofile_admin_addfield.htm', new myProfile_admin_addFieldHandler());
}

/**
 * invalid email address management
 *
 * @return       output 
 */
function MyProfile_admin_invalidemail()
{
    // Security check 
    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_ADMIN)) return LogUtil::registerPermissionError();
    
  	// load handler class
	Loader::requireOnce('modules/MyProfile/includes/classes/admin/invalidemail.php');
    // Create output
    $render = FormUtil::newpnForm('MyProfile');
    
    // Return the output
    return $render->pnFormExecute('myprofile_admin_invalidemail.htm', new myProfile_admin_invalidemailHandler());
}
?>