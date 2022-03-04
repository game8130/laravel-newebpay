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
        $this->assertEquals('e88e33cc07d106bcba1c1bd02d5d421f9c4dc994fdb1a0acb2c79d95ee134b224e2d30fda9b31515d49d15c31b82cc10495fc4f238656c76fbff6a5aa6dcceb35d7a13d6f53c600427b8221160e2b39375debc831e56ae15c510a38cbcb5bdf28293a21594440cc45ef19600bcbaa2f6ee0d4eb170e48e3ebc083814240d597900077e4e4e2975d3bc94e7c2229f1582e0ac678bf7ccf203236f531096781570cd66486344f420eaa5e40a1fda23b645e8071097e2763fe8d2c101eb1d93a13f16131737f00c7afd284c6d9919ca84b0d96616aa763f3b79805dbdbe89e44c43', $requestData['PostData_']);
    }

    public function testNewebPayPeriodSubmit()
    {
        $this->setTestNow();

        $newebpay = new NewebPayPeriod($this->createMockConfig());

        $result = $newebpay
            ->setPeriod('TestNo123456', 100, '測試定期定額商品', 'test@email.com', 'M', '01')
            ->submit();

        $this->assertEquals('<form id="order-form" method="post" action=https://ccore.newebpay.com/MPG/period ><input type="hidden" name="MerchantID_" value="TestMerchantID1234"><input type="hidden" name="PostData_" value="e88e33cc07d106bcba1c1bd02d5d421f9c4dc994fdb1a0acb2c79d95ee134b224e2d30fda9b31515d49d15c31b82cc10495fc4f238656c76fbff6a5aa6dcceb35d7a13d6f53c600427b8221160e2b39375debc831e56ae15c510a38cbcb5bdf28293a21594440cc45ef19600bcbaa2f6ee0d4eb170e48e3ebc083814240d597900077e4e4e2975d3bc94e7c2229f1582e0ac678bf7ccf203236f531096781570cd66486344f420eaa5e40a1fda23b645e8071097e2763fe8d2c101eb1d93a13f16131737f00c7afd284c6d9919ca84b099b2bba0d1cddfaba942a5e468043e0c5b8a203992f89babc177130b2a41cfbd385585afb771e2cbb0267a87ee8d1efa75d08c81d9e4c4ff71c2e727d3e76cce6a92a84085b2db0bc229a1fcf0f2b76d85087eecfcd4385818465b08dd2702b0e2c32d446a73904445685bc563b3179185a72e0475347c84e0d0b15b2bb436f96dd364faec0015db26b666a8aa1fe3388f0d08e7145e5ab94d63e784369678b21fa501398705737e1f55d5c96357d6d24465043383654266f49c557fc2bb528c2b657b138a280370a5cc6deaba7815e1"></form><script type="text/javascript">document.getElementById(\'order-form\').submit();</script>', $result);
    }
}
