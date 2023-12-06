<?php

namespace App\Repository;

use App\Entity\PlageHoraire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlageHoraire|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlageHoraire|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlageHoraire[]    findAll()
 * @method PlageHoraire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlageHoraireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlageHoraire::class);
    }

    // /**
    //  * @return PlageHoraire[] Returns an array of PlageHoraire objects
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
    public function findOneBySomeField($value): ?PlageHoraire
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
