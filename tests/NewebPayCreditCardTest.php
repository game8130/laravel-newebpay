<?php

namespace Ycs77\NewebPay\Test;

use GuzzleHttp\Psr7\Response;
use Ycs77\NewebPay\NewebPayCreditCard;
use Ycs77\NewebPay\Sender\Async;

class NewebPayCreditCardTest extends TestCase
{
    public function testNewebPayCreditCardGetUrl()
    {
        $newebpay = new NewebPayCreditCard($this->createMockConfig());

        $this->assertEquals('https://ccore.newebpay.com/API/CreditCard', $newebpay->getUrl());
    }

    public function testNewebPayCreditCardSenderIsSync()
    {
        $newebpay = new NewebPayCreditCard($this->createMockConfig());

        $this->assertInstanceOf(Async::class, $newebpay->getSender());
    }

    public function testNewebPayCreditCardGetRequestData()
    {
        $this->setTestNow();

        $newebpay = new NewebPayCreditCard($this->createMockConfig());

        $requestData = $newebpay->getRequestData();

        $this->assertEquals('TestMerchantID1234', $requestData['MerchantID_']);
        $this->assertEquals('0648e6bb8bcda9be87c79c6d1460915ef83e2401fd26af418303a3d9d932f4a55b44d0a1ae9c5d487b0b9398bb262ffc2b85a6788e5d08050306354a57344194', $requestData['PostData_']);
        $this->assertEquals('JSON', $requestData['Pos_']);
    }

    public function testNewebPayCreditCardSubmit()
    {
        $this->setTestNow();

        $newebpay = new NewebPayCreditCard($this->createMockConfig());

        $result = $newebpay
            ->firstTrade([
                'no' => 'TestNo123456',
                'amt' => 100,
                'desc' => '測試商品',
                'email' => 'test@email.com',
                'cardNo' => '0000-0000-0000-0000',
                'exp' => '',
                'cvc' => '',
                'tokenTerm' => '',
            ])
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
