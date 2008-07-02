<?php
// menu
define('_MYPROFILEMAIN',					'main backend page');
define('_MYPROFILEACTUALCONFIG',			'MyProfile configuration');
define('_MYPROFILEFINDORPHANS',				'check consistence');
define('_MYPROFILEPLUGINS',					'plugins');
define('_MYPROFILEIMPORTFUNCS',				'migration');

// import
define('_MYPROFILEIMPORTDESC',				'You find some import functions here to get data from other profile modules');
define('_MYPROFILEPNPROFILEIMPORT',			'Import data from pnProfile');
define('_MYPROFILEPNPROFILEAV',				'pnProfile module is available on your system. If you want to import data from this module to use it in the MyProfile module you can do this here. If you used a database dump to reconstruct pnProfile data make sure, that you also need the Users tables - not only the pnProfile tables are important!');
define('_MYPROFILEPNPROFILENOTAV',			'pnProfile is not available on your system. No import possible.');
define('_MYPROFILEPROFILEIMPORT',			'Import data from Profile');
define('_MYPROFILEPROFILEAV',				'Profile module found on your system. You can import all data from Profile module into MyProfile.');
define('_MYPROFILEOVERWRITECONF',			'Attention: Importing data from this module will erase an existing MyProfile configuration before importing Profile data into MyProfile.');
define('_MYPROFILEPROFILENOTAV',			'The regular Profile module could not be found on your system. No Import possible.');
define('_MYPROFILEIMPORTDATA',				'Start import now');
define('_MYPROFILENOSOURCEGIVEN',			'Parameter is missing: no source given');
define('_MYPROFILEINVALIDSOURCE',			'Parameter error: invalid source given');
define('_MYPROFILEPNPROFILECONFUNREADABLE',	'pnProfile configuration could not be read');
define('_MYPROFILEFIELDSIMPORTERROR',		'An error occured importing the pnProfile configuration');
define('_MYPROFILEUPDATETABLEDEFERROR',		'An error occured while trying to update the table definition');
define('_MYPROFILEIMPORTSUCCESSFULL',		'Import done');
define('_MYPROFILEITEMSIMPORTES',			'items imported');
define('_MYPROFILETRUNCATEMYPROFILETABLES',	'If you have already configured MyProfile your configuration will be lost! Also values users might have entered already will be lost! Merging is not supported!');
define('_MYPROFILEIMPORTSTRUCTURE',			'import pnProfile structure');
define('_MYPROFILEUPDATETABLES',			'update table');
define('_MYPROFILEIMPORTPROFILEDATA',		'import pnProfile data into MyProfile');
define('_MYPROFILEUPDATETABLEDEFS',			'update table definition');
define('_MYPROFILETABLESTRUCTUREUPDATED',	'Table structure updated');
define('_MYPROFILETABLEDEFUPDATED',			'Table definition updated successfully');
define('_MYPROFILESTRUCTUREUPDATED',		'pnProfile structure imported into MyProfile');
define('_MYPROFILEPOSSIBLETIMEOUT',			'If you have a huge pnProfile database the update might break if the memory limit or the timeout is set to low. If the update breaks, raise your memory limit and the php maximum execution time and try this step again until it works! Also do not run any other processes you do not need when importing the database.');
define('_MYPROFILEPNPROFILEMIGRATIONDONE',	'Migration from pnProfile to MyProfile already done');
define('_MYPROFILERESETMIGRATION',			'Migration failed');
define('_MYPROFILERESETSTEPSNOW',			'Reset migration and start with first step again');
define('_MYPROFILESTEPSRESETDONE',			'pnProfile migration reset done');
// findorphans / consistence check
define('_MYPROFILECONSISTENCECHECKDESC',	'This function checks the consistency of your MyProfile database. This check might be neccessary, if you allow your user\'s to delete their accounts themself or if your delete users using the function the Users module offers you. In this case, old data might still be stored in the MyProfile tables. This function is the "garbage collector" for this module.');
define('_MYPROFILEYOUHAVE',					'You have');
define('_MYPROFILECLEANUP',					'Clean up database');
define('_MYPROFILEORPHANS',					'orphans');
define('_MYPROFILECLEANEDUP',				'Database was cleaned up');
define('_MYPROFILECONSISTENCEOK',			'Database already optimized');

// main
define('_MYPROFILEBACKEND',					'MyProfile backend configuration');
define('_MYPROFILEBACKENDDESCR',			'This is the backend for the MyProfile module. First step for the admin should be the creation of a profile configuration. Have a lot of fun with this module!');
define('_MYPROFILEREQUESTBANINDAYS',		'Time between to validation code requests to change an email address as user');
define('_MYPROFILESUPPORTMYPROFILE',		'Support the MyProfile module');
define('_MYPROFILEDONATETHIS',				'Donate with PayPal!');
define('_MYPROFILEDONATE',					'You like this module and it is usefull for you? Thank you for some little donation for the programmer! OK - I like programming very much and this module is free and open source - but if you spend some money I\'ll go out for a nice candlelight dinner with my girlfriend and it will be much easier next time to get free time for programming ;-)');
define('_MYPROFILEDIRECTPROFILEEDIT',		'As an administrator you can directly access and modify other profiles. Even if you modify a profile as an administrator, the date of the last update of the profile will be set to today\'s date. You should inform your user about everything you change in his profile!');
define('_MYPROFILEEXPIREDAYS',				'Amount of days the validation code has until getting invalid');
define('_MYPROFILEEDITPROFILE',				'Modify existing user profiles');
define('_MYPROFILEEDITUNAME',				'Just enter the username...');
define('_MYPROFILEEDITUID',					'or the user\'s ID...');
define('_MYPROFILEEDITPROFILETHEN',			'... and edit the user\'s profile');
define('_MYPROFILENNOTYPECHANGESLATER',		'Due to some technical and logical reasons the type and identifier of a regular field can not be changed after the field was created.');
define('_MYPROFILEMAKEPROFILEMANDATORY',	'Make it mandatory for every user to have a valid profile');
define('_MYPROFILEMAKEPROFILEMANDATORYCODE','If you want every member of your website to have a valid profile you have to include the following code into your theme templates. The function that is called with this code checks if the actual logged in user has a profile. If there is no profile found the user will be redirected to the form to fill out the complete user profile. This will only be applied if the member is not an administrator of MyProfile module.');
define('_MYPROFILEDATEFORMAT',				'Date format that should be used when dates as registration date, last login date etc. are showed in the user\'s profile page');
//feature request: to be removed if accepted 	define('_MYPROFILEUSELASTSEEN',		'Display "last seen" date as last login date');
//feature request: to be removed if accepted 	define('_MYPROFILELASTSEENTEXT',	'The CMS can store (after activating this feature in the Users module) the date of the last login in the users variable "lastlogin". This variable will be included in a user\'s profile page. But if your security level is not set to "hight", your users do not have to log in each time - they will stay logged in some days or even months and the last login date will be very different from the last seen date when the user did his last activity on your site. To fix this "bug", just add the following line into the index.php in your root folder at line 25 before the line "// Get Variables" begins:');
//main, settings
define('_MYPROFILEGLOBALETTINGS',			'General module settings');
define('_MYPROFILENOTABS',					'Do not use the "tab"-mode (Javscript/CSS-Tabs)');
define('_MYPROFILESAVECFG',					'Update configuration');
define('_MYPROFILECFGSTORED',				'Configuration updated successfully');
define('_MYPROFILENOVERIFICATION',			'Do not verify new stored email addresses with an verification email and a verification code');

// editProfile
define('_MYPROFILEUNOTFOUND',				'No user with this username or user-ID found');
define('_MYPROFILEFILENOTWRITEABLE',		'Config file is not writeable - change this before trying to edit the actual configuration');
define('_MYPROFILEFILENOTREADABLE',			'Config file is not readable - change this before trying to edit the actual configuration');
define('_MYPROFILEWRITEFILEPROBLEMS',		'Config file could not be created - please check the config directory permissions');

// configFailure
define('_MYPROFILEERROROCCURED',			'An error occured. Please regard the error message!');
define('_MYPROFILECFGDIREXIST',				'A directory inside the MyProfile module named "config" must exist');
define('_MYPROFILECFGDIRWRITABLE',			'This directory has to be writable by the webserver');
define('_MYPROFILECFGFILENAME',				'In this directory a file called tabledef.inc will be created by the module');
define('_MYPROFILECFGREADABLE',				'This file has to be readable by the webserver');
define('_MYPROFILECFGWRITABLE',				'This file has to be writable by the webserver');
define('_MYPROFILEPROCEED',					'Try again and proceed');

// fields configuration
define('_MYPROFILECONFIGURATION',			'Your profile\'s configuration');
define('_MYPROFILEREDIRECTFACC',			'It is possible to redirect functional accounts (administrator accounts etc.). Just enter the id values of the accounts you want to mark as functional accounts. Please separate each id with a comma.');
define('_MYPROFILEISOPTIONAL',				'optional field');
define('_MYPROFILEISMANDATORY',				'mandatory field');
define('_MYPROFILEALL',						'viewable by everybody');
define('_MYPROFILEREG',						'viewable by registered users only');
define('_MYPROFILEADMIN',					'viewable by admin users only');
define('_MYPROFILECHARS',					'characters');
define('_MYPROFILEISACTIVE',				'Activated');
define('_MYPROFILEISSHOWN',					'shown');
define('_MYPROFILEEXISTINGFIELDS',			'Manage the existing fields');
define('_MYPROFILEMANAGEHOWTO',				'If you want to change the order just click on the box and move the item to the position you want it to be. Settings will be stored automatically!');
define('_MYPROFILEEDIT',					'modify this field');
define('_MYPROFILEADDSEPARATOR',			'Add a separator bar');
define('_MYPROFILEMOVEUP',					'Move up');
define('_MYPROFILEMOVEDOWN',				'Move down');
define('_MYPROFILEELEMENTMOVED',			'Element was moved successfully');

// configuration, ajax interface
define('_MYPROFILESTOREDAT',				'New order was saved successfully at');

// add a new field or modify an existing one
define('_MYPROFILEADDNEWFIELD',				'Add a new field');
define('_MYPROFILEMODIFYFIELD',				'Modify an existing field');
define('_MYPROFILEINTROTEXT',				'You can add or modify a custom field for the user\'s profile here.');
define('_MYPROFILEIDENTIFIER',				'Identifier for the field (and the name of the column in the database) or title of the separator (if type is separator)');
define('_MYPROFILEYES',						'Yes');
define('_MYPROFILENO',						'No');
define('_MYPROFILESTRING',					'String');
define('_MYPROFILEINT',						'Integer');
define('_MYPROFILEURL',						'Url');
define('_MYPROFILEFLOAT',					'Float');
define('_MYPROFILEUIN',						'ICQ-UIN');
define('_MYPROFILEAIM',						'ICQ-AIM');
define('_MYPROFILESKYPEID',					'Skype-ID');
define('_MYPROFILETEXTBOX',					'String (multiline)');
define('_MYPROFILEDATE',					'Date');
define('_MYPROFILETIMESTAMP',				'Timestamp');
define('_MYPROFILESEPARATOR',				'Separator');
define('_MYPROFILEMANDATORY',				'Should this field be mandatory');
define('_MYPROFILEDESCRIPTION',				'Description');
define('_MYPROFILEFIELDTYPE',				'Type of this field');
define('_MYPROFILESTRINGLENGTH',			'Maximal length of string');
define('_MYPROFILELIST',					'List (for building a dropdown menu)');
define('_MYPROFILEDROPDOWNEX',				'Example code for dropdown menus: @@value to store||text to show');
define('_MYPROFILEDROPDOWNCODE',			'@@daily||I want the daily newsletter @@monthly||Send a newsletter every month @@no||I do not want to recieve newsletters');
define('_MYPROFILERADIOEX',					'Example code for radiobutton menus: @*value to store||text to show');
define('_MYPROFILERADIOCODE',				'@*0||No @*1||Yes');
define('_MYPROFILEPUBLICSTATUS',			'Public status');
define('_MYPROFILECOPYVALUE',				'Value of this field should be copied into another table\'s column');
define('_MYPROFILECOPYUIDVALUE',			'Identifier for the user\'s id to modify the right row');
define('_MYPROFILEACTIVE',					'Should this field be writeable and shown in the user\'s profile configuration');
define('_MYPROFILESHOWN',					'Should this field be shown on the user\'s profile page that will be generated by this module');
define('_MYPROFILESUBMITFIELD',				'Update / create field');
define('_MYPROFILENOCOPYVALUE',				'do not copy anything');
define('_MYPROFILENOPROTECT',				'This field will be shown to everybody');
define('_MYPROFILEREGONLY',					'Only registered users will be able to see this field\'s value');
define('_MYPROFILEADMINONLY',				'Only the administrator will be able to see this field\'s value');
define('_MYPROFILENUMMINVALUE',				'Minimal value for integer or float');
define('_MYPROFILENUMMAXVALUE',				'Maximal value for integer or float');
define('_MYPROFILEFIELDCREATED',			'New field was created successfully');
define('_MYPROFILEFIELDUPDATED',			'Existing field was updated successfully');
define('_MYPROFILEDELETEFIELD',				'Delete this field');
define('_MYPROFILEFIELDDELERR',				'Error while deleting the fields');
define('_MYPROFILEFIELDDEL',				'Field was deleted successfully');

// plugins
define('_MYPROFILEPLUGINDESC',				'Some modules have plugins for the profile module. For developers: Please take a look at the plugins.txt file in the documentation directory. Found plugins will be used automatically. If you want to remove a plugin delete the directory named myprofile in the folder of the module that provides a special plugin.');
define('_MYPROFILENOPLUGINSFOUND',			'No plugins found!');
?>