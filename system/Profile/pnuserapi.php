<?php
/**
 * PostNuke Application Framework
 *
 * @copyright (c) 2002, PostNuke Development Team
 * @link http://www.postnuke.com
 * @version $Id: pnuserapi.php 22968 2007-10-13 16:00:29Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package PostNuke_System_Modules
 * @subpackage Profile
 * @license http://www.gnu.org/copyleft/gpl.html
*/

/**
 * Get all Dynamic user data fields
 * @author Mark West
 * @param int args['startnum'] starting record number for request
 * @param int args['numitems'] number of records to retrieve
 * @return mixed array of items, or false on failure
 */
function Profile_userapi_getall($args)
{
    // Optional arguments.
    if (!isset($args['startnum'])) {
        $args['startnum'] = 0;
    }
    if (!isset($args['numitems'])) {
        $args['numitems'] = -1;
    }

    if ((!isset($args['startnum'])) ||
        (!isset($args['numitems']))) {
        return LogUtil::registerError (_MODARGSERROR);
    }

    $items   = array();
    $results = array();

    // Security check
    if (!SecurityUtil::checkPermission('Profile::', '::', ACCESS_READ)) {
        return $items;
    }

    // We now generate a where-clause
    $where   = '';
    $orderBy = 'prop_weight';

    $results = DBUtil::selectObjectArray ('user_property', $where, $orderBy, $args['startnum'], $args['numitems']);

    // Put items into result array.
    foreach ($results as $item) {
        if (SecurityUtil::checkPermission('Profile::', $item['prop_label'].'::'.$item['prop_id'], ACCESS_READ)) {
            // Extract the validation info array
            $validationinfo = @unserialize($item['prop_validation']);

            // Create the item array
            $item['prop_required']      = $validationinfo['required'];
            $item['prop_viewby']        = $validationinfo['viewby'];
            $item['prop_displaytype']   = $validationinfo['displaytype'];
            $item['prop_listoptions']   = $validationinfo['listoptions'];
            $item['prop_note']          = $validationinfo['note'];
            $item['prop_validation']    = $validationinfo['validation'];
            $items[$item['prop_label']] = $item;
        }
    }

    // Return the items
    return $items;
}

/**
 * Get a specific Dynamic user data item
 * @author Mark West
 * @param $args['propid'] id of property to get
 * @return mixed item array, or false on failure
 */
function Profile_userapi_get($args)
{
    // Argument check
    if (!isset($args['propid']) && !isset($args['proplabel'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }

    // Get item with where clause
    if (isset($args['propid'])) {
        $result = DBUtil::selectObjectByID('user_property', (int)$args['propid'], 'prop_id');
    } else {
        $result = DBUtil::selectObjectByID('user_property', $args['proplabel'], 'prop_label');
    }

    // Check for no rows found, and if so return
    if (!$result) {
        return false;
    }

    // Security check
    if (!SecurityUtil::checkPermission('Profile::', $result['prop_label'].'::'.$result['prop_id'], ACCESS_READ)) {
        return false;
    }

    // Extract the validation info array
    $validationinfo = @unserialize($result['prop_validation']);

    // Create the item array
    $item = array('prop_id'          => $result['prop_id'],
                  'prop_label'       => $result['prop_label'],
                  'prop_dtype'       => $result['prop_dtype'],
                  'prop_length'      => $result['prop_length'],
                  'prop_weight'      => $result['prop_weight'],
                  'prop_required'    => $validationinfo['required'],
                  'prop_viewby'      => $validationinfo['viewby'],
                  'prop_displaytype' => $validationinfo['displaytype'],
                  'prop_listoptions' => $validationinfo['listoptions'],
                  'prop_note'        => $validationinfo['note'],
                  'prop_validation'  => $validationinfo['validation']);

    // Return the item array
    return $item;
}

/**
 * Get all active Dynamic user data fields
 * @author Mark West - FC
 * @param int args['startnum'] starting record number for request
 * @param int args['numitems'] number of records to retrieve
 * @return mixed array of items, or false on failure
 */
function Profile_userapi_getallactive($args)
{
    // Optional arguments.
    if (!isset($args['startnum'])) {
        $args['startnum'] = 1;
    }
    if (!isset($args['numitems'])) {
        $args['numitems'] = -1;
    }

    if ((!isset($args['startnum'])) ||
        (!isset($args['numitems']))) {
        return LogUtil::registerError (_MODARGSERROR);
    }

    $items = array();

    // Security check
    if (!SecurityUtil::checkPermission('Profile::', '::', ACCESS_READ)) {
        return $items;
    }

    // Get datbase setup
    $pntable = pnDBGetTables();
    $column  = $pntable['user_property_column'];
    $where   = "$column[prop_weight]>='1'";
    $where   = "WHERE $column[prop_weight]>='1'
                AND   $column[prop_dtype]>='0'";
    $orderBy = "$column[prop_weight]";
    $props   = DBUtil::selectObjectArray('user_property', $where, $orderBy, $args['startnum'], $args['numitems']);

    // Put items into result array.
    foreach ($props as $item) {
        if (SecurityUtil::checkPermission('Profile::', $item['prop_label'].'::'.$item['prop_id'], ACCESS_READ)) {

            // Extract the validation info array
            $validationinfo = @unserialize($item['prop_validation']);

            $item['prop_required']    = $validationinfo['required'];
            $item['prop_viewby']      = $validationinfo['viewby'];
            $item['prop_displaytype'] = $validationinfo['displaytype'];
            $item['prop_listoptions'] = $validationinfo['listoptions'];
            $item['prop_note']        = $validationinfo['note'];
            $item['prop_validation']  = $validationinfo['validation'];

        $items[] = $item;
        }
    }

    // Return the items
    return $items;
}

/**
 * Utility function to count the number of items held by this module
 * @author Mark West
 * @return int number of items held by this module
 */
function Profile_userapi_countitems()
{
    // Return the number of items
    return DBUtil::selectObjectCount('user_property');
}

/**
 * Utility function to get the weight limits
 * @author Mark West
 * @return mixed array of items, or false on failure
 */
function Profile_userapi_getweightlimits()
{
    // Get datbase setup
    $pntable = pnDBGetTables();
    $column  = $pntable['user_property_column'];

    $where = "WHERE $column[prop_weight]<>0";
    $max   = DBUtil::selectFieldMax ('user_property', 'prop_weight', 'MAX', $where);

    $where = "WHERE $column[prop_weight]<>0";
    $min   = DBUtil::selectFieldMax ('user_property', 'prop_weight', 'MIN', $where);

    // Return the number of items
    return array('min' => $min, 'max' => $max);
}

/**
 * Utility function to check if a mail exists
 * @author FC
 * @return int number of items held by this module
 */
function Profile_userapi_checkmailexists($args)
{
    // Argument check
    if (empty($args['newmail'])) {
        // must be set!
        return 1;
    }
    if (empty($args['uid'])) {
        return LogUtil::registerError (_MODARGSERROR . ' (uid)');
        // TO FIX
    }

    $pntable = pnDBGetTables();
    $column  = $pntable['users_column'];
    $where   = "WHERE $column[uid]!='". (int) DataUtil::formatForStore($args['uid'])."'
                AND   $column[email]= '" . DataUtil::formatForStore($args['newmail'])."'";
    return DBUtil::selectObjectCount ('users', $where);
}

/**
 * Utility function to save the data of the user
 * @author FC
 * @return true - success; false - failure
 */
function Profile_userapi_savedata($args)
{
    // Argument check
    if (!isset($args['uid'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }

    // Building the $sql
    $fieldlist = $args['dynadata'];

    // create the basic array for dbutil
    $profile = array('uid' => $args['uid']);

    // Creating the SQL on the fly with the correct fields.
    while(list($fieldlabel, $fieldvalue) = each($fieldlist)) {
        // Combining fields, TODO: Extend to other types than only EXTDATE
        // Must check type, if EXTDATE { implode } else { serialize }
        if (is_array($fieldvalue)) {
            $definition = pnModAPIFunc('Profile', 'user', 'get', array('proplabel' => $fieldlabel));
            if ($definition) {
                if ($definition['prop_displaytype'] == 6) {
                    $fieldvalue = implode('-', $fieldvalue);
                } else {
                    $fieldvalue = serialize(array_values($fieldvalue));
                }
            }
        }

        $fieldname = pnModAPIFunc('Profile', 'user', 'sqlalias', array('fieldlabel' => $fieldlabel));

        if ($fieldlabel != $fieldname) {
            $profile[$fieldname] = $fieldvalue;
        } else {
            $otherfields[$fieldlabel] = $fieldvalue;
        }
    }

    // Check for an error with the database code
    if (!DBUtil::updateObject($profile, 'users', '', 'uid')) {
        return LogUtil::registerError(_PROFILE_SAVEFAILED);
    }

    // Saving the additional fields.
    if (!empty($otherfields) && is_array($otherfields)) {
        while(list($dynafield, $dynavalue) = each($otherfields)) {
            if (!pnUserSetVar($dynafield, $dynavalue)) {
                return LogUtil::registerError(pnML('_PROFILE_SAVEFIELDFAILED', array('field' => $dynafield)));
            }
        }
    }

    if (!empty($args['pass']) && $args['pass'] == $args['vpass']) {
        pnUserSetPassword($args['pass']);
    }

    // Return the result (true = success, false = failure
    // At this point, the result is true.
    return true;
}

/**
 * Utility function to check the required missing
 * @author FC
 * @return true - success; false - failure
 */
function Profile_userapi_checkrequired($args)
{
    // Argument check
    if (!isset($args['dynadata'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }

    // The API function is called.
    $items = pnModAPIFunc('Profile', 'user', 'getallactive',
                          array());

    // Initializing Error check
    $error = false;

    foreach($items as $item) {

        if (($item['prop_required'] == 1) && ($item['prop_label'] != '_PASSWORD')) {
            if (is_array($args['dynadata'][$item['prop_label']])) {
                while(list(,$value) = each($args['dynadata'][$item['prop_label']])) {
                    if (empty($value)) {
                        $error['result'] = true;
                        $error['fields'] = $item['prop_label'];
                        break;
                    }
                }
            } else {
                if (empty($args['dynadata'][$item['prop_label']])) {
                    $error['result'] = true;
                    $error['fields'] = $item['prop_label'];
                    break;
                }
            }
        }
    }

    // Return the result
    return $error;
}

/**
 * Utility function to get the alias for the profile
 * @author FC
 * @return string
 */
function Profile_userapi_aliasing($args)
{
    $vars['_UREALNAME']      = 'name';
    $vars['_UREALEMAIL']     = 'email';
    $vars['_UFAKEMAIL']      = 'femail';
    $vars['_YOURHOMEPAGE']   = 'url';
    $vars['_TIMEZONEOFFSET'] = 'timezone_offset';
    $vars['_YOURAVATAR']     = 'user_avatar';
    $vars['_YICQ']           = 'user_icq';
    $vars['_YAIM']           = 'user_aim';
    $vars['_YYIM']           = 'user_yim';
    $vars['_YMSNM']          = 'user_msnm';
    $vars['_YLOCATION']      = 'user_from';
    $vars['_YOCCUPATION']    = 'user_occ';
    $vars['_YINTERESTS']     = 'user_intrest';
    $vars['_SIGNATURE']      = 'user_sig';
    $vars['_EXTRAINFO']      = 'bio';

    //if ($vars[$args['label']]."" != "") {
    if (isset($vars[$args['label']])) {
        $label = $vars[$args['label']];
    }

    return $label;
}

/**
 * Utility function to get the alias for the sqlquery saving the data
 * Temporary - useless for the moment
 * @author FC
 * @return string
 */
function Profile_userapi_sqlalias($args)
{

    $vars['_UREALEMAIL']     = 'email';
    //$vars['_TIMEZONEOFFSET'] = 'timezone_offset';

    if (isset($vars[$args['fieldlabel']])){
        $args['fieldlabel'] = $vars[$args['fieldlabel']];
    }

    return $args['fieldlabel'];
}

/**
 * Utility function to get the account links for each user module
 * @author FC
 * @return string
 */
function Profile_userapi_accountlinks($args)
{
    // Get all user modules
    $usermods = pnModGetUserMods();

    if ($usermods == false) {
        return false;
    }

    $accountlinks = array();

    foreach ($usermods as $usermod) {
        if (file_exists('modules/'.DataUtil::formatForOS($usermod['name']).'/pnaccountapi.php')) {
            $items = pnModAPIFunc($usermod['name'], 'account', 'getall');
            if ($items) {
                foreach ($items as $item) {
                    // check every retured link for permissions
                    if (SecurityUtil::checkPermission('Profile::', "$usermod[name]::$item[title]", ACCESS_READ)) {
                        if (!isset($item['module'])) $item['module']  = $usermod['name'];
                        $accountlinks[] = $item;
                    }
                }
            }
        } elseif (file_exists('system/'.DataUtil::formatForOS($usermod['name']).'/pnaccountapi.php')) {
            $items = pnModAPIFunc($usermod['name'], 'account', 'getall');
            if ($items) {
                foreach ($items as $item) {
                    // check every retured link for permissions
                    if (SecurityUtil::checkPermission('Profile::', "$usermod[name]::$item[title]", ACCESS_READ)) {
                        if (!isset($item['module'])) $item['module']  = $usermod['name'];
                        $accountlinks[] = $item;
                    }
                }
            }
        } else {
            $items = false;
        }
        if ($items) {
            // add legacy user icons to the page.
            // The link images must be moved from /images/menu to the module directory.
            if (@is_dir($dir = 'system/' . DataUtil::formatForOS($usermod['directory']) . '/user/links/')) {
                $linksdir = opendir($dir);
                while (false !== ($func = readdir($linksdir))) {
                    if (eregi('^links.', $func)) {
                        // needed for modules_get_language
                        $GLOBALS['ModName'] = $usermod['directory'];
                        include "$dir$func";
                        if (isset($GLOBALS['old_style_links'])) {
                            $accountlinks[] = array('url'    => $GLOBALS['old_style_links']['url'],
                                                    'title'  => $GLOBALS['old_style_links']['title'],
                                                    'icon'   => $GLOBALS['old_style_links']['image'],
                                                    'module' => $usermod['name']);
                            unset ($GLOBALS['old_style_links']);
                        }
                    }
                }
                closedir($linksdir);
            }
        }
    }

    return $accountlinks;
}

/**
 * form custom url string
 *
 * @author Mark West
 * @return string custom url string
 */
function Profile_userapi_encodeurl($args)
{
    // check we have the required input
    if (!isset($args['modname']) || !isset($args['func']) || !isset($args['args'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }

    // create an empty string ready for population
    $vars = '';

    // let the core handled everything except the view function
    if ($args['func'] == 'view' && (isset($args['args']['uname']) || isset($args['args']['uid']))) {
        isset($args['args']['uname']) ? $vars = $args['args']['uname'] : $vars = $args['args']['uid'];
    } else {
        return false;
    }
    if (isset($args['args']['page'])) {
        $vars .= "/{$args['args']['page']}";
    }

    // construct the custom url part
    return $args['modname'] . '/' . $args['func'] . '/' . $vars;
}

/**
 * decode the custom url string
 *
 * @author Mark West
 * @return bool true if successful, false otherwise
 */
function Profile_userapi_decodeurl($args)
{
    // check we actually have some vars to work with...
    if (!isset($args['vars'])) {
        return LogUtil::registerError (_MODARGSERROR);
    }

    // let the core handled everything except the view function
    if (!isset($args['vars'][2]) || empty($args['vars'][2]) || $args['vars'][2] != 'view') {
        return false;
    }
    pnQueryStringSetVar('func', 'view');

    // identify the correct parameter to identify the user
    if (isset($args['vars'][3])) {
        if (is_numeric($args['vars'][3])) {
            pnQueryStringSetVar('uid', $args['vars'][3]);
        } else {
             pnQueryStringSetVar('uname', $args['vars'][3]);
        }
    }
    if (isset($args['vars'][4])) {
        pnQueryStringSetVar('page', $args['vars'][4]);
    }

    return true;
}
