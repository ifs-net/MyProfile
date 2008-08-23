<?php
/**
 * PostNuke Application Framework
 *
 * @copyright (c) 2002, PostNuke Development Team
 * @link http://www.postnuke.com
 * @version $Id: function.dudoptionalitem.php 23038 2007-10-23 09:10:57Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 *
 * Dynamic User data Module
 *
 * @package      PostNuke_System_Modules
 * @subpackage   Profile
 */


/**
 * Smarty function to display a dynamic user data field
 *
 * Example
 * <!--[dudoptionalitem proplabel="_YICQ"]-->
 *
 * @author       Mark West
 * @since        21/01/04
 * @see          function.exampleadminlinks.php::smarty_function_exampleadminlinks()
 * @param        array       $params      All attributes passed to this function from the template
 * @param        object      &$smarty     Reference to the Smarty object
 * @param        string      $proplabel   The label to identify the DUD item
 * @return       string      the results of the module function
 */
function smarty_function_dudoptionalitem($params, &$smarty)
{
    extract($params);
    unset($params);

    if (!pnModAvailable('Profile')) {
        return;
    }

    if (!isset($proplabel) || empty($proplabel)) {
        return;
    }

    $item = pnModAPIFunc('Profile', 'user', 'get', array('proplabel' => $proplabel));

    if (!isset($item) || empty ($item)) {
        return;
    }

    $output = '';

    // language define
    $prop_label_text = '';
    $prop_label_text = constant($item['prop_label']);

    if (empty($prop_label_text)) {
        $prop_label_text = $item['prop_label'];
    }

    $output .='<tr><td valign="top">' . $prop_label_text . ':</td><td valign="top">';

    switch ($item['prop_dtype']) {
        case UDCONST_MANDATORY;
        case UDCONST_CORE;
        $core_fields[] = $item['prop_label'];
        switch ($item['prop_label']) {
            case '_UREALNAME':
            $output .='<input type="text" name="name" value="' . DataUtil::formatForDisplay(pnUserGetVar('name')) . '" size="30" maxlength="60" />';
            break;
            case '_UREALEMAIL':
            $output .='<input type="text" name="email" value="' . DataUtil::formatForDisplay(pnUserGetVar('email')) . '" size="30" maxlength="60" />'
            .'&nbsp;'._REQUIRED.'&nbsp;'._EMAILNOTPUBLIC;
            break;
            case '_UFAKEMAIL':
            $output .='<input type="text" name="femail" value="' . DataUtil::formatForDisplay(pnUserGetVar('femail')) . '" size="30" maxlength="60" />';
            break;
            case '_YOURHOMEPAGE':
            $output .='<input type="text" name="url" value="' . DataUtil::formatForDisplay(pnUserGetVar('url')) . '" size="30" maxlength="100" />';
            break;
            case '_TIMEZONEOFFSET':
            $tzoffset = pnConfigGetVar('timezone_offset');
            $tzinfo   = pnModGetVar(PN_CONFIG_MODULE, 'timezone_info');
            $output .='<select name="timezoneoffset">';
            foreach ($tzinfo as $tzindex => $tzdata) {
                $output .='\n<option value="$tzindex"';
                if ($tzoffset == $tzindex) {
                    $output .=' selected="selected"';
                }
                $output .='>';
                $output .=$tzdata;
                $output .='</option>';
            }
            $output .='</select>';
            break;
            case '_YOURAVATAR':
            $user_avatar = 'blank.gif';
            $output .='<select name="user_avatar" onchange="showimage()">';
            $handle = opendir('images/avatar');
            while (false !== ($file = readdir($handle))) {
                $filelist[] = $file;
            }
            asort($filelist);
            while (list ($key, $file) = each ($filelist)) {
                ereg('.gif|.jpg', $file);
                if ($file != '.' && $file != '..' && $file != 'CVS') {
                    $output .="<option value=\"$file\"";
                    if ($file == $user_avatar) {
                        $output .=' selected="selected"';
                    }
                    $output .=">$file</option>";
                }
            }
            $output .='</select>&nbsp;&nbsp;<img src="images/avatar/' . DataUtil::formatForDisplay($user_avatar) . '" name="avatar" width="32" height="32" alt="" />';
            break;
            case '_YICQ':
            $output .='<input type="text" name="user_icq" value="' . DataUtil::formatForDisplay(pnUserGetVar('user_icq')) . '" size="30" maxlength="100" />';
            break;
            case '_YAIM':
            $output .='<input type="text" name="user_aim" value="' . DataUtil::formatForDisplay(pnUserGetVar('user_aim')) . '" size="30" maxlength="100" />';
            break;
            case '_YYIM':
            $output .='<input type="text" name="user_yim" value="' . DataUtil::formatForDisplay(pnUserGetVar('user_yim')) . '" size="30" maxlength="100" />';
            break;
            case '_YMSNM':
            $output .='<input type="text" name="user_msnm" value="' . DataUtil::formatForDisplay(pnUserGetVar('user_msnm')) . '" size="30" maxlength="100" />';
            break;
            case '_YLOCATION':
            $output .='<input type="text" name="user_from" value="' . DataUtil::formatForDisplay(pnUserGetVar('user_from')) . '" size="30" maxlength="100" />';
            break;
            case '_YOCCUPATION':
            $output .='<input type="text" name="user_occ" value="' . DataUtil::formatForDisplay(pnUserGetVar('user_occ')) . '" size="30" maxlength="100" />';
            break;
            case '_YINTERESTS':
            $output .='<input type="text" name="user_intrest" value="' . DataUtil::formatForDisplay(pnUserGetVar('user_intrest')) . '" size="30" maxlength="100" />';
            break;
            case '_SIGNATURE':
            $output .='<textarea wrap="virtual" cols="50" rows="5" name="user_sig">' . DataUtil::formatForDisplay(pnUserGetVar('user_sig'))
            . '</textarea><br />' . _OPTIONAL . '&nbsp;' . _PROFILE_255CHARMAX . '<br />' . _ALLOWEDHTML . '<br />';
            $AllowableHTML = pnConfigGetVar('AllowableHTML');
            while (list($key, $access,) = each($AllowableHTML)) {
                if ($access > 0) $output .=" &lt;" . $key . "&gt;";
            }
            break;
            case '_EXTRAINFO':
            $output .='<textarea wrap="virtual" cols="50" rows="5" name="bio">' . DataUtil::formatForDisplay(pnUserGetVar('bio')) . '</textarea>&nbsp;<br />' . _PROFILE_CANKNOWABOUT;
            break;

            case '_PASSWORD':
            $output .='<input type="password" name="pass" size="10" maxlength="20" />&nbsp;&nbsp;<input type="password" name="vpass" size="10" maxlength="20" />'
            .'&nbsp;'._TYPENEWPASSWORD;
            break;
            default:
            $output .='Undefined '.$item['prop_id'].', '.$item['prop_label'].', '.$item['prop_dtype'].', '.$item['prop_length'].', '.$item['prop_weight'].', '.$item['prop_validation'];
        }
        break;

        case UDCONST_STRING:
        if (empty($item['prop_length'])) $item['prop_length'] = 30;
        $output .='<input type="text" name="dynadata['.$item['prop_label'].']" value="' . DataUtil::formatForDisplay(pnUserGetVar($item['prop_label'])) . '" size="30" maxlength="'.$item['prop_length'].'" />';
        break;

        case UDCONST_TEXT:
        $output .='<textarea wrap="virtual" cols="50" rows="5" name="dynadata['.$item['prop_label'].']">' . DataUtil::formatForDisplay(pnUserGetVar($item['prop_label'])) . '</textarea>';
        break;

        case UDCONST_FLOAT:
        case UDCONST_INTEGER:
        $output .='<input type="text" name="dynadata['.$item['prop_label'].']" value="' . DataUtil::formatForDisplay(pnUserGetVar($item['prop_label'])) . '" size="30" maxlength="100" />';
        break;
    } // switch

    $output .='</td></tr>';

    return $output;
}
