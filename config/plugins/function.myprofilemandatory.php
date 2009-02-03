<?php
/**
 * @package      MyProfile
 * @version      $Id: function.myprofilemandatory.php 273 2009-01-11 21:54:28Z quan $
 * @author       Florian Schie�l
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
 
/**
 * force users to create a mandatory profile
 *
 * A user's profile is mandatory and valid if 
 * $userdata['__ATTRIBUTES__']['validuntil']	timestamp
 * is not older than today's unix timestamp.
 * Otherwise the profile has to be updated. The user will be re-
 * directed to the profile management otherwise.
 */
function smarty_function_myprofilemandatory()
{
    if (pnUserLoggedIn()
	&& pnModAvailable('MyProfile')
	&& (pnModGetName() != 'MyProfile')
	&& (strtolower(FormUtil::getPassedValue('type') 		!= 'admin'		))) {
	  	$attributes = pnUserGetVar('__ATTRIBUTES__');
	  	// first check if email address is marked as invalid
	  	if ($attributes['myprofile_invalidemail'] == 1) {
		    // user has invalid email address
      	  	// load language file
      	  	pnModLangLoad('MyProfile','plugin');
      	  	// register error message
		    LogUtil::registerError(_MYPROFILEYOUREMAILINVALID);
		    return pnRedirect(pnModURL('MyProfile','user','settings',array('mode' => 'email')));
		}
	  	else if (!pnModAPIFunc('MyProfile','user','hasValidProfile')) {
      	  	// load language file
      	  	pnModLangLoad('MyProfile','plugin');
      	  	// register error message
		    LogUtil::registerError(_MYPROFILEPROFILEOUTOFTIME);
		    return pnRedirect(pnModURL('MyProfile','user','main'));
		}
    }
}
?>