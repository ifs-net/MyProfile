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
 * @return       array       The block information
 */
function MyProfile_onlineblock_info()
{
    $dom = ZLanguage::getModuleDomain('MyProfile');
    return array('text_type'      => 'Online',
                 'module'         => 'MyProfile',
                 'text_type_long' => __('Show users that are online now (please customize template myprofile_block_online.htm for your needs)',$dom),
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

	// Use ifs caching method
	$cache = pnModAPIFunc('ifs','cache','get',array('modname' => 'MyProfile', 'cid' => 'online'));
	if ($cache) {
	  	// return cached output
		$blockinfo['content'] = $cache;
		return themesideblock($blockinfo);
	} else {
	    // Get variables from content block
	    $vars = pnBlockVarsFromContent($blockinfo['content']);
	
		// Load Language files (user)
		pnModLangLoad('MyProfile','user');
	    
	    // Create output object
	    $pnRender = pnRender::getInstance('MyProfile',false);
			
	    // Populate block info and pass to theme
	    $blockinfo['content'] = $pnRender->fetch('myprofile_block_online.htm');

		// Cache now
	    pnModAPIFunc('ifs','cache','set',array('modname' => 'MyProfile', 'cid' => 'online', 'content' => $blockinfo['content'],'sec' => 30));

		// return output
	    return themesideblock($blockinfo);
	}
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