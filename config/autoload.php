<?php

/**
* Contao Open Source CMS
*  
* @file autoload.php
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.whishbox
* @copyright Sascha Weidner, Sioweb
*/


ClassLoader::addNamespaces(array
(
	'sioweb\contao\extensions\whishbox',
	'Model'
));

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// classes
	'sioweb\contao\extensions\whishbox\Song'			=> 'system/modules/SWRadioWhishbox/classes/Song.php',
	'sioweb\contao\extensions\whishbox\Artist'			=> 'system/modules/SWRadioWhishbox/classes/Artist.php',
	'sioweb\contao\extensions\whishbox\LoadWhishes'		=> 'system/modules/SWRadioWhishbox/classes/LoadWhishes.php',
	'sioweb\contao\extensions\whishbox\Whishbox'		=> 'system/modules/SWRadioWhishbox/classes/Whishbox.php',

	// models
	'sioweb\contao\extensions\whishbox\SongModel'		=> 'system/modules/SWRadioWhishbox/models/SongModel.php',
	'sioweb\contao\extensions\whishbox\ArtistModel'		=> 'system/modules/SWRadioWhishbox/models/ArtistModel.php',
	'sioweb\contao\extensions\whishbox\ArtistSongModel'	=> 'system/modules/SWRadioWhishbox/models/ArtistSongModel.php',
	'sioweb\contao\extensions\whishbox\WunschboxModel'	=> 'system/modules/SWRadioWhishbox/models/WunschboxModel.php',

	// modules
	'sioweb\contao\extensions\whishbox\GetWhishes'		=> 'system/modules/SWRadioWhishbox/modules/GetWhishes.php',

	// Library
	'Model\QueryBuilder'		=> 'system/modules/SWRadioWhishbox/library/Contao/Model/QueryBuilder.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_whishlist'   	=> 'system/modules/SWRadioWhishbox/templates',
	'whish_default'   	=> 'system/modules/SWRadioWhishbox/templates/whish',
	'whish_toplist'   	=> 'system/modules/SWRadioWhishbox/templates/whish',
	'whish_filter'   		=> 'system/modules/SWRadioWhishbox/templates/whish',

	'mod_artists'   	=> 'system/modules/SWRadioWhishbox/templates/artists',
	'artist_default'   	=> 'system/modules/SWRadioWhishbox/templates/artists',

	'mod_songs'   		=> 'system/modules/SWRadioWhishbox/templates/songs',
	'song_default'   	=> 'system/modules/SWRadioWhishbox/templates/songs',
));
