<?php
/**
 * Ecomus_Mediabox extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Ecomus
 * @package        Ecomus_Mediabox
 * @copyright      Copyright (c) 2014
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Youtube Video file field renderer helper
 *
 * @category    Ecomus
 * @package     Ecomus_Mediabox
 * @author      Ultimate Module Creator
 */
class Ecomus_Mediabox_Block_Adminhtml_Youtubevideo_Helper_File
    extends Varien_Data_Form_Element_Abstract {
    /**
     * constructor
     * @access public
     * @param array $data
     * @author Ultimate Module Creator
     */
    public function __construct($data){
        parent::__construct($data);
        $this->setType('file');
    }
    /**
     * get element html
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getElementHtml(){
        $html = '';
        $this->addClass('input-file');
        $html.= parent::getElementHtml();
        if ($this->getValue()) {
            $url = $this->_getUrl();
            if( !preg_match("/^http\:\/\/|https\:\/\//", $url) ) {
                $url = Mage::helper('ecomus_mediabox/youtubevideo')->getFileBaseUrl() . $url;
            }
            $html .= '<br /><img style="padding-top:10px;" height="56" src="'.$url.'" />';
        }
        $html.= $this->_getDeleteCheckbox();
        return $html;
    }
    /**
     * get the delete checkbox HTML
     * @access protected
     * @return string
     * @author Ultimate Module Creator
     */
    protected function _getDeleteCheckbox(){
        $html = '';
        if ($this->getValue()) {
            //$label = Mage::helper('ecomus_mediabox')->__('Delete Image');
            $html .= '<span class="delete-image">';
            //$html .= '<input type="checkbox" name="'.parent::getName().'[delete]" value="1" class="checkbox" id="'.$this->getHtmlId().'_delete"'.($this->getDisabled() ? ' disabled="disabled"': '').'/>';
            //$html .= '<label for="'.$this->getHtmlId().'_delete"'.($this->getDisabled() ? ' class="disabled"' : '').'> '.$label.'</label>';
            $html .= $this->_getHiddenInput();
            $html .= '</span>';
        }
        return $html;
    }
    /**
     * get the hidden input
     * @access protected
     * @return string
     * @author Ultimate Module Creator
     */
    protected function _getHiddenInput(){
        return '<input type="hidden" name="'.parent::getName().'[value]" value="'.$this->getValue().'" />';
    }
    /**
     * get the file url
     * @access protected
     * @return string
     * @author Ultimate Module Creator
     */
    protected function _getUrl(){
        return $this->getValue();
    }
    /**
     * get the name
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getName(){
        return $this->getData('name');
    }
}
