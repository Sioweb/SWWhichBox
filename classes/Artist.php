<?php

/**
* Contao Open Source CMS
*/

namespace sioweb\contao\extensions\whishbox;
use Contao;

/**
* @file Artist.php
* @class Artist
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.whishbox
* @copyright Sascha Weidner, Sioweb
*/

class Artist extends \Frontend
{

	public function getArtists() {
		$Artist = ArtistModel::findBy(array('title LIKE ? OR alias LIKE ?'),array('%'.\Input::post('value').'%','%'.standardize(\Input::post('value').'%')),array('order'=>'title'));
		if(!$Artist)
			return;

		$modArtObj = new \FrontendTemplate('mod_artists');
		$modArtObj->class="mod_artist";

		$arrArtists = array();
		while($Artist->next()) {
			$artObj = new \FrontendTemplate('artist_default');
			$artObj->setData($Artist->row());
			$arrArtists[] = $artObj->parse();
		}

		$modArtObj->artists = $arrArtists;
		return $modArtObj->parse();
	}
}