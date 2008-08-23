/**
 * PostNuke Application Framework
 *
 * @copyright (c) 2002, PostNuke Development Team
 * @link http://www.postnuke.com
 * @version $Id: pnadmin.php 20935 2007-01-03 14:51:37Z chestnut $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package PostNuke_System_Modules
 * @subpackage Profile
 */

function showavatar()
{
    if($('youravatar') && $('youravatardisplay')){
        $('youravatardisplay').src = baseurl + 'images/avatar/' + $('youravatar').options[$('youravatar').selectedIndex].value;
    }
}
