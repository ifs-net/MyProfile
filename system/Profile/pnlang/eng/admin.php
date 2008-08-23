<?php
/**
 * PostNuke Application Framework
 *
 * @copyright (c) 2002, PostNuke Development Team
 * @link http://www.postnuke.com
 * @version $Id: admin.php 22605 2007-08-15 16:35:38Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package PostNuke_System_Modules
 * @subpackage Profile
 */

// general
define('_PROFILE_DUD','Account Panel Manager');
define('_MODIFYACCOUNTPANELCONFIG', 'Account Panel Manager Settings');
define('_NEWPANELCONTROL', 'Create Account Panel Property');
define('_ACCOUNTPANELCONTROLSLISTVIEW', 'Account Panel Properties List');
define('_DISPLAYSETTINGS', 'Display Settings');

// view template
define('_PROFILE_DRAGANDDROPHINT', 'Tip: You can arrange the order of the individual properties, using drag and drop. The display order will be saved when you drop the property at the desired place.');
define('_PROFILE_NA','N/A');

// modify config template
define('_PROFILE_DISPLAYGRAPHICS', 'Display graphics in user\'s account panel');
define('_PROFILE_ITEMSPERROW','Links per row');

// new/modify templates
define('_PROFILE_ADDINSTRUCTIONS', 'Reminder: After you create a new property label above (such as _MYINT), you must create a define in \'config/languages/eng/global.php\' to provide a display string for the new property label. For _MYINT, it could be: define(\'_MYINT\', \'My integer\');');
define('_PROFILE_DISPLAYTYPE', 'Display type');
define('_PROFILE_FIELDCOMBONOTE', 'Reminder: Precede each option by @@. For combo boxes: id1,label1;id2,label2;id3,label3;... Separate each individual property with a semicolon (\';\'). Separate the ID and label of each property with a comma (\',\').');
define('_PROFILE_FIELDLABEL_FLC','Property Label');
define('_PROFILE_FIELDLABEL','Property label');
define('_PROFILE_FIELDLENGTH','Length');
define('_PROFILE_FIELDTYPE_FLC','Data Type');
define('_PROFILE_FIELDTYPE','Data type');
define('_PROFILE_FIELDSTATUS', 'Status');
define('_PROFILE_FIELDVALIDATION','Validation rules');
define('_PROFILE_LISTOPTIONS', 'List content');
define('_PROFILE_STRINGINSTRUCTIONS', 'Reminder: The \'Length\' setting above is for strings only. Leave empty for other types. Acceptable value: 1-255.');
define('_PROFILE_VALIDATION', 'Validation');
define('_PROFILE_VIEWABLEBY', 'Viewable by');

// error/status messages
define('_PROFILE_ACTIVATIONFAILED', 'Error! Sorry! Activation failed');
define('_PROFILE_DEACTIVATIONFAILED', 'Error! Sorry! Deactivation failed');
define('_PROFILE_EMPTYLABEL', 'Error! Sorry! The property must have an internal label, such as: _MYINT');
define('_PROFILE_LABELEXISTS', 'Error! Sorry! This property label already exists');

// viewable by drop down
define('_PROFILE_VIEWBYOPTIONADM', 'Admins only');
define('_PROFILE_VIEWBYOPTIONUSR', 'Registered users only');
define('_PROFILE_VIEWBYOPTIONALL', 'Everyone');

// field types
define('_PROFILE_CORE','Core');
define('_PROFILE_COREREQUIRED','Core, Required');
define('_PROFILE_FLOAT','Float');
define('_PROFILE_FLOATREQUIRED','Float, Required');
define('_PROFILE_INTEGER','Integer');
define('_PROFILE_INTEGERREQUIRED','Integer, Required');
define('_PROFILE_MANDATORY','Mandatory');
define('_PROFILE_STRING','String');
define('_PROFILE_STRINGREQUIRED','String, Required');
define('_PROFILE_TEXT','Text');
define('_PROFILE_TEXTREQUIRED','Text, Required');

// field control types
define('_PROFILE_FIELDTEXT', 'Text box');
define('_PROFILE_FIELDTEXTAREA', 'Text area');
define('_PROFILE_FIELDCHECKBOX', 'Checkbox');
define('_PROFILE_FIELDRADIO', 'Radio button');
define('_PROFILE_FIELDSELECT', 'Dropdown list');
define('_PROFILE_FIELDDATE', 'Calendar');
define('_PROFILE_FIELDEXTDATE', 'Date (extended)');
define('_PROFILE_FIELDCOMBOTEXT', 'Combo box (text)');

