<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2010
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

	// Add css code:
	$this->tpl->add_css("
		#guild_header_wrap {
			width:100%;
		}
		#guild_header_banner{
			width:100%;
			height:106px;
			background: url('games/eq2/profiles/images/achievebanner.jpg') no-repeat scroll 0px 0px transparent;
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
			width: 56px; height: 55px; z-index: 4; background:url('games/eq2/profiles/images/achbkg.png');
		}
	");
	
if ($this->config->get('uc_showachieve') == 'yes') {
# Amory Stuff
		$this->game->new_object('eq2_soe', 'soe', array($this->config->get('uc_server_loc'), $this->config->get('uc_data_lang')));
		if(!is_object($this->game->obj['soe'])) return "";
		$guilddata = $this->game->obj['soe']->guildinfo($this->config->get('guildtag'), $this->config->get('uc_servername'), false);
		$achieves = $guilddata['guild_list'][0]['achievement_list'];	
		$gdata 	  = $guilddata['guild_list'][0];
		if ($guilddata && !isset($chardata['status'])){
		infotooltip_js();
		//Achievement Detail
		$arrTmpGAchievs = array();
		$avcount = 0; $avtotal = 19;
		$classiccount = 0; $classictotal = 10; $sscount = 0; $sstotal = 2; $dofcount = 0; $doftotal = 10;
		$koscount = 0; $kostotal = 8; $fdcount = 0; $fdtotal = 3; $eofcount = 0; $eoftotal = 5;
		$rokcount = 0; $roktotal = 9; $sfcount = 0; $sftotal = 7; $tsocount = 0; $tsototal = 6;
		$dovcount = 0; $dovtotal = 100; $coecount = 0; $coetotal = 33; $tovcount = 0; $tovtotal = 27;
		if (isset($gdata)) {
		foreach($achieves as $values){
			$arrTmpGAchievs[$values['completedtimestamp']] = $values;
		}
		krsort($arrTmpGAchievs,1);
		foreach ($arrTmpGAchievs as $achieve) { 
		$achid = $achieve['id'];
		$achtim = $achieve['completedtimestamp'];
		$achdata = $this->game->obj['soe']->achieves($achid, false);
		$ad = ($achdata[achievement_list][0]);
		$aic = '<img style="padding-left:8px;padding-top:6px;" src="http://data.soe.com/s:eqdkpplus/img/eq2/icons/'.$ad['icon'].'/item"/>';
		$expan = ($ad['subcategory']);
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
		if ($expan == "Avatars") {($expans = "av");($avcount = $avcount + 1);}
		$clcomplete = ($classiccount != 0) ? intval(($classiccount / $classictotal) * 100) : 0;
		$sscomplete = ($sscount != 0) ? intval(($sscount / $sstotal) * 100) : 0;
		$dofcomplete = ($dofcount != 0) ? intval(($dofcount / $doftotal) * 100) : 0;
		$koscomplete = ($koscount != 0) ? intval(($koscount / $kostotal) * 100) : 0;
		$fdcomplete = ($fdcount != 0) ? intval(($fdcount / $fdtotal) * 100) : 0;
		$eofcomplete = ($eofcount != 0) ? intval(($eofcount / $eoftotal) * 100) : 0;
		$rokcomplete = ($rokcount != 0) ? intval(($rokcount / $roktotal) * 100) : 0;
		$sfcomplete = ($sfcount != 0) ? intval(($sfcount / $sftotal) * 100) : 0;
		$tsocomplete = ($tsocount != 0) ? intval(($tsocount / $tsototal) * 100) : 0;
		$dovcomplete = ($dovcount != 0) ? intval(($dovcount / $dovtotal) * 100) : 0;
		$coecomplete = ($coecount != 0) ? intval(($coecount / $coetotal) * 100) : 0;
		$tovcomplete = ($tovcount != 0) ? intval(($tovcount / $tovtotal) * 100) : 0;
		$avcomplete = ($avcount != 0) ? intval(($avcount / $avtotal) * 100) : 0;
		$this->tpl->assign_block_vars($expans.'_achievements', array(
				'AICON' => $aic,
				'ANAME' => substr($ad['name'], 7),
				'ADESC' => $ad['desc'],
				'ADATE' => ((int)$achieve['completedtimestamp'] == 0) ? '' : $this->time->user_date($achieve['completedtimestamp']),));
		}
		$this->tpl->assign_block_vars('classicbar', array(		
				'BAR'	=> $this->jquery->ProgressBar('classicbar', $clcomplete, $classiccount .' / ' . $classictotal.' ('.$clcomplete.'%)'),));
		$this->tpl->assign_block_vars('ssbar', array(		
				'BAR'	=> $this->jquery->ProgressBar('ssbar', $sscomplete, $sscount .' / ' . $sstotal.' ('.$sscomplete.'%)'),));
		$this->tpl->assign_block_vars('dofbar', array(		
				'BAR'	=> $this->jquery->ProgressBar('dofbar', $dofcomplete, $dofcount .' / ' . $doftotal.' ('.$dofcomplete.'%)'),));
		$this->tpl->assign_block_vars('kosbar', array(		
				'BAR'	=> $this->jquery->ProgressBar('kosbar', $koscomplete, $koscount .' / ' . $kostotal.' ('.$koscomplete.'%)'),));
		$this->tpl->assign_block_vars('fdbar', array(		
				'BAR'	=> $this->jquery->ProgressBar('fdbar', $fdcomplete, $fdcount .' / ' . $fdtotal.' ('.$fdcomplete.'%)'),));
		$this->tpl->assign_block_vars('eofbar', array(		
				'BAR'	=> $this->jquery->ProgressBar('eofbar', $eofcomplete, $eofcount .' / ' . $eoftotal.' ('.$eofcomplete.'%)'),));
		$this->tpl->assign_block_vars('rokbar', array(		
				'BAR'	=> $this->jquery->ProgressBar('rokbar', $rokcomplete, $rokcount .' / ' . $roktotal.' ('.$rokcomplete.'%)'),));
		$this->tpl->assign_block_vars('sfbar', array(		
				'BAR'	=> $this->jquery->ProgressBar('sfbar', $sfcomplete, $sfcount .' / ' . $sftotal.' ('.$sfcomplete.'%)'),));
		$this->tpl->assign_block_vars('tsobar', array(		
				'BAR'	=> $this->jquery->ProgressBar('tsobar', $tsocomplete, $tsocount .' / ' . $tsototal.' ('.$tsocomplete.'%)'),));
		$this->tpl->assign_block_vars('dovbar', array(		
				'BAR'	=> $this->jquery->ProgressBar('dovbar', $dovcomplete, $dovcount .' / ' . $dovtotal.' ('.$dovcomplete.'%)'),));
		$this->tpl->assign_block_vars('coebar', array(		
				'BAR'	=> $this->jquery->ProgressBar('coebar', $coecomplete, $coecount .' / ' . $coetotal.' ('.$coecomplete.'%)'),));
		$this->tpl->assign_block_vars('tovbar', array(		
				'BAR'	=> $this->jquery->ProgressBar('tovbar', $tovcomplete, $tovcount .' / ' . $tovtotal.' ('.$tovcomplete.'%)'),));		
		$this->tpl->assign_block_vars('avbar', array(		
				'BAR'	=> $this->jquery->ProgressBar('avbar', $avcomplete, $avcount .' / ' . $avtotal.' ('.$avcomplete.'%)'),));		
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
		'CLASSIC'		=> '<img src="games/eq2/profiles/images/expansions/classic.png"/>',
		'SS'			=> '<img src="games/eq2/profiles/images/expansions/ss.png"/>',
		'DOF'			=> '<img src="games/eq2/profiles/images/expansions/dof.png"/>',
		'KOS'			=> '<img src="games/eq2/profiles/images/expansions/kos.png"/>',
		'FD'			=> '<img src="games/eq2/profiles/images/expansions/fd.png"/>',
		'EOF'			=> '<img src="games/eq2/profiles/images/expansions/eof.png"/>',
		'ROK'			=> '<img src="games/eq2/profiles/images/expansions/rok.png"/>',
		'TSO'			=> '<img src="games/eq2/profiles/images/expansions/tso.png"/>',
		'SF'			=> '<img src="games/eq2/profiles/images/expansions/sf.png"/>',
		'DOV'			=> '<img src="games/eq2/profiles/images/expansions/dov.png"/>',
		'COE'			=> '<img src="games/eq2/profiles/images/expansions/coe.png"/>',
		'TOV'			=> '<img src="games/eq2/profiles/images/expansions/tov.png"/>',
		'AV'			=> '<img src="games/eq2/profiles/images/expansions/avatars.png"/>',
		'REALM'			=> $this->config->get('uc_servername'),
		'GUILD'			=> $this->config->get('guildtag'),
		'LEVEL'			=> $level = $guilddata['guild_list'][0]['level'],
));

//Achievement Total
		$achievecount = 0;
		if (!empty($guilddata)) {
		foreach ($achieves as $achieve) 
		{ $achievecount = $achievecount + 1; 
		}
 			$total = 238;
			$complete = ($achievecount != 0) ? intval(($achievecount / $total) * 100) : 0;
			$this->tpl->assign_block_vars('guildachievs', array(
				'TOTAL'	=> 'Total Completed',
				'BAR'	=> $this->jquery->ProgressBar('guildachievs', $complete, $achievecount .' / ' . $total.' ('.$complete.'%)'),
		));
		}	

}
		
//ROSTER PAGE
$hptt_page_settings = $this->pdh->get_page_settings('roster', 'hptt_roster');
$hptt_page_settings['table_sort_col'] += 1;
$table_presets = $hptt_page_settings['table_presets'];
array_unshift($table_presets, array('name' => 'eq2_charicon', 'sort' => false, 'th_add' => 'width="52"', 'td_add' => ''));
$hptt_page_settings['table_presets'] = $table_presets;
if ($this->config->get('roster_classorrole') == 'role'){
	$members = $this->pdh->aget('member', 'defaultrole', 0, array($this->pdh->get('member', 'id_list', array($skip_inactive, $skip_hidden, true, $skip_twinks))));
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
		$hptt = $this->get_hptt($hptt_page_settings, $arrRoleMembers[$key], $arrRoleMembers[$key], array('%link_url%' => 'viewcharacter.php', '%link_url_suffix%' => '', '%with_twink%' => !intval($this->config->get('pk_show_twinks'))), 'role_'.$key);
		$this->tpl->assign_block_vars('class_row', array(
			'CLASS_NAME'	=> $value,
			'CLASS_ICONS'	=> $this->game->decorate('roles', array($key)),
			'MEMBER_LIST'	=> $hptt->get_html_table($this->in->get('sort')),
		));
	}
} else {
	$members = $this->pdh->aget('member', 'classid', 0, array($this->pdh->get('member', 'id_list', array($skip_inactive, $skip_hidden, true, $skip_twinks))));
	$arrClassMembers = array();
	foreach ($members as $memberid => $classid){
		$arrClassMembers[$classid][] = $memberid;
	}
	foreach ($this->game->get('classes') as $key => $value){
		if ($key == 0) continue;
		$hptt = $this->get_hptt($hptt_page_settings, $arrClassMembers[$key], $arrClassMembers[$key], array('%link_url%' => 'viewcharacter.php', '%link_url_suffix%' => '', '%with_twink%' => !intval($this->config->get('pk_show_twinks'))), 'class_'.$key);
		$this->tpl->assign_block_vars('class_row', array(
			'CLASS_NAME'	=> $value,
			'CLASS_ID'		=> $key ,
			'CLASS_ICONS'	=> $this->game->decorate('classes', array($key, true)),
			'MEMBER_LIST'	=> $hptt->get_html_table($this->in->get('sort')),
		));
	}
}
?>