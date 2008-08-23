////////////////////////////////////////////////////////////////////////////////
// USER
/////////

// general

function change(url,element)
{
	new Ajax.Updater(
		element,
		url, 
		{
			method: 'get',
			evalScripts: true
		}
	);
	return true;
}

// display
var url = document.location.pnbaseURL + "modules/MyProfile/pnimages/ajaxindicator.gif";
// update a tab
function myprofile_updateTab(URL,element) {
	$('myprofile_maincontent').replace('<div class="myprofile_tabcontent" id="myprofile_maincontent"><img src="' + url + '" /></div>');
	change(URL,element);
	return false;
}

// This function change the background color of a tab whenever the mouse is out of the tab
function myprofile_plugintab_mouseout(ID) {
  	$('myprofile_plugintab'+ID).removeClassName('myprofile_plugintab_selected').addClassName('myprofile_plugintab_unselected');
  	return false;
}

// This function change the background color of a tab whenever the mouse is over athe tab
function myprofile_plugintab_mouseover(ID) {
  	$('myprofile_plugintab'+ID).addClassName('myprofile_plugintab_selected').removeClassName('myprofile_plugintab_unselected');
  	return false;
}

// main

// Initial call of all script lines that have to be loaded at startup
function myprofile_init_user_main() {
	$('myprofile_javascript').removeClassName('myprofile_javascript');
	myprofile_hideAllTabs();
	$('myprofile_submitbutton').hide();
	$('myprofile_tabmode').hide();
	$('myprofile_tabinfotext').removeClassName('myprofile_tabcontent_hidden').addClassName('myprofile_tabcontent');
	$('myprofile_showalltabs').observe('click',function() {myprofile_observe_showAllFieldsLink();});
	$('myprofile_tabmode').observe('click',function() {myprofile_observe_showTabbedMode();});
	return false;
}

// This function change the background color of a tab whenever the mouse is over the tab
function myprofile_tab_mouseover(ID) {
  	$('myprofile_tabheader'+ID).removeClassName('myprofile_tabnotselected').addClassName('myprofile_tabmouseover');
  	return false;
}

// This function change the background color of a tab whenever the mouse is out of the tab
function myprofile_tab_mouseout(ID) {
  	$('myprofile_tabheader'+ID).removeClassName('myprofile_tabmouseover').addClassName('myprofile_tabnotselected');
  	return false;
}

// Observe function for the "show all tabs" link
function myprofile_observe_showAllFieldsLink() {
	$('myprofile_tabinfotext').toggle();
  	$('myprofile_submitbutton').show();
	$('myprofile_showalltabs').hide();
	$('myprofile_tabmode').show();
	$('myprofile_tabheader').hide();
	myprofile_showAllTabs();
	return false;
}

// Observe function for the "switch to tabbed mode" link
function myprofile_observe_showTabbedMode() {
	$('myprofile_tabinfotext').toggle();
  	$('myprofile_submitbutton').hide();
	$('myprofile_showalltabs').show();
	$('myprofile_tabheader').show();
	myprofile_hideAllTabs();
	$('myprofile_introtext').show();
	$('myprofile_tabmode').hide();
	return false;
}

// show a Tab
function myprofile_showTab(ID) {
  	$('myprofile_submitbutton').show();
	$('myprofile_introtext').hide();
	myprofile_hideAllTabs();
	$('myprofile_tab'+ID).show();
	$('myprofile_tabheader'+ID).addClassName('myprofile_tabselected');
	return false;
}


////////////////////////////////////////////////////////////////////////////////
// ADMIN
/////////

// Observe function for fieldtype changes
function myprofile_observeFieldType() {
	$('myprofile_fieldtype').observe('change', function() {
	  	myprofile_showSelectedFieldType();
	});
	return false;
}

// Hide all fields
function myprofile_hideAll() {
	$('myprofile_identifier').hide();
	$('myprofile_mandatory').hide();
	$('myprofile_description').hide();
	$('myprofile_num_minvalue').hide();
	$('myprofile_num_maxvalue').hide();
	$('myprofile_str_length').hide();
	$('myprofile_list').hide();
	$('myprofile_public_status').hide();
	$('myprofile_active').hide();
	$('myprofile_shown').hide();
	return false;
}

// Just show the fields that are needed
function myprofile_showSelectedFieldType() {
  	myprofile_hideAll();
  	var value = $F('fieldtype');
  	if ((value == 'INTEGER') || (value == 'FLOAT')) {
		$('myprofile_identifier').show();
		$('myprofile_mandatory').show();
		$('myprofile_description').show();
		$('myprofile_num_minvalue').show();
		$('myprofile_num_maxvalue').show();
		$('myprofile_public_status').show();
		$('myprofile_active').show();
		$('myprofile_shown').show();		    
	}
	else if (value == 'STRING') {
		$('myprofile_identifier').show();
		$('myprofile_mandatory').show();
		$('myprofile_description').show();
		$('myprofile_str_length').show();
		$('myprofile_list').show();
		$('myprofile_public_status').show();
		$('myprofile_active').show();
		$('myprofile_shown').show();
	}
	else if ((value == 'URL') || (value == 'SKYPEID') || (value == 'UIN')) {
		$('myprofile_identifier').show();
		$('myprofile_mandatory').show();
		$('myprofile_description').show();
		$('myprofile_public_status').show();
		$('myprofile_active').show();
		$('myprofile_shown').show();
	}
	else if (value == 'TEXTBOX') {
		$('myprofile_identifier').show();
		$('myprofile_mandatory').show();
		$('myprofile_description').show();
		$('myprofile_list').show();
		$('myprofile_public_status').show();
		$('myprofile_active').show();
		$('myprofile_shown').show();
	}
	else if (value == 'DATE') {
		$('myprofile_identifier').show();
		$('myprofile_mandatory').show();
		$('myprofile_description').show();
		$('myprofile_public_status').show();
		$('myprofile_active').show();
		$('myprofile_shown').show();
	}
	else if (value == 'TIMESTAMP') {
		$('myprofile_identifier').show();
		$('myprofile_mandatory').show();
		$('myprofile_description').show();
		$('myprofile_public_status').show();
		$('myprofile_active').show();
		$('myprofile_shown').show();
	}
	else if (value == 'SEPARATOR') {
		$('myprofile_identifier').show();
		$('myprofile_description').show();
		$('myprofile_shown').show();
	}  
	return false;
}
