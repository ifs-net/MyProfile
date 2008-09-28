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
 * initialise the MyProfile module
 *
 * @return       bool       true on success, false otherwise
 */
function MyProfile_init()
{
  	if (!DBUtil::createTable('myprofile')) return false;
  	if (!DBUtil::createTable('myprofile_fields')) return false;

    // Module Variables
    $asattributes			= pnSessionGetVar('myprofile_asattributes');
    $notabs 				= pnSessionGetVar('myprofile_notabs');
    $plugin_noajax			= pnSessionGetVar('myprofile_plugin_noajax');
    $validuntil 			= pnSessionGetVar('myprofile_validuntil');
    $dateformat 			= pnSessionGetVar('myprofile_dateformat');
    $noverification			= pnSessionGetVar('myprofile_noverification');
    $requestban 			= pnSessionGetVar('myprofile_requestban');
    $expiredays 			= pnSessionGetVar('myprofile_expiredays');
    $individualpermissions 	= pnSessionGetVar('myprofile_individualpermissions');
    pnModSetVar('MyProfile', 'notabs', 					(($notabs<>false) ? $notabs : ''));	
    pnModSetVar('MyProfile', 'plugin_noajax',			(($plugin_noajax<>false) ? $plugin_noajax : ''));	
    pnModSetVar('MyProfile', 'validuntil', 				(($validuntil<>false) ? $validuntil : 0));	
    pnModSetVar('MyProfile', 'asattributes',			(($asattributes<>false) ? $asattributes : 0));	
    pnModSetVar('MyProfile', 'dateformat', 				(($dateformat<>false) ? $dateformat : '%d.%m.%Y'));	
    pnModSetVar('MyProfile', 'noverification', 			(($noverification<>false) ? $noverification : ''));	
    pnModSetVar('MyProfile', 'requestban', 				(($requestban<>false) ? $requestban : 7));	
    pnModSetVar('MyProfile', 'expiredays', 				(($expiredays<>false) ? $expiredays : 70));	
    pnModSetVar('MyProfile', 'individualpermissions',	(($individualpermissions<>false) ? $individualpermissions : 0));	

    // clean up
    pnSessionDelVar('myprofile_asattributes');
    pnSessionDelVar('myprofile_notabs');
    pnSessionDelVar('myprofile_plugin_noajax');
    pnSessionDelVar('myprofile_validuntil');
    pnSessionDelVar('myprofile_dateformat');
    pnSessionDelVar('myprofile_noverification');
    pnSessionDelVar('myprofile_requestban');
    pnSessionDelVar('myprofile_expiredays');
    pnSessionDelVar('myprofile_individualpermissions');
			
    // delete old config file if there is one
    $configfile = 'modules/MyProfile/config/tabledef.inc';
    if (file_exists($configfile)) unlink($configfile);

    // Initialisation successful
    return true;
}

/**
 * delete the MyProfile module
 *
 * @return       bool       true on success, false otherwise
 */
function MyProfile_delete()
{
  	if (!DBUtil::dropTable('myprofile')) return false;
  	if (!DBUtil::dropTable('myprofile_fields')) return false;

    // Delete any module variables
    pnModDelVar('MyProfile');
    
    // delete old config file if there is one
    $configfile = 'modules/MyProfile/config/tabledef.inc';
    if (file_exists($configfile)) unlink($configfile);

    // Deletion successful
    return true;
}

function MyProfile_upgrade($oldversion)
{
   switch($oldversion) {
    case '1.0':
    	// introduce individualpermission module variable
    	pnModSetVar('MyProfile','individualpermissions',0);
    	break;
    default:
    return true;
}
?>