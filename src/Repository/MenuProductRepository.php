<?php

namespace App\Repository;

use App\Entity\MenuProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MenuProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuProduct[]    findAll()
 * @method MenuProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MenuProduct::class);
    }

    // /**
    //  * @return MenuProduct[] Returns an array of MenuProduct objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MenuProduct
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
