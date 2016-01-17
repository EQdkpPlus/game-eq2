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

class charImporter extends page_generic {
	public function __construct() {
		$handler = array(
			'massupdate'		=> array('process' => 'perform_massupdate'),
			'resetcache'		=> array('process' => 'perform_resetcache'),
			'ajax_massupdate'	=> array('process' => 'ajax_massupdate'),
			'ajax_mudate'		=> array('process' => 'ajax_massupdatedate'),
		);
		parent::__construct(false, $handler, array());
		$this->user->check_auth('u_member_man');
		$this->user->check_auth('u_member_add');
		$this->game->new_object('eq2_daybreak', 'daybreak', array());
		$this->process();
	}

	public function perform_resetcache(){
		// delete the cache folder
		$this->game->obj['daybreak']-> DeleteCache();

		// Output the success message
		$hmtlout = '<div id="guildimport_dataset">
						<div id="controlbox">
							<fieldset class="settings">
								<dl>
									'.$this->game->glang('uc_importcache_cleared').'
								</dl>
							</fieldset>
						</div>
					</div>';

		$this->tpl->assign_vars(array(
			'DATA'		=> $hmtlout,
			'STEP'		=> ''
		));

		$this->core->set_vars(array(
			'page_title'		=> $this->user->lang('raidevent_raid_guests'),
			'header_format'		=> 'simple',
			'template_file'		=> 'importer.html',
			'display'			=> true
		));
	}

	public function perform_massupdate(){
		// check permission again, cause this is for admins only
		$this->user->check_auth('a_members_man');

		$memberArry	= array();
		$members	= $this->pdh->get('member', 'names', array());
		if(is_array($members)){
			asort($members);
			foreach($members as $membernames){
				if($membernames != ''){
					$charid = $this->pdh->get('member', 'id', array($membernames));
					if($charid){
						$memberArry[] = array(
							'charname'	=> $membernames,
							'charid'	=> $charid,
						);
					}
				}
			}
		}
		$hmtlout = '<div id="guildimport_dataset">
						<div id="controlbox">
							<fieldset class="settings">
								<dl>
									'.$this->game->glang('uc_massupd_loading').'
									<div id="progressbar"></div>
								</dl>
							</fieldset>
						</div>
						<fieldset class="settings data">
						</fieldset>
					</div>';

		$this->tpl->add_js('
			var chardataArry = $.parseJSON(\''.json_encode($memberArry).'\');
			function getData(i){
				if (!i)
					i=0;
	
				if (chardataArry.length >= i){
					$.post("charimporter.php'.$this->SID.'&ajax_massupdate=true&totalcount="+chardataArry.length+"&actcount="+i, chardataArry[i], function(data){
						chardata = $.parseJSON(data);
						if(chardata.success == "imported"){
							successdata = "<span style=\"color:green;\">'.$this->game->glang('uc_armory_updated').'</span>";
						}else{
							successdata = "<span style=\"color:red;\">'.$this->game->glang('uc_armory_updfailed').'<br/>"+
							((chardata.error) ? "'.$this->game->glang('uc_armory_impfail_reason').' "+chardata.error : "")+"</span>";
						}
						$("#guildimport_dataset fieldset.data").prepend("<dl><dt><label><img src=\""+ chardata.image +"\" alt=\"charicon\" height=\"84\" width=\"84\" /></label></dt><dd>"+ chardata.name+"<br/>"+ successdata +"</dd></dl>").children(":first").hide().fadeIn("slow");
						$("#progressbar").progressbar({ value: ((i/chardataArry.length)*100) })
						if(chardataArry.length > i+1){
							getData(i+1);
						}else{
							$.post("charimporter.php'.$this->SID.'&ajax_mudate=true");
							$("#controlbox").html("<dl><div class=\"greenbox roundbox\"><div class=\"icon_ok\" id=\"error_message_txt\">'.$this->game->glang('uc_cupdt_header_fnsh').'</div></div></dl>").fadeIn("slow");
							return;
						}
					});
				}
			}
			
			$( "#progressbar" ).progressbar({ value: 0 }); getData();
			');

		$this->tpl->assign_vars(array(
			'DATA'		=> $hmtlout,
			'STEP'		=> ''
		));

		$this->core->set_vars(array(
			'page_title'		=> $this->user->lang('raidevent_raid_guests'),
			'header_format'		=> 'simple',
			'template_file'		=> 'importer.html',
			'display'			=> true
		));
	}

	public function ajax_massupdatedate(){
		$this->config->set(array('uc_profileimported'=> $this->time->time));
	}

	public function ajax_massupdate(){
		$char_server	= $this->pdh->get('member', 'profile_field', array($this->in->get('charid', 0), 'servername'));
		$servername		= ($char_server != '') ? $char_server : $this->config->get('servername');
		$chardata	= $this->game->obj['daybreak']->character($this->in->get('charname', ''), $servername, true);

		if(!isset($chardata['status'])){
			$errormsg	= '';
			$cdata 		= $chardata['character_list'][0];
			$charname	= $cdata['name']['first'];
			
			$arrUpdateData = array(
				'name'				=> $this->in->get('charname', ''),
				'level'				=> $cdata['type']['level'],
				'gender'			=> $this->in->get('gender', 'male'),
				'gender'            => ucfirst($cdata['type']['gender']),
				'race'				=> $this->game->obj['daybreak']->ConvertID($cdata['type']['raceid'], 'int', 'races'),
				'class'				=> $this->game->obj['daybreak']->ConvertID($cdata['type']['classid'], 'int', 'classes'),
				'guild'				=> $cdata['guild']['name'],
				'picture'			=> $cdata['id'],
			);
			$charicon	= $this->game->obj['daybreak']->characterIcon($cdata['id']);
			if ($charicon == "") $charicon	= $this->server_path.'images/global/avatar-default.svg';
			
			// insert into database
			$info		= $this->pdh->put('member', 'addorupdate_member', array($this->in->get('charid', 0), $arrUpdateData, $this->in->get('overtakeuser')));
			$this->pdh->process_hook_queue();
			$successmsg	= ($info) ? 'imported' : 'error';
		}else{
			$successmsg	= 'error';
			$errormsg	= $chardata['reason'];
			$charname	= $this->in->get('charname', '');
			$charicon	= $this->server_path.'images/global/avatar-default.svg';
		}

		die(json_encode(array(
			'image'		=> $charicon,
			'name'		=> $charname,
			'success'	=> $successmsg,
			'error'		=> $errormsg
		)));
	}

	public function perform_step0(){
		$tmpmemname = '';
		if($this->in->get('member_id', 0) > 0){
			$tmpmemname = $this->pdh->get('member', 'name', array($this->in->get('member_id', 0)));
		}

		// generate output
		$hmtlout = '<fieldset class="settings mediumsettings">
			<dl>
				<dt><label>'.$this->game->glang('uc_charname').'</label></dt>
				<dd>'.new htext('charname', array('value' => (($tmpmemname) ? $tmpmemname : ''), 'size' => '25')).'</dd>
			</dl>';
		
		// Server Name
		$hmtlout .= '<dl>
				<dt><label>'.$this->game->glang('servername').'</label></dt>
				<dd>';
		if($this->config->get('uc_lockserver') == 1){
			$hmtlout .= ' @'.stripslashes($this->config->get('servername')).'<br/>';
			$hmtlout .= new hhidden('servername', array('value' => (($this->config->get('servername')) ? stripslashes($this->config->get('servername')) : '')));
		}else{
			$hmtlout .= new htext('servername', array('value' => (($this->config->get('servername')) ? stripslashes($this->config->get('servername')) : ''), 'size' => '25', 'autocomplete' => $this->game->get('realmlist')));
		}
		$hmtlout .= '</dd>
			</dl>';
		
		$hmtlout .= '</fieldset>';
		$hmtlout .= '<br/><button type="submit" name="submiti"><i class="fa fa-download"></i> '.$this->game->glang('uc_import_forw').'</button>';
		return $hmtlout;
	}

	public function perform_step1(){
		$hmtlout = '';
		if($this->in->get('member_id', 0) > 0){
			// We'll update an existing one...
			$isindatabase	= $this->in->get('member_id', 0);
			$isMemberName	= $this->pdh->get('member', 'name', array($isindatabase));
			$isServerName	= $this->config->get('servername');
			$is_mine		= ($this->pdh->get('member', 'userid', array($isindatabase)) == $this->user->data['user_id']) ? true : false;
		}else{
			// Check for existing member name
			$isindatabase	= $this->pdh->get('member', 'id', array($this->in->get('charname'), array('servername' => $this->in->get('servername'))));
			$hasuserid		= ($isindatabase > 0) ? $this->pdh->get('member', 'userid', array($isindatabase)) : 0;
			$isMemberName	= $this->in->get('charname');
			$isServerName	= $this->in->get('servername');
			if($this->user->check_auth('a_charmanager_config', false)){
				$is_mine	= true;			// We are an administrator, its always mine..
			}else{
				$is_mine	= (($hasuserid > 0) ? (($hasuserid == $this->user->data['user_id']) ? true : false) : true);	// we are a normal user
			}
		}

		if($is_mine){
			// Load the Armory Data
			$chardata	= $this->game->obj['daybreak']->character($isMemberName, $isServerName, true);
			$cdata = $chardata['character_list'][0];

			// Basics
			$hmtlout	.= new hhidden('member_id', array('value'=>$isindatabase));
			$hmtlout	.= new hhidden('member_name', array('value'=>$isMemberName));
			$hmtlout	.= new hhidden('member_level', array('value'=>$cdata['type']['level']));
			$hmtlout	.= new hhidden('gender', array('value' => ucfirst($cdata['type']['gender'])));
			$hmtlout	.= new hhidden('member_race_id', array('value'=>$this->game->obj['daybreak']->ConvertID((int)$cdata['type']['raceid'], 'int', 'races')));
			$hmtlout	.= new hhidden('member_class_id', array('value'=>$this->game->obj['daybreak']->ConvertID((int)$cdata['type']['classid'], 'int', 'classes')));
			$hmtlout	.= new hhidden('guild', array('value'=>$cdata['guild']['name']));
			$hmtlout	.= new hhidden('picture', array('value'=>$cdata['id']));
			$hmtlout	.= new hhidden('servername', array('value' => $cdata['locationdata']['world']));
			
			
			// viewable Output
			if(!isset($chardata['status'])){
				$charicon = $this->game->obj['daybreak']->characterIcon($cdata['id']);
				if ($charicon == "") $charicon = $this->server_path.'images/global/avatar-default.svg';
				$hmtlout	.= '
				<div class="infobox infobox-large infobox-red clearfix">
					<i class="fa fa-exclamation-triangle fa-4x pull-left"></i> '.$this->game->glang('uc_charfound3').'</div>
				</div>

				<fieldset class="settings mediumsettings">
					<dl>
						<dt><label><img src="'.$charicon.'" name="char_icon" alt="icon" height="100" align="middle" /></label></dt>
						<dd>
							'.sprintf($this->game->glang('uc_charfound'), $isMemberName).'
						</dd>
					</dl>
					<dl>';
				if(!$isindatabase){
					if($this->user->check_auth('u_member_conn', false)){
						$hmtlout	.= '<dt>'.$this->user->lang('overtake_char').'</dt><dd>'.new hradio('overtakeuser', array('value' => 1)).'</dd>';
					}else{
						$hmtlout	.= '<dt>'.$this->user->lang('overtake_char').'</dt><dd>'.new hradio('overtakeuser', array('value' => 1, 'disabled' => true)).'</dd>';
						$hmtlout	.= new hhidden('overtakeuser', array('value' => '1'));
					}
				}
				$hmtlout	.= '
					</dl>
					</fieldset>';
				$hmtlout		.= '<center>
										<button type="submit" name="submiti"><i class="fa fa-refresh"></i> '.$this->game->glang('uc_prof_import').'</button>
									</center>';
			}else{
				$hmtlout		.= '<div class="errorbox roundbox">
										<i class="fa fa-exclamation-triangle fa-4x pull-left"></i><b>WARNING: </b> '.$chardata['reason'].'</div>
									</div>';
			}
		}else{
			$hmtlout	.= '<div class="errorbox roundbox">
								<i class="fa fa-exclamation-triangle fa-4x pull-left"></i>'.$this->game->glang('uc_notyourchar').'</div>
							</div>';
		}
		return $hmtlout;
	}

	public function perform_step2(){
		$data = array(
			'name'				=> $this->in->get('member_name'),
			'level'				=> $this->in->get('member_level', 0),
			'gender'			=> $this->in->get('gender', 'male'),
			'race'				=> $this->in->get('member_race_id', 0),
			'class'				=> $this->in->get('member_class_id', 0),
			'guild'				=> $this->in->get('guild',''),
			'picture'			=> $this->in->get('picture',''),
			'servername'		=> $this->in->get('servername', ''),
		);
		$info		= $this->pdh->put('member', 'addorupdate_member', array($this->in->get('member_id', 0), $data, $this->in->get('overtakeuser')));
		$this->pdh->process_hook_queue();
		if($info){
			$hmtlout	= '<div class="infobox infobox-large infobox-green clearfix">
								<i class="fa fa-check fa-4x pull-left"></i> '.$this->game->glang('uc_armory_updated').'
							</div>';
		}else{
			$hmtlout	= '<div class="infobox infobox-large infobox-red clearfix">
								<i class="fa fa-exclamation-triangle fa-4x pull-left"></i> '.$this->game->glang('uc_armory_updfailed').'
							</div>';
		}
		return $hmtlout;
	}

	public function display(){
		$stepnumber		= ($this->config->get('servername') && $this->config->get('uc_server_loc') && $this->in->get('member_id',0) > 0 && $this->in->get('step',0) == 0) ? 1 : $this->in->get('step',0);
		$urladdition	 = ($this->in->get('member_id',0)) ? '&amp;member_id='.$this->in->get('member_id',0) : '';
		$funcname		 = 'perform_step'.$stepnumber;
		$this->tpl->assign_vars(array(
			'DATA'		=> $this->$funcname(),
			'STEP'		=> ($stepnumber+1).$urladdition
		));

		$this->core->set_vars(array(
			'page_title'		=> $this->user->lang('raidevent_raid_guests'),
			'header_format'		=> 'simple',
			'template_file'		=> 'importer.html',
			'display'			=> true
		));
	}
}

registry::register('charImporter');
?>
