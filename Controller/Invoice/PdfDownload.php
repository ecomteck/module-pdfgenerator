<?php
namespace Ecomteck\Pdfgenerator\Controller\Invoice;

use Magento\Framework\App\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Ecomteck\Pdfgenerator\Helper\Pdfgenerator;

class PdfDownload extends Action\Action
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $fileFactory;

    /**
     * @var Pdfgenerator
     */
    protected $pdfgenerator;

    /**
     * @param Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     * @param Pdfgenerator $pdfgenerator
     */
    public function __construct(
        Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        Pdfgenerator $pdfgenerator
    ) {
        $this->customerSession = $customerSession;
        $this->fileFactory = $fileFactory;
        $this->pdfgenerator = $pdfgenerator;
        parent::__construct($context);
    }

    public function execute()
    {
        $invoiceId = (int)$this->getRequest()->getParam('invoice_id');
        if(!$invoiceId){
            /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('sales/order/history');
            return $resultRedirect;
        }
        $invoice = $this->_objectManager->create('Magento\Sales\Api\InvoiceRepositoryInterface')->get($invoiceId);
        if(!$invoice || !$invoice->getId()){
            /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('sales/order/history');
            return $resultRedirect;
        }

        $order = $invoice->getOrder();
        $customerId = $this->customerSession->getCustomerId();

        if($order->getId()
            && $order->getCustomerId()
            && $order->getCustomerId() == $customerId){
            $templateId = 0;
            $pdfData = $this->pdfgenerator->generateInvoicePdf($invoiceId, $templateId);

            if(!$pdfData){
                $pdf = $this->_objectManager->create('Magento\Sales\Model\Order\Pdf\Invoice')->getPdf([$invoice]);
                $date = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->date('Y-m-d_H-i-s');
                return $this->fileFactory->create(
                    'invoice' . $date . '.pdf',
                    $pdf->render(),
                    DirectoryList::VAR_DIR,
                    'application/pdf'
                );
            } else {
                return $this->fileFactory->create(
                    $pdfData['fileName'],
                    $pdfData['pdfData'],
                    DirectoryList::VAR_DIR,
                    'application/pdf'
                );
            }
        } else {
            /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('sales/order/history');
            return $resultRedirect;
        }
    }
}
