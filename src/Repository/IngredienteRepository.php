<?php

namespace App\Repository;

use App\Entity\Ingrediente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ingrediente|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ingrediente|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ingrediente[]    findAll()
 * @method Ingrediente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredienteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ingrediente::class);
    }

    // /**
    //  * @return Ingrediente[] Returns an array of Ingrediente objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ingrediente
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
