<?php

namespace App\Tests\Functional\Controller;

use Symfony\Component\Panther\PantherTestCase;

class HomeControllerTest extends PantherTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createPantherClient();
        $this->client->request('GET', '/');
    }

    public function testCheckTitle(): void
    {
        $this->assertPageTitleSame('Server Information List');
    }

    public function testCheckHeader(): void
    {
        $this->assertSelectorTextContains('header', 'Server Information List application');
    }

    public function testCheckBody(): void
    {
        $this->assertSelectorTextContains('main', 'Server Information List application');
        $this->assertSelectorTextContains('main', 'List servers');
        $this->assertSelectorTextContains('main', 'Upload data');
    }
}
