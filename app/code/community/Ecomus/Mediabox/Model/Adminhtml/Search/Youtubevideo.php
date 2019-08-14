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
 * Admin search model
 *
 * @category    Ecomus
 * @package     Ecomus_Mediabox
 * @author      Ultimate Module Creator
 */
class Ecomus_Mediabox_Model_Adminhtml_Search_Youtubevideo
    extends Varien_Object {
    /**
     * Load search results
     * @access public
     * @return Ecomus_Mediabox_Model_Adminhtml_Search_Youtubevideo
     * @author Ultimate Module Creator
     */
    public function load(){
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('ecomus_mediabox/youtubevideo_collection')
            ->addFieldToFilter('title', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $youtubevideo) {
            $arr[] = array(
                'id'=> 'youtubevideo/1/'.$youtubevideo->getId(),
                'type'  => Mage::helper('ecomus_mediabox')->__('Youtube Video'),
                'name'  => $youtubevideo->getTitle(),
                'description'   => $youtubevideo->getTitle(),
                'url' => Mage::helper('adminhtml')->getUrl('*/mediabox_youtubevideo/edit', array('id'=>$youtubevideo->getId())),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
