<?php
/**
 * PostNuke Application Framework
 *
 * @copyright (c) 2002, PostNuke Development Team
 * @link http://www.postnuke.com
 * @version $Id: pnversion.php 22138 2007-06-01 10:19:14Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package PostNuke_System_Modules
 * @subpackage Profile
 */

$modversion['name']           = _PROFILE_MODNAME;
$modversion['oldnames']       = array('Your_Account');
$modversion['displayname']    = _PROFILE_DISPLAYNAME;
$modversion['description']    = _PROFILE_DESCRIPTION;
$modversion['version']        = '1.0';
$modversion['credits']        = 'pndocs/credits.txt';
$modversion['help']           = 'pndocs/help.txt';
$modversion['changelog']      = 'pndocs/changelog.txt';
$modversion['license']        = 'pndocs/license.txt';
$modversion['official']       = true;
$modversion['author']         = 'Mark West, Franky Chestnut // deactived by Florian Schießl';
$modversion['contact']        = 'http://www.markwest.me.uk/, http://dev.pnconcept.com/';
$modversion['securityschema'] = array('Profile::item' => 'Dynamic User Data Property Name::Dynamic User Data Property ID');
