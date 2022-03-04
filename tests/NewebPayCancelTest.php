<?php

namespace Ycs77\NewebPay\Test;

use GuzzleHttp\Psr7\Response;
use Ycs77\NewebPay\NewebPayCancel;
use Ycs77\NewebPay\Sender\Async;

class NewebPayCancelTest extends TestCase
{
    public function testNewebPayCancelGetUrl()
    {
        $newebpay = new NewebPayCancel($this->createMockConfig());

        $this->assertEquals('https://ccore.newebpay.com/API/CreditCard/Cancel', $newebpay->getUrl());
    }

    public function testNewebPayCancelSenderIsSync()
    {
        $newebpay = new NewebPayCancel($this->createMockConfig());

        $this->assertInstanceOf(Async::class, $newebpay->getSender());
    }

    public function testNewebPayCancelGetRequestData()
    {
        $this->setTestNow();

        $newebpay = new NewebPayCancel($this->createMockConfig());

        $requestData = $newebpay->getRequestData();

        $this->assertEquals('TestMerchantID1234', $requestData['MerchantID_']);
        $this->assertEquals('0648e6bb8bcda9be87c79c6d1460915ef83e2401fd26af418303a3d9d932f4a55b44d0a1ae9c5d487b0b9398bb262ffc4fcf63fb1572c55cc70e5a0a04b08497', $requestData['PostData_']);
    }

    public function testNewebPayCancelSubmit()
    {
        $this->setTestNow();

        $newebpay = new NewebPayCancel($this->createMockConfig());

        $result = $newebpay
            ->setCancelOrder('TestNo123456', 100, 'order')
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
