<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2013 Leo Feyer
 */


/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['whishlist'] = '{title_legend},name,headline,type;{filter_legend},addFilter;{toplist_legend},fromTo,topDays,maxEntries,reverseSort;{template_legend:hide},whish_template;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['whish_template'] = array
(
  'label'             => &$GLOBALS['TL_LANG']['tl_module']['whish_template'],
  'default'           => 'whish_default',
  'exclude'           => true,
  'inputType'         => 'select',
  'reference'         => $GLOBALS['TL_LANG']['tl_module']['whish_templates'],
  'options'           => $this->getTemplateGroup('whish_'),
  'eval'              => array('tl_class'=>'w50'),
  'sql'               => "varchar(128) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['fromTo'] = array
(
  'label'             => &$GLOBALS['TL_LANG']['tl_module']['fromTo'],
  'default'           => 'last_x',
  'exclude'           => true,
  'inputType'         => 'select',
  'reference'         => $GLOBALS['TL_LANG']['tl_module']['whish_fromTo'],
  'options'           => array('last_x','this_week','this_month','this_year'),
  'eval'              => array('tl_class'=>'w50'),
  'sql'               => "varchar(128) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['topDays'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_module']['topDays'],
  'default'                 => '10',
  'exclude'                 => true,
  'inputType'               => 'text',
  'search'                  => true,
  'eval'                    => array('decodeEntities'=>true, 'maxlength'=>3),
  'sql'                     => "int(20) NOT NULL default '10'"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['maxEntries'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_module']['maxEntries'],
  'exclude'                 => true,
  'inputType'               => 'text',
  'search'                  => true,
  'eval'                    => array('decodeEntities'=>true, 'maxlength'=>11),
  'sql'                     => "int(20) NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['addFilter'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addFilter'],
  'exclude'                 => true,
  'inputType'               => 'checkbox',
  'sql'                     => "char(1) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['reverseSort'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_module']['reverseSort'],
  'exclude'                 => true,
  'inputType'               => 'checkbox',
  'sql'                     => "char(1) NOT NULL default ''"
);


