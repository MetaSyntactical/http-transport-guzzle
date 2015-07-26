<?php

namespace MetaSyntactical\Http\Transport\Guzzle;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use PHPUnit_Framework_TestCase;
use Psr\Http\Message\RequestInterface;

class GuzzleTransportTest extends PHPUnit_Framework_TestCase
{
    private $container = [];

    /**
     * @var GuzzleTransport
     */
    private $object;

    public function testSendGetRequest()
    {
        /** @var RequestInterface $request */
        $request = $this->object->newRequest()
            ->withMethod("GET")
            ->withUri(new Uri("http://example.com/foo"))
            ->withHeader("X-Foo", "Bar")
            ->withBody(Psr7\stream_for("Does it work?"));

        $response = $this->object->send($request);

        $transaction = $this->container[0];
        /** @var RequestInterface $transactionRequest */
        $transactionRequest = $transaction['request'];

        self::assertEquals($request->getMethod(), $transactionRequest->getMethod());
        self::assertEquals($request->getUri(), $transactionRequest->getUri());
        self::assertEquals($request->getBody(), $transactionRequest->getBody());
        self::assertEquals($request->getHeader("X-Foo"), $transactionRequest->getHeader("X-Foo"));
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals("It worked!", $response->getBody());
        self::assertEquals("Bar", $response->getHeaderLine("X-Foo"));
    }

    protected function setUp()
    {
        $mock = new MockHandler([
            new Response(200, ["X-Foo" => "Bar"], "It worked!")
        ]);
        $stack = HandlerStack::create($mock);

        $history = Middleware::history($this->container);
        $stack->push($history);

        $client = new Client(["handler" => $stack]);

        $this->object = new GuzzleTransport($client);
    }
}
