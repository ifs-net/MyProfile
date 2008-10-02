<?php

/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schießl
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

function smarty_function_showmap($params, &$smarty) 
{
	$coord = $params['coord'];
	if (!isset($coord) || ($coord == '')) return;
	$coord = unserialize($coord);
	$lat = $coord['lat'];
	$lng = $coord['lng'];
	echo "lat [".$lng."], lng [".$lat."]";
    return; 
}      

