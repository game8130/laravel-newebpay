<?php

namespace Ycs77\NewebPay\Test;

use GuzzleHttp\Psr7\Response;
use Ycs77\NewebPay\NewebPayClose;
use Ycs77\NewebPay\Sender\Async;

class NewebPayCloseTest extends TestCase
{
    public function testNewebPayCloseGetUrl()
    {
        $newebpay = new NewebPayClose($this->createMockConfig());

        $this->assertEquals('https://ccore.newebpay.com/API/CreditCard/Close', $newebpay->getUrl());
    }

    public function testNewebPayCloseSenderIsSync()
    {
        $newebpay = new NewebPayClose($this->createMockConfig());

        $this->assertInstanceOf(Async::class, $newebpay->getSender());
    }

    public function testNewebPayCloseGetRequestData()
    {
        $this->setTestNow();

        $newebpay = new NewebPayClose($this->createMockConfig());

        $requestData = $newebpay->getRequestData();

        $this->assertEquals('TestMerchantID1234', $requestData['MerchantID_']);
        $this->assertEquals('0648e6bb8bcda9be87c79c6d1460915ef83e2401fd26af418303a3d9d932f4a55b44d0a1ae9c5d487b0b9398bb262ffc4fcf63fb1572c55cc70e5a0a04b08497', $requestData['PostData_']);
    }

    public function testNewebPayCloseSubmit()
    {
        $this->setTestNow();

        $newebpay = new NewebPayClose($this->createMockConfig());

        $result = $newebpay
            ->setCloseOrder('TestNo123456', 100, 'order')
            ->setMockHttp([
                new Response(200, [], '{"Status":"Code001","Message":"Test message.","Result":[]}'),
            ])
            ->submit();

        $this->assertEquals([
            'Status' => 'Code001',
            'Message' => 'Test message.',
            'Result' => [],
        ], $result);
    }
}
