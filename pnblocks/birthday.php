<?php
/**
 * initialise block
 * 
 */
function MyProfile_birthdayblock_init()
{
    // Security
    pnSecAddSchema('MyProfile:Birthdayblock:', 'Block title::');
}

/**
 * get information on block
 * 
 * @author       The PostNuke Development Team
 * @return       array       The block information
 */
function MyProfile_birthdayblock_info()
{
    return array('text_type'      => 'Birthday',
                 'module'         => 'MyProfile',
                 'text_type_long' => 'Show nicknames that celebrate their birthday today',
                 'allow_multiple' => true,
                 'form_content'   => false,
                 'form_refresh'   => false,
                 'show_preview'   => true);
}

/**
 * display block
 * 
 * @param        array       $blockinfo     a blockinfo structure
 * @return       output      the rendered bock
 */
function MyProfile_birthdayblock_display($blockinfo)
{
    // Check if the MyProfile module is available. 
    if (!pnModAvailable('MyProfile')) return false;

    // Security check
    if (!SecurityUtil::checkPermission('MyProfile:birthdayblock', "$blockinfo[title]::", ACCESS_READ)) return false;

    // Get variables from content block
    $vars = pnBlockVarsFromContent($blockinfo['content']);

    $datedatafield				= $vars['datedatafield'];
    $restrictiondatafield		= $vars['restrictiondatafield'];
    $restrictiondatafieldvalue	= $vars['restrictiondatafieldvalue'];


    // Create output object
    $pnRender = pnRender::getInstance('MyProfile');
	
    $items=pnModAPIFunc('MyProfile','user','getBirthdays',array(
			'datedatafield'				=> $datedatafield,
			'restrictiondatafield'		=> $restrictiondatafield,
			'restrictiondatafieldvalue'	=> $restrictiondatafieldvalue));
    $pnRender->assign('items', $items);
	
    // Populate block info and pass to theme
    $blockinfo['content'] = $pnRender->fetch('myprofile_block_birthday.htm');

    return themesideblock($blockinfo);
}


/**
 * modify block settings
 * 
 * @param        array       $blockinfo     a blockinfo structure
 * @return       output      the bock form
 */
function MyProfile_birthdayblock_modify($blockinfo)
{
    // Get current content
    $vars = pnBlockVarsFromContent($blockinfo['content']);

    // Defaults
    if (empty($vars['datedatafield'])) {
        $vars['datedatafield'] = '';
    }
    if (empty($vars['restrictiondatafield'])) {
        $vars['restrictiondatafield'] = '';
    }
    if (empty($vars['restrictiondatafieldvalue'])) {
        $vars['restrictiondatafieldvalue'] = '';
    }

    // Create output object
    $pnRender = pnRender::getInstance('MyProfile');

    // As Admin output changes often, we do not want caching.
    if (date("H",time()) > 23 ) {
	    $pnRender->caching = false;
	}
	else {
	    $pnRender->caching = true;
	    $pnRender->cache_lifetime = 3500;  
	}

	// get fields
	$fields = pnModAPIFunc('MyProfile','admin','getFields');
	$res = array();
	$allfields = array();
	foreach ($fields as $field) {
	  	// only select date fields for date field selector
	  	if ($field['fieldtype'] == 'DATE') $res[]=$field['identifier'];
	  	$allfields[]=$field['identifier'];
	}

	$pnRender->assign('fields',						$res);
	$pnRender->assign('allfields',					$allfields);

    // assign the approriate values
    $pnRender->assign('datedatafield', 				$vars['datedatafield']);
    $pnRender->assign('restrictiondatafield', 		$vars['restrictiondatafield']);
    $pnRender->assign('restrictiondatafieldvalue', 	$vars['restrictiondatafieldvalue']);

    // Return the output that has been generated by this function
    return $pnRender->fetch('myprofile_block_birthday_modify.htm');
}


/**
 * update block settings
 * 
 * @param        array       $blockinfo     a blockinfo structure
 * @return       $blockinfo  the modified blockinfo structure
 */
function MyProfile_birthdayblock_update($blockinfo)
{
    // Get current content
    $vars = pnBlockVarsFromContent($blockinfo['content']);
	
    // alter the corresponding variable
    $vars['datedatafield'] = 				FormUtil::getPassedValue('datedatafield');
    $vars['restrictiondatafield'] = 		FormUtil::getPassedValue('restrictiondatafield');
    $vars['restrictiondatafieldvalue'] = 	FormUtil::getPassedValue('restrictiondatafieldvalue');
	
    // write back the new contents
    $blockinfo['content'] = pnBlockVarsToContent($vars);

    // clear the block cache
    $pnRender = pnRender::getInstance('MyProfile');
    $pnRender->clear_cache('myprofile_block_birthday.htm');
	
    return $blockinfo;
}

?>