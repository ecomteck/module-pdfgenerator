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

namespace Ecomteck\Pdfgenerator\Model\Source;

use Magento\Framework\View\Model\PageLayout\Config\BuilderInterface;

/**
 * Class PageLayout
 */
class TemplateType extends AbstractSource
{
    
    /**
     * @var \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface
     */
    private $pageLayoutBuilder;

    /**
     * Constructor
     *
     * @param BuilderInterface $pageLayoutBuilder
     */
    public function __construct(BuilderInterface $pageLayoutBuilder)
    {
        $this->pageLayoutBuilder = $pageLayoutBuilder;
    }

    /**
     * Types
     */
    const TYPE_INVOICE = 1;
    const TYPE_ORDER = 2;
    const TYPE_SHIPMENT = 3;
    const TYPE_CATEGORY = 4;
    const TYPE_PRODUCT= 5;
    const TYPE_CMS= 6;

    /**
     * Prepare post's statuses.
     *
     * @return array
     */
    public function getAvailable()
    {
        return [
                self::TYPE_INVOICE => __('Invoice'),
                self::TYPE_ORDER => __('Order'),
                self::TYPE_SHIPMENT => __('Shipment'),
                self::TYPE_CATEGORY => __('Catalog Category'),
                self::TYPE_PRODUCT => __('Catalog Product'),
                self::TYPE_CMS => __('CMS Page')
                ];
    }
}
