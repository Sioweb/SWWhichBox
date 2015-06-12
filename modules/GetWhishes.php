<?php

/**
* Contao Open Source CMS
*/

namespace sioweb\contao\extensions\whishbox;
use Contao;

/**
* @file GetWhishes.php
* @class GetWhishes
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.whishbox
* @copyright Sascha Weidner, Sioweb
*/

class GetWhishes extends \Module {

  /**
   * Template
   * @var string
   */
  protected $strTemplate = 'mod_whishlist';

  public function generate() {
    return parent::generate();
  }

  public function generateAjax() {
    return $this->generate();
  }

  public function getNewWhiches() {
  }
  
  /**
   * Generate module
   */
  protected function compile()
  {
    global $objPage;

    $Whish = WunschboxModel::findAll(array('limit'=>10,'order'=>'id DESC'));
    if(!$Whish)
      return;

    $pageid = $objPage->id;
    if(\Input::post('pageid') != '')
      $pageid = \Input::post('pageid');

    if(method_exists($this, $this->whish_template))
      $this->{$this->whish_template}($Whish,$pageid);
  }

  private function whish_default($Whish,$pageid) {
    global $objPage;

    $Whishes = array();
    $tw = \Input::get('tw');
    while($Whish->next()){
      $whishTpl = new \FrontendTemplate($this->whish_template);
      $whishTpl->setData($Whish->row());
      $whishTpl->pageid = $pageid;

      $icon = array(
        'grants' => 'ungrant.png',
        'artistSong' => 'artistSong.png',
      );
      if($Whish->grantWhish)
        $icon['grants'] = 'grant.png';
      if($Whish->artistSong)
        $icon['artistSong'] = 'artistSongActive.png';

      $whishTpl->icon = $icon;

      $Song = $Whish->getRelated('Lied');
      if($Song)
        $whishTpl->Lied = $Song->title;
      $Artist = $Whish->getRelated('Interpret');
      if($Artist)
        $whishTpl->Interpret = $Artist->title;

      $whishTpl->createdAt = date(\Config::get('datimFormat')?\Config::get('datimFormat'):'H:i',$Whish->createdAt?$Whish->createdAt:$Whish->tstamp);

      $Whishes[] = $whishTpl->parse();
    }

    if($this->addFilter) {
      $filerTpl = new \FrontendTemplate('whish_filter');
      $this->Template->filter = $filerTpl->parse();
    }
    
    $this->Template->pageid = $pageid;
    $this->Template->whishes = $Whishes;
  }

  private function whish_toplist($Whish,$pageid) {
    
    $SecondsPerDay = (24*60*60);
    $weekday = date('w');
    $today = mktime(12,0,0,date('n'),date('j'),date('Y'));
    if($weekday == 0)
      $weekday = 7;
    $weekday -= 1;

    $time = time() - ($SecondsPerDay * 6);
    if($this->fromTo == 'last_x' && $this->topDays)
      $time = time() - ($SecondsPerDay * ($this->topDays-1));

    switch($this->fromTo) {
      case 'this_week':
        $time = $today - ($weekday*$SecondsPerDay);
        break;
      case 'this_month':
        $time = mktime(12,0,0,date('n'),1,date('Y'));
        break;
      case 'this_year':
        $time = mktime(12,0,0,1,1,date('Y'));
        break;
    }

    $Whish = $this->Database->prepare("SELECT Lied, count(1) FROM tl_wunschbox WHERE tstamp >= ? AND Lied != '' GROUP BY Lied")->execute($time);
    $Whish = WunschboxModel::findBy(array("tl_wunschbox.tstamp >= ? AND tl_wunschbox.Lied != '' AND tl_wunschbox.Lied != 54 "),array($time),array('group'=>'Lied','addSelect'=>'count(1)'));
    if(!$Whish)
      return;

    $arrWhishes = array();
    while($Whish->next()) {
      $Lied = $Whish->getRelated('Lied');
      if($Lied)
        $Whish->Lied = $Lied->title;
      $Artist = $Whish->getRelated('Interpret');
      if($Artist)
        $Whish->Interpret = $Artist->title;
      $arrWhishes[] = $Whish->row();
    }

    usort($arrWhishes,array($this,'sortToplist'));
    if($this->reverseSort)
      $arrWhishes = array_reverse($arrWhishes);
    if($this->maxEntries)
      $arrWhishes = array_slice($arrWhishes,0,$this->maxEntries);

    $parsedWhishes = array();
    foreach($arrWhishes as $key => $whish) {
      $whishTpl = new \FrontendTemplate($this->whish_template);
      $whishTpl->setData($whish);
      $parsedWhishes[] = $whishTpl->parse();
    }
    $this->Template->startDate = date(\Config::get('dateFormat')?\Config::get('dateFormat'):'m.d.Y',$time);
    $this->Template->listType = 'ol';
    $this->Template->whishes = $parsedWhishes;
  }

  private function sortToplist($a,$b) {
    return $a["count(1)"] - $b["count(1)"];
  }
}