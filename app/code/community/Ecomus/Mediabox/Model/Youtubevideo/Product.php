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
 * Youtube Video product model
 *
 * @category    Ecomus
 * @package     Ecomus_Mediabox
 * @author      Ultimate Module Creator
 */
class Ecomus_Mediabox_Model_Youtubevideo_Product
    extends Mage_Core_Model_Abstract {
    /**
     * Initialize resource
     * @access protected
     * @return void
     * @author Ultimate Module Creator
     */
    protected function _construct(){
        $this->_init('ecomus_mediabox/youtubevideo_product');
    }
    /**
     * Save data for youtubevideo-product relation
     * @access public
     * @param  Ecomus_Mediabox_Model_Youtubevideo $youtubevideo
     * @return Ecomus_Mediabox_Model_Youtubevideo_Product
     * @author Ultimate Module Creator
     */
    public function saveYoutubevideoRelation($youtubevideo){
        $data = $youtubevideo->getProductsData();
        if (!is_null($data)) {
            $this->_getResource()->saveYoutubevideoRelation($youtubevideo, $data);
        }
        return $this;
    }
    /**
     * get products for youtubevideo
     * @access public
     * @param Ecomus_Mediabox_Model_Youtubevideo $youtubevideo
     * @return Ecomus_Mediabox_Model_Resource_Youtubevideo_Product_Collection
     * @author Ultimate Module Creator
     */
    public function getProductCollection($youtubevideo){
        $collection = Mage::getResourceModel('ecomus_mediabox/youtubevideo_product_collection')
            ->addYoutubevideoFilter($youtubevideo);
        return $collection;
    }
}
