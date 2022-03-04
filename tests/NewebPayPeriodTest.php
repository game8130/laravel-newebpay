<?php

namespace Ycs77\NewebPay\Test;

use Ycs77\NewebPay\NewebPayPeriod;
use Ycs77\NewebPay\Sender\Sync;

class NewebPayPeriodTest extends TestCase
{
    public function testNewebPayPeriodGetUrl()
    {
        $newebpay = new NewebPayPeriod($this->createMockConfig());

        $this->assertEquals('https://ccore.newebpay.com/MPG/period', $newebpay->getUrl());
    }

    public function testNewebPayPeriodSenderIsSync()
    {
        $newebpay = new NewebPayPeriod($this->createMockConfig());

        $this->assertInstanceOf(Sync::class, $newebpay->getSender());
    }

    public function testNewebPayPeriodGetRequestData()
    {
        $this->setTestNow();

        $newebpay = new NewebPayPeriod($this->createMockConfig());

        $requestData = $newebpay->getRequestData();

        $this->assertEquals('TestMerchantID1234', $requestData['MerchantID_']);
        $this->assertEquals('0648e6bb8bcda9be87c79c6d1460915ef83e2401fd26af418303a3d9d932f4a55b44d0a1ae9c5d487b0b9398bb262ffca046bd00e74e65c73c966f45505fc49bfb697aaccc6d5405811eb00aafafe64efa203983b1434f910ce538e0dc2e8042a74b7a32f0ffcde2298f30a472449af5ee57f46ebcda3223e92a7ca65c68921b02bf01ba40916364d6950447b203249405c903d939f1cfc7ab1670d674d4b1d150a1c9e2d65d875d98268e5ba810069a13e34d6763218787ce335af7929f75cfa0c2690a4d36361d0a251ace832be366d7343b4d1a6d4dccc590b134d6978154', $requestData['PostData_']);
    }

    public function testNewebPayPeriodSubmit()
    {
        $this->setTestNow();

        $newebpay = new NewebPayPeriod($this->createMockConfig());

        $result = $newebpay
            ->setPeriod('TestNo123456', 100, '測試定期定額商品', 'test@email.com', 'M', '01')
            ->submit();

        $this->assertEquals('<form id="order-form" method="post" action=https://ccore.newebpay.com/MPG/period ><input type="hidden" name="MerchantID_" value="TestMerchantID1234"><input type="hidden" name="PostData_" value="0648e6bb8bcda9be87c79c6d1460915ef83e2401fd26af418303a3d9d932f4a55b44d0a1ae9c5d487b0b9398bb262ffca046bd00e74e65c73c966f45505fc49bfb697aaccc6d5405811eb00aafafe64efa203983b1434f910ce538e0dc2e8042a74b7a32f0ffcde2298f30a472449af5ee57f46ebcda3223e92a7ca65c68921b02bf01ba40916364d6950447b203249405c903d939f1cfc7ab1670d674d4b1d150a1c9e2d65d875d98268e5ba810069a13e34d6763218787ce335af7929f75cfa0c2690a4d36361d0a251ace832be3662ad7f79a8edbeab7c8b6c0d9b4525f537e7cb176d93fdc8a357af24410bc49eae27219fbc90a1c5be0bb92ac9024710140fd616c733c2a6d04daa0352d02a5fd335692b301d1e1e2e4641ca06c37bb3c1792e2e1816273ba461af01cbe7b529f854871d078fc777b4e9a5a97cb32b2f3dbbf7c97dd17850f0929ba86e0968fc0dcefdfeecd260e690ca5bbf3815fb9a33607887525d048b7dcf06439ec65ee8ab3c18c53aa91a1b281b940a600651c56ae68cb2534082f53aa2b98397913c07f02dce6ca12abcbe4d8be48bbc0dd19ef"></form><script type="text/javascript">document.getElementById(\'order-form\').submit();</script>', $result);
    }
}
