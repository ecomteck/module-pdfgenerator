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

namespace Ecomteck\Pdfgenerator\Model\Source;

use Magento\Framework\View\Model\PageLayout\Config\BuilderInterface;

/**
 * Class PageLayout
 */
class TemplatePaperForm extends AbstractSource
{
    /**
     * @var \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface
     */
    private $pageLayoutBuilder;

    /**
     * Constructor
     *
     * @param BuilderInterface $pageLayoutBuilder
     */
    public function __construct(BuilderInterface $pageLayoutBuilder)
    {
        $this->pageLayoutBuilder = $pageLayoutBuilder;
    }

    /**
     * Paper types
     */
    const TEMAPLATE_PAPER_FORM_A4 = 1;
    const TEMAPLATE_PAPER_FORMAT_A3 = 2;
    const TEMAPLATE_PAPER_FORMAT_A5 = 3;
    const TEMAPLATE_PAPER_FORMAT_A6 = 4;
    const TEMAPLATE_PAPER_FORMAT_LETTER = 5;
    const TEMAPLATE_PAPER_FORMAT_LEGAL = 6;

    /**
     * Prepare post's statuses.
     *
     * @return array
     */
    public function getAvailable()
    {
        return [
            self::TEMAPLATE_PAPER_FORM_A4 => 'A4',
            self::TEMAPLATE_PAPER_FORMAT_A3 => 'A3',
            self::TEMAPLATE_PAPER_FORMAT_A5 => 'A5',
            self::TEMAPLATE_PAPER_FORMAT_A6 => 'A6',
            self::TEMAPLATE_PAPER_FORMAT_LETTER => 'Letter',
            self::TEMAPLATE_PAPER_FORMAT_LEGAL => 'Legal',
        ];
    }
}
