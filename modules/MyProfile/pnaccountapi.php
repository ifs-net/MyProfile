<?php
/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schießl
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
 
 /**
 * Return an array of items to show in the your account panel
 *
 * @return   array   
 */
function MyProfile_accountapi_getall($args)
{
    $dom = ZLanguage::getModuleDomain('MyProfile');
    // Create an array of links to return
    pnModLangLoad('MyProfile');
    $items = array(
					array(	'url'     => pnModURL('MyProfile', 'user','main'),
                         	'title'   => __('My profile data', $dom),
                        	 'icon'    => 'accountbutton.gif')
                        	 ,
					array(	'url'     => pnModURL('MyProfile', 'user','settings',array('mode' => 'password')),
                         	'title'   => __('My password', $dom),
                         	'icon'    => 'keybutton.gif')
							 ,
					array(	'url'     => pnModURL('MyProfile', 'user','settings',array('mode' => 'email')),
                         	'title'   => __('My email address', $dom),
                         	'icon'    => 'mailbutton.gif')
							 );
    // Return the items
    return $items;
}