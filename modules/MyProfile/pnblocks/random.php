<?php
/**
 * @package      MyProfile
 * @version      $Id $
 * @author       Florian Schie�l
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

/**
 * initialise block
 * 
 */
function MyProfile_randomblock_init()
{
    // Security
    pnSecAddSchema('MyProfile:randomblock:', 'Block title::');
}

/**
 * get information on block
 * 
 * @return       array       The block information
 */
function MyProfile_randomblock_info()
{
    return array('text_type'      => 'random',
                 'module'         => 'MyProfile',
                 'text_type_long' => 'Show random users',
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
function MyProfile_randomblock_display($blockinfo)
{
    // Check if the MyProfile module is available. 
    if (!pnModAvailable('MyProfile')) return false;

    // Security check
    if (!SecurityUtil::checkPermission('MyProfile:birthdayblock', "$blockinfo[title]::", ACCESS_READ)) return false;
    
    // Get variables from content block
    $vars = pnBlockVarsFromContent($blockinfo['content']);

    $numitems=$vars['numitems'];
    
    if (!isset($numitems)) $numitems = 10;

    // Create output object
    $pnRender =  pnRender::getInstance('MyProfile');
	
    $pnRender->caching = true;
    $pnRender->cache_lifetime = 3600; // cache for 1 hour

    $items=pnModAPIFunc('MyProfile','user','getrandom',array('numitems'=>$numitems));
    $pnRender->assign('items', $items);
    // Populate block info and pass to theme
    $blockinfo['content'] = $pnRender->fetch('myprofile_block_random.htm');

    return themesideblock($blockinfo);
}


/**
 * modify block settings
 * 
 * @param        array       $blockinfo     a blockinfo structure
 * @return       output      the bock form
 */
function MyProfile_randomblock_modify($blockinfo)
{
    // Get current content
    $vars = pnBlockVarsFromContent($blockinfo['content']);

    // Defaults
    if (empty($vars['numitems'])) {
        $vars['numitems'] = 10;
    }

	// Load language from newbies block - the define we need is there
	pnModLangLoad('MyProfile','newbies');

    // Create output object
    $pnRender = pnRender::getInstance('MyProfile');

    // As Admin output changes often, we do not want caching.
    $pnRender->caching = false;

    // assign the approriate values
    $pnRender->assign('numitems', $vars['numitems']);

    // Return the output that has been generated by this function
    return $pnRender->fetch('myprofile_block_newbies_modify.htm');
}


/**
 * update block settings
 * 
 * @param        array       $blockinfo     a blockinfo structure
 * @return       $blockinfo  the modified blockinfo structure
 */
function MyProfile_randomblock_update($blockinfo)
{
    // Get current content
    $vars = pnBlockVarsFromContent($blockinfo['content']);
	
    // alter the corresponding variable
    $vars['numitems'] = FormUtil::getPassedValue('numitems');
	
    // write back the new contents
    $blockinfo['content'] = pnBlockVarsToContent($vars);

    // clear the block cache
    $pnRender = pnRender::getInstance('MyProfile');
    $pnRender->clear_cache('myprofile_block_random.htm');
	
    return $blockinfo;
}

?>