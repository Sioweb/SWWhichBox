<?php

/**
* Contao Open Source CMS
*  
* @file tl_artist.php
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.whishbox
* @copyright Sascha Weidner, Sioweb
*/

/**
 * Table tl_artist 
 */
$GLOBALS['TL_DCA']['tl_artist'] = array
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
                'label'               => &$GLOBALS['TL_LANG']['tl_artist']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_artist']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_artist']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            )
        )
    ),

    // Palettes
    'palettes' => array(
        'default'                     => '{title_legend},title,published'
    ),


    // Fields
    'fields' => array(
        'id' => array(
            'foreignKey'              => 'tl_artist_song.aid',
            'sql'                     => "int(10) unsigned NOT NULL auto_increment",
            'relation'                => array('type'=>'hasMany','load'=>'eager','field'=>'aid')
        ),
        'sorting' => array(
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp' => array(
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'title' => array(
            'label'                   => &$GLOBALS['TL_LANG']['tl_artist']['title'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255,'readonly'=>true,'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'alias' => array(
            'label'                   => &$GLOBALS['TL_LANG']['tl_artist']['alias'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255,'readonly'=>true,'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'published' => array
        (
            'exclude'                 => true,
            'label'                   => &$GLOBALS['TL_LANG']['tl_artist']['published'],
            'inputType'               => 'checkbox',
            'eval'                    => array('doNotCopy'=>true),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
    )
);