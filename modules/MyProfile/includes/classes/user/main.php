<?php
/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schießl
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2010
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
 
class MyProfile_user_ProfileHandler
{
    var $id;
    var $load_uid;
    function initialize(&$render)
    {
        $dom = ZLanguage::getModuleDomain('MyProfile');
        $uid = pnUserGetVar('uid');
        $settings   = pnModAPIFunc('MyProfile','user','getSettings',array('uid' => $uid));
        $fields     = pnModAPIFunc('MyProfile','admin','getFields');
        $separators = pnModAPIFunc('MyProfile','admin','countSeparators');

        // We first have to filter out fields that are not active - these should not be writable by the user
        $resultfields = array();
        foreach ($fields as $field) {
            if ($field['active'] != 0) {
                $resultfields[] = $field;
            }
        }
        $fields = $resultfields;
        unset($resultfields);

        // Should mandatory message be displayed (User was redirected)
        $mandatorymessage =  (int) SessionUtil::getVar('MyProfile_mandytorymessage');
        if ($mandatorymessage == 1) {
			SessionUtil::delVar('MyProfile_mandytorymessage');
			LogUtil::registerError(__('Your profile is outdated or incomplete - please check / complete / update your personal data', $dom));
        }

        // Assign data to template
	$render->assign('fields',         $fields);
	$render->assign('separators',     $separators);
	$render->assign('uid',            $uid);
	$render->assign('mymapavailable', pnModAvailable('MyMap'));
	$notabs = pnModGetVar('MyProfile','notabs');
	
	// if the user does not have a valid (incomplete / outdated) profile we should better
	// not use the tab-mode because the user might not see every field and only update / complete
	// the first tab
	if (!pnModAPIFunc('MyProfile','user','hasValidProfile')) {
            $notabs = 1;
        }
	$render->assign('notabs',$notabs);
	PageUtil::addVar('javascript','modules/MyProfile/pnjavascript/myprofile.js');   
      	// Admins should be able to modify user's profile data
      	$load_uid = (int) FormUtil::getPassedValue('load_uid');
      	if (isset($load_uid) && (($load_uid) > 0) && (SecurityUtil::checkPermission('MyProfile::', '.$load_uid', ACCESS_ADMIN))) {
            $this->id = $load_uid;
        } else {
            $this->id = (int)pnUserGetVar('uid');
        }

        // Load admin library
        if (SessionUtil::getVar('MyProfile_sendnotification') == 1) {
            Loader::includeOnce('modules/MyProfile/includes/common_admin.php');
            mp_admin_sendNotification(array('id' => $this->id));			
            SessionUtil::delVar('MyProfile_sendnotification');
        }

	if ($this->id > 0) {
            $data = DBUtil::selectObjectByID('myprofile', $this->id);
            if (!isset($data)) {
                unset($this->id);
            } else {
                // extract coordinates if there are some
                $resultfields = array();
                foreach ($fields as $field) if ($field['fieldtype'] == 'COORD') {
                    $resultfields[] = $field;
                }
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
        return true;
    }

    function handleCommand(&$render, &$args)
    {
        $dom = ZLanguage::getModuleDomain('MyProfile');
        if ($args['commandName']=='update') {
            // Security check
            if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_COMMENT)) {
                return LogUtil::registerPermissionError();
            }
            // get the pnForm data and do a validation check
            $obj = $render->pnFormGetValues();
            if (!$render->pnFormIsValid()) {
                return false;
            }
            $obj['timestamp'] = date("Y-m-d",time());
            // now check fields for coordinates (and do validation check),
            // check for date transformation and check if value should
            // also be stored as user attribute.
            $fields = pnModAPIFunc('MyProfile','admin','getfields');
            foreach ($fields as $field) {
                // Profile compatibility
                if ($field['userproperty'] != '') {
                    $uid = $this->id;
                    if (!($uid > 1)) {
                        $uid = pnUserGetVar('uid');
                    }
                    // set user property
                    pnUserSetVar($field['userproperty'],$obj[$field['identifier']]);
                }
                // coordinate validation
                if ($field['fieldtype'] == 'COORD') {
                    $identifier = $field['identifier'];
                    $lat = $identifier.'_lat';
                    $lng = $identifier.'_lng';
                    if (($obj[$lng] == '') || ($obj[$lat] == '')) {
                        $obj[$identifier] = '';
                    } else {
                        $pattern = '/^[0-9+-][0-9]*(|\.)[0-9]*$/';
                        $obj[$lng] = str_replace(',','.',$obj[$lng]);
                        $obj[$lat] = str_replace(',','.',$obj[$lat]);
                        if ((!preg_match($pattern,$obj[$lat])) || (!preg_match($pattern,$obj[$lng]))) {
                            LogUtil::registerError(__('Please check the format you entered for your coordinates!',$dom));
                            return false;
                        }
                        $obj[$identifier] = array(
                            'lng' => $obj[$lng],
                            'lat' => $obj[$lat]
                            );
                    }
                    unset($obj[$lat]);
                    unset($obj[$lng]);
                    if ($obj[$identifier] != '') {
                        $obj[$identifier] = serialize($obj[$identifier]);
                    }
                }
                // check for date
                if ($field['fieldtype'] == 'DATE') {
                    $identifier = $field['identifier'];
                    $obj[$identifier] = DateUtil::transformInternalDate(DateUtil::parseUIDate($obj[$identifier]));
                }
            }

            if ($this->id > 0) {	// update an existing profile
                $obj['id']=$this->id;
                $result = DBUtil::updateObject($obj, 'myprofile');

                // update user's attributes if neccesarry
                if (!pnModAPIFunc('MyProfile','user','storeAsAttributes',array('data' => $obj))) {
                    LogUtil::registerError(__('Updating / creating user attributes failed', $dom));
                }
				
                // Set status message for the user
                if ($result) {
                    LogUtil::registerStatus(__('Profile was updated successfully', $dom));
                } else {
                    LogUtil::registerError(__('Creating / Updating profile failed', $dom));
                    $error = true;
                }
            } else {
                // create a new profile
                // if the user is created by the user himself we need his uid
                // otherwise we have to work with the load_uid value
                $load_uid = (int)FormUtil::getPassedValue('load_uid');
                if (($load_uid > 0) && (!pnModAPIFunc('MyProfile','user','getProfile',array('uid'=>$load_uid)) && SecurityUtil::checkPermission('MyProfile::','::', ACCESS_ADMIN)) ) {
                    $obj['id'] = $load_uid;
                } else {
                    $obj['id'] = pnUserGetVar('uid');
                }
                $this->id = $obj['id'];
                $this->load_uid = $obj['id'];
                $createAction = DBUtil::insertObject($obj, 'myprofile',true);

                // Give success message to the user
                if ($createAction) {
                    // update user's attributes if neccesarry
                    if (!pnModAPIFunc('MyProfile','user','storeAsAttributes',array('data' => $obj))) {
                        LogUtil::registerError(__('Updating / creating user attributes failed', $dom));
                    }
                    // Send a notification email - but we have to send it later because API will not return correct profile now
                    SessionUtil::setVar('MyProfile_sendnotification',1);
                    // Register Status Message
                    LogUtil::registerStatus(__('The profile was created successfully', $dom));
                } else {
                    // Register Error message
                    LogUtil::registerError(__('Profile creation error', $dom));
                    $error = true;
                }
            }

            if ($this->load_uid > 0) {
                return $render->pnFormRedirect(pnModURL('MyProfile','user','main',array('load_uid'=>$this->load_uid)));
            } else {
                SessionUtil::delVar('MyProfile_mandatorymessage');
                if (!$error) {
                    return $render->pnFormRedirect(pnModURL('MyProfile','user','display'));    			    
                } else {
                    return $render->pnFormRedirect(pnModURL('MyProfile'));
                }
            }
        }
        return true;
    }
}
