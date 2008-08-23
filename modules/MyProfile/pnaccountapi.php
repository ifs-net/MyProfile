<?php
/**
 * Return an array of items to show in the your account panel
 *
 * @return   array   
 */
function MyProfile_accountapi_getall($args)
{
    // Create an array of links to return
    pnModLangLoad('MyProfile');
    $items = array(
					array(	'url'     => pnModURL('MyProfile', 'user','main'),
                         	'title'   => _MYPROFILEPROFILEDATA,
                        	 'icon'    => 'accountbutton.gif')
                        	 ,
					array(	'url'     => pnModURL('MyProfile', 'user','settings',array('mode' => 'password')),
                         	'title'   => _MYPROFILEPASSWORD,
                         	'icon'    => 'keybutton.gif')
							 ,
					array(	'url'     => pnModURL('MyProfile', 'user','settings',array('mode' => 'email')),
                         	'title'   => _MYPROFILEMAILADDRESS,
                         	'icon'    => 'mailbutton.gif')
							 );
    // Return the items
    return $items;
}
