<?php
/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schießl
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

class MyProfile_admin_settingsHandler
{
    function initialize(&$render)
    {
	  	$data['allowmemberlist']		= pnModGetVar('MyProfile','allowmemberlist');
	  	$data['notabs'] 				= pnModGetVar('MyProfile','notabs');
	  	$data['individualpermissions'] 	= pnModGetVar('MyProfile','individualpermissions');
	  	$data['individualtemplates'] 	= pnModGetVar('MyProfile','individualtemplates');
	  	$data['plugin_noajax'] 			= pnModGetVar('MyProfile','plugin_noajax');
	  	$data['validuntil'] 			= pnModGetVar('MyProfile','validuntil');
	  	$data['asattributes']			= pnModGetVar('MyProfile','asattributes');
	  	$data['dateformat'] 			= pnModGetVar('MyProfile','dateformat');
	  	$data['noverification']			= pnModGetVar('MyProfile','noverification');
	  	$data['requestban'] 			= pnModGetVar('MyProfile','requestban');
	  	$data['expiredays'] 			= pnModGetVar('MyProfile','expiredays');
	  	$data['searchtemplate']			= pnModGetVar('MyProfile','searchtemplate');
	  	$data['resultsperpage']			= pnModGetVar('MyProfile','resultsperpage');
	  	$groups	= pnModAPIFunc('MyProfile','admin','getGroupsConfiguration');
	  	$groups_list = array();
	  	foreach ($groups as $g) $groups_list[] = array('text' => $g['name'], 'value' => $g['gid']);
		$data['groups'] = $groups_list;
		$data['disabledgroups'] = unserialize(pnModGetVar('MyProfile','disabledgroups'));
	  	$render->assign($data);
		return true;
    }
    function handleCommand(&$render, &$args)
    {
		if ($args['commandName']=='update') {
		    // Security check 
		    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_ADMIN)) return LogUtil::registerPermissionError();

			// get the pnForm data and do a validation check
		    $obj = $render->pnFormGetValues();		    
		    if (!$render->pnFormIsValid()) return false;
		    // store all passed form values as module variables
		    foreach ($obj as $key=>$value) {
		      	if (is_array($value)) $value=serialize($value);
			  	pnModSetVar('MyProfile',(string)$key,(string)$value);
			}
			LogUtil::registerStatus(_MYPROFILECFGSTORED);
		}
		return true;
    }
}