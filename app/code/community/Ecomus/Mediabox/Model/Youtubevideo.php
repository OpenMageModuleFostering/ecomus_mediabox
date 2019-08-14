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
 * Youtube Video model
 *
 * @category    Ecomus
 * @package     Ecomus_Mediabox
 * @author      Ultimate Module Creator
 */
class Ecomus_Mediabox_Model_Youtubevideo
    extends Mage_Core_Model_Abstract {
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'ecomus_mediabox_youtubevideo';
    const CACHE_TAG = 'ecomus_mediabox_youtubevideo';
    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'ecomus_mediabox_youtubevideo';

    /**
     * Parameter name in event
     * @var string
     */
    protected $_eventObject = 'youtubevideo';
    protected $_productInstance = null;
    /**
     * constructor
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function _construct(){
        parent::_construct();
        $this->_init('ecomus_mediabox/youtubevideo');
    }
    /**
     * before save youtube video
     * @access protected
     * @return Ecomus_Mediabox_Model_Youtubevideo
     * @author Ultimate Module Creator
     */
    protected function _beforeSave(){
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()){
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }
    /**
     * save youtubevideo relation
     * @access public
     * @return Ecomus_Mediabox_Model_Youtubevideo
     * @author Ultimate Module Creator
     */
    protected function _afterSave() {
        $this->getProductInstance()->saveYoutubevideoRelation($this);
        return parent::_afterSave();
    }
    /**
     * get product relation model
     * @access public
     * @return Ecomus_Mediabox_Model_Youtubevideo_Product
     * @author Ultimate Module Creator
     */
    public function getProductInstance(){
        if (!$this->_productInstance) {
            $this->_productInstance = Mage::getSingleton('ecomus_mediabox/youtubevideo_product');
        }
        return $this->_productInstance;
    }
    /**
     * get selected products array
     * @access public
     * @return array
     * @author Ultimate Module Creator
     */
    public function getSelectedProducts(){
        if (!$this->hasSelectedProducts()) {
            $products = array();
            foreach ($this->getSelectedProductsCollection() as $product) {
                $products[] = $product;
            }
            $this->setSelectedProducts($products);
        }
        return $this->getData('selected_products');
    }
    /**
     * Retrieve collection selected products
     * @access public
     * @return Ecomus_Mediabox_Resource_Youtubevideo_Product_Collection
     * @author Ultimate Module Creator
     */
    public function getSelectedProductsCollection(){
        $collection = $this->getProductInstance()->getProductCollection($this);
        return $collection;
    }
    /**
     * get default values
     * @access public
     * @return array
     * @author Ultimate Module Creator
     */
    public function getDefaultValues() {
        $values = array();
        $values['status'] = 1;
        return $values;
    }
}
