<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    private $session;
    private $deal;
    private $local;

    public function __construct(RegistryInterface $registry, SessionInterface $session)
    {
        parent::__construct($registry, Client::class);
        $this->session = $session;
        $this->deal = $this->session->get('deal');
        $this->local = $this->session->get('local');
    }

    /**
     * @return Client[] Returns an array of Ingredient objects
     */
    public function findAll()
    {
        if ($this->deal != null) {
            return $this->createQueryBuilder('c')->select('cl')
                ->from('App\Entity\Client', 'cl')
                ->join('cl.tableObject', 't')
                ->join('t.local', 'l')
                ->where('l.id = :local')
                ->setParameter('local', $this->local)
                ->orderBy('c.createdAt', 'ASC')
                ->getQuery()
                ->getResult();
        } else {
            return $this->createQueryBuilder('u');
        }
    }


    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createAlphabeticalQueryBuilder()
    {
        if ($this->deal != null) {
            return $this->createQueryBuilder('c')->select('cl')
                ->from('App\Entity\Client', 'cl')
                ->join('cl.tableObject', 't')
                ->join('t.local', 'l')
                ->where('l.id = :local')
                ->setParameter('local', $this->local)
                ->orderBy('c.createdAt', 'ASC');
        } else {
            return $this->createQueryBuilder('u');
        }
    }


    // /**
    //  * @return Client[] Returns an array of Client objects
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
    public function findOneBySomeField($value): ?Client
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
