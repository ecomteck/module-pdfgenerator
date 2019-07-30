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

namespace Ecomteck\Pdfgenerator\Controller\Adminhtml\Templates;

use Ecomteck\Pdfgenerator\Controller\Adminhtml\Templates;
use Ecomteck\Pdfgenerator\Model\Pdfgenerator;
use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Ecomteck\Pdfgenerator\Model\Source\TemplateActive;
use Ecomteck\Pdfgenerator\Model\PdfgeneratorRepository as TemplateRepository;
use Ecomteck\Pdfgenerator\Model\PdfgeneratorFactory;

/**
 * Class Save
 * @package Ecomteck\Pdfgenerator\Controller\Adminhtml\Templates
 * @SuppressWarnings("CouplingBetweenObjects")
 */
class Save extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'ecomteck_Pdfgenerator::save';

    /**
     * @var PdfDataProcessor
     */
    private $dataProcessor;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var TemplateRepository
     */
    private $templateRepository;

    /**
     * @var PdfgeneratorFactory
     */
    private $pdfgeneratorFactory;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param PdfDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     * @param TemplateRepository $templateRepository
     * @param PdfgeneratorFactory $pdfgeneratorFactory
     */
    public function __construct(
        Action\Context $context,
        PdfDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor,
        TemplateRepository $templateRepository,
        PdfgeneratorFactory $pdfgeneratorFactory
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        $this->templateRepository = $templateRepository;
        $this->pdfgeneratorFactory = $pdfgeneratorFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            $data = $this->dataProcessor->validateRequireEntry($data);

            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = TemplateActive::STATUS_ENABLED;
            }

            if (empty($data['template_id'])) {
                $data['template_id'] = null;
            }

            /** @var Pdfgenerator $model */

            $id = $this->getRequest()->getParam('template_id');
            if ($id) {
                /** @var Pdfgenerator $model */
                $model = $this->templateRepository->getById($id);
            } else {
                unset($data['template_id']);
                /** @var Pdfgenerator $model */
                $model = $this->pdfgeneratorFactory->create();
            }

            $model->setData($data);
            $model->setData('update_time', time());

            if (!$this->dataProcessor->validate($data)) {
                return $resultRedirect->setPath('*/*/edit', [
                    'template_id' => $model->getTemplateId(),
                    '_current' => true
                ]);
            }

            try {
                $this->templateRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the template.'));
                $this->dataPersistor->clear('pdfgenerator_template');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', [
                        'template_id' => $model->getTemplateId(),
                        '_current' => true
                    ]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while saving the template.')
                );
            }

            $this->dataPersistor->set('pdfgenerator_template', $data);
            return $resultRedirect->setPath('*/*/edit', [
                'template_id' => $this->getRequest()->getParam('template_id')
            ]);
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    //@codingStandardsIgnoreLine
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(
            Templates::ADMIN_RESOURCE_VIEW
        );
    }
}
