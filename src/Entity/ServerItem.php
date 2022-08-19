<?php

namespace App\Entity;

use App\Repository\ServerItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServerItemRepository::class)
 */
class ServerItem
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
    private $model;

    /**
     * @ORM\Column(type="integer")
     */
    private $ram;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ram_type;

    /**
     * @ORM\Column(type="integer")
     */
    private $hdd_count;

    /**
     * @ORM\Column(type="integer")
     */
    private $hddStorageCapacity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hddType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $currency;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getRam(): ?int
    {
        return $this->ram;
    }

    public function setRam(int $ram): self
    {
        $this->ram = $ram;

        return $this;
    }

    public function getRamType(): ?string
    {
        return $this->ram_type;
    }

    public function setRamType(string $ram_type): self
    {
        $this->ram_type = $ram_type;

        return $this;
    }

    public function getHddCount(): ?int
    {
        return $this->hdd_count;
    }

    public function setHddCount(int $hdd_count): self
    {
        $this->hdd_count = $hdd_count;

        return $this;
    }

    public function getHddStorageCapacity(): ?int
    {
        return $this->hddStorageCapacity;
    }

    public function setHddStorageCapacity(int $hddStorageCapacity): self
    {
        $this->hddStorageCapacity = $hddStorageCapacity;

        return $this;
    }

    public function getHddType(): ?string
    {
        return $this->hddType;
    }

    public function setHddType(string $hddType): self
    {
        $this->hddType = $hddType;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }
}
