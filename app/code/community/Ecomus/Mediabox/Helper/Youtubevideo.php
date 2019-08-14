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
 * Youtube Video helper
 *
 * @category    Ecomus
 * @package     Ecomus_Mediabox
 * @author      Ultimate Module Creator
 */
class Ecomus_Mediabox_Helper_Youtubevideo
    extends Mage_Core_Helper_Abstract {
    /**
     * get base files dir
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getFileBaseDir(){
        return Mage::getBaseDir('media').DS.'ec_video_images'.DS.'uploaded';
    }
    /**
     * get base file url
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getFileBaseUrl(){
        return Mage::getBaseUrl('media').'ec_video_images/uploaded';
    }
    
    public function getVideoImageUrl($fileName, $width, $height = null)
    {
        if (is_null($width) && is_null($height)) 
        {
            return null;
        }
        
        try
        {
            $ioHandler = new Varien_Io_File;
                    
            $sizeDir = $height.'_'.$width;
            $cacheDir = Mage::getBaseDir('media').DS.'ec_video_images'.DS.'cache';
            
            $ioHandler->checkAndCreateFolder($cacheDir);

            $originalImage = $this->getFileBaseDir().$fileName;
            $resizedImage = $cacheDir.DS.$sizeDir.$fileName;

            if (file_exists($originalImage) && is_file($originalImage) && !file_exists($resizedImage)) 
            {
                $imageObj = new Varien_Image($originalImage);
                $imageObj->constrainOnly(true);
                $imageObj->keepAspectRatio(true);
                $imageObj->backgroundColor(array(255,255,255));
                $imageObj->keepFrame(true);
                $imageObj->resize($width, $height);
                $imageObj->save($resizedImage);
            }
            
            $resizedURL = Mage::getBaseUrl('media').'ec_video_images/'.'/cache/'.$sizeDir.$fileName;

            return $resizedURL;
        }
        catch (Exception $e) 
        {
            Mage::logException($e);
            return null;
        }
    }
    
    public function getVideoData($product)
    {
        $result = array();
        
        try 
        {
            $collection = Mage::getModel('ecomus_mediabox/youtubevideo')->getCollection();
            $collection->addStoreFilter(Mage::app()->getStore());
            $collection->addProductFilter($product);
            $collection->addFieldToFilter('status', array('eq' => 1));
            $collection->getSelect()->order('position','asc');
            
            foreach($collection as $entity)
            {
                $video = array();
                $video['id'] = $entity->getVideoId();
                $video['title'] = $entity->getTitle();
                $video['image'] = $entity->getImage();
                
                if($video['image'] != '')
                    array_push($result, $video);
            }
        }
        catch (Exception $e) 
        {
            Mage::logException($e);
        }
        
        return $result;
    }
}
