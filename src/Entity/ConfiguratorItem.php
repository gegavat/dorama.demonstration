<?php

namespace App\Entity;

use App\Repository\ConfiguratorItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConfiguratorItemRepository::class)
 */
class ConfiguratorItem
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
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default": 0})
     */
    private $price = 0;

    /**
     * @ORM\ManyToOne(targetEntity=Configurator::class, inversedBy="configuratorItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $configurator;

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getConfigurator(): ?Configurator
    {
        return $this->configurator;
    }

    public function setConfigurator(?Configurator $configurator): self
    {
        $this->configurator = $configurator;

        return $this;
    }
}
