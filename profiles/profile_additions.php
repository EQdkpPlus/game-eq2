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
	
	$this->game->new_object('eq2_soe', 'soe', array());
	$chardata = $this->game->obj['soe']->character($member['name'],$this->config->get('uc_servername'));
	$mincrit = $this->config->get('uc_critchance');
	$name = ($member['name']);
	$classname = $chardata['character_list'][0]['type']['class'];
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
    background: url("./games/eq2/profiles/images/xpbar-overlay.png") repeat-x scroll 0 0 transparent;
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
			$second_tradeskill .= $this->jquery->ProgressBar('second_tradeskill'.$key, ((int)$value['totalvalue'] / (int)$value['maxvalue'])*100, ucfirst($key).' ('.$value['totalvalue'].')');
		}
		$this->tpl->assign_vars(array(
			'ARMORY' 		=> 1,
			'CHAR_IMGURL'		=> $this->game->obj['soe']->imgurl,
			'DATA_TRADESKILL'	=> ucfirst($tradeskill_keys[0]).' ('.$cdata['tradeskills'][$tradeskill_keys[0]]['level'].')',
			'DATA_TRADESKILL_LEVEL' => $cdata['tradeskills'][$tradeskill_keys[0]]['level'],
			'DATA_LEVEL_XP'		=> ((int)$cdata['experience']['currentadventureexp'] == 0) ? 0 : intval(((float)$cdata['experience']['currentadventureexp'] / (float)$cdata['experience']['adventureexpfornextlevel'])*100),
			'DATA_TRADESKILL_XP'=> ((int)$cdata['experience']['currenttradeskillexp'] == 0) ? 0 : intval(((float)$cdata['experience']['currenttradeskillexp'] / (float)$cdata['experience']['tradeskillexpfornextlevel'])*100),
			'DATA_SECOND_TRADESKILL' => $second_tradeskill,
			'DATA_AA'	=> ((int)$cdata['alternateadvancements']['spentpoints'] + (int)$cdata['alternateadvancements']['availablepoints']).' ('.$cdata['alternateadvancements']['availablepoints'].' unspent)',
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
			
			$this->tpl->assign_block_vars('skill_list', array(
				'BAR' => $this->jquery->ProgressBar('skills_'.$key, ((int)$value['totalvalue'] / $maxvalue)*100, $value['totalvalue'].' / '.$maxvalue),
				'NAME'=> ucfirst($key),
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
		$debuffspells = array('674390489','1616154856','2917802350','612359111');
		$singularfocus = array('2662824675');
		 //Check to see if they are fully mastered
		switch ($classname) {
				case 'Assassin':
				$masterlist = array('1453406069','1686234490','4143866989','2116541508','2375826539','3918805587','53657533',
									'3063815025','3322295378','559267019','1870985557','3933781394','4172879647','115624088',
									'1431390603','3065566163','1568322744','3872745732','2400631208','409782401','4031531557',
									'3659969272','2943093501','365635789','2023055300','671716104','2338977299','1136546862',
									'508434033','3444832254','117087927','4171072125','2813366152','1372905345','203726302',
									'3745086545','344986904'); $mastertot = 33;
				$erspells = array('593450753'); $ericon1 = 383; $erbakg1 = 317;
				break;	
				case 'Beastlord':
				$masterlist = array('1699421107','3366093024','942636371','2300990911','642755573','671716104','3072116773',
									'2886613766','2605506064','874848346','2775991178','3194269865'); $mastertot = 8;
				$erspells = array('3062851873'); $ericon1 = 271; $erbakg1 = 317;
				break;
				case 'Berserker':
				$masterlist = array('2190191535','2775840022','3681847822','1320722687','2618212180','2532058666','793976734',
									'2742342729','3832261779','3962904685','3892329353','1694657011','3995260361','229307064',
									'1647900257','3382927152','3058114344','4067738756','1049603204','2377366066','448258152',
									'2289904256','3136784723','2611958259','2033357160','3002474978','995205922','3854661406',
									'1683811659','3812284690','1233484916','1418449198','2210328891','1501729352','3245071695',
									'1645137928','4155243697','1542453211','1273502183','1885625255'); $mastertot = 36;
				$erspells = array('2357709831','908867871'); $ericon1 = 296; $erbakg1 = 317; $ericon2 = 681; $erbakg2 = 317;
				break;
				case 'Brigand':
				$masterlist = array('150953895','3105517585','494251951','2899313942','480481134','1513209734','3549678872',
									'92829755','2513181280','2631287422','1832311015','3616300008','3787083348','1986729368',
									'1732534520','1080450929','2477689418','2577164397','1032009519','1377117173','340618273',
									'2580935479','383941968','3270374386','671716104','4068809236','4115517124','1195442535',
									'4045265799','2232321870','3274264237','2138230862','3245524561','803847296','76084991',
									'3773796795','746530014'); $mastertot = 33;
				$erspells = array('660714803'); $ericon1 = 337; $erbakg1 = 317;
				break;
				case 'Bruiser':
				$masterlist = array('2775840022','3681847822','278176474','2702580466','1785462639','2068379556','976122805',
									'3703693461','858138846','2245917452','3514310661','1719017968','2211541560','2817612809',
									'1678675668','1412851135','4790752','3128695678','2105428185','3627957298','2346027542',
									'1443053443','3814895358','3030886008','3629869544','2543302118','1142568362','1312254819',
									'425090688','3975154568','3007134674','2264401653','1608665821','1422920642','1903130610',
									'4258537544','1549656268','2706878589','1186627693','1661336669'); $mastertot = 36;
				$erspells = array('325090821','525825229'); $ericon1 = 664; $erbakg1 = 317; $ericon2 = 327; $erbakg2 = 317;
				break;
				case 'Channeler':
				$masterlist = array('1967992241','2381793860','3518171711','1592172885','3432082492','2544306066','1992001547',
									'2883155794','3954314227','4191715420','1507366243','4250142795','747707187','1056673948',
									'3451741558','3755470553'); $mastertot = 12;
				$erspells = array('320684470','1302094268'); $ericon1 = 220; $erbakg1 = 314; $ericon2 = 42; $erbakg2 = 317;
				break;
				case 'Coercer':
				$masterlist = array('948198458','3443185326','1998517305','2467104654','3768290845','3224247923','373906512',
									'1055998171','3317897376','710873371','354375561','4040163155','1041605889','3723063385',
									'4013310459','1837296668','2582296461','191612031','1044837178','640974764','3334003744',
									'1751701698','3187910788','564444822','575477883','1622104196','2931572620','3741510047',
									'976706810','2275657315','620447696','1485727934','3618214671','869152057','807900116',
									'1925567275','3881149347'); $mastertot = 32;
				$erspells = array('472410880','513612011'); $ericon1 = 15; $erbakg1 = 317; $ericon2 = 5; $erbakg2 = 316;
				break;
				case 'Conjuror':
				$masterlist = array('2552239724','1453588213','1105864787','3282363166','3679906792','251725371','2050006326',
									'1295280074','3504467181','294347220,','1339981796','2859711955','317641156','29997037',
									'137995618','3193793238','2967858370','541022022','2609294917','1306440334','3212102720',
									'670850266','174389920','1407969806','3488474811','811055728','1776244389','2009272454',
									'1038614366','1297667344','3563279974','990015218','1645622041','899078005','1098998177',
									'3766812679'); $mastertot = 32;
				$erspells = array('1720755111'); $ericon1 = 234; $erbakg1 = 317;
				break;
				case 'Defiler':
				$masterlist = array('4095272222','2510973408','3588784074','655303293','2102005549','693433631','3756619889',
									'188849249','531441183','209803606','1881122378','200336570','3521133146','2460494031',
									'108750685','549209957','1093117460','2171063613','488942432','2294710725','3477534953',
									'2696735009','3448961836','75170683','2681914822','217731034','234694682','2898440734',
									'2879614678','1809325109','3528340823','1755208822','1221105337','2377141865','1652471925',
									'3065701228','2062866393'); $mastertot = 32;
				$erspells = array('2597294319','2168916173'); $ericon1 = 279; $erbakg1 = 312; $ericon1 = 913; $erbakg1 = 317;
				break;
				case 'Dirge':
				$masterlist = array('374146049','2068542589','2762628819','2203703656','745269540','748220944','3198686968',
									'492763852','4248646169','2709908785','1084967496','2540955172','2710508371','3728463248',
									'384550447','783113970,','953210131','1812489834','250889484','4093793306','1693513230',
									'14105723','1373280585','1769897033','671716104','2167110489','1969965946','3672201438',
									'945558293','852416378','2454234077','425523306','342025076','1763835858','2064971750',
									'3846106188','547642581','1328176260'); $mastertot = 33;
				$erspells = array('2976474773'); $ericon1 = 171; $erbakg1 = 317;
				break;
				case 'Fury':
				$masterlist = array('3449288156','1860053195','3014985370','416122633','1553157192','2315964827','1501424726',
									'1984410697','2774561315','2599561102','1006744701','142898705','2075183664','3546033597',
									'308609626','1602526362','558446914','3854258734','1402946393','1160442794','1137803472',
									'2701666700','410481078','1248632348','974112147','2963239239','4171753676','2482744716',
									'1217492253','3965980226','4046254684','1029073507','3306524399','3939328867','2173773347',
									'4262364653'); $mastertot = 32;
				$erspells = array('2672801118','571579967'); $ericon1 = 550; $erbakg1 = 317; $ericon2 = 274; $erbakg2 = 316;
				break;
				case 'Guardian':
				$masterlist = array('2775840022','3681847822','1320722687','2400433333','1947189268','4183771973','1114048068',
									'3199744349','3925583560','2304340642','423891577','3425508908','3881979458','949412667',
									'3551112644','678690677','828174539','2601234634','3529968074','4083809958','3178844355',
									'3648562469','273106226','2546708198','2417559275','1567366746','1004084055','4099363439',
									'2059091809','2680958379','1214636800','2239259974','2210069093','3168121498','2590808070',
									'1985397823','2899489522','1325831669','1510959279','2534600425','1681674128'); $mastertot = 36;
				$erspells = array('306666685'); $ericon1 = 844; $erbakg1 = 317;
				break;
				case 'Illusionist':
				$masterlist = array('1713946446','899371952','3192891295','592026828','1532979923','3270025556','920568156',
									'414912318','2726468669','60771531','2530833279','124820392','760320393','1184094200',
									'121980286','2940245974','3673821902','2890432675','1113054218','2048586239','575477883',
									'2476843508','743965023','2318782747','222774239','2661860793','2085093685','461132047',
									'3010082920','3539436977','312318730','807900116','2177575515','2556385972','16191653'); $mastertot = 31;
				$erspells = array('2719301397'); $ericon1 = 266; $erbakg1 = 317;
				break;
				case 'Inquisitor':
				$masterlist = array('1701415318','699597965','2739024255','3392360509','381343863','3989337504',
									'980278319','239092409','3227568034','624570797','1320940574','1188409877',
									'4100925540','2224245149','2221862792','2433048882','3882719968','1572727380',
									'1539187283','997875635','3810383344','2747090881','1532190303','368134240',
									'4138572522','2674635082','1716528910','2179272000','2000493986','3920412480',
									'1849495000','3417787764','735012275','1107906067','1700238861','885932057'); $mastertot = 32;
				$erspells = array('85761225','382126813'); $ericon1 = 623; $erbakg1 = 317; $ericon2 = 800; $erbakg2 = 317;
				break;
				case 'Monk':
				$masterlist = array('2775840022','3681847822','48030475','2702580466','1079097575','1854840526',
									'2672186702','3703693461','1366732208','3621454048','3787370852','1898362059',
									'1894707440','2297144478','545945437','2524254891','1828784042','4046054878',
									'95982861','4159695561','1870809397','2010037710','2612102268','3876019993',
									'899995317','517194721','1207499654','2834504209','468606873','3975154568',
									'422632157','2722196221','1369938808','451806777','705683262','667835674',
									'3130626494','159700022','3347904864'); $mastertot = 35;
				$erspells = array('1463331340'); $ericon1 = 755; $erbakg1 = 317;
				break;
				case 'Mystic':
				$masterlist = array('4095272222','3363260414','3600914638','445612857','1713481164','3219048642',
									'3377112048','3356451995','3532624791','1892255892','1302597704','3579296099',
									'154386308','1609765880','1919070089','1612593034','2141126960','2929325500',
									'3337784511','4188677344','1548309567','3650407097','1594316418','4205592441',
									'1021857575','2265687295','1194462728','1801854257','769138567','3907873976',
									'172634914','1742126865','3659385937','1431864743','1068667944','4203210519',
									'404797581'); $mastertot = 32;
				$erspells = array('2290136341','2657181028'); $ericon1 = 616; $erbakg1 = 317; $ericon1 = 175; $erbakg1 = 315;
				break; 
				case 'Necromancer':
				$masterlist = array('641788400','4288476226','403765746','1923973489','3655182118','4069568153',
									'506273793','378943683','4125959213','4229081299','96276611','3782754918',
									'2936048378','1467549722','1628684695','4238885445','2550997064','1990476105',
									'1458575439','1337250501','3166499458','1970396761','1141480874','3031129665',
									'1723281354','4067608611','174389920','3999769260','1775684870','2807379819',
									'371770028','1524632572','875851064','3271587184','2632587845','1960682597',
									'1709664975','4228720899','2075936425'); $mastertot = 35;
				$erspells = array('3039617986'); $ericon1 = 234; $erbakg1 = 317;
				break; 
				case 'Paladin':
				$masterlist = array('2775840022','3681847822','189102944','3190248181','1270915978','426499337',
									'2567734333','1191452826','3192485489','3674570910','85317579','286089335',
									'2482869324','2044076300','1094347775','177379043','447249095','638869806',
									'2965171613','931541693','2456639365','2743677076','297332951','2805070032',
									'218488568','157380336','272549058','3125524325','4121790241','1353710620',
									'2496109355','430296129','1762497707','1394292778','3852705892','453764447',
									'2259488900','2070355716','1097970565'); $mastertot = 35;
				$erspells = array('449915658','3279286219'); $ericon1 = 158; $erbakg1 = 317; $ericon2 = 266; $erbakg2 = 317;
				break;
				case 'Ranger':
				$masterlist = array('1453406069','94078495','2365829432','1022852822','4134567904','173869474',
									'3102653297','2968936453','3130860302','1815610727','2881360760','927728825',
									'1332473904','3136328197','517530027','3065566163','3910007855','1166683564',
									'3217017106','1290651187','2348297596','3983962533','3311204935','3746973073',
									'1492954649','671716104','3198020099','1645084658','1327576069','2975729347',
									'1831874158','724375644','343833341','2121370363','2674473623','2901893548',
									'1885828189','2738130284','102035794'); $mastertot = 34;
				$erspells = array('509781089'); $ericon1 = 685; $erbakg1 = 317;
				break;
				case 'Shadowknight':
				$masterlist = array('2775840022','3681847822','1422530248','557338756','911981027','3565918682',
									'2096641441','3129489990','287742276','4228557782','1691111311','2248150946',
									'2872181634','3941050122','718698738','910883666','2865151289','295415029',
									'2586449741','1197427393','2462336288','3185284599','297332951','1762544908',
									'3689766879','3422174648','3367349935','1888367581','2871143113','4121790241',
									'446325567','287578495','821130735','3249118014','1637984340','2917977220',
									'150005904','55481040','3985869494'); $mastertot = 35;
				$erspells = array('3182003177','792904718'); $ericon1 = 224; $erbakg1 = 315; $ericon2 = 614; $erbakg2 = 317;
				break;
				case 'Swashbuckler':
				$masterlist = array('150953895','4108870270','1966473046','2899313942','3295446599','3564373484',
									'1373185924','4197485690','1585726756','1846754474','3013475609','55211649',
									'2791083921','2772042797','1986729368','2345709301','1406830467','4214975398',
									'1777862184','2754641298','2480913067','1769925793','56844656','2625351640',
									'1039148954','671716104','515637323','3978574085','1485482030','3117169768',
									'514161855','1899925795','3942625682','3590721000','2064934670','798665781',
									'4283347626','4170529341'); $mastertot = 33;
				$erspells = array('1273618570'); $ericon1 = 377; $erbakg1 = 317;
				break;
				case 'Templar':
				$masterlist = array('621873619','935985479','2271642294','1094880812','4231920873','538451197',
									'2711779308','910374714','3801277473','3034676273','3714620613','580580313',
									'3026561604','3881579177','4177799239','1580142315','2732122827','2581730298',
									'882410660','58527357','1539187283','3489376158','325851837','2388513452',
									'333009219','2254923368','2172922967','1659822935','3074964704','1289651823',
									'2839712237','2483940807','1558631182','1887725816','2770515791'); $mastertot = 31;
				$erspells = array('2758923289','2775781479'); $ericon1 = 664; $erbakg1 = 317; $ericon2 = 272; $erbakg2 = 316;
				break; 
				case 'Troubador':
				$masterlist = array('3625781823','3182595113','3012461877','600000602','573868519','1723921947',
									'20198715','2304377495','1558428323','1348874865','13466809','2710508371',
									'4240149877','625158885','2487804046','4276338901',' 3604410421','4217443217',
									'3916521809','1693513230','2648040040','2013737458','1817772494','125755892',
									'1769897033','671716104','2971585535','1760694477','2175037242','4070880457',
									'848292028','130213958','1768496346','2488069032','2742304848','2056821602',
									'3771613030','2063832949'); $mastertot = 34;
				$erspells = array('698807671'); $ericon1 = 174; $erbakg1 = 317;
				break;
				case 'Warden':
				$masterlist = array('1512898123','3968187506','2640979113','1784877756','1519555691','1396759801','3533360000',
									'979391768','1387445752','4291750267','64758322','880358737','541175193','3110219055',
									'132069181','79279751','2413940865','1137803472','1253700938','207973897','696637667',
									'4047948490','4128256942','2158563993','589306776','1554647037','2873557204','2669034325',
									'2417236906','3437825167','2290128971','740570515','826970167','1321241682','3106769787',
									'2189332485'); $mastertot = 31;
				$erspells = array('1636577504','3803106182'); $ericon1 = 609; $erbakg1 = 317; $ericon2 = 188; $erbakg2 = 316;
				break;
				case 'Warlock':
				$masterlist = array('3512703758','1588881681','2415403886','707859362','3446830952','987918651','913319044',
									'1416254343','464380402','2328229655','1538689620','2468048335','1237346971','1683403005',
									'2811962234','2168966670','3577884651','3978368363','4153015074','2210022155','4006522412',
									'2762622654','3774532200','917040151','1459346956','2394624332','4106745320','1629685291',
									'4188516558','2707818024','846004811','2881837088','4069540295','2630982371','698682033',
									'3003944327'); $mastertot = 32;
				$erspells = array('21416893','102736953'); $ericon1 = 239; $erbakg1 = 317; $ericon2 = 732; $erbakg2 = 317;
				break;
				case 'Wizard':
				$masterlist = array('844439794','200799944','1779220149','7615733','811393340','4009816454','1984787231',
									'3168177206','4230786666','2727144672','3570942586','309362354','981190753','1177255',
									'90370354','3328219092','956915119','3865902449','2762622654','3030884362','2742347269',
									'668939375','2652936100','1087960202','1249785521','1241389972','1566486683','3085741189',
									'2816525445','3698481917','4042001522','1774542675','2353667083','3457732946','3800467421'); $mastertot = 31;
				$erspells = array('2840893721'); $ericon1 = 41; $erbakg1 = 317;
				break;
				}		   
		$mastermatch = count(array_intersect($masterlist, $arrTmpSpells));
		$mastered = ($mastermatch / $mastertot)*100;
		$master = floor($mastered);
		if ($master == 100) { $mmark = 'good'; }
		if ($master < 100) { $mmark = 'bad'; }
		 //Check to see if they completed Epic Repercussions
		$er = count(array_intersect($erspells, $arrTmpSpells));
		if ($er >= 1 ) { ($ercheck = 'Epic Repercussions Completed'); }
		if ($er == 0 ) { ($ercheck = 'Epic Repercussions NOT Completed'); }
		$ermatch = (array_intersect($erspells, $arrTmpSpells));
		$erlist = array_values($ermatch);
		$erico1 = 0; $erico2 = 0; $erbak1 = 0; $erbak2 = 0;
		$emark = 'bad';
		if (isset($erlist[0])) { $emark = 'good'; $erico1 = $ericon1; $erico2 = $ericon2; $erbak1 = $erbakg1; $erbak2 = $erbakg2; }
		 //ToFS X2 Debuff removed - Outdated content
		//$debuff = count(array_intersect($debuffspells, $arrTmpSpells));
		//$debuffmatch = (array_intersect($debuffspells, $arrTmpSpells));
		//if ($debuff >= 1 ) { ($debuffcheck = 'X2 Debuff Completed'); $dmark = 'good'; }
		//if ($debuff == 0 ) { ($debuffcheck = 'X2 Debuff NOT Completed'); $dmark = 'bad'; }
		//$debuffmatch = array_shift($debuffmatch);
		//if ($debuffmatch == '674390489') { ($debufficon = '918'); }	if ($debuffmatch == '1616154856') { ($debufficon = '928'); }
		//if ($debuffmatch == '2917802350') { ($debufficon = '857'); } if ($debuffmatch == '612359111') { ($debufficon = '913'); }
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
		 //Output
		if (floor((float)$cdata['stats']['combat']['critchance']) >= $mincrit) { $cmark = 'good'; }
		else { $cmark = 'bad'; }
		$this->tpl->assign_block_vars('raid_ready', array(
				'ER'     => $ercheck,
				'DEBUFF' => $debuffcheck,
				'EICONID1'  => $erico1,
				'EICONID2'  => $erico2,
				//'DICONID'   => $debufficon, //ToFS X2 Debuff Icon Removed - Outdated Content
				'DEITY'     => $deity,
				'DPIC'      => $dpic,
				'SING'      => $singularcheck,
				'SICO'      => $singularicon,
				'FDVALUE'   => (isset($fdname)) ? infotooltip($fdname, 0, false, 0, 0, 1) : '',
				'FDICONID'  => (isset($fdicon)) ? $fdicon : 0,
				'DRVALUE'   => (isset($drname)) ? infotooltip($drname, 0, false, 0, 0, 1) : '',
				'DRICONID'  => (isset($dricon)) ? $dricon : 0,
				'MASTER'    => $master,
				'EMARK'     => $emark,
				'MMARK'     => $mmark,
				'CMARK'     => $cmark,
				'DMARK'     => $dmark,
				'GMARK'     => $gmark,
				'SMARK'     => $smark,
				'MINCRIT'   => $mincrit,
			));
		$this->tpl->add_css('
			.spellbkg1{
				background: url("http://data.soe.com/s:eqdkpplus/img/eq2/icons/'.$erbak1.'/spell") no-repeat;
				float: left;
				text-align: center;
				width: 42px;
			}
			.spellbkg2{
				background: url("http://data.soe.com/s:eqdkpplus/img/eq2/icons/'.$erbak2.'/spell") no-repeat;
				float: left;
				text-align: center;
				width: 42px;
			}
			.singbkg{
				background: url("http://data.soe.com/s:eqdkpplus/img/eq2/icons/317/spell") no-repeat;
				float: left;
				text-align: center;
				width: 42px;
			}
		');
	}
?>