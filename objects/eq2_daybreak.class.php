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

class eq2_daybreak {

	protected $apiurl		= 'https://census.daybreakgames.com/s:eqdkpplus/json/get/eq2/';
	public $imgurl			= 'https://census.daybreakgames.com/s:eqdkpplus/img/eq2/';
	private $chariconUpdates = 0;
	private $chardataUpdates = 0;
	
	protected $convert		= array(
		'classes' => array(
			40 => 1,//Assassin
			42 => 25,//Beastlord
			4 => 2,//Berserker
			34 => 3,//Brigand
			7 => 4,//Bruiser
			44 => 26,//Channeler
			27 => 5,//Coercer
			29 => 6,//Conjuror
			20 => 7,//Defiler
			37 => 8,//Dirge
			17 => 9,//Fury
			3 => 10,//Guardian
			26 => 11,//Illusionist
			14 => 12,//Inquisitor
			6 => 13,//Monk
			19 => 14,//Mystic
			30 => 15,//Necromancer
			10 => 16,//Paladin
			39 => 17,//Ranger
			9 => 18,//Shadowknight
			33 => 19,//Swashbuckler
			13 => 20,//Templar
			36 => 21,//Troubador
			16 => 22,//Warden
			24 => 23,//Warlock
			23 => 24,//Wizard
		),
		'races' => array(
			20 => 21, // Aerakyn
			17 => 18, //Arasai
			0 => 4, //Barbarian
			1 => 7, //Dark Elf
			2 => 5, //Dwarf
			3 => 14, //Erudite
			16 => 19, //Fae
			19 => 20, //Freeblood
			4 => 13, //Froglok
			5 => 2, //Gnome
			6 => 9, //Half Elf
			7 => 17, //Halfling			
			9 => 3, //Human
			8 => 6, //High Elf
			10 => 15, //Iksar
			11 => 10, //Kerran
			12 => 12, //Ogre
			13 => 16, //Ratonga			
			18 => 1, //Sarnak
			14 => 11, //Troll						
			15 => 8, //Wood Elf
		),
	);
	
	private $converts		= array();
	
	private $_config		= array(
		'maxChariconUpdates'	=> 10,
		'maxChardataUpdates'	=> 10,
		'caching'				=> true,
		'caching_time'			=> 24,
	);

	/**
	* Initialize the Class
	* 
	* @param $serverloc		Location of Server
	* @param $locale		The Language of the data
	* @return bool
	*/
	public function __construct(){}
	
	public function __get($name) {
		if(class_exists('registry')) {
			if($name == 'pfh') return registry::register('file_handler');
			if($name == 'puf') return registry::register('urlfetcher');
		}
		return null;
	}

	/**
	* Fetch guild information
	* 
	* @param $user		Character Name
	* @param $realm		Realm Name
	* @param $force		Force the cache to update?
	* @return bol
	*/
	public function guild($guild, $realm='', $force=false){
		$guildid = $this->getGuildID($guild, $realm);
		if (is_array($guildid )) return $guildid;
		$url	= $this->apiurl.'character/?guild.id='.$guildid.'&c:limit=999&c:show=name,guild.status,type,dbid,guild.rank,guild.joined,guild.name';
		if(!$json	= $this->get_CachedData('guilddata_'.$guildid.$realm, $force)){
			$json	= $this->read_url($url);
			$this->set_CachedData($json, 'guilddata_'.$guildid.$realm);
		}
		$chardata	= json_decode($json, true);
		$errorchk	= $this->CheckIfError($chardata);
		return (!$errorchk) ? $chardata: $errorchk;
	}
	
	public function guildinfo($guild, $realm='', $force=false){
        $guildid = $this->getGuildID($guild, $realm);
        if (is_array($guildid )) return $guildid;
        $url    = $this->apiurl.'guild/'.$guildid;
        if(!$json    = $this->get_CachedData('guildinfo_'.$guildid.$realm, $force)){
            $json    = $this->read_url($url);
            $this->set_CachedData($json, 'guildinfo_'.$guildid.$realm);
        }
        $guilddata    = json_decode($json, true);
        $errorchk    = $this->CheckIfError($guilddata);
        return (!$errorchk) ? $guilddata: $errorchk;
    }
	
	public function achieves($achieveid, $force=false){
        $url    = $this->apiurl.'achievement/'.$achieveid;
        if(!$json    = $this->get_CachedData('achievement_'.$achieveid)){
            $json    = $this->read_url($url);
            $this->set_CachedData($json, 'achievement_'.$achieveid);
        }
        $achieves    = json_decode($json, true);
        $errorchk    = $this->CheckIfError($achieves);
        return (!$errorchk) ? $achieves: $errorchk;
    }
	
	public function getGuildID($guild, $realm, $force=false){
		$guild = rawurlencode(unsanitize($guild));
		$realm = rawurlencode(unsanitize($realm));
		$url	= $this->apiurl.'guild/?name='.$guild.'&world='.$realm;
		if(!$json	= $this->get_CachedData('guildid_'.$guild.$realm, $force)){
			$json	= $this->read_url($url);
			$this->set_CachedData($json, 'guildid_'.$guild.$realm);
		}
		$chardata	= json_decode($json, true);
		$errorchk	= $this->CheckIfError($chardata);
		return (!$errorchk) ? $chardata['guild_list'][0]['id']: $errorchk;
	}
		
	/**
	* Fetch character information
	* 
	* @param $user		Character Name
	* @param $realm		Realm Name
	* @param $force		Force the cache to update?
	* @return bol
	*/
	public function character($user, $realm, $force=false){
		$user	= rawurlencode(unsanitize($user));
		$realm = rawurlencode(unsanitize($realm));
		$url	= $this->apiurl.'character/?name.first='.$user.'&locationdata.world='.$realm.'&c:resolve=factions(name),appearanceslots(displayname,iconid),equipmentslots(displayname,iconid),achievements(name),statistics';
		$json	= $this->get_CachedData('chardata_'.$user.$realm, $force);
		if(!$json && ($this->chardataUpdates < $this->_config['maxChardataUpdates'])){
			$json	= $this->read_url($url);
			$this->set_CachedData($json, 'chardata_'.$user.$realm);
		}
		$chardata	= json_decode($json, true);
		$errorchk	= $this->CheckIfError($chardata);
		return (!$errorchk) ? $chardata: $errorchk;
	}
	
	/**
	* Create full character Icon Link
	* 
	* @param $thumb		Thumbinformation returned by battlenet JSON feed
	* @return string
	*/
	public function characterIcon($charid, $forceUpdateAll = false){
		$cached_img	= str_replace('/', '_', 'image_character_'.$charid.'.png');
		$img_charicon	= $this->get_CachedData($cached_img, false, true);
		
		if(!$img_charicon && ($forceUpdateAll || ($this->chariconUpdates < $this->_config['maxChariconUpdates']))){

			$this->set_CachedData($this->read_url($this->imgurl.'character/'.$charid.'/headshot'), $cached_img, true);
			$img_charicon	= $this->get_CachedData($cached_img, false, true);			
			$this->chariconUpdates++;
		}
		if(!$img_charicon){
			$img_charicon	= $this->get_CachedData($cached_img, false, true, true);
			if(filesize($img_charicon) < 900){
				$img_charicon = '';
			}
		}
		
		return $img_charicon;
	}
	
	/**
	* Check if the JSON is an error result
	* 
	* @param $data		XML Data of Char
	* @return error code
	*/
	protected function CheckIfError($data){
		$error_code = (intval($data['returned']) == 0) ? 'no data returned' : false;
		$reason	= (intval($data['returned']) == 0) ? 'no data returned' : false;
		if(!$data || (intval($data['returned']) == 0)){
			return array('status'=> 'no data returned','reason'=>'no data returned');
		}else{
			return false;
		}
	}

	/**
	* Convert from Armory ID to EQDKP Id or reverse
	* 
	* @param $name			name/id to convert
	* @param $type			int/string?
	* @param $cat			category (classes, races, months)
	* @param $ssw			if set, convert from eqdkp id to armory id
	* @return string/int output
	*/
	public function ConvertID($name, $type, $cat, $ssw=''){
		if($ssw){
			if(!is_array($this->converts[$cat])){
				$this->converts[$cat] = array_flip($this->convert[$cat]);
			}
			return ($type == 'int') ? $this->converts[$cat][(int) $name] : $this->converts[$cat][$name];
		}else{
			return ($type == 'int') ? $this->convert[$cat][(int) $name] : $this->convert[$cat][$name];
		}
	}

	/**
	* Write JSON to Cache
	* 
	* @param	$json		XML string
	* @param	$filename	filename of the cache file
	* @return --
	*/
	protected function set_CachedData($json, $filename, $binary=false){
		if($this->_config['caching']){
			$cachinglink = $this->binaryORdata($filename, $binary);
			if(is_object($this->pfh)){
				$this->pfh->putContent($this->pfh->FolderPath('eq2', 'cache').$cachinglink, $json);
			}else{
				file_put_contents('data/'.$cachinglink, $json);
			}
		}
	}

	/**
	* get the cached JSON if not outdated & available
	* 
	* @param	$filename	filename of the cache file
	* @param	$force		force an update of the cached json file
	* @return --
	*/
	protected function get_CachedData($filename, $force=false, $binary=false, $returniffalse=false){
		if(!$this->_config['caching']){return false;}
		$data_ctrl = false;
		$rfilename	= (is_object($this->pfh)) ? $this->pfh->FolderPath('eq2', 'cache').$this->binaryORdata($filename, $binary) : 'data/'.$this->binaryORdata($filename, $binary);
		if(is_file($rfilename)){
			$data_ctrl	= (!$force && (filemtime($rfilename)+(3600*$this->_config['caching_time'])) > time()) ? true : false;
		}
		return ($data_ctrl || $returniffalse) ? (($binary) ? $rfilename : @file_get_contents($rfilename)) : false;
	}

	/**
	* delete the cached data
	* 
	* @return --
	*/
	public function DeleteCache(){
		if(!$this->_config['caching']){return false;}
		$rfoldername	= (is_object($this->pfh)) ? $this->pfh->FolderPath('eq2', 'cache') : 'data/';
		return $this->pfh->Delete($rfoldername);
	}

	/**
	* check if binary files or json/data
	* 
	* @param	$input	the input
	* @param	$binary	true/false
	* @return --
	*/
	protected function binaryORdata($input, $binary=false){
		return ($binary) ? $input : 'data_'.md5($input);
	}

	/**
	* Fetch the Data from URL
	* 
	* @param $url URL to Download
	* @return json
	*/
	protected function read_url($url) {
		if(!is_object($this->puf)) {
			global $eqdkp_root_path;
			include_once($eqdkp_root_path.'core/urlfetcher.class.php');
			$this->puf = new urlfetcher();
		}
		return $this->puf->fetch($url);
	}

	/**
	* Check if an error occured
	* 
	* @return error
	*/
	public function CheckError(){
		return ($this->error) ? $this->error : false;
	}
}
?>
