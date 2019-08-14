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
 * Youtube Video admin edit form
 *
 * @category    Ecomus
 * @package     Ecomus_Mediabox
 * @author      Ultimate Module Creator
 */
class Ecomus_Mediabox_Block_Adminhtml_Youtubevideo_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container {
    /**
     * constructor
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function __construct(){
        parent::__construct();
        $this->_blockGroup = 'ecomus_mediabox';
        $this->_controller = 'adminhtml_youtubevideo';
        $this->_updateButton('save', 'label', Mage::helper('ecomus_mediabox')->__('Save Youtube Video'));
        $this->_updateButton('delete', 'label', Mage::helper('ecomus_mediabox')->__('Delete Youtube Video'));
        $this->_addButton('saveandcontinue', array(
            'label'        => Mage::helper('ecomus_mediabox')->__('Save And Continue Edit'),
            'onclick'    => 'saveAndContinueEdit()',
            'class'        => 'save',
        ), -100);
        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
    /**
     * get the edit form header
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getHeaderText(){
        if( Mage::registry('current_youtubevideo') && Mage::registry('current_youtubevideo')->getId() ) {
            return Mage::helper('ecomus_mediabox')->__("Edit Youtube Video '%s'", $this->escapeHtml(Mage::registry('current_youtubevideo')->getTitle()));
        }
        else {
            return Mage::helper('ecomus_mediabox')->__('Add Youtube Video');
        }
    }
}
