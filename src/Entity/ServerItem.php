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
    private $ramType;

    /**
     * @ORM\Column(type="integer")
     */
    private $hddCount;

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
        return $this->ramType;
    }

    public function setRamType(string $ram_type): self
    {
        $this->ramType = $ram_type;

        return $this;
    }

    public function getHddCount(): ?int
    {
        return $this->hddCount;
    }

    public function setHddCount(int $hdd_count): self
    {
        $this->hddCount = $hdd_count;

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

    public function getRamConcatenated(): ?string
    {
        return $this->ram . 'GB ' . $this->ramType;
    }

    public function getHddConcatenated(): ?string
    {
        if ($this->hddStorageCapacity / 1024 >= 1) {
            return $this->hddCount . 'x' . $this->hddStorageCapacity/1024 . 'TB ' . $this->hddType;
        } else {
            return $this->hddCount . 'x' . $this->hddStorageCapacity . 'GB ' . $this->hddType;
        }
    }

    public function getPriceConcatenated(): ?string
    {
        return $this->currency .$this->price;
    }
}
