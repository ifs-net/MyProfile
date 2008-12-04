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
		$uid 		= pnUserGetVar('uid');
		$settings 	= pnModAPIFunc('MyProfile','user','getSettings',array('uid' => $uid));
		$render->assign('fields',pnModAPIFunc('MyProfile','admin','getFields'));
		$render->assign('separators',pnModAPIFunc('MyProfile','admin','countSeparators'));
		$render->assign('uid',$uid);
		$render->assign('mymapavailable',pnModAvailable('MyMap'));
		$notabs = pnModGetVar('MyProfile','notabs');
		// if the user does not have a valid (incomplete / outdated) profile we should better
		// not use the tab-mode because the user might not see every field and only update / complete
		// the first tab
		if (!pnModAPIFunc('MyProfile','user','hasValidProfile')) $notabs = 1;
		$render->assign('notabs',$notabs);
		PageUtil::addVar('javascript','modules/MyProfile/pnjavascript/myprofile.js');   
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
				    if (($obj[$lng] == '') || ($obj[$lat] == '')) break;
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
