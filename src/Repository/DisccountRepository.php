<?php

namespace App\Repository;

use App\Entity\Disccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Disccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method Disccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method Disccount[]    findAll()
 * @method Disccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DisccountRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Disccount::class);
    }

    // /**
    //  * @return Disccount[] Returns an array of Disccount objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Disccount
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
