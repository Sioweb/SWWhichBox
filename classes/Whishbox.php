<?php

/**
* Contao Open Source CMS
*/

namespace sioweb\contao\extensions\whishbox;
use Contao;

/**
* @file Whishbox.php
* @class Whishbox
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.whishbox
* @copyright Sascha Weidner, Sioweb
*/

class Whishbox extends \Hybrid
{

	public function __construct($objElement = false, $strColumn='main') {

	}

	public function generate() {
		return parent::generate();
	}

	public function compile(){}

	public function handleData($arrSet, $formObj) {

		parent::__construct($formObj);
		if($arrSet['whishbox'] != '1' || $arrSet['mainTitle'] != '')
			return;

		$SongID = 0;
		$ArtistID = 0;
		$artistSong = 0;

		if($arrSet['Lied'] != 'Zufalls-Song?') {
			$Song = SongModel::findByAlias(standardize($arrSet['Lied']));
			if(!$Song) {
				$SongMod = new SongModel();
				$SongMod->tstamp = time();
				$SongMod->title = ucwords($arrSet['Lied']);
				$SongMod->alias = standardize($arrSet['Lied']);
				$SongMod->published = 1;
				$SongMod->save();
				$SongID = $SongMod->id;
			} else $SongID = $Song->id;
		}
		$Atrist = ArtistModel::findByAlias(standardize($arrSet['Interpret']));
		if(!$Atrist) {
			$ArtistMod = new ArtistModel();
			$ArtistMod->tstamp = time();
			$ArtistMod->title = ucwords($arrSet['Interpret']);
			$ArtistMod->alias = standardize($arrSet['Interpret']);
			$ArtistMod->published = 1;
			$ArtistMod->save();
			$ArtistID = $ArtistMod->id;
		} else {
			$ArtistID = $Atrist->id;
			$artistSong = $Atrist->getRelated('id');
		}

		if($artistSong)
			while($artistSong->next())
				if($artistSong->sid == $SongID && $artistSong->aid == $ArtistID)
					$arrSet['artistSong'] = 1;

		$arrSet['createdAt'] = time();
		$arrSet['Lied'] = $SongID;
		$arrSet['Interpret'] = $ArtistID;

		// Set the correct empty value (see #6284, #6373)
		foreach ($arrSet as $k=>$v)
			if ($v === '')
				$arrSet[$k] = \Widget::getEmptyValueByFieldType($GLOBALS['TL_DCA'][$formObj->targetTable]['fields'][$k]['sql']);

		$this->Database->prepare("INSERT INTO " . $formObj->targetTable . " %s")->set($arrSet)->execute();


		// Add a log entry
		if (FE_USER_LOGGED_IN) {
			$this->import('FrontendUser', 'User');
			$this->log('Form "' . $formObj->title . '" has been submitted by "' . $formObj->User->username . '".', __METHOD__, TL_FORMS);
		}
		else
			$this->log('Form "' . $formObj->title . '" has been submitted by ' . \System::anonymizeIp(\Environment::get('ip')) . '.', __METHOD__, TL_FORMS);

		// Check whether there is a jumpTo page
		if (($objJumpTo = $formObj->objModel->getRelated('jumpTo')) !== null) 
			$this->jumpToOrReload($objJumpTo->row());

		$this->reload();
	}

	public function updateTypo() {

		$Whishbox = \WunschboxModel::findByPk(\Input::post('whish'));
		$ArtistID = $SondID = false;
		if(\Input::post('type') == 'artist') {
			$Replace = \ArtistModel::findByAlias(standardize(\Input::post('replace')));
			$Search  = \ArtistModel::findByTitle(\Input::post('search'));

			if($Replace) {
				$Search->delete();
				$Whishbox->Interpret = $Replace->id;
			}
			else {
				if($Search && \Input::post('replace') != '') {
					$Search->title = \Input::post('replace');
					$Search->alias = standardize(\Input::post('replace'));
					$Search->save();
				}
			}
		}
		if(\Input::post('type') == 'song') {
			$Replace = \SongModel::findByAlias(standardize(\Input::post('replace')));
			$Search  = \SongModel::findByTitle(\Input::post('search'));

			if($Replace) {
				$Search->delete();
				$Whishbox->Lied = $Replace->id;
			}
			else {
				if($Search && \Input::post('replace') != '') {
					$Search->title = \Input::post('replace');
					$Search->alias = standardize(\Input::post('replace'));
					$Search->save();
				}
			}
			
		}

		$artistSong = \ArtistSongModel::findBy(array('aid = ? AND sid = ?'),array($Whishbox->Interpret,$Whishbox->Lied));
		if($artistSong)
			$Whishbox->artistSong = 1;

		$Whishbox->save();

		if(!$artistSong)
			return '<img src="system/modules/SWRadioWhishbox/assets/artistSong.png" title="Hier klicken, wenn das Lied zum Interpreten gehört." alt="Hier klicken, wenn das Lied zum Interpreten gehört." />';
		return '<img src="system/modules/SWRadioWhishbox/assets/artistSongActive.png" title="Hier klicken, wenn das Lied NICHT zum Interpreten gehört" alt="Hier klicken, wenn das Lied NICHT zum Interpreten gehört." />';
	}
}