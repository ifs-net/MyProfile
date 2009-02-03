<?php
/**
 * @package      iFS-net.de modules -- common function library
 * @version      $Id$
 * @author       Florian Schießl
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

function mp_urand($min = NULL, $max = NULL){
        static $alreadyGenerated = array();
        $range = ($min && $max) ? ($max - $min) + 1 : NULL;

        do{
            $randValue = ($range) ? rand($min, $max) : rand();
            $key = md5($randValue);
            if(count($rangeList) == $range) return NULL;
            if($range) $rangeList[$key] = $randValue;
        }while($alreadyGenerated[$key]);

        unset($rangeList);
        $alreadyGenerated[$key] = $randValue;
        return $randValue;
    }
?>