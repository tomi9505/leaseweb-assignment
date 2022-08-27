<?php

namespace App\Tests\Functional\Controller;

use Symfony\Component\Panther\PantherTestCase;

class HomeControllerTest extends PantherTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createPantherClient();
    }

    public function testSmokeTest(): void
    {
        $this->client->request('GET', '/');
        $this->assertResponseIsSuccessful();
    }
}
