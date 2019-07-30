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

use Magento\Cms\Controller\Adminhtml\Page\PostDataProcessor;

class PdfDataProcessor extends PostDataProcessor
{

    /**
     * @param array $data
     * @return array
     */
    //@codingStandardsIgnoreLine
    public function validateRequireEntry(array $data)
    {

        $requiredFields = [
            'template_name' => __('Template Name'),
            'template_description' => __('Template description'),
            'store_id' => __('Store View'),
            'template_file_name' => __('Template File Name'),
            'template_paper_ori' => __('Template Paper Orientation'),
            'template_paper_form' => __('Template Paper Form'),
            'is_active' => __('Status')
        ];

        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $this->messageManager->addErrorMessage(
                    __('To apply changes you should fill in hidden required "%1" field', $requiredFields[$field])
                );
            }
        }

        return $data;
    }
}
