<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    private $session;
    private $deal;
    private $local;

    public function __construct(RegistryInterface $registry, SessionInterface $session)
    {
        parent::__construct($registry, Product::class);
        $this->session = $session;
        $this->deal = $this->session->get('deal');
        $this->local = $this->session->get('local');
    }

    /**
     * @return Product[] Returns an array of Ingredient objects
     */
    public function findAll()
    {
        if ($this->local != null) {
            return $this->createQueryBuilder('p')
                ->andWhere('p.local = :local')
                ->setParameter('local', $this->local->getId())
                ->orderBy('p.id', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
                ;
        } else {
            return $this->
                createQueryBuilder('pa')
                ->select("p")
                ->from(Product::class, "p")
                ->orderBy("p.id", "ASC")
                ->getQuery()
                ->getResult();
        }
    }

    public function createAlphabeticalQueryBuilder() {

        if ($this->local != null) {
            return $this->createQueryBuilder('p')
                ->andWhere('p.local = :local')
                ->setParameter('local', $this->local->getId())
                ->orderBy('p.id', 'ASC');
        } else {
            return $this->createQueryBuilder('p');
        }
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
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
