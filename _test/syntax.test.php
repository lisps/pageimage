<?php
class syntax_plugin_pageimage_test extends DokuwikiTest {
    protected $pluginsEnabled = array('pageimage');
    
    public function test_metadata() {
        saveWikiText('pageimage:page','~~PAGEIMAGE:pageimage:png~~','Test setup');
        $this->assertEquals('pageimage:png',p_get_metadata('pageimage:page','pageimage'));
    }
    public function test_xhtml() {
        $xhtml = p_render('xhtml', p_get_instructions('~~PAGEIMAGE:pageimage:png~~'), $info);
        $this->assertEquals($xhtml,'');
    }
    

}