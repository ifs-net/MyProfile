<?php
/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schie�l
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
				// extract coordinates if there are some
				$fields = pnModAPIFunc('MyProfile','admin','getFields');
				$resultfields = array();
				foreach ($fields as $field) if ($field['fieldtype'] == 'COORD') $resultfields[] = $field;
				foreach ($resultfields as $field) {
				  	$coord = unserialize($data[$field['identifier']]);
				  	$lat = $field['identifier'].'_lat';
				  	$lng = $field['identifier'].'_lng';
				    $data[$lat] = $coord['lat'];
				    $data[$lng] = $coord['lng'];
				    $data[$field['identifier']] = $coord;
				    // for easier access we also store coordinates in an exta array with key = field identifier
					$data['coords'][$field['identifier']] = $coord;
				}
				$render->assign($data);
				$this->load_uid=$load_uid;
			}
		}
		$render->assign('mymapavailable',pnModAvailable('MyMap'));
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
			
			// is there a coordinate?
			$fields = pnModAPIFunc('MyProfile','admin','getfields');
			foreach ($fields as $field) {
			  	if ($field['fieldtype'] == 'COORD') {
			  	  	$identifier = $field['identifier'];
				    $lat = $identifier.'_lat';
				    $lng = $identifier.'_lng';
				    if (($obj[$lng] == '') || ($obj[$lat] == '')) $obj[$identifier] = '';
				    else $obj[$identifier] = array(
				    		'lng' => str_replace(',','.',$obj[$lng]),
				    		'lat' => str_replace(',','.',$obj[$lat])
						);
					unset($obj[$lat]);
					unset($obj[$lng]);
					$obj[$identifier] = serialize($obj[$identifier]);
				}
			}
			
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
			
			$individualtemplates = (int)pnModGetVar('MyProfile','individualtemplates');
			if (($individualtemplates == 1) && (pnModAPIFunc('MyProfile','user','individualTemplateAllowed',array('uid' => $this->id)))) $render->assign('individualtemplates',1);
			$render->assign($data);
			// individual permission settings
			$render->assign('individualpermissions',	pnModGetVar('MyProfile','individualpermissions'));
			$items_individualpermissions = array (
					array('text' => _MYPROFILEALL, 		'value' => 0),
					array('text' => _MYPROFILEMEMBERS, 	'value' => 1)
				);
			if (pnModAvailable('ContactList')) $items_individualpermissions[] = array('text' => _MYPROFILEBUDDIES, 	'value' => 2);
			$render->assign('items_individualpermissions', $items_individualpermissions);
			// are there custom settings we should take care of?
			$fields = pnModAPIFunc('MyProfile','admin','getFields');
			$customfields = false;
			foreach ($fields as $field) {
			  	if ($field['public_status'] == 9) $customfields = true;
			}
			if ($customfields) {
				$contactlistavailable = pnModAvailable('ContactList');
				$items_customfields[] = array('text' => _MYPROFILEALL, 'value' => 0);
				$items_customfields[] = array('text' => _MYPROFILEMEMBERS, 'value' => 1);
				if ($contactlistavailable) $items_customfields[] = array('text' => _MYPROFILEBUDDIES, 'value' => 2);
				$items_customfields[] = array('text' => _MYPROFILELISTEDUSERSONLY, 'value' => 3);
				$render->assign('items_customfields', $items_customfields);
				// assign user's value
				$render->assign('customsettings',	$data['customsettings']);
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

			// if individualtemplate is on and template is submitted we have to validate for mandatory fields
			$individualtemplates = (int)pnModGetVar('MyProfile','individualtemplates');
			if (($individualtemplates == 1) && isset($obj['individualtemplate']) && ($obj['individualtemplate'] != "")) {
				if (!pnModAPIFunc('MyProfile','admin','validateIndividualTemplate',array('template' => $obj['individualtemplate']))) {
					LogUtil::registerError(_MYPROFILETEMPLATEINCLUDEMANDATORY);
					return false;
				}
			}

	      	$obj['id']=$this->id;
			$result = pnModAPIFunc('MyProfile','user','setSettings',array(
					'uid'					=> $obj['id'],
					'nocomments' 			=> $obj['nocomments'],
					'individualpermission' 	=> $obj['individualpermission'],
					'individualtemplate' 	=> $obj['individualtemplate'],
					'customsettings'	 	=> $obj['customsettings']
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

class MyProfile_user_ConfirmedUsersHandler
{
	var $uid;
	function initialize(&$render)
	{	    
	  	// Admins should be able to modify user's profile data
		$users = pnModAPIFunc('MyProfile','user','getCustomFieldList',array(
			'uid' 			=> pnUserGetVar('uid'),
			'excludeowner' 	=> 1));
		$render->assign('users',	$users);
		$render->assign('authid',	SecurityUtil::generateAuthKey());
		return true;
    }
	function handleCommand(&$render, &$args)
	{
		if ($args['commandName']=='update') {
			// get the pnForm data and do a validation check
		    $obj = $render->pnFormGetValues();		    
		    if (!$render->pnFormIsValid()) return false;
			
			// check username
			$uid = (int)pnUserGetVar('uid');
			$confirmed_uid = (int)pnUserGetIDFromName($obj['uname']);
			if (!($confirmed_uid > 1)) {
			  	LogUtil::registerError(_MYPROFILEUSERNOTFOUND);
			  	return false;
			}
			else if ($uid == $confirmed_uid) {
			  	LogUtil::registerError(_MYPROFILEDONOTADDYOURSELF);
			  	return false;
			}
			else if (in_array($confirmed_uid,pnModAPIFunc('MyProfile','user','getCustomFieldList',array('uid' => $uid)))) {
			  	LogUtil::registerError(_MYPROFILEUSERALREADYADDED);
			  	return false;
			}
			else {
			  	$obj = array(	'uid'			=> $uid,
				  				'confirmed_uid'	=> $confirmed_uid);
				prayer($obj);
			  	if (!DBUtil::insertObject($obj,'myprofile_confirmedusers')) {
				  	LogUtil::registerError(_MYPROFILEUSERADDERROR);
				  	return false;
				} 
			}
			LogUtil::registerStatus(_MYPROFILEUSERADDED);
			return pnRedirect(pnModURL('MyProfile','user','confirmedusers'));
		}
		return true;
    }
}
?>