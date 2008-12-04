<?php
/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schießl
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
 
class MyProfile_user_SettingsHandler
{
	var $id;
	function initialize(&$render)
	{	    
		// fields needed for individual templating
		$individualtemplates = (int)pnModGetVar('MyProfile','individualtemplates');
		if ($individualtemplates == 1) {
			$fields = pnModAPIFunc('MyProfile','admin','getIndividualTemplateFields');
			$render->assign('fields', $fields);
		}
		
		// should just password or email management be shown?
		$mode = strtolower(FormUtil::getPassedValue('mode'));
		$render->assign('mode', $mode);
		$render->assign('noverification', pnModGetVar('MyProfile','noverification'));
	
		$this->id = (int)pnUserGetVar('uid');
		if ($this->id > 0) {
			// get settings
			$data = pnModAPIFunc('MyProfile','user','getSettings',array('uid'=>$this->id));
			// work with retrieved user settings
			$individualtemplates = (int)pnModGetVar('MyProfile','individualtemplates');
			if (($individualtemplates == 1) && (pnModAPIFunc('MyProfile','user','individualTemplateAllowed',array('uid' => $this->id)))) $render->assign('individualtemplates',1);
			$render->assign($data);
			// timezone management, get zikula's timezones
		    $tzinfo   = pnModGetVar(PN_CONFIG_MODULE, 'timezone_info');
			foreach ($tzinfo as $key=>$value) {
			  	$items_timezone[] = array('text' => $value, 'value' => $key);
			}
			$render->assign('items_timezone', $items_timezone);
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
					'customsettings'	 	=> $obj['customsettings'],
					'timezoneoffset'		=> $obj['timezoneoffset']
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
