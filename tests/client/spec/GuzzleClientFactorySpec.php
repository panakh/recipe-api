<?php

namespace spec\SDK;

use GuzzleHttp\Client;
use SDK\GuzzleClientFactory;
use PhpSpec\ObjectBehavior;

class GuzzleClientFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(GuzzleClientFactory::class);
    }

    function it_creates_guzzle_client()
    {
        $baseUri = 'uri';
        $this->createClient($baseUri)->shouldBeAnInstanceOf(Client::class);
    }
}
