<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\Promotion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Promotion>
 */
class PromotionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promotion::class);
    }

    public function findValidForProduct(Product $product, \DateTimeInterface $requestDate)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.productPromotions', 'pp')
            ->andWhere('pp.product = :product')
            ->andWhere('pp.valid_to >= :requestDate OR pp.valid_to IS NULL')
            ->setParameter('product', $product)
            ->setParameter('requestDate', $requestDate)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Promotion[] Returns an array of Promotion objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Promotion
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
