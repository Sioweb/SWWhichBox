<?php

/**
* Contao Open Source CMS
*  
* @file config.php
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.whishbox
* @copyright Sascha Weidner, Sioweb
*/

if(TL_MODE == 'FE')
	$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/SWRadioWhishbox/assets/wunschbox.min.js';

array_insert($GLOBALS['BE_MOD']['sioweb'], 4, array(
	'whishlist' => array(
		'tables' => array('tl_wunschbox'),
		'icon' => 'system/modules/SWRadioWhishbox/assets/sioweb16x16.png'
	)
));

array_insert($GLOBALS['FE_MOD'], 4, array
(
	'whishbox' => array
	(
		'whishlist' => 'sioweb\contao\extensions\whishbox\GetWhishes'
	)
));

if(\Input::post('whishbox') == 1)
	$GLOBALS['TL_HOOKS']['storeFormData'][] = array('sioweb\contao\extensions\whishbox\Whishbox', 'handleData');

if(\Input::post('getNewWhishes') == '1')
	$GLOBALS['TL_HOOKS']['dispatchAjax'][] = array('sioweb\contao\extensions\whishbox\LoadWhishes', 'getNewWhiches');
if(\Input::post('toggleGrant') == '1')
	$GLOBALS['TL_HOOKS']['dispatchAjax'][] = array('sioweb\contao\extensions\whishbox\LoadWhishes', 'toggleWhish');
if(\Input::post('toggleArtistSong') == '1')
	$GLOBALS['TL_HOOKS']['dispatchAjax'][] = array('sioweb\contao\extensions\whishbox\LoadWhishes', 'toggleArtistSong');
if(\Input::post('getArtists') == '1')
	$GLOBALS['TL_HOOKS']['dispatchAjax'][] = array('sioweb\contao\extensions\whishbox\Artist', 'getArtists');
if(\Input::post('getSongs') == '1')
	$GLOBALS['TL_HOOKS']['dispatchAjax'][] = array('sioweb\contao\extensions\whishbox\Song', 'getSongs');
if(\Input::post('updateTypo') == '1')
	$GLOBALS['TL_HOOKS']['dispatchAjax'][] = array('sioweb\contao\extensions\whishbox\Whishbox', 'updateTypo');
