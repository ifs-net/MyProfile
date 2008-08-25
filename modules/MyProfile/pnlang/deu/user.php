<?php
/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schießl
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
 
// header
define('_MYPROFILEUSERMENU',		'Benutzer-Menü');
define('_MYPROFILEMAINPROFILEDATA',	'Haupt-Profil-Daten');
define('_MYPROFILEMAILANDPASSWORD',	'E-Mail-Adresse, Passwort und erweiterte Einstellungen bearbeiten');

// main
define('_MYPROFILEMYPROFILE',		'Mein Profil');
define('_MYPROFILESAVE',		'speichern / aktualisieren');
define('_MYPROFILEMYPROFILEDATA',	'Organisiere Dein Gemeinschafts-Profil');
define('_MYPROFILEMANAGEYOURDATA',	'Bitte fülle die Formular-Felder aus. Mit * markierte Felder sind zwingend erforderlich.');
define('_MYPROFILEHOWTOUSETABS',	'Bitte klick auf die Tab-Reiter oberhalb, um zu den separaten Abschnitten zu gelangen. Drücke erst auf "Speichern" wenn alle Felder in allen Abschnitten ausgefüllt sind!');
define('_MYPROFILESHOWWALLTABS',	'Alle Abschnitte auf einer Seite zeigen');
define('_MYPROFILETABMODE',		'In den Tab-Modus umschalten');
define('_MYPROFILECREATED',		'Das Profil wurde erfolgreich erzeugt');
define('_MYPROFILEFIELDUPDATED',	'Die Profil-Daten wurden erfolgreich aktualisiert');
define('_MYPROFILESHOWMYPROFILE',	'Eigene Profil-Seite anzeigen');
define('_MYPROFILEADDPROFILEFAILED',	'Profil-Erzeugung / -Aktualisierung fehlgeschlagen');
define('_MYPROFILEATTRIBUTESTOREERROR',	'Aktualisieren / Erzeugen der Benutzer-Attribute fehlgeschlagen');

// display
define('_MYPROFILESENDPM',		'Private Nachricht senden');
define('_MYPROFILEADDASBUDDY',		'Als Freund hinzufügen');
define('_MYPROFILENOPERMISSION',	'nur für regisrierte Benutzer angezeigt');
define('_MYPROFILEREGSINCE',		'Registriert seit');
define('_MYPROFILELASTLOGIN',		'Letzer Login');
define('_MYPROFILELASTUPDATE',		'Letzte Aktualisierung');
// display plugins
define('_MYPROFILE_USERPICTURES_PICSINGALLERY',	'Benutzer-Gallerie');
define('_MYPROFILE_USERPICTURES_PICTURES',	'Bild(er)');
define('_MYPROFILE_USERPICTURES_LINKEDIN',	'Benutzer verknüpft auf');
define('_MYPROFILE_USERPICTURES_EXTERNAL',	'extern');
define('_MYPROFILE_USERPICTURES_THEREFROM',	'davon');

// settings
define('_MYPROFILEYOURSETTINGS',	'Hier können einige Einstellungen für Dein Profil festgelegt werden');
define('_MYPROFILENOCOMMENTS',		'Anderen Benutzern nicht erlauben mein Profil zu kommentieren');
define('_MYPROFILESETTINGSUPDATED',	'Einstellungen erfolgreich aktualisiert');
define('_MYPROFILENEWPASS',		'Um das Dein Passwort zu ändern, bitte das neue eingeben');
define('_MYPROFILENEWPASSAGAIN',	'und das neue Passwort wiederholen');
define('_MYPROFILEGENERALSETTINGS',	'Allgemeine Einstellungen');
define('_MYPROFILEPASSWORDSETTINGS',	'Passwort verwalten');
define('_MYPROFILECHANGEMAIL',		'E-Mail-Adresse ändern');
define('_MYPROFILEEMAILADDRESS',	'Neue E-Mail-Adresse');
define('_MYPROFILEPASSWORDCHANGED',	'Dein Passwort wurde erfolgreich geändert');
define('_MYPROFILEPASSWORDSINCORRECT',	'Das neue Passwort wurde nicht zweimal gleich eingegeben - möglicherweise hast Du Dich vertippt - das Passwort ist nicht geändert');
define('_MYPROFILEPWDTOOSHORT',		'Das neue Passwort ist zu kurz');
define('_MYPROFILEMAILCHANGEREQUEST',	'Eine Überprüfungs-Nachricht mit weiteren Anweisungen wurde an Deine neue E-Mail-Adresse verschickt.');
define('_MYPROFILEMAILCHANGEREQUESTERROR',	'Der Überprüfungs-Code konnte nicht an Deine neu eingegebene E-Mail-Adresse verschickt werden');
define('_MYPROFILEEMAILCHANGED',	'Deine E-Mail-Adresse wurde erfolgreich aktualisiert');
define('_MYPROFILEEMAILCHANGEERROR',	'Beim Versuch Deine E-Mail-Adresse zu ändern ist ein Fehler aufgetreten');
define('_MYPROFILENONEWREQUESTBEFORE',	'Ein neuer Überprüfungs-Code kann erst wieder angefordert werden nach');
define('_MYPROFILEENTERVALIDATIONCODE',	'Überprüfungs-Code für neue E-Mail-Adresse eingeben');

// validation code email
define('_MYPROFILEVALIDATIONCODEFOR',	'E-Mail Überprüfungs-Code für');
define('_MYPROFILEAT',			'bei');
define('_MYPROFILEEMAILCHANGEREQUEST',	'Du hast die Änderung Deiner E-Mail-Adresse angefordert bei');
define('_MYPROFILEACTIVATESTEPS',	'Um Deine neue E-Mail-Adresse zu aktivieren, klicke bitte den folgenden Link an');
define('_MYPROFILEIFLINKBROKEN',	'Falls der Link nicht funktioniert, ruf bitte die folgende Website auf und gib Deinen Überprüfungs-Code dort ein');
define('_MYPROFILEVALIDUNTIL',		'Dieser Code ist gültig bis');
define('_MYPROFILEORNEWREQUEST',	'oder bis Du einen neuen anforderst');
define('_MYPROFILENORESPONSE',		'Bitte antworte nicht auf diese automatisch versandte Nachricht - benachrichtige den Administrator falls es Probleme gibt');
define('_MYPROFILEENTERDATA',		'Um die alternative URL zu nutzen, müssen folgende Daten eingegeben werden');
// validate
define('_MYPROFILEVALIDATEEMAILADDRESS','Überprüfungs-Code zur Aktivierung der neuen E-Mail-Adresse eingeben');
define('_MYPROFILEVALIDATIONCODE',	'Überprüfungs-Code (25 Zeichen)');
define('_MYPROFILEUSERID',		'Deine Benutzerkennung');
define('_MYPROFILEACTIVATENEWMAIL',	'Neue E-Mail-Adresse aktivieren');
define('_MYPROFILENOUSERDATAFOUND',	'Keine Benutzer-Daten gefunden');
define('_MYPROFILEINVALIDCODE',		'Der Überprüfungs-Code ist nicht mehr gültig - Starte eine neue Anfrage für einen neuen Überprüfungs-Code');
define('_MYPROFILEINCORRECTCODE',	'falscher Überprüfungs-Code');

// account panel
define('_MYPROFILEPROFILEDATA',		'Meine Profil-Daten');
define('_MYPROFILEPASSWORD',		'Mein Passwort');
define('_MYPROFILEMAILADDRESS',		'Meine E-Mail-Adresse');

// display
define('_MYPROFILEMAINPROF',		'Profil');

// check for account plugin
define('_MYPROFILEPLEASECREATEACCOUNTFIRST',	'Bitte füll zunächst Dein persönliches Profil aus. Das ist notwendig um mit der Gemeinschaft kommunizieren zu können!');
?>
