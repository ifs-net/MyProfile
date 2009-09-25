<?php

/*
 * get plugins with type / title
 *
 * @param   $args['id']     int     optional, show specific one or all otherwise
 * @return  array
 */
function MyProfile_mailzapi_getPlugins($args)
{
    // Load language definitions
    pnModLangLoad('MyProfile','mailz');
    
    $plugins = array();
    // Add first plugin.. You can add more using more arrays
    $plugins[] = array(
        'pluginid'      => 1,   // internal id for this module
        'title'         => _MYPROFILE_NEW_MEMBERS,
        'description'   => _MYPROFILE_NEW_MEMBERS_DESCRIPTION,
        'module'        => 'MyProfile'
    );
    return $plugins;
}

/*
 * get content for plugins
 *
 * @param   $args['pluginid']       int         id number of plugin (internal id for this module, see getPlugins method)
 * @param   $args['params']         string      optional, show specific one or all otherwise
 * @param   $args['uid']            int         optional, user id for user specific content
 * @param   $args['contenttype']    string      h or t for html or text
 * @param   $args['last']           datetime    timtestamp of last newsletter
 * @return  array
 */
function MyProfile_mailzapi_getContent($args)
{
    // Load language definitions
    pnModLangLoad('MyProfile','mailz');
    switch ($args['pluginid']) {
        case 1:
            $tables = pnDBGetTables();
            $uc = $tables['users_column'];
            // Get latest members
            $orderby = (string) $args['params']['orderby'];
            if (!isset($orderby) || ($orderby == '')) {
                $orderby = $uc['user_regdate'].' DESC';
            }
            $columns = (string) $args['params']['columns'];
            if (!isset($columns) || ($columns == '')) {
                return "NO COLUMNS SPECIFIED - USE PARAMETER columns WITH ITEMS SEPARATED WITH ,";
            } else {
                $columns = str_replace(' ', '', $columns);
                $columns = explode(',', $columns);
            }
            $days = (int) $args['params']['days'];
            if ($days > 0) {
                $sincedate = date("Y-m-d H:i:s",(time()-($days*24*60*60)));
            } else {
                $last = $args['last'];
                if (isset($last) && ($last != '') && ($last != '0000-00-00 00:00:00')) {
                    $sincedate = $last;
                } else {
                    $sincedate = date("Y-m-d",(time()-(24*60*60*35)));
                }
            }
            $columnArray = array (
                'id'
            );
            $where = $uc['user_regdate']." > '".$sincedate."'";
        	$joinInfo[] = array (	'join_table'          =>  'users',			// table for the join
		          					'join_field'          =>  array('uname','user_regdate'),			// field in the join table that should be in the result with
                                   	'object_field_name'   =>  array('uname','user_regdate'),			// ...this name for the new column
                                    'compare_field_table' =>  'id',				// regular table column that should be equal to
                                 	'compare_field_join'  =>  'uid');			// ...the table in join_table
            $result = DBUtil::selectExpandedObjectArray('myprofile',$joinInfo,$where,$orderby,'','','','','',$columnArray);

            if (!$result) {
                return 'ERROR READING LATEST USER INFORMATION';
            }
            foreach ($result as $item) {
                $profile = pnModAPIFunc('MyProfile','user','getProfile',array('uid' => $item['id']));
                $p = array();

                foreach ($columns as $column) {
                    
                    $c['identifier']  = $profile[$column]['identifier'];
                    $c['description'] = $profile[$column]['description'];
                    $c['value']       = $profile[$column]['value'];
                    $cc[] = $c;
                }
                foreach ($cc as $k=>$v) {
                    $ccc[$v['identifier']] = $v;
                }

                    $p = array (
                        'uname'     => $item['uname'],
                        'uid'       => $item['id'],
                        'data'      => $ccc
                    );
                    $resList[] = $p;

                unset($profile);
            }
//            prayer($resList);

            $counter = 0;
            if ($args['contenttype'] == 't') {
                $output="\n";
                foreach ($resList as $item) {
                    foreach ($item['data'] as $i) {
                        $output.=$i['value'].", ";
                    $counter++;
                    }
                    $output.=" ".$item['uname']." \n";
                }
                $output.= '> '._MYPROFILE_SUM." ".$counter." "._MYPROFILE_MEMBERS." ".$sincedate."\n";
            } else {
                $th = $resList[0];
                $render = pnRender::getInstance('MyProfile');
                $render->assign('latest', $resList);
                $render->assign('th', $th['data']);
                $render->assign('sincedate', $sincedate);
                $output = $render->fetch('myprofile_mailz_latest.htm');
            }
            return $output;
            break;
        default:
            return 'wrong plugin id given';
    }

    // return emtpy string because we do not need anything to display in here...    
    return '';
}

