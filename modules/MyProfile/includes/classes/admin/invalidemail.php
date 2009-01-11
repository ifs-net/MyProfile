<?php
/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schie�l
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
 
class MyProfile_admin_invalidemailHandler
{
    function initialize(&$render)
    {
		return true;
    }
    function handleCommand(&$render, &$args)
    {
		if ($args['commandName']=='update') {
		    // Security check 
		    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_ADMIN)) return LogUtil::registerPermissionError();

			// get the pnForm data and do a validation check
		    $obj = $render->pnFormGetValues();		    

			$email = $obj['email'];
			$tables 		= pnDBGetTables();
			$userscolumn 	= $tables['users_column'];
			$where = $userscolumn['email']." like '".$email."'";
			$users = DBUtil::selectObjectArray('users',$where);
			if (count($users) < 1) {
			  	LogUtil::registerError(_MYPROFILEEMAILNOTFOUND);
			}
			else {
			  	// maybe there are more users than one with the same email address
			  	foreach ($users as $user) {
			  	  	$attr = $user['__ATTRIBUTES__'];
					if (isset($attr['myprofile_invalidemail']) && $attr['myprofile_invalidemail'] == 1) {
					  	LogUtil::registerError(_MYPROFILEUSERALREADYADDED.': '.$user['uname']);
					}
					else {
						// update user attributes
						$new['uid'] = $user['uid'];
						$new['__ATTRIBUTES__']['myprofile_invalidemail'] = 1;
						
						if (DBUtil::updateObject($new, 'users', '', 'uid')) {
						  	LogUtil::registerStatus(_MYPROFILEUSERMARKED.': '.$user['uname']);
						}
						else {
						  	LogUtil::registerError(_MYPROFILEUPDATEERRORFOR.': '.$user['uname']);
						}
					}
				}
			}
		    
		}
		return true;
    }
}