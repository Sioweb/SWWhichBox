<?php

/**
* Contao Open Source CMS
*  
* @file tl_wunschbox.php
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.whishbox
* @copyright Sascha Weidner, Sioweb
*/

/**
 * Table tl_wunschbox 
 */
$GLOBALS['TL_DCA']['tl_wunschbox'] = array
(
    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'enableVersioning'            => true,
        'sql' => array (
            'keys' => array
            (
                'id' => 'primary'
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                  => 1,
            'fields'                => array('tstamp'),
            'flag'                  => 6,
            'panelLayout'           => 'sort,filter;search,limit',
        ),
        'label' => array
        (
            'fields'                  => array('Name', 'Interpret'),
            'format'                  => '<span style="color:#b3b3b3; padding-left:3px;">%s wünscht: %s'
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_wunschbox']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_wunschbox']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_wunschbox']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            )
        )
    ),

    // Palettes
    'palettes' => array(
        'default'                     => '{title_legend},Herkunft,Interpret,Lied,Anmerkungen;'
    ),


    // Fields
    'fields' => array(
        'id' => array(
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'sorting' => array(
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp' => array(
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'grantWhish' => array(
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'whishbox' => array(
            'sql'                     => "int(10) unsigned NOT NULL default '1'"
        ),
        'mainTitle' => array(
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'artistSong' => array(
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'createdAt' => array(
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'Name' => array(
            'label'                   => &$GLOBALS['TL_LANG']['tl_wunschbox']['Name'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255,'readonly'=>true,'tl_class'=>'w50 clr'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'Herkunft' => array(
            'label'                   => &$GLOBALS['TL_LANG']['tl_wunschbox']['Herkunft'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255,'readonly'=>true,'tl_class'=>'w50 clr'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'Interpret' => array(
            'label'                   => &$GLOBALS['TL_LANG']['tl_wunschbox']['Interpret'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'foreignKey'              => 'tl_artist.title',
            'eval'                    => array('maxlength'=>255,'readonly'=>true,'tl_class'=>'w50 clr'),
            'sql'                     => "varchar(255) NOT NULL default ''",
            'relation'                => array('type'=>'hasOne','load'=>'eager')
        ),
        'Lied' => array(
            'label'                   => &$GLOBALS['TL_LANG']['tl_wunschbox']['Lied'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'foreignKey'              => 'tl_song.title',
            'eval'                    => array('maxlength'=>255,'readonly'=>true,'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''",
            'relation'                => array('type'=>'hasOne','load'=>'eager')
        ),
        'Anmerkungen' => array(
            'label'                   => &$GLOBALS['TL_LANG']['tl_wunschbox']['Anmerkungen'],
            'exclude'                 => true,
            'inputType'               => 'textarea',
            'eval'                    => array('disabled'=>true,'tl_class'=>'clr long'),
                  'sql'                     => "text NULL"
        )
    )
);