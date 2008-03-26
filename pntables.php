<?php
/**
 * Populate pntables array for MyProfile module
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
    $pntable['myprofile_settings'] = $MyProfile."_settings";
    $pntable['myprofile_emailverification'] = $MyProfile."_emailverification";

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
    $pntable['myprofile_settings_column'] = array(
			    'id'					=> 'id',
			    'nocomments'			=> 'nocomments'
			    );
    $pntable['myprofile_settings_column_def'] = array(
    			'id'					=> "I NOTNULL PRIMARY ",
    			'nocomments'			=> "I NOTNULL DEFAULT 0"
    			);

    $pntable['myprofile_emailverification_column'] = array(
			    'id'					=> 'id',
			    'email'					=> 'email',
			    'date'					=> 'date',
			    'code'					=> 'code'
			    );
    $pntable['myprofile_emailverification_column_def'] = array(
    			'id'					=> "I NOTNULL PRIMARY",
				'email'					=> "XL NOTNULL",
				'date'					=> "D NOTNULL",
				'code'					=> "XL NOTNULL"
    			);
    
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
			    'position'				=> 'position'
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
    			'position'				=> "I NOTNULL DEFAULT 0"
				);
    // Return the table information
    return $pntable;
}
?>