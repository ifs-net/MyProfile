<?php
/**
 * PostNuke Application Framework
 *
 * @copyright (c) 2002, PostNuke Development Team
 * @link http://www.postnuke.com
 * @version $Id: pnadminapi.php 22360 2007-07-09 01:54:41Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package PostNuke_System_Modules
 * @subpackage Profile
 * @author Mark West
 */

/**
 * create a new dynamic user data item
 * @author Mark West
 * @param string $args['label'] the name of the item to be created
 * @param string $args['dtype'] the data type of the item to be created
 * @param int $args['length'] the length of the item to be created if dtype is string
 * @param string $args['validation'] data validation string for the item
 * @return mixed dud item ID on success, false on failure
 */
function Profile_adminapi_create($args)
{
    // Argument check
    if ((!isset($args['label'])) || empty($args['label']) || stristr($args['label'], '-') || 
        (!isset($args['dtype'])) || empty($args['dtype'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }

    // The API function is called.
    $weightlimits = pnModAPIFunc('Profile', 'user', 'getweightlimits');

    // Set default values
    $weight = $weightlimits['max'] + 1;

    // Security check
    if (!SecurityUtil::checkPermission('Profile::item', "$args[label]::", ACCESS_ADD)) {
        return LogUtil::registerPermissionError();
    }

    // produce the validation array
    $validationinfo = array('required'    => $args['required'],
                            'viewby'    => $args['viewby'],
                            'displaytype' => $args['displaytype'],
                            'listoptions' => $args['listoptions'],
                            'note'        => $args['note'],
                            'validation'  => $args['validation']);

    $obj = array();
    $obj['prop_label']      = $args['label'];
    $obj['prop_dtype']      = $args['dtype'];
    $obj['prop_length']     = $args['length'];
    $obj['prop_weight']     = $weight;
    $obj['prop_validation'] = serialize($validationinfo);
    $res = DBUtil::insertObject ($obj, 'user_property', 'prop_id');

    // Check for an error with the database code
    if (!$res) {
        return LogUtil::registerError (_CREATEFAILED);
    }

    // Let any hooks know that we have created a new item.
    pnModCallHooks('item', 'create', $obj['prop_id'], array('module' => 'Profile'));

    // Return the id of the newly created item to the calling process
    return $obj['prop_id'];
}

/**
 * Delete a dynamic user data item
 * @author Mark West
 * @param int $args['dudid'] ID of the item
 * @return bool true on success, false on failure
 */
function Profile_adminapi_delete($args)
{
    // Argument check
    if (!isset($args['dudid']) || !is_numeric($args['dudid'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }

	$dudid = $args['dudid'];
	unset($args);

    // The user API function is called.
    $item = pnModAPIFunc('Profile', 'user', 'get',
                         array('propid' => $dudid));

    if ($item == false) {
        return LogUtil::registerError (pnML('_NOSUCHITEMFOUND', array('i' => _PROFILE_PROPERTY)));
    }

    // Security check
    if (!SecurityUtil::checkPermission('Profile::Item', "$item[prop_label]::$dudid", ACCESS_DELETE)) {
        return LogUtil::registerPermissionError();
    }

    $res = DBUtil::deleteObjectByID ('user_property', $dudid, 'prop_id');

    // Check for an error with the database code
    if (!$res) {
        return LogUtil::registerError (_DELETEFAILED);
    }

    // Let any hooks know that we have deleted an item.
    pnModCallHooks('item', 'delete', $dudid, array('module' => 'Profile'));

    // Let the calling process know that we have finished successfully
    return true;
}

/**
 * Update a dynamic user data item
 * @author Mark West
 * @param int $args['dudid'] the id of the item to be updated
 * @param string $args['label'] the name of the item to be updated
 * @param string $args['dtype'] the data type of the item to be updated
 * @param int $args['length'] the length of the item to be updated if dtype is string
 * @param string $args['validation'] data validation string for the item
 * @return bool true on success, false on failure
 */
function Profile_adminapi_update($args)
{
    // Argument check
    if (!isset($args['label']) || stristr($args['label'], '-') ||
        !isset($args['dtype']) ||
        !isset($args['dudid']) || !is_numeric($args['dudid'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }

    // The user API function is called.
    $item = pnModAPIFunc('Profile', 'user', 'get',
                         array('propid' => $args['dudid']));

    if ($item == false) {
        return LogUtil::registerError (pnML('_NOSUCHITEMFOUND', array('i' => _PROFILE_PROPERTY)));
    }

    // Security check
    if (!SecurityUtil::checkPermission('Profile::Item', "$item[prop_label]::$args[dudid]", ACCESS_EDIT)) {
        return LogUtil::registerPermissionError();
    }
    if (!SecurityUtil::checkPermission('Profile::Item', "$args[label]::$args[dudid]", ACCESS_EDIT)) {
        return LogUtil::registerPermissionError();
    }

    // Set default length
    if (!isset($args['length'])) {
        $args['length'] = 0;
    }

    // Produce the validation array
    $validationinfo = array('required'    => $args['required'],
                            'viewby'      => $args['viewby'],
                            'displaytype' => $args['displaytype'],
                            'listoptions' => $args['listoptions'],
                            'note'        => $args['note'],
                            'validation'  => $args['validation']);

    if (isset($args['prop_weight']) && $args['prop_weight'] <> $item['prop_weight']) {
        $pntable = pnDBGetTables();
        $column  = $pntable['user_property_column'];
        $result = DBUtil::selectObjectByID('user_property', $args['prop_weight'], 'prop_weight');
//        $old_weight = $result['prop_weight'];
        $result['prop_weight'] = $item['prop_weight'];
        $where   = "$column[prop_weight] =  '$args[prop_weight]'
                    AND $column[prop_id] <> '$args[dudid]'";
        DBUtil::updateObject($result, 'user_property', $where, 'prop_id');
    }

    $obj = array();
    $obj['prop_id']         = $args['dudid'];
    $obj['prop_label']      = $args['label'];
    $obj['prop_dtype']      = $args['dtype'];
    $obj['prop_length']     = $args['length'];
    $obj['prop_weight']     = ((isset($args['prop_weight'])) ? $args['prop_weight'] : $item['prop_weight']);
    $obj['prop_validation'] = serialize($validationinfo);
    $res = DBUtil::updateObject ($obj, 'user_property', '', 'prop_id');

    // Check for an error with the database code
    if (!$res) {
        return LogUtil::registerError (_UPDATEFAILED);
    }

    // New hook functions
    pnModCallHooks('item', 'update', $args['dudid'], array('module' => 'Profile'));

    // Let the calling process know that we have finished successfully
    return true;
}

/**
 * Activate a dynamic user data item
 * @author Mark West
 * @param int $args['dudid'] the id of the item to be updated
 * @param int $args['weight'] the current weight of the item to be updated
 * @return bool true on success, false on failure
 * @todo remove weight; can be got from get API
 */
function Profile_adminapi_activate($args)
{
    // Argument check
    if (!isset($args['dudid']) || !is_numeric($args['dudid']) ||
        !isset($args['weight'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }

    // Get datbase setup
    $pntable = pnDBGetTables();
    $propertytable  = $pntable['user_property'];
    $propertycolumn = $pntable['user_property_column'];

    // The API function is called.
    $weightlimits = pnModAPIFunc('Profile', 'user', 'getweightlimits');

    // set default values
    $args['weight'] = $weightlimits['max'] + 1;

    // Update the item
    $sql = "UPDATE $propertytable
            SET    $propertycolumn[prop_weight] = '" . (int)DataUtil::formatForStore($args['weight']) . "'
            WHERE  $propertycolumn[prop_id]     = '" . (int)DataUtil::formatForStore($args['dudid']) . "'";
    $res = DBUtil::executeSQL ($sql);

    // Check for an error with the database code
    if (!$res) {
        return LogUtil::registerError (_PROFILE_ACTIVATIONFAILED);
    }
}

/**
 * Deactivate a dynamic user data item
 * @author Mark West
 * @param int $args['dudid'] the id of the item to be updated
 * @param int $args['weight'] the current weight of the item to be updated
 * @return bool true on success, false on failure
 * @todo remove weight; can be got from get API
 */
function Profile_adminapi_deactivate($args)
{
    // Argument check
    if (!isset($args['dudid']) || !is_numeric($args['dudid']) ||
        !isset($args['weight'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }

    // Get database setup
    $pntable = pnDBGetTables();
    $propertytable  = $pntable['user_property'];
    $propertycolumn = $pntable['user_property_column'];

    // Update the item
    $sql = "UPDATE $propertytable
            SET    $propertycolumn[prop_weight] = 0
            WHERE  $propertycolumn[prop_id]     = '" . (int)DataUtil::formatForStore($args['dudid']) . "'";
    $res = DBUtil::executeSQL ($sql);

    // Check for an error with the database code
    if (!$res) {
        return LogUtil::registerError (_PROFILE_DEACTIVATIONFAILED);
    }

    // Update the item
    $sql = "UPDATE $propertytable
            SET    $propertycolumn[prop_weight] = $propertycolumn[prop_weight] - 1
            WHERE  $propertycolumn[prop_weight] > '" . (int)DataUtil::formatForStore($args['weight']) . "'";
    $res = DBUtil::executeSQL ($sql);

    // Check for an error with the database code
    if (!$res) {
        return LogUtil::registerError (_PROFILE_DEACTIVATIONFAILED);
    }
}

/**
 * Get type and validation for a specific field
 * @author FC
 * @param int $args['proplabel'] the proplabel of the item to be fetched
 * @return array validation, false on failure
 * @todo : cleanup
 */
function Profile_adminapi_getype($args)
{
    // Argument check
    if (!isset($args['proplabel'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }

    // Select the item
    $vResult = DBUtil::selectFieldByID ('user_property', 'prop_validation', $args['proplabel'], 'prop_label');
    if ($vResult === false) {
        return LogUtil::registerError (pnML('_NOSUCHITEMFOUND', array('i' => _PROFILE_PROPERTY)));
    }

    $validation = unserialize($vResult);
    if ($validation['displaytype'] == 4) {

        $listoptions = explode('@@', $validation['listoptions']);
        $listoptionvalues = 1;
        foreach($listoptions as $option) {
            $options[] = $option;
            $optionvalue[] = $listoptionvalues;

            $listoptionvalues++;
        }

        $validation['listoptions'] = $options;
        $validation['listoptionsvalues'] = $optionvalues;
    }

    return $validation;
}

/**
 * get available admin panel links
 *
 * @author Mark West
 * @return array array of admin links
 */
function Profile_adminapi_getlinks()
{
    $links = array();

    pnModLangLoad('Profile', 'admin');

    if (SecurityUtil::checkPermission('Profile::', '::', ACCESS_READ)) {
        $links[] = array('url' => pnModURL('Profile', 'admin', 'view'), 'text' => _ACCOUNTPANELCONTROLSLISTVIEW);
    }
    if (SecurityUtil::checkPermission('Profile::', '::', ACCESS_ADD)) {
        $links[] = array('url' => pnModURL('Profile', 'admin', 'new'), 'text' => _NEWPANELCONTROL);
    }
    if (SecurityUtil::checkPermission('Profile::', '::', ACCESS_ADMIN)) {
        $links[] = array('url' => pnModURL('Profile', 'admin', 'modifyconfig'), 'text' => _MODIFYACCOUNTPANELCONFIG);
    }

    return $links;
}
