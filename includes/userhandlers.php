<?php
/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schießl
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
 
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
			
				// update user's attributes if neccesarry
				if (!pnModAPIFunc('MyProfile','user','storeAsAttributes',array('data' => $obj))) LogUtil::registerError(_MYPROFILEATTRIBUTESTOREERROR);
				
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

				// update user's attributes if neccesarry
				if (!pnModAPIFunc('MyProfile','user','storeAsAttributes',array('data' => $obj))) LogUtil::registerError(_MYPROFILEATTRIBUTESTOREERROR);

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
			// individual permission settings
			$render->assign('individualpermissions',	pnModGetVar('MyProfile','individualpermissions'));
			$items_individualpermissions = array (
					array('text' => _MYPROFILEALL, 		'value' => 0),
					array('text' => _MYPROFILEMEMBERS, 	'value' => 1)
				);
			if (pnModAvailable('ContactList')) $items_individualpermissions[] = array('text' => _MYPROFILEBUDDIES, 	'value' => 2);
			$render->assign('items_individualpermissions', $items_individualpermissions);
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
			$result = pnModAPIFunc('MyProfile','user','setSettings',array(
					'uid'					=> $obj['id'],
					'nocomments' 			=> $obj['nocomments'],
					'individualpermission' 	=> $obj['individualpermission']
					)
				);
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
			if (($obj['users_email'] != '') && (pnUserGetVar('email') != $obj['users_email'])){
			  	if (pnModGetVar('MyProfile','noverification') == '1') {	// change without any verification
				    if (pnUserSetVar('email',$obj['users_email'])) LogUtil::registerStatus(_MYPROFILEEMAILCHANGED);
				    else LogUtil::registerStatus(_MYPROFILEEMAILCHANGEERROR);
				}
			  	else {
			  	  	// generate verification code etc.
			  	  	if (pnModAPIFunc('MyProfile','user','generateVerificationCode',array('email' => $obj['users_email']))) LogUtil::registerStatus(_MYPROFILEMAILCHANGEREQUEST);
			  	  	else LogUtil::registerStatus(_MYPROFILEMAILCHANGEREQUESTERROR);
				}
			}
			return pnRedirect(pnModURL('MyProfile','user','settings'));
		}
		return true;
    }
}

class MyProfile_user_ValidateMailHandler
{
	var $uid;
	function initialize(&$render)
	{	    
	  	// Admins should be able to modify user's profile data
	  	$uid = FormUtil::getPassedValue('uid',0,'GETPOST');
	  	$code = FormUtil::getPassedValue('code','','GETPOST');
	  	if (!($uid > 0)) $this->id = (int)pnUserGetVar('uid');
	  	else $this->uid = $uid;
		if ($this->uid > 0) {
			// get settings
			$render->assign('uid',	$this->uid);
			$render->assign('code',	$code);
			$data = pnModAPIFunc('MyProfile','user','getSettings',array('uid'=>$this->uid));
			$render->assign($data);
		}
		return true;
    }
	function handleCommand(&$render, &$args)
	{
		if ($args['commandName']=='update') {
			// get the pnForm data and do a validation check
		    $obj = $render->pnFormGetValues();		    
		    if (!$render->pnFormIsValid()) return false;

			// get validation code
			$settings = pnModAPIFunc('MyProfile','user','getSettings',array('uid' => (int)$obj['uid']));
			// check if valid
			$code = $settings['validationcode'];
			if ($code['expire_date'] >= time()) {	// code is valid (date check)
			  	if ($obj['code'] == $code['code']) {// code is correct
				    if (pnUserSetVar('email',$code['email'])) LogUtil::registerStatus(_MYPROFILEEMAILCHANGED);
				    else return LogUtil::registerError(_MYPROFILEEMAILCHANGEERROR);
				}
				else return LogUtil::registerError(_MYPROFILEINCORRECTCODE.' code: '.$code['code'].' entered '.$obj['code']);
			}
			else return LogUtil::registerError(_MYPROFILEINVALIDCODE);
			// now we have to delete the old validation code from the user's attributes
			$uid = $obj['uid'];
		    $user = DBUtil::selectObjectByID('users', $uid, 'uid', null, null, null, false);
			unset($user['__ATTRIBUTES__']['myprofile_validationcode']);
			// store attributes
			DBUtil::updateObject($user, 'users', '', 'uid');			
			return pnRedirect(pnModURL('MyProfile','user','settings'));
		}
		return true;
    }
}
?>