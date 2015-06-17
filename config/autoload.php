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
	'sioweb\contao\extensions\whishbox\Song'			=> 'system/modules/Wunschbox/classes/Song.php',
	'sioweb\contao\extensions\whishbox\Artist'			=> 'system/modules/Wunschbox/classes/Artist.php',
	'sioweb\contao\extensions\whishbox\LoadWhishes'		=> 'system/modules/Wunschbox/classes/LoadWhishes.php',
	'sioweb\contao\extensions\whishbox\Whishbox'		=> 'system/modules/Wunschbox/classes/Whishbox.php',

	// models
	'sioweb\contao\extensions\whishbox\SongModel'		=> 'system/modules/Wunschbox/models/SongModel.php',
	'sioweb\contao\extensions\whishbox\ArtistModel'		=> 'system/modules/Wunschbox/models/ArtistModel.php',
	'sioweb\contao\extensions\whishbox\ArtistSongModel'	=> 'system/modules/Wunschbox/models/ArtistSongModel.php',
	'sioweb\contao\extensions\whishbox\WunschboxModel'	=> 'system/modules/Wunschbox/models/WunschboxModel.php',

	// modules
	'sioweb\contao\extensions\whishbox\GetWhishes'		=> 'system/modules/Wunschbox/modules/GetWhishes.php',

	// Library
	'Model\QueryBuilder'		=> 'system/modules/Wunschbox/library/Contao/Model/QueryBuilder.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_whishlist'   	=> 'system/modules/Wunschbox/templates',
	'whish_default'   	=> 'system/modules/Wunschbox/templates/whish',
	'whish_toplist'   	=> 'system/modules/Wunschbox/templates/whish',
	'whish_filter'   		=> 'system/modules/Wunschbox/templates/whish',

	'mod_artists'   	=> 'system/modules/Wunschbox/templates/artists',
	'artist_default'   	=> 'system/modules/Wunschbox/templates/artists',

	'mod_songs'   		=> 'system/modules/Wunschbox/templates/songs',
	'song_default'   	=> 'system/modules/Wunschbox/templates/songs',
));
