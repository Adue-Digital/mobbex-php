<?php


namespace Adue\Mobbex\Modules;


use Adue\Mobbex\MobbexResponse;

class Operation extends BaseModule implements ModuleInterface
{

    protected $uri = 'operations/';
    protected $validationRules = [
    ];

    public function filter()
    {

        $response = $this->makeRequest([
            'method' => 'GET',
            'uri' => $this->uri . '?' . http_build_query([
                    'page' => $this->page,
                    'limit' => $this->limit,
                ])
        ]);

        return new MobbexResponse($response);
    }

    public function refund($id)
    {
        $response = $this->makeRequest([
            'headers' => [
                'cache-control' => 'no-cache',
                'content-type' => 'application/x-www-form-urlencoded',
                'x-access-token' => $this->mobbex->getAccessToken(),
                'x-api-key' => $this->mobbex->getApiKey()
            ],
            'body' => false,
            'method' => 'GET',
            'uri' => $this->uri . $id . '/status'
        ]);

        return new MobbexResponse($response);
    }
}