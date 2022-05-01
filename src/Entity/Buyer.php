<?php

namespace App\Entity;

use App\Repository\BuyerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BuyerRepository::class)
 */
class Buyer
{
    public const DELIVERY_TYPE_SHIPMENT = 5;
    public const DELIVERY_TYPE_PICKUP = 10;

    public const PAY_TYPE_RECEIPT = 5;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, inversedBy="buyer", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $order;

    /**
     * @Assert\Length(
     *      min = 4,
     *      minMessage = "Your first name must be at least {{ limit }} characters long"
     * )
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @Assert\NotBlank(
     *     message = "Укажите номер телефона"
     * )
     * @ORM\Column(type="string", length=100)
     */
    private $phone;

    /**
     * @Assert\NotBlank(
     *     message = "Укажите адрес доставки"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="integer", options={"default": "1"})
     */
    private $personCount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @Assert\NotBlank(
     *     message = "Выберите способ доставки"
     * )
     * @ORM\Column(type="integer")
     */
    private $deliveryType;

    /**
     * @ORM\Column(type="integer")
     */
    private $payType;

    /**
     * @ORM\Column(type="boolean")
     */
    private $callMe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPersonCount(): ?int
    {
        return $this->personCount;
    }

    public function setPersonCount(int $personCount): self
    {
        $this->personCount = $personCount;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getDeliveryType(): ?int
    {
        return $this->deliveryType;
    }

    public function setDeliveryType(int $deliveryType): self
    {
        $this->deliveryType = $deliveryType;

        return $this;
    }

    public function getPayType(): ?int
    {
        return $this->payType;
    }

    public function setPayType(int $payType): self
    {
        $this->payType = $payType;

        return $this;
    }

    public function getCallMe(): ?bool
    {
        return $this->callMe;
    }

    public function setCallMe(bool $callMe): self
    {
        $this->callMe = $callMe;

        return $this;
    }
}
