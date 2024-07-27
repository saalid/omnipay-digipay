<?php

namespace Omnipay\Digipay\Tests;

use Omnipay\Digipay\Gateway;
use Omnipay\Tests\GatewayTestCase;
use Omnipay\Digipay\Message\CreateOrderRequest;
use Omnipay\Digipay\Message\CreateOrderResponse;
use Omnipay\Tests\TestCase;

class GatewayTest extends TestCase
{
    /**
     * @var Gateway
     */
    protected $gateway;

    /**
     * @var array<string, integer|string|boolean>
     */
    protected $params;

    public function setUp(): void
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setUsername('36528a81-f66f-4833-8bf9-b397a64b2319');
        $this->gateway->setPassword('Ppu-Si;1040;s5');
        $this->gateway->setClientId('inverseschool-client-id');
        $this->gateway->setClientSecret('627,x6(XxOQarFH');
    }

    public function testPurchaseSuccess(): void
    {
        $this->setMockHttpResponse(['GetToken.txt','PurchaseSuccess.txt']);
        $amount = 60;
        $customerPhone = '09056619083';

        /** @var CreateOrderResponse $response */
        $response = $this->gateway->purchase([
            'amount' => $amount,
            'phoneNumber' => $customerPhone,
            'transactionId' => rand(1111111, 99999999),
            'returnUrl' => 'http://localhost/return',
            'courses' => [192, 193, 194],
            'cartId' => 180
        ])->send();

        self::assertTrue($response->isSuccessful());
        self::assertTrue($response->isRedirect());
        self::assertEquals('v2:ab17ec383d654be3b009f9fc45202f80',$response->getTransactionReference());
        self::assertEquals('https://uatweb.mydigipay.info/web-pay/tgs/v2:ab17ec383d654be3b009f9fc45202f80', $response->getRedirectUrl());
    }

    public function testPurchaseFailure(): void
    {
        $this->setMockHttpResponse(['GetToken.txt','PurchaseFailure.txt']);
        $amount = 60;
        $customerPhone = '09056619083';

        /** @var CreateOrderResponse $response */
        $response = $this->gateway->purchase([
            'amount' => $amount,
            'phoneNumber' => $customerPhone,
            'transactionId' => rand(1111111, 99999999),
            'returnUrl' => 'http://localhost/return',
            'courses' => [192, 193, 194],
            'cartId' => 180
        ])->send();
        self::assertFalse($response->isSuccessful());
        self::assertTrue($response->isCancelled());
    }

    public function testCompletePurchaseSuccess(): void
    {
        $this->setMockHttpResponse('PurchaseCompleteSuccess.txt');
        $param= [
            'ticketId' => 'PJQPHFwN1AM6EUAJ',
        ];


        /** @var VerifyTicketResponse $response */
        $response = $this->gateway->completePurchase($param)->send();

        $responseData=$response->getData();

        self::assertTrue($response->isSuccessful());
        self::assertTrue($response->isVerified());
        self::assertEquals('PJQPHFwN1AM6EUAJ',$responseData['result']['ticket_id']);
    }
//
//    public  function testPurchaseCreatedStatus(): void
//    {
//        $this->setMockHttpResponse('PurchaseCreatedStatus.txt');
//        $param= [
//            'ticketId' => 'PJQPHFwN1AM6EUAJ',
//        ];
//        /** @var StatusTicketResponse $response */
//        $response = $this->gateway->status($param)->send();
//
//        $responseData=$response->getData();
//
//        self::assertTrue($response->isSuccessful());
//        self::assertTrue($response->isCreated());
//        self::assertEquals('PJQPHFwN1AM6EUAJ',$responseData['result']['ticket_id']);
//    }
//
//    public  function testPurchaseExpiredStatus(): void
//    {
//        $this->setMockHttpResponse('PurchaseExpiredStatus.txt');
//        $param= [
//            'ticketId' => 'PJQPHFwN1AM6EUAJ',
//        ];
//        /** @var StatusTicketResponse $response */
//        $response = $this->gateway->statusPurchase($param)->send();
//
//        $responseData=$response->getData();
//
//        self::assertTrue($response->isSuccessful());
//        self::assertTrue($response->isExpired());
//        self::assertEquals('PJQPHFwN1AM6EUAJ',$responseData['result']['ticket_id']);
//    }
//
//    public  function testPurchaseCancel(): void
//    {
//        $this->setMockHttpResponse('PurchaseCancel.txt');
//        $param= [
//            'ticketId' => 'PJQPHFwN1AM6EUAJ',
//        ];
//        /** @var CancelTicketResponse $response */
//        $response = $this->gateway->cancel($param)->send();
//
//        $responseData=$response->getData();
//
//        self::assertTrue($response->isSuccessful());
//        self::assertEquals($response->getFallBackUrl(),$responseData['result']['fallbackUri']);
//    }


}