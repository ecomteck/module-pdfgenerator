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

namespace Ecomteck\Pdfgenerator\Model\ResourceModel\Pdfgenerator;

class Collection extends AbstractCollection
{

    /**
     * @var string
     */
    //@codingStandardsIgnoreLine
    protected $_idFieldName = 'template_id';

    /**
     * Init resource model
     * @return void
     */
    //@codingStandardsIgnoreLine
    public function _construct()
    {

        $this->_init(
            \Ecomteck\Pdfgenerator\Model\Pdfgenerator::class,
            \Ecomteck\Pdfgenerator\Model\ResourceModel\Pdfgenerator::class
        );

        $this->_map['fields']['template_id'] = 'main_table.template_id';
        $this->_map['fields']['store'] = 'store_table.store_id';
    }

    /**
     * Add filter by store
     *
     * @param int|array|\Magento\Store\Model\Store $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if (!$this->getFlag('store_filter_added')) {
            $this->performAddStoreFilter($store, $withAdmin);
        }

        return $this;
    }

    /**
     * Perform operations after collection load
     *
     * @return \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
     */
    //@codingStandardsIgnoreLine
    public function _afterLoad()
    {
        $this->performAfterLoad('ecomteck_pdf_store', 'template_id');

        return parent::_afterLoad();
    }

    /**
     * Perform operations before rendering filters
     *
     * @return void
     */
    //@codingStandardsIgnoreLine
    public function _renderFiltersBefore()
    {
        $this->joinStoreRelationTable('ecomteck_pdf_store', 'template_id');
    }
}
