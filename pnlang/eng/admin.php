<?php
// menu
define('_MYPROFILEMAIN',			'Main backend page');
define('_MYPROFILEACTUALCONFIG',	'MyProfile configuration');
define('_MYPROFILEFINDORPHANS',		'Check database');
define('_MYPROFILEPLUGINS',			'Plugins');

// main
define('_MYPROFILEBACKEND',			'MyProfile backend configuration');
define('_MYPROFILEBACKENDDESCR',	'This is the backend for the MyProfile module. First step for the admin should be the creation of a profile configuration. Have a lot of fun with this module!');
define('_MYPROFILESUPPORTMYPROFILE','Support the MyProfile module');
define('_MYPROFILEDONATETHIS',		'Donate with PayPal!');
define('_MYPROFILEDONATE',			'You like this module and it is usefull for you? Thank you for some little donation for the programmer! OK - I like programming very much and this module is free and open source - but if you spend some money I\'ll go out for a nice candlelight dinner with my girlfriend and it will be much easier next time to get free time for programming ;-)');
define('_MYPROFILEEDITPROFILE',		'Modify existing user profiles');
define('_MYPROFILEEDITUNAME',		'Just enter the username...');
define('_MYPROFILEEDITUID',			'or the user\'s ID...');
define('_MYPROFILEEDITPROFILETHEN',	'... and edit the user\'s profile');
define('_MYPROFILEMAKEPROFILEMANDATORY',	'Valid profile should be mandatory for every user');
define('_MYPROFILEMAKEPROFILEMANDATORYCODE','If you want every member of your website to have a valid profile you have to include the following code into your theme templates. The function that is called with this code checks if the actual logged in user has a profile. If there is no profile found the user will be redirected to the form to fill out the complete user profile. This will only be applied if the member is not an administrator of MyProfile module.');
//main, settings
define('_MYPROFILEGLOBALETTINGS',	'General module settings');
define('_MYPROFILENOTABS',			'Do not use the "tab"-mode (Javscript/CSS-Tabs)');
define('_MYPROFILESAVECFG',			'Update configuration');
define('_MYPROFILECFGSTORED',		'Configuration updated successfully');
define('_MYPROFILENOVERIFICATION',	'Do not verify new stored email addresses with an verification email and a verification code');

// editProfile
define('_MYPROFILEUNOTFOUND',		'No user with this username or user-ID found');
define('_MYPROFILEFILENOTWRITEABLE','Config file is not writeable - change this before trying to edit the actual configuration');
define('_MYPROFILEFILENOTREADABLE',	'Config file is not readable - change this before trying to edit the actual configuration');
define('_MYPROFILEWRITEFILEPROBLEMS','Config file could not be created - please check the config directory permissions');

// configFailure
define('_MYPROFILEERROROCCURED',	'An error occured. Please regard the error message!');
define('_MYPROFILECFGDIREXIST',		'A directory inside the MyProfile module named "config" must exist');
define('_MYPROFILECFGDIRWRITABLE',	'This directory has to be writable by the webserver');
define('_MYPROFILECFGFILENAME',		'In this directory a file called tabledef.inc will be created by the module');
define('_MYPROFILECFGREADABLE',		'This file has to be readable by the webserver');
define('_MYPROFILECFGWRITABLE',		'This file has to be writable by the webserver');
define('_MYPROFILEPROCEED',			'Try again and proceed');

// fields configuration
define('_MYPROFILECONFIGURATION',	'Your profile\'s configuration');
define('_MYPROFILEREDIRECTFACC',	'It is possible to redirect functional accounts (administrator accounts etc.). Just enter the id values of the accounts you want to mark as functional accounts. Please separate each id with a comma.');
define('_MYPROFILEISOPTIONAL',		'optional field');
define('_MYPROFILEISMANDATORY',		'mandatory field');
define('_MYPROFILEALL',				'viewable by everybody');
define('_MYPROFILEREG',				'viewable by registered users only');
define('_MYPROFILEADMIN',			'viewable by admin users only');
define('_MYPROFILECHARS',			'characters');
define('_MYPROFILEISACTIVE',		'Activated');
define('_MYPROFILEISSHOWN',			'shown');
define('_MYPROFILEEXISTINGFIELDS',	'Manage the existing fields');
define('_MYPROFILEMANAGEHOWTO',		'If you want to change the order just click on the box and move the item to the position you want it to be. Settings will be stored automatically!');
define('_MYPROFILEEDIT',			'modify this field');
define('_MYPROFILEADDSEPARATOR',	'Add a separator bar');
define('_MYPROFILEMOVEUP',			'Move up');
define('_MYPROFILEMOVEDOWN',		'Move down');
define('_MYPROFILEELEMENTMOVED',	'Element was moved successfully');

// configuration, ajax interface
define('_MYPROFILESTOREDAT',		'New order was saved successfully at');

// add a new field or modify an existing one
define('_MYPROFILEADDNEWFIELD',		'Add a new field');
define('_MYPROFILEMODIFYFIELD',		'Modify an existing field');
define('_MYPROFILEINTROTEXT',		'You can add or modify a custom field for the user\'s profile here.');
define('_MYPROFILEIDENTIFIER',		'Identifier for the field (and the name of the column in the database) or title of the separator (if type is separator)');
define('_MYPROFILEYES',				'Yes');
define('_MYPROFILENO',				'No');
define('_MYPROFILESTRING',			'String');
define('_MYPROFILEINT',				'Integer');
define('_MYPROFILEURL',				'Url');
define('_MYPROFILEFLOAT',			'Float');
define('_MYPROFILEUIN',				'ICQ-UIN');
define('_MYPROFILEAIM',				'ICQ-AIM');
define('_MYPROFILESKYPEID',			'Skype-ID');
define('_MYPROFILETEXTBOX',			'String (multiline)');
define('_MYPROFILEDATE',			'Date');
define('_MYPROFILETIMESTAMP',		'Timestamp');
define('_MYPROFILESEPARATOR',		'Separator');
define('_MYPROFILEMANDATORY',		'Should this field be mandatory');
define('_MYPROFILEDESCRIPTION',		'Description');
define('_MYPROFILEFIELDTYPE',		'Type of this field');
define('_MYPROFILESTRINGLENGTH',	'Maximal length of string');
define('_MYPROFILELIST',			'List (for building a dropdown menu)');
define('_MYPROFILEDROPDOWNEX',		'Example code for dropdown menus: @@value to store||text to show');
define('_MYPROFILEDROPDOWNCODE',	'@@daily||I want the daily newsletter @@monthly||Send a newsletter every month @@no||I do not want to recieve newsletters');
define('_MYPROFILERADIOEX',			'Example code for radiobutton menus: @*value to store||text to show');
define('_MYPROFILERADIOCODE',		'@*0||No @*1||Yes');
define('_MYPROFILEPUBLICSTATUS',	'Public status');
define('_MYPROFILECOPYVALUE',		'Value of this field should be copied into another table\'s column');
define('_MYPROFILECOPYUIDVALUE',	'Identifier for the user\'s id to modify the right row');
define('_MYPROFILEACTIVE',			'Should this field be writeable and shown in the user\'s profile configuration');
define('_MYPROFILESHOWN',			'Should this field be shown on the user\'s profile page that will be generated by this module');
define('_MYPROFILESUBMITFIELD',		'Update / create field');
define('_MYPROFILENOCOPYVALUE',		'do not copy anything');
define('_MYPROFILENOPROTECT',		'This field will be shown to everybody');
define('_MYPROFILEREGONLY',			'Only registered users will be able to see this field\'s value');
define('_MYPROFILEADMINONLY',		'Only the administrator will be able to see this field\'s value');
define('_MYPROFILENUMMINVALUE',		'Minimal value for integer or float');
define('_MYPROFILENUMMAXVALUE',		'Maximal value for integer or float');
define('_MYPROFILEFIELDCREATED',	'New field was created successfully');
define('_MYPROFILEFIELDUPDATED',	'Existing field was updated successfully');
define('_MYPROFILEDELETEFIELD',		'Delete this field');
define('_MYPROFILEFIELDDELERR',		'Error while deleting the fields');
define('_MYPROFILEFIELDDEL',		'Field was deleted successfully');

// plugins
define('_MYPROFILEPLUGINDESC',		'Some modules have plugins for the profile module. For developers: Please take a look at the plugins.txt file in the documentation directory. Found plugins will be used automatically. If you want to remove a plugin delete the directory named myprofile in the folder of the module that provides a special plugin.');
define('_MYPROFILENOPLUGINSFOUND',	'No plugins found!');
?>