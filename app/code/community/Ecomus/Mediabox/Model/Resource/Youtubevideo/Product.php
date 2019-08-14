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
 * Youtube Video - product relation model
 *
 * @category    Ecomus
 * @package     Ecomus_Mediabox
 * @author      Ultimate Module Creator
 */
class Ecomus_Mediabox_Model_Resource_Youtubevideo_Product
    extends Mage_Core_Model_Resource_Db_Abstract {
    /**
     * initialize resource model
     * @access protected
     * @see Mage_Core_Model_Resource_Abstract::_construct()
     * @author Ultimate Module Creator
     */
    protected function  _construct(){
        $this->_init('ecomus_mediabox/youtubevideo_product', 'rel_id');
    }
    /**
     * Save youtubevideo - product relations
     * @access public
     * @param Ecomus_Mediabox_Model_Youtubevideo $youtubevideo
     * @param array $data
     * @return Ecomus_Mediabox_Model_Resource_Youtubevideo_Product
     * @author Ultimate Module Creator
     */
    public function saveYoutubevideoRelation($youtubevideo, $data){
        if (!is_array($data)) {
            $data = array();
        }
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('youtubevideo_id=?', $youtubevideo->getId());
        $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

        foreach ($data as $productId => $info) {
            $this->_getWriteAdapter()->insert($this->getMainTable(), array(
                'youtubevideo_id'      => $youtubevideo->getId(),
                'product_id'     => $productId,
                'position'      => @$info['position']
            ));
        }
        return $this;
    }
    /**
     * Save  product - youtubevideo relations
     * @access public
     * @param Mage_Catalog_Model_Product $prooduct
     * @param array $data
     * @return Ecomus_Mediabox_Model_Resource_Youtubevideo_Product
     * @@author Ultimate Module Creator
     */
    public function saveProductRelation($product, $data){
        if (!is_array($data)) {
            $data = array();
        }
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('product_id=?', $product->getId());
        $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

        foreach ($data as $youtubevideoId => $info) {
            $this->_getWriteAdapter()->insert($this->getMainTable(), array(
                'youtubevideo_id' => $youtubevideoId,
                'product_id' => $product->getId(),
                'position'   => @$info['position']
            ));
        }
        return $this;
    }
}
