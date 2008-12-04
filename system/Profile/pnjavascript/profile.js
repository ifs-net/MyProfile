/**
 * PostNuke Application Framework
 *
 * @copyright (c) 2001, PostNuke Development Team
 * @link http://www.postnuke.com
 * @version $Id: profile.js 22676 2007-09-15 15:24:22Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package PostNuke_System_Modules
 * @subpackage Profile
 */


function profileinit()
{
    Sortable.create("profilelist",
                    { 
                      only: 'pn-sortable',
                      constraint: false,
                      onUpdate: profileweightchanged
                    });
    $$('a.profile_down').each(function(arrow){arrow.hide();});
    $$('a.profile_up').each(function(arrow){arrow.hide();});
    $('profilehint').show();
	$A(document.getElementsByClassName('pn-sortable', 'profilelist')).each(
        function(node) 
        { 
            var thisprofileid = node.id.split('_')[1];
			Element.update('profiledrag_' + thisprofileid, '<img style="margin-top: 3px; margin-left: 3px;" src="images/icons/extrasmall/move.gif" width="16" height="16" alt="move.gif" />&nbsp;' + $('profiledrag_' + thisprofileid).innerHTML);
		}
	)
}

/**
 * Stores the new sort order. This function gets called automatically
 * from the Sortable when a 'drop' action has been detected
 *
 *@params none;
 *@return none;
 *@author Frank Schummertz
 */
function profileweightchanged()
{
    var pars = "module=Profile&func=changeprofileweight&authid=" + $F('authid') + "&startnum=" + $F('startnum')
               + "&" + Sortable.serialize('profilelist', { 'name': 'profilelist' });
    var myAjax = new Ajax.Request(
        "ajax.php", 
        {
            method: 'get', 
            parameters: pars, 
            onComplete: profileweightchanged_response
        });
}

/**
 * Ajax response function for updating new sort order: cleanup
 *
 *@params none;
 *@return none;
 *@author Frank Schummertz
 */
function profileweightchanged_response(req)
{
    if(req.status != 200 ) { 
        pnshowajaxerror(req.responseText);
        return;
    }

    var json = pndejsonize(req.responseText);
    pnupdateauthids(json.authid);

    pnrecolor('profilelist', 'profilelistheader');

}
