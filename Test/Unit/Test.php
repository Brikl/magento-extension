<?php
namespace Brikl\Studio\Test\Unit;

use PHPUnit\Framework\TestCase;

use Brikl\Studio\Observer\ProductSaveEvent;

class Test extends TestCase
{
    public function testSaveEvent()
    {
        $expected = [
            'id' => '5',
            'brikl_product_id' => 'test product id',
            'brikl_shop_id' => '4280b857-69d6-49e2-aca5-f3be8562cc5f'
        ];

        $contextMock = $this->getMockBuilder(\Magento\Framework\View\Element\Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        $requestMock = $this->getMockBuilder(\Magento\Framework\App\RequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $observer = $this->getMockBuilder(Magento\Framework\Event\Observer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $requestMock->method('getParams')->willReturn(
            [
                'id' => $expected['id'],
                'brikl_studio' =>
                [
                    'brikl_product_id' => $expected['brikl_product_id'],
                    'brikl_shop_id' => $expected['brikl_shop_id']
                ],
                'testing' => true
            ]
        );

        $contextMock->method('getRequest')->willReturn($requestMock);

        $model = new ProductSaveEvent($contextMock);

        $this->assertEquals($expected, $model->execute($observer));
    }
}
