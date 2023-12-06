<?php

namespace App\Repository;

use App\Entity\Cours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cours[]    findAll()
 * @method Cours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }
    public function findCoursListe($em)
    {
      return $em->createQuery(
        "SELECT c.nomUe, c.id, c.groupeTd
        FROM App\Entity\Cours c
        ORDER BY c.nomUe ASC"
        )->getResult();
    }
    public function findNomDuCours($em, $idCours)
    {
      return $em->createQuery(
        "SELECT c.nomUe as nomCours
        FROM App\Entity\Cours c
        WHERE c.id = '".$idCours."'"
        )->getResult();
    }
    public function findProfsParCours($em, $idCours)
    {
      return $em->createQuery(
        "SELECT DISTINCT u.nomUtilisateur, u.email, u.prenomUtilisateur, u.numeroEtudiant
        FROM App\Entity\Utilisateur u
        LEFT JOIN App\Entity\ProfCours p WITH u.id = p.prof
        INNER JOIN App\Entity\Cours c WITH p.cours = c.id
        ORDER BY u.nomUtilisateur ASC"
        )->getResult();
    }
    public function findEtudiantsParCours($em, $idCours)
    {
      return $em->createQuery(
        "SELECT DISTINCT u.nomUtilisateur, u.email, u.prenomUtilisateur, u.numeroEtudiant, f.nomFormation
        FROM App\Entity\Utilisateur u
        INNER JOIN App\Entity\EtudiantCours ec WITH u.id = ec.etudiant
        INNER JOIN App\Entity\Cours c WITH ec.cours = c.id
        INNER JOIN App\Entity\Formation f WITH u.formation = f.id
        AND u.roles = '[\"ROLE_USER\"]'
        ORDER BY u.nomUtilisateur ASC"
        )->getResult();
    }
    public function findCoursParProf($em, $idProf)
    {
      return $em->createQuery(
        "SELECT DISTINCT u.nomUtilisateur, u.email, u.prenomUtilisateur, u.numeroEtudiant, c.id, c.nomUe, c.groupeTd
        FROM App\Entity\Utilisateur u
        INNER JOIN App\Entity\ProfCours p WITH u.id = p.prof
        INNER JOIN App\Entity\Cours c WITH p.cours = c.id
        AND u.id = '".$idProf."'
        ORDER BY c.nomUe ASC"
        )->getResult();
    }
    public function findCoursParEtudiant($em, $idEtudiant)
    {
      return $em->createQuery(
        "SELECT u.nomUtilisateur, u.email, u.prenomUtilisateur, u.numeroEtudiant, c.id, c.nomUe, c.groupeTd
        FROM App\Entity\Utilisateur u
        INNER JOIN App\Entity\EtudiantCours ec WITH u.id = ec.etudiant
        INNER JOIN App\Entity\Cours c WITH ec.cours = c.id
        AND u.id = '".$idEtudiant."'
        ORDER BY c.nomUe ASC"
        )->getResult();
    }
}
