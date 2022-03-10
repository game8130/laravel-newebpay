<?php

namespace Ycs77\NewebPay;

class NewebPayPeriodAlterAmt extends BaseNewebPay
{
    /**
     * The newebpay boot hook.
     *
     * @return void
     */
    public function boot()
    {
        $this->setApiPath('MPG/period/AlterAmt');
        $this->setAsyncSender();

        $this->setExtday();
    }

    /**
     * set Period alter Amt
     *
     * @param  string  $no
     * @param  string  $periodNo
     * @param  int  $amt
     * @param  string  $desc
     * @param  string  $email
     * @param  string  $type
     * @param  string  $point
     * @return $this
     */
    public function setPeriodAlterAmt($no, $periodNo, $amt, $desc, $email, $type, $point)
    {
        $this->TradeData['MerOrderNo'] = $no;
        $this->TradeData['PeriodAmt'] = $amt;
        $this->TradeData['ProdDesc'] = $desc;
        $this->TradeData['PayerEmail'] = $email;
        $this->TradeData['PeriodType'] = $type;
        $this->TradeData['PeriodPoint'] = $point;

        return $this;
    }

    /**
     * 信用卡到期日期格式為月年，2021年5月則填入[0521]
     *
     * @param string $extday
     * @return void
     */
    public function setExtday($extday = null)
    {
        if ($extday) {
            $this->TradeData['Extday'] = $extday;
        }

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
