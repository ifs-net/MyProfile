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
        $dom = ZLanguage::getModuleDomain('MyProfile');
		$this->id = (int)FormUtil::getPassedValue('id');
		if ($this->id > 0) {
			$data = DBUtil::selectObjectByID('myprofile_fields', $this->id);
			$render->assign($data);
		}
		else {
			// assign default values
			$render->assign('mandatory',1);
			$render->assign('public_status',1);
			$render->assign('active',1);
			$render->assign('shown',1);
			$render->assign('searchable',1);
		}
		// create dropdown fields
		$items_yesno = array (			array('text' => __('No', $dom),                   'value' => 0),
										array('text' => __('Yes', $dom),                  'value' => 1) );
		$items_fieldtype = array (		
										array('text' => __('Separator', $dom),            'value' => 'SEPARATOR'),
										array('text' => __('String', $dom),	              'value' => 'STRING'),
										array('text' => __('Integer', $dom),              'value' => 'INTEGER'),
										array('text' => __('Float', $dom),                'value' => 'FLOAT'),
										array('text' => __('String (multiline)', $dom),   'value' => 'TEXTBOX'),
										array('text' => __('Url', $dom),                  'value' => 'URL'),
										array('text' => __('ICQ-UIN', $dom),              'value' => 'UIN'),
										array('text' => __('Skype-ID', $dom),             'value' => 'SKYPEID'),
										array('text' => __('Date', $dom),                 'value' => 'DATE'),
										array('text' => __('Timestamp', $dom),            'value' => 'TIMESTAMP'),
										array('text' => __('Coordinate', $dom),	          'value' => 'COORD') );
		$items_public_status = array (	array('text' => __('This field will be shown to everybody', $dom),                              'value' => 0),
										array('text' => __('Only registered users will be able to see this field\'s value', $dom),	    'value' => 1),
										array('text' => __('Only the administrator will be able to see this field\'s value', $dom),     'value' => 2),
										array('text' => __('The user can choose who should be able to see this field\'s value', $dom),	'value' => 9) );
		$render->assign('items_yesno',			$items_yesno);
		$render->assign('items_fieldtype',		$items_fieldtype);
		$render->assign('items_public_status',	$items_public_status);
		
		return true;
    }
    function handleCommand(&$render, &$args)
    {
        $dom = ZLanguage::getModuleDomain('MyProfile');
		if ($args['commandName']=='update') {
		    // Security check 
		    if (!SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_ADMIN)) return LogUtil::registerPermissionError();

			// get the pnForm data and do a validation check
		    $obj = $render->pnFormGetValues();		    
		    
		    // delete the field?
		    if ($obj['deletefield'] == "1") {
		      	if ($obj['fieldtype']!='SEPARATOR') 
				  	if (!DBUtil::dropColumn('myprofile','MyProfile_'.$obj['identifier'])) {
						logUtil::registerError(__('Error while deleting the fields', $dom));
						return false;
					}
			  	if (DBUtil::deleteObjectByID('myprofile_fields',$this->id)) {
			  	  	logUtil::registerStatus(__('Field was deleted successfully', $dom));
			  	  	pnModAPIFunc('MyProfile','admin','updateTableDefinition');
			  	  	return pnRedirect(pnModURL('MyProfile','admin','fields'));
			  	}
				else logUtil::registerError(__('Error while deleting the fields', $dom));
		    }

		    // check if the form was filled correctly
		    if (!$render->pnFormIsValid()) return false;

		    // get the field id into the object
		    if ($this->id > 0) $obj['id']=$this->id;
		    if ($this->id > 0) {	// an field just has to be updated
		      	$result = DBUtil::updateObject($obj, 'myprofile_fields');
		      	if ($result) LogUtil::registerStatus(__('Existing field was updated successfully', $dom));
			}
			else {	// field has to be inserted as new field.
			  	$fields = pnModAPIFunc('MyProfile','admin','getFields');
			  	// Check if there is already a field with the given / new identifier
			  	foreach ($fields as $field) {
                    if ( ($obj['fieldtype'] != 'SEPARATOR') && (strtoupper($field['identifier']) == strtoupper($obj['identifier']))) {
                        LogUtil::registerError(__('A field named with this identifier exists already - please choose another value for the identifier!'));
                        return false;
                    }
                }
                
			  	$obj['position']= count($fields);
			  	// remove blanks if needed
			  	if ($obj['fieldtype'] != 'SEPARATOR') {
			  	  
					$pattern = "/\A[a-zA-Z0-9]+\z/";
					if ((int)preg_match($pattern, $obj['identifier'], $result) ==0) {
			  	  	  	LogUtil::registerError(__('The identifier must not contain any other characters than numbers (0-9) and regular characters (A-Z, a-z)', $dom).' "'.$obj['identifier'].'"');
						return false; 
					}
				}
				DBUtil::insertObject($obj, 'myprofile_fields');
				LogUtil::registerStatus(__('New field was created successfully', $dom));
			}
		    // rebuild table definition. many errors might be avoidable by this
		    pnModAPIFunc('MyProfile','admin','updateTableDefinition');
			return pnRedirect(pnModURL('MyProfile','admin','update'));
		}
		return true;
    }
}