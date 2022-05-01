<?php

namespace App\Repository;

use App\Entity\ConfiguratorItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConfiguratorItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConfiguratorItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConfiguratorItem[]    findAll()
 * @method ConfiguratorItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfiguratorItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConfiguratorItem::class);
    }

    public function findOneById($value): ?ConfiguratorItem
    {
        return $this->createQueryBuilder('ci')
            ->andWhere('ci.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    // /**
    //  * @return ConfiguratorItem[] Returns an array of ConfiguratorItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ConfiguratorItem
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
