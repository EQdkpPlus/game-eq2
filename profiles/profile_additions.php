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
	
	$this->game->new_object('eq2_daybreak', 'daybreak', array());
	$chardata = $this->game->obj['daybreak']->character($member['name'],$this->config->get('servername'));
	$name = ($member['name']);
	$minresists = $this->config->get('uc_resists');
	$classname = $chardata['character_list'][0]['type']['class'];
	$racename = $chardata['character_list'][0]['type']['race'];
	if ($chardata && !isset($chardata['status'])){
		infotooltip_js();
		$this->tpl->add_css('
			.char_faction_1{
				color: #0060ff;
			}
			.char_faction_2{
				color: #90ead0;
			}
			.char_faction_3{
				color: #96ff66;
			}
			.char_faction_4{
				color: #dedede;
			}
			.char_faction_5{
				color: #ffe446;
			}
			.char_faction_6{
				color: #e0703a;
			}
			.char_faction_7{
				color: #d10000;
			}
			.xpbar {
    color: white;
    display: block;
    float: left;
    font-family: serif;
    font-weight: bold;
    margin-bottom: 3px;
    text-decoration: none;
    width: 170px;
}
.xpbar .bar {
    background-color: #7C4821;
    border: 1px solid #F0CAB7;
    border-bottom-left-radius: 5px;
    border-top-right-radius: 5px;
    display: block;
    margin-bottom: 4px;
    position: relative;
    text-shadow: 0 1px 0 #000000;
}
.xpbar .bar .value {
    background: url("../../games/eq2/profiles/images/xpbar-overlay.png") repeat-x scroll 0 0 transparent;
    display: block;
    font-size: 12px;
    position: relative;
    text-align: center;
    z-index: 2;
}
.xpbar .bar .index {
    background-color: #B8E4F5;
    border-bottom-left-radius: 5px;
    display: block;
    height: 100%;
    left: 0;
    overflow: hidden;
    position: absolute;
    text-indent: -9999px;
    top: 0;
}
.xpbar .bar .xpbar_adv {
    background: none repeat scroll 0 0 #C89442;
}
.xpbar .bar .xpbar_aa {
    background: none repeat scroll 0 0 #26B011;
}
.xpbar .bar .xpbar_ts {
    background: none repeat scroll 0 0 #B010AF;
}
.xpbubble {
    background-color: #413122;
    border: 2px solid #EBDEAA;
    border-radius: 10px 10px 10px 10px;
    float: left;
    font-size: 11px;
    margin-left: 20px;
    padding: 0 2px;
    text-align: center;
    text-shadow: 0 1px 0 #000000;
    width: 14px;
}
');
		$cdata 		= $chardata['character_list'][0];
		$tradeskill_keys = array_keys($cdata['tradeskills']);
		$second_tradeskill = "";
		foreach($cdata['secondarytradeskills'] as $key=>$value){
		$second_tradeskill .= $this->jquery->ProgressBar('second_tradeskill'.$key, 0, array('total' => (int)$value['maxvalue'], 'completed' => (int)$value['totalvalue'], 'text' => ucfirst($key).' (%progress%)'));
		}
		$this->tpl->assign_vars(array(
			'ARMORY' 		=> 1,
			'CHAR_IMGURL'		=> $this->game->obj['daybreak']->imgurl,
			'DATA_TRADESKILL'	=> ucfirst($tradeskill_keys[0]).' ('.$cdata['tradeskills'][$tradeskill_keys[0]]['level'].')',
			'DATA_TRADESKILL_LEVEL' => $cdata['tradeskills'][$tradeskill_keys[0]]['level'],
			'DATA_LEVEL_XP'		=> ((int)$cdata['experience']['currentadventureexp'] == 0) ? 0 : intval(((float)$cdata['experience']['currentadventureexp'] / (float)$cdata['experience']['adventureexpfornextlevel'])*100),
			'DATA_TRADESKILL_XP'=> ((int)$cdata['experience']['currenttradeskillexp'] == 0) ? 0 : intval(((float)$cdata['experience']['currenttradeskillexp'] / (float)$cdata['experience']['tradeskillexpfornextlevel'])*100),
			'DATA_SECOND_TRADESKILL' => $second_tradeskill,
			'DATA_AA'	=> ((int)$cdata['alternateadvancements']['availablepoints']),
			'DATA_RACENAME'     => $racename,
			'DATA_BIRTHDATE'	=> $this->time->user_date($cdata['type']['birthdate_utc']),
			'DATA_LASTSEEN'		=> $this->time->user_date($cdata['last_update']),
			'DATA_PLAYEDTIME'	=> intval($cdata['playedtime']/60/60/24),
			'DATA_GUILDJOINED'	=> $this->time->user_date($cdata['guild']['joined']),
			'DATA_KILLDEATHRATIO'=> round((float)$cdata['statistics']['kills_deaths_ratio']['value'], 2),
			'DATA_BLOCKCHANCE'	=>  floor((float)$cdata['stats']['combat']['blockchance']),
			'DATA_CRITCHANCE'	=> floor((float)$cdata['stats']['combat']['critchance']),
			'DATA_CRITBONUS'	=> floor((float)$cdata['stats']['combat']['critbonus']),
			'DATA_POTENCY'	=> floor((float)$cdata['stats']['combat']['basemodifier']),
			'DATA_ABILITY'	=> floor((float)$cdata['stats']['combat']['abilitymod']),
			'DATA_HATEGAIN'	=> floor((float)$cdata['stats']['combat']['hategainmod']),
			'DATA_DPS'		=> floor((float)$cdata['stats']['combat']['dps']),
			'DATA_STRIKE'	=> floor((float)$cdata['stats']['combat']['strikethrough']),
			'DATA_ACCURACY'	=> floor((float)$cdata['stats']['combat']['accuracy']),
			'DATA_AEAUTO'	=> floor((float)$cdata['stats']['combat']['aeautoattackchance']),
			'DATA_ATTACKSPEED'	=> floor((float)$cdata['stats']['combat']['attackspeed']),
			'DATA_DOUBLEATTACK'	=> floor((float)$cdata['stats']['combat']['doubleattackchance']),
			'DATA_SP_DOUBLEATTACK' => floor((float)$cdata['stats']['combat']['spelldoubleattackchance']),
			'DATA_SP_WAA' => floor((float)$cdata['stats']['combat']['spellweaponautoattackchance']),
			'DATA_SP_WAS' => floor((float)$cdata['stats']['combat']['spellweaponattackspeed']),
			'DATA_SP_WDA' => floor((float)$cdata['stats']['combat']['spellweapondoubleattackchanc']),
			'DATA_SP_WDPS' => floor((float)$cdata['stats']['combat']['spellweapondps']),
			'DATA_SP_WF' => floor((float)$cdata['stats']['combat']['spellweaponflurry']),
		));
		//Resists
		foreach($cdata['resists'] as $key => $value){
			$this->tpl->assign_block_vars('defense_list', array(
				'NAME'	=> ucfirst($key),
				'VALUE' => $value['effective'],
			));
		}
		//Skills
		$arrTmpSkills = array();
		foreach ($cdata['skills'] as $key => $value){
			$arrTmpSkills[$key] = $value;
		}
		ksort($arrTmpSkills);
		foreach ($arrTmpSkills as $key => $value){
			$maxvalue = ((int)$value['maxvalue'] > (int)$value['totalvalue']) ? (int)$value['maxvalue'] : (int)$value['totalvalue'];
			$skname = $key;
			if ($skname == 'alcoholtolerance') { $skname = 'Alcohol Tolerance';}
			$this->tpl->assign_block_vars('skill_list', array(
				'BAR' => $this->jquery->ProgressBar('skills_'.$key, 0, array( 'total' => $maxvalue, 'completed' => (int)$value['totalvalue'], 'text' => $value['totalvalue'].' / '.$maxvalue)),
				'NAME'=> ucfirst($skname),
			));
		}
				
		//Languages
		$arrTmpLangs = array();
		foreach ($cdata['language_list'] as $key => $value){
			$arrTmpLangs[$value['name']] = $value['id'];
		}
		ksort($arrTmpLangs);
		foreach ($arrTmpLangs as $key => $value){
			$this->tpl->assign_block_vars('lang_list', array(
				'NAME'=> ucfirst($key),
			));
		}
		//Factions
		$arrTmpFactions = array();
		foreach($cdata['faction_list'] as $value){
			$arrTmpFactions[$value['name']] = $value;
		}
		ksort($arrTmpFactions);
		foreach($arrTmpFactions as $value){
			$val = intval($value['value']);
			
			if ($val == 50000) {
				$class = 1;
			} elseif ($val > 29999) {
				$class = 2;
			} elseif ($val > 9999) {
				$class = 3;
			} elseif ($val > -10000) {
				$class = 4;
			} elseif ($val > -30000) {
				$class = 5;
			} elseif ($val > -49999) {
				$class = 6;
			} else {
				$class = 7;
			}
			$this->tpl->assign_block_vars('faction_list', array(
				'NAME'=> $value['name'],
				'CLASS'=> 'char_faction_'.$class,
				'VALUE'=> $val,
			));
		}
		//Places
		foreach($cdata['house_list'] as $value){
			$this->tpl->assign_block_vars('places_list', array(
				'NAME'=> ((int)$value['published'] == 1) ? '<b>'.$value['name'].'</b>' : $value['name'],
				'VALUE'=> $value['address'],
			));
		}
		foreach($cdata['dungeon_list'] as $value){
			$this->tpl->assign_block_vars('dungeon_list', array(
				'NAME'=> ((int)$value['published'] == 1) ? '<b>'.$value['name'].'</b>' : $value['name'],
				'VALUE'=> $value['type'],
				'S_DUNGEONS' => true,
			));
		}
		//Achievements
		$arrTmpAchievs = array();
		foreach($cdata['achievements']['achievement_list'] as $value){
			$arrTmpAchievs[$value['name']] = $value;
		}
		ksort($arrTmpAchievs);
		foreach($arrTmpAchievs as $value){
			$this->tpl->assign_block_vars('achievements_list', array(
				'NAME'=> $value['name'],
				'VALUE'=> ((int)$value['completed_timestamp'] == 0) ? '' : $this->time->user_date($value['completed_timestamp']),
			));
		}
		$this->tpl->assign_array('CHARDATA', $cdata);
		$this->jquery->Tab_header('char1_tabs');
		//Equipment
		$arrTmpEquip = array();
		foreach($cdata['equipmentslot_list'] as $value){
			$arrTmpEquip[] = $value;
			$arrSort[] = $value['displayname'];
		}
		array_multisort($arrSort, SORT_ASC, $arrTmpEquip);
		foreach($arrTmpEquip as $value){
			if ($value['displayname'] == 'Drink') { $drname = ($value['item']['displayname']); $dricon = ($value['item']['iconid']); }
		    if ($value['displayname'] == 'Food') { $fdname = ($value['item']['displayname']); $fdicon = ($value['item']['iconid']); }
			$this->tpl->assign_block_vars('equipment_list', array(
				'NAME'  => $value['displayname'],
				'VALUE' => (isset($value['item']['displayname'])) ? infotooltip($value['item']['displayname'], 0, false, 0, 0, 1) : '',
				'ICONID'=> (isset($value['item']['iconid'])) ? $value['item']['iconid'] : 0,
			));
		}
		//Appearance
		$arrTmpEquip = array();
		$arrSort = array();
		foreach($cdata['appearanceslot_list'] as $value){
			$arrTmpEquip[] = $value;
			$arrSort[] = $value['displayname'];
		}
		array_multisort($arrSort, SORT_ASC, $arrTmpEquip);
		foreach($arrTmpEquip as $value){
			$this->tpl->assign_block_vars('appearance_list', array(
				'NAME'  => $value['displayname'],
				'VALUE' => (isset($value['item']['displayname'])) ? infotooltip($value['item']['displayname'], 0, false, 0, 0, 1) : '',
				'ICONID'=> (isset($value['item']['iconid'])) ? infotooltip($value['item']['iconid']) : 0,
			));
		}
		
		//Raid Ready
		$arrTmpSpells = array();
		foreach($cdata['spell_list'] as $value) { $arrTmpSpells[] = $value; }
		$singularfocus = array('2662824675');
		
		//ER Setup
		 switch ($classname) {
				case 'Assassin':
				$erspells = array('593450753'); $ericon1 = 383; $erbakg1 = 317;
				break;	
				case 'Beastlord':
				$erspells = array('3062851873'); $ericon1 = 271; $erbakg1 = 317;
				break;
				case 'Berserker':
				$erspells = array('2357709831','908867871'); $ericon1 = 296; $erbakg1 = 317; $ericon2 = 681; $erbakg2 = 317;
				break;
				case 'Brigand':
				$erspells = array('660714803'); $ericon1 = 337; $erbakg1 = 317;
				break;
				case 'Bruiser':
				$erspells = array('325090821','525825229'); $ericon1 = 664; $erbakg1 = 317; $ericon2 = 327; $erbakg2 = 317;
				break;
				case 'Channeler':
				//$erspells = array('320684470','1302094268'); $ericon1 = 220; $erbakg1 = 314; $ericon2 = 42; $erbakg2 = 317;
				$erspells = array('320684470','1302094268','3147558951','2901583121'); $ericon1 = 220; $erbakg1 = 314; $ericon2 = 42; $erbakg2 = 317;
				break;
				case 'Coercer':
				$erspells = array('472410880','513612011'); $ericon1 = 15; $erbakg1 = 317; $ericon2 = 5; $erbakg2 = 316;
				break;
				case 'Conjuror':
				$erspells = array('1720755111'); $ericon1 = 234; $erbakg1 = 317;
				break;
				case 'Defiler':
				$erspells = array('2597294319','2168916173'); $ericon1 = 279; $erbakg1 = 312; $ericon1 = 913; $erbakg1 = 317;
				break;
				case 'Dirge':
				$erspells = array('2976474773'); $ericon1 = 171; $erbakg1 = 317;
				break;
				case 'Fury':
				$erspells = array('2672801118','571579967'); $ericon1 = 550; $erbakg1 = 317; $ericon2 = 274; $erbakg2 = 316;
				break;
				case 'Guardian':
				$erspells = array('306666685'); $ericon1 = 844; $erbakg1 = 317;
				break;
				case 'Illusionist':
				$erspells = array('2719301397'); $ericon1 = 266; $erbakg1 = 317;
				break;
				case 'Inquisitor':
				$erspells = array('85761225','382126813'); $ericon1 = 623; $erbakg1 = 317; $ericon2 = 800; $erbakg2 = 317;
				break;
				case 'Monk':
				$erspells = array('1463331340'); $ericon1 = 755; $erbakg1 = 317;
				break;
				case 'Mystic':
				$erspells = array('2290136341','2657181028'); $ericon1 = 616; $erbakg1 = 317; $ericon1 = 175; $erbakg1 = 315;
				break; 
				case 'Necromancer':
				$erspells = array('3039617986'); $ericon1 = 234; $erbakg1 = 317;
				break; 
				case 'Paladin':
				$erspells = array('449915658','3279286219'); $ericon1 = 158; $erbakg1 = 317; $ericon2 = 266; $erbakg2 = 317;
				break;
				case 'Ranger':
				$erspells = array('509781089'); $ericon1 = 685; $erbakg1 = 317;
				break;
				case 'Shadowknight':
				$erspells = array('3182003177','792904718'); $ericon1 = 224; $erbakg1 = 315; $ericon2 = 614; $erbakg2 = 317;
				break;
				case 'Swashbuckler':
				$erspells = array('1273618570'); $ericon1 = 377; $erbakg1 = 317;
				break;
				case 'Templar':
				$erspells = array('2758923289','2775781479'); $ericon1 = 664; $erbakg1 = 317; $ericon2 = 272; $erbakg2 = 316;
				break; 
				case 'Troubador':
				$erspells = array('698807671'); $ericon1 = 174; $erbakg1 = 317;
				break;
				case 'Warden':
				$erspells = array('1636577504','3803106182'); $ericon1 = 609; $erbakg1 = 317; $ericon2 = 188; $erbakg2 = 316;
				break;
				case 'Warlock':
				$erspells = array('21416893','102736953'); $ericon1 = 239; $erbakg1 = 317; $ericon2 = 732; $erbakg2 = 317;
				break;
				case 'Wizard':
				$erspells = array('2840893721'); $ericon1 = 41; $erbakg1 = 317;
				break;
				}		
				
		//Check to see if they completed Epic Repercussions
		$er = count(array_intersect($erspells, $arrTmpSpells));
		if ($er >= 1 ) { ($ercheck = 'Epic Repercussions Completed'); }
		if ($er == 0 ) { ($ercheck = 'Epic Repercussions NOT Completed'); }
		$ermatch = (array_intersect($erspells, $arrTmpSpells));
		$erlist = array_values($ermatch);
		$erico1 = 0; $erico2 = 0; $erbak1 = 0; $erbak2 = 0;
		$emark = 'bad';
		if (isset($erlist[0])) { $emark = 'good'; $erico1 = $ericon1; $erico2 = $ericon2; $erbak1 = $erbakg1; $erbak2 = $erbakg2; }
		 //Check if they have Singular Focus
		$singular = count(array_intersect($singularfocus, $arrTmpSpells));
		$singularmatch = (array_intersect($singularfocus, $arrTmpSpells));
		if ($singular >= 1 ) { ($singularcheck = 'Singular Focus Obtained'); $smark = 'good'; }
		if ($singular == 0 ) { ($singularcheck = 'Singular Focus NOT Obtained'); $smark = 'bad'; }
		if ($singularmatch == $singularfocus) { ($singularicon = '377'); }
		else { $singularicon = 0; }
		 //Check if they chose a deity
		$deity = $cdata['type']['deity'];
		$gmark = 'bad';
		if ($deity != 'None') { $dpic = strtolower(substr($deity,0,3)); $gmark = 'good'; }
		 //Check Alternate Advancements
		$aatotal = $cdata['type']['aa_level'];
		if ($aatotal < 350) { $aamark = 'bad'; } else { $aamark = 'good'; }
		$aaptotal = $cdata['alternateadvancements']['prestigespentpoints'];
		if ($aaptotal < 50) { $ptmark = 'bad'; } else { $ptmark = 'good'; }
		 // Check Resists
		$aresist = $cdata['resists']['arcane']['effective'];
		if ($aresist >= $minresists) { $armark = 'good'; }
		else { $armark = 'bad'; }
		$nresist = $cdata['resists']['noxious']['effective'];
		if ($nresist >= $minresists) { $nrmark = 'good'; }
		else { $nrmark = 'bad'; }
		$eresist = $cdata['resists']['elemental']['effective'];
		if ($eresist >= $minresists) { $ermark = 'good'; }
		else { $ermark = 'bad'; }
		 //Output
		if (floor((float)$cdata['stats']['combat']['critchance']) >= $mincrit) { $cmark = 'good'; }
		else { $cmark = 'bad'; }
		$this->tpl->assign_block_vars('raid_ready', array(
				'CAST_SPEED'	=> floor((float)$cdata['stats']['ability']['spelltimecastpct']),
				'REUSE_SPEED'	=> floor((float)$cdata['stats']['ability']['spelltimereusepct']),
				'RECOVERY_SPEED'=> floor((float)$cdata['stats']['ability']['spelltimerecoverypct']),
				'ER'     => $ercheck,
				'EICONID1'  => $erico1,
				'EICONID2'  => $erico2,
				'DEITY'     => $deity,
				'DPIC'      => $dpic,
				'SING'      => $singularcheck,
				'SICO'      => $singularicon,
				'FDVALUE'   => (isset($fdname)) ? infotooltip($fdname, 0, false, 0, 0, 1) : '',
				'FDICONID'  => (isset($fdicon)) ? $fdicon : 0,
				'DRVALUE'   => (isset($drname)) ? infotooltip($drname, 0, false, 0, 0, 1) : '',
				'DRICONID'  => (isset($dricon)) ? $dricon : 0,
				'EMARK'     => $emark,
				'CMARK'     => $cmark,
				'GMARK'     => $gmark,
				'SMARK'     => $smark,
				'ARMARK'    => $armark,
				'NRMARK'    => $nrmark,
				'ERMARK'    => $ermark,
				'MINRESIST' => number_format($minresists),
				'ARESIST'   => number_format($aresist),
				'NRESIST'   => number_format($nresist),
				'ERESIST'   => number_format($eresist),
				'AAPNTS'    => $aatotal,
				'PTPNTS'    => $aaptotal,
				'AAMARK'     => $aamark,
				'PTMARK'     => $ptmark,				
			));
		$this->tpl->add_css('
			.spellbkg1{
				background: url("http://census.daybreakgames.com/s:eqdkpplus/img/eq2/icons/'.$erbak1.'/spell") no-repeat;
				float: left;
				text-align: center;
				width: 42px;
			}
			.spellbkg2{
				background: url("http://census.daybreakgames.com/s:eqdkpplus/img/eq2/icons/'.$erbak2.'/spell") no-repeat;
				float: left;
				text-align: center;
				width: 42px;
			}
			.singbkg{
				background: url("http://census.daybreakgames.com/s:eqdkpplus/img/eq2/icons/317/spell") no-repeat;
				float: left;
				text-align: center;
				width: 42px;
			}
		');
	}
?>
