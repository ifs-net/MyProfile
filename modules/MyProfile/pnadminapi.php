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
 * Get group configuration
 *
 * This function gets the group configuration it inividualtemplating 
 * is disabled just for some zikula groups
 *
 * @return	array
 */
function MyProfile_adminapi_getGroupsConfiguration()
{
  	$groups = pnModAPIFunc('Groups','user','getall');
  	$individualtemplate_disabledgroups = pnModGetVar('MyProfile','disabledgroups');
  	$individualtemplate_disabledgroups = unserialize($individualtemplate_disabledgroups);
  	$result = array();
  	foreach ($groups as $group) {
  	  	$gid = $group['gid'];
	    if ($individualtemplate_disabledgroups[$gid] == 1) $disabled = 1;
	    else $disabled = 0;
		$result[] = array(	'gid' 		=> $gid, 
							'disabled' 	=> $disabled,
							'name' 		=> $group['name']
							);
	}
	return $result;
}
 
/**
 * Get plugin list
 *
 * @param	$args['uid']	user id to create link (optional)
 * @return	boolean
 */
function MyProfile_adminapi_getPlugins($args)
{
    $mods = pnModGetUserMods();
    foreach ($mods as $mod) {
      	if ($mod['displayname'] != "MyProfile") {
	      	$file_modules	= 'modules/'.$mod['directory'].'/pnmyprofileapi.php';
	      	$file_system	= 'modules/'.$mod['directory'].'/pnmyprofileapi.php';
	      	$found = false;
	      	if (file_exists($file_system)) {
			    $found = true;
			    $file = $file_system;
			}
	      	else if (file_exists($file_modules)) {
	      	  	$found = true;
			    $file = $file_modules;
			}
			if ($found) {
			  	if (pnModAPIFunc($mod['name'],'myprofile','noAjax')) $noAjax = true;
			  	else $noAjax = false;
			  	unset($params);
				if (isset($args['uid']) && $args['uid'] > 0) $params['uid'] = (int)$args['uid'];
			  	// get url add on; module-specific
			  	$add_on = pnModAPIFunc($mod['name'],'myprofile','getURLAddOn');
			  	if (is_array($add_on)) foreach ($add_on as $key=>$value) $params[$key] = $value;
			  	$params_ajax = $params;
			  	$params['pluginname'] = $mod['name'];
			  	$params_ajax['modname'] = $mod['name'];
			  	$params_ajax['ajax'] = 1;
			  	$res[] = array(	
				'dir'		=> $mod['directory'],
				'name'		=> $mod['displayname'],
				'loadname'	=> $mod['name'],
				'link'		=> pnGetBaseURL().pnModURL('MyProfile','user','display',$params),
				'link_ajax'	=> pnGetBaseURL().pnModURL('MyProfile','user','tab',$params_ajax),
				'title'		=> pnModAPIFunc($mod['name'],'myprofile','getTitle'),
				'noajax'	=> $noAjax
										);
			}
		}
	}
	return $res;
}

/**
 * Check if config file is writeable
 *
 * @return	boolean
 */
function MyProfile_adminapi_checkConfigFile()
{
  	$configfile = 'modules/MyProfile/config/tabledef.inc';
  	// if config file does not exist we'll create one
  	Loader::loadClass('FileUtil');
  	if (!file_exists($configfile)) {
	    if (!FileUtil::writeFile($configfile,' ')) {				// create dummy file
		  	LogUtil::registerError(_MYPROFILEWRITEFILEPROBLEMS);
		  	return false;
		};
	}
  	if (!is_readable($configfile)) {								// not readable
	    LogUtil::registerError(_MYPROFILEFILENOTREADABLE);
	    return false;
	}
  	if (!is_writable($configfile)) {								// not writeable
	    LogUtil::registerError(_MYPROFILEFILENOTWRITEABLE);
	    return false;
	}
	return true;
}

/**
 * This function writes the table array so that this array can be included into the pntables array
 *
 * @param  void
 * @return void
 */
function MyProfile_adminapi_updateTableDefinition()
{
	Loader::loadClass('FileUtil');
	$configfile = 'modules/MyProfile/config/tabledef.inc';
	if (file_exists($configfile)) unlink ($configfile);
  	$fields = pnModAPIFunc('MyProfile','admin','getFields');
  	foreach ($fields as $field) if ($field['fieldtype'] != 'SEPARATOR') $datafields[]=$field;
  	if (count($datafields)==0) return false;
  	foreach ($datafields as $field) {
    	// get value for table definition
    	switch ($field['fieldtype']) {
		  	case 'UIN':
			case 'INTEGER': 	$value = "I NOTNULL";break;
		  	case 'TIMESTAMP':	$value = "T NOTNULL";break;
		  	case 'URL':
		  	case 'SKYPEID':
		  	case 'STRING': 	$value = "XL NOTNULL";break;
		  	case 'FLOAT':		$value = "F NOTNULL";break;
		  	case 'DATE':		$value = "D";break;
		  	default: 
		}
    	// construct array
    	$column[] = 	array (	'key'	=> $field['identifier'],
	  							'value'	=> 'MyProfile_'.$field['identifier']);
		$column_def[] = array (	'key'	=> $field['identifier'],
								'value'	=> $value);
	}
  	return FileUtil::writeFile($configfile,serialize(array('column' => $column, 'column_def' => $column_def)));
}

/**
 * get fields for individual template
 *
 * This function returns all fields that should be shown in the user's template
 *
 * @return 	array
 */
function MyProfile_adminapi_getIndividualTemplateFields()
{
	$fields = pnModAPIFunc('MyProfile','admin','getFields');
	$results = array();
	foreach ($fields as $field) {
	  	if (	($field['fieldtype'] != 'SEPARATOR') &&
		  		($field['shown'] == 1) &&
				($field['public_status'] != 2)		) $results[] = $field;
	}
	return $results;
}

/**
 * validate template for mandatory fields
 *
 * This function validates a template if every mandatory field is used there
 *
 * @param	$args['template']	string		the user's template
 * @return 	bool
 */
function MyProfile_adminapi_validateIndividualTemplate($args)
{
	$fields = MyProfile_adminapi_getIndividualTemplateFields();
	$template = $args['template'];
	if (isset($template) && (strlen($template) > 0)) {
		$toreplace1 = array();
		$toreplace2 = array();
		foreach ($fields as $data) {
		  	if ($data['fieldtype'] != 'SEPARATOR') {
				$toreplace1[] = '§'.$data['identifier'].'§';
				$toreplace2[] = 'If you read this you are a fool :-)';
			}
		}
	  	$individualtemplate_content = str_replace($toreplace1,$toreplace2,$template,$count);
	  	if ($count == count($fields)) return true;
	}
	return $false;
}

/**
 * get all myprofile datafields
 * 
 * @param		$args['id']		optional, just get the field with the called id
 * @return   array   array of items, or false on failure
 */
function MyProfile_adminapi_getFields($args)
{
    // Get datbase setup 
    $dbconn =& pnDBGetConn(true);
    $pntable =& pnDBGetTables();

	// check for id
	$id = (int) $args['id'];
	if (isset($id) && ($id>0)) return DBUtil::selectObjectByID('myprofile_fields',$id);

	// create orderby statement
	$orderby = $pntable['myprofile_fields_column']['position'];
	
    $cache = DBUtil::selectObjectArray('myprofile_fields','',$orderby);
    foreach ($cache as $field) {
      	if ($field['list']!='') {
		    $field['dropdownitems'] = MyProfile_adminapi_buildSelection($field['list'],'dropdown');
		    $field['radioitems'] = MyProfile_adminapi_buildSelection($field['list'],'radio');
		}
	  	$fields[]=$field;
	}
    return $fields;
}

/**
 * build list (dropdown or radio))from string
 * 
 * @return   array
 */
function MyProfile_adminapi_buildSelection($list,$type) {
  	if ($type == 'radio') $chars = '@*';
  	else if ($type == 'dropdown') $chars = '@@';
  	else return false;
    if (eregi($chars,$list)) {
		$ra = explode($chars,$list);
		foreach ($ra as $element) {
			$ea = explode('||',$element);
			if ($ea[0]!='') $result[]=array('text'=>$ea[1],'value'=>$ea[0]);
		}
	return $result;
	}
}

/**
 * count separators
 *
 * @return	int
 */
function MyProfile_adminapi_countSeparators() {
	$fields = pnModAPIFunc('MyProfile','admin','getFields');
	$c=0;
	foreach ($fields as $field) if ($field['fieldtype'] == 'SEPARATOR') $c++;
	return $c;
}

/**
 * get order array for noscript ajax fallback ordering the item list
 *
 * @param	$fields		array
 * @return	array
 */
function MyProfile_adminapi_addOrderLinkToFields($args)
{
  	/**
  	 * This function switches the value of two given positions
  	 * in a given array
  	 *
  	 * @param 	$array	array
  	 * @param	$pos1	int
  	 * @param 	$pos2	int
  	 * @return 	array
  	 */
  	function switchArrayElements($array,$pos1,$pos2) {
	    $cache = $array[$pos1];
	    $array[$pos1] = $array[$pos2];
	    $array[$pos2] = $cache;
	    return $array;
	}
	
  	$fields = $args['fields'];
  	if (!isset($fields)) return false;
  	
	// we'll now create an array which contains the array for 
	// moving an element up and down for every element of the list
  	foreach ($fields as $field) $workArray[] = $field['id'];
  	$i=0;
  	foreach ($workArray as $w) {
  	  	// we'll store the array with the id of the entry as key
  	  	$copy = $workArray;
  	  	if ($i!=0) $res[$workArray[$i]]['up'] = switchArrayElements($copy,($i-1),$i);
  	  	if ($i!=count($fields)-1) $res[$workArray[$i]]['down'] = switchArrayElements($copy,$i,($i+1));
	    $i++;
	}
	foreach ($fields as $field) {
	  	$up = $res[$field['id']]['up'];
		if (count($up)>0)$field['orderlink']['up'] = htmlentities(serialize($up));
		$down = $res[$field['id']]['down'];
		if (count($down)>0)$field['orderlink']['down'] = htmlentities(serialize($down));
		$fieldRes[]=$field;
	}
	return $fieldRes;
}

/**
 * store the new order of the fields
 *
 * @param	$args['list']	array
 * @return 	boolan
 */
function MyProfile_adminapi_ajaxSaveList($args) 
{
 	$list = $args['list'];
	if (!isset($list)) return false; 
	foreach ($list as $key=>$value) {
	  	// get item with id "value" and set the new position number "sort" (+1)
	  	$field = pnModAPIFunc('MyProfile','admin','getFields',array('id' => $value));
	  	$field['position'] = $key;
	  	DBUtil::updateObject($field,'myprofile_fields');
	}
	return true;
}

/**
 * import functions
 *
 * @param	$args['source']		string
 * @return void
 */
function MyProfile_adminapi_import($args)
{
  	$step = FormUtil::getPassedValue('step','1');	// first step if no step given
  	if ($step == 2) {
		if (!MyProfile_adminapi_updateTableDefinition()) return LogUtil::registerError(_MYPROFILEUPDATETABLEDEFERROR);
	    else {
		  	pnModSetVar('MyProfile','pnProfileStep',3);
		  	return LogUtil::RegisterStatus(_MYPROFILETABLEDEFUPDATED);
		}
	}
  	else if ($step == 3) {
	    DBUtil::ChangeTable('myprofile');
	  	pnModSetVar('MyProfile','pnProfileStep',4);
	    return LogUtil::RegisterStatus(_MYPROFILETABLESTRUCTUREUPDATED);
	}
  	$uid = pnUserGetVar('uid');
  	if (!isset($args['source'])) return LogUtil::registerError(_MYPROFILENOSOURCEGIVEN);
  	else switch ($args['source']) {
	    case 'pnProfile':
	    	// get pnProfile fields
	    	$fields = pnModAPIFunc('pnProfile','admin','getFields');
	    	if (is_array($fields)) {
	    	  	if ($step == 1) {
	    	  	  	// truncate tables
	    	  	  	DBUtil::truncateTable('myprofile');
	    	  	  	DBUtil::truncateTable('myprofile_fields');
	    	  	  	// go on...
		    	  	$newFields = array();
		    	  	$toConvert = array();
				  	foreach ($fields as $field) {
				  	  	$newField = array (	'identifier'	=> $field['identifier'],
											'mandatory'		=> $field['optional'],
											'description'	=> $field['description'],
											'fieldtype'		=> $field['fieldtype'],
											'list'			=> $field['list'],
											'public_status'	=> $field['public_status'],
											'num_minvalue'	=> '',	// new in MyProfile
											'num_maxvalue'	=> '',	// new in MyProfile
											'str_length'	=> $field['str_length'],
											'position'		=> $field['position'], 	// will be optimized after next manual position change
											'active'		=> $field['active'],
											'shown'			=> $field['shown']
											);
						// some things need to be converted...
						if ($newField['mandatory'] == 1) $newField['mandatory'] = 0;
						else $newField['mandatory'] = 1;
						$newFields[]=$newField;
						$toConvert[]=$newField['identifier'];
						unset($newField);
					}
					// insert the new objects...
					if (!DBUtil::InsertObjectArray($newFields,'myprofile_fields')) return logUtil::registerError(_MYPROFILEFIELDSIMPORTERROR);
					else {
					  	pnModSetVar('MyProfile','pnProfileStep',2);
					  	return LogUtil::registerStatus(_MYPROFILESTRUCTUREUPDATED);
					}
				}
				else if ($step == 4){
    				$fields = pnModAPIFunc('pnProfile','admin','getFields');
    				foreach ($fields as $field) {
					  	$keys[]=$field['identifier'];
					}
					// now go on and get the transformed profile data
					$pnProfileUsers = pnSessionGetVar('pnProfileUsers');
					if (!is_array($pnProfileUsers) || (!count($pnProfileUsers) > 0)) {
					  	$dummy = DBUtil::selectObjectArray('pnprofile');
					  	$pnProfileUsers = array();
					  	foreach ($dummy as $d) $pnProfileUsers[]=$d['uid'];
					  	pnSessionSetVar('pnProfileUsers',$pnProfileUsers);
		    	  	  	// truncate table - if a migration failed before there might be content in a table
		    	  	  	DBUtil::truncateTable('myprofile');
		    	  	  	
					}
					// we will do exactly 500 for each step
					$c=0;
					while (is_array($pnProfileUsers) && (count($pnProfileUsers) > 0)) {
					  	$pnProfileUser = (int)array_pop($pnProfileUsers);
					  	// get profile
					  	$res = pnModAPIFunc('pnProfile','user','getProfile',array('uid' => $pnProfileUser));
					  	unset($newitem);
					  	$newitem['id'] = $pnProfileUser;
					  	foreach ($keys as $key) {
						    $newitem[$key] = $res[$key]['value'];
						}
						$newitems[]=$newitem;
						$c++;
						if ($c == 500) break;
					}
					// now insert object Array into myprofile table
					$res = DBUtil::insertObjectArray($newitems,'myprofile',false,true);
					// update session variable
				    pnSessionSetVar('pnProfileUsers',$pnProfileUsers);
					// set step to finished... 
				  	if (!is_array($pnProfileUsers) || (count($pnProfileUsers) == 0)) {
						pnSessionDelVar('pnProfileUsers');
					    pnModSetVar('MyProfile','pnProfileStep',5);
						return LogUtil::registerStatus(_MYPROFILEIMPORTSUCCESSFULL.' '.$c.' '._MYPROFILEITEMSIMPORTES);
					}
				  	else {
						return LogUtil::registerStatus(_MYPROFILEIMPORTSTEPSUCCESSFULL.' '.$c.' '._MYPROFILEITEMSIMPORTES.", "._MYPROFILEABOUT." ".(int)count($pnProfileUsers)." "._MYPROFILELEFT);
					}
				}
			}
			else return LogUtil::registerError(_MYPROFILEPNPROFILECONFUNREADABLE);
	    	break;
	    case 'Profile':
	    	die("Profile migration function will follow - perhaps :-)");
	    	$vars = pnUserGetVars($uid);
	    	// we need every variable beginning with an "_" character
	    	
	    	$optionalitems = pnModAPIFunc('Users','user','optionalitems');
	    	
	    	print_r($optionalitems);
	    	print "<hr>";
	    	prayer($optionalitems);
	    	die();
			// data types from the Profil module:
			// 1 = string
			// 2 = text
			// 3 = float
			// 4 = int
			// viewBy
			// (none) = everybody
			// 1 = registered only
			// 2 = admin only
			// displayType
			// 0 = text box
			// 1 = text area
			// 2 = checkbox
			// 3 = radio buttn
			// 4 = dropdown list
			// 5 = calendar
			// 6 = date (extended)
			// 7 = combo box (ext)
				    	
	    	break;
	    default:
	    	LogUtil::registerError(_MYPROFILEINVALIDSOURCE);
	    	break;
	}
}

/**
 * garbage collector / consistence check
 *
 * @return array
 */
function MyProfile_adminapi_getOrphans($args)
{
  	// get all items
  	$objArray = DBUtil::selectObjectArray('myprofile');
  	$res = array();
  	$delete = false;
  	$action = FormUtil::GetPassedValue('action');
  	if (isset($action) && ($action == "delete") && (SecurityUtil::confirmAuthKey())) $delete = true;
  	foreach ($objArray as $obj) {
	    if (!(strlen(pnUserGetVar('uname',$obj['id'])) > 0)) {
			$res[] = array ('id' => $obj['id']);
			DBUtil::deleteObject($obj,'myprofile');
		}
	}
	if ($delete) {
	  	LogUtil::registerStatus(_MYPROFILECLEANEDUP);
	  	return array();
	}
	else return $res;
}

?>