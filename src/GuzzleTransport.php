<?php

namespace MetaSyntactical\Http\Transport\Guzzle;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
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

    /**
     * Build a query string from an array of key value pairs
     *
     * @param array     $params   Query string parameters.
     * @param int|false $encoding Set to false to not encode, PHP_QUERY_RFC3986
     *                            to encode using RFC3986, or PHP_QUERY_RFC1738
     *                            to encode using RFC1738.
     * @return string
     */
    public function buildQuery(array $params, $encoding = PHP_QUERY_RFC3986)
    {
        return Psr7\build_query($params, $encoding);
    }
}
