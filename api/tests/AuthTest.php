<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class AuthTest extends ApiTestCase
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testSomething(): void
    {
        $client   = static::createClient();
        $response = $client->request(
            'POST', '/api/login_check', [
            'headers' => ['Content-Type' => 'application/json'],
            'json'    => [
                'username' => 'user@gmail.com',
                'password' => 'user80085',
            ],
        ]);

        $json = $response->toArray();
        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey('token', $json);

        $client->request('GET', '/api');
        $this->assertResponseStatusCodeSame(401);

        $client->request('GET', '/api', ['auth_bearer' => $json['token']]);
        $this->assertResponseIsSuccessful();
    }
}
