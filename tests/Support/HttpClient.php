<?php

namespace App\Tests\Support;

use Symfony\Component\HttpKernel\Client;

trait HttpClient
{
    /**
     * @param array $server
     * @return Client
     */
    public function createClient(array $server = []): Client
    {
        $client = static::$container->get('test.client');
        $client->setServerParameters($server);

        return $client;
    }
}
