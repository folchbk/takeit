<?php

namespace App\Repository;

use App\Entity\CategoryProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CategoryProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CategoryProduct::class);
    }


    public function findAll()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.shownOrder', 'ASC')
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?CategoryProduct
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
