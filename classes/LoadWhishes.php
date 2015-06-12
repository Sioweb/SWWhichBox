<?php

/**
* Contao Open Source CMS
*/

namespace sioweb\contao\extensions\whishbox;
use Contao;

/**
* @file LoadWhishes.php
* @class LoadWhishes
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.whishbox
* @copyright Sascha Weidner, Sioweb
*/

class LoadWhishes extends \Backend
{

	public function generate() {
		return parent::generate();
	}

	public function generateAjax() {
		return parent::generate();
	}

	public function getNewWhiches() {

		$order = array('limit'=>\Input::post('count') && is_numeric(\Input::post('count'))?\Input::post('count'):10,'order'=>'id DESC');
			if(\Input::post('limitOffset') && is_numeric(\Input::post('limitOffset')))
				$order['offset'] = \Input::post('limitOffset');

		if(\Input::post('filter') != '' && \Input::post('filter') != 'all') {
			$findBy = '';
			switch(\Input::post('filter')) {
				case 'ungrant':
					$Whish = WunschboxModel::findBy('grantWhish',0,$order);
				break;
				case 'today':
					$Whish = WunschboxModel::findBy(array('tl_wunschbox.tstamp >= ?'),array(mktime(0, 0, 0, date('m'), date('d'), date('Y'))),$order);
				break;
				case 'yesterday':
					$Whish = WunschboxModel::findBy(array('tl_wunschbox.tstamp >= ? && tl_wunschbox.tstamp <= ?'),array((mktime(0, 0, 0, date('m'), date('d'), date('Y')-86.400)),mktime(0, 0, 0, date('m'), date('d'), date('Y'))),$order);
				break;
			}
		}
		else
			$Whish = WunschboxModel::findAll($order);

		if(!$Whish)
			return;

		$Whishes = array();
		$tw = \Input::get('tw');
		while($Whish->next()){
			$whishTpl = new \FrontendTemplate('whish_default');
			$whishTpl->setData($Whish->row());
			$whishTpl->pageid = $pageid;

			$icon = array(
				'grants' => 'ungrant.png',
				'artistSong' => 'artistSong.png',
			);
			if($Whish->grantWhish)
				$icon['grants'] = 'grant.png';
			if($Whish->artistSong)
				$icon['artistSong'] = 'artistSongActive.png';

			$whishTpl->icon = $icon;

			$Song = $Whish->getRelated('Lied');
			if($Song)
				$whishTpl->Lied = $Song->title;
			$Artist = $Whish->getRelated('Interpret');
			if($Artist)
				$whishTpl->Interpret = $Artist->title;

			$whishTpl->createdAt = date(\Config::get('datimFormat')?\Config::get('datimFormat'):'H:i',$Whish->createdAt?$Whish->createdAt:$Whish->tstamp);

			$Whishes[] = $whishTpl->parse();
		}

		$wObj = new \FrontendTemplate('mod_whishlist');
		$wObj->setData(array('whishes'=>$Whishes));
		$wObj->pageid = \Input::post('pageid');

		return $wObj->parse();
	}

	public function toggleWhish() {
		$Whish = WunschboxModel::findByPk(\Input::post('whish'));
		if(!$Whish)
			return;

		if(!$Whish->grantWhish)
			$Whish->grantWhish = 1;
		else $Whish->grantWhish = 0;
		$Whish->save();

		return '<img src="system/modules/SWRadioWhishbox/assets/'.($Whish->grantWhish?'grant.png':'ungrant.png').'" title="Hier klicken um den Wunsch umzustellen" alt="Hier klicken um den Wunsch umzustellen" />';
	}

	public function toggleArtistSong() {
		$Whish = WunschboxModel::findByPk(\Input::post('whish'));
		if(!$Whish)
			return;

		$UpdateWhishes = WunschboxModel::findBy(array('Interpret = ? AND Lied = ?'),array($Whish->Interpret,$Whish->Lied));

		$ArtistSong = ArtistSongModel::findBy(array('aid = ? AND sid = ?'),array($Whish->Interpret,$Whish->Lied));
		if($ArtistSong) {
			$ArtistSong->delete();
			if($UpdateWhishes)
				while($UpdateWhishes->next()) {
					$UpdateWhishes->artistSong = 0;
					$UpdateWhishes->save();
				}
			return '<img src="system/modules/SWRadioWhishbox/assets/artistSong.png" title="Hier klicken, wenn das Lied zum Interpreten gehört." alt="Hier klicken, wenn das Lied zum Interpreten gehört." />';
		}

		$ArtistSong = new ArtistSongModel();
		$ArtistSong->aid = $Whish->Interpret;
		$ArtistSong->sid = $Whish->Lied;
		$ArtistSong->save();

		if($UpdateWhishes)
			while($UpdateWhishes->next()) {
				$UpdateWhishes->artistSong = 1;
				$UpdateWhishes->save();
			}

		return '<img src="system/modules/SWRadioWhishbox/assets/artistSongActive.png" title="Hier klicken, wenn das Lied NICHT zum Interpreten gehört" alt="Hier klicken, wenn das Lied NICHT zum Interpreten gehört." />';
	}
}