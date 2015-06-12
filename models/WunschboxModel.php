<?php

/**
* Contao Open Source CMS
*/

namespace sioweb\contao\extensions\whishbox;
use Contao;

/*
* @file WunschboxModel.php
* @class WunschboxModel
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.whishbox
* @copyright Sascha Weidner, Sioweb
*/

if(!class_exists('WunschboxModel')) {
	
class WunschboxModel extends \Model {
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_wunschbox';
}

}