<?php

/**
 * @package Omnipay\Digipay
 * @author Amirreza Salari <amirrezasalari1997@gmail.com>
 */

namespace Omnipay\Digipay\Message;

/**
 * Class VerifyOrderResponse
 */
class VerifyOrderResponse extends AbstractResponse
{
    /**
     * @inheritDoc
     */
    public function getTransactionReference()
    {
        /** @var VerifyOrderRequest $request */
        $request = $this->request;
        return $request->getTransactionReference();
    }

    public function getTransactionId()
    {
        return $this->data['providerId'];
    }

    public function getPaymentGatewayTypes()
    {
        return $this->paymentGatewayTypesCodes[$this->data['paymentGateway']];
    }


    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        return (int)$this->getCode() === 200 && $this->data['result']['status'] === 0;
    }

    /**
     * @inheritDoc
     */
    public function isCancelled()
    {
        return (int)$this->getCode() === 200 && $this->data['result']['status'] === 1;
    }

    /**
     * In case of pending, you must inquiry the order later
     * @return bool
     */
    public function isPending()
    {
        return (int)$this->getCode() === 200 && $this->data['result']['status'] === 2;
    }
}
