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
 
define('EQDKP_INC', true);
$eqdkp_root_path = './../../../';
include_once ($eqdkp_root_path . 'common.php');

class guildImporter extends page_generic {

	public function __construct() {
		$handler = array();
		parent::__construct(false, $handler, array());
		$this->user->check_auth('a_members_man');
		$this->game->new_object('eq2_daybreak', 'daybreak', array());
		$this->process();
	}

	public function perform_step0(){
		// classes array
		$classfilter	= $this->game->get('classes');
		$classfilter[0]	= $this->game->glang('uc_class_nofilter');

		// generate output
		$hmtlout = '<fieldset class="settings mediumsettings">
			<dl>
				<dt><label>'.$this->game->glang('uc_guild_name').'</label></dt>
				<dd>'.new htext('guildname', array('value' => $this->config->get('guildtag'), 'size' => '40')).'</dd>
			</dl>
			<dl>
				<dt><label>'.$this->game->glang('servername').'</label></dt>
				<dd>'.new htext('servername', array('value'=> $this->config->get('servername'), 'size'=>'40', 'autocomplete' => $this->game->get('realmlist'))).'</dd>
			</dl>
			</fieldset>
			<fieldset class="settings mediumsettings">
				<legend>'.$this->game->glang('uc_filter_name').'</legend>

				<dl>
					<dt><label>'.$this->game->glang('uc_class_filter').'</label></dt>
					<dd>'.new hdropdown('filter_class', array('options' => $classfilter)).'</dd>
				</dl>
				<dl>
					<dt><label>'.$this->game->glang('uc_level_filter').'</label></dt>
					<dd>'.new htext('filter_level', array('value' => 0, 'size' => '5')).'</dd>
				</dl>
			</fieldset>';
		$hmtlout .= '<br/><button type="submit" name="submiti"><i class="fa fa-download"></i> '.$this->game->glang('uc_import_forw').'</button>';
		return $hmtlout;
	}

	public function perform_step1(){
		if($this->in->get('guildname', '') == ''){
			return '<div class="infobox infobox-large infobox-red clearfix"><i class="fa fa-exclamation-triangle fa-4x pull-left"></i> <span id="error_message_txt>'.$this->game->glang('uc_imp_noguildname').'</span></div>';
		}
		
		//Suspend all Chars
		if ($this->in->get('delete_old_chars',0)){
			$this->pdh->put('member', 'suspend', array('all'));
		}

		// generate output
		$guilddata	= $this->game->obj['daybreak']->guild($this->in->get('guildname', ''), $this->config->get('servername'), true);
		$this->config->set('uc_guildid', $this->in->get('guildname', ''));

		if(!isset($guilddata['status'])){
			$hmtlout = '<div id="guildimport_dataset">
							<div id="controlbox">
								<fieldset class="settings">
									<dl>
										'.$this->game->glang('uc_gimp_loading').'
									</dl>
									<div id="progressbar"></div>
									</dl>
								</fieldset>
							</div>
							<fieldset class="settings data">
							</fieldset>
						</div>';

			$jsondata = array();
			foreach($guilddata['character_list'] as $guildchars){
				// filter: class
				if($this->in->get('filter_class', 0) > 0 && $this->game->obj['daybreak']->ConvertID((int)$guildchars['type']['classid'], 'int', 'classes') != $this->in->get('filter_class', 0)){
					continue;
				}

				// filter: level
				if($this->in->get('filter_level', 0) > 0 && (int)$guildchars['type']['level'] < $this->in->get('filter_level', 0)){
					continue;
				}
				
				// Build the array
				$jsondata[] = array(
					'name'		=> $guildchars['name']['first'],
					'class'		=> (int)$guildchars['type']['classid'],
					'race'		=> (int)$guildchars['type']['raceid'],
					'level'		=> (int)$guildchars['type']['level'],
					'gamecharid'=> (string)$guildchars['id'],
					//Take the config servername, until we get it for the chars
					'servername'=> $this->config->get('servername'),
				);
			}

			$this->tpl->add_js('
				$( "#progressbar" ).progressbar({
					value: 0
				});
				getData();', 'docready');
			$this->tpl->add_js('
			var guilddataArry = $.parseJSON(\''.json_encode($jsondata).'\');
			function getData(i){
				if (!i)
					i=0;
	
				if (guilddataArry.length >= i){
					$.post("guildimporter.php'.$this->SID.'&del='.(($this->in->get('delete_old_chars',0)) ? 'true' : 'false').'&step=2&totalcount="+guilddataArry.length+"&actcount="+i, guilddataArry[i], function(data){
						guilddata = $.parseJSON(data);
						if(guilddata.success == "available"){
							successdata = "<span style=\"color:orange;\">'.$this->game->glang('uc_armory_impduplex').'</span>";
						}else if(guilddata.success == "imported"){
							successdata = "<span style=\"color:green;\">'.$this->game->glang('uc_armory_imported').'</span>";
						}else{
							successdata = "<span style=\"color:red;\">'.$this->game->glang('uc_armory_impfailed').'</span>";
						}
						$("#guildimport_dataset fieldset.data").prepend("<dl><dt><label><img src=\""+ guilddata.image +"\" alt=\"charicon\" height=\"84\" width=\"84\" /></label></dt><dd>"+ guilddata.name+"<br/>"+ successdata +"</dd></dl>").children(":first").hide().fadeIn("slow");
						$("#progressbar").progressbar({ value: ((i/guilddataArry.length)*100) })
						if(guilddataArry.length > i+1){
							getData(i+1);
						}else{
							$("#controlbox").html("<dl><div class=\"greenbox roundbox\"><div class=\"icon_ok\" id=\"error_message_txt\">'.$this->game->glang('uc_gimp_header_fnsh').'</div></div></dl>").fadeIn("slow");
							return;
						}
					});
				}
			}');
		}else{
			$hmtlout .= '<div class="errorbox roundbox"><div class="icon_ok" id="error_message_txt">'.$guilddata['reason'].'</div></div>';
		}
		return $hmtlout;
	}

	public function perform_step2(){
		$strServername = $this->in->get('servername', '');
		$intMemberID = $this->pdh->get('member', 'id', array($strMembername, array('servername' => $strServername)));

		if($intMemberID){
			$successmsg = 'available';
			$gamecharid = $this->pdh->get('member', 'picture', array($charid));
			$charicon = $this->game->obj['daybreak']->characterIcon($gamecharid, true);
			
			//Revoke Char
			if ($this->in->get('del', '') == 'true'){
				$this->pdh->put('member', 'revoke', array($charid));
				$this->pdh->process_hook_queue();
			}
		} else {
			$dataarry = array(
				'name'		=> $this->in->get('name',''),
				'level'		=> $this->in->get('level', 0),
				'class'		=> $this->game->obj['daybreak']->ConvertID($this->in->get('class', 0), 'int', 'classes'),
				'race'		=> $this->game->obj['daybreak']->ConvertID($this->in->get('race', 0), 'int', 'races'),
				'picture'	=> $this->in->get('gamecharid', ''),
				'servername'=> $strServername,
			);

			$charicon = $this->game->obj['daybreak']->characterIcon($this->in->get('gamecharid', ''), true);
			$myStatus = $this->pdh->put('member', 'addorupdate_member', array(0, $dataarry));
			$successmsg = ($myStatus) ? 'imported' : 'failed';

			// reset the cache
			$this->pdh->process_hook_queue();
		}

		die(json_encode(array(
			'image'		=> ($charicon == '') ? $this->server_path.'images/global/avatar-default.svg' : $charicon,
			'name'		=> $this->in->get('name', ''),
			'success'	=> $successmsg
		)));
	}

	public function display(){
		$funcname = 'perform_step'.$this->in->get('step',0);
		$this->tpl->assign_vars(array(
			'DATA'		=> $this->$funcname(),
			'STEP'		=> ($this->in->get('step',0)+1)
		));

		$this->core->set_vars(array(
			'page_title'		=> $this->user->lang('raidevent_raid_guests'),
			'header_format'		=> 'simple',
			'template_file'		=> 'importer.html',
			'display'			=> true
		));
	}
}

registry::register('guildImporter');
?>
