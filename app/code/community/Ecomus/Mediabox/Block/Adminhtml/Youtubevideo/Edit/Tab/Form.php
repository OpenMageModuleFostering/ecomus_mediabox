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
 * Youtube Video edit form tab
 *
 * @category    Ecomus
 * @package     Ecomus_Mediabox
 * @author      Ultimate Module Creator
 */
class Ecomus_Mediabox_Block_Adminhtml_Youtubevideo_Edit_Tab_Form
    extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * prepare the form
     * @access protected
     * @return Ecomus_Mediabox_Block_Adminhtml_Youtubevideo_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm(){
        $maxUploadSizeString = ini_get('upload_max_filesize');
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('youtubevideo_');
        $form->setFieldNameSuffix('youtubevideo');
        $this->setForm($form);
        $fieldset = $form->addFieldset('youtubevideo_form', array('legend'=>Mage::helper('ecomus_mediabox')->__('Youtube Video')));
        $fieldset->addType('file', Mage::getConfig()->getBlockClassName('ecomus_mediabox/adminhtml_youtubevideo_helper_file'));

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('ecomus_mediabox')->__('Youtube Video Title'),
            'name'  => 'title',
            'note'	=> $this->__('Title of the video'),
            'required'  => true,
            'class' => 'required-entry',

        ));

        $fieldset->addField('video_id', 'text', array(
            'label' => Mage::helper('ecomus_mediabox')->__('Youtube Video Id'),
            'name'  => 'video_id',
            'note'	=> $this->__('The Video Id on Youtube, eg aKdV5FvXLuI'),
            'required'  => true,
            'class' => 'required-entry',

        ));

        $fieldset->addField('image', 'file', array(
            'label' => Mage::helper('ecomus_mediabox')->__('Youtube Video Image'),
            'name'  => 'image',
            //'required'  => true,
            'note'	=> $this->__('Image placeholder for video. Allowed file types are .jpg, .jpeg, .gif, .png. Note max upload size is currently ').$maxUploadSizeString,

        ));
        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('ecomus_mediabox')->__('Status'),
            'name'  => 'status',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('ecomus_mediabox')->__('Enabled'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('ecomus_mediabox')->__('Disabled'),
                ),
            ),
        ));
        if (Mage::app()->isSingleStoreMode()){
            $fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_youtubevideo')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $formValues = Mage::registry('current_youtubevideo')->getDefaultValues();
        if (!is_array($formValues)){
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getYoutubevideoData()){
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getYoutubevideoData());
            Mage::getSingleton('adminhtml/session')->setYoutubevideoData(null);
        }
        elseif (Mage::registry('current_youtubevideo')){
            $formValues = array_merge($formValues, Mage::registry('current_youtubevideo')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
