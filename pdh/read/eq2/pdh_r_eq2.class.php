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

if (!defined('EQDKP_INC')){
	die('Do not access this file directly.');
}

/*+----------------------------------------------------------------------------
  | pdh_r_eq2
  +--------------------------------------------------------------------------*/
if (!class_exists('pdh_r_eq2')) {
	class pdh_r_eq2 extends pdh_r_generic {
		public static $shortcuts = array('core', 'game', 'pdh', 'config');

		/**
		* Hook array
		*/
		public $hooks = array(
			'member_update',
		);

		/**
		* Presets array
		*/
		public $presets = array(
			'eq2_charicon'			=> array('charicon', array('%member_id%'), array()),
		);

		/**
		* Constructor
		*/
		public function __construct(){
		}
	
		public function reset(){
		}

		/**
		* init
		*
		* @returns boolean
		*/
		public function init(){
			$this->game->new_object('eq2_soe', 'soe', array());
			return true;
		}

		public function get_charicon($member_id){
			$picture_id = $this->pdh->get('member', 'picture', array($member_id));
			if ($picture_id){
				$charicon = $this->game->obj['soe']->characterIcon($picture_id);
				$charicon = str_replace($this->root_path, $this->server_path, $charicon);
				return $charicon;
			}
			return '';
		}

		public function get_html_charicon($member_id){
			$charicon = $this->get_charicon($member_id);
			if ($charicon == '') {
				$charicon = $this->server_path.'images/global/avatar-default.svg';
			}
			return '<img src="'.$charicon.'" alt="Char-Icon" height="48" class="gameicon" />';
		}
	} //end class
} //end if class not exists
if(version_compare(PHP_VERSION, '5.3.0', '<')) registry::add_const('short_pdh_r_eq2', pdh_r_eq2::$shortcuts);
?>