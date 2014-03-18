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
		0	=> 'Unbekannt',
		1	=> 'Assassine',
		2	=> 'Berserker',
		3	=> 'Brigant',
		4	=> 'Raufbold',
		5	=> 'Erzwinger',
		6	=> 'Elementalist',
		7	=> 'Schänder',
		8	=> 'Klagesänger',
		9	=> 'Furie',
		10	=> 'Wächter',
		11	=> 'Thaumaturgist',
		12	=> 'Inquisitor',
		13 => 'Mönch',
		14 => 'Mystiker',
		15 => 'Nekromant',
		16 => 'Paladin',
		17	=> 'Waldläufer',
		18 => 'Schattenritter',
		19 => 'Säbelrassler',
		20 => 'Templer',
		21	=> 'Troubadour',
		22	=> 'Wärter',
		23	=> 'Hexenmeister',
		24	=> 'Zauberer',
		25	=> 'Bestienfürst',
		26	=> 'Bündler',
	),
	'races' => array(
		0	=> 'Unbekannt',
		1	=> 'Sarnak',
		2	=> 'Gnom',
		3	=> 'Mensch',
		4	=> 'Barbar',
		5	=> 'Zwerg',
		6	=> 'Hochelf',
		7	=> 'Dunkelelf',
		8	=> 'Waldelf',
		9	=> 'Halbelf',
		10	=> 'Kerraner',
		11	=> 'Troll',
		12	=> 'Oger',
		13	=> 'Froschlok',
		14	=> 'Erudit',
		15	=> 'Iksar',
		16	=> 'Rattonga',
		17	=> 'Halbling',
		18	=> 'Arasai',
		19	=> 'Fee',
		20	=> 'Freiblüter'
	),
	'factions' => array(
		'good'		=> 'Gut',
		'evil'		=> 'Böse',
		'neutral'	=> 'Neutral'
	),
	'roles' => array(
		1 => 'Heiler',
		2 => 'Kämpfer',
		3 => 'Magier',
		4 => 'Kundschafter',
	),
	'realmlist' => array(
		'Valor', //EU Deutsch
		'Splitpaw', //EU English
		'Storms',	//EU Francais
		'Sebilis', //China
		'Test', //Public Test Server
		'Beta', //Public Beta Server
		//US English
		'Butcherblock',
		'Nagafen',
		'Guk',
		'Freeport',
		'Everfrost',
		'Unrest',
		'Oasis',
		'Antonia Bayle',
		'Permafrost',
		'Crushbone',
		//Russia
		'Harla Dar',
		'Barren Sky',
	),
	'lang' => array(
		'eq2'								=> 'EverQuest II',
		'very_light'						=> 'Stoff',
		'light'								=> 'Leder',
		'medium'							=> 'Kette',
		'heavy'								=> 'Platte',
		'healer'							=> 'Heiler',
		'fighter'							=> 'Kämpfer',
		'mage'								=> 'Magier',
		'scout'								=> 'Kundschafter',
		
		// profile additions
		'uc_gender'							=> 'Geschlecht',
		'uc_male'							=> 'Männlich',
		'uc_female'							=> 'Weiblich',
		'uc_guild'							=> 'Gilde',
		'pk_tab_fs_eq2settings'				=> 'EQ2 Einstellungen',
		'uc_import_guild'					=> 'Gilde importieren',
		'uc_import_guild_help'				=> 'Importiere alle Mitglieder einer Gilde',
		'uc_servername'						=> 'Servername',
		'uc_lockserver'						=> 'Servername unveränderbar machen',
		'uc_faction'						=> 'Fraktion',
		'uc_update_all'						=> 'Alle Charactere aktualisieren',
		'uc_importer_cache'					=> 'Leere Cache des Importers',
		'uc_importer_cache_help'			=> 'Löscht alle gecachten Daten des Importers.',
		'achievements'						=> 'Erfolge',
		'uc_class_filter'					=> 'Klasse',
		'uc_class_nofilter'					=> 'Nicht filtern',
		'uc_guild_name'						=> 'Gilden-Name',
		'uc_filter_name'					=> 'Filter',
		'uc_level_filter'					=> 'Level größer als',
		'uc_imp_novariables'				=> 'Du musst in den Einstellungen erst einen Realmserver und dessen Standort einstellen.',
		'uc_imp_noguildname'				=> 'Es wurde kein Gildenname angegeben',
		'uc_gimp_loading'					=> 'Gildenmitglieder werden geladen, bitte warten...',
		'uc_gimp_header_fnsh'				=> 'Guild import finished',
		'uc_importcache_cleared'			=> 'Der Cache des Importers wurde erfolgreich geleert.',
		'uc_delete_chars_onimport'			=> 'Charaktere im System löschen, die nicht mehr in der Gilde sind',
		'uc_achievements'					=> 'Erfolge',
		'uc_critchance'						=> 'Minimale Crit-Chance Vorraussetzung',
		'gachievements'						=> 'Gildenerfolge',
		'graidready'						=> 'Raid Ready',
		'heraldry'							=> 'Gildenwappen',
		'uc_noprofile_found'				=> 'Kein Profil gefunden',
		'uc_profiles_complete'				=> 'Profile erfolgreich aktualisiert',
		'uc_notyetupdated'					=> 'Keine neuen Daten (Inaktiver Charakter)',
		'uc_notactive'						=> 'Das Mitglied ist im EQDKP auf inaktiv gesetzt und wird daher übersprungen',
		'uc_error_with_id'					=> 'Fehler mit der Character ID, Charakter übersprungen',
		'uc_notyourchar'					=> 'ACHTUNG: Du versuchst gerade einen Charakter hinzuzufügen, der bereits in der Datenbank vorhanden ist und dir nicht zugewiesen ist. Aus Sicherheitsgründen ist diese Aktion nicht gestattet. Bitte kontaktiere einen Administrator zum Lösen dieses Problems oder versuche einen anderen Charakternamen einzugeben.',
		'uc_lastupdate'						=> 'Letzte Aktualisierung',
		'uc_lastupdate'						=> 'Last Update',
		'uc_prof_import'					=> 'importieren',
		'uc_import_forw'					=> 'Start',
		'uc_imp_succ'						=> 'Die Daten wurden erfolgreich importiert',
		'uc_upd_succ'						=> 'Die Daten wurden erfolgreich aktualisiert',
		'uc_imp_failed'						=> 'Beim Import der Daten trat ein Fehler auf. Bitte versuche es erneut.',
		"uc_updat_armory" 					=> "Von SOE aktualisieren",
		'uc_charname'						=> 'Charaktername',
		'uc_servername'						=> 'Server\'s name',
		'uc_charfound'						=> "Der Charakter  <b>%1\$s</b> wurde gefunden.",
		'uc_charfound2'						=> "Das letzte Update dieses Charakters war am <b>%1\$s</b>.",
		'uc_charfound3'						=> 'ACHTUNG: Beim Import werden bisher gespeicherte Daten überschrieben!',
		'uc_armory_confail'					=> 'Keine Verbindung zur Armory möglich.',
		'uc_armory_imported'				=> 'Charakter erfolgreich importiert',
		'uc_armory_impfailed'				=> 'Charakter nicht importiert',
		'uc_armory_impduplex'				=> 'Charakter ist bereits vorhanden',
		'eqclassic'							=> 'The Shattered Lands',
		'splitpaw'							=> 'The Splitpaw Saga',
		'desert'							=> 'Desert of Flames',
		'kingdom'							=> 'Kingdom of Sky',
		'fallen'							=> 'The Fallen Dynasty',
		'faydwer'							=> 'Echoes of Faydwer',
		'kunark'							=> 'Rise of Kunark',
		'shadow'							=> 'The Shadow Odyssey',
		'sentinel'							=> 'Sentinel\'s of Fate',
		'velious'							=> 'Destiny of Velious',
		'chains'							=> 'Chains of Eternity',
		'tears'								=> 'Tears of Veeshan',
		'avatar'							=> 'Avatars',
		'healermage'						=> 'Healer & Mage',
		'fighterscout'						=> 'Fighter & Scout',
		'no_data'							=> 'Zu diesem Char konnten keine Informationen abgerufen werden. Bitte überprüfe ob der richtige Server in den Einstellungen eingestellt ist.',
		'total_completed'					=> 'Abgeschlossen',
		'uc_showachieve'					=> 'Erfolge anzeigen',
	),
);
?>