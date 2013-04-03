<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2009
 * Date:		$Date$
 * -----------------------------------------------------------------------
 * @author		$Author$
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev$
 * 
 * $Id$
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}
$german_array = array(
	'classes' => array(
		0 => 'Unbekannt',
		1 => 'Assassine',
		2 => 'Berserker',
		25 => 'Bestienfürst',
		3 => 'Brigant',
		6 => 'Elementalist',
		5 => 'Erzwinger',
		9 => 'Furie',
		23 => 'Hexenmeister',
		12 => 'Inquisitor',
		8 => 'Klagesänger',
		13 => 'Mönch',
		14 => 'Mystiker',
		15 => 'Nekromant',
		16 => 'Paladin',
		4 => 'Raufbold',
		18 => 'Schattenritter',
		7 => 'Schänder',
		19 => 'Säbelrassler',
		20 => 'Templer',
		11 => 'Thaumaturgist',
		21 => 'Troubadour',
		17 => 'Waldläufer',
		10 => 'Wächter',
		22 => 'Wärter',
		24 => 'Zauberer',
		
	),
	'races' => array(
		'Unbekannt',
		'Sarnak',
		'Gnom',
		'Mensch',
		'Barbar',
		'Zwerg',
		'Hochelf',
		'Dunkelelf',
		'Waldelf',
		'Halbelf',
		'Kerraner',
		'Troll',
		'Oger',
		'Froschlok',
		'Erudit',
		'Iksar',
		'Rattonga',
		'Halbling',
		'Arasai',
		'Fee',
		'Freiblüter'
	),
	'factions' => array(
		'Gut',
		'Böse',
		'Neutral'
	),
	
		'roles' => array(
		1 => array(7, 9, 12, 14, 20, 22),
		2 => array(2, 4, 10, 13, 16, 8),
		3 => array(5, 6, 11, 15, 23, 24),
		4 => array(1, 25, 3, 8, 17, 19, 21)
	),
	
	'lang' => array(
		'eq2'			=> 'EverQuest II',
		'very_light'	=> 'Stoff',
		'light'			=> 'Leder',
		'medium'		=> 'Kette',
		'heavy'			=> 'Platte',
		'healer'        => 'Heiler',
		'fighter'       => 'Kämpfer',
		'mage'          => 'Magier',
		'scout'         => 'Kundschafter',
		'role1' => 'Heiler',
		'role2' => 'Kämpfer',
		'role3' => 'Magier',
		'role4' => 'Kundschafter',
		
		// profilfelder
		
		'uc_gender'						=> 'Geschlecht',
		'uc_male'						=> 'Männlich',
		'uc_female'						=> 'Weiblich',
		'uc_guild'						=> 'Gilde',
		
		'pk_tab_fs_eq2settings'			=> 'EQ2 Einstellungen',
		'uc_faction'					=> 'Fraktion',
		'uc_faction_help'				=> 'Die Fraktion im Spiel',
		'uc_servername_help'			=> 'Servername des Spielservers',
		'uc_lockserver'					=> 'Servername unveränderbar machen',
		'uc_lockserver_help'			=> 'Der Servername für den Benutzer unveränderbar machen',
		'uc_update_all'					=> 'Alle Charactere aktualisieren',
		
		'uc_import_guild'				=> 'Gilde importieren',
		'uc_import_guild_help'			=> 'Importiere alle Mitglieder einer Gilde',
		
		'uc_class_filter'				=> 'Klasse',
		'uc_class_nofilter'				=> 'Nicht filtern',
		'uc_guild_name'					=> 'Gilden-Name',
		'uc_filter_name'				=> 'Filter',
		'uc_level_filter'				=> 'Level größer als',
		'uc_imp_noguildname'			=> 'Es wurde kein Gildenname angegeben',
		'uc_gimp_loading'				=> 'Gildenmitglieder werden geladen, bitte warten...',
		'uc_gimp_header_fnsh'			=> 'Der Import der Gildenmitglieder wurde beendet. Beim Gildenimport werden nur der Charktername, die Rasse, die Klasse und das Level importiert. Um die restlichen Daten zu importieren, einfach den Updater benutzen.',
		'uc_importcache_cleared'		=> 'Der Cache des Importers wurde erfolgreich geleert.',
		'uc_delete_chars_onimport'		=> 'Charaktere im System löschen, die nicht mehr in der Gilde sind',
		
		'uc_noprofile_found'			=> 'Kein Profil gefunden',
		'uc_profiles_complete'			=> 'Profile erfolgreich aktualisiert',
		'uc_notyetupdated'				=> 'Keine neuen Daten (Inaktiver Charakter)',
		'uc_notactive'					=> 'Das Mitglied ist im EQDKP auf inaktiv gesetzt und wird daher übersprungen',
		'uc_error_with_id'				=> 'Fehler mit der Character ID, Charakter übersprungen',
		'uc_notyourchar'				=> 'ACHTUNG: Du versuchst gerade einen Charakter hinzuzufügen, der bereits in der Datenbank vorhanden ist und dir nicht zugewiesen ist. Aus Sicherheitsgründen ist diese Aktion nicht gestattet. Bitte kontaktiere einen Administrator zum Lösen dieses Problems oder versuche einen anderen Charakternamen einzugeben.',
		'uc_lastupdate'					=> 'Letzte Aktualisierung',

		"uc_updat_armory" 				=> "Von SOE aktualisieren",
		'uc_prof_import'				=> 'importieren',
		'uc_import_forw'				=> 'Start',
		'uc_imp_succ'					=> 'Die Daten wurden erfolgreich importiert',
		'uc_upd_succ'					=> 'Die Daten wurden erfolgreich aktualisiert',
		'uc_imp_failed'					=> 'Beim Import der Daten trat ein Fehler auf. Bitte versuche es erneut.',
		'uc_charname'					=> 'Charaktername',
		'uc_servername'					=> 'Servername',
		'uc_charfound'					=> "Der Charakter  <b>%1\$s</b> wurde gefunden.",
		'uc_charfound2'					=> "Das letzte Update dieses Charakters war am <b>%1\$s</b>.",
		'uc_charfound3'					=> 'ACHTUNG: Beim Import werden bisher gespeicherte Daten überschrieben!',
		'uc_armory_imported'			=> 'Charakter erfolgreich importiert',
		'uc_armory_updated'				=> 'Charakter erfolgreich aktualisiert',
		'uc_armory_impfailed'			=> 'Charakter nicht importiert',
		'uc_armory_updfailed'			=> 'Charakter nicht aktualisiert',
		'uc_armory_impfail_reason'		=> 'Grund:',
		'uc_armory_impduplex'			=> 'Charakter ist bereits vorhanden',
		'uc_importer_cache'				=> 'Leere Cache des Importers',
		
		'no_data'						=> 'Zu diesem Char konnten keine Informationen abgerufen werden. Bitte überprüfe ob der richtige Server in den Einstellungen eingestellt ist.',
		
        //Events
        'event1' => 'Abominable Laboratory',
        'event2' => 'Betrayal of the Underdepths',
        'event3' => 'Chamber of Destiny',
        'event4' => 'Execution Throne Room',
        'event5' => 'Harrow&acute;s End',
        'event6' => 'Harrow&acute;s End (Heroisch)',
        'event7' => 'Icy Keep: Retribution',
        'event8' => 'Kraytoc&acute;s Fortress',
        'event9' => 'Kurn&acute;s Tower',
        'event10' => 'Lair of the Dragon Queen',
        'event11' => 'Miragul&acute;s Planar Shard',
        'event12' => 'Munzok&acute;s Material Bastion',
        'event13' => 'Palace of the Ancient One',
        'event14' => 'Plane of War',
        'event15' => 'Protectors Realm',
        'event16' => 'Roehn Theer',
        'event17' => 'Sevalak Awakened',
        'event18' => 'Shard of Hate',
        'event19' => 'Sleeper&acute;s Tomb',
        'event20' => 'Sleeper&acute;s Tomb (Heroisch)',
        'event21' => 'Sullon&acute;s Spire',
        'event22' => 'Sullon&acute;s Spire (Hardcore)',
        'event23' => 'Tallon&acute;s Stronghold',
        'event24' => 'Tallon&acute;s Stronghold (Hardcore)',
        'event25' => 'Temple of Kor-Sha',
        'event26' => 'Temple of Rallos Zek',
        'event27' => 'Temple of Rallos Zek (Hardcore)',
        'event28' => 'Temple of the Faceless',
        'event29' => 'Temple of the Faceless (Heroisch)',
        'event30' => 'Throne of Storms',
        'event31' => 'Throne of Storms (Hardcore)',
        'event32' => 'Tomb of the Mad Cursader',
        'event33' => 'Tomb of Thuuga',
        'event34' => 'Trakanon&acute;s Lair',
        'event35' => 'Underfoot Depths',
        'event36' => 'Vallon&acute;s Tower',
        'event37' => 'Vallon&acute;s Tower (Hardcore)',
        'event38' => 'Veeshan&acute;s Peak',
        'event39' => 'Venril Sathir&acute;s Lair',
        'event40' => 'Vyskudra the Ancient',
        'event41' => 'Ward of Elements',
        'event42' => 'Ykesha&acute;s Inner Stronghold',
        'event43' => 'Zarrakon&acute;s Abyssal Chamber',
        
	),
);
?>