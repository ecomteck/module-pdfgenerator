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

namespace Ecomteck\Pdfgenerator\Plugin\Magento\Sales\Controller\Adminhtml\Invoice;

use Magento\Sales\Model\ResourceModel\Order\Invoice\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Ecomteck\Pdfgenerator\Helper\Pdfgenerator;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Pdfinvoices
{
    /**
     * @var FileFactory
     */
    protected $fileFactory;

    /**
     * @var DateTime
     */
    protected $dateTime;

    protected $filter;

    protected $pdfgeneratorHelper;

    public function __construct(
        CollectionFactory $collectionFactory,
        Filter $filter,
        DateTime $dateTime,
        FileFactory $fileFactory,
        Pdfgenerator $pdfgeneratorHelper
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->fileFactory = $fileFactory;
        $this->dateTime = $dateTime;
        $this->filter = $filter;
        $this->pdfgenerator = $pdfgeneratorHelper;
    }

    public function aroundExecute($subject, $result)
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        return $this->massAction($collection);
    }

    public function massAction(AbstractCollection $collection)
    {
        
        $pdf = $this->pdfgenerator->getInvoicePdf($collection);
        $fileContent = ['type' => 'string', 'value' => $pdf->render(), 'rm' => true];

        return $this->fileFactory->create(
            sprintf('invoice%s.pdf', $this->dateTime->date('Y-m-d_H-i-s')),
            $fileContent,
            DirectoryList::VAR_DIR,
            'application/pdf'
        );
    }
}