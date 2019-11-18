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

namespace Ecomteck\Pdfgenerator\Helper;

use Ecomteck\Pdfgenerator\Model\ResourceModel\Pdfgenerator\Collection;
use Ecomteck\Pdfgenerator\Model\ResourceModel\Pdfgenerator\CollectionFactory as TemplateCollectionFactory;
use Ecomteck\Pdfgenerator\Model\Source\AbstractSource;
use Ecomteck\Pdfgenerator\Model\Source\TemplateActive;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Sales\Model\Order\Invoice;
use Magento\Store\Model\ScopeInterface;
use Mpdf\Mpdf;

use Magento\Email\Model\Template\Config;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Ecomteck\Pdfgenerator\Model\PdfgeneratorRepository;
use Magento\Sales\Model\Order\InvoiceRepository;

/**
 * Handles the config and other settings
 *
 * Class Data
 * @package Ecomteck\Pdfgenerator\Helper
 */
class Pdfgenerator extends AbstractHelper
{
    protected $_module_helper;
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magento_Sales::sales_invoice';

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @var FileFactory
     */

    private $fileFactory;
    /**
     * @var ForwardFactory
     */

    private $resultForwardFactory;

    /**
     * @var Pdf
     */
    private $helper;

    /**
     * @var PdfgeneratorRepository
     */
    private $pdfGeneratorRepository;

    /**
     * @var InvoiceRepository
     */
    private $invoiceRepository;

    /**
     * @var Config
     */
    private $emailConfig;

    /**
     * @var JsonFactory
     */
    public $resultJsonFactory;
    /**
     * Data constructor.
     * @param Context $context
     * @param Data $pdfgeneratorData
     * @param Config $emailConfig
     * @param JsonFactory $resultJsonFactory
     * @param Pdf $helper
     * @param DateTime $dateTime
     * @param FileFactory $fileFactory
     * @param FileFactory $fileFactory
     * @param PdfgeneratorRepository $pdfGeneratorRepository
     * @param InvoiceRepository $invoiceRepository
     */
    public function __construct(
        Context $context,
        Data $pdfgeneratorData,
        Config $emailConfig,
        JsonFactory $resultJsonFactory,
        Pdf $helper,
        DateTime $dateTime,
        FileFactory $fileFactory,
        PdfgeneratorRepository $pdfGeneratorRepository,
        InvoiceRepository $invoiceRepository
    ) {
        $this->_module_helper = $pdfgeneratorData;
        $this->emailConfig = $emailConfig;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->fileFactory = $fileFactory;
        $this->helper = $helper;
        $this->dateTime = $dateTime;
        $this->pdfGeneratorRepository = $pdfGeneratorRepository;
        $this->invoiceRepository = $invoiceRepository;

        parent::__construct($context);
    }

    public function generateInvoicePdf($invoiceId, $templateId = 0) {
        if (!$templateId) {
            $invoiceTemplate = $this->pdfGeneratorRepository->getDefaultTemplateItem();
            if($invoiceTemplate){
                $templateId = $invoiceTemplate->getId();
            }
        }
        if (!$templateId) {
            return false;
        }

        $templateModel = $this->pdfGeneratorRepository
            ->getById($templateId);

        if (!$templateModel) {
            return false;
        }

        if (!$invoiceId) {
            return false;
        }

        $invoice = $this->invoiceRepository
            ->get($invoiceId);
        if (!$invoice) {
            return false;
        }

        $helper = $this->helper;

        $helper->setInvoice($invoice);
        $helper->setTemplate($templateModel);

        $pdfFileData = $helper->template2Pdf();

        $date = $this->dateTime->date('Y-m-d_H-i-s');

        $fileName = $pdfFileData['filename'] . $date . '.pdf';
        $data_return = ["fileName"=>$fileName, "pdfData" => $pdfFileData['filestream']];
        return $data_return;
    }


    public function getInvoicePdf($invoices = [], $templateId = 0)
    {
        if (!$templateId) {
            $invoiceTemplate = $this->pdfGeneratorRepository->getDefaultTemplateItem();
            if($invoiceTemplate){
                $templateId = $invoiceTemplate->getId();
            }
        }
        if (!$templateId) {
            return false;
        }

        $templateModel = $this->pdfGeneratorRepository
            ->getById($templateId);

        if (!$templateModel) {
            return false;
        }

        $helper = $this->helper;

        foreach ($invoices as $invoice) {
            if ($invoice) {
               
            }

        }
        return $pdf;
    }

}