<?php

namespace App\Entity;

use App\Repository\SettingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SettingRepository::class)
 */
class Setting
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $siteName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $instagram;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $vk;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $telegram;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emails;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiteName(): ?string
    {
        return $this->siteName;
    }

    public function setSiteName(string $siteName): self
    {
        $this->siteName = $siteName;

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

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getVk(): ?string
    {
        return $this->vk;
    }

    public function setVk(?string $vk): self
    {
        $this->vk = $vk;

        return $this;
    }

    public function getTelegram(): ?string
    {
        return $this->telegram;
    }

    public function setTelegram(?string $telegram): self
    {
        $this->telegram = $telegram;

        return $this;
    }

    public function getEmails(): ?string
    {
        return $this->emails;
    }

    public function setEmails(?string $emails): self
    {
        $this->emails = $emails;

        return $this;
    }
}
