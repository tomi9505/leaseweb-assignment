<?php

namespace App\Tests\Functional\Controller;

use Symfony\Component\Panther\PantherTestCase;

class ServerItemAPIControllerTest extends PantherTestCase
{
    public function testSomething(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/');

        $this->assertSelectorTextContains('h1', 'Hello World');
    }
}
