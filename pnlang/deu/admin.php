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
define('_MYPROFILEEDITPROFILE',		'Profil ändern');
define('_MYPROFILEDIRECTPROFILEEDIT',	'Ein Benutzerprofil kann direkt durch Eingabe');
define('_MYPROFILEEDITUNAME',		'des Benutzernamen');
define('_MYPROFILEEDITUID',		'oder der Benutzer-ID');
define('_MYPROFILEEDITPROFILETHEN',	'... bearbeitet werden');
define('_MYPROFILESUPPORTMYPROFILE',	'Unterstütze dieses Modul');
define('_MYPROFILEDONATETHIS',		'Spende per PayPal!');
define('_MYPROFILEDONATE',		'Du magst dieses Modul und es nützt Dir? Dann wäre Dir der Programmierer für eine kleine Spende sehr dankbar! Na klar - ich programmiere sehr gerne und das Modul ist natürlich kostenlos und Open-Source - aber wenn Du etwas springen lässt, dann könnte ich meine Freunding zum Abendessen ausführen und es wird das nächste mal viel leichter sein, zum Programmieren frei zu bekommen ;-)');

// mainsettings
define('_MYPROFILEGLOBALETTINGS',	'Allgemeine Modul-Einstellungen');
define('_MYPROFILEASATTRIBUTES',	'Profil auch als Attribut des Benutzer-Objekts speichern');
define('_MYPROFILEATTRIBUTEUSAGE',	'Ein Benutzer-Profil kann als $myprofile.youridentifier mit diesem Code verwendet werden');
define('_MYPROFILEAPPEARANCE',		'Darstellung');
define('_MYPROFILEBEHAVIOUR',		'Verhalten');
define('_MYPROFILENOTABS',		'Ohne Tabellen-Reiter / AJAX-Code wird vermieden');
define('_MYPROFILEEMAILMANAGEMENT',	'E-Mail-Adressen Organisation');
define('_MYPROFILENOVERIFICATION',	'Keine Verifikation bei der E-Mail-Änderung erzwingen');
define('_MYPROFILEREQUESTBANINDAYS',	'Erneute Änderung verbieten innerhalb von');
define('_MYPROFILEDAYSAFTERREQUEST',	'Tagen nach der letzten Änderung');
define('_MYPROFILEDATEFORMAT',		'Zu verwendendes Datums-Format');
define('_MYPROFILEEXPIREDAYS',		'Verfallszeit des Validierungs-Codes');
define('_MYPROFILEDAYS',		'Tage');
define('_MYPROFILEFORCEPROFILESCODE',	'Um die Benutzer zu zwingen, das komplette Profil auszufüllen, kann der folgende Code in den Xanthia-Vorlagen eingefügt werden');
define('_MYPROFILEVALIDUNTILTIMESTAMP',	'Verfallszeit des Benutzer-Profils');
define('_MYPROFILEZERODEACTIVETED',	'in Sekunden, 0 = kein Verfall');
define('_MYPROFILEATTENTIONCHANGE',	'Falls die Benutzer nur gezwungen werden sollen, das Profil zu komplettieren, den Code einfügen und den Verfallszeit auf 0 setzen.');
define('_MYPROFILENNOTYPECHANGESLATER',	'Wegen technischer und logischer Gründe, können Typ und Kennung eines regulären Feldes nicht nachträglich geändert werden.');
define('_MYPROFILESAVECFG',		'Konfiguration aktualisieren');
define('_MYPROFILECFGSTORED',		'Konfiguration erfolgreich aktualisiert');
define('_MYPROFILEMYPROFILEPLUGIN',	'Benutzer-Profile in jeden Zikula-Inhalt integrieren');
define('_MYPROFILEUSEPROFILEPLUGINEXPL',	'Ein Plugin kann aus jedem anderen Modul mit folgendem Code-Stück aufgerufen werden');
define('_MYPROFILEUSEPROFILEPLUGINTEMPLATE',	'Aber dieses Plugin muss über seine Vorlage manuell konfiguriert werden - die zu bearbeitende Vorlagen-Datei ist');
define('_MYPROFILEUSELASTSEEN',		'"Zuletzt online" Datum im Benutzer-Profil verwenden');
define('_MYPROFILELASTSEENTEXT',	'Nach Aktivierung dieser Funktion im Users-Modul speichert Zikula das Datum des letzten Login in der Benutzer-Variablen "lastlogin". Diese Variable wird in der Benutzer-Profil-Seite verwendet. Falls aber die Sicherheits-Einstellung nicht "hoch" ist, müssen sich Benutzer nicht bei jedem Zugriff anmelden und bleiben möglicherweise über längere Zeit (mehrere Tage oder sogar Monate) angemeldet und das Datum wird sich vom Zeitpunkt der letzten Aktivität des Benutzers stark unterscheiden. Um diesen "Fehler" zu korrigieren, kann die folgende Zeile in die index.php im Basis-Verzeichnis bei Zeile 25, vor der Zeile die mit "// Get Variables" beginnt, eingegeben werden:'); 


// import
define('_MYPROFILEIMPORTDESC',		'Hier befinden sich Funktionen mit denen Daten von anderen Profil-Modulen übernommen werden');
define('_MYPROFILEPNPROFILEIMPORT',	'Daten von pnProfile importieren');
define('_MYPROFILEPNPROFILEAV',		'Das pnProfile-Modul wurde auf dem System gefunden. Falls die vorhandenen Daten im MyProfile-Modul verwendet werden sollen, ist hier ein Import möglich. Fals die pnProfile-Daten per Datenbank-Abzug restauriert wurden, bitte sicher stellen, dass auch die Users Tabellen restauriert wurden - nicht nur die pnProfile-Tabellen sind wichtig!');
define('_MYPROFILEPNPROFILENOTAV',	'pnProfile wurde auf dem System nicht gefunden. Import nicht möglich.');
define('_MYPROFILEPROFILEIMPORT',	'Daten von Profile importieren');
define('_MYPROFILEPROFILEAV',		'Das Profile-Modul wurde auf dem System gefunden. Alle Daten des Profile-Modulsw können in MyProfile importiert werden.');
define('_MYPROFILEOVERWRITECONF',	'Achtung: Daten-Import von diesem Modul löscht eine existierende MyProfile-Konfiguration vor dem Import der Profile-Daten.');
define('_MYPROFILEPROFILENOTAV',	'Das Standard-Profil-Modul wurde auf dem System nicht gefunden. Import nicht möglich.');
define('_MYPROFILEIMPORTDATA',		'Import jetzt starten');
define('_MYPROFILENOSOURCEGIVEN',	'Parameter fehlt: keine Quelle angegeben');
define('_MYPROFILEINVALIDSOURCE',	'Parameter Fehler: ungültige Quelle');
define('_MYPROFILEPNPROFILECONFUNREADABLE',	'pnProfile Konfiguration konnte nicht gelesen werden');
define('_MYPROFILEFIELDSIMPORTERROR',	'An error occured importing the pnProfile configuration');
define('_MYPROFILEUPDATETABLEDEFERROR',	'Beim Aktualisieren der Tabellen-Definitionen trat ein Fehler auf');
define('_MYPROFILEIMPORTSUCCESSFULL',	'Import beendet');
define('_MYPROFILEITEMSIMPORTES',	'Elemente importiert');
define('_MYPROFILETRUNCATEMYPROFILETABLES',	'Falls MyProfile bereits konfiguriert wurde, geht die Konfiguration verloren! Auch von Benutzern eingegebene Daten gehen verloren! Zusammenführung ist nicht unterstützt!');
define('_MYPROFILEIMPORTSTRUCTURE',	'pnProfile Struktur importieren');
define('_MYPROFILEUPDATETABLES',	'Tabellen aktualisieren');
define('_MYPROFILEIMPORTPROFILEDATA',	'pnProfile Daten in MyProfile importieren');
define('_MYPROFILEUPDATETABLEDEFS',	'Tabellen-Definitionen aktualisieren');
define('_MYPROFILETABLESTRUCTUREUPDATED',	'Tabellen-Struktur aktualisiert');
define('_MYPROFILETABLEDEFUPDATED',	'Tabellen-Definitionen erfolgreich aktualisiert');
define('_MYPROFILESTRUCTUREUPDATED',	'pnProfile Struktur in MyProfile importiert');
define('_MYPROFILEPOSSIBLETIMEOUT',	'Wenn eine sehr große pnProfile-Datenbank vorhanden ist, könnte die Aktualisierung unterbrochen werden, falls das Speicher-Limit oder der Timeout zu klein eingestellt ist. Falls dies eintritt, bitte das Speicher-Limit und die Maximale Ausführungszeit für PHP erhöhen und nochmal versuchen, bis es funktioniert! Außerdem bitte keine anderen Prozesse starten solange die Datenbank importiert wird.');
define('_MYPROFILEPNPROFILEMIGRATIONDONE',	'Umwandlung von pnProfile zu MyProfile ist bereits erfolgt');
define('_MYPROFILERESETMIGRATION',	'Umwandlung fehlgeschlagen');
define('_MYPROFILERESETSTEPSNOW',	'Umwandlung zurück setzen und nochmal mit dem ersten Schritt beginnen.');
define('_MYPROFILESTEPSRESETDONE',	'pnProfile Umwandlung zurück gesetzt');
// findorphans / consistence check
define('_MYPROFILECONSISTENCECHECKDESC',	'Diese Funktion prüft die Konsistenz der MyProfile Datenbank. Das kann erforderlich werden, falls den Benutzern erlaubt ist, die eigene Kennung zu löschen, oder falls Benutzer über das Users-Modul gelöscht wurden. In diesem Fall können noch Daten in den MyProfile-Tabellen gespeichert sein. Diese Funkiton ist die "Müllabfuhr" für dieses Modul.'); 
define('_MYPROFILEYOUHAVE',		'Du hast');
define('_MYPROFILECLEANUP',		'Datenbank bereinigen');
define('_MYPROFILEORPHANS',		'Waisen');
define('_MYPROFILECLEANEDUP',		'Datenbank wurde bereinigt');
define('_MYPROFILECONSISTENCEOK',	'Datenbank ist bereits optimiert');

// editProfile
define('_MYPROFILEUNOTFOUND',		'Kein Benutzer mit dieser Kennung oder ID gefunden');
define('_MYPROFILEFILENOTWRITEABLE',	'Konfigurationsdatei nicht schreibbar - bitte vor dem Bearbeiten der Konfiguration korrigieren');
define('_MYPROFILEFILENOTREADABLE',	'Konfigurationsdatei nicht lesbar - bitte vor dem Bearbeiten der Konfiguration korrigieren');
define('_MYPROFILEWRITEFILEPROBLEMS',	'Konfigurationsdate konnte nicht erstellt werden - bitte Verzeichnis-Rechte prüfen');

// configFailure
define('_MYPROFILEERROROCCURED',	'Ein Fehler ist aufgetreten. Bitte Fehlermeldung beachten!');
define('_MYPROFILECFGDIREXIST',		'Ein Verzeichnis "config" im MyProfile Modul ist erforderlich');
define('_MYPROFILECFGDIRWRITABLE',	'Dieses Verzeichnis muss vom Webserver beschreibbar sein');
define('_MYPROFILECFGFILENAME',		'In diesem Verzeichnis wird eine Datei "tabledef.inc" vom Modul angelegt');
define('_MYPROFILECFGREADABLE',		'Diese Datei muss für den Webserver lesbar sein');
define('_MYPROFILECFGWRITABLE',		'Diese Datei muss für den Webserver schreibbar sein');
define('_MYPROFILEPROCEED',		'Nochmal versuchen zum Fortsetzen');

// fields configuration
define('_MYPROFILECONFIGURATION',	'Deine Profil-Konfiguration');
define('_MYPROFILEREDIRECTFACC',	'Es ist möglich funktionale Kennungen (administrator etc.) umzuleiten. Einfach die ID-Werte der Kennungen als Komma-getrennte Liste eingeben, die als funktionale Kennungen markiert werden sollen.');
define('_MYPROFILEISOPTIONAL',		'optionales Feld');
define('_MYPROFILEISMANDATORY',		'Pflichtfeld');
define('_MYPROFILEALL',			'sichtbar für jedermann');
define('_MYPROFILEREG',			'sichtbar nur für registrierte Benutzer');
define('_MYPROFILEADMIN',		'sichtbar nur für Administrator');
define('_MYPROFILECHARS',		'Zeichen');
define('_MYPROFILEISACTIVE',		'aktiviert');
define('_MYPROFILEISSHOWN',		'angezeigt');
define('_MYPROFILEEXISTINGFIELDS',	'Existierende Felder organisieren');
define('_MYPROFILEMANAGEHOWTO',		'Zum Ändern der Reihenfolge einfach in den Bereich klicken und Element an die gewünschte Stelle verschieben. Die Anordnung wird automatisch gespeichert!');
define('_MYPROFILEEDIT',		'Feld ändern');
define('_MYPROFILEADDSEPARATOR',	'Trenner hinzufügen');
define('_MYPROFILEMOVEUP',		'Nach oben');
define('_MYPROFILEMOVEDOWN',		'Nach unten');
define('_MYPROFILEELEMENTMOVED',	'Element erfolgreich verschoben');

// configuration, ajax interface
define('_MYPROFILESTOREDAT',		'Neue Anordnung erfolgreich gespeichert bei');

// add a new field or modify an existing one
define('_MYPROFILEADDNEWFIELD',		'Neues Feld anlegen');
define('_MYPROFILEMODIFYFIELD',		'Existierendes Feld ändern');
define('_MYPROFILEINTROTEXT',		'Hier können eigene Felder des Benutzer-Profils erstellt oder geändert werden');
define('_MYPROFILEIDENTIFIER',		'Identifier des Feldes (und Name der Tabellen-Spalte) oder gegebenenfalls Titel des Trenners');
define('_MYPROFILEYES',			'Ja');
define('_MYPROFILENO',			'Nein');
define('_MYPROFILESTRING',		'Zeichenkette');
define('_MYPROFILEINT',			'Ganzzahl');
define('_MYPROFILEURL',			'URL');
define('_MYPROFILEFLOAT',		'Fließkomma-Zahl');
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
define('_MYPROFILESTRINGLENGTH',	'Maximale Länge der Zeichenkette');
define('_MYPROFILELIST',		'Liste (für Auswahl-Menüs)');
define('_MYPROFILEDROPDOWNEX',		'Beispiel für Mehrfach-Auswahl (Dropdown): @@Zu speichernder Wert||Beschriftung');
define('_MYPROFILEDROPDOWNCODE',	'@@daily||Ich möchte täglich einen Newsletter @@monthly||Schickt mir den Newsletter monatlich  @@no||Ich möchte keinen Newsletter');
define('_MYPROFILERADIOEX',		'Beispiel für Einzel-Auswahl (Radiobutton): @*Zu speichernder Wert||Beschriftung');
define('_MYPROFILERADIOCODE',		'@*0||Nein @*1||Ja');
define('_MYPROFILEPUBLICSTATUS',	'Öffentlicher Status');
define('_MYPROFILECOPYVALUE',		'Wert des Feldes soll in eine andere Tabellenspalte kopiert werden');
define('_MYPROFILECOPYUIDVALUE',	'Identifier der Benutzerkennung um die korrekte Zeile zu ändern');
define('_MYPROFILEACTIVE',		'Dieses Feld in der Profil-Konfiguration eines Benutzers sichtbar und schreibbar machen');
define('_MYPROFILESHOWN',		'Dieses Feld auf der Profil-Seite eines Benutzers anzeigen, die von diesem Modul erzeugt wird');
define('_MYPROFILESUBMITFIELD',		'Feld anlegen / aktualisieren');
define('_MYPROFILENOCOPYVALUE',		'nichts kopieren');
define('_MYPROFILENOPROTECT',		'Dieses Feld ist für jeden sichtbar');
define('_MYPROFILEREGONLY',		'Nur registrierte Benutzer können den Wert dieses Feldes sehen');
define('_MYPROFILEADMINONLY',		'Nur der Administrator kann den Wert dieses Feldes sehen');
define('_MYPROFILENUMMINVALUE',		'Minimalwert für Ganzzahl- oder Fließkomma-Wert');
define('_MYPROFILENUMMAXVALUE',		'Maximalwert für Ganzzahl- oder Fließkomma-Wert');
define('_MYPROFILEFIELDCREATED',	'Neues Feld wurde erfolgreich angelegt');
define('_MYPROFILEFIELDUPDATED',	'Existierendes Feld wurde erfolgreich aktualisiert');
define('_MYPROFILEDELETEFIELD',		'Dieses Feld löschen');
define('_MYPROFILEFIELDDELERR',		'Fehler beim Löschen des Feldes');
define('_MYPROFILEFIELDDEL',		'Feld erfolgreich gelöscht');

// plugins
define('_MYPROFILEPLUGINDESC',		'Einige Module stellen Plugins für das Profil-Modul bereit. Für Entwickler: Bitte werft einen Blick in plugins.txt im Dokumentations-Ordner. Erkannte Plugins werden automatisch benutzt. Um ein Plugin zu entfernen, reicht es den Ordner myprofile im Ordner des Moduls zu löschen, das ein Plugin zur verfügung stellt.');
define('_MYPROFILENOPLUGINSFOUND',	'Plugins nicht gefunden!');
?>
