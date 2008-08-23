<?php
/**
 * PostNuke Application Framework
 *
 * @copyright (c) 2002, PostNuke Development Team
 * @link http://www.postnuke.com
 * @version $Id: function.dudoptionalitemmodify.php 23038 2007-10-23 09:10:57Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 *
 * Dynamic User data Module
 *
 * @package      PostNuke_System_Modules
 * @subpackage   Profile
 */


/**
 * Smarty function to display an editable dynamic user data field
 *
 * Example
 * <!--[dudoptionalitemmodify proplabel="_YICQ"]-->
 *
 * Example
 * <!--[dudoptionalitemmodify proplabel="_YICQ" uid=$uid]-->
 *
 * @author       Mark West
 * @since        21/01/04
 * @see          function.exampleadminlinks.php::smarty_function_exampleadminlinks()
 * @param        array       $params         All attributes passed to this function from the template
 * @param        object      &$smarty        Reference to the Smarty object
 * @param        string      $item           The Profile DUD item
 * @param        string      $uid            User ID to display the field value for
 * @param        string      $tableless      Don't use tables to render the markup (optional - default true)
 * @param        string      $class          CSS class to assign to the table row/form row div (optional)
 * @return       string      the results of the module function
 */
function smarty_function_dudoptionalitemmodify($params, &$smarty)
{
    extract($params);
    unset($params);

    if (!pnModAvailable('Profile')) {
        return;
    }

    if (!isset($item) || empty ($item)) {
        return;
    }

    if ($item['prop_label'] == '_PASSWORD') {
        return;
    }

    if (!isset($uid)) {
        $uid = pnUserGetVar('uid');
    }
    if (!isset($tableless) || !is_bool($tableless)) {
        $tableless = true;
    }
    if (!isset($class) || !is_bool($class)) {
        $class = '';
    }

    // language define
    $prop_label_text = '';
    $prop_label_text = (defined($item['prop_label']) ? constant($item['prop_label']) : $item['prop_label']);

    if (empty($prop_label_text)) {
        $prop_label_text = $item['prop_label'];
    }

    if (isset($item['temp_propdata'])) {
        $uservalue = $item['temp_propdata'];
    } else {
        $alias = pnModAPIFunc('Profile',
                              'user',
                              'sqlalias',
                              array('fieldlabel' => $item['prop_label']));

        $uservalue = pnUserGetVar($alias, $uid);
    }

    $pnRender = pnRender::getInstance('Profile', false);

    // assign the default values for the control
    $pnRender->assign('tableless',     $tableless);
    $pnRender->assign('class',         $class);
    $pnRender->assign('value',         $uservalue);
    $pnRender->assign('prop_label',    $item['prop_label']);
    $pnRender->assign('prop_id',       str_replace('_', '', strtolower($item['prop_label'])));
    $pnRender->assign('proplabeltext', $prop_label_text);
    $pnRender->assign('required',      $item['prop_required']);
    $pnRender->assign('note',          $item['prop_note']);
    $pnRender->assign('properror',     isset($item['prop_error']) ? $item['prop_error'] : '');
    $pnRender->assign('tempdata',      isset($item['temp_propdata']) ? $item['temp_propdata'] : '');

    // Excluding Timezone of the generics
    if ($item['prop_label'] == '_TIMEZONEOFFSET') {
        if (empty($uservalue)) $uservalue = pnConfigGetVar('timezone_offset');
        $tzinfo = pnModGetVar(PN_CONFIG_MODULE, 'timezone_info');

        foreach ($tzinfo as $tzindex => $tzdata) {
            $listoptions[] = $tzindex;
            $listoutput[]  = $tzdata;
            if ($uservalue == $tzindex) {
                 $selectedvalue = $uservalue;
            }
        }

        $selectmultiple = '';

        $pnRender->assign('selectedvalue',  $selectedvalue);
        $pnRender->assign('selectmultiple', $selectmultiple);
        $pnRender->assign('listoptions',    $listoptions);
        $pnRender->assign('listoutput',     $listoutput);
        return $pnRender->fetch('profile_user_dudselect.htm');
    }

    if ($item['prop_label'] == '_YOURAVATAR') {
        if (empty($uservalue)) $uservalue = 'blank.gif';

        $handle = opendir('images/avatar');
        while (false !== ($file = readdir($handle))) {
            $filelist[] = $file;
        }
        asort($filelist);
        while (list ($key, $file) = each ($filelist)) {
            ereg('.gif|.jpg', $file);
            if ($file != '.' && $file != '..' && $file != 'index.html' && $file != 'CVS' && $file != '.svn') {
                $listoptions[] = $file;
                $listoutput[]  = $file;

                if ($file == $uservalue) {
                    $selectedvalue = $uservalue;
                }
            }
        }

        $selectmultiple = '';

        $pnRender->assign('selectedvalue',  $selectedvalue);
        $pnRender->assign('selectmultiple', $selectmultiple);
        $pnRender->assign('listoptions',    $listoptions);
        $pnRender->assign('listoutput',     $listoutput);
        return $pnRender->fetch('profile_user_dudselect.htm');
    }

    switch($item['prop_displaytype']) {
        case 0: // TEXT
            $type = 'text';
            break;
        case 1: // TEXTAREA
            $type = 'textarea';
            break;
        case 2: // CHECKBOX
            $type = 'checkbox';
            break;
        case 3: // RADIO
            $type = 'radio';
            $pnRender->assign('selectedvalue', $uservalue);
            $item['prop_listoptions'] = str_replace(Chr(13), '', str_replace(Chr(13), '', $item['prop_listoptions']));
            $list = array_splice(explode('@@', $item['prop_listoptions']), 1);
            $pnRender->assign('listoptions',   $list);
            $pnRender->assign('listoutput',    $list);
            $pnRender->assign('note',          $item['prop_note']);
            break;
        case 4: // SELECT
            $type = 'select';
            if ($item['multiple'] == 1) {
                $selectmultiple = ' multiple';
            } else {
                $selectmultiple = '';
            }
            $pnRender->assign('selectedvalue',  $uservalue);
            $pnRender->assign('selectmultiple', $selectmultiple);
            $item['prop_listoptions'] = str_replace(Chr(13), '', $item['prop_listoptions']);
            $list = array_splice(explode('@@', $item['prop_listoptions']), 1);
            $pnRender->assign('listoptions',    $list);
            $pnRender->assign('listoutput',     $list);
            break;
        case 5: // DATE
            $type = 'date';
            break;
        case 6: // EXTDATE
            $type = 'extdate';
            $pnRender->assign('value',         explode('-', $uservalue));
            break;
        case 7: // COMBOTEXT
            $type = 'combotext';
            $pnRender->assign('value',         unserialize($uservalue));

            $first_break  = ';';
            $second_break = ',';

            $first = explode($first_break, $item['prop_validation']);

            for ($k = 0; $k < count($first); $k++) {
                list($id, $val) = split($second_break, $first[$k]);
                $array[] = array('id'    => $id,
                                 'value' => $val);

            }
            $pnRender->assign('validation',    $array);
            break;
        default: // TEXT
            $type = 'text';
            break;
    }

    $output = $pnRender->fetch('profile_user_dud'.$type.'.htm');

    return $output;
}
