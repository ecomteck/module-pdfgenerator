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

namespace Ecomteck\Pdfgenerator\Model\Email;

use Ecomteck\Pdfgenerator\Model\FactoryInterface;
use Magento\Framework\ObjectManagerInterface;

/**
 * Class VariablesFacrory
 * @package Ecomteck\Pdfgenerator\Model\Email
 * @deprecated
 */
class VariablesFacrory implements FactoryInterface
{
    private $objectManager = null;

    private $instanceName = null;

    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
        if (class_exists(\Magento\Email\Model\Source\Variables::class)) {
            $this->instanceName = \Magento\Email\Model\Source\Variables::class;
        }

        if (class_exists(\Magento\Variable\Model\Source\Variables::class)) {
            $this->instanceName = \Magento\Variable\Model\Source\Variables::class;
        }
    }

    public function create(array $data = [])
    {
        return $this->objectManager->create($this->instanceName, $data);
    }
}
