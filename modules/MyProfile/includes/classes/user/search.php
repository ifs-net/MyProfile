<?php
/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schie�l
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

class MyProfile_user_SearchHandler
{
  	var $fields;
  	var $page;
	function initialize(&$render)
	{	    
	  	// Admins should be able to modify user's profile data
	  	$fields = pnModAPIFunc('MyProfile','admin','getFields');
	  	$fieldsResult = array();
	  	$items_orderby = array(array ('text' => _MYPROFILEUNAME, 'value' => 'uname'));
		$viewer_uid = pnUserGetVar('uid');
	  	foreach ($fields as $field) {
			// status codes:
			// 0 = visible for guests 
			// 1 = visible for logged in users
			// 2 = visible for administrators only
			$is_admin = SecurityUtil::checkPermission('MyProfile::', '::', ACCESS_ADMIN);
			if (!pnUserLoggedIn()) 	$mystatus = 0;	// guest
			else if ($is_admin) 	$mystatus = 10;	// admin should see everything
			else 					$mystatus = 1;	// registered users
			
		    if (	
				( // first check: field is searchable and the admin was no fool and said separator should be searchable? :-P
				($field['fieldtype'] != 'SEPARATOR')
				&&
				($field['searchable'] == 1)
				&&
				($field['fieldtype'] != 'COORD')
				)
				&&
				( // we will also look at the field's visibility and not show member fields to guests and admin fields to logged in users
					$mystatus >= $field['public_status']
				)
			) {
			  	if (is_array($field['dropdownitems'])) $field['items'] = $field['dropdownitems'];
			  	else if (is_array($field['radioitems'])) $field['items'] = $field['radioitems'];
				$fieldsResult[] = $field;
				$items_orderby[] = array ('text' => $field['description'], 'value' => $field['identifier']);
			}
		}
		$render->assign('items_orderby', 	$items_orderby);
		$render->assign('fields', 			$fieldsResult);
		$render->assign('allowmemberlist',	pnModGetVar('MyProfile','allowmemberlist'));
		$this->fields = $fields;
		$items_searchoptions = array (
				array(	'text' => _MYPROFILESOFT, 	'value' => 'soft'),
				array(	'text' => _MYPROFILEEXACT, 	'value' => 'exact')
			);
		$items_connector = array (
				array(	'text' => _MYPROFILEAND,	'value' => 'and'),
				array(	'text' => _MYPROFILEOR,		'value' => 'or')
			);
		$items_ascdesc = array (
				array(	'text' => _MYPROFILEASC,	'value' => 'ASC'),
				array(	'text' => _MYPROFILEDESC,	'value' => 'DESC')
			);
		$render->assign('items_searchoptions',$items_searchoptions);
		$render->assign('items_connector',$items_connector);
		$render->assign('items_ascdesc',$items_ascdesc);
		$customtemplate = pnModGetVar('MyProfile','searchtemplate');
		if (file_exists('modules/MyProfile/pntemplates/'.$customtemplate)) $render->assign('customTemplate', $customtemplate);
		$this->pager($render);
		return true;
    }
	function handleCommand(&$render, &$args)
	{
		if ($args['commandName']=='prevPage') {
		  	$this->page--;
		  	$args['commandName'] = 'update';
		}
		if ($args['commandName']=='nextPage') {
		  	$this->page++;
		  	$args['commandName'] = 'update';
		}
		if ($args['commandName']=='update') {
			// get the pnForm data and do a validation check
		    $obj = $render->pnFormGetValues();		    
			
			// now we'll have to construct the where statement. This might geht a little bit tricky...

			$tables = pnDBGetTables();
			$mp_column 	= $tables['myprofile_column'];
			$u_column	= $tables['users_column'];
			
			// check for search mode first
			if ($obj['searchoption'] == 'soft') $w = '%';
			if ($obj['connector'] == 'and')	$connector = 'AND';
			else $connector = 'OR';

			// lets start the search now
			$whereArray = array();
			$where = "";
			// username first
			if ($obj['uname'] != '') {
			  	$whereArray[]= "a.".$u_column['uname']." like '".$w.DataUtil::formatForStore($obj['uname']).$w."'";
			}
			// now all other searchable fields
			foreach ($this->fields as $field) {
			  	if ($obj[$field['identifier']] != "") {
			  	  	if (is_array($obj[$field['identifier']]) && (count($obj[$field['identifier']]) > 0)) {
			  	  	  	// we have to work with an array now... and in this array, we have to use the OR link
			  	  	  	$or_where = array();
			  	  	  	foreach ($obj[$field['identifier']] as $item) {
							$or_where[] = "tbl.MyProfile_".$field['identifier']." like '" .DataUtil::formatForStore($item)."'";
						}
						if (is_array($or_where) && (count($or_where) > 0)) $whereArray[] = $or_where;
					}
					else if (!is_array($obj[$field['identifier']])) {
					  $whereArray[]= "tbl.MyProfile_".$field['identifier']." like '" .$w.DataUtil::formatForStore($obj[$field['identifier']]).$w."'";
					}
				}
			}
		
			// now construct the where...
			$link = false;
			foreach ($whereArray as $a) {
			  	if ($link) $where.=" ".$connector." ";
			  	else $link = true;
				if (!is_array($a)) {
					$where.=$a;
				}
				else {
				  	$where.=" ( ";
				  	$or = false;
				  	foreach ($a as $a_or) {
				  	  	if ($or) $where.=" OR ";
				  	  	else $or = true;
					    $where.=$a_or;
					}
				  	$where.=" ) ";
				}
			}
			
			// make it possible to show all members as result?
			if ((count($whereArray) == 0) && (pnModGetVar('MyProfile','allowmemberlist') == 1)) $whereArray[] = "tbl.id > 0";
			
			if (count($whereArray) > 0) {
			  	// what is the orderby value?
			  	$order = $obj['orderby'];
			  	if ($order == 'uname') $orderby = "a.".$u_column['uname'];
				else $orderby = "tbl.MyProfile_".DataUtil::formatForStore($order);
				// get asc or desc
			  	$ascdesc = $obj['ascdesc'];
			  	if ($ascdesc == 'ASC') $orderby.=" ASC";
			  	else $orderby.=" DESC";
				// We need this to make a join with the users table
				$joinInfo[] = array (	'join_table'          =>  'users',			// table for the join
										'join_field'          =>  'uname',			// field in the join table that should be in the result with
			                         	'object_field_name'   =>  'uname',			// ...this name for the new column
			                         	'compare_field_table' =>  'id',				// regular table column that should be equal to
			                         	'compare_field_join'  =>  'uid');			// ...the table in join_table
	
				// now get the results counted only
				$result = DBUtil::selectExpandedObjectArray('myprofile',$joinInfo,$where,$orderby);
				$resultCount = count($result);
				unset($result);
				// and now get the selected page
				if (!($this->page > 0)) $this->page = 1;
				$limit 	=  (int)pnModGetVar('MyProfile','resultsperpage');
				if (!($limit > 0)) $limit = 50;
				$startwith = ($this->page*$limit)-$limit;
				$pages = (int)($resultCount/$limit);
				if (($resultCount % $limit) > 0) $pages++;
				if ($this->page > $pages) $this->page = $pages;
				$result = DBUtil::selectExpandedObjectArray('myprofile',$joinInfo,$where,$orderby,$startwith,$limit);
				// assign data to template
				$render->assign('resultCount', 	$resultCount);
				$render->assign('result', 		$result);
				$render->assign('page',			$this->page);
				$render->assign('pages',		$pages);
				$this->pager($render, $pages, $resultCount);
			}
		}
		return true;
    }
	function pager(&$render, $pages, $resultCount)
	{
   		// assign values for pager controlling
		if (($this->page == 1) 		|| (!isset($resultCount))) 	$render->assign('previousButtonStyle', 	"myprofile_hidden");
		else $render->assign('previousButtonStyle', '');
		if (($this->page == $pages)	|| (!isset($resultCount))) 	$render->assign('nextButtonStyle', 		"myprofile_hidden");
		else $render->assign('nextButtonStyle', '');
		return true;
	}
}