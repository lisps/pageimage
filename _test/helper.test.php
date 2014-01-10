<?php
class helper_plugin_pageimage_test extends DokuwikiTest {
    protected $pluginsEnabled = array('pageimage');
    
    private $helper;
    public function setUp(){
        parent::setUp();
        $this->helper = plugin_load('helper', 'pageimage');
    }
    
    public function test_imageSet_imagemissing() {
        saveWikiText('pageimage:page','~~PAGEIMAGE:pageimage:png~~','Test setup');
        
        $imageID = $this->helper->getImageID('pageimage:page');
        $this->assertEquals('',$imageID);
    }
    
    public function test_imageSet_imageexists() {
        saveWikiText('pageimage:page','~~PAGEIMAGE:wiki:dokuwiki-128.png~~','Test setup');
        
        $imageID = $this->helper->getImageID('pageimage:page');
        $this->assertEquals('wiki:dokuwiki-128.png',$imageID);
    }
    
    public function test_image_same_as_page() {
        saveWikiText('wiki:dokuwiki-128','blorg','Test setup');
        
        $imageID = $this->helper->getImageID('wiki:dokuwiki-128');
        $this->assertEquals('wiki:dokuwiki-128.png',$imageID);
    }
    
    public function test_image_firstimage() {
        saveWikiText('pageimage:page','{{wiki:dokuwiki-128.png}}','Test setup');
        $imageID = $this->helper->getImageID('pageimage:page',array('firstimage'=>1));
        $this->assertEquals('wiki:dokuwiki-128.png',$imageID);
    }
    
    
    

    

}