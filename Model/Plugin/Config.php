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

namespace Ecomteck\Pdfgenerator\Model\Plugin;

use Magento\Backend\Model\UrlInterface;
use Magento\Framework\Registry;

class Config
{
    /**
     * Config constructor.
     * @param UrlInterface $url
     * @param Registry $registry
     */
    public function __construct(
        UrlInterface $url,
        Registry $registry
    ) {
        $this->_url = $url;
        $this->registry = $registry;
    }

    /**
     * @param $subject
     * @param $result
     * @return string
     * @SuppressWarnings("unused")
     */
    //@codingStandardsIgnoreLine
    public function afterGetVariablesWysiwygActionUrl($subject, $result)
    {

        if ($this->registry->registry('pdfgenerator_template')) {
            return $this->getUrl();
        }

        return $result;
    }

    /**
     * Returns the variable url
     * @return string
     */
    public function getUrl()
    {
        return $this->_url->getUrl('*/variable/template');
    }
}
