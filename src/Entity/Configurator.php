<?php

namespace App\Entity;

use App\Repository\ConfiguratorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConfiguratorRepository::class)
 */
class Configurator
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="configurators")
     */
    private $product;

    /**
     * @ORM\OneToMany(targetEntity=ConfiguratorItem::class, mappedBy="configurator", orphanRemoval=true)
     */
    private $configuratorItems;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    private $isMultiple;

    /**
     * @ORM\Column(type="boolean", options={"default": 1})
     */
    private $isRequired;

    public function __construct()
    {
        $this->product = new ArrayCollection();
        $this->configuratorItems = new ArrayCollection();
    }

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

    /**
     * @return Collection|Product[]
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->product->removeElement($product);

        return $this;
    }

    /**
     * @return Collection|ConfiguratorItem[]
     */
    public function getConfiguratorItems(): Collection
    {
        return $this->configuratorItems;
    }

    public function addConfiguratorItem(ConfiguratorItem $configuratorItem): self
    {
        if (!$this->configuratorItems->contains($configuratorItem)) {
            $this->configuratorItems[] = $configuratorItem;
            $configuratorItem->setConfigurator($this);
        }

        return $this;
    }

    public function removeConfiguratorItem(ConfiguratorItem $configuratorItem): self
    {
        if ($this->configuratorItems->removeElement($configuratorItem)) {
            // set the owning side to null (unless already changed)
            if ($configuratorItem->getConfigurator() === $this) {
                $configuratorItem->setConfigurator(null);
            }
        }

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getIsMultiple(): ?bool
    {
        return $this->isMultiple;
    }

    public function setIsMultiple(bool $isMultiple): self
    {
        $this->isMultiple = $isMultiple;

        return $this;
    }

    public function getIsRequired(): ?bool
    {
        return $this->isRequired;
    }

    public function setIsRequired(bool $isRequired): self
    {
        $this->isRequired = $isRequired;

        return $this;
    }
}
