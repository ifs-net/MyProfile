<?php
/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schießl
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2009
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */ 
 
function mp_admin_sendNotification($obj) {
  	$notification = pnModGetVar('MyProfile','notification');
  	if ($notification == 1) {
	  	// get profile
	  	$profile = pnModAPIFunc('MyProfile','user','getProfile',array('uid' => $obj['id']));
		// Get vars
	    $sitename 	= pnConfigGetVar('sitename');
	    $to 		= pnConfigGetVar('adminmail');
	    $subject = __('New profile', $dom).' '.__('at', $dom).' '.$sitename;
		$body = pnUserGetVar('uname',$obj['id'])." - ".pnUserGetVar('email',$obj['id'])."\n\n";
		foreach ($profile as $p) {
		  	if ($p['fieldtype'] != 'COORD') {
				$body.=$p['description'].": ".$p['value']."\n";
			} 
		}
		pnMail($to, $subject, $body, array('header' => '\nMIME-Version: 1.0\nContent-type: text/plain'), false);
	}
    return true;
}