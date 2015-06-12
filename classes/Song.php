<?php

/**
* Contao Open Source CMS
*/

namespace sioweb\contao\extensions\whishbox;
use Contao;

/**
* @file Song.php
* @class Song
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.whishbox
* @copyright Sascha Weidner, Sioweb
*/

class Song extends \Backend
{

	public function getSongs() {
		$Song = SongModel::findBy(array('title LIKE ? OR alias LIKE ?'),array('%'.\Input::post('value').'%','%'.standardize(\Input::post('value').'%')),array('order'=>'title'));
		if(!$Song)
			return;

		$modSngObj = new \FrontendTemplate('mod_songs');
		$modSngObj->class="mod_songs";

		$arrSongs = array();
		while($Song->next()) {
			$sngObj = new \FrontendTemplate('song_default');
			$sngObj->setData($Song->row());
			$arrSongs[] = $sngObj->parse();
		}

		$modSngObj->songs = $arrSongs;
		return $modSngObj->parse();
	}
}