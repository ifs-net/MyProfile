<?php
/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schießl
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
 
/**
 * forces users having an invalid email address to update the email address
 *
 */
function smarty_function_myprofileinvalidemail()
{
    if (pnUserLoggedIn()
	&& pnModAvailable('MyProfile')
	&& (pnModGetName() != 'MyProfile')
	&& (strtolower(FormUtil::getPassedValue('type') 		!= 'admin'		))) {
	  	$attributes = pnUserGetVar('__ATTRIBUTES__');
	  	if ($attributes['myprofile_invalidemail'] == 1) {
		    // user has invalid email address
      	  	// load language file
      	  	pnModLangLoad('MyProfile','plugin');
      	  	// register error message
		    LogUtil::registerError(_MYPROFILEYOUREMAILINVALID);
		    return pnRedirect(pnModURL('MyProfile','user','email'));
		}
    }
}
?>