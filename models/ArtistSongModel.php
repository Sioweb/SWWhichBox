<?php

/**
* Contao Open Source CMS
*/

namespace sioweb\contao\extensions\whishbox;
use Contao;

/*
* @file ArtistSongModel.php
* @class ArtistSongModel
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.whishbox
* @copyright Sascha Weidner, Sioweb
*/

if(!class_exists('ArtistSongModel')) {
	
class ArtistSongModel extends \Model {
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_artist_song';
}

}