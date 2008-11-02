<?php
/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schießl
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
 
// header
define('_MYPROFILEUSERMENU',				'User\'s menu');
define('_MYPROFILEMAINPROFILEDATA',			'my profile data');
define('_MYPROFILEMAILANDPASSWORD',			'email address, password and extended settings');
define('_MYPROFILESEARCHMEMBERS',			'search members');

// main
define('_MYPROFILEVIEWABLEBY',				'Viewable for');
define('_MYPROFILEPRIVATEFIELD',			'Private field, only viewable by users you allow to access this data');
define('_MYPROFILEPROFILEOF',				'Profile of user');
define('_MYPROFILEMYPROFILE',				'My profile');
define('_MYPROFILESAVE',					'save / update');
define('_MYPROFILEMYPROFILEDATA',			'Manage your community profile');
define('_MYPROFILEMANAGEYOURDATA',			'Please fill the form with your input. Every field that is marked with this sign: * is mandatory.');
define('_MYPROFILEHOWTOUSETABS',			'Please click on the tabs above this text to get to the separated sections to manage your profile data. Please click the "save"-Button only if the profile is completely filled out!');
define('_MYPROFILESHOWWALLTABS',			'Show all tabs on one page');
define('_MYPROFILETABMODE',					'Switch to the "tab"-mode');
define('_MYPROFILECREATED',					'The profile was created successfully');
define('_MYPROFILEFIELDUPDATED',			'Your profile data was updated successfully');
define('_MYPROFILESHOWMYPROFILE',			'Show my own profile page');
define('_MYPROFILEADDPROFILEFAILED',		'Creating / Updating profile failed');
define('_MYPROFILEATTRIBUTESTOREERROR',		'Updating / creating user attributes failed');
define('_MYPROFILELNG',						'Longitude');
define('_MYPROFILELAT',						'Latitude');

// search
define('_MYPROFILEMEMBERLISTDESC',			'If you just click the search button without any search parameters you will get the whole member list displayed');
define('_MYPROFILEPAGE',					'Page');
define('_MYPROFILENOTHINGSEARCHABLE',		'There are no more searchable fields or you do not have the permission to view these fields');
define('_MYPROFILESEARCH',					'Search');
define('_MYPROFILEORDERBY',					'Sort result by');
define('_MYPROFILESEARCHINTRO',				'You can now use the following form to search for other users. The more fields you fill out the less results you will get.');
define('_MYPROFILESEARCHTYPE',				'Search type');
define('_MYPROFILESOFT',					'soft');
define('_MYPROFILEEXACT',					'exact');
define('_MYPROFILESEARCHTYPEDESC',			'Using the search type "soft" and searching for "sun" you will also get results like "sunset" too because the searched word is in it. If you do not want to use this select "exact" as search type!');
define('_MYPROFILEORUSED',					'Choosing more than one item will link them using OR');
define('_MYPROFILECONNECTOR',				'Connector for search logic');
define('_MYPROFILEAND',						'AND');
define('_MYPROFILEOR',						'OR');
define('_MYPROFILEDESC',					'DESC');
define('_MYPROFILEASC',						'ASC');
define('_MYPROFILEFOUND',					'Found');
define('_MYPROFILERESULTS',					'results');
define('_MYPROFILERESULT',					'result');
define('_MYPROFILESHOWSEARCHFORM',			'Show search form to change search parameters');
define('_MYPROFILENEXTPAGE',				'next page');
define('_MYPROFILEPREVIOUSPAGE',			'previous page');

// confirmedusers
define('_MYPROFILEUSERDELETED',				'User deleted');
define('_MYPROFILEDELETE',					'delete User');
define('_MYPROFILEERRORDELETINGUSER',		'An error occured while trying to delete the user');
define('_MYPROFILEMANAGETRUSTLIST',			'Manage users that can see your private data');
define('_MYPROFILEADDUSER',					'Add a new user to your list');
define('_MYPROFILEUNAME',					'Username');
define('_MYPROFILEADD',						'add');
define('_MYPROFILEYOURLIST',				'Your list');
define('_MYPROFILENOENTRY',					'No entry was made yet');
define('_MYPROFILEUSERADDED',				'User was added to the list');
define('_MYPROFILEUSERADDERROR',			'An error occured while trying to add the user to your list');
define('_MYPROFILEUSERALREADYADDED',		'The user is already listed in your list');
define('_MYPROFILEDONOTADDYOURSELF',		'I hope you trust yourself, but you cannot add your own username to your list');
define('_MYPROFILEUSERNOTFOUND',			'The username you specified does not exist');

// display
define('_MYPROFILEOVERRIDETEMPLATE',		'Override individual profile template');
define('_MYPROFILENOACCESS',				'Sorry, no authorisation');
define('_MYPROFILENOINDIVIDUALPERMISSION',	'The main profile part is not accessible by you');
define('_MYPROFILESENDPM',					'Send private message');
define('_MYPROFILEADDASBUDDY',				'Add as buddy');
define('_MYPROFILENOPERMISSION',			'no permission to view this field');
define('_MYPROFILEREGSINCE',				'Registerd since');
define('_MYPROFILELASTLOGIN',				'Last login');
define('_MYPROFILELASTUPDATE',				'Last update');
// display plugins
define('_MYPROFILE_USERPICTURES_PICSINGALLERY',	'User\'s gallery');
define('_MYPROFILE_USERPICTURES_PICTURES',	'picture(s)');
define('_MYPROFILE_USERPICTURES_LINKEDIN',	'User linked at');
define('_MYPROFILE_USERPICTURES_EXTERNAL',	'external');
define('_MYPROFILE_USERPICTURES_THEREFROM',	'therefrom');
// display invaid
define('_MYPROFILEPROFILENOTFOUND',			'This profile page cannot be displayed');
define('_USERPICTURESINVALIDEXPLANATION',	'The user does not exist or there is no vaid profile available for this user yet.');
define('_USERPICTURESBACKTOLASTPAGE',		'Go back one page');

// settings
define('_MYPROFILEMANAGECONFIRMEDUSERS',	'Manage users that are allowed to view all my data that is declared as private');
define('_MYPROFILECUSTOMSETTINGS',			'Profile data fields that are marked as private should be viewable by');
define('_MYPROFILETEMPLATEINCLUDEMANDATORY','You have to include all mandatory profile variables into your individual template');
define('_MYPROFILEINDIVIDUALTEMPLATEHINTS',	'Some hints to create your own template');
define('_MYPROFILEMYPROFILEMYTEMPLATE',		'Use an individual template');
define('_MYPROFILEWILLBEREPLACEDWITH',		'will be replaced with');
define('_MYPROFILETEMPALTEUSEWHATYOUWANT',	'The individual profile tempalte can be designed in HTML');
define('_MYPROFILETEMPALTEVARREPLACEMENTS',	'The use of the following words (bold printed) will cause a replacement with your profile data - with * marked variables are mandatory and have to be used in your template');
define('_MYPROFILEMYPROFILEVISIBLEFOR',		'My profile page should be accessable by');
define('_MYPROFILEALL',						'everybody');
define('_MYPROFILEMEMBERS',					'all members');
define('_MYPROFILEBUDDIES',					'confirmed buddies');
define('_MYPROFILEADMIN',					'administrators');
define('_MYPROFILELISTEDUSERSONLY',			'only listed users');
define('_MYPROFILEYOURSETTINGS',			'Here you can define some custom settings for your profile');
define('_MYPROFILENOCOMMENTS',				'Do not allow other users to comment my profile');
define('_MYPROFILESETTINGSUPDATED',			'Settings updated successfully');
define('_MYPROFILENEWPASS',					'If you want to change your password enter the new one');
define('_MYPROFILENEWPASSAGAIN',			'and repeat the new password please');
define('_MYPROFILEGENERALSETTINGS',			'General settings');
define('_MYPROFILEPASSWORDSETTINGS',		'Manage your password');
define('_MYPROFILECHANGEMAIL',				'Change email address');
define('_MYPROFILEEMAILADDRESS',			'New email address');
define('_MYPROFILEPASSWORDCHANGED',			'Your password was changed successfully');
define('_MYPROFILEPASSWORDSINCORRECT',		'The new password was not entered twice the same way - there might be a typo in a password - password was not changed');
define('_MYPROFILEPWDTOOSHORT',				'The new password is too short');
define('_MYPROFILEMAILCHANGEREQUEST',		'An verification email with further instructions has been sent to your new email address.');
define('_MYPROFILEMAILCHANGEREQUESTERROR',	'An error occured while trying to send an verification code to your new, entered email address');
define('_MYPROFILEEMAILCHANGED',			'Your email address was updated successfully');
define('_MYPROFILEEMAILCHANGEERROR',		'An error occured while trying to change your email address');
define('_MYPROFILENONEWREQUESTBEFORE',		'You can not request a new validation code before');
define('_MYPROFILEENTERVALIDATIONCODE',		'Enter verification code for new email address');

// validation code email
define('_MYPROFILEVALIDATIONCODEFOR',		'Email verification code for');
define('_MYPROFILEAT',						'at');
define('_MYPROFILEEMAILCHANGEREQUEST',		'You requested to change your email address at');
define('_MYPROFILEACTIVATESTEPS',			'To activate your new email address click the following link please');
define('_MYPROFILEIFLINKBROKEN',			'If this link is broken use the following website and enter your verification code there');
define('_MYPROFILEVALIDUNTIL',				'This code is valid until');
define('_MYPROFILEORNEWREQUEST',			'or up to a new request by yourself');
define('_MYPROFILENORESPONSE',				'Please do not respond to this automatically created email - contact the website administrator if there are any problems');
define('_MYPROFILEENTERDATA',				'To use the alternate URL you have to enter the following data');
// validate
define('_MYPROFILEVALIDATEEMAILADDRESS',	'Enter verification code to activate new email address');
define('_MYPROFILEVALIDATIONCODE',			'Verification code (25 characters)');
define('_MYPROFILEUSERID',					'Your user ID');
define('_MYPROFILEACTIVATENEWMAIL',			'Activate new email address');
define('_MYPROFILENOUSERDATAFOUND',			'No user data found');
define('_MYPROFILEINVALIDCODE',				'Verification code is no longer valid - you should start a new request for a new verification code');
define('_MYPROFILEINCORRECTCODE',			'Verification code incorrect');

// account panel
define('_MYPROFILEPROFILEDATA',				'My profile data');
define('_MYPROFILEPASSWORD',				'My password');
define('_MYPROFILEMAILADDRESS',				'My email address');

// display
define('_MYPROFILEMAINPROF',				'User\'s main profile');

// check for account plugin
define('_MYPROFILEPLEASECREATEACCOUNTFIRST','Please fill out your personal profile first. This is neccessary before you can interact in this community!');
?>