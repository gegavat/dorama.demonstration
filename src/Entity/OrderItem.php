<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderItemRepository::class)
 */
class OrderItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $order;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToMany(targetEntity=ConfiguratorItem::class)
     */
    private $configuratorItems;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function __construct()
    {
        $this->configuratorItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

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
        }

        return $this;
    }

    public function removeConfiguratorItem(ConfiguratorItem $configuratorItem): self
    {
        $this->configuratorItems->removeElement($configuratorItem);

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
