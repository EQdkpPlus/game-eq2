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
 
	// Add css code:
	$this->tpl->add_css("
		#guild_header_wrap {
			width:100%;
		}
		#guild_header_banner{
			width:100%;
			height:106px;
			background: url('../../games/eq2/profiles/images/achievebanner.png') no-repeat scroll 0px 0px transparent;
			margin-top:20px;
		}
		#guild_emblem { 
			height:256px;
			width:128px;
		}		
		#guild_name {
			font-size: 30px; 
			color: #white ;
			position:relative; 
			top:10px; 
			left:15px;
			font-weight:bold;
		}
		#guild_realm {
			font-size: 20px; 
			color: #white ;
			position:relative; 
			top:30px; 
			left:15px;
		}
		#bar_guildachieves{
			width: 31%;
			align: center;
			padding: 5px;
			cursor: pointer;
		}
		#achicon { 
			width: 56px; height: 55px; z-index: 4; background:url('../../games/eq2/profiles/images/achbkg.png');
		}
	");
	
if ($this->config->get('uc_showachieve') == 'yes') {
# Amory Stuff
		$this->game->new_object('eq2_daybreak', 'daybreak', array($this->config->get('uc_server_loc'), $this->config->get('uc_data_lang')));
		if(!is_object($this->game->obj['daybreak'])) return "";
		$guilddata = $this->game->obj['daybreak']->guildinfo($this->config->get('guildtag'), $this->config->get('servername'), false);
		$achieves = $guilddata['guild_list'][0]['achievement_list'];	
		$gdata 	  = $guilddata['guild_list'][0];
		if ($guilddata && !isset($chardata['status'])){
		infotooltip_js();
		//Achievement Detail
		$arrTmpGAchievs = array();
		$gp = 0; $gencount = 0; $gentotal = 2; 
		$aomcount = 0; $aomtotal = 23; $avcount = 0; $avtotal = 24; $coecount = 0; $coetotal = 34;
		$dofcount = 0; $doftotal = 10; $dovcount = 0; $dovtotal = 98; $eofcount = 0; $eoftotal = 13; 
		$fdcount = 0; $fdtotal = 3; $koscount = 0; $kostotal = 16; $rokcount = 0; $roktotal = 9;
		$sfcount = 0; $sftotal = 7; $classiccount = 0; $classictotal = 14; $sscount = 0; $sstotal = 2; 
		$tovcount = 0; $tovtotal = 36; $tsocount = 0; $tsototal = 6; $rumcount = 0; $rumtotal = 10;
		if (isset($gdata)) {
		function cmp($a, $b)
		{
			if ($a['completedtimestamp'] == $b['completedtimestamp']) { return 0; }
		return ($a['completedtimestamp'] > $b['completedtimestamp']) ? -1 : 1;
		}
		usort($achieves, "cmp");
		foreach ($achieves as $achieve) { 
		$achid = $achieve['id'];
		$achtim = $achieve['completedtimestamp'];
		$achdata = $this->game->obj['daybreak']->achieves($achid, false);
		$ad = ($achdata[achievement_list][0]);
		$aic = '<img style="padding-left:8px;padding-top:6px;" src="http://census.daybreakgames.com/s:eqdkpplus/img/eq2/icons/'.$ad['icon'].'/item" class="gameicon"/>';
		$expan = ($ad['subcategory']);
		$ap = ($ad['points']);
		$gp = ($gp + $ap);
		if ($expan == "Shattered Lands") {($expans = "classic");($classiccount = $classiccount + 1);}
		if ($expan == "Splitpaw Saga") {($expans = "ss");($sscount = $sscount + 1);}
		if ($expan == "Desert of Flames") {($expans = "dof");($dofcount = $dofcount + 1);}
		if ($expan == "Kingdom of Sky") {($expans = "kos");($koscount = $koscount + 1);}
		if ($expan == "Fallen Dynasty") {($expans = "fd");($fdcount = $fdcount + 1);}
		if ($expan == "Echoes of Faydwer") {($expans = "eof");($eofcount = $eofcount + 1);}
		if ($expan == "Rise of Kunark") {($expans = "rok");($rokcount = $rokcount + 1);}
		if ($expan == "Sentinel's Fate") {($expans = "sf");($sfcount = $sfcount + 1);}
		if ($expan == "The Shadow Odyssey") {($expans = "tso");($tsocount = $tsocount + 1);}
		if ($expan == "Destiny of Velious") {($expans = "dov");($dovcount = $dovcount + 1);}
		if ($expan == "Chains of Eternity") {($expans = "coe");($coecount = $coecount + 1);}
		if ($expan == "Tears of Veeshan") {($expans = "tov");($tovcount = $tovcount + 1);}
		if ($expan == "Altar of Malice") {($expans = "aom");($aomcount = $aomcount + 1);}
		if ($expan == "Avatars") {($expans = "av");($avcount = $avcount + 1);}
		if ($expan == "Guild Hall") {($expans = "gen");($gencount = $gencount + 1);}
		if ($expan == "F.S. Distillery") {($expans = "rum");($rumcount = $rumcount + 1);}
		$this->tpl->assign_block_vars($expans.'_achievements', array(
				'AICON' => $aic,
				'ANAME' => substr($ad['name'], 7),
				'ADESC' => $ad['desc'],
				'ADATE' => ((int)$achieve['completedtimestamp'] == 0) ? '' : $this->time->user_date($achieve['completedtimestamp']),));
		}
		$this->tpl->assign_block_vars('classicbar', array(
		'BAR'	=> $this->jquery->progressbar('classicbar', 0, array('completed' => $classiccount, 'total' => $classictotal,'text' => '%progress% (%percentage%)')),
		));
		$this->tpl->assign_block_vars('ssbar', array(
		'BAR'	=> $this->jquery->progressbar('ssbar', 0, array('completed' => $sscount, 'total' => $sstotal,'text' => '%progress% (%percentage%)')),
		));
		$this->tpl->assign_block_vars('dofbar', array(
		'BAR'	=> $this->jquery->progressbar('dofbar', 0, array('completed' => $dofcount, 'total' => $doftotal,'text' => '%progress% (%percentage%)')),
		));
		$this->tpl->assign_block_vars('kosbar', array(
		'BAR'	=> $this->jquery->progressbar('kosbar', 0, array('completed' => $koscount, 'total' => $kostotal,'text' => '%progress% (%percentage%)')),
		));
		$this->tpl->assign_block_vars('fdbar', array(
		'BAR'	=> $this->jquery->progressbar('fdbar', 0, array('completed' => $fdcount, 'total' => $fdtotal,'text' => '%progress% (%percentage%)')),
		));
		$this->tpl->assign_block_vars('eofbar', array(
		'BAR'	=> $this->jquery->progressbar('eofbar', 0, array('completed' => $eofcount, 'total' => $eoftotal,'text' => '%progress% (%percentage%)')),
		));
		$this->tpl->assign_block_vars('rokbar', array(
		'BAR'	=> $this->jquery->progressbar('rokbar', 0, array('completed' => $rokcount, 'total' => $roktotal,'text' => '%progress% (%percentage%)')),
		));
		$this->tpl->assign_block_vars('sfbar', array(
		'BAR'	=> $this->jquery->progressbar('sfbar', 0, array('completed' => $sfcount, 'total' => $sftotal,'text' => '%progress% (%percentage%)')),
		));
		$this->tpl->assign_block_vars('tsobar', array(
		'BAR'	=> $this->jquery->progressbar('tsobar', 0, array('completed' => $tsocount, 'total' => $tsototal,'text' => '%progress% (%percentage%)')),
		));
		$this->tpl->assign_block_vars('dovbar', array(
		'BAR'	=> $this->jquery->progressbar('dovbar', 0, array('completed' => $dovcount, 'total' => $dovtotal,'text' => '%progress% (%percentage%)')),
		));
		$this->tpl->assign_block_vars('coebar', array(
		'BAR'	=> $this->jquery->progressbar('coebar', 0, array('completed' => $coecount, 'total' => $coetotal,'text' => '%progress% (%percentage%)')),
		));
		$this->tpl->assign_block_vars('tovbar', array(
		'BAR'	=> $this->jquery->progressbar('tovbar', 0, array('completed' => $tovcount, 'total' => $tovtotal,'text' => '%progress% (%percentage%)')),
		));
		$this->tpl->assign_block_vars('aombar', array(
		'BAR'	=> $this->jquery->progressbar('aombar', 0, array('completed' => $aomcount, 'total' => $aomtotal,'text' => '%progress% (%percentage%)')),
		));
		$this->tpl->assign_block_vars('avbar', array(
		'BAR'	=> $this->jquery->progressbar('avbar', 0, array('completed' => $avcount, 'total' => $avtotal,'text' => '%progress% (%percentage%)')),
		));
		$this->tpl->assign_block_vars('genbar', array(
		'BAR'	=> $this->jquery->progressbar('genbar', 0, array('completed' => $gencount, 'total' => $gentotal,'text' => '%progress% (%percentage%)')),
		));
		$this->tpl->assign_block_vars('rumbar', array(
		'BAR'	=> $this->jquery->progressbar('rumbar', 0, array('completed' => $rumcount, 'total' => $rumtotal,'text' => '%progress% (%percentage%)')),
		));
		$this->jquery->Tab_header('eq2_roster');
		$this->jquery->Tab_header('expansions');
		$this->tpl->assign_vars(array(
			'S_ARMORY_INFO' => true,
		));
	} else {
		$guilddata = false;
	}
	}
$this->tpl->assign_vars(array(
		'CLASSIC'	=> '<img src="../../games/eq2/profiles/images/expansions/classic.png" class="gameicon"/>',
		'SS'		=> '<img src="../../games/eq2/profiles/images/expansions/ss.png" class="gameicon"/>',
		'DOF'		=> '<img src="../../games/eq2/profiles/images/expansions/dof.png" class="gameicon"/>',
		'KOS'		=> '<img src="../../games/eq2/profiles/images/expansions/kos.png" class="gameicon"/>',
		'FD'		=> '<img src="../../games/eq2/profiles/images/expansions/fd.png" class="gameicon"/>',
		'EOF'		=> '<img src="../../games/eq2/profiles/images/expansions/eof.png" class="gameicon"/>',
		'ROK'		=> '<img src="../../games/eq2/profiles/images/expansions/rok.png" class="gameicon"/>',
		'TSO'		=> '<img src="../../games/eq2/profiles/images/expansions/tso.png" class="gameicon"/>',
		'SF'		=> '<img src="../../games/eq2/profiles/images/expansions/sf.png" class="gameicon"/>',
		'DOV'		=> '<img src="../../games/eq2/profiles/images/expansions/dov.png" class="gameicon"/>',
		'COE'		=> '<img src="../../games/eq2/profiles/images/expansions/coe.png" class="gameicon"/>',
		'TOV'		=> '<img src="../../games/eq2/profiles/images/expansions/tov.png" class="gameicon"/>',
		'AOM'		=> '<img src="../../games/eq2/profiles/images/expansions/aom.png"/>',
		'AV'		=> '<img src="../../games/eq2/profiles/images/expansions/avatars.png" class="gameicon"/>',
		'GENERAL'	=> '<img src="../../games/eq2/profiles/images/expansions/general.png" class="gameicon"/>',
		'RUM'    	=> '<img src="../../games/eq2/profiles/images/expansions/rum.png" class="gameicon"/>',
		'REALM'	 	=> $this->config->get('servername'),
		'GUILD'		=> $this->config->get('guildtag'),
		'LEVEL'		=> $level = $guilddata['guild_list'][0]['level'],
		'POINTS'    => $gp,
));

//Achievement Total
		$achievecount = 0;
		if (!empty($guilddata)) {
		foreach ($achieves as $achieve) 
		{ $achievecount = $achievecount + 1; 
		}
 			$total = 307;
			$this->tpl->assign_block_vars('guildachievs', array(
				'TOTAL'	=> 'Total Completed',
				'BAR'	=> $this->jquery->progressbar('guildachievs_'.$id, 0, array('completed' => $achievecount, 'total' => $total,'text' => '%progress% (%percentage%)')),
			));
		}	

}
		
//ROSTER PAGE
$this->hptt_page_settings = $this->pdh->get_page_settings('roster', 'hptt_roster');

if ($this->config->get('roster_classorrole') == 'role'){
	$members = $this->pdh->aget('member', 'defaultrole', 0, array($this->pdh->get('member', 'id_list', array($this->skip_inactive, $this->skip_hidden, true, $this->skip_twinks))));
	$arrRoleMembers = array();
	foreach ($members as $memberid => $defaultroleid){
		if ((int)$defaultroleid == 0){
			$arrAvailableRoles = array_keys($this->pdh->get('roles', 'memberroles', array($this->pdh->get('member', 'classid', array($memberid)))));
			if (isset($arrAvailableRoles[0])) $arrRoleMembers[$arrAvailableRoles[0]][] = $memberid;
		} else {
			$arrRoleMembers[$defaultroleid][] = $memberid;
		}
	}
	
	foreach ($this->pdh->aget('roles', 'name', 0, array($this->pdh->get('roles', 'id_list', array()))) as $key => $value){
		if ($key == 0) continue;

		$hptt = $this->get_hptt($this->hptt_page_settings, $arrRoleMembers[$key], $arrRoleMembers[$key], array('%link_url%' => $this->routing->simpleBuild('character'), '%link_url_suffix%' => '', '%with_twink%' => $this->skip_twinks, '%use_controller%' => true), 'role_'.$key);
		
		$this->tpl->assign_block_vars('class_row', array(
			'CLASS_NAME'	=> $value,
			'CLASS_ICONS'	=> $this->game->decorate('roles', $key),
			'CLASS_LEVEL'	=> 2,
			'ENDLEVEL'		=> true,
			'MEMBER_LIST'	=> $hptt->get_html_table($this->in->get('sort')),
		));
	}
	
	
} elseif($this->config->get('roster_classorrole') == 'raidgroup') {
	$arrMembers = $this->pdh->aget('member', 'defaultrole', 0, array($this->pdh->get('member', 'id_list', array($this->skip_inactive, $this->skip_hidden, true, $this->skip_twinks))));
	$arrRaidGroups = $this->pdh->get('raid_groups', 'id_list', array());
	foreach($arrRaidGroups as $intRaidGroupID){
		$arrGroupMembers = $this->pdh->get('raid_groups_members', 'member_list', array($intRaidGroupID));
				
		$hptt = $this->get_hptt($this->hptt_page_settings, $arrGroupMembers, $arrGroupMembers, array('%link_url%' => $this->routing->simpleBuild('character'), '%link_url_suffix%' => '', '%with_twink%' => $this->skip_twinks, '%use_controller%' => true), 'raidgroup_'.$intRaidGroupID);
		
		$this->tpl->assign_block_vars('class_row', array(
				'CLASS_NAME'	=> $this->pdh->get('raid_groups', 'name', array($intRaidGroupID)),
				'CLASS_ICONS'	=> '',
				'CLASS_LEVEL'	=> 2,
				'ENDLEVEL'		=> true,
				'MEMBER_LIST'	=> $hptt->get_html_table($this->in->get('sort')),
		));
	}

} else {
	$arrMembers = $this->pdh->get('member', 'id_list', array($this->skip_inactive, $this->skip_hidden, true, $this->skip_twinks));
	
	$rosterClasses = $this->game->get_roster_classes();
	
	$arrRosterMembers = array();
	foreach($arrMembers as $memberid){
		$string = "";
		foreach($rosterClasses['todisplay'] as $key => $val){
			$string .= $this->pdh->get('member', 'profile_field', array($memberid, $this->game->get_name_for_type($val)))."_";
		}
	
		$arrRosterMembers[$string][] = $memberid;
	}
	
	$this->build_class_block($rosterClasses['data'], $rosterClasses['todisplay'], $arrRosterMembers);
}
?>
