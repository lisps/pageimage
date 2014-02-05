<?php
 /**
 * DokuWiki Plugin tagfilter (Syntax Component) 
 *
 * Usage: ~~PAGEIMAGE:xxx~~
 *
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author  lisps    
 */
 
// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_LF')) define('DOKU_LF', "\n");
if (!defined('DOKU_TAB')) define('DOKU_TAB', "\t");
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

class syntax_plugin_pageimage extends DokuWiki_Syntax_Plugin {

    var $tags   = array();

    function getType() { return 'substition'; }
    function getSort() { return 305; }
    function getPType() { return 'block';}

    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('~~PAGEIMAGE:.*?~~', $mode, 'plugin_pageimage');
    }

    function handle($match, $state, $pos, Doku_Handler &$handler) {
        $image = trim(substr($match, 12, -2));     // strip markup & whitespace
        $image = cleanID($image);
        if(!$image) return false;
        return $image;
    }      

    /**
    * Render xhtml output or metadata
    *
    * @param string         $mode      Renderer mode (supported modes: xhtml and metadata)
    * @param Doku_Renderer  $renderer  The renderer
    * @param array          $data      The data from the handler function
    * @return bool If rendering was successful.
    */
    function render($mode, Doku_Renderer &$renderer, $data) {
        if ($data === false) return false;

        // XHTML output
        if ($mode == 'xhtml') {
            //$renderer->doc .= $data;
            return false;
        // for metadata renderer
        } elseif ($mode == 'metadata') {
            $renderer->meta['pageimage'] = $data;
            return true;
        }
        return false;
    }
}
// vim:ts=4:sw=4:et: 
