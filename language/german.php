<?php
/*	Project:	EQdkp-Plus
 *	Package:	Everquest2 game package
 *	Link:		http://eqdkp-plus.eu
 *
 *	Copyright (C) 2006-2015 EQdkp-Plus Developer Team
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU Affero General Public License as published
 *	by the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU Affero General Public License for more details.
 *
 *	You should have received a copy of the GNU Affero General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}
$german_array = array(
	'classes' => array(
		0	=> 'Unbekannt',
		1	=> 'Assassine',
		2	=> 'Berserker',
		25	=> 'Bestienfürst',
		3	=> 'Brigant',
		26	=> 'Bündler',
		6	=> 'Elementalist',
		5	=> 'Erzwinger',
		9	=> 'Furie',
		23	=> 'Hexenmeister',
		12	=> 'Inquisitor',
		8	=> 'Klagesänger',
		13  => 'Mönch',
		14  => 'Mystiker',
		15  => 'Nekromant',
		16  => 'Paladin',
		4	=> 'Raufbold',
		19  => 'Säbelrassler',
		7 	=> 'Schänder',
		18  => 'Schattenritter',
		20  => 'Templer',
		11	=> 'Thaumaturgist',
		21	=> 'Troubadour',
		10	=> 'Wächter',
		17	=> 'Waldläufer',
		22	=> 'Wärter',
		24	=> 'Zauberer',
	),
	'races' => array(
		0	=> 'Unbekannt',
		21  => 'Aerakyn',
		18	=> 'Arasai',
		4	=> 'Barbar',
		7	=> 'Dunkelelf',
		14	=> 'Erudit',
		19	=> 'Fee',		
		20	=> 'Freiblüter',
		13	=> 'Froschlok',
		2	=> 'Gnom',
		9	=> 'Halbelf',
		17	=> 'Halbling',
		6	=> 'Hochelf',
		15	=> 'Iksar',
		10	=> 'Kerraner',
		3	=> 'Mensch',
		12	=> 'Oger',
		16	=> 'Rattonga',
		1	=> 'Sarnak',
		11	=> 'Troll',
		8	=> 'Waldelf',
		5	=> 'Zwerg',
	),
	'factions' => array(
		'good'		=> 'Gut',
		'evil'		=> 'Böse',
		'neutral'	=> 'Neutral'
	),
	'roles' => array(
		1 => 'Priester',
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
		'uc_race'							=> 'Rasse',
		'uc_class'							=> 'Klasse',
		'uc_import_guild'					=> 'Gilde importieren',
		'uc_import_guild_help'				=> 'Importiere alle Mitglieder einer Gilde',
		'servername'						=> 'Servername',
		'uc_lockserver'						=> 'Servername unveränderbar machen',
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
		'core_sett_f_uc_resists'   		 	=> 'Minimale Resists',
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
		"uc_updat_armory" 					=> "Von Daybreak aktualisieren",
		'uc_charname'						=> 'Charaktername',
		'uc_charfound'						=> "Der Charakter  <b>%1\$s</b> wurde gefunden.",
		'uc_charfound2'						=> "Das letzte Update dieses Charakters war am <b>%1\$s</b>.",
		'uc_charfound3'						=> 'ACHTUNG: Beim Import werden bisher gespeicherte Daten überschrieben!',
		'uc_armory_confail'					=> 'Keine Verbindung zur Armory möglich.',
		'uc_armory_imported'				=> 'Charakter erfolgreich importiert',
		'uc_armory_impfailed'				=> 'Charakter nicht importiert',
		'uc_armory_impduplex'				=> 'Charakter ist bereits vorhanden',
		'eqclassic'							=> 'Zerschmetterte Lande',
		'splitpaw'							=> 'The Splitpaw Saga',
		'desert'							=> 'Wüste der Flammen',
		'kingdom'							=> 'Kingdom of Sky',
		'fallen'							=> 'The Fallen Dynasty',
		'faydwer'							=> 'Echoes of Faydwer',
		'kunark'							=> 'Rise of Kunark',
		'shadow'							=> 'The Shadow Odyssey',
		'sentinel'							=> 'Sentinel\'s of Fate',
		'velious'							=> 'Destiny of Velious',
		'chains'							=> 'Chains of Eternity',
		'tears'								=> 'Tränen von Veeshan',
		'malice'                  	        => 'Altar der Bosheit',
		'general'                           => 'General',
		'avatar'							=> 'Avatars',
		'rum'							=> 'F.S. Distillery',
		'healermage'						=> 'Healer & Mage',
		'fighterscout'						=> 'Fighter & Scout',
		'uc_level'                          => 'Level',
		'no_data'							=> 'Zu diesem Char konnten keine Informationen abgerufen werden. Bitte überprüfe ob der richtige Server in den Einstellungen eingestellt ist.',
		'total_completed'					=> 'Abgeschlossen',
		'uc_showachieve'					=> 'Erfolge anzeigen',

		// Admin Settings
		'core_sett_fs_gamesettings'		=> 'EverQuest II Einstellungen',
		'uc_faction'					=> 'Fraktion',
		'uc_faction_help'				=> 'Wähle die Standard-Fraktion',
	),
);
?>
