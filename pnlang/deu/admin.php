<?php
/**
 * @package      MyProfile
 * @version      $Id$
 * @author       Florian Schießl
 * @link         http://www.ifs-net.de
 * @copyright    Copyright (C) 2008
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

// menu
define('_MYPROFILEMAIN',					'Hauptseite / Benutzer bearbeiten');
define('_MYPROFILEMAINSETTINGS',			'Modul-Konfiguration');
define('_MYPROFILEACTUALCONFIG',			'Profil-Konfiguration');
define('_MYPROFILEFINDORPHANS',				'Reparieren');
define('_MYPROFILEPLUGINS',					'Profil-Plugins');
define('_MYPROFILEINFORMATION',				'Informationen');
define('_MYPROFILEIMPORTFUNCS',				'Import');

// stats
define('_MYPROFILESTATUSERS',				'Anzahl registrierter Nutzer');
define('_MYPROFILESTATACTIVE',				'Anzahl aktiver Nutzer');
define('_MYPROFILESTAT14D',					'Aktiv in letzten 14 Tagen');
define('_MYPROFILESTAT30D',					'Aktiv im letzten Monat');
define('_MYPROFILESTAT60D',					'Aktiv in letzten zwei Monaten');
define('_MYPROFILESTAT90D',					'Aktiv in letzten drei Monaten');
define('_MYPROFILESTAT180D',				'Aktiv im letzten Halbjahr');
define('_MYPROFILESTAT365D',				'Aktiv im letzten Jahr');
define('_MYPROFILESTATNEWUSERS30D',			'Neuanmeldung die letzten 30 Tage');
define('_MYPROFILESTATMYPROFILE',			'Nutzer mit ausgefülltem Profil');
define('_MYPROFILESTATNOPROFILE',			'Nutzer ohne ausgefülltes Profil');
define('_MYPROFILESTATINVALIDEMAIL',		'Nutzer mit als ungültig markierter EMailadresse');
define('_MYPROFILESTATINVALIDEMAIL30D',		'Nutzer mit als ungültig markierter EMailadresse ohne Änderung in letztem Monat');
define('_MYPROFILELEGEND',					'Legende');
define('_MYPROFILESTATSACTIVE',				'aktive Accounts');
define('_MYPROFILESTATSDAY',				'online');
define('_MYPROFILESTATS14DAYS',				'online letzte 2 Wochen');
define('_MYPROFILESTATS30DAYS',				'online letzte 30 Tage');
define('_MYPROFILESTATS60DAYS',				'online letzte 60 Tage');
define('_MYPROFILESTATS90DAYS',				'online letzte 90 Tage');
define('_MYPROFILESTATS180DAYS',			'online letztes Halbjahr');
define('_MYPROFILESTATSYEAR',				'online letztes Jahr');
define('_MYPROFILE_SELECTRANGE',            'Zeitraum für Grafik wählen');
define('_MYPROFILE_DAYS',                   'Tage');
define('_MYPROFILE_RANGEHINT',              'Benutzerdefiniert: Einfach parameter "range" mit entsprechender Tageszahl in URL übergeben!');


//main
define('_MYPROFILEEMAIL',					'Emailadresse des Benutzers');
define('_MYPROFILEBACKEND',					'MyProfile Backend-Konfiguration');
define('_MYPROFILEBACKENDDESCR',			'Willkommen bei MyProfile - dem erweiterten Profilmodul für Zikula!');
define('_MYPROFILEEDITPROFILE',				'Profil ändern');
define('_MYPROFILEDIRECTPROFILEEDIT',		'Ein Benutzerprofil kann direkt durch Eingabe');
define('_MYPROFILEEDITUNAME',				'des Benutzernamen');
define('_MYPROFILEEDITUID',					'oder der Benutzer-ID');
define('_MYPROFILEEDITPROFILETHEN',			'... bearbeitet werden');
define('_MYPROFILESUPPORTMYPROFILE',		'Unterstütze dieses Modul');
define('_MYPROFILEDONATETHIS',				'Spende per PayPal!');
define('_MYPROFILEDONATE',					'Du magst dieses Modul und es nützt Dir? Dann wäre Dir der Programmierer für eine kleine Spende sehr dankbar! Na klar - ich programmiere sehr gerne und das Modul ist natürlich kostenlos und Open-Source - aber wenn Du etwas springen lässt, dann könnte ich meine Freundin zum Abendessen ausführen und es wird das nächste mal viel leichter sein, zum Programmieren frei zu bekommen ;-)');

// mainsettings
define('_MYPROFILEUSERNEEDSVALIDPROFILE',	'Benutzer müssen vor Nutzung der Seite ihr Profil ausfüllen');
define('_MYPROFILEEMAILNOTFOUND',			'Emailadresse konnte nicht gefunden werden');
define('_MYPROFILEUSERALREADYADDED',		'Benutzer ist bereits markiert');
define('_MYPROFILEUSERMARKED',				'Benutzer wurde markiert / deaktiviert');
define('_MYPROFILEUPDATEERRORFOR',			'Fehler beim markieren des Benutzers');
define('_MYPROFILEMANAGEINVALIDEMAILS',		'Ungültige EMailadressen verwalten');
define('_MYPROFILEINVALIDEMAILMANAGEMENT',	'Es ist möglich, Benutzer zu sperren, welche eine falsche Emailadresse angegeben haben. Ein solcher, der Liste hinzugefügter Benutzer, kann sich beim nächsten Login zwar einloggen, ist aber gezwungen, seine Emailadresse zu aktualisieren. Dann wird er ausgeloggt und kann sich nur mit einer gültigen Emailadresse erst wieder anmelden. Hierzu muss in jedes Template folgender Smarty-Code integriert werden');
define('_MYPROFILESEARCHENGINEURL',			'URL für Suchmaschine');
define('_MYPROFILEEMAILMYMAPDISPLAY',		'Benutzer in Karte anzeigen');
define('_MYPROFILEMYMAPUSECOORDFIELD',		'Wenn Feldtyp KOORDINATE verwendet wird, können die Benutzer in eine Karte eingeblendet werden unter zuhilfenahme folgender URL');
define('_MYPROFILEMYMAPINSTALLED',			'MyMap muss installiert sein, um dieses Feature nutzen zu können');
define('_MYPROFILESEARCHTEMPLATE',			'Nutze ein selbstverfasstes Template (Dateinamen angeben), welches auf der Suchergebnisseite für die gefundenen Mitglieder jeweils benutzt werden soll');
define('_MYPROFILEALLOWMEMBERLIST',			'Suchenden erlauben die komplette Mitgliederliste einzusehen, z.B. wenn kein Suchparameter übergeben wurde');
define('_MYPROFILEAMOUNTOFRESULTSPERPAGE',	'Anzahl der Suchergebnisse pro Seite');
define('_MYPROFILEPROFILEAPPEARANCE',		'Konfiguration Profilanzeige');
define('_MYPROFILESEARCHAPPEARANCE',		'Konfiguration Suchmaschine');
define('_MYPROFILEEXCLUDEGROUPFORTEMPLATING','Folgende Gruppen sollen keine individuellen Templates nutzen dürfen');
define('_MYPROFILEALLOWINDIVIDUALTEMPLATES','Benutzern das Hochladen eigener Profil-Vorlagen gestatten.');
define('_MYPROFILEUSERPERMISSIONS',			'Benutzerrechte');
define('_MYPROFILEALLOWINDIVIDUALVIEWPERMISSIONS',	'Erlaube es jedem Benutzer selbst zu bestimmen, wer sein Gesamtprofil sehen darf');
define('_MYPROFILEGLOBALETTINGS',			'Allgemeine Modul-Einstellungen');
define('_MYPROFILEASATTRIBUTES',			'Profil auch als Attribut des Benutzer-Objekts speichern');
define('_MYPROFILEATTRIBUTEUSAGE',			'Ein Benutzer-Profil kann als $myprofile.youridentifier mit diesem Code verwendet werden');
define('_MYPROFILEAPPEARANCE',				'Darstellung');
define('_MYPROFILEBEHAVIOUR',				'Verhalten');
define('_MYPROFILENOTABS',					'Ohne Tabellen-Reiter bei Profilverwaltung');
define('_MYPROFILENOAJAXTABS',				'Plugins nicht per AJAX laden lassen');
define('_MYPROFILEEMAILMANAGEMENT',			'E-Mail-Adressen Organisation');
define('_MYPROFILECONVERTAJAXCONTENTTOUTF8','Per AJAX nachgeladene Inhalte in UTF8 umwandeln');
define('_MYPROFILENOVERIFICATION',			'Keine Verifikation bei der E-Mail-Änderung erzwingen');
define('_MYPROFILEREQUESTBANINDAYS',		'Erneute Änderung verbieten innerhalb von');
define('_MYPROFILEDAYSAFTERREQUEST',		'Tagen nach der letzten Änderung');
define('_MYPROFILEDATEFORMAT',				'Zu verwendendes Datums-Format');
define('_MYPROFILEEXPIREDAYS',				'Verfallszeit des Validierungs-Codes');
define('_MYPROFILEDAYS',					'Tage');
define('_MYPROFILEFORCEPROFILESCODE',		'Um die Benutzer zu zwingen, das komplette Profil auszufüllen, kann der folgende Code in den Xanthia-Vorlagen eingefügt werden');
define('_MYPROFILEVALIDUNTILTIMESTAMP',		'Verfallszeit des Benutzer-Profils');
define('_MYPROFILEZERODEACTIVETED',			'in Sekunden, 0 = kein Verfall');
define('_MYPROFILEATTENTIONCHANGE',			'Falls die Benutzer nur gezwungen werden sollen, das Profil zu komplettieren, den Code einfügen und den Verfallszeit auf 0 setzen.');
define('_MYPROFILENNOTYPECHANGESLATER',		'Wegen technischer und logischer Gründe, können Typ und Identifier eines regulären Feldes nicht nachträglich geändert werden.');
define('_MYPROFILESAVECFG',					'Konfiguration aktualisieren');
define('_MYPROFILECFGSTORED',				'Konfiguration erfolgreich aktualisiert');
define('_MYPROFILEMYPROFILEPLUGIN',			'Benutzer-Profile in jeden Zikula-Inhalt integrieren');
define('_MYPROFILEUSEPROFILEPLUGINEXPL',	'Ein Plugin kann aus jedem anderen Modul mit folgendem Code-Stück aufgerufen werden');
define('_MYPROFILEUSEPROFILEPLUGINTEMPLATE','Aber dieses Plugin muss über seine Vorlage manuell konfiguriert werden - die zu bearbeitende Vorlagen-Datei ist');
define('_MYPROFILEUSETABSFORSEPARATORS',	'Abschnittstrenner als Tabs mittels Javascript nur per Klick einbinden - kann für extrem umfangreiche Profilseiten hilfreich sein.');
define('_MYPROFILENOTIFICATION',			'Benachrichtigung an Administrator bei Neuregistrierungen');

// import
define('_MYPROFILEIMPORTDESC',				'Hier befinden sich Funktionen mit denen Daten von anderen Profil-Modulen übernommen werden');
define('_MYPROFILEPNPROFILEIMPORT',			'Daten von pnProfile importieren');
define('_MYPROFILEPNPROFILEAV',				'Das pnProfile-Modul wurde auf dem System gefunden. Falls die vorhandenen Daten im MyProfile-Modul verwendet werden sollen, ist hier ein Import möglich. Fals die pnProfile-Daten per Datenbank-Abzug restauriert wurden, bitte sicher stellen, dass auch die Users Tabellen restauriert wurden - nicht nur die pnProfile-Tabellen sind wichtig!');
define('_MYPROFILEPNPROFILENOTAV',			'pnProfile wurde auf dem System nicht gefunden. Import nicht möglich.');
define('_MYPROFILEPROFILEIMPORT',			'Daten von Profile importieren');
define('_MYPROFILEPROFILEAV',				'Das Profile-Modul wurde auf dem System gefunden. Alle Daten des Profile-Modulsw können in MyProfile importiert werden.');
define('_MYPROFILEOVERWRITECONF',			'Achtung: Daten-Import von diesem Modul löscht eine existierende MyProfile-Konfiguration vor dem Import der Profile-Daten.');
define('_MYPROFILEPROFILENOTAV',			'Das Standard-Profil-Modul wurde auf dem System nicht gefunden. Import nicht möglich.');
define('_MYPROFILEIMPORTDATA',				'Import jetzt starten');
define('_MYPROFILENOSOURCEGIVEN',			'Parameter fehlt: keine Quelle angegeben');
define('_MYPROFILEINVALIDSOURCE',			'Parameter Fehler: ungültige Quelle');
define('_MYPROFILEPNPROFILECONFUNREADABLE',	'pnProfile Konfiguration konnte nicht gelesen werden');
define('_MYPROFILEFIELDSIMPORTERROR',		'An error occured importing the pnProfile configuration');
define('_MYPROFILEUPDATETABLEDEFERROR',		'Beim Aktualisieren der Tabellen-Definitionen trat ein Fehler auf');
define('_MYPROFILEIMPORTSTEPSUCCESSFULL',	'Ein Import-Schritt der Benutzerdaten erfolgreich beendet. Bei einer größeren Datenbasis muss dieser Schritt mehrmals wiederholt werden!');
define('_MYPROFILEABOUT',					'etwa');
define('_MYPROFILELEFT',					'stehen noch aus');
define('_MYPROFILEIMPORTSUCCESSFULL',		'Import beendet');
define('_MYPROFILEITEMSIMPORTES',			'Elemente importiert');
define('_MYPROFILETRUNCATEMYPROFILETABLES',	'Falls MyProfile bereits konfiguriert wurde, geht die Konfiguration verloren! Auch von Benutzern eingegebene Daten gehen verloren! Zusammenführung ist nicht unterstützt!');
define('_MYPROFILEIMPORTSTRUCTURE',			'pnProfile Struktur importieren');
define('_MYPROFILEUPDATETABLES',			'Tabellen aktualisieren');
define('_MYPROFILEIMPORTPROFILEDATA',		'pnProfile Daten in MyProfile importieren');
define('_MYPROFILEUPDATETABLEDEFS',			'Tabellen-Definitionen aktualisieren');
define('_MYPROFILETABLESTRUCTUREUPDATED',	'Tabellen-Struktur aktualisiert');
define('_MYPROFILETABLEDEFUPDATED',			'Tabellen-Definitionen erfolgreich aktualisiert');
define('_MYPROFILESTRUCTUREUPDATED',		'pnProfile Struktur in MyProfile importiert');
define('_MYPROFILEPOSSIBLETIMEOUT',			'Wenn eine sehr große pnProfile-Datenbank vorhanden ist, könnte die Aktualisierung unterbrochen werden, falls das Speicher-Limit oder der Timeout zu klein eingestellt ist. Falls dies eintritt, bitte das Speicher-Limit und die Maximale Ausführungszeit für PHP erhöhen und nochmal versuchen, bis es funktioniert! Außerdem bitte keine anderen Prozesse starten solange die Datenbank importiert wird.');
define('_MYPROFILEPNPROFILEMIGRATIONDONE',	'Umwandlung von pnProfile zu MyProfile ist bereits erfolgt');
define('_MYPROFILERESETMIGRATION',			'Umwandlung fehlgeschlagen');
define('_MYPROFILERESETSTEPSNOW',			'Umwandlung zurück setzen und nochmal mit dem ersten Schritt beginnen.');
define('_MYPROFILESTEPSRESETDONE',			'pnProfile Umwandlung zurück gesetzt');
// findorphans / consistence check
define('_MYPROFILECONSISTENCECHECKDESC',	'Diese Funktion prüft die Konsistenz der MyProfile Datenbank. Das kann erforderlich werden, falls den Benutzern erlaubt ist, die eigene Kennung zu löschen, oder falls Benutzer über das Users-Modul gelöscht wurden. In diesem Fall können noch Daten in den MyProfile-Tabellen gespeichert sein. Diese Funkiton ist die "Müllabfuhr" für dieses Modul.'); 
define('_MYPROFILEYOUHAVE',					'Du hast');
define('_MYPROFILECLEANUP',					'Datenbank bereinigen');
define('_MYPROFILEORPHANS',					'Waisen');
define('_MYPROFILECLEANEDUP',				'Datenbank wurde bereinigt');
define('_MYPROFILECONSISTENCEOK',			'Datenbank ist bereits optimiert');

// editProfile
define('_MYPROFILEEMAILNOTEXISTENT',		'Emailadresse nicht im System vorhanden');
define('_MYPROFILEMORETHANONEUSERFOUND',	'Mehr als ein Benutzer gefunden');
define('_MYPROFILECHOOSEONEUSER',			'bitte einen davon direkt auswählen durch Eingabe des Benutzernamens');
define('_MYPROFILEUNOTFOUND',				'Kein Benutzer mit dieser Kennung oder ID gefunden');
define('_MYPROFILEFILENOTWRITEABLE',		'Konfigurationsdatei nicht schreibbar - bitte vor dem Bearbeiten der Konfiguration korrigieren');
define('_MYPROFILEFILENOTREADABLE',			'Konfigurationsdatei nicht lesbar - bitte vor dem Bearbeiten der Konfiguration korrigieren');
define('_MYPROFILEWRITEFILEPROBLEMS',		'Konfigurationsdate konnte nicht erstellt werden - bitte Verzeichnis-Rechte prüfen');

// configFailure
define('_MYPROFILEERROROCCURED',			'Ein Fehler ist aufgetreten. Bitte Fehlermeldung beachten!');
define('_MYPROFILECFGDIREXIST',				'Ein Verzeichnis "config" im MyProfile Modul ist erforderlich');
define('_MYPROFILECFGDIRWRITABLE',			'Dieses Verzeichnis muss vom Webserver beschreibbar sein');
define('_MYPROFILECFGFILENAME',				'In diesem Verzeichnis wird eine Datei "tabledef.inc" vom Modul angelegt');
define('_MYPROFILECFGREADABLE',				'Diese Datei muss für den Webserver lesbar sein');
define('_MYPROFILECFGWRITABLE',				'Diese Datei muss für den Webserver schreibbar sein');
define('_MYPROFILEPROCEED',					'Nochmal versuchen zum Fortsetzen');

// fields configuration
define('_MYPROFILEIDENTIFIERFORMATWARNING',	'Es dürfen als Bezeichnung / Identifier ausschließlich Buchstaben A-Z, a-z und Zahlen genutzt werden');
define('_MYPROFILECONFIGURATION',			'Deine Profil-Konfiguration');
define('_MYPROFILEREDIRECTFACC',			'Es ist möglich funktionale Kennungen (administrator etc.) umzuleiten. Einfach die ID-Werte der Kennungen als Komma-getrennte Liste eingeben, die als funktionale Kennungen markiert werden sollen.');
define('_MYPROFILEISOPTIONAL',				'optionales Feld');
define('_MYPROFILEISMANDATORY',				'Pflichtfeld');
define('_MYPROFILEALL',						'sichtbar für jedermann');
define('_MYPROFILEREG',						'sichtbar nur für registrierte Benutzer');
define('_MYPROFILEADMIN',					'sichtbar nur für Administrator');
define('_MYPROFILECHARS',					'Zeichen');
define('_MYPROFILEISACTIVE',				'aktiviert');
define('_MYPROFILEISSHOWN',					'angezeigt');
define('_MYPROFILEEXISTINGFIELDS',			'Existierende Felder organisieren');
define('_MYPROFILEMANAGEHOWTO',				'Zum Ändern der Reihenfolge einfach in den Bereich klicken und Element an die gewünschte Stelle verschieben. Die Anordnung wird automatisch gespeichert!');
define('_MYPROFILEEDIT',					'Feld ändern');
define('_MYPROFILEADDSEPARATOR',			'Trenner hinzufügen');
define('_MYPROFILEMOVEUP',					'Nach oben');
define('_MYPROFILEMOVEDOWN',				'Nach unten');
define('_MYPROFILEELEMENTMOVED',			'Element erfolgreich verschoben');

// configuration, ajax interface
define('_MYPROFILESTOREDAT',				'Neue Anordnung erfolgreich gespeichert bei');

// add a new field or modify an existing one
define('_MYPROFILEZEROUNLIMITED',			'0 = Textlänge unbegrenzt');
define('_MYPROFILESEARCHABLE',				'Dieses Feld soll für alle, welche die Suchfunktion benutzen, durchsuchbar sein');
define('_MYPROFILECOORD',					'Koordinate');
define('_MYPROFILEADDNEWFIELD',				'Neues Feld anlegen');
define('_MYPROFILEMODIFYFIELD',				'Existierendes Feld ändern');
define('_MYPROFILEINTROTEXT',				'Hier können eigene Felder des Benutzer-Profils erstellt oder geändert werden');
define('_MYPROFILEIDENTIFIER',				'Identifier des Feldes (und Name der Tabellen-Spalte) oder gegebenenfalls Titel des Trenners');
define('_MYPROFILEYES',						'Ja');
define('_MYPROFILENO',						'Nein');
define('_MYPROFILESTRING',					'Zeichenkette');
define('_MYPROFILEINT',						'Ganzzahl');
define('_MYPROFILEURL',						'URL');
define('_MYPROFILEFLOAT',					'Fließkomma-Zahl');
define('_MYPROFILEUIN',						'ICQ-UIN');
define('_MYPROFILEAIM',						'ICQ-AIM');
define('_MYPROFILESKYPEID',					'Skype-ID');
define('_MYPROFILETEXTBOX',					'Zeichenkette (mehrzeilig)');
define('_MYPROFILEDATE',					'Datum');
define('_MYPROFILETIMESTAMP',				'Zeitpunkt');
define('_MYPROFILESEPARATOR',				'Abschnitt/Tab-Trenner');
define('_MYPROFILEMANDATORY',				'Ist dies Feld zwingend erforderlich');
define('_MYPROFILEDESCRIPTION',				'Beschreibung');
define('_MYPROFILEFIELDTYPE',				'Typ dieses Feldes');
define('_MYPROFILESTRINGLENGTH',			'Maximale Länge der Zeichenkette');
define('_MYPROFILELIST',					'Liste (für Auswahl-Menüs)');
define('_MYPROFILEDROPDOWNEX',				'Beispiel für Dropdown-Liste: @@Zu speichernder Wert||Beschriftung');
define('_MYPROFILEDROPDOWNCODE',			'@@daily||Ich möchte täglich einen Newsletter @@monthly||Schickt mir den Newsletter monatlich  @@no||Ich möchte keinen Newsletter');
define('_MYPROFILERADIOEX',					'Beispiel für Radiobutton: @*Zu speichernder Wert||Beschriftung');
define('_MYPROFILERADIOCODE',				'@*0||Nein @*1||Ja');
define('_MYPROFILEPUBLICSTATUS',			'Öffentlicher Status');
define('_MYPROFILECOPYVALUE',				'Wert des Feldes soll in eine andere Tabellenspalte kopiert werden');
define('_MYPROFILECOPYUIDVALUE',			'Identifier der Benutzerkennung um die korrekte Zeile zu ändern');
define('_MYPROFILEACTIVE',					'Dieses Feld in der Profil-Konfiguration eines Benutzers sichtbar und schreibbar machen');
define('_MYPROFILESHOWN',					'Dieses Feld auf der Profil-Seite eines Benutzers anzeigen, die von diesem Modul erzeugt wird');
define('_MYPROFILESUBMITFIELD',				'Feld anlegen / aktualisieren');
define('_MYPROFILENOCOPYVALUE',				'nichts kopieren');
define('_MYPROFILENOPROTECT',				'Dieses Feld ist für jeden sichtbar');
define('_MYPROFILEREGONLY',					'Nur registrierte Benutzer können den Wert dieses Feldes sehen');
define('_MYPROFILEADMINONLY',				'Nur der Administrator kann den Wert dieses Feldes sehen');
define('_MYPROFILECUSTOM',					'Wer den Inhalt sehen darf entscheidet der Benutzer selbst');
define('_MYPROFILENUMMINVALUE',				'Minimalwert für Ganzzahl- oder Fließkomma-Wert');
define('_MYPROFILENUMMAXVALUE',				'Maximalwert für Ganzzahl- oder Fließkomma-Wert');
define('_MYPROFILEFIELDCREATED',			'Neues Feld wurde erfolgreich angelegt');
define('_MYPROFILEFIELDUPDATED',			'Existierendes Feld wurde erfolgreich aktualisiert');
define('_MYPROFILEDELETEFIELD',				'Dieses Feld löschen');
define('_MYPROFILEFIELDDELERR',				'Fehler beim Löschen des Feldes');
define('_MYPROFILEFIELDDEL',				'Feld erfolgreich gelöscht');

// plugins
define('_MYPROFILEREMOVEPLUGINS',			'Wenn ein Plugin nicht eingebunden werden soll einfach im entsprechenden Modul die Datei myprofileapi.php löschen oder umbenennen');
define('_MYPROFILEPLUGINDESC',				'Einige Module stellen Plugins für das Profil-Modul bereit. Für Entwickler: Bitte werft einen Blick in plugins.txt im Dokumentations-Ordner. Erkannte Plugins werden automatisch benutzt.');
define('_MYPROFILENOPLUGINSFOUND',			'Plugins nicht gefunden!');
