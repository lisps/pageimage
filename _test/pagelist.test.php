<?php
/**
 * @group plugin_pageimage
 * @group plugins
 */
class helper_plugin_pageimage_pagelist_test extends DokuwikiTest {
    protected $pluginsEnabled = array('pageimage');
    
    private $helper;
    public function setUp(){
        parent::setUp();
        $this->helper = plugin_load('helper', 'pageimage');
    }
    
    public function test_imageSet_imagemissing() {
        saveWikiText('pageimage:page','~~PAGEIMAGE:pageimage:png~~','Test setup');
        
        $image = $this->helper->td('pageimage:page');
        $this->assertEquals('',$image);
    }
    
    public function test_imageSet_imageexists() {
        saveWikiText('pageimage:page','~~PAGEIMAGE:wiki:dokuwiki-128.png~~','Test setup');

        $image = $this->helper->td('pageimage:page');
        //$this->assertContains('h=70',$image);
        $this->assertContains('media=wiki:dokuwiki-128.png',$image);
    }

}