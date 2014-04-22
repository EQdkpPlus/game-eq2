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

if(!class_exists('eq2')) {
	class eq2 extends game_generic {
		public $version			= '2.3.0';
		protected $this_game	= 'eq2';
		protected $types		= array('classes', 'races', 'factions', 'roles', 'filters', 'realmlist');
		protected $classes		= array();
		protected $races		= array();
		protected $factions		= array();
		protected $filters		= array();
		public $langs			= array('english', 'german');
		public $objects			= array('eq2_soe');
		public $no_reg_obj		= array('eq2_soe');	

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
						1 	=> 'all',		// Sarnak
						2 	=> 'all',		// Gnome
						3 	=> 'all',		// Human
						4 	=> 'all',		// Barbarian
						5 	=> 'all',		// Dwarf
						6 	=> 'all',		// High Elf
						7 	=> 'all',		// Dark Elf
						8 	=> 'all',		// Wood Elf
						9 	=> 'all',		// Half Elf
						10 	=> 'all',		// Kerran
						11 	=> 'all',		// Troll
						12 	=> 'all',		// Ogre
						13 	=> 'all',		// Froglok
						14 	=> 'all',		// Erudite
						15 	=> 'all',		// Iksar
						16 	=> 'all',		// Ratonga
						17 	=> 'all',		// Halfling
						18 	=> 'all',		// Arasai
						19 	=> 'all',		// Fae
						20 	=> 'all',		// Freeblood
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
			5	=> '#0000E1',
			6	=> '#0000E1',
			7	=> '#00E100',
			8	=> '#E1E100',
			9	=> '#00E100',
			10	=> '#E10000',
			11	=> '#0000E1',
			12	=> '#00E100',
			13	=> '#E10000',
			14	=> '#00E100',
			15	=> '#0000E1',
			16	=> '#E10000',
			17	=> '#E1E100',
			18	=> '#E10000',
			19	=> '#E1E100',
			20	=> '#00E100',
			21	=> '#E1E100',
			22	=> '#00E100',
			23	=> '#0000E1',
			24	=> '#0000E1',
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
					'size'			=> 40,
					'undeletable'	=> true
				),
			);
			return $xml_fields;
		}

		public function admin_settings() {
			$settingsdata_admin = array(
				'game' => array(
					'eq2settings' => array(
						'uc_faction'	=> array(
							'lang'		=> 'uc_faction',
							'fieldtype'	=> 'dropdown',
							'size'		=> '1',
							'options'	=> $this->game->get('factions'),
							'default'	=> 'alliance'
						),
						'uc_servername' => array(
							'lang'		=> 'uc_servername',
							'fieldtype'	=> 'autocomplete',
							'size'		=> '21',
							'edecode'	=> true,
							'options'	=> $this->game->get('realmlist'),
						),
						'uc_lockserver'	=> array(
							'lang'		=> 'uc_lockserver',
							'fieldtype'	=> 'checkbox',
							'size'		=> false,
							'options'	=> false,
						),
						'uc_critchance'	=> array(
							'lang'		=> 'uc_critchance',
							'fieldtype'	=> 'text',
							'size'		=> '4',
							'options'	=> false,
						),
						'uc_showachieve'	=> array(
							'lang'		=> 'uc_showachieve',
							'fieldtype'	=> 'dropdown',
							'size'		=> '1',
							'options'	=> array('yes' => 'Yes', 'no' => 'No'),
							'default'   => 'yes',
						)
					)
				)
			);
			return $settingsdata_admin;
		}

		/**
		* Initialises filters
		*
		* @param array $langs
		*/
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
					array('name' => $this->glang('very_light', true, $lang), 'value' => 'class:5,6,11,15,23,24'),
					array('name' => $this->glang('light', true, $lang), 'value' => 'class:26,4,9,13,22'),
					array('name' => $this->glang('medium', true, $lang), 'value' => 'class:1,3,7,8,14,17,21,25'),
					array('name' => $this->glang('heavy', true, $lang), 'value' => 'class:2,10,12,16,18,20'),
					array('name' => '-----------', 'value' => false),
					array('name' => $this->glang('healer', true, $lang), 'value' => 'class:26,7,9,12,14,20,22'),
					array('name' => $this->glang('fighter', true, $lang), 'value' => 'class:2,4,10,13,16,18'),
					array('name' => $this->glang('mage', true, $lang), 'value' => 'class:5,6,11,15,23,24'),
					array('name' => $this->glang('scout', true, $lang), 'value' => 'class:1,25,3,8,17,19,21'),
					array('name' => '-----------', 'value' => false),
					array('name' => $this->glang('healermage', true, $lang), 'value' => 'class:26,7,9,12,14,20,22,5,6,11,15,23,24'),
					array('name' => $this->glang('fighterscout', true, $lang), 'value' => 'class:2,4,10,13,16,18,1,25,3,8,17,19,21'),
					
				));
			}
		}

		/**
		* Returns Information to change the game
		*
		* @param bool $install
		* @return array
		*/
		public function get_OnChangeInfos($install=false){
		}
	}
}
?>