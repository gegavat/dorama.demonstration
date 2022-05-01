<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks()
 */
class Product
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $priceMain;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priceCross;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $weight;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageName;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="imageName")
     * @var File
     */
    private $imageFile;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $sizeDeviation = 3;
        $sizeErrMess = "Пропорции изображения должны быть: " . $_ENV['PRODUCT_IMAGE_WIDTH'] . "x" . $_ENV['PRODUCT_IMAGE_HEIGHT'] . "px";
        $mimeTypeErrMess = "Доступна загрузка только jpg-изображений";
        $metadata->addPropertyConstraint('imageFile', new Assert\Image([
            'minWidth' => $_ENV['PRODUCT_IMAGE_WIDTH'] - $sizeDeviation,
            'maxWidth' => $_ENV['PRODUCT_IMAGE_WIDTH'] + $sizeDeviation,
            'minHeight' => $_ENV['PRODUCT_IMAGE_HEIGHT'] - $sizeDeviation,
            'maxHeight' => $_ENV['PRODUCT_IMAGE_HEIGHT'] + $sizeDeviation,
            'minWidthMessage' => $sizeErrMess,
            'maxWidthMessage' => $sizeErrMess,
            'minHeightMessage' => $sizeErrMess,
            'maxHeightMessage' => $sizeErrMess,
            'mimeTypes' => ["image/jpeg", "image/jpg"],
            'mimeTypesMessage' => $mimeTypeErrMess
        ]));
    }

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean", options={"default": "1"})
     */
    private $is_popular;

    /**
     * @ORM\ManyToMany(targetEntity=Configurator::class, mappedBy="product")
     */
    private $configurators;

    /**
     * @ORM\Column(type="boolean", options={"default": "1"})
     */
    private $isActive;

    public function __construct()
    {
        $this->configurators = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPriceMain(): ?int
    {
        return $this->priceMain;
    }

    public function setPriceMain(int $priceMain): self
    {
        $this->priceMain = $priceMain;

        return $this;
    }

    public function getPriceCross(): ?int
    {
        return $this->priceCross;
    }

    public function setPriceCross(?int $priceCross): self
    {
        $this->priceCross = $priceCross;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->updatedAt = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
    }

    public function getIsPopular(): ?bool
    {
        return $this->is_popular;
    }

    public function setIsPopular(bool $is_popular): self
    {
        $this->is_popular = $is_popular;

        return $this;
    }

    /**
     * @return Collection|Configurator[]
     */
    public function getConfigurators(): Collection
    {
        return $this->configurators;
    }

    public function addConfigurator(Configurator $configurator): self
    {
        if (!$this->configurators->contains($configurator)) {
            $this->configurators[] = $configurator;
            $configurator->addProduct($this);
        }

        return $this;
    }

    public function removeConfigurator(Configurator $configurator): self
    {
        if ($this->configurators->removeElement($configurator)) {
            $configurator->removeProduct($this);
        }

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
