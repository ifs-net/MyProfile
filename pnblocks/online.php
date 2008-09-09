<?php
/**
 * initialise block
 * 
 */
function MyProfile_onlineblock_init()
{
    // Security
    pnSecAddSchema('MyProfile:Onlineblock:', 'Block title::');
}

/**
 * get information on block
 * 
 * @author       The PostNuke Development Team
 * @return       array       The block information
 */
function MyProfile_onlineblock_info()
{
    return array('text_type'      => 'Online',
                 'module'         => 'MyProfile',
                 'text_type_long' => 'Show users that are online now',
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
function MyProfile_onlineblock_display($blockinfo)
{
    // Check if the MyProfile module is available. 
    if (!pnModAvailable('MyProfile')) return false;

    // Security check - important to do this as early as possible to avoid
    // potential security holes or just too much wasted processing.  
	// Note that we have MyProfile:Onlineblock: as the component.
    if (!pnSecAuthAction(0,
                         'MyProfile:Onlineblock:',
                         "$blockinfo[title]::",
                         ACCESS_READ)) return false;

    // Get variables from content block
    $vars = pnBlockVarsFromContent($blockinfo['content']);

    // Create output object
    $pnRender =& new pnRender('MyProfile');

    $pnRender->caching = true;
    $pnRender->cache_lifetime = 20;
		
    // Populate block info and pass to theme
    $blockinfo['content'] = $pnRender->fetch('myprofile_block_online.htm');

    return themesideblock($blockinfo);
}


/**
 * modify block settings
 * 
 * @param        array       $blockinfo     a blockinfo structure
 * @return       output      the bock form
 */
function MyProfile_onlineblock_modify($blockinfo)
{
    return;
}


/**
 * update block settings
 * 
 * @param        array       $blockinfo     a blockinfo structure
 * @return       $blockinfo  the modified blockinfo structure
 */
function MyProfile_onlineblock_update($blockinfo)
{
    // Get current content
    $vars = pnBlockVarsFromContent($blockinfo['content']);
	
    // write back the new contents
    $blockinfo['content'] = pnBlockVarsToContent($vars);

    // clear the block cache
    $pnRender =& new pnRender('MyProfile');
    $pnRender->clear_cache('myprofile_block_online.htm');
	
    return $blockinfo;
}

?>