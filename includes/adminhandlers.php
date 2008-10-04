<?php
/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schießl
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
 
class MyProfile_admin_addFieldHandler
{
    var $id;
    function initialize(&$render)
    {
		$this->id = (int)FormUtil::getPassedValue('id');
		if ($this->id > 0) {
			$data = DBUtil::selectObjectByID('myprofile_fields', $this->id);
			$render->assign($data);
		}
		// create dropdown fields
		$items_yesno = array (			array('text' => _MYPROFILENO,		'value' => 0),
										array('text' => _MYPROFILEYES,		'value' => 1) );
		$items_fieldtype = array (		
										array('text' => _MYPROFILESEPARATOR,'value' => 'SEPARATOR'),
										array('text' => _MYPROFILESTRING,	'value' => 'STRING'),
										array('text' => _MYPROFILEINT,		'value' => 'INTEGER'),
										array('text' => _MYPROFILEFLOAT,	'value' => 'FLOAT'),
										array('text' => _MYPROFILETEXTBOX,	'value' => 'TEXTBOX'),
										array('text' => _MYPROFILEURL,		'value' => 'URL'),
										array('text' => _MYPROFILEUIN,		'value' => 'UIN'),
										array('text' => _MYPROFILESKYPEID,	'value' => 'SKYPEID'),
										array('text' => _MYPROFILEDATE,		'value' => 'DATE'),
										array('text' => _MYPROFILETIMESTAMP,'value' => 'TIMESTAMP'),
										array('text' => _MYPROFILECOORD,	'value' => 'COORD') );
		$items_public_status = array (	array('text' => _MYPROFILENOPROTECT,'value' => 0),
										array('text' => _MYPROFILEREGONLY,	'value' => 1),
										array('text' => _MYPROFILEADMINONLY,'value' => 2),
										array('text' => _MYPROFILECUSTOM,	'value' => 9) );
		$render->assign('items_yesno',			$items_yesno);
		$render->assign('items_fieldtype',		$items_fieldtype);
		$render->assign('items_public_status',	$items_public_status);
		
		// assign default values
		$render->assign('mandatory',1);
		$render->assign('public_status',1);
		$render->assign('active',1);
		$render->assign('shown',1);
		return true;
    }
    function handleCommand(&$render, &$args)
    {
		if ($args['commandName']=='update') {
		    // Security check 
		    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_ADMIN)) return LogUtil::registerPermissionError();

			// get the pnForm data and do a validation check
		    $obj = $render->pnFormGetValues();		    
		    
		    // delete the field?
		    if ($obj['deletefield'] == "1") {
		      	if ($obj['fieldtype']!='SEPARATOR') 
				  	if (!DBUtil::dropColumn('myprofile','MyProfile_'.$obj['identifier'])) {
						logUtil::registerError(_MYPROFILEFIELDDELERR);
						return false;
					}
			  	if (DBUtil::deleteObjectByID('myprofile_fields',$this->id)) {
			  	  	logUtil::registerStatus(_MYPROFILEFIELDDEL);
			  	  	pnModAPIFunc('MyProfile','admin','updateTableDefinition');
			  	  	return pnRedirect(pnModURL('MyProfile','admin','fields'));
			  	}
				else logUtil::registerError(_MYPROFILEFIELDDELERR);
		    }
		    if (!$render->pnFormIsValid()) return false;
		    if ($this->id > 0) $obj['id']=$this->id;

		    if ($this->id > 0) {	// an field just has to be updated
		      	$result = DBUtil::updateObject($obj, 'myprofile_fields');
		      	if ($result) LogUtil::registerStatus(_MYPROFILEFIELDUPDATED);
			}
			else {	// field has to be inserted as new field.
			  	$fields = pnModAPIFunc('MyProfile','admin','getFields');
			  	$obj['position']= count($fields);
			  	// remove blanks if needed
			  	if ($obj['fieldtype'] != 'SEPARATOR') {
				    $obj['identifier'] = str_replace(' ','_',$obj['identifier']);
				}
				DBUtil::insertObject($obj, 'myprofile_fields');
				LogUtil::registerStatus(_MYPROFILEFIELDCREATED);
			}
			return pnRedirect(pnModURL('MyProfile','admin','update'));
		}
		return true;
    }
}

class MyProfile_admin_settingsHandler
{
    function initialize(&$render)
    {
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
?>