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
 * Youtube Video - product relation resource model collection
 *
 * @category    Ecomus
 * @package     Ecomus_Mediabox
 * @author      Ultimate Module Creator
 */
class Ecomus_Mediabox_Model_Resource_Youtubevideo_Product_Collection
    extends Mage_Catalog_Model_Resource_Product_Collection {
    /**
     * remember if fields have been joined
     * @var bool
     */
    protected $_joinedFields = false;
    /**
     * join the link table
     * @access public
     * @return Ecomus_Mediabox_Model_Resource_Youtubevideo_Product_Collection
     * @author Ultimate Module Creator
     */
    public function joinFields(){
        if (!$this->_joinedFields){
            $this->getSelect()->join(
                array('related' => $this->getTable('ecomus_mediabox/youtubevideo_product')),
                'related.product_id = e.entity_id',
                array('position')
            );
            $this->_joinedFields = true;
        }
        return $this;
    }
    /**
     * add youtubevideo filter
     * @access public
     * @param Ecomus_Mediabox_Model_Youtubevideo | int $youtubevideo
     * @return Ecomus_Mediabox_Model_Resource_Youtubevideo_Product_Collection
     * @author Ultimate Module Creator
     */
    public function addYoutubevideoFilter($youtubevideo){
        if ($youtubevideo instanceof Ecomus_Mediabox_Model_Youtubevideo){
            $youtubevideo = $youtubevideo->getId();
        }
        if (!$this->_joinedFields){
            $this->joinFields();
        }
        $this->getSelect()->where('related.youtubevideo_id = ?', $youtubevideo);
        return $this;
    }
}
