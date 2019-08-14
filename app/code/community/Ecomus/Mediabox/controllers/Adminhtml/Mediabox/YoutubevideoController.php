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
 * Youtube Video admin controller
 *
 * @category    Ecomus
 * @package     Ecomus_Mediabox
 * @author      Ultimate Module Creator
 */
class Ecomus_Mediabox_Adminhtml_Mediabox_YoutubevideoController
    extends Ecomus_Mediabox_Controller_Adminhtml_Mediabox {
    /**
     * init the youtubevideo
     * @access protected
     * @return Ecomus_Mediabox_Model_Youtubevideo
     */
    protected function _initYoutubevideo(){
        $youtubevideoId  = (int) $this->getRequest()->getParam('id');
        $youtubevideo    = Mage::getModel('ecomus_mediabox/youtubevideo');
        if ($youtubevideoId) {
            $youtubevideo->load($youtubevideoId);
        }
        Mage::register('current_youtubevideo', $youtubevideo);
        return $youtubevideo;
    }
     /**
     * default action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function indexAction() {
        $this->loadLayout();
        $this->_title(Mage::helper('ecomus_mediabox')->__('Ecomus Mediabox'))
             ->_title(Mage::helper('ecomus_mediabox')->__('Youtube Videos'));
        $this->renderLayout();
    }
    /**
     * grid action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function gridAction() {
        $this->loadLayout()->renderLayout();
    }
    /**
     * edit youtube video - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction() {
        $youtubevideoId    = $this->getRequest()->getParam('id');
        $youtubevideo      = $this->_initYoutubevideo();
        if ($youtubevideoId && !$youtubevideo->getId()) {
            $this->_getSession()->addError(Mage::helper('ecomus_mediabox')->__('This youtube video no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getYoutubevideoData(true);
        if (!empty($data)) {
            $youtubevideo->setData($data);
        }
        Mage::register('youtubevideo_data', $youtubevideo);
        $this->loadLayout();
        $this->_title(Mage::helper('ecomus_mediabox')->__('Ecomus Mediabox'))
             ->_title(Mage::helper('ecomus_mediabox')->__('Youtube Videos'));
        if ($youtubevideo->getId()){
            $this->_title($youtubevideo->getTitle());
        }
        else{
            $this->_title(Mage::helper('ecomus_mediabox')->__('Add youtube video'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }
    /**
     * new youtube video action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function newAction() {
        $this->_forward('edit');
    }
    /**
     * save youtube video - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction() {
        if ($data = $this->getRequest()->getPost('youtubevideo')) {
            try {
                $youtubevideo = $this->_initYoutubevideo();
                $youtubevideo->addData($data);
                $imageName = $this->_uploadAndGetName('image', Mage::helper('ecomus_mediabox/youtubevideo')->getFileBaseDir(), $data);
                $youtubevideo->setData('image', $imageName);
                $products = $this->getRequest()->getPost('products', -1);
                if ($products != -1) {
                    $youtubevideo->setProductsData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($products));
                }
                $youtubevideo->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ecomus_mediabox')->__('Youtube Video was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $youtubevideo->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                if (isset($data['image']['value'])){
                    $data['image'] = $data['image']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setYoutubevideoData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
            catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['image']['value'])){
                    $data['image'] = $data['image']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ecomus_mediabox')->__('There was a problem saving the youtube video.').' '.$e->getMessage());
                Mage::getSingleton('adminhtml/session')->setYoutubevideoData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ecomus_mediabox')->__('Unable to find youtube video to save.'));
        $this->_redirect('*/*/');
    }
    /**
     * delete youtube video - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction() {
        if( $this->getRequest()->getParam('id') > 0) {
            try {
                $youtubevideo = Mage::getModel('ecomus_mediabox/youtubevideo');
                $youtubevideo->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ecomus_mediabox')->__('Youtube Video was successfully deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ecomus_mediabox')->__('There was an error deleting youtube video.'));
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ecomus_mediabox')->__('Could not find youtube video to delete.'));
        $this->_redirect('*/*/');
    }
    /**
     * mass delete youtube video - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction() {
        $youtubevideoIds = $this->getRequest()->getParam('youtubevideo');
        if(!is_array($youtubevideoIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ecomus_mediabox')->__('Please select youtube videos to delete.'));
        }
        else {
            try {
                foreach ($youtubevideoIds as $youtubevideoId) {
                    $youtubevideo = Mage::getModel('ecomus_mediabox/youtubevideo');
                    $youtubevideo->setId($youtubevideoId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ecomus_mediabox')->__('Total of %d youtube videos were successfully deleted.', count($youtubevideoIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ecomus_mediabox')->__('There was an error deleting youtube videos.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass status change - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massStatusAction(){
        $youtubevideoIds = $this->getRequest()->getParam('youtubevideo');
        if(!is_array($youtubevideoIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ecomus_mediabox')->__('Please select youtube videos.'));
        }
        else {
            try {
                foreach ($youtubevideoIds as $youtubevideoId) {
                $youtubevideo = Mage::getSingleton('ecomus_mediabox/youtubevideo')->load($youtubevideoId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d youtube videos were successfully updated.', count($youtubevideoIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ecomus_mediabox')->__('There was an error updating youtube videos.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * get grid of products action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function productsAction(){
        $this->_initYoutubevideo();
        $this->loadLayout();
        $this->getLayout()->getBlock('youtubevideo.edit.tab.product')
            ->setYoutubevideoProducts($this->getRequest()->getPost('youtubevideo_products', null));
        $this->renderLayout();
    }
    /**
     * get grid of products action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function productsgridAction(){
        $this->_initYoutubevideo();
        $this->loadLayout();
        $this->getLayout()->getBlock('youtubevideo.edit.tab.product')
            ->setYoutubevideoProducts($this->getRequest()->getPost('youtubevideo_products', null));
        $this->renderLayout();
    }
    /**
     * export as csv - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportCsvAction(){
        $fileName   = 'youtubevideo.csv';
        $content    = $this->getLayout()->createBlock('ecomus_mediabox/adminhtml_youtubevideo_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as MsExcel - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportExcelAction(){
        $fileName   = 'youtubevideo.xls';
        $content    = $this->getLayout()->createBlock('ecomus_mediabox/adminhtml_youtubevideo_grid')->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as xml - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportXmlAction(){
        $fileName   = 'youtubevideo.xml';
        $content    = $this->getLayout()->createBlock('ecomus_mediabox/adminhtml_youtubevideo_grid')->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * Check if admin has permissions to visit related pages
     * @access protected
     * @return boolean
     * @author Ultimate Module Creator
     */
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('ecomus_mediabox/youtubevideo');
    }
}
