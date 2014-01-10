<?php
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
        $this->assertGreaterThan(0,strpos($image,'h=70'));
        $this->assertGreaterThan(0,strpos($image,'media=wiki:dokuwiki-128.png'));
    }

}