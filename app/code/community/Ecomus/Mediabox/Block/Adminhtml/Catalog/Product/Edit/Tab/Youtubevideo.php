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
 * Youtube Video tab on product edit form
 *
 * @category    Ecomus
 * @package     Ecomus_Mediabox
 * @author      Ultimate Module Creator
 */
class Ecomus_Mediabox_Block_Adminhtml_Catalog_Product_Edit_Tab_Youtubevideo
    extends Mage_Adminhtml_Block_Widget_Grid {
    /**
     * Set grid params
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct() {
        parent::__construct();
        $this->setId('youtubevideo_grid');
        $this->setDefaultSort('position');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        if ($this->getProduct()->getId()) {
            $this->setDefaultFilter(array('in_youtubevideos'=>1));
        }
    }
    /**
     * prepare the youtubevideo collection
     * @access protected
     * @return Ecomus_Mediabox_Block_Adminhtml_Catalog_Product_Edit_Tab_Youtubevideo
     * @author Ultimate Module Creator
     */
    protected function _prepareCollection() {
        $collection = Mage::getResourceModel('ecomus_mediabox/youtubevideo_collection');
        if ($this->getProduct()->getId()){
            $constraint = 'related.product_id='.$this->getProduct()->getId();
            }
            else{
                $constraint = 'related.product_id=0';
            }
        $collection->getSelect()->joinLeft(
            array('related'=>$collection->getTable('ecomus_mediabox/youtubevideo_product')),
            'related.youtubevideo_id=main_table.entity_id AND '.$constraint,
            array('position')
        );
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }
    /**
     * prepare mass action grid
     * @access protected
     * @return Ecomus_Mediabox_Block_Adminhtml_Catalog_Product_Edit_Tab_Youtubevideo
     * @author Ultimate Module Creator
     */
    protected function _prepareMassaction(){
        return $this;
    }
    /**
     * prepare the grid columns
     * @access protected
     * @return Ecomus_Mediabox_Block_Adminhtml_Catalog_Product_Edit_Tab_Youtubevideo
     * @author Ultimate Module Creator
     */
    protected function _prepareColumns(){
        $this->addColumn('in_youtubevideos', array(
            'header_css_class'  => 'a-center',
            'type'  => 'checkbox',
            'name'  => 'in_youtubevideos',
            'values'=> $this->_getSelectedYoutubevideos(),
            'align' => 'center',
            'index' => 'entity_id'
        ));
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('ecomus_mediabox')->__('Id'),
            'index'        => 'entity_id',
            'type'        => 'number'
        ));
        $this->addColumn('title', array(
            'header'=> Mage::helper('ecomus_mediabox')->__('Video Title'),
            'align' => 'left',
            'index' => 'title',
            'renderer'  => 'ecomus_mediabox/adminhtml_helper_column_renderer_relation',
            'params' => array(
                'id'=>'getId'
            ),
            'base_link' => 'adminhtml/mediabox_youtubevideo/edit',
        ));
        $this->addColumn('video_id', array(
            'header'=> Mage::helper('ecomus_mediabox')->__('Video Id'),
            'index' => 'video_id',
            'type'=> 'text',

        ));
        $this->addColumn('position', array(
            'header'        => Mage::helper('ecomus_mediabox')->__('Position'),
            'name'          => 'position',
            'width'         => 60,
            'type'        => 'number',
            'validate_class'=> 'validate-number',
            'index'         => 'position',
            'editable'      => true,
        ));
        return parent::_prepareColumns();
    }
    /**
     * Retrieve selected youtubevideos
     * @access protected
     * @return array
     * @author Ultimate Module Creator
     */
    protected function _getSelectedYoutubevideos(){
        $youtubevideos = $this->getProductYoutubevideos();
        if (!is_array($youtubevideos)) {
            $youtubevideos = array_keys($this->getSelectedYoutubevideos());
        }
        return $youtubevideos;
    }
     /**
     * Retrieve selected youtubevideos
     * @access protected
     * @return array
     * @author Ultimate Module Creator
     */
    public function getSelectedYoutubevideos() {
        $youtubevideos = array();
        //used helper here in order not to override the product model
        $selected = Mage::helper('ecomus_mediabox/product')->getSelectedYoutubevideos(Mage::registry('current_product'));
        if (!is_array($selected)){
            $selected = array();
        }
        foreach ($selected as $youtubevideo) {
            $youtubevideos[$youtubevideo->getId()] = array('position' => $youtubevideo->getPosition());
        }
        return $youtubevideos;
    }
    /**
     * get row url
     * @access public
     * @param Ecomus_Mediabox_Model_Youtubevideo
     * @return string
     * @author Ultimate Module Creator
     */
    public function getRowUrl($item){
        return '#';
    }
    /**
     * get grid url
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getGridUrl(){
        return $this->getUrl('*/*/youtubevideosGrid', array(
            'id'=>$this->getProduct()->getId()
        ));
    }
    /**
     * get the current product
     * @access public
     * @return Mage_Catalog_Model_Product
     * @author Ultimate Module Creator
     */
    public function getProduct(){
        return Mage::registry('current_product');
    }
    /**
     * Add filter
     * @access protected
     * @param object $column
     * @return Ecomus_Mediabox_Block_Adminhtml_Catalog_Product_Edit_Tab_Youtubevideo
     * @author Ultimate Module Creator
     */
    protected function _addColumnFilterToCollection($column){
        if ($column->getId() == 'in_youtubevideos') {
            $youtubevideoIds = $this->_getSelectedYoutubevideos();
            if (empty($youtubevideoIds)) {
                $youtubevideoIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$youtubevideoIds));
            }
            else {
                if($youtubevideoIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$youtubevideoIds));
                }
            }
        }
        else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
}
