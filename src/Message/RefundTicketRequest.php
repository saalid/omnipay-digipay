<?php

/**
 * @package Omnipay\Digipay
 * @author Amirreza Salari <amirrezasalari1997@gmail.com>
 */

namespace Omnipay\Digipay\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class RefundTicketRequest extends AbstractRequest
{

    protected function getHttpMethod()
    {
        return 'POST';
    }

    protected function createUri(string $endpoint)
    {
        return $endpoint . '/refunds?type=' . $this->getType();
    }

    /**
     * @param array $data
     * @return RefundTicketResponse
     */
    protected function createResponse(array $data)
    {
        return new RefundTicketResponse($this, $data);
    }

    /**
     * @throws InvalidRequestException
     */
    public function getData()
    {
        return [
            'amount' => $this->getAmount(),
            'providerId' => $this->getTransactionId(),
            'saleTrackingCode' => $this->getTransactionReference(),
        ];
    }


    /**
     * @return string
     */
    public function getType()
    {
        return $this->getParameter('type');
    }

    /**
     * @param string $type
     * @return self
     */
    public function setType(string $type)
    {
        return $this->setParameter('type', $type);
    }
}