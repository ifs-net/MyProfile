<?php
// menu
define('_MYPROFILEMAIN',		'Hauptseite / Benutzer bearbeiten');
define('_MYPROFILEMAINSETTINGS',	'Modul-Konfiguration');
define('_MYPROFILEACTUALCONFIG',	'Profil-Konfiguration');
define('_MYPROFILEFINDORPHANS',		'Reparieren');
define('_MYPROFILEPLUGINS',		'Profil-Plugins');
define('_MYPROFILEIMPORTFUNCS',		'Import');

//main
define('_MYPROFILEBACKEND',		'MyProfile Backend-Konfiguration');
define('_MYPROFILEBACKENDDESCR',	'Willkommen bei MyProfile - dem fortschrittlichen zikula ProfilModul!');
define('_MYPROFILEEDITPROFILE',		'Profil �ndern');
define('_MYPROFILEDIRECTPROFILEEDIT',	'Ein Benutzerprofil kann direkt durch Eingabe');
define('_MYPROFILEEDITUNAME',		'des Benutzernamen');
define('_MYPROFILEEDITUID',		'oder der Benutzer-ID');
define('_MYPROFILEEDITPROFILETHEN',	'... bearbeitet werden');
define('_MYPROFILESUPPORTMYPROFILE',	'Unterst�tze dieses Modul');
define('_MYPROFILEDONATETHIS',		'Spende per PayPal!');
define('_MYPROFILEDONATE',		'Du magst dieses Modul und es n�tzt Dir? Dann w�re Dir der Programmierer f�r eine kleine Spende sehr dankbar! Na klar - ich programmiere sehr gerne und das Modul ist nat�rlich kostenlos und Open-Source - aber wenn Du etwas springen l�sst, dann k�nnte ich meine Freunding zum Abendessen ausf�hren und es wird das n�chste mal viel leichter sein, zum Programmieren frei zu bekommen ;-)');

// mainsettings
define('_MYPROFILEGLOBALETTINGS',	'Allgemeine Modul-Einstellungen');
define('_MYPROFILEASATTRIBUTES',	'Profil auch als Attribut des Benutzer-Objekts speichern');
define('_MYPROFILEATTRIBUTEUSAGE',	'Ein Benutzer-Profil kann als $myprofile.youridentifier mit diesem Code verwendet werden');
define('_MYPROFILEAPPEARANCE',		'Darstellung');
define('_MYPROFILEBEHAVIOUR',		'Verhalten');
define('_MYPROFILENOTABS',		'Ohne Tabellen-Reiter / AJAX-Code wird vermieden');
define('_MYPROFILEEMAILMANAGEMENT',	'E-Mail-Adressen Organisation');
define('_MYPROFILENOVERIFICATION',	'Keine Verifikation bei der E-Mail-�nderung erzwingen');
define('_MYPROFILEREQUESTBANINDAYS',	'Erneute �nderung verbieten innerhalb von');
define('_MYPROFILEDAYSAFTERREQUEST',	'Tagen nach der letzten �nderung');
define('_MYPROFILEDATEFORMAT',		'Zu verwendendes Datums-Format');
define('_MYPROFILEEXPIREDAYS',		'Verfallszeit des Validierungs-Codes');
define('_MYPROFILEDAYS',		'Tage');
define('_MYPROFILEFORCEPROFILESCODE',	'Um die Benutzer zu zwingen, das komplette Profil auszuf�llen, kann der folgende Code in den Xanthia-Vorlagen eingef�gt werden');
define('_MYPROFILEVALIDUNTILTIMESTAMP',	'Verfallszeit des Benutzer-Profils');
define('_MYPROFILEZERODEACTIVETED',	'in Sekunden, 0 = kein Verfall');
define('_MYPROFILEATTENTIONCHANGE',	'Falls die Benutzer nur gezwungen werden sollen, das Profil zu komplettieren, den Code einf�gen und den Verfallszeit auf 0 setzen.');
define('_MYPROFILENNOTYPECHANGESLATER',	'Wegen technischer und logischer Gr�nde, k�nnen Typ und Kennung eines regul�ren Feldes nicht nachtr�glich ge�ndert werden.');
define('_MYPROFILESAVECFG',		'Konfiguration aktualisieren');
define('_MYPROFILECFGSTORED',		'Konfiguration erfolgreich aktualisiert');
define('_MYPROFILEMYPROFILEPLUGIN',	'Benutzer-Profile in jeden Zikula-Inhalt integrieren');
define('_MYPROFILEUSEPROFILEPLUGINEXPL',	'Ein Plugin kann aus jedem anderen Modul mit folgendem Code-St�ck aufgerufen werden');
define('_MYPROFILEUSEPROFILEPLUGINTEMPLATE',	'Aber dieses Plugin muss �ber seine Vorlage manuell konfiguriert werden - die zu bearbeitende Vorlagen-Datei ist');
define('_MYPROFILEUSELASTSEEN',		'"Zuletzt online" Datum im Benutzer-Profil verwenden');
define('_MYPROFILELASTSEENTEXT',	'Nach Aktivierung dieser Funktion im Users-Modul speichert Zikula das Datum des letzten Login in der Benutzer-Variablen "lastlogin". Diese Variable wird in der Benutzer-Profil-Seite verwendet. Falls aber die Sicherheits-Einstellung nicht "hoch" ist, m�ssen sich Benutzer nicht bei jedem Zugriff anmelden und bleiben m�glicherweise �ber l�ngere Zeit (mehrere Tage oder sogar Monate) angemeldet und das Datum wird sich vom Zeitpunkt der letzten Aktivit�t des Benutzers stark unterscheiden. Um diesen "Fehler" zu korrigieren, kann die folgende Zeile in die index.php im Basis-Verzeichnis bei Zeile 25, vor der Zeile die mit "// Get Variables" beginnt, eingegeben werden:'); 


// import
define('_MYPROFILEIMPORTDESC',		'Hier befinden sich Funktionen mit denen Daten von anderen Profil-Modulen �bernommen werden');
define('_MYPROFILEPNPROFILEIMPORT',	'Daten von pnProfile importieren');
define('_MYPROFILEPNPROFILEAV',		'Das pnProfile-Modul wurde auf dem System gefunden. Falls die vorhandenen Daten im MyProfile-Modul verwendet werden sollen, ist hier ein Import m�glich. Fals die pnProfile-Daten per Datenbank-Abzug restauriert wurden, bitte sicher stellen, dass auch die Users Tabellen restauriert wurden - nicht nur die pnProfile-Tabellen sind wichtig!');
define('_MYPROFILEPNPROFILENOTAV',	'pnProfile wurde auf dem System nicht gefunden. Import nicht m�glich.');
define('_MYPROFILEPROFILEIMPORT',	'Daten von Profile importieren');
define('_MYPROFILEPROFILEAV',		'Das Profile-Modul wurde auf dem System gefunden. Alle Daten des Profile-Modulsw k�nnen in MyProfile importiert werden.');
define('_MYPROFILEOVERWRITECONF',	'Achtung: Daten-Import von diesem Modul l�scht eine existierende MyProfile-Konfiguration vor dem Import der Profile-Daten.');
define('_MYPROFILEPROFILENOTAV',	'Das Standard-Profil-Modul wurde auf dem System nicht gefunden. Import nicht m�glich.');
define('_MYPROFILEIMPORTDATA',		'Import jetzt starten');
define('_MYPROFILENOSOURCEGIVEN',	'Parameter fehlt: keine Quelle angegeben');
define('_MYPROFILEINVALIDSOURCE',	'Parameter Fehler: ung�ltige Quelle');
define('_MYPROFILEPNPROFILECONFUNREADABLE',	'pnProfile Konfiguration konnte nicht gelesen werden');
define('_MYPROFILEFIELDSIMPORTERROR',	'An error occured importing the pnProfile configuration');
define('_MYPROFILEUPDATETABLEDEFERROR',	'Beim Aktualisieren der Tabellen-Definitionen trat ein Fehler auf');
define('_MYPROFILEIMPORTSUCCESSFULL',	'Import beendet');
define('_MYPROFILEITEMSIMPORTES',	'Elemente importiert');
define('_MYPROFILETRUNCATEMYPROFILETABLES',	'Falls MyProfile bereits konfiguriert wurde, geht die Konfiguration verloren! Auch von Benutzern eingegebene Daten gehen verloren! Zusammenf�hrung ist nicht unterst�tzt!');
define('_MYPROFILEIMPORTSTRUCTURE',	'pnProfile Struktur importieren');
define('_MYPROFILEUPDATETABLES',	'Tabellen aktualisieren');
define('_MYPROFILEIMPORTPROFILEDATA',	'pnProfile Daten in MyProfile importieren');
define('_MYPROFILEUPDATETABLEDEFS',	'Tabellen-Definitionen aktualisieren');
define('_MYPROFILETABLESTRUCTUREUPDATED',	'Tabellen-Struktur aktualisiert');
define('_MYPROFILETABLEDEFUPDATED',	'Tabellen-Definitionen erfolgreich aktualisiert');
define('_MYPROFILESTRUCTUREUPDATED',	'pnProfile Struktur in MyProfile importiert');
define('_MYPROFILEPOSSIBLETIMEOUT',	'Wenn eine sehr gro�e pnProfile-Datenbank vorhanden ist, k�nnte die Aktualisierung unterbrochen werden, falls das Speicher-Limit oder der Timeout zu klein eingestellt ist. Falls dies eintritt, bitte das Speicher-Limit und die Maximale Ausf�hrungszeit f�r PHP erh�hen und nochmal versuchen, bis es funktioniert! Au�erdem bitte keine anderen Prozesse starten solange die Datenbank importiert wird.');
define('_MYPROFILEPNPROFILEMIGRATIONDONE',	'Umwandlung von pnProfile zu MyProfile ist bereits erfolgt');
define('_MYPROFILERESETMIGRATION',	'Umwandlung fehlgeschlagen');
define('_MYPROFILERESETSTEPSNOW',	'Umwandlung zur�ck setzen und nochmal mit dem ersten Schritt beginnen.');
define('_MYPROFILESTEPSRESETDONE',	'pnProfile Umwandlung zur�ck gesetzt');
// findorphans / consistence check
define('_MYPROFILECONSISTENCECHECKDESC',	'Diese Funktion pr�ft die Konsistenz der MyProfile Datenbank. Das kann erforderlich werden, falls den Benutzern erlaubt ist, die eigene Kennung zu l�schen, oder falls Benutzer �ber das Users-Modul gel�scht wurden. In diesem Fall k�nnen noch Daten in den MyProfile-Tabellen gespeichert sein. Diese Funkiton ist die "M�llabfuhr" f�r dieses Modul.'); 
define('_MYPROFILEYOUHAVE',		'Du hast');
define('_MYPROFILECLEANUP',		'Datenbank bereinigen');
define('_MYPROFILEORPHANS',		'Waisen');
define('_MYPROFILECLEANEDUP',		'Datenbank wurde bereinigt');
define('_MYPROFILECONSISTENCEOK',	'Datenbank ist bereits optimiert');

// editProfile
define('_MYPROFILEUNOTFOUND',		'Kein Benutzer mit dieser Kennung oder ID gefunden');
define('_MYPROFILEFILENOTWRITEABLE',	'Konfigurationsdatei nicht schreibbar - bitte vor dem Bearbeiten der Konfiguration korrigieren');
define('_MYPROFILEFILENOTREADABLE',	'Konfigurationsdatei nicht lesbar - bitte vor dem Bearbeiten der Konfiguration korrigieren');
define('_MYPROFILEWRITEFILEPROBLEMS',	'Konfigurationsdate konnte nicht erstellt werden - bitte Verzeichnis-Rechte pr�fen');

// configFailure
define('_MYPROFILEERROROCCURED',	'Ein Fehler ist aufgetreten. Bitte Fehlermeldung beachten!');
define('_MYPROFILECFGDIREXIST',		'Ein Verzeichnis "config" im MyProfile Modul ist erforderlich');
define('_MYPROFILECFGDIRWRITABLE',	'Dieses Verzeichnis muss vom Webserver beschreibbar sein');
define('_MYPROFILECFGFILENAME',		'In diesem Verzeichnis wird eine Datei "tabledef.inc" vom Modul angelegt');
define('_MYPROFILECFGREADABLE',		'Diese Datei muss f�r den Webserver lesbar sein');
define('_MYPROFILECFGWRITABLE',		'Diese Datei muss f�r den Webserver schreibbar sein');
define('_MYPROFILEPROCEED',		'Nochmal versuchen zum Fortsetzen');

// fields configuration
define('_MYPROFILECONFIGURATION',	'Deine Profil-Konfiguration');
define('_MYPROFILEREDIRECTFACC',	'Es ist m�glich funktionale Kennungen (administrator etc.) umzuleiten. Einfach die ID-Werte der Kennungen als Komma-getrennte Liste eingeben, die als funktionale Kennungen markiert werden sollen.');
define('_MYPROFILEISOPTIONAL',		'optionales Feld');
define('_MYPROFILEISMANDATORY',		'Pflichtfeld');
define('_MYPROFILEALL',			'sichtbar f�r jedermann');
define('_MYPROFILEREG',			'sichtbar nur f�r registrierte Benutzer');
define('_MYPROFILEADMIN',		'sichtbar nur f�r Administrator');
define('_MYPROFILECHARS',		'Zeichen');
define('_MYPROFILEISACTIVE',		'aktiviert');
define('_MYPROFILEISSHOWN',		'angezeigt');
define('_MYPROFILEEXISTINGFIELDS',	'Existierende Felder organisieren');
define('_MYPROFILEMANAGEHOWTO',		'Zum �ndern der Reihenfolge einfach in den Bereich klicken und Element an die gew�nschte Stelle verschieben. Die Anordnung wird automatisch gespeichert!');
define('_MYPROFILEEDIT',		'Feld �ndern');
define('_MYPROFILEADDSEPARATOR',	'Trenner hinzuf�gen');
define('_MYPROFILEMOVEUP',		'Nach oben');
define('_MYPROFILEMOVEDOWN',		'Nach unten');
define('_MYPROFILEELEMENTMOVED',	'Element erfolgreich verschoben');

// configuration, ajax interface
define('_MYPROFILESTOREDAT',		'Neue Anordnung erfolgreich gespeichert bei');

// add a new field or modify an existing one
define('_MYPROFILEADDNEWFIELD',		'Neues Feld anlegen');
define('_MYPROFILEMODIFYFIELD',		'Existierendes Feld �ndern');
define('_MYPROFILEINTROTEXT',		'Hier k�nnen eigene Felder des Benutzer-Profils erstellt oder ge�ndert werden');
define('_MYPROFILEIDENTIFIER',		'Identifier des Feldes (und Name der Tabellen-Spalte) oder gegebenenfalls Titel des Trenners');
define('_MYPROFILEYES',			'Ja');
define('_MYPROFILENO',			'Nein');
define('_MYPROFILESTRING',		'Zeichenkette');
define('_MYPROFILEINT',			'Ganzzahl');
define('_MYPROFILEURL',			'URL');
define('_MYPROFILEFLOAT',		'Flie�komma-Zahl');
define('_MYPROFILEUIN',			'ICQ-UIN');
define('_MYPROFILEAIM',			'ICQ-AIM');
define('_MYPROFILESKYPEID',		'Skype-ID');
define('_MYPROFILETEXTBOX',		'Zeichenkette (mehrzeilig)');
define('_MYPROFILEDATE',		'Datum');
define('_MYPROFILETIMESTAMP',		'Zeitpunkt');
define('_MYPROFILESEPARATOR',		'Trenner');
define('_MYPROFILEMANDATORY',		'Ist dies Feld zwingend erforderlich');
define('_MYPROFILEDESCRIPTION',		'Beschreibung');
define('_MYPROFILEFIELDTYPE',		'Typ dieses Feldes');
define('_MYPROFILESTRINGLENGTH',	'Maximale L�nge der Zeichenkette');
define('_MYPROFILELIST',		'Liste (f�r Auswahl-Men�s)');
define('_MYPROFILEDROPDOWNEX',		'Beispiel f�r Mehrfach-Auswahl (Dropdown): @@Zu speichernder Wert||Beschriftung');
define('_MYPROFILEDROPDOWNCODE',	'@@daily||Ich m�chte t�glich einen Newsletter @@monthly||Schickt mir den Newsletter monatlich  @@no||Ich m�chte keinen Newsletter');
define('_MYPROFILERADIOEX',		'Beispiel f�r Einzel-Auswahl (Radiobutton): @*Zu speichernder Wert||Beschriftung');
define('_MYPROFILERADIOCODE',		'@*0||Nein @*1||Ja');
define('_MYPROFILEPUBLICSTATUS',	'�ffentlicher Status');
define('_MYPROFILECOPYVALUE',		'Wert des Feldes soll in eine andere Tabellenspalte kopiert werden');
define('_MYPROFILECOPYUIDVALUE',	'Identifier der Benutzerkennung um die korrekte Zeile zu �ndern');
define('_MYPROFILEACTIVE',		'Dieses Feld in der Profil-Konfiguration eines Benutzers sichtbar und schreibbar machen');
define('_MYPROFILESHOWN',		'Dieses Feld auf der Profil-Seite eines Benutzers anzeigen, die von diesem Modul erzeugt wird');
define('_MYPROFILESUBMITFIELD',		'Feld anlegen / aktualisieren');
define('_MYPROFILENOCOPYVALUE',		'nichts kopieren');
define('_MYPROFILENOPROTECT',		'Dieses Feld ist f�r jeden sichtbar');
define('_MYPROFILEREGONLY',		'Nur registrierte Benutzer k�nnen den Wert dieses Feldes sehen');
define('_MYPROFILEADMINONLY',		'Nur der Administrator kann den Wert dieses Feldes sehen');
define('_MYPROFILENUMMINVALUE',		'Minimalwert f�r Ganzzahl- oder Flie�komma-Wert');
define('_MYPROFILENUMMAXVALUE',		'Maximalwert f�r Ganzzahl- oder Flie�komma-Wert');
define('_MYPROFILEFIELDCREATED',	'Neues Feld wurde erfolgreich angelegt');
define('_MYPROFILEFIELDUPDATED',	'Existierendes Feld wurde erfolgreich aktualisiert');
define('_MYPROFILEDELETEFIELD',		'Dieses Feld l�schen');
define('_MYPROFILEFIELDDELERR',		'Fehler beim L�schen des Feldes');
define('_MYPROFILEFIELDDEL',		'Feld erfolgreich gel�scht');

// plugins
define('_MYPROFILEPLUGINDESC',		'Einige Module stellen Plugins f�r das Profil-Modul bereit. F�r Entwickler: Bitte werft einen Blick in plugins.txt im Dokumentations-Ordner. Erkannte Plugins werden automatisch benutzt. Um ein Plugin zu entfernen, reicht es den Ordner myprofile im Ordner des Moduls zu l�schen, das ein Plugin zur verf�gung stellt.');
define('_MYPROFILENOPLUGINSFOUND',	'Plugins nicht gefunden!');
?>
