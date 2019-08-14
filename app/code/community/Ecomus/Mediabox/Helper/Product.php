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
 * Product helper
 *
 * @category    Ecomus
 * @package     Ecomus_Mediabox
 * @author      Ultimate Module Creator
 */
class Ecomus_Mediabox_Helper_Product
    extends Ecomus_Mediabox_Helper_Data {
    /**
     * get the selected youtubevideos for a product
     * @access public
     * @param Mage_Catalog_Model_Product $product
     * @return array()
     * @author Ultimate Module Creator
     */
    public function getSelectedYoutubevideos(Mage_Catalog_Model_Product $product){
        if (!$product->hasSelectedYoutubevideos()) {
            $youtubevideos = array();
            foreach ($this->getSelectedYoutubevideosCollection($product) as $youtubevideo) {
                $youtubevideos[] = $youtubevideo;
            }
            $product->setSelectedYoutubevideos($youtubevideos);
        }
        return $product->getData('selected_youtubevideos');
    }
    /**
     * get youtubevideo collection for a product
     * @access public
     * @param Mage_Catalog_Model_Product $product
     * @return Ecomus_Mediabox_Model_Resource_Youtubevideo_Collection
     * @author Ultimate Module Creator
     */
    public function getSelectedYoutubevideosCollection(Mage_Catalog_Model_Product $product){
        $collection = Mage::getResourceSingleton('ecomus_mediabox/youtubevideo_collection')
            ->addProductFilter($product);
        return $collection;
    }
}
