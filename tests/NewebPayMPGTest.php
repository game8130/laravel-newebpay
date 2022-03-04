<?php

namespace Ycs77\NewebPay\Test;

use Ycs77\NewebPay\NewebPayMPG;
use Ycs77\NewebPay\Sender\Sync;

class NewebPayMPGTest extends TestCase
{
    public function testNewebPayMPGGetUrl()
    {
        $newebpay = new NewebPayMPG($this->createMockConfig());

        $this->assertEquals('https://ccore.newebpay.com/MPG/mpg_gateway', $newebpay->getUrl());
    }

    public function testNewebPayMPGSenderIsSync()
    {
        $newebpay = new NewebPayMPG($this->createMockConfig());

        $this->assertInstanceOf(Sync::class, $newebpay->getSender());
    }

    public function testNewebPayMPGGetRequestData()
    {
        $this->setTestNow();

        $newebpay = new NewebPayMPG($this->createMockConfig());

        $requestData = $newebpay->getRequestData();

        $this->assertEquals('TestMerchantID1234', $requestData['MerchantID']);
        $this->assertEquals('0648e6bb8bcda9be87c79c6d1460915ef83e2401fd26af418303a3d9d932f4a55b44d0a1ae9c5d487b0b9398bb262ffca046bd00e74e65c73c966f45505fc49b73eac1fd59e2dc803c840e267ffcf3fa0d8dab91c66d00a554fe7f3076ac7c48a73c686bc1b3b4ecf71c834b5f3590c29aff3c1cc86b9596195713bffa660a0ea5a5ba160cfacfdc95d6600bf3e42dc9bc7fb8aad9d9f5859e6be0ebb529c5df67566ba78f1bbac4bee6932672481ca82970b5e2aaca98fbd020ef7e369812bd9ea02386db33383ba82c3ca04c5fe507782a09a7848469530ff51c969b401162e7d7669b52f5748a0ae066ae123db0a390cef7ca40549a72158dbb2f29a40d8a61917a0e14bdaae3cb7b8021c592bd6b53a515c468b615a05cf6e83b4ba733abe3a077d5fa225d8e7bfbfbe24e69f7629e1555db3c3ec06d831077f98a0051c6efc63ded85d48a7cb8d0b7a9a94a8b82ca09b702b26e44cfaa39f09df9c31989', $requestData['TradeInfo']);
        $this->assertEquals('2FC8FB303B0B71B62AC6E1F16BBBA05C5C568A5831E3ECF8528FAF2196F85E2B', $requestData['TradeSha']);
        $this->assertEquals('2.0', $requestData['Version']);
    }

    public function testNewebPayMPGSubmit()
    {
        $this->setTestNow();

        $newebpay = new NewebPayMPG($this->createMockConfig());

        $result = $newebpay
            ->setOrder('TestNo123456', 100, '測試商品', 'test@email.com')
            ->submit();

        $this->assertEquals('<form id="order-form" method="post" action=https://ccore.newebpay.com/MPG/mpg_gateway ><input type="hidden" name="MerchantID" value="TestMerchantID1234"><input type="hidden" name="TradeInfo" value="0648e6bb8bcda9be87c79c6d1460915ef83e2401fd26af418303a3d9d932f4a55b44d0a1ae9c5d487b0b9398bb262ffca046bd00e74e65c73c966f45505fc49b73eac1fd59e2dc803c840e267ffcf3fa0d8dab91c66d00a554fe7f3076ac7c48a73c686bc1b3b4ecf71c834b5f3590c29aff3c1cc86b9596195713bffa660a0ea5a5ba160cfacfdc95d6600bf3e42dc9bc7fb8aad9d9f5859e6be0ebb529c5df67566ba78f1bbac4bee6932672481ca82970b5e2aaca98fbd020ef7e369812bd9ea02386db33383ba82c3ca04c5fe507782a09a7848469530ff51c969b401162e7d7669b52f5748a0ae066ae123db0a390cef7ca40549a72158dbb2f29a40d8a61917a0e14bdaae3cb7b8021c592bd6b53a515c468b615a05cf6e83b4ba733abe3a077d5fa225d8e7bfbfbe24e69f7629e1555db3c3ec06d831077f98a0051c6efc63ded85d48a7cb8d0b7a9a94a8b82b8b39d62c31ddf1aefeadfebf1df549ea42d73d01c904022634f7e7c195b65d8d08918f717ef60ed36c2fae03ba12db7e2c97d5ef59f1bd2e90100eede0ed3565b3c724270a9c2f52d4923de8f26601459595ebf8f4987775377a9fbfbd336c51b11be605468a1572ad4bc29b2f9ce3be87df98705ad2d0df2d18addf699979534e32ebb811303e4853f27ca40dff826"><input type="hidden" name="TradeSha" value="7F5F27B06E2B6A1292FE676450CD231D6674389AF6573A223C7DC453A0A2A6D6"><input type="hidden" name="Version" value="2.0"></form><script type="text/javascript">document.getElementById(\'order-form\').submit();</script>', $result);
    }
}
