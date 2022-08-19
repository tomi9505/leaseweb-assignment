<?php

namespace App\Entity;

use App\Repository\ServerListRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServerListRepository", repositoryClass=ServerListRepository::class)
 */
class ServerList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }
//    // This represents the instance
//    private static $fileName;
//
//    private function __construct() { }
//
//    private function __clone() { }
//
//    /**
//     * @throws Exception
//     */
//    public function __wakeup() {
//        throw new Exception("Cannot unserialize a singleton.");
//    }
//
//    public static function getFileName(): ?string
//    {
//        return ServerList::$fileName;
//    }
//
//    public static function setFileName(string $fileName)
//    {
//        ServerList::$fileName = $fileName;
//    }

public function getCreatedAt(): ?DateTimeImmutable
{
    return $this->createdAt;
}

public function setCreatedAt(DateTimeImmutable $createdAt): self
{
    $this->createdAt = $createdAt;

    return $this;
}
}
