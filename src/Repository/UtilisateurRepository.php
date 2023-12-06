<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Utilisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateur[]    findAll()
 * @method Utilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }
    public function findProfsListe($em)
    {
        return $em->createQuery(
          "SELECT DISTINCT u.nomUtilisateur, u.email, u.prenomUtilisateur, u.numeroEtudiant, u.id
          FROM App\Entity\Utilisateur u
          WHERE u.roles LIKE  '%ROLE_PROF%'
          ORDER BY u.nomUtilisateur ASC"
          )->getResult();
      }
    public function findEtudiantsListe($em)
        {
          return $em->createQuery(
            "SELECT DISTINCT u.nomUtilisateur, u.email, u.prenomUtilisateur, u.numeroEtudiant, u.id
            FROM App\Entity\Utilisateur u
            WHERE u.roles LIKE  '%ROLE_USER%'
            ORDER BY u.nomUtilisateur ASC"
            )->getResult();
        }
    public function findCountEtudiantM1MIAGE($em)
    {
      return $em->createQuery(
        "SELECT COUNT(u.formation) AS M1MIAGE
        FROM App\Entity\Utilisateur u
        WHERE u.formation = 5"
        )->getResult();
    }
    public function findCountEtudiantM2OSIE($em)
    {
      return $em->createQuery(
        "SELECT COUNT(u.formation) AS OSIE
        FROM App\Entity\Utilisateur u
        WHERE u.formation = 6"
        )->getResult();
    }
    public function findCountEtudiantM2SIO($em)
    {
      return $em->createQuery(
        "SELECT COUNT(u.formation) AS SIO
        FROM App\Entity\Utilisateur u
        WHERE u.formation = 7"
        )->getResult();
    }
    public function findCountEtudiantM2INE($em)
    {
      return $em->createQuery(
        "SELECT COUNT(u.formation) AS INE
        FROM App\Entity\Utilisateur u
        WHERE u.formation = 8"
        )->getResult();
    }
        // /**
    //  * @return Utilisateur[] Returns an array of Utilisateur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Utilisateur
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
