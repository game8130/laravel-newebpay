<?php

namespace Ycs77\NewebPay;

class NewebPayPeriod extends BaseNewebPay
{
    /**
     * The newebpay boot hook.
     *
     * @return void
     */
    public function boot()
    {
        $this->setApiPath('MPG/period');
        $this->setSyncSender();

        $this->setLangType();
        $this->setPeriodStartType();
        $this->setPeriodTimes();
        $this->setPeriodFirstdate();
        $this->setReturnURL();
        $this->setPeriodMemo();
        $this->setEmailModify();
        $this->setPaymentInfo();
        $this->setOrderInfo();
        $this->setNotifyURL();
        $this->setBackURL();
        $this->setUNIONPAY();

        $this->TradeData['MerchantID'] = $this->MerchantID;
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
