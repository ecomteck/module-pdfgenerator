<?php
namespace Ecomteck\Pdfgenerator\Controller\Invoice;

use Magento\Framework\App\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;

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
     * @param Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     */
    public function __construct(
        Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory
    ) {
        $this->customerSession = $customerSession;
        $this->fileFactory = $fileFactory;
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
            $pdf = $this->_objectManager->create('Magento\Sales\Model\Order\Pdf\Invoice')->getPdf([$invoice]);
            $date = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->date('Y-m-d_H-i-s');
            return $this->fileFactory->create(
                'invoice' . $date . '.pdf',
                $pdf->render(),
                DirectoryList::VAR_DIR,
                'application/pdf'
            );
        } else {
            /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('sales/order/history');
            return $resultRedirect;
        }
    }
}
