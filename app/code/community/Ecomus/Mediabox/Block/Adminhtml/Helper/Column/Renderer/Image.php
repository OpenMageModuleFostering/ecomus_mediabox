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
 * related entities column renderer
 * @category   Ecomus
 * @package    Ecomus_Mediabox
 * @author      Ultimate Module Creator
 */
class Ecomus_Mediabox_Block_Adminhtml_Helper_Column_Renderer_Image
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
    /**
     * render the column
     * @access public
     * @param Varien_Object $row
     * @return string
     * @author Ultimate Module Creator
     */
    public function render(Varien_Object $row) 
    {
        $image =  $row->getData($this->getColumn()->getIndex());
        
        if($image != '')
        {
            $url = Mage::helper('ecomus_mediabox/youtubevideo')->getVideoImageUrl($image, null, 56);
            return '<img src="'.$url.'" />';
        }
        else
        {
            return '';
        }
    }
}
