<?php
/**
 * user small profile plugin
 *
 * @param	$args['user']		object
 * @return	output
 */
function MyProfile_pluginapi_myprofile($args)
{
	$user = $args['user'];
	if (!isset($user) || !is_array($user)) return false;
    $render = pnRender::getInstance('MyProfile');
    // add stylesheet and language
	PageUtil::AddVar('stylesheet', ThemeUtil::getModuleStylesheet('MyProfile'));
	pnModLangLoad('MyProfile','plugin');
	
	// assign data
	$render->assign('user',$args['user']);
	$render->assign('avatar',pnUserGetVar('user_avatar',2));
	$output = $render->fetch('myprofile_plugin_myprofile.htm');
    return $output;
}
?>