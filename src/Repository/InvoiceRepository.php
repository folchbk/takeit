<?php

namespace App\Repository;

use App\Entity\Invoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @method Invoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceRepository extends ServiceEntityRepository
{
    private $session;
    private $deal;
    private $local;

    public function __construct(RegistryInterface $registry, SessionInterface $session)
    {
        parent::__construct($registry, Invoice::class);
        $this->session = $session;
        $this->deal = $this->session->get('deal');
        $this->local = $this->session->get('local');
    }

    /**
     * @return Invoice[] Returns an array of Ingredient objects
     */
    public function findAll()
    {
        if ($this->deal != null) {
            return $this->createQueryBuilder('in')->select('i')
                ->from('App\Entity\Invoice', 'i')
                ->join('i.client', 'cl')
                ->join('cl.tableObject', 't')
                ->join('t.local', 'l')
                ->where('l.id = :local')
                ->setParameter('local', $this->local)
                ->orderBy('in.createdAt', 'ASC')
                ->getQuery()
                ->getResult();
        } else {
            return $this->createQueryBuilder('u');
        }
    }


    // /**
    //  * @return Invoice[] Returns an array of Invoice objects
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
    public function findOneBySomeField($value): ?Invoice
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
