<?php
/**
 * PostNuke Application Framework
 *
 * @copyright (c) 2002, PostNuke Development Team
 * @link http://www.postnuke.com
 * @version $Id: pntables.php 22138 2007-06-01 10:19:14Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package PostNuke_System_Modules
 * @subpackage Profile
 * @author Mark West
*/

/**
 * This function is called internally by the core whenever the module is
 * loaded. It adds in the information
 * @author Mark West
 * @return array table definition array
 */
function Profile_pntables()
{
    // Initialise table array
    $pntable = array();

    // Get the name for the template item table.  This is not necessary
    // but helps in the following statements and keeps them readable
    $property = DBUtil::getLimitedTablename('user_property');

    // Set the table name
    $pntable['user_property'] = $property;

    // Set the column names.  Note that the array has been formatted
    // on-screen to be very easy to read by a user.
    $pntable['user_property_column'] = array('prop_id'         => 'pn_prop_id',
                                             'prop_label'      => 'pn_prop_label',
                                             'prop_dtype'      => 'pn_prop_dtype',
                                             'prop_length'     => 'pn_prop_length',
                                             'prop_weight'     => 'pn_prop_weight',
                                             'prop_validation' => 'pn_prop_validation');

    $pntable['user_property_column_def'] = array('prop_id'         => "I4 NOTNULL AUTO PRIMARY",
                                                 'prop_label'      => "C(255) NOTNULL DEFAULT ''",
                                                 'prop_dtype'      => "I4 NOTNULL DEFAULT 0",
                                                 'prop_length'     => "I4 NOTNULL DEFAULT 255",
                                                 'prop_weight'     => "I4 NOTNULL DEFAULT 0",
                                                 'prop_validation' => "C(255) NOTNULL DEFAULT ''");

    $pntable['user_property_column_idx'] = array ('prop_label' => 'prop_label');

    // Get the name for the template item table.  This is not necessary
    // but helps in the following statements and keeps them readable
    $data = DBUtil::getLimitedTablename('user_data');

    // Set the table name
    $pntable['user_data'] = $data;

    // Set the column names.  Note that the array has been formatted
    // on-screen to be very easy to read by a user.
    $pntable['user_data_column'] = array('uda_id'     => 'pn_uda_id',
                                         'uda_propid' => 'pn_uda_propid',
                                         'uda_uid'    => 'pn_uda_uid',
                                         'uda_value'  => 'pn_uda_value');

    $pntable['user_data_column_def'] = array('uda_id'     => "I4 NOTNULL AUTO PRIMARY",
                                             'uda_propid' => "I4 NOTNULL DEFAULT 0",
                                             'uda_uid'    => "I4 NOTNULL DEFAULT 0",
                                             'uda_value'  => "XL NOTNULL");


    $pntable['user_data_column_idx'] = array ('uid_propid' => array('uda_propid', 'uda_uid'));

    // Return the table information
    return $pntable;
}
