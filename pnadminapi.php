<?php
/**
 * Check if config file is writeable
 *
 * @return	boolean
 */
function MyProfile_adminapi_getPlugins()
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
			if ($found) $res[] = array(	
				'dir'		=> $mod['directory'],
				'name'		=> $mod['displayname'],
				'loadname'	=> $mod['name'],
				'link'		=> pnModURL('MyProfile','user','tab',array('modname'=>$mod['name'],'ajax'=>'1')),
				'title'		=> pnModAPIFunc($mod['name'],'myprofile','getTitle'),
										);
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
?>