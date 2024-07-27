<?php

/**
 * @package Omnipay\Digipay
 * @author Amirreza Salari <amirrezasalari1997@gmail.com>
 */

namespace Omnipay\Digipay\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

class RefundTicketResponse extends AbstractResponse implements RedirectResponseInterface
{

    /**
     * @inheritDoc
     */
    public function getTransactionReference()
    {
        /** @var VerifyOrderRequest $request */
        $request = $this->data;
        return $request['trackingCode'];
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
}