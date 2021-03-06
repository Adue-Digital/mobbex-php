<?php


namespace Adue\Mobbex;

use Adue\Mobbex\Exceptions\ModuleNotFound;
use Adue\Mobbex\Modules\Checkout;
use Adue\Mobbex\Modules\Operation;
use Adue\Mobbex\Modules\PaymentCode;
use Adue\Mobbex\Modules\PaymentOrder;
use Adue\Mobbex\Modules\Sources;
use Adue\Mobbex\Modules\Subscription;
use Adue\Mobbex\Modules\Transaction;

class Mobbex
{
    private $apiKey;
    private $accessToken;

    private $modules = [
        'checkout' => Checkout::class,
        'paymentOrder' => PaymentOrder::class,
        'sources' => Sources::class,
        'paymentCode' => PaymentCode::class,
        'subscription' => Subscription::class,
        'transaction' => Transaction::class,
        'operation' => Operation::class,
    ];

    private $sharing = [];

    /**
     * Mobbex constructor.
     * @param $apiKey
     * @param $accessToken
     */
    public function __construct($apiKey, $accessToken)
    {
        $this->apiKey = $apiKey;
        $this->accessToken = $accessToken;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param mixed $apiKey
     */
    public function setApiKey($apiKey): void
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param mixed $accessToken
     */
    public function setAccessToken($accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    public function __get($property)
    {
        if(in_array($property, array_keys($this->modules))) {
            if(!in_array($property, array_keys($this->sharing)))
                return $this->sharing[$property] = new $this->modules[$property]($this);
            return $this->sharing[$property];
        }

        throw new ModuleNotFound;
    }

}