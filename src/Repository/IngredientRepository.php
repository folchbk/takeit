<?php

namespace App\Repository;

use App\Entity\Ingredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @method Ingredient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ingredient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ingredient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientRepository extends ServiceEntityRepository
{

    private $session;
    private $deal;
    private $local;

    public function __construct(RegistryInterface $registry, SessionInterface $session)
    {
        parent::__construct($registry, Ingredient::class);
        $this->session = $session;
        $this->deal = $this->session->get('deal');
        $this->local = $this->session->get('local');
    }

     /**
      * @return Ingredient[] Returns an array of Ingredient objects
      */
    public function findAll()
    {
        if ($this->local != null) {
            return $this->createQueryBuilder('i')
                ->andWhere('i.local = :local')
                ->setParameter('local', $this->local->getId())
                ->orderBy('i.id', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
                ;
        } else {
            return $this->createQueryBuilder('i');
        }
    }

    /**
     * Método utilizado en los FormsTypes para añadir
     * una cláusula WHERE en la consulta que recupera
     * los elementos. En este caso solo recupera
     * los ingredientes que tienen relación con el
     * local activo.
     * @return \Doctrine\ORM\QueryBuilder
     */
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
    //  * @return Ingredient[] Returns an array of Ingredient objects
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
    public function findOneBySomeField($value): ?Ingredient
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
