<?php

namespace MetaSyntactical\Http\Transport\Guzzle;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use MetaSyntactical\Http\Transport\TransportInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GuzzleTransport implements TransportInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send request and return response
     *
     * @param  RequestInterface $request
     * @return ResponseInterface
     */
    public function send(RequestInterface $request)
    {
        return $this->client->send($request);
    }

    /**
     * Create new request
     *
     * @return RequestInterface
     */
    public function newRequest()
    {
        return new Request(null, "");
    }
}
