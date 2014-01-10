<?php
 /**
 * DokuWiki Plugin tagfilter (Helper Component) 
 *
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author  lisps    
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_LF')) define('DOKU_LF', "\n");
if (!defined('DOKU_TAB')) define('DOKU_TAB', "\t");

class helper_plugin_pageimage extends DokuWiki_Plugin {

    function getMethods() {
        $result = array();
        $result[] = array(
                'name'   => 'th',
                'desc'   => 'returns the header of the image column for pagelist',
                'return' => array('header' => 'image'),
                );
        $result[] = array(
                'name'   => 'td',
                'desc'   => 'returns the image of a given page',
                'params' => array('id' => 'string'),
                'return' => array('links' => 'string'),
                );

        return $result;
    }

    /**
     * @return string the column header for th pagelist Plugin
     */
    function th() {
        return $this->getLang('image');
    }

    /**
     * @param $id 
     * @return the cell data for the Pagelist Plugin
     */
    function td($id) {
        $height = $this->getConf('height');
        $width = null;
        $align = 'center';
        $ret = '';
        $src = $this->getImageID($id);
        
        if(!$src) {
            $src = $this->getConf('default_image');
            //return '';
        }
        
        list($ext,$mime,$dl) = mimetype($src);
        
        if(substr($mime,0,5) == 'image' && ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png')){
            
            $ret .= '<a href="'.wl($id).'">';
            //add image tag
            $ret .= '<img src="'.ml($src,array('w'=>$width,'h'=>$height)).'"';
            $ret .= ' class="media'.$align.'"';

            $ret .= ' style="';
            if ( !is_null($width) )
                $ret .= ' width:'.hsc($width);

            if ( !is_null($height) )
                $ret .= ' height:'.hsc($height);
            $ret .= '" ';
            $ret .= ' />';
            $ret .= '</a>';
            return $ret;
        }
    }
    
    /**
     * returns the image related to a page
     * first checks if pageimage is set,
     * if not checks if in the same namespace is an image with the same name and ipg,png,jpeg extension
     * then it checks if theres an firstimage defined 
     * ohterwise it can youse a default_image
     * 
     * @param string $id page id
     * @param array $flags possible flag is firstimage
     * @return string image id
     *
     **/
    function getImageID($id,$flags=array()){
        $src = p_get_metadata($id,'pageimage');
        if( !$src || ($src && !@file_exists(mediaFN($src))) ){
            $src = $id .'.jpg';
            if(!@file_exists(mediaFN($src))) {
                $src = $id .'.png';
                if(!@file_exists(mediaFN($src))) {
                    $src = $id .'.jpeg';
                    if(!@file_exists(mediaFN($src))) {
                        $src = p_get_metadata($id,'relation');
                        $src = $src['firstimage'];
                        if(!$flags['firstimage'] || !@file_exists(mediaFN($src))) {
                            return $this->getConf('default_image');
                        }
                    }
                }
            }
        }
        return $src;
    }

}
// vim:ts=4:sw=4:et:  
