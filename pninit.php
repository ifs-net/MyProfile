<?php
/**
 * initialise the MyProfile module
 *
 * @return       bool       true on success, false otherwise
 */
function MyProfile_init()
{
  	if (!DBUtil::createTable('myprofile')) return false;
  	if (!DBUtil::createTable('myprofile_fields')) return false;
  	if (!DBUtil::createTable('myprofile_settings')) return false;
  	if (!DBUtil::createTable('myprofile_emailverification')) return false;

    // Module Variables
    $notabs = pnSessionGetVar('myprofile_notabs');
    $dateformat = pnSessionGetVar('myprofile_dateformat');
    $noverification = pnSessionGetVar('myprofile_noverification');
    pnModSetVar('MyProfile', 'notabs', (($notabs<>false) ? $notabs : ''));	
    pnModSetVar('MyProfile', 'dateformat', (($dateformat<>false) ? $dateformat : '%d.%m.%Y'));	
    pnModSetVar('MyProfile', 'noverification', (($noverification<>false) ? $noverification : ''));	

    // clean up
    pnSessionDelVar('myprofile_notabs');
    pnSessionDelVar('myprofile_dateformat');
    pnSessionDelVar('myprofile_noverification');
			
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
  	if (!DBUtil::dropTable('myprofile_settings')) return false;
  	if (!DBUtil::dropTable('myprofile_emailverification')) return false;

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
    return true;
}
?>