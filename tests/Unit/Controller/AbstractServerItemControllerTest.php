<?php

namespace App\Tests\Unit\Controller;

use App\Controller\AbstractServerItemController;
use App\Entity\ServerItem;
use App\Repository\ServerItemRepository;
use App\Tests\TestUtil;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class AbstractServerItemControllerTest extends TestCase
{
    private $doctrine;
    private $repository;
    private $controller;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createMock(ServerItemRepository::class);
        $this->doctrine = $this->createMock(ManagerRegistry::class);
        $this->doctrine->expects($this->any())
            ->method('getRepository')
            ->willReturn($this->repository);
        $this->controller = new AbstractServerItemController();
    }

    public function testGetAllServerItemsEmpty() {
        // Given: there are no server items in the database
        $this->repository
            ->expects($this->any())
            ->method('findAll')
            ->willReturn([]);

        // When: I query all server items
        try {
            $result = TestUtil::callMethod($this->controller, 'getAllServerItems', [$this->doctrine]);
        } catch (ReflectionException $e) {
            $this->fail('Failed to call method \'getAllServerItems\' under test');
        }

        // Then: the response is an empty array
        $this->assertCount(0, $result);
    }

    public function testGetAllServerItemsSuccess() {
        // Given: there are server items in the database
        $serverItems = [
            new ServerItem(),
            new ServerItem()
        ];

        $this->repository
            ->expects($this->any())
            ->method('findAll')
            ->willReturn($serverItems);

        // When: I query all server items
        try {
            $result = TestUtil::callMethod($this->controller, 'getAllServerItems', [$this->doctrine]);
        } catch (\ReflectionException $e) {
            $this->fail('Failed to call method \'getAllServerItems\' under test');
        }

        // Then: the response is an empty array
        $this->assertCount(count($serverItems), $result);
        foreach ($result as $actualServerItem) {
            $this->assertContains($actualServerItem, $serverItems);
        }
    }

    public function testFilteredServerItems() {
        // Given: there are server items in the database and the filters are empty
        $serverItems = [
            new ServerItem(),
            new ServerItem()
        ];
        $filters = [
            'ramValues' => null,
            'storageMin' => null,
            'storageMax' => null,
            'storageType' => null,
            'location' => null
        ];

        $this->repository
            ->expects($this->any())
            ->method('findByFilters')
            ->willReturn($serverItems);

        // When: I query all server items
        try {
            $result = TestUtil::callMethod($this->controller, 'getFilteredServerItems', [$this->doctrine, $filters]);
        } catch (\ReflectionException $e) {
            $this->fail('Failed to call method \'getAllServerItems\' under test');
        }

        // Then: the response is an empty array
        $this->assertCount(count($serverItems), $result);
        foreach ($result as $actualServerItem) {
            $this->assertContains($actualServerItem, $serverItems);
        }
    }
}
