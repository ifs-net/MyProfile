<?php
/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schießl
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
 
// The following information is used by the Modules module 
// for display and upgrade purposes
$modversion['name']           = 'MyProfile';
// the version string must not exceed 10 characters!
$modversion['version']        = '1.6';
$modversion['description']    = 'MyProfile - the advanced pnRender based Zikula profile module';
$modversion['displayname']    = 'MyProfile';

// The following in formation is used by the credits module
// to display the correct credits
$modversion['changelog']      = 'pndocs/changelog.txt';
$modversion['credits']        = 'pndocs/credits.txt';
$modversion['help']           = 'pndocs/help.txt';
$modversion['license']        = 'pndocs/license.txt';
$modversion['official']       = 0;
$modversion['author']         = 'Florian Schiessl';
$modversion['contact']        = 'http://www.ifs-net.de/';

// The following information tells the PostNuke core that this
// module has an admin option.
$modversion['admin']          = 1;

// module is a profile module
$modversion['profile']        = 1;

// module dependencies
$modversion['dependencies'] = array(
	array(	'modname'    => 'ifs',
			'minversion' => '1.0', 'maxversion' => '',
            'status'     => PNMODULE_DEPENDENCY_REQUIRED),
	array(	'modname'    => 'EZComments',
			'minversion' => '1.6', 'maxversion' => '',
            'status'     => PNMODULE_DEPENDENCY_RECOMMENDED),
	array(	'modname'    => 'ContactList',
			'minversion' => '1.1', 'maxversion' => '',
            'status'     => PNMODULE_DEPENDENCY_RECOMMENDED),
	array(	'modname'    => 'ClickedMe',
			'minversion' => '1.0', 'maxversion' => '',
            'status'     => PNMODULE_DEPENDENCY_RECOMMENDED),
	array(	'modname'    => 'WebLog',
            'minversion' => '1.0', 'maxversion' => '',
    		'status'     => PNMODULE_DEPENDENCY_RECOMMENDED),
	array(  'modname'    => 'UserPictures',
	        'minversion' => '1.1', 'maxversion' => '',
	        'status'     => PNMODULE_DEPENDENCY_RECOMMENDED),
	array(  'modname'    => 'InterCom',
	        'minversion' => '2.1', 'maxversion' => '',
	        'status'     => PNMODULE_DEPENDENCY_RECOMMENDED),
	array(  'modname'    => 'AboutMe',
	        'minversion' => '1.0', 'maxversion' => '',
	        'status'     => PNMODULE_DEPENDENCY_RECOMMENDED),
    array(	'modname'    => 'MyMap',
            'minversion' => '1.3', 'maxversion' => '',
            'status'     => PNMODULE_DEPENDENCY_RECOMMENDED)
	);

// This one adds the info to the DB, so that users can click on the 
// headings in the permission module
$modversion['securityschema'] = array('MyProfile::' => 'MyProfile item name::MyProfile item ID');

?>