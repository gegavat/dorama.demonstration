<?php

namespace App\Repository;

use App\Entity\Product;
use App\Service\ResizeProductImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    protected const POPULAR_CATEGORY = -1;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
    * @return Product[] Returns an array of Product objects
    */
    public function findByIsPopular($value = 1)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.is_popular = :val')
            ->andWhere('p.isActive = true')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findByCategoryId($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.category = :val')
            ->andWhere('p.isActive = true')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findOneById($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getProductDataByCategory($catId, $imagePath)
    {
        if ( $catId == self::POPULAR_CATEGORY ) {
            $productDataDb = $this->findByIsPopular();
        } else {
            $productDataDb = $this->findByCategoryId($catId);
        }
        $products = [];
        foreach ( $productDataDb as $product ) {
            /* @var $product Product */
            $configurators = [];
            foreach ( $product->getConfigurators() as $configurator ) {
                $items = [];
                foreach ( $configurator->getConfiguratorItems() as $item ) {
                    $items[] = (object) [
                        'id' => $item->getId(),
                        'name' => $item->getName(),
                        'price' => (int)substr($item->getPrice(), 0, -2)
                    ];
                }
                $configurators[] = (object) [
                    'id' => $configurator->getId(),
                    'name' => $configurator->getName(),
                    'is_multiple' => $configurator->getIsMultiple(),
                    'is_required' => $configurator->getIsRequired(),
                    'items' => $items
                ];
            }
            $products[] = (object) [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'desc_truncated' => iconv_strlen($product->getDescription(),'UTF-8') > $_ENV['TRUNCATED_PROD_DESC_LENGTH'] ?
                    iconv_substr($product->getDescription(),0, $_ENV['TRUNCATED_PROD_DESC_LENGTH'],'UTF-8') . '...' :
                    $product->getDescription(),
                'price_main' => (int)substr($product->getPriceMain(), 0, -2),
                'price_cross' => (int)substr($product->getPriceCross(), 0, -2),
                'rating' => $product->getRating(),
                'weight' => $product->getWeight(),
                'image_name' => ResizeProductImage::getResizedImagePath($imagePath. '/' . $product->getImageName()),
                'configurators' => $configurators
            ];
        }
        return $products;
    }

}
