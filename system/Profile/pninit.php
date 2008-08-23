<?php
/**
 * PostNuke Application Framework
 *
 * @copyright (c) 2002, PostNuke Development Team
 * @link http://www.postnuke.com
 * @version $Id: pninit.php 22138 2007-06-01 10:19:14Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package PostNuke_System_Modules
 * @subpackage Profile
 * @author Mark West
*/

/**
 * Initialise the dynamic user data  module
 * This function is only ever called once during the lifetime of a particular
 * module instance
 * @author Mark West
 * @return bool true on success or false on failure
 */
function Profile_init()
{
    if (!DBUtil::createTable('user_property')) {
        return false;
    }

    if (!DBUtil::createTable('user_data')) {
        return false;
    }

    pnModSetVar('Profile', 'itemsperpage',    25);
    pnModSetVar('Profile', 'itemsperrow',     5);
    pnModSetVar('Profile', 'displaygraphics', 1);

    // Set up module hooks
    if (!pnModRegisterHook('item', 'display', 'GUI', 'Profile', 'user', 'display')) {
        return false;
    }

    // create the default data for the module
    Profile_defaultdata();

    // Initialisation successful
    return true;
}

/**
 * Upgrade the dynamic user data module from an old version
 * This function can be called multiple times
 * @author Mark West
 * @param int $oldversion version to upgrade from
 * @return bool true on success or false on failure
 */
function Profile_upgrade($oldversion)
{
    // in mysql 5 strict mode we need to set any null values before changing the table
    $table = DBUtil::getLimitedTableName('user_property');
    DBUtil::executeSQL("UPDATE {$table} SET pn_prop_validation = '' WHERE pn_prop_validation IS NULL");

    if (!DBUtil::changeTable('user_property')) {
        return false;
    }

    if (!DBUtil::changeTable('user_data')) {
        return false;
    }

    switch ($oldversion) {
        case 0.8:
           pnModSetVar('Profile', 'itemsperpage',    25);
           pnModSetVar('Profile', 'itemsperrow',     5);
           pnModSetVar('Profile', 'displaygraphics', 1);
           // fix the data types of any existing properties
           DBUtil::executeSQL("UPDATE {$table} SET pn_prop_dtype = '1' WHERE pn_prop_dtype = '0'");
           // Set up module hooks
           if (!pnModRegisterHook('item', 'display', 'GUI', 'Profile', 'user', 'display')) {
               return false;
           }
           break;
    }
    // Update successful
    return true;
}

/**
 * Delete the dyanmic user data module
 * This function is only ever called once during the lifetime of a particular
 * module instance
 * @author Mark West
 * @return bool true on success or false on failure
 */
function Profile_delete()
{
    if (!DBUtil::dropTable('user_property')) {
        return false;
    }

    if (!DBUtil::dropTable('user_data')) {
        return false;
    }

    // Delete any module variables
    pnModDelVar('Profile');

    // remove module hooks
    if (!pnModUnRegisterHook('item', 'display', 'GUI', 'Profile', 'user', 'display')) {
        return false;
    }

    // Deletion successful
    return true;
}

/**
 * create the default data for the users module
 *
 * This function is only ever called once during the lifetime of a particular
 * module instance
 *
 */
function Profile_defaultdata()
{
    // Make assumption that if were upgrading from 76x to 0.8
    // that user properties already exist and abort inserts.
    if (isset($_SESSION['_PNUpgrader']['_PNUpgradeFrom76x'])) {
        return;
    }

    // _UREALNAME
    $record = array();
    $record['prop_label']      = ''._USER_PROPERTY_1_a.'';
    $record['prop_dtype']      = ''._USER_PROPERTY_1_b.'';
    $record['prop_length']     = ''._USER_PROPERTY_1_c.'';
    $record['prop_weight']     = ''._USER_PROPERTY_1_d.'';
    $record['prop_validation'] = ''._USER_PROPERTY_1_e.'';

    DBUtil::insertObject($record, 'user_property', 'prop_id');

    // _UREALEMAIL
    $record = array();
    $record['prop_label']      = ''._USER_PROPERTY_2_a.'';
    $record['prop_dtype']      = ''._USER_PROPERTY_2_b.'';
    $record['prop_length']     = ''._USER_PROPERTY_2_c.'';
    $record['prop_weight']     = ''._USER_PROPERTY_2_d.'';
    $record['prop_validation'] = ''._USER_PROPERTY_2_e.'';

    DBUtil::insertObject($record, 'user_property', 'prop_id');

    // _PASSWORD
    $record = array();
    $record['prop_label']      = ''._USER_PROPERTY_16_a.'';
    $record['prop_dtype']      = ''._USER_PROPERTY_16_b.'';
    $record['prop_length']     = ''._USER_PROPERTY_16_c.'';
    $record['prop_weight']     = ''._USER_PROPERTY_16_d.'';
    $record['prop_validation'] = ''._USER_PROPERTY_16_e.'';

    DBUtil::insertObject($record, 'user_property', 'prop_id');

    // _UFAKEMAIL
    $record = array();
    $record['prop_label']      = ''._USER_PROPERTY_3_a.'';
    $record['prop_dtype']      = ''._USER_PROPERTY_3_b.'';
    $record['prop_length']     = ''._USER_PROPERTY_3_c.'';
    $record['prop_weight']     = ''._USER_PROPERTY_3_d.'';
    $record['pn_prop_validation'] = ''._USER_PROPERTY_3_e.'';

    DBUtil::insertObject($record, 'user_property', 'prop_id');

    // _YOURHOMEPAGE
    $record = array();
    $record['prop_label']      = ''._USER_PROPERTY_4_a.'';
    $record['prop_dtype']      = ''._USER_PROPERTY_4_b.'';
    $record['prop_length']     = ''._USER_PROPERTY_4_c.'';
    $record['prop_weight']     = ''._USER_PROPERTY_4_d.'';
    $record['prop_validation'] = ''._USER_PROPERTY_4_e.'';

    DBUtil::insertObject($record, 'user_property', 'prop_id');

    // _TIMEZONEOFFSET
    $record = array();
    $record['prop_label']      = ''._USER_PROPERTY_5_a.'';
    $record['prop_dtype']      = ''._USER_PROPERTY_5_b.'';
    $record['prop_length']     = ''._USER_PROPERTY_5_c.'';
    $record['prop_weight']     = ''._USER_PROPERTY_5_d.'';
    $record['prop_validation'] = ''._USER_PROPERTY_5_e.'';

    DBUtil::insertObject($record, 'user_property', 'prop_id');

    // _YOURAVATAR
    $record = array();
    $record['prop_label']      = ''._USER_PROPERTY_6_a.'';
    $record['prop_dtype']      = ''._USER_PROPERTY_6_b.'';
    $record['prop_length']     = ''._USER_PROPERTY_6_c.'';
    $record['prop_weight']     = ''._USER_PROPERTY_6_d.'';
    $record['prop_validation'] = ''._USER_PROPERTY_6_e.'';

    DBUtil::insertObject($record, 'user_property', 'prop_id');

    // _YICQ
    $record = array();
    $record['prop_label']      = ''._USER_PROPERTY_7_a.'';
    $record['prop_dtype']      = ''._USER_PROPERTY_7_b.'';
    $record['prop_length']     = ''._USER_PROPERTY_7_c.'';
    $record['prop_weight']     = ''._USER_PROPERTY_7_d.'';
    $record['prop_validation'] = ''._USER_PROPERTY_7_e.'';

    DBUtil::insertObject($record, 'user_property', 'prop_id');

    // _YAIM
    $record = array();
    $record['prop_label']      = ''._USER_PROPERTY_8_a.'';
    $record['prop_dtype']      = ''._USER_PROPERTY_8_b.'';
    $record['prop_length']     = ''._USER_PROPERTY_8_c.'';
    $record['prop_weight']     = ''._USER_PROPERTY_8_d.'';
    $record['prop_validation'] = ''._USER_PROPERTY_8_e.'';

    DBUtil::insertObject($record, 'user_property', 'prop_id');

    // _YYIM
    $record = array();
    $record['prop_label']      = ''._USER_PROPERTY_9_a.'';
    $record['prop_dtype']      = ''._USER_PROPERTY_9_b.'';
    $record['prop_length']     = ''._USER_PROPERTY_9_c.'';
    $record['prop_weight']     = ''._USER_PROPERTY_9_d.'';
    $record['prop_validation'] = ''._USER_PROPERTY_9_e.'';

    DBUtil::insertObject($record, 'user_property', 'prop_id');

    // _YMSNM
    $record = array();
    $record['prop_label']      = ''._USER_PROPERTY_10_a.'';
    $record['prop_dtype']      = ''._USER_PROPERTY_10_b.'';
    $record['prop_length']     = ''._USER_PROPERTY_10_c.'';
    $record['prop_weight']     = ''._USER_PROPERTY_10_d.'';
    $record['prop_validation'] = ''._USER_PROPERTY_10_e.'';

    DBUtil::insertObject($record, 'user_property', 'prop_id');

    // _YLOCATION
    $record = array();
    $record['prop_label']      = ''._USER_PROPERTY_11_a.'';
    $record['prop_dtype']      = ''._USER_PROPERTY_11_b.'';
    $record['prop_length']     = ''._USER_PROPERTY_11_c.'';
    $record['prop_weight']     = ''._USER_PROPERTY_11_d.'';
    $record['prop_validation'] = ''._USER_PROPERTY_11_e.'';

    DBUtil::insertObject($record, 'user_property', 'prop_id');

    // _YOCCUPATION
    $record = array();
    $record['prop_label']      = ''._USER_PROPERTY_12_a.'';
    $record['prop_dtype']      = ''._USER_PROPERTY_12_b.'';
    $record['prop_length']     = ''._USER_PROPERTY_12_c.'';
    $record['prop_weight']     = ''._USER_PROPERTY_12_d.'';
    $record['prop_validation'] = ''._USER_PROPERTY_12_e.'';

    DBUtil::insertObject($record, 'user_property', 'prop_id');

    // _SIGNATURE
    $record = array();
    $record['prop_label']      = ''._USER_PROPERTY_13_a.'';
    $record['prop_dtype']      = ''._USER_PROPERTY_13_b.'';
    $record['prop_length']     = ''._USER_PROPERTY_13_c.'';
    $record['prop_weight']     = ''._USER_PROPERTY_13_d.'';
    $record['prop_validation'] = ''._USER_PROPERTY_13_e.'';

    DBUtil::insertObject($record, 'user_property', 'prop_id');

    // _EXTRAINFO
    $record = array();
    $record['prop_label']      = ''._USER_PROPERTY_14_a.'';
    $record['prop_dtype']      = ''._USER_PROPERTY_14_b.'';
    $record['prop_length']     = ''._USER_PROPERTY_14_c.'';
    $record['prop_weight']     = ''._USER_PROPERTY_14_d.'';
    $record['prop_validation'] = ''._USER_PROPERTY_14_e.'';

    DBUtil::insertObject($record, 'user_property', 'prop_id');

    // _YINTERESTS
    $record = array();
    $record['prop_label']      = ''._USER_PROPERTY_15_a.'';
    $record['prop_dtype']      = ''._USER_PROPERTY_15_b.'';
    $record['prop_length']     = ''._USER_PROPERTY_15_c.'';
    $record['prop_weight']     = ''._USER_PROPERTY_15_d.'';
    $record['prop_validation'] = ''._USER_PROPERTY_15_e.'';

    DBUtil::insertObject($record, 'user_property', 'prop_id');
}
