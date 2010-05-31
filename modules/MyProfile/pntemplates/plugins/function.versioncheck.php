<?php
/**
 * @package      advMailer
 * @version      $Id:  $
 * @author       Florian Schießl
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2009
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

function smarty_function_versioncheck($params, &$smarty) 
{
    // check module version
    // some code based on work from Axel Guckelsberger - thanks for this inspiration
    $currentversion = pnModGetInfo(pnModGetIDFromName($params['module']));
    $currentversion = trim($currentversion['version']);
    
    // current version           
    $output = "<p>".$currentversion;
    
    // get newest version number
    require_once('Snoopy.class.php');
    $snoopy = new Snoopy;
    $snoopy->fetchtext("http://updates.zksoft.de/zikula/MyProfile.txt");

    $newestversion = $snoopy->results;
    $newestversion = trim($newestversion);   
    if (!$newestversion) { 
      // newest version check not possible, so return only current version number
      echo($output." (installation is up to date)</p>");
      return; 
    }  
    
    if ($currentversion != $newestversion) {
      // generate info link if new version is available
      $output .= " (<strong><a href=\"http://www.ifs-net.de/\">Please update! Update available! Latest release: ".$newestversion."</a></strong>)</p>";
    }   
    echo($output);
    return; 
}      

