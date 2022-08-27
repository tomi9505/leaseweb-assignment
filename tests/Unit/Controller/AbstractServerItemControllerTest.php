<?php

namespace App\Tests\Unit\Controller;

use App\Controller\AbstractServerItemController;
use App\Tests\TestUtil;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;

class AbstractServerItemControllerTest extends TestCase
{
    private $doctrine;
    private $controller;

    public function setUp(): void
    {
        parent::setUp();
        $this->doctrine = $this->createMock(ManagerRegistry::class);
        $this->controller = new AbstractServerItemController();
    }

    public function testGetAllServerItemsEmpty() {
        // Given: there are no server items in the database
        $this->doctrine
            ->expects($this->any())
            ->method('findAll')
            ->willReturn([]);

        // When: I query all server items
        try {
            $result = TestUtil::callMethod($this->controller, 'getAllServerItems', []);
        } catch (\ReflectionException $e) {
            $this->fail('Failed to call method \'getAllServerItems\' under test');
        }

        // Then: the response is an empty array
        $this->assertCount(0, $result);
    }
}
