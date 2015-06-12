<?php

/**
* Contao Open Source CMS
*  
* @file tl_module.php
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.whishbox
* @copyright Sascha Weidner, Sioweb
*/

$GLOBALS['TL_LANG']['tl_module']['addFilter']         = array('Filter hinzufügen?', 'Filter für die Wunschauflistung.');
$GLOBALS['TL_LANG']['tl_module']['whish_template']    = array('Template wählen', 'Bitte wählen Sie ein passendes Template für Ihre Auflistung.');

$GLOBALS['TL_LANG']['tl_module']['fromTo']        = array('Die Top-Wünsche:', 'Bitte vervollständigen Sie den Titel. Bspw.: Die Top-Wünsche: der letzten X Tage.');
$GLOBALS['TL_LANG']['tl_module']['topDays']       = array('Tage', 'Diese Angabe wird benötigt für die Auswahl: Der letzten X Tage.');
$GLOBALS['TL_LANG']['tl_module']['maxEntries']    = array('Anzahl der Ergebnisse', 'Z.B. 10 für die Top 10');
$GLOBALS['TL_LANG']['tl_module']['reverseSort']   = array('Größtes Ergebnis zuerst?', 'Das meistgewünschte Lied an erster Stelle.');

$GLOBALS['TL_LANG']['tl_module']['filter_legend'] = 'Filter Einstellungen';

$GLOBALS['TL_LANG']['tl_module']['whish_templates'] = array(
  'whish_default' => 'Standard',
  'whish_filter'  => 'Filter',
  'whish_toplist' => 'Top-Auflistung (Bspw.: Top Ten)',
);

$GLOBALS['TL_LANG']['tl_module']['whish_fromTo'] = array(
  'last_x' => 'der letzten X Tage',
  'this_week'  => 'dieser Woche',
  'this_month'  => 'dieses Monats',
  'this_year'  => 'diesen Jahres',
);