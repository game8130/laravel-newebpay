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
        $this->assertEquals('e88e33cc07d106bcba1c1bd02d5d421f9c4dc994fdb1a0acb2c79d95ee134b224e2d30fda9b31515d49d15c31b82cc1060a7433f19224003d9f271bf9c56f9d2', $requestData['PostData_']);
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
