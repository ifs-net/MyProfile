<?php
/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schießl
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
 
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
				    if (pnUserSetVar('email',$code['email'])) {
					  	LogUtil::registerStatus(_MYPROFILEEMAILCHANGED);
						// email address was changed - we now need to delete the attribute invalidemail if it exists
					    $user = DBUtil::selectObjectByID('users', pnUserGetVar('uid'), 'uid', null, null, null, false);
						$user['__ATTRIBUTES__']['myprofile_invalidemail'] = '';
						// store attributes
						DBUtil::updateObject($user, 'users', '', 'uid');			
					}
				    else return LogUtil::registerError(_MYPROFILEEMAILCHANGEERROR);
				}
				else return LogUtil::registerError(_MYPROFILEINCORRECTCODE.' code: '.$code['code'].' entered '.$obj['code']);
			}
			else return LogUtil::registerError(_MYPROFILEINVALIDCODE);
			// now we have to delete the old validation code from the user's attributes
			$uid = $obj['uid'];
		    $user = DBUtil::selectObjectByID('users', $uid, 'uid', null, null, null, false);
			$user['__ATTRIBUTES__']['myprofile_validationcode'] = '';
			// store attributes
			DBUtil::updateObject($user, 'users', '', 'uid');			
			return pnRedirect(pnModURL('MyProfile','user','settings'));
		}
		return true;
    }
}

