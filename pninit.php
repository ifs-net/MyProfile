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
  	if (!DBUtil::createTable('myprofile_confirmedusers')) return false;
  	if (!DBUtil::createTable('myprofile_templates')) return false;

    // Module Variables
    $allowmemberlist		= pnSessionGetVar('myprofile_allowmemberlist');
    $asattributes			= pnSessionGetVar('myprofile_asattributes');
    $notabs 				= pnSessionGetVar('myprofile_notabs');
    $plugin_noajax			= pnSessionGetVar('myprofile_plugin_noajax');
    $validuntil 			= pnSessionGetVar('myprofile_validuntil');
    $dateformat 			= pnSessionGetVar('myprofile_dateformat');
    $noverification			= pnSessionGetVar('myprofile_noverification');
    $requestban 			= pnSessionGetVar('myprofile_requestban');
    $expiredays 			= pnSessionGetVar('myprofile_expiredays');
    $individualpermissions 	= pnSessionGetVar('myprofile_individualpermissions');
    $resultsperpage 		= pnSessionGetVar('myprofile_resultsperpage');
    $convertToUTF8			= pnSessionGetVar('myprofile_convertToUTF8');

    pnModSetVar('MyProfile', 'allowmemberlist', 		(($allowmemberlist<>false) ? $allowmemberlist : 0));	
    pnModSetVar('MyProfile', 'notabs', 					(($notabs<>false) ? $notabs : ''));	
    pnModSetVar('MyProfile', 'plugin_noajax',			(($plugin_noajax<>false) ? $plugin_noajax : ''));	
    pnModSetVar('MyProfile', 'validuntil', 				(($validuntil<>false) ? $validuntil : 0));	
    pnModSetVar('MyProfile', 'asattributes',			(($asattributes<>false) ? $asattributes : 0));	
    pnModSetVar('MyProfile', 'resultsperpage',			(($resultsperpage<>false) ? $resultsperpage : 50));	
    pnModSetVar('MyProfile', 'dateformat', 				(($dateformat<>false) ? $dateformat : '%d.%m.%Y'));	
    pnModSetVar('MyProfile', 'noverification', 			(($noverification<>false) ? $noverification : ''));	
    pnModSetVar('MyProfile', 'requestban', 				(($requestban<>false) ? $requestban : 7));	
    pnModSetVar('MyProfile', 'expiredays', 				(($expiredays<>false) ? $expiredays : 70));	
    pnModSetVar('MyProfile', 'individualpermissions',	(($individualpermissions<>false) ? $individualpermissions : 0));	
    pnModSetVar('MyProfile', 'individualtemplates',		(($individualtemplates<>false) ? $individualtemplates : 0));	
    pnModSetVar('MyProfile', 'convertToUTF8',			(($convertToUTF8<>false) ? $convertToUTF8 : 0));	

    // clean up
    pnSessionDelVar('myprofile_allowmemberlist');
    pnSessionDelVar('myprofile_resultsperpage');
    pnSessionDelVar('myprofile_asattributes');
    pnSessionDelVar('myprofile_notabs');
    pnSessionDelVar('myprofile_plugin_noajax');
    pnSessionDelVar('myprofile_validuntil');
    pnSessionDelVar('myprofile_dateformat');
    pnSessionDelVar('myprofile_noverification');
    pnSessionDelVar('myprofile_requestban');
    pnSessionDelVar('myprofile_expiredays');
    pnSessionDelVar('myprofile_individualpermissions');
    pnSessionDelVar('myprofile_individualtemplates');
    pnSessionDelVar('myprofile_convertToUTF8');

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
  	if (!DBUtil::dropTable('myprofile_confirmedusers')) return false;
  	if (!DBUtil::dropTable('myprofile_templates')) return false;

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
    	pnModSetVar('MyProfile',	'individualpermissions'	,0);
    	pnModSetVar('MyProfile',	'individualtemplates'	,0);
    	pnModSetVar('MyProfile',	'resultsperpage'		,50);
    	pnModSetVar('MyProfile',	'allowmemberlist'		,0);
    	pnModSetVar('MyProfile',	'convertToUTF8'			,0);

    	// tables for templates and "trust list" introduced
	  	if (!DBUtil::createTable('myprofile_confirmedusers')) return false;
	  	if (!DBUtil::createTable('myprofile_templates')) return false;
	  	if (!DBUtil::changeTable('myprofile_fields')) return false;
	case '1.1':
		// update table definition because of the new usage of varchar and longtext
		pnModAPIFunc('MyProfile','admin','updateTableDefinition');
    default:
	    return true;
    }
}
?>