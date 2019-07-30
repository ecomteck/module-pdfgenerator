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

namespace Ecomteck\Pdfgenerator\Test\Unit\Model;

use Ecomteck\Pdfgenerator\Model\PdfgeneratorRepository;
use Ecomteck\Pdfgenerator\Model\ResourceModel\Pdfgenerator as PdfgeneratorResourceModel;
use Ecomteck\Pdfgenerator\Model\PdfgeneratorFactory;
use Ecomteck\Pdfgenerator\Model\Pdfgenerator as PdfgeneratorModel;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Framework\Message\ManagerInterface;

/**
 * Test for \Pdfgenerator\Model\PdfgeneratorRepository
 * Class PdfgeneratorRepositoryTest
 * @package Ecomteck\Pdfgenerator\Test\Integration
 */
class PdfgeneratorRepositoryTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var /Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
     */
    public $objectManager;

    /**
     * @var PdfgeneratorRepository
     */
    private $repository;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Ecomteck\Pdfgenerator\Model\ResourceModel\Pdfgenerator
     */
    private $pdfGeneratorResourceModel;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Ecomteck\Pdfgenerator\Model\PdfgeneratorFactory
     */
    private $pdfGeneratorFactory;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Ecomteck\Pdfgenerator\Api\Data\TemplatesInterface;
     */
    private $pdfGenerator;

    public function setUp()
    {

        $this->objectManager = new ObjectManager($this);

        $this->pdfGeneratorResourceModel = $this->getMockBuilder(PdfgeneratorResourceModel::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->pdfGeneratorFactory = $this->getMockBuilder(PdfgeneratorFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        /** @var PdfgeneratorModel pdfGenerator */
        $this->pdfGenerator = $this->objectManager->getObject(PdfgeneratorModel::class);

        $this->pdfGeneratorFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->pdfGenerator);

        $messageManager = $this->getMockBuilder(ManagerInterface::class)->getMock();

        $this->repository = new PdfgeneratorRepository(
            $this->pdfGeneratorResourceModel,
            $this->pdfGenerator,
            $this->pdfGeneratorFactory,
            $messageManager
        );
    }

    public function testSave()
    {
        $this->pdfGeneratorResourceModel
            ->expects($this->once())
            ->method('save')
            ->with($this->pdfGenerator)
            ->willReturnSelf();

        $this->assertEquals($this->pdfGenerator, $this->repository->save($this->pdfGenerator));
    }

    public function testGetById()
    {
        $id = 1;
        $this->pdfGeneratorResourceModel
            ->expects($this->once())
            ->method('load')
            ->with($this->pdfGenerator->setEntityId($id))
            ->willReturnSelf();

        $this->assertEquals($this->pdfGenerator, $this->repository->getById($id));
    }

    public function testDelete()
    {

        $this->pdfGeneratorResourceModel
            ->expects($this->once())
            ->method('delete')
            ->with($this->pdfGenerator)
            ->willReturnSelf();

        $this->assertTrue($this->repository->delete($this->pdfGenerator));
    }

    public function testDeleteById()
    {
        $id = 1;

        $this->pdfGeneratorResourceModel
            ->expects($this->once())
            ->method('load')
            ->with($this->pdfGenerator->setEntityId($id))
            ->willReturnSelf();

        $this->assertTrue($this->repository->deleteById($id));
    }
}
