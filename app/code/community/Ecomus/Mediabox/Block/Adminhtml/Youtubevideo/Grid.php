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
 * Youtube Video admin grid block
 *
 * @category    Ecomus
 * @package     Ecomus_Mediabox
 * @author      Ultimate Module Creator
 */
class Ecomus_Mediabox_Block_Adminhtml_Youtubevideo_Grid
    extends Mage_Adminhtml_Block_Widget_Grid {
    /**
     * constructor
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct(){
        parent::__construct();
        $this->setId('youtubevideoGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
    /**
     * prepare collection
     * @access protected
     * @return Ecomus_Mediabox_Block_Adminhtml_Youtubevideo_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareCollection(){
        $collection = Mage::getModel('ecomus_mediabox/youtubevideo')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    /**
     * prepare grid collection
     * @access protected
     * @return Ecomus_Mediabox_Block_Adminhtml_Youtubevideo_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareColumns(){
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('ecomus_mediabox')->__('Id'),
            'index'        => 'entity_id',
            'type'        => 'number'
        ));
        $this->addColumn('title', array(
            'header'    => Mage::helper('ecomus_mediabox')->__('Video Title'),
            'align'     => 'left',
            'index'     => 'title',
        ));
        $this->addColumn('video_id', array(
            'header'=> Mage::helper('ecomus_mediabox')->__('Video Id'),
            'index' => 'video_id',
            'type'=> 'text',
        ));
        $this->addColumn('image', array(
            'header'=> Mage::helper('ecomus_mediabox')->__('Video Image'),
            'align' => 'left',
            'index' => 'image',
            'renderer'  => 'ecomus_mediabox/adminhtml_helper_column_renderer_image',
            'width'     => '80px',
            'align' => 'center',
        ));
        if (!Mage::app()->isSingleStoreMode() && !$this->_isExport) {
            $this->addColumn('store_id', array(
                'header'=> Mage::helper('ecomus_mediabox')->__('Store Views'),
                'index' => 'store_id',
                'type'  => 'store',
                'store_all' => true,
                'store_view'=> true,
                'sortable'  => false,
                'filter_condition_callback'=> array($this, '_filterStoreCondition'),
            ));
        }
        $this->addColumn('status', array(
            'header'    => Mage::helper('ecomus_mediabox')->__('Status'),
            'index'        => 'status',
            'type'        => 'options',
            'options'    => array(
                '1' => Mage::helper('ecomus_mediabox')->__('Enabled'),
                '0' => Mage::helper('ecomus_mediabox')->__('Disabled'),
            )
        ));
        $this->addColumn('created_at', array(
            'header'    => Mage::helper('ecomus_mediabox')->__('Created at'),
            'index'     => 'created_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('ecomus_mediabox')->__('Updated at'),
            'index'     => 'updated_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        $this->addColumn('action',
            array(
                'header'=>  Mage::helper('ecomus_mediabox')->__('Action'),
                'width' => '100',
                'type'  => 'action',
                'getter'=> 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('ecomus_mediabox')->__('Edit'),
                        'url'   => array('base'=> '*/*/edit'),
                        'field' => 'id'
                    )
                ),
                'filter'=> false,
                'is_system'    => true,
                'sortable'  => false,
        ));
        $this->addExportType('*/*/exportCsv', Mage::helper('ecomus_mediabox')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('ecomus_mediabox')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('ecomus_mediabox')->__('XML'));
        return parent::_prepareColumns();
    }
    /**
     * prepare mass action
     * @access protected
     * @return Ecomus_Mediabox_Block_Adminhtml_Youtubevideo_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareMassaction(){
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('youtubevideo');
        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('ecomus_mediabox')->__('Delete'),
            'url'  => $this->getUrl('*/*/massDelete'),
            'confirm'  => Mage::helper('ecomus_mediabox')->__('Are you sure?')
        ));
        $this->getMassactionBlock()->addItem('status', array(
            'label'=> Mage::helper('ecomus_mediabox')->__('Change status'),
            'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
            'additional' => array(
                'status' => array(
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('ecomus_mediabox')->__('Status'),
                        'values' => array(
                                '1' => Mage::helper('ecomus_mediabox')->__('Enabled'),
                                '0' => Mage::helper('ecomus_mediabox')->__('Disabled'),
                        )
                )
            )
        ));
        return $this;
    }
    /**
     * get the row url
     * @access public
     * @param Ecomus_Mediabox_Model_Youtubevideo
     * @return string
     * @author Ultimate Module Creator
     */
    public function getRowUrl($row){
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    /**
     * get the grid url
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getGridUrl(){
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
    /**
     * after collection load
     * @access protected
     * @return Ecomus_Mediabox_Block_Adminhtml_Youtubevideo_Grid
     * @author Ultimate Module Creator
     */
    protected function _afterLoadCollection(){
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
    /**
     * filter store column
     * @access protected
     * @param Ecomus_Mediabox_Model_Resource_Youtubevideo_Collection $collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     * @return Ecomus_Mediabox_Block_Adminhtml_Youtubevideo_Grid
     * @author Ultimate Module Creator
     */
    protected function _filterStoreCondition($collection, $column){
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $collection->addStoreFilter($value);
        return $this;
    }
}
