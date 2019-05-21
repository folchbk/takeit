<?php

namespace App\Repository;

use App\Entity\Local;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @method Local|null find($id, $lockMode = null, $lockVersion = null)
 * @method Local|null findOneBy(array $criteria, array $orderBy = null)
 * @method Local|null findByDeal($deal, array $orderBy = null)
 * @method Local[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocalRepository extends ServiceEntityRepository
{
    private $session;
    private $deal;
    private $local;

    public function __construct(RegistryInterface $registry, SessionInterface $session)
    {
        parent::__construct($registry, Local::class);
        $this->session = $session;
        $this->deal = $this->session->get('deal');
        $this->local = $this->session->get('local');
    }


     /**
      * @return Local[] Returns an array of Local objects
      */
    public function findAll()
    {
        if ($this->deal != null) {
            return $this->createQueryBuilder('l')
                ->andWhere('l.deal = :deal')
                ->setParameter('deal', $this->deal)
                ->orderBy('l.id', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult();
        } else {
            return $this->createQueryBuilder('l');
        }
    }

    /**
     * Método utilizado en los FormsTypes para añadir
     * una cláusula WHERE en la consulta que recupera
     * los elementos. En este caso solo recupera
     * los locales que tienen relación con el
     * negocio activo.
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createAlphabeticalQueryBuilder() {

        if ($this->deal != null) {
            return $this->createQueryBuilder('l')
                ->andWhere('l.deal = :deal')
                ->setParameter('deal', $this->deal)
                ->orderBy('l.id', 'ASC');
        } else {
            return $this->createQueryBuilder('l');
        }
    }


    // /**
    //  * @return Local[] Returns an array of Local objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Local
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
