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

use \Ecomteck\Pdfgenerator\Api\Data\TemplatesInterface;
use \Ecomteck\Pdfgenerator\Model\ResourceModel\Pdfgenerator as TemplateResource;
use \Ecomteck\Pdfgenerator\Api\TemplatesRepositoryInterface;
use Exception;
use Magento\Framework\Message\ManagerInterface;

class PdfgeneratorRepository implements TemplatesRepositoryInterface
{

    /**
     * @var array
     */
    private $instances = [];

    /**
     * @var TemplateResource
     */
    private $resource;

    /**
     * @var TemplatesInterface
     */
    private $templatesInterface;

    /**
     * @var \Ecomteck\Pdfgenerator\Model\PdfgeneratorFactory
     */
    private $pdfgeneratorFactory;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * PdfgeneratorRepository constructor.
     * @param TemplateResource $resource
     * @param TemplatesInterface $templatesInterface
     * @param PdfgeneratorFactory $pdfgeneratorFactory
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        TemplateResource $resource,
        TemplatesInterface $templatesInterface,
        PdfgeneratorFactory $pdfgeneratorFactory,
        ManagerInterface $messageManager
    ) {
        $this->resource = $resource;
        $this->templatesInterface = $templatesInterface;
        $this->pdfgeneratorFactory = $pdfgeneratorFactory;
        $this->messageManager = $messageManager;
    }

    /**
     * @param TemplatesInterface|Pdfgenerator $template
     * @return TemplatesInterface
     */
    public function save(TemplatesInterface $template)
    {
        try {
            $this->resource->save($template);
        } catch (Exception $e) {
            $this->messageManager->addExceptionMessage($e, 'There was a error');
        }

        return $template;
    }

    /**
     * @param int $templateId
     * @return mixed
     */
    public function getById($templateId)
    {
        if (!isset($this->instances[$templateId])) {
            $template = $this->pdfgeneratorFactory->create();
            $this->resource->load($template, $templateId);

            $this->instances[$templateId] = $template;
        }

        return $this->instances[$templateId];
    }

    /**
     * @param TemplatesInterface|Pdfgenerator $template
     * @return bool
     */
    public function delete(TemplatesInterface $template)
    {
        $id = $template->getId();
        try {
            unset($this->instances[$id]);
            $this->resource->delete($template);
        } catch (Exception $e) {
            $this->messageManager->addExceptionMessage($e, 'There was a error');
        }

        unset($this->instances[$id]);

        return true;
    }

    /**
     * @param int $templateId
     * @return bool
     */
    public function deleteById($templateId)
    {
        $template = $this->getById($templateId);
        return $this->delete($template);
    }

    /**
     * @param $type the template type
     * @return mixed
     */
    public function getDefaultTemplateItem($type = \Ecomteck\Pdfgenerator\Model\Source\TemplateType::TYPE_INVOICE){
        $templateModel = $this->pdfgeneratorFactory->create();
        $collection = $templateModel->getCollection();
        $collection->addFieldToFilter('template_type', $type)
                    ->addFieldtoFilter('template_default', 1);
        if ($collection->getSize()) {
            return $collection->getFirstItem();
        }
        return false;
    }
}
