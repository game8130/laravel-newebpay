<?php

namespace Ycs77\NewebPay\Test;

use GuzzleHttp\Psr7\Response;
use Ycs77\NewebPay\NewebPayPeriodAlterAmt;
use Ycs77\NewebPay\Sender\Async;

class NewebPayPeriodAlterAmtTest extends TestCase
{
    public function testNewebPayPeriodAlterAmtGetUrl()
    {
        $newebpay = new NewebPayPeriodAlterAmt($this->createMockConfig());

        $this->assertEquals('https://ccore.newebpay.com/MPG/period/AlterAmt', $newebpay->getUrl());
    }

    public function testNewebPayPeriodAlterAmtSenderIsSync()
    {
        $newebpay = new NewebPayPeriodAlterAmt($this->createMockConfig());

        $this->assertInstanceOf(Async::class, $newebpay->getSender());
    }

    public function testNewebPayPeriodAlterAmtGetRequestData()
    {
        $this->setTestNow();

        $newebpay = new NewebPayPeriodAlterAmt($this->createMockConfig());

        $requestData = $newebpay->getRequestData();

        $this->assertEquals('TestMerchantID1234', $requestData['MerchantID_']);
        $this->assertEquals('e88e33cc07d106bcba1c1bd02d5d421f9c4dc994fdb1a0acb2c79d95ee134b224e2d30fda9b31515d49d15c31b82cc1060a7433f19224003d9f271bf9c56f9d2', $requestData['PostData_']);
    }

    public function testNewebPayPeriodAlterAmtSubmit()
    {
        $this->setTestNow();

        $newebpay = new NewebPayPeriodAlterAmt($this->createMockConfig());

        $result = $newebpay
            ->setPeriodAlterAmt('TestNo123456', 'TestNo123456', 100, '測試定期定額商品', 'test@email.com', 'M', '15')
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
