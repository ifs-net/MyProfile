<?php
/**
 * PostNuke Application Framework
 *
 * @copyright (c) 2001, PostNuke Development Team
 * @link http://www.postnuke.com
 * @version $Id: pnajax.php 22138 2007-06-01 10:19:14Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package PostNuke_System_Modules
 * @subpackage Profile
*/

/**
 * change the weight of a profile item
 *
 * @author Mark West
 * @param blockorder array of sorted blocks (value = block id)
 * @return mixed true or Ajax error
 */
function Profile_ajax_changeprofileweight()
{
    if (!SecurityUtil::checkPermission('Profile::', '::', ACCESS_ADMIN)) {
        AjaxUtil::error(DataUtil::formatForDisplayHTML(_MODULENOAUTH));
    }

    if (!SecurityUtil::confirmAuthKey()) {
        AjaxUtil::error(_BADAUTHKEY);
    }

    $profilelist = FormUtil::getPassedValue('profilelist');
    $startnum = FormUtil::getPassedValue('startnum');

    // update the items with the new weights
    $items = array();
    foreach ($profilelist as $newweight => $prop_id) {
        $items[] = array('prop_id' => $prop_id,
                         'prop_weight' => $newweight + $startnum + 1);
    }

    // update the db
    $res = DBUtil::updateObjectArray($items, 'user_property', 'prop_id');
    if (!$res) {
        AjaxUtil::error(_UPDATEFAILED);
    }

    return array('result' => true);
}
