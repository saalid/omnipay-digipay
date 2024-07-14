<?php

/**
 * @package Omnipay\Digipay
 * @author Amirreza Salari <amirrezasalari1997@gmail.com>
 */

namespace Omnipay\Digipay\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Class InquiryOrderRequest
 */
class InquiryOrderRequest extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    protected function getHttpMethod()
    {
        return 'GET';
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     * @throws InvalidRequestException
     */
    public function getData()
    {
        // Validate required parameters before return data
        $this->validate('transactionReference');

        return [];
    }

    /**
     * @param string $endpoint
     * @return string
     */
    protected function createUri(string $endpoint)
    {
        return $endpoint . '/orders/' . $this->getTransactionReference();
    }

    /**
     * @param array $data
     * @return InquiryOrderResponse
     */
    protected function createResponse(array $data)
    {
        return new InquiryOrderResponse($this, $data);
    }
}
