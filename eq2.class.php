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

if(!class_exists('eq2')) {
	class eq2 extends game_generic {
		protected static $apiLevel	= 20;
		public $version				= '2.3.3';
		protected $this_game		= 'eq2';
		protected $types			= array('classes', 'races', 'factions', 'roles', 'filters', 'realmlist');
		protected $classes			= array();
		protected $races			= array();
		protected $factions			= array();
		protected $filters			= array();
		public $langs				= array('english', 'german');
		public $objects				= array('eq2_soe');
		public $no_reg_obj			= array('eq2_soe');	

		protected $class_dependencies = array(
			array(
				'name'		=> 'faction',
				'type'		=> 'factions',
				'admin' 	=> true,
				'decorate'	=> false,
				'parent'	=> false,
			),
			array(
				'name'		=> 'race',
				'type'		=> 'races',
				'admin'		=> false,
				'decorate'	=> true,
				'parent'	=> array(
					'faction' => array(
						'good'		=> 'all',
						'evil'		=> 'all',
						'neutral'	=> 'all',
					),
				),
			),
			array(
				'name'		=> 'class',
				'type'		=> 'classes',
				'admin'		=> false,
				'decorate'	=> true,
				'primary'	=> true,
				'colorize'	=> true,
				'roster'	=> true,
				'recruitment' => true,
				'parent'	=> array(
					'race' => array(
						0 	=> 'all',		// Unknown
						21  => 'all',       // Aerakyn
						18 	=> 'all',		// Arasai
						4 	=> 'all',		// Barbarian
						7 	=> 'all',		// Dark Elf
						5 	=> 'all',		// Dwarf
						14 	=> 'all',		// Erudite
						19 	=> 'all',		// Fae
						20 	=> 'all',		// Freeblood
						13 	=> 'all',		// Froglok
						2 	=> 'all',		// Gnome
						9 	=> 'all',		// Half Elf
						17 	=> 'all',		// Halfling
						6 	=> 'all',		// High Elf
						3 	=> 'all',		// Human
						15 	=> 'all',		// Iksar
						10 	=> 'all',		// Kerran
						12 	=> 'all',		// Ogre
						16 	=> 'all',		// Ratonga
						1 	=> 'all',		// Sarnak
						11 	=> 'all',		// Troll
						8 	=> 'all',		// Wood Elf
						),
				),
			),
		);

		public $default_roles = array(
			1	=> array(26, 7, 9, 12, 14, 20, 22),
			2	=> array(2, 4, 10, 13, 16, 18),
			3	=> array(5, 6, 11, 15, 23, 24),
			4	=> array(1, 25, 3, 8, 17, 19, 21)
		);

		protected $class_colors = array(
			0	=> '#E1E1E1',
			1	=> '#E1E100',
			2	=> '#E10000',
			3	=> '#E1E100',
			4	=> '#E10000',
			5	=> '#0065E1',
			6	=> '#0065E1',
			7	=> '#00E100',
			8	=> '#E1E100',
			9	=> '#00E100',
			10	=> '#E10000',
			11	=> '#0065E1',
			12	=> '#00E100',
			13	=> '#E10000',
			14	=> '#00E100',
			15	=> '#0065E1',
			16	=> '#E10000',
			17	=> '#E1E100',
			18	=> '#E10000',
			19	=> '#E1E100',
			20	=> '#00E100',
			21	=> '#E1E100',
			22	=> '#00E100',
			23	=> '#0065E1',
			24	=> '#0065E1',
			25	=> '#E1E100',
			26	=> '#00E100',
		);

		protected $glang		= array();
		protected $lang_file	= array();
		protected $path			= '';
		public $lang			= false;

		public function __construct() {
			$this->importers = array(
				'char_import'		=> 'charimporter.php',						// filename of the character import
				'char_update'		=> 'charimporter.php',						// filename of the character update, member_id (POST) is passed
				'char_mupdate'		=> 'charimporter.php'.$this->SID.'&massupdate=true',		// filename of the "update all characters" aka mass update
				'guild_import'		=> 'guildimporter.php',						// filename of the guild import
				'import_reseturl'	=> 'charimporter.php'.$this->SID.'&resetcache=true',		// filename of the reset cache
				'guild_imp_rsn'		=> true,
				'import_data_cache'	=> true,									// Is the data cached and requires a reset call?
			);

			parent::__construct();
			$this->pdh->register_read_module($this->this_game, $this->path . 'pdh/read/'.$this->this_game);
		}

		public function profilefields(){
			$this->load_type('realmlist', array($this->lang));
			$xml_fields = array(
				'gender'	=> array(
					'type'			=> 'dropdown',
					'category'		=> 'character',
					'lang'			=> 'uc_gender',
					'options'		=> array('Male' => 'uc_male', 'Female' => 'uc_female'),
					'undeletable'	=> true,
					'tolang'		=> true
				),
				'guild'	=> array(
					'type'			=> 'text',
					'category'		=> 'character',
					'lang'			=> 'uc_guild',
					'size'			=> 32,
					'undeletable'	=> true
				),
				'servername'	=> array(
						'category'		=> 'character',
						'lang'			=> 'servername',
						'type'			=> 'text',
						'size'			=> '21',
						'edecode'		=> true,
						'autocomplete'	=> $this->realmlist[$this->lang],
						'undeletable'	=> true,
						'sort'			=> 2
				),
				'level'	=> array(
						'type'			=> 'spinner',
						'category'		=> 'character',
						'lang'			=> 'uc_level',
						'max'			=> 100,
						'min'			=> 1,
						'undeletable'	=> true,
						'sort'			=> 4
				),
			);
			return $xml_fields;
		}

		public function admin_settings() {
			$settingsdata_admin = array(
				'servername' => array(
					'lang'			=> 'servername',
					'type'			=> 'text',
					'size'			=> '21',
					'edecode'		=> true,
					'autocomplete'	=> $this->game->get('realmlist'),
				),
				'uc_lockserver'	=> array(
					'lang'			=> 'uc_lockserver',
					'type'			=> 'radio',
					'size'			=> false,
					'options'		=> false,
				),
				'uc_resists'	=> array(
					'name'		=> 'uc_resists',
					'type'		=> 'text',
					'size'		=> '10',
					'options'	=> false,
				),
				'uc_showachieve'	=> array(
					'lang'			=> 'uc_showachieve',
					'type'			=> 'dropdown',
					'size'			=> '1',
					'options'		=> array('yes' => 'Yes', 'no' => 'No'),
					'default'		=> 'yes',
				)
			);
			return $settingsdata_admin;
		}

		protected function load_filters($langs){
			if(!$this->classes) {
				$this->load_type('classes', $langs);
			}
			foreach($langs as $lang) {
				$this->filters[$lang][] = array('name' => '-----------', 'value' => false);
				foreach($this->classes[$this->lang] as $id => $name) {
					$this->filters[$lang][] = array('name' => $name, 'value' => 'class:'.$id);
				}
				$this->filters[$lang] = array_merge($this->filters[$lang], array(
					array('name' => '-----------', 'value' => false),
					array('name' => $this->glang('healer', true, $lang), 'value' => 'class:26,7,9,12,14,20,22'),
					array('name' => $this->glang('fighter', true, $lang), 'value' => 'class:2,4,10,13,16,18'),
					array('name' => $this->glang('mage', true, $lang), 'value' => 'class:5,6,11,15,23,24'),
					array('name' => $this->glang('scout', true, $lang), 'value' => 'class:1,25,3,8,17,19,21'),
					
				));
			}
		}

		public function install($install=false){}
	}
}
?>
