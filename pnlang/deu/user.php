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
define('_MYPROFILEUSERMENU',				'Benutzer-Menü');
define('_MYPROFILEMAINPROFILEDATA',			'Haupt-Profil-Daten');
define('_MYPROFILEMAILANDPASSWORD',			'Zugangsdaten und Profileinstellungen');
define('_MYPROFILESEARCHMEMBERS',			'Mitglieder suchen');

// map
define('_MYPROFILEVISITPROFILE',			'Profil des Benutzers anzeigen');
define('_MYPROFILEMYMAPMISSING',			'MyMap-Modul wurde nicht gefunden');
define('_MYPROFILEMAPIDENTIFIERASPARAMETER','Es gibt mehrere Koordinatenfelder. Bitte den Parameter identifier und als Wert den Namen des Identifiers angeben, der als Grundlage für die darzustellende Karte genutzt werden soll');

// main
define('_MYPROFILEDATEHINT',				'Format: JJJJ-MM-TT, z.B. 1981-05-25');
define('_MYPROFILEVIEWABLEBY',				'sichtbar für');
define('_MYPROFILEPRIVATEFIELD',			'Als privat markiert; nur für speziell freigegebene Kontakte sichtbar');
define('_MYPROFILEPROFILEOF',				'Profil von');
define('_MYPROFILEMYPROFILE',				'Mein Profil');
define('_MYPROFILESAVE',					'speichern / aktualisieren');
define('_MYPROFILEMYPROFILEDATA',			'Organisiere Dein Gemeinschafts-Profil');
define('_MYPROFILEMANAGEYOURDATA',			'Bitte fülle die Formular-Felder aus. Mit * markierte Felder sind zwingend erforderlich.');
define('_MYPROFILEHOWTOUSETABS',			'Bitte klick auf die Tab-Reiter oberhalb, um zu den separaten Abschnitten zu gelangen. Drücke erst auf "Speichern" wenn alle Felder in allen Abschnitten ausgefüllt sind!');
define('_MYPROFILESHOWWALLTABS',			'Alle Abschnitte auf einer Seite zeigen');
define('_MYPROFILETABMODE',					'In den Tab-Modus umschalten');
define('_MYPROFILECREATED',					'Das Profil wurde erfolgreich erzeugt');
define('_MYPROFILEFIELDUPDATED',			'Die Profil-Daten wurden erfolgreich aktualisiert');
define('_MYPROFILESHOWMYPROFILE',			'Eigene Profil-Seite anzeigen');
define('_MYPROFILEADDPROFILEFAILED',		'Profil-Erzeugung / -Aktualisierung fehlgeschlagen');
define('_MYPROFILEATTRIBUTESTOREERROR',		'Aktualisieren / Erzeugen der Benutzer-Attribute fehlgeschlagen');
define('_MYPROFILELNG',						'Längengrad');
define('_MYPROFILELAT',						'Breitengrad');
define('_MYPROFILENEWPROFILE',				'Neues Profil');

// search
define('_MYPROFILESHOWALLMEMBERS',			'Alle Mitglieder anzeigen');
define('_MYPROFILEMEMBERLISTDESC',			'Wenn die Suche ohne Suchparameter und Eingabe gestartet wird, wird die komplette Mitgliederliste angezeigt');
define('_MYPROFILEPAGE',					'Seite');
define('_MYPROFILENOTHINGSEARCHABLE',		'Es sind entweder keine weiteren durchsuchbaren Felder definiert oder es Fehlen die nötigen Zugriffsrechte, darauf zuzugreifen.');
define('_MYPROFILESEARCH',					'Suche');
define('_MYPROFILEORDERBY',					'Sortieren nach');
define('_MYPROFILESEARCHINTRO',				'Die nachfolgenden Felder können befüllt werden um die Ergebnisse einzugrenzen.');
define('_MYPROFILESEARCHTYPE',				'Suchoption');
define('_MYPROFILESOFT',					'soft');
define('_MYPROFILEEXACT',					'exakt');
define('_MYPROFILESEARCHTYPEDESC',			'Die Suchoption "soft" wird mehr ergebnisse anzeigen als "exakt". Wird z.B. nach "Sonne" gesucht, werden bei "soft" auch Ergebnisse mit "Sonnenuntergang" angezeigt, da der Suchbegriff im Gefundenen mit enthalten ist. Die Option "exakt" gibt nur die Ergebnisse aus, welche exakt zutreffen.');
define('_MYPROFILEORUSED',					'Hier dargestellte Felder werden mit "oder" verknüpft.');
define('_MYPROFILECONNECTOR',				'Logische Verbindung mehrerer Felder');
define('_MYPROFILEAND',						'UND');
define('_MYPROFILEOR',						'ODER');
define('_MYPROFILEDESC',					'absteigend');
define('_MYPROFILEASC',						'aufsteigend');
define('_MYPROFILEFOUND',					'Gefundene');
define('_MYPROFILERESULTS',					'Ergebnisse');
define('_MYPROFILERESULT',					'Ergebnis');
define('_MYPROFILESHOWSEARCHFORM',			'Suchformular mit Suchparametern einblenden');
define('_MYPROFILENEXTPAGE',				'nächste Seite');
define('_MYPROFILEPREVIOUSPAGE',			'vorherige Seite');
define('_MYPROFILESEARCHSTRING',            'Begriff (Suche in allen Feldern)');

// confirmedusers
define('_MYPROFILEUSERDELETED',				'Benutzer entfernt');
define('_MYPROFILEDELETE',					'Benutzer entfernen');
define('_MYPROFILEERRORDELETINGUSER',		'Beim Versuch den Benutzer von der Liste zu löschen ist ein Fehler aufgetreten');
define('_MYPROFILEMANAGETRUSTLIST',			'Benutzerliste verwalten, welche Zugriff auf private Daten hat');
define('_MYPROFILEADDUSER',					'Einen neuen Benutzer meiner Liste hinzufügen');
define('_MYPROFILEUNAME',					'Benutzername');
define('_MYPROFILEADD',						'hinzufügen');
define('_MYPROFILEYOURLIST',				'Meine Liste');
define('_MYPROFILENOENTRY',					'Noch kein Eintrag gefunden');
define('_MYPROFILEUSERADDED',				'Der Benutzer wurde der Liste hinzugefügt');
define('_MYPROFILEUSERADDERROR',			'Beim Versuch den Benuzter der Liste hinzuzufügen ist ein Fehler aufgetreten');
define('_MYPROFILEUSERALREADYADDED',		'Der Benutzer ist bereits auf der Liste aufgeführt und kann nicht zweimal hinzugefügt werden');
define('_MYPROFILEDONOTADDYOURSELF',		'Ja, man traut sich meist selbst, aber trotzdem kann der eigene Benutzername nicht auf der eigenen Liste gespeichert werden');
define('_MYPROFILEUSERNOTFOUND',			'Der angegebene Benutzername existiert nicht');

// display
define('_MYPROFILEOVERRIDETEMPLATE',		'Individuelle Benutzervorlage ignorieren und klassische Profilansicht wählen');
define('_MYPROFILENOACCESS',				'Kein Zugriff auf dieses Profil möglich');
define('_MYPROFILENOINDIVIDUALPERMISSION',	'Der Inhaber des Profils hat die Sichtbarkeit seines Profils so eingeschränkt, dass es für Dich leider nicht sichtbar ist.');
define('_MYPROFILESENDPM',					'Private Nachricht senden');
define('_MYPROFILEADDASBUDDY',				'Als Kontakt hinzufügen');
define('_MYPROFILENOPERMISSION',			'keine Zugriffsrechte auf diese Daten');
define('_MYPROFILEREGSINCE',				'Registriert seit');
define('_MYPROFILELASTLOGIN',				'Letzer Login');
define('_MYPROFILELASTUPDATE',				'Letzte Aktualisierung');
// display plugins
define('_MYPROFILE_USERPICTURES_PICSINGALLERY',	'Benutzer-Gallerie');
define('_MYPROFILE_USERPICTURES_PICTURES',	'Bild(er)');
define('_MYPROFILE_USERPICTURES_LINKEDIN',	'Benutzer verknüpft auf');
define('_MYPROFILE_USERPICTURES_EXTERNAL',	'extern');
define('_MYPROFILE_USERPICTURES_THEREFROM',	'davon');
// display invaid
define('_MYPROFILEPROFILENOTFOUND',			'Benutzerprofil kann nicht angezeigt werden');
define('_USERPICTURESINVALIDEXPLANATION',	'Der Benutzer existiert nicht oder hat (noch) kein gültiges, vollständiges Profil angelegt.');
define('_USERPICTURESBACKTOLASTPAGE',		'Zurück zur letzten Seite.');

// settings
define('_MYPROFILEWAITFORVERIFICATION',		'Achtung: Bevor die Seite weiter genutzt werden kann muss zwingend der richtige Verifikationscode aus der Email, die soeben verschickt wurde, eingegeben werden. Bitte dazu das Email abwarten und die neue Emailadrese aktivieren - danach kann die Seite wieder weiter genutzt werden!');
define('_MYPROFILEMYTIMEZONE',				'Meine Zeitzone');
define('_MYPROFILEMANAGECONFIRMEDUSERS',	'Benutzer verwalten, welche alle meine als privat deklarierten Daten sehen dürfen');
define('_MYPROFILETEMPLATEINCLUDEMANDATORY','Alle als Pflichtvariablen angegebenen Variablen müssen in der individuellen Profilvorlage enthalten sein!');
define('_MYPROFILEINDIVIDUALTEMPLATEHINTS',	'Hinweise zur Nutzung eingener individueller Vorlagen');
define('_MYPROFILEMYPROFILEMYTEMPLATE',		'Individuelle Vorlage zur Darstellung des eigenen Profils nutzen');
define('_MYPROFILEWILLBEREPLACEDWITH',		'wird ersetzt werden durch');
define('_MYPROFILETEMPALTEUSEWHATYOUWANT',	'Die eigene Profilseite kann frei in HTML gestaltet werden');
define('_MYPROFILETEMPALTEVARREPLACEMENTS',	'Das Verwenden von volgenden fettgedruckten Zeichen führt dazu, dass diese in der Profilausgabe durch die gespeicherten Profildaten ersetzt werden; mit Stern markierte Profildaten müssen im Template vorkommen');
define('_MYPROFILEMYPROFILEVISIBLEFOR',		'Meine Profilseite sollen sichtbar sein für');
define('_MYPROFILEALL',						'alle');
define('_MYPROFILEMEMBERS',					'alle Mitglieder');
define('_MYPROFILEBUDDIES',					'bestätigte Kontakte');
define('_MYPROFILEADMIN',					'Administrator(en)');
define('_MYPROFILEYOURSETTINGS',			'Hier können einige Einstellungen für Dein Profil festgelegt werden');
define('_MYPROFILENOCOMMENTS',				'Anderen Benutzern nicht erlauben mein Profil zu kommentieren');
define('_MYPROFILESETTINGSUPDATED',			'Einstellungen erfolgreich aktualisiert');
define('_MYPROFILENEWPASS',					'Um das Dein Passwort zu ändern, bitte das neue eingeben');
define('_MYPROFILENEWPASSAGAIN',			'und das neue Passwort wiederholen');
define('_MYPROFILEGENERALSETTINGS',			'Allgemeine Einstellungen');
define('_MYPROFILEPASSWORDSETTINGS',		'Passwort verwalten');
define('_MYPROFILECHANGEMAIL',				'E-Mail-Adresse ändern');
define('_MYPROFILEEMAILADDRESS',			'Neue E-Mail-Adresse');
define('_MYPROFILEPASSWORDCHANGED',			'Dein Passwort wurde erfolgreich geändert');
define('_MYPROFILEPASSWORDSINCORRECT',		'Das neue Passwort wurde nicht zweimal gleich eingegeben - möglicherweise hast Du Dich vertippt - das Passwort ist nicht geändert');
define('_MYPROFILEPWDTOOSHORT',				'Das neue Passwort ist zu kurz');
define('_MYPROFILEMAILCHANGEREQUEST',		'Eine Überprüfungs-Nachricht mit weiteren Anweisungen wurde an Deine neue E-Mail-Adresse verschickt.');
define('_MYPROFILEMAILCHANGEREQUESTERROR',	'Der Überprüfungs-Code konnte nicht an Deine neu eingegebene E-Mail-Adresse verschickt werden');
define('_MYPROFILEEMAILCHANGED',			'Deine E-Mail-Adresse wurde erfolgreich aktualisiert');
define('_MYPROFILEEMAILCHANGEERROR',		'Beim Versuch Deine E-Mail-Adresse zu ändern ist ein Fehler aufgetreten');
define('_MYPROFILENONEWREQUESTBEFORE',		'Ein neuer Überprüfungs-Code kann erst wieder angefordert werden nach');
define('_MYPROFILEENTERVALIDATIONCODE',		'Überprüfungs-Code für neue E-Mail-Adresse eingeben');

// validation code email
define('_MYPROFILEVALIDATIONCODEFOR',		'E-Mail Überprüfungs-Code für');
define('_MYPROFILEAT',						'bei');
define('_MYPROFILEEMAILCHANGEREQUEST',		'Du hast die Änderung Deiner E-Mail-Adresse angefordert bei');
define('_MYPROFILEACTIVATESTEPS',			'Um Deine neue E-Mail-Adresse zu aktivieren, klicke bitte den folgenden Link an');
define('_MYPROFILEIFLINKBROKEN',			'Falls der Link nicht funktioniert, ruf bitte die folgende Website auf und gib Deinen Überprüfungs-Code dort ein');
define('_MYPROFILEVALIDUNTIL',				'Dieser Code ist gültig bis');
define('_MYPROFILEORNEWREQUEST',			'oder bis Du einen neuen anforderst');
define('_MYPROFILENORESPONSE',				'Bitte antworte nicht auf diese automatisch versandte Nachricht - benachrichtige den Administrator falls es Probleme gibt');
define('_MYPROFILEENTERDATA',				'Um die alternative URL zu nutzen, müssen folgende Daten eingegeben werden');
// validate
define('_MYPROFILEVALIDATEEMAILADDRESS',	'Überprüfungs-Code zur Aktivierung der neuen E-Mail-Adresse eingeben');
define('_MYPROFILEVALIDATIONCODE',			'Überprüfungs-Code (25 Zeichen)');
define('_MYPROFILEUSERID',					'Deine Benutzerkennung');
define('_MYPROFILEACTIVATENEWMAIL',			'Neue E-Mail-Adresse aktivieren');
define('_MYPROFILENOUSERDATAFOUND',			'Keine Benutzer-Daten gefunden');
define('_MYPROFILEINVALIDCODE',				'Der Überprüfungs-Code ist nicht mehr gültig - Starte eine neue Anfrage für einen neuen Überprüfungs-Code');
define('_MYPROFILEINCORRECTCODE',			'falscher Überprüfungs-Code');

// account panel
define('_MYPROFILEPROFILEDATA',				'Meine Profil-Daten');
define('_MYPROFILEPASSWORD',				'Mein Passwort');
define('_MYPROFILEMAILADDRESS',				'Meine E-Mail-Adresse');

// display
define('_MYPROFILEMAINPROF',				'Profil');

// check for account plugin
define('_MYPROFILEPLEASECREATEACCOUNTFIRST','Bitte füll zunächst Dein persönliches Profil aus. Das ist notwendig um mit der Gemeinschaft kommunizieren zu können!');
?>