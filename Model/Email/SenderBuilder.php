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

use Ecomteck\Pdfgenerator\Model\Pdfgenerator;
use Magento\Sales\Model\Order\Email\Container\IdentityInterface;
use Magento\Sales\Model\Order\Email\Container\Template;
use Ecomteck\Pdfgenerator\Helper\Pdf;
use Ecomteck\Pdfgenerator\Helper\Data;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Sales\Model\Order\Invoice;

class SenderBuilder extends \Magento\Sales\Model\Order\Email\SenderBuilder
{

    /**
     * @var Pdf
     */
    private $helper;

    /**
     * @var Data
     */
    private $dataHelper;

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * SenderBuilder constructor.
     * @param Template $templateContainer
     * @param IdentityInterface $identityContainer
     * @param TransportBuilder $transportBuilder
     * @param Pdf $helper
     * @param Data $dataHelper
     * @param DateTime $dateTime
     */
    public function __construct(
        Template $templateContainer,
        IdentityInterface $identityContainer,
        TransportBuilder $transportBuilder,
        Pdf $helper,
        Data $dataHelper,
        DateTime $dateTime
    ) {
        $this->helper = $helper;
        $this->dataHelper = $dataHelper;
        $this->dateTime = $dateTime;
        parent::__construct($templateContainer, $identityContainer, $transportBuilder);
    }

    /**
     * Add attachment to the main mail
     */
    public function send()
    {
        $vars = $this->templateContainer->getTemplateVars();
        $this->checkInvoice($vars);

        parent::send();
    }

    /**
     * Add attachment to the css/bcc mail
     */
    public function sendCopyTo()
    {
        $vars = $this->templateContainer->getTemplateVars();
        $this->checkInvoice($vars);
        parent::sendCopyTo();
    }

    /**
     *
     * Check if we need to send the invoice email
     *
     * @param $vars
     * @return $this
     */
    private function checkInvoice($vars)
    {
        if (!$this->dataHelper->isEmail()) {
            return $this;
        }

        if (!array_key_exists('invoice', $vars)) {
            return $this;
        }

        if ($vars['invoice'] instanceof Invoice) {
            $invoice = $vars['invoice'];
            $helper = $this->helper;

            $helper->setInvoice($invoice);

            /** @var Pdfgenerator $template */
            $template = $this->dataHelper->getTemplateStatus($invoice);

            if (empty($template->getId())) {
                return $this;
            }

            $helper->setTemplate($template);

            $pdfFileData = $helper->template2Pdf();

            $date = $this->dateTime->date('Y-m-d_H-i-s');

            $this->transportBuilder->addAttachment(
                $pdfFileData['filestream'],
                $pdfFileData['filename'] . $date . '.pdf'
            );
        }

        return $this;
    }
}
