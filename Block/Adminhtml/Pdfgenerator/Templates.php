<?php
/**
 * Ecomteck
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the ecomteck.com license that is
 * available through the world-wide-web at this URL:
 * https://ecomteck.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Ecomteck
 * @package     Ecomteck_Pdfgenerator
 * @copyright   Copyright (c) 2019 Ecomteck (https://ecomteck.com/)
 * @license     https://ecomteck.com/LICENSE.txt
 */

namespace Ecomteck\Pdfgenerator\Block\Adminhtml\Pdfgenerator;

use Magento\Backend\Block\Widget\Grid\Container;

class Templates extends Container
{

    /**
     * @return void;
     */
    //@codingStandardsIgnoreLine
    public function _construct()
    {

        $this->_controller = 'adminhtml_pdfgenerator';
        $this->_blockGroup = 'Ecomteck_Pdfgenerator';

        $this->_headerText = __('PDF Templates');
        $this->_addButtonLabel = __('Add New Template');
        parent::_construct();
        $this->buttonList->add(
            'template_apply',
            [
                'label' => __('Template'),
                'onclick' => "location.href='" . $this->getUrl('pdfgenerator/*/template') . "'",
                'class' => 'apply'
            ]
        );
    }

    /**
     * @param $resourceId
     * @return bool
     */
    //@codingStandardsIgnoreLine
    public function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
