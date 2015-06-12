<?php

/**
* Contao Open Source CMS
*/

namespace sioweb\contao\extensions\whishbox;
use Contao;

/*
* @file ArtistModel.php
* @class ArtistModel
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.whishbox
* @copyright Sascha Weidner, Sioweb
*/

if(!class_exists('ArtistModel')) {
	
class ArtistModel extends \Model {
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_artist';
}

}