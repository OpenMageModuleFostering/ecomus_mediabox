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
 * Youtube Video - product controller
 * @category    Ecomus
 * @package     Ecomus_Mediabox
 * @author      Ultimate Module Creator
 */
require_once ("Mage/Adminhtml/controllers/Catalog/ProductController.php");
class Ecomus_Mediabox_Adminhtml_Mediabox_Youtubevideo_Catalog_ProductController
    extends Mage_Adminhtml_Catalog_ProductController {
    /**
     * construct
     * @access protected
     * @return void
     * @author Ultimate Module Creator
     */
    protected function _construct(){
        // Define module dependent translate
        $this->setUsedModuleName('Ecomus_Mediabox');
    }
    /**
     * youtubevideos in the catalog page
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function youtubevideosAction(){
        $this->_initProduct();
        $this->loadLayout();
        $this->getLayout()->getBlock('product.edit.tab.youtubevideo')
            ->setProductYoutubevideos($this->getRequest()->getPost('product_youtubevideos', null));
        $this->renderLayout();
    }
    /**
     * youtubevideos grid in the catalog page
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function youtubevideosGridAction(){
        $this->_initProduct();
        $this->loadLayout();
        $this->getLayout()->getBlock('product.edit.tab.youtubevideo')
            ->setProductYoutubevideos($this->getRequest()->getPost('product_youtubevideos', null));
        $this->renderLayout();
    }
}
