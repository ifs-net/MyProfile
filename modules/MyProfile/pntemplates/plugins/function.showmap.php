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
	if (pnModAvailable('MyMap')) {
		$coords[] = array(
					'lat'	=> $lat,
					'lng'	=> $lng
					);
		$mapcode = pnModAPIFunc('MyMap','user','generateMap',array(
					'coords'	=> $coords,		// must be an array
					'maptype'	=> 'HYBRID',	// HYBRID, SATELLITE or NORMAL
					'width'		=> 300,			// width in pixels
					'height'	=> 200,			// height in pixels
					'zoomfactor' => 8			// zoomfactor - 1 is closest
					));							// zoomfactor only relevant if there is
												// only one marker displayed!
		echo $mapcode;
	}
	else echo "lat [".$lng."], lng [".$lat."]";
    return; 
}      

