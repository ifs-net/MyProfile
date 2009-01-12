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
 * Populate tables array for MyProfile module
 *
 * @return       array       The table information.
 */
function MyProfile_pntables()
{
    // Initialise table array
    $pntable = array();

    $MyProfile = pnConfigGetVar('prefix') . '_myprofile';

    // Set the table name
    $pntable['myprofile'] = $MyProfile;
    $pntable['myprofile_fields'] = $MyProfile."_fields";
    $pntable['myprofile_confirmedusers'] = $MyProfile."_confirmedusers";
    $pntable['myprofile_templates'] = $MyProfile."_templates";
    $pntable['myprofile_stats'] = $MyProfile."_stats";

    // Set the column names.  Note that the array has been formatted
    // on-screen to be very easy to read by a user.
    $pntable['myprofile_column'] = array(
			    'id'      				=> 'id',
			    'timestamp'				=> 'timestamp'
			    );
    $pntable['myprofile_column_def'] = array(
    			'id'					=> "I NOTNULL PRIMARY",
    			'timestamp'				=> "D NOTNULL"
    			);
	// this part loads the dynamical data into the tables array
	$configfile = 'modules/MyProfile/config/tabledef.inc';
	if (file_exists($configfile)) {
		Loader::loadClass('FileUtil');
		$array = unserialize(FileUtil::readFile($configfile));
		foreach ($array['column'] as $c) $pntable['myprofile_column'][$c['key']] =  $c['value'];
		foreach ($array['column_def'] as $c) $pntable['myprofile_column_def'][$c['key']] =  $c['value'];
	};
    $pntable['myprofile_fields_column'] = array (
			    'id'					=> 'id',
			    'identifier'			=> 'identifier',
			    'mandatory'				=> 'mandatory',
			    'description'			=> 'description',
			    'fieldtype'				=> 'type',
			    'list'					=> 'list',
			    'public_status'			=> 'public_status',
			    'num_minvalue'			=> 'num_minvalue',
			    'num_maxvalue'			=> 'num_maxvalue',
			    'str_length'			=> 'str_length',
			    'position'				=> 'position',
			    'active'				=> 'active',
			    'shown'					=> 'shown',
			    'position'				=> 'position',
			    'searchable'			=> 'searchable'
			    );
    $pntable['myprofile_fields_column_def'] = array (
    			'id'					=> "I AUTOINCREMENT PRIMARY",
    			'identifier'			=> "XL NOTNULL DEFAULT ''",
    			'mandatory'				=> "I(1) NOTNULL DEFAULT 0",
    			'description'			=> "XL NOTNULL DEFAULT ''",
    			'fieldtype'				=> "XL NOTNULL DEFAULT ''",
    			'list'					=> "XL NOTNUL DEFAULT ''",
    			'public_status'			=> "I(1) NOTNULL DEFAULT 0",
    			'num_minvalue'			=> "XL NOTNULL DEFAULT ''",
    			'num_maxvalue'			=> "XL NOTNULL DEFAULT ''",
    			'str_length'			=> "I NOTNULL",
    			'active'				=> "I(1) NOTNULL DEFAULT 0",
    			'shown'					=> "I(1) NOTNULL DEFAULT 0",
    			'position'				=> "I NOTNULL DEFAULT 0",
    			'searchable'			=> "I(1) NOTNULL DEFAULT 0"
				);

	// template-table
    $pntable['myprofile_templates_column'] = array(
			    'id'      				=> 'id',
			    'template'				=> 'template'
			    );
    $pntable['myprofile_templates_column_def'] = array(
    			'id'					=> "I NOTNULL PRIMARY",
    			'template'				=> "XL NOTNULL DEFAULT ''"
    			);

	// statistic table
    $pntable['myprofile_stats_column'] = array(
			    'day'      				=> 'day',	// day counted from unix timestamp's birth :-)
			    'users'					=> 'users',
			    'users_active'			=> 'users_active',
			    'users_14d'				=> 'users_14d',
			    'users_30d'				=> 'users_30d',
			    'users_60d'				=> 'users_60d',
			    'users_90d'				=> 'users_90d',
			    'users_180d'			=> 'users_180d',
			    'users_365d'			=> 'users_365d',
			    'users_new30d'			=> 'users_new30d',
			    'myprofile'				=> 'myprofile',
			    'noprofile'				=> 'noprofile',
			    'invalidemail'			=> 'invalidemail',
			    'invalidemail30d'		=> 'invalidemail30d'
			    );
    $pntable['myprofile_stats_column_def'] = array(
    			'day'					=> "I NOTNULL PRIMARY",
    			'users'					=> "I NOTNULL DEFAULT '0'",
    			'users_active'			=> "I NOTNULL DEFAULT '0'",
    			'users_14d'				=> "I NOTNULL DEFAULT '0'",
    			'users_30d'				=> "I NOTNULL DEFAULT '0'",
    			'users_60d'				=> "I NOTNULL DEFAULT '0'",
    			'users_90d'				=> "I NOTNULL DEFAULT '0'",
    			'users_180d'			=> "I NOTNULL DEFAULT '0'",
    			'users_365d'			=> "I NOTNULL DEFAULT '0'",
    			'users_new30d'			=> "I NOTNULL DEFAULT '0'",
    			'myprofile'				=> "I NOTNULL DEFAULT '0'",
    			'noprofile'				=> "I NOTNULL DEFAULT '0'",
    			'invalidemail'			=> "I NOTNULL DEFAULT '0'",
    			'invalidemail30d'		=> "I NOTNULL DEFAULT '0'",
    			'template'				=> "XL NOTNULL DEFAULT ''"
    			);
    			
	// confirmed_users
    $pntable['myprofile_confirmedusers_column'] = array(
			    'id'      				=> 'id',
			    'uid'					=> 'uid',
			    'confirmed_uid'			=> 'confirmed_uid'
			    );
    $pntable['myprofile_confirmedusers_column_def'] = array(
    			'id'					=> "I AUTOINCREMENT PRIMARY",
    			'uid'					=> "I NOTNULL DEFAULT 0",
    			'confirmed_uid'			=> "I NOTNULL DEFAULT 0"
    			);

    // Return the table information
    return $pntable;
}
?>