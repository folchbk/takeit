<?php

namespace App\Repository;

use App\Entity\CategoryProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @method CategoryProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryProductRepository extends ServiceEntityRepository
{
    private $session;
    private $deal;
    private $local;

    public function __construct(RegistryInterface $registry, SessionInterface $session)
    {
        parent::__construct($registry, CategoryProduct::class);
        $this->session = $session;
        $this->deal = $this->session->get('deal');
        $this->local = $this->session->get('local');
    }

    public function findByFamilyNull() {
        return $this->createQueryBuilder('c')
            ->andWhere('c.categoryProduct IS NULL')
            ->andWhere('c.local = :local')
            ->setParameter('local', $this->local)
            ->orderBy('c.shownOrder', 'ASC')
            ->getQuery()
            ->getResult();
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
