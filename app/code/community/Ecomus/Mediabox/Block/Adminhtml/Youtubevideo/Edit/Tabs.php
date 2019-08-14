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
 * Youtube Video admin edit tabs
 *
 * @category    Ecomus
 * @package     Ecomus_Mediabox
 * @author      Ultimate Module Creator
 */
class Ecomus_Mediabox_Block_Adminhtml_Youtubevideo_Edit_Tabs
    extends Mage_Adminhtml_Block_Widget_Tabs {
    /**
     * Initialize Tabs
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct() {
        parent::__construct();
        $this->setId('youtubevideo_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('ecomus_mediabox')->__('Youtube Video'));
    }
    /**
     * before render html
     * @access protected
     * @return Ecomus_Mediabox_Block_Adminhtml_Youtubevideo_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml(){
        $this->addTab('form_youtubevideo', array(
            'label'        => Mage::helper('ecomus_mediabox')->__('Youtube Video'),
            'title'        => Mage::helper('ecomus_mediabox')->__('Youtube Video'),
            'content'     => $this->getLayout()->createBlock('ecomus_mediabox/adminhtml_youtubevideo_edit_tab_form')->toHtml(),
        ));
        if (!Mage::app()->isSingleStoreMode()){
            $this->addTab('form_store_youtubevideo', array(
                'label'        => Mage::helper('ecomus_mediabox')->__('Store views'),
                'title'        => Mage::helper('ecomus_mediabox')->__('Store views'),
                'content'     => $this->getLayout()->createBlock('ecomus_mediabox/adminhtml_youtubevideo_edit_tab_stores')->toHtml(),
            ));
        }
        $this->addTab('products', array(
            'label' => Mage::helper('ecomus_mediabox')->__('Associated products'),
            'url'   => $this->getUrl('*/*/products', array('_current' => true)),
            'class'    => 'ajax'
        ));
        return parent::_beforeToHtml();
    }
    /**
     * Retrieve youtube video entity
     * @access public
     * @return Ecomus_Mediabox_Model_Youtubevideo
     * @author Ultimate Module Creator
     */
    public function getYoutubevideo(){
        return Mage::registry('current_youtubevideo');
    }
}
