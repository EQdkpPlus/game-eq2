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
	");
		
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