<?php

namespace SDK;

use GuzzleHttp\Client;

class GuzzleClientFactory
{
    public function createClient(string $baseUri)
    {
        return new Client([
            'base_uri' => $baseUri
        ]);
    }
}
