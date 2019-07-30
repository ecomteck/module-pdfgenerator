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

namespace Ecomteck\Pdfgenerator\Model;

use Ecomteck\Pdfgenerator\Api\Data\TemplatesInterface;
use Ecomteck\Pdfgenerator\Model\ResourceModel\Pdfgenerator as PdfgeneratorClass;
use Magento\Framework\Model\AbstractModel;

class Pdfgenerator extends AbstractModel implements TemplatesInterface
{

    /**
     * Init resource model for the templates
     * @return void
     */
    //@codingStandardsIgnoreLine
    public function _construct()
    {
        $this->_init(
            PdfgeneratorClass::class
        );
    }
}
