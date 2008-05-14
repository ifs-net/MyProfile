<?php

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
