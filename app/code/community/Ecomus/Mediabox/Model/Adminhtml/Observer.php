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
 * Adminhtml observer
 *
 * @category    Ecomus
 * @package     Ecomus_Mediabox
 * @author      Ultimate Module Creator
 */
class Ecomus_Mediabox_Model_Adminhtml_Observer {
    /**
     * check if tab can be added
     * @access protected
     * @param Mage_Catalog_Model_Product $product
     * @return bool
     * @author Ultimate Module Creator
     */
    protected function _canAddTab($product){
        if(!Mage::getStoreConfig('ecomus_mediabox/ecomus_mediabox/enabled')) {
            return false;
        }
        
        if ($product->getId()){
            return true;
        }
        if (!$product->getAttributeSetId()){
            return false;
        }
        $request = Mage::app()->getRequest();
        if ($request->getParam('type') == 'configurable'){
            if ($request->getParam('attributes')){
                return true;
            }
        }
        return false;
    }
    /**
     * add the youtubevideo tab to products
     * @access public
     * @param Varien_Event_Observer $observer
     * @return Ecomus_Mediabox_Model_Adminhtml_Observer
     * @author Ultimate Module Creator
     */
    public function addProductYoutubevideoBlock($observer){
        $block = $observer->getEvent()->getBlock();
        $product = Mage::registry('product');
        if ($block instanceof Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs && $this->_canAddTab($product)){
            $block->addTab('youtubevideos', array(
                'label' => Mage::helper('ecomus_mediabox')->__('Youtube Videos'),
                'url'   => Mage::helper('adminhtml')->getUrl('adminhtml/mediabox_youtubevideo_catalog_product/youtubevideos', array('_current' => true)),
                'class' => 'ajax',
            ));
        }
        return $this;
    }
    /**
     * save youtubevideo - product relation
     * @access public
     * @param Varien_Event_Observer $observer
     * @return Ecomus_Mediabox_Model_Adminhtml_Observer
     * @author Ultimate Module Creator
     */
    public function saveProductYoutubevideoData($observer){
        $post = Mage::app()->getRequest()->getPost('youtubevideos', -1);
        if ($post != '-1') {
            $post = Mage::helper('adminhtml/js')->decodeGridSerializedInput($post);
            $product = Mage::registry('product');
            $youtubevideoProduct = Mage::getResourceSingleton('ecomus_mediabox/youtubevideo_product')->saveProductRelation($product, $post);
        }
        return $this;
    }

    public function cleanVideoImagesCache()
    {
        $directory = Mage::getBaseDir('media').DS.'ec_video_images'.DS.'cache';
        $io = new Varien_Io_File();
        $io->rmdir($directory, true);

        Mage::helper('core/file_storage_database')->deleteFolder($directory);
    }
}
