<?php

namespace Ycs77\NewebPay;

class NewebPayPeriodAlterStatus extends BaseNewebPay
{
    /**
     * The newebpay boot hook.
     *
     * @return void
     */
    public function boot()
    {
        $this->setApiPath('MPG/period/AlterStatus');
        $this->setAsyncSender();

    }

    /**
     * 委託狀態
     *
     * @param  string  $type
     *                        'suspend': 暫停委託
     *                        'terminate': 終止委託
     *                        'restart': 暫停後重啟委託
     * @return $this
     */
    public function setAlterType($type = 'terminate')
    {
        $this->TradeData['AlterType'] = $type;

        return $this;
    }

    /**
     * 修改定期定額狀態
     *
     * @param  string  $no 商店訂單編號
     * @param  string  $periodNo 委託單號
     * @return $this
     */
    public function setPeriodAlterStatus($no, $periodNo)
    {
        $this->TradeData['MerOrderNo'] = $no;
        $this->TradeData['PeriodNo'] = $periodNo;

        return $this;
    }


    /**
     * Get request data.
     *
     * @return array
     */
    public function getRequestData()
    {
        $postData = $this->encryptDataByAES($this->TradeData, $this->HashKey, $this->HashIV);

        return [
            'MerchantID_' => $this->MerchantID,
            'PostData_' => $postData,
        ];
    }
}
