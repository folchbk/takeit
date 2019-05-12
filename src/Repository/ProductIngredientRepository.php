<?php

namespace App\Repository;

use App\Entity\ProductIngredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @method ProductIngredient|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductIngredient|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductIngredient[]    findAll()
 * @method ProductIngredient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductIngredientRepository extends ServiceEntityRepository
{
    private $session;
    private $deal;
    private $local;


    public function __construct(RegistryInterface $registry, SessionInterface $session)
    {
        parent::__construct($registry, ProductIngredient::class);
        $this->session = $session;
        $this->deal = $this->session->get('deal');
        $this->local = $this->session->get('local');
    }

//     /**
//      * @return ProductIngredient[] Returns an array of ProductIngredient objects
//      */
//    public function findByLocal()
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.local = :local')
//            ->setParameter('local', $this->local->getId())
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }


    // /**
    //  * @return ProductIngredient[] Returns an array of ProductIngredient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductIngredient
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
