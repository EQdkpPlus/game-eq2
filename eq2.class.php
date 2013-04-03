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
		public static $shortcuts = array('pdh');
		protected $this_game	= 'eq2';
		protected $types		= array('classes', 'races', 'factions', 'roles', 'filters');
		public $icons			= array('classes', 'classes_big', 'races', 'events', 'roles', 'ranks');
		protected $classes		= array();
		protected $races		= array();
		protected $factions		= array();
		protected $filters		= array();
		public $langs			= array('english', 'german');
		public $objects			= array('eq2_soe');
		public $no_reg_obj		= array('eq2_soe');	

		protected $glang		= array();
		protected $lang_file	= array();
		protected $path			= '';
		public $lang			= false;
		public $version			= '2.2.3';
		
		public $importers 		= array(
			'char_import'		=> 'charimporter.php',						// filename of the character import
			'char_update'		=> 'charimporter.php',						// filename of the character update, member_id (POST) is passed
			'char_mupdate'		=> 'charimporter.php?massupdate=true',		// filename of the "update all characters" aka mass update
			'guild_import'		=> 'guildimporter.php',						// filename of the guild import
			'import_reseturl'	=> 'charimporter.php?resetcache=true',		// filename of the reset cache
			'guild_imp_rsn'		=> true,
			'import_data_cache'	=> true,									// Is the data cached and requires a reset call?
		);

		public function __construct(){
			parent::__construct();
			$this->pdh->register_read_module($this->this_game, $this->path . 'pdh/read/'.$this->this_game);
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
					array('name' => $this->glang('light', true, $lang), 'value' => 'class:4,9,13,22'),
					array('name' => $this->glang('medium', true, $lang), 'value' => 'class:1,3,7,8,14,17,21,25'),
					array('name' => $this->glang('heavy', true, $lang), 'value' => 'class:2,10,12,16,18,20'),
					array('name' => '-----------', 'value' => false),
					array('name' => $this->glang('healer', true, $lang), 'value' => 'class:7,9,12,14,20,22'),
					array('name' => $this->glang('fighter', true, $lang), 'value' => 'class:2,4,10,13,16,18'),
					array('name' => $this->glang('mage', true, $lang), 'value' => 'class:5,6,11,15,23,24'),
					array('name' => $this->glang('scout', true, $lang), 'value' => 'class:1,25,3,8,17,19,21'),					
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
			//classcolors
			$info['class_color'] = array(
				0 => '#E1E1E1',
				1 => '#E1E100',
				2 => '#E10000',
				3 => '#E1E100',
				4 => '#E10000',
				5 => '#0000E1',
				6 => '#0000E1',
				7 => '#00E100',
				8 => '#E1E100',
				9 => '#00E100',
				10 => '#E10000',
				11 => '#0000E1',
				12 => '#00E100',
				13 => '#E10000',
				14 => '#00E100',
				15 => '#0000E1',
				16 => '#E10000',
				17 => '#E1E100',
				18 => '#E10000',
				19 => '#E1E100',
				20 => '#00E100',
				21 => '#E1E100',
				22 => '#00E100',
				23 => '#0000E1',
				24 => '#0000E1',
				25 => '#E1E100',
			);
            
            //lets do some tweak on the templates dependent on the game
            $info['aq'] = array();
            
            //Do this SQL Query NOT if the Eqdkp is installed -> only @ the first install
            //if($install){            
            
            // Events
            
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (50, "'.$this->glang('event1').'", 0.00, "default", NULL, "abominable_laboratory.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (51, "'.$this->glang('event2').'", 0.00, "default", NULL, "betrayal_of_the_underdepths.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (52, "'.$this->glang('event3').'", 0.00, "default", NULL, "chamber_of_destiny.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (53, "'.$this->glang('event4').'", 0.00, "default", NULL, "execution_throne_room.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (54, "'.$this->glang('event5').'", 0.00, "default", NULL, "harrows_end.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (55, "'.$this->glang('event6').'", 0.00, "default", NULL, "harrows_end.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (56, "'.$this->glang('event7').'", 0.00, "default", NULL, "icy_keep_retribution.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (57, "'.$this->glang('event8').'", 0.00, "default", NULL, "kraytocs_fortress.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (58, "'.$this->glang('event9').'", 0.00, "default", NULL, "kurns_tower.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (59, "'.$this->glang('event10').'", 0.00, "default", NULL, "lair_of_the_dragon_queen.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (60, "'.$this->glang('event11').'", 0.00, "default", NULL, "miraguls_planar_shard.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (61, "'.$this->glang('event12').'", 0.00, "default", NULL, "munzoks_material_bastion.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (62, "'.$this->glang('event13').'", 0.00, "default", NULL, "palace_of_the_ancient_one.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (63, "'.$this->glang('event14').'", 0.00, "default", NULL, "plane_of_war.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (64, "'.$this->glang('event15').'", 0.00, "default", NULL, "protectors_realm.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (65, "'.$this->glang('event16').'", 0.00, "default", NULL, "roehn_theer.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (66, "'.$this->glang('event17').'", 0.00, "default", NULL, "sevalak_awakened.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (67, "'.$this->glang('event18').'", 0.00, "default", NULL, "shard_of_hate.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (68, "'.$this->glang('event19').'", 0.00, "default", NULL, "sleepers_tomb.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (69, "'.$this->glang('event20').'", 0.00, "default", NULL, "sleepers_tomb.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (70, "'.$this->glang('event21').'", 0.00, "default", NULL, "sullons_spire.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (71, "'.$this->glang('event22').'", 0.00, "default", NULL, "sullons_spire.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (72, "'.$this->glang('event23').'", 0.00, "default", NULL, "tallons_stronghold.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (73, "'.$this->glang('event24').'", 0.00, "default", NULL, "tallons_stronghold.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (74, "'.$this->glang('event25').'", 0.00, "default", NULL, "temple_of_kor-sha.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (75, "'.$this->glang('event26').'", 0.00, "default", NULL, "temple_of_rallos_zek.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (76, "'.$this->glang('event27').'", 0.00, "default", NULL, "temple_of_rallos_zek.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (77, "'.$this->glang('event28').'", 0.00, "default", NULL, "temple_of_the_faceless.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (78, "'.$this->glang('event29').'", 0.00, "default", NULL, "temple_of_the_faceless.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (79, "'.$this->glang('event30').'", 0.00, "default", NULL, "throne_of_storms.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (80, "'.$this->glang('event31').'", 0.00, "default", NULL, "throne_of_storms.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (81, "'.$this->glang('event32').'", 0.00, "default", NULL, "tomb_of_the_mad_cursader.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (82, "'.$this->glang('event33').'", 0.00, "default", NULL, "tomb_of_thuuga.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (83, "'.$this->glang('event34').'", 0.00, "default", NULL, "trakanons_lair.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (84, "'.$this->glang('event35').'", 0.00, "default", NULL, "underfoot_depths.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (85, "'.$this->glang('event36').'", 0.00, "default", NULL, "vallons_tower.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (86, "'.$this->glang('event37').'", 0.00, "default", NULL, "vallons_tower.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (87, "'.$this->glang('event38').'", 0.00, "default", NULL, "veeshans_peak.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (88, "'.$this->glang('event39').'", 0.00, "default", NULL, "venril_sathirs_lair.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (89, "'.$this->glang('event40').'", 0.00, "default", NULL, "vyskudra_the_ancient.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (90, "'.$this->glang('event41').'", 0.00, "default", NULL, "ward_of_elements.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (91, "'.$this->glang('event42').'", 0.00, "default", NULL, "ykeshas_inner_stronghold.png"); ');
            array_push($info['aq'], 'INSERT INTO __events (event_id, event_name, event_value, event_added_by, event_updated_by, event_icon) VALUES (92, "'.$this->glang('event43').'", 0.00, "default", NULL, "zarrakons_abyssal_chamber.png"); ');
            
            //Connect them to the Default-Multidkp-Pool
            
            array_push($info['aq'], 'INSERT INTO __multidkp (multidkp_id, multidkp_name, multidkp_desc) VALUES (2, "default", "Default-Pool");');
            array_push($info['aq'], 'INSERT INTO __multidkp2event (multidkp2event_multi_id, multidkp2event_event_id) VALUES (1,50), (1,51), (1,52), (1,53), (1,54), (1,55), (1,56), (1,57), (1,58), (1,59), (1,60), (1,61), (1,62), (1,63), (1,64), (1,65), (1,66), (1,67), (1,68), (1,69), (1,70), (1,71), (1,72), (1,73), (1,74), (1,75), (1,76), (1,77), (1,78), (1,79), (1,80), (1,81), (1,82), (1,83), (1,84), (1,85), (1,86), (1,87), (1,88), (1,89), (1,90), (1,91), (1,92);');
            array_push($info['aq'], 'INSERT INTO __itempool (itempool_id, itempool_name, itempool_desc) VALUES (2, "default", "Default itempool");');
            array_push($info['aq'], 'INSERT INTO __multidkp2itempool (multidkp2itempool_itempool_id, multidkp2itempool_multi_id) VALUES (2, 2);');

            //}
            
            return $info;
        }
    }
}
if(version_compare(PHP_VERSION, '5.3.0', '<')) registry::add_const('short_eq2', eq2::$shortcuts);
?>