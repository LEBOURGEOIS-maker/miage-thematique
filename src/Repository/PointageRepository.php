<?php

namespace App\Repository;

use App\Entity\Pointage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pointage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pointage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pointage[]    findAll()
 * @method Pointage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PointageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pointage::class);
    }

    public function AdminfindAll($entityManager)
  	{
      $fullQuery = "SELECT p.id, p.datePointageEntree, p.datePointageSortie, e.prenomUtilisateur, e.nomUtilisateur, e.numeroEtudiant, c.nomUe, pl.plageHoraire, f.nomFormation, p.commentaire, p.commentaireSortie, p.PointeParAdmin, p.retard, p.partiEnAvance
      FROM App\Entity\Pointage p
      INNER JOIN App\Entity\Utilisateur e, App\Entity\Cours c, App\Entity\PlageHoraire pl, App\Entity\Formation f
      WHERE e.id = p.utilisateurEtudiant
      AND c.id = p.cours
      AND e.formation = f.id
      AND pl.id = p.plageHoraire
      ORDER BY p.id DESC, c.nomUe DESC";

      return $entityManager->createQuery($fullQuery)->getResult();
  	}

    public function AdminFindBetweenTwoDates($entityManager, $dateDebut, $dateFin)
  	{
      $fullQuery = "SELECT p.id, p.datePointageEntree, p.datePointageSortie, e.prenomUtilisateur, e.nomUtilisateur, e.numeroEtudiant, c.nomUe, pl.plageHoraire, f.nomFormation, p.commentaire, p.commentaireSortie, p.PointeParAdmin, p.retard, p.partiEnAvance
      FROM App\Entity\Pointage p
      INNER JOIN App\Entity\Utilisateur e, App\Entity\Cours c, App\Entity\PlageHoraire pl, App\Entity\Formation f
      WHERE e.id = p.utilisateurEtudiant
      AND c.id = p.cours
      AND e.formation = f.id
      AND pl.id = p.plageHoraire
      and (p.datePointageEntree BETWEEN '".$dateDebut."' AND '".$dateFin."'
      or p.datePointageSortie BETWEEN '".$dateDebut."' AND '".$dateFin."')
      ORDER BY p.id DESC, c.nomUe DESC";

      dump($fullQuery);

      return $entityManager->createQuery($fullQuery)->getResult();
  	}

    public function findPointageSortieByEtudiant($utilisateurEtudiant)
    {
      $id = $utilisateurEtudiant->getId();

      return $this->createQueryBuilder('p')
      ->where('p.utilisateurEtudiant = :idEtu')
      ->andWhere('p.datePointageEntree IS NOT NULL')
      ->andWhere('p.datePointageSortie IS NULL')
      ->setParameter('idEtu', $id)
      ->getQuery()
      ->getResult();
    }

    public function findByPointageByEtudiant($utilisateurEtudiant)
    {
      $id = $utilisateurEtudiant->getId();

      return $this->createQueryBuilder('p')
      ->where('p.utilisateurEtudiant = :idEtu')
      ->andWhere('p.datePointageEntree IS NULL')
      ->andWhere('p.datePointageSortie IS NULL')
      ->setParameter('idEtu', $id)
      ->getQuery()
      ->getResult();
    }

    public function findByPointageByEtudiantAndCours($utilisateurEtudiant, $idCours)
    {
      $id = $utilisateurEtudiant->getId();

      return $this->createQueryBuilder('p')
      ->where('p.utilisateurEtudiant = :idEtu')
      ->andWhere('p.cours = :idCours')
      ->andWhere('p.datePointageEntree IS NULL')
      ->andWhere('p.datePointageSortie IS NULL')
      ->setParameter('idEtu', $id)
      ->setParameter('idCours', $idCours)
      ->getQuery()
      ->getResult();
    }

    public function findCoursByName($cours)
    {
      return $this->createQueryBuilder('c')
      ->where(expr()->like('c.nomUe', ':co'))
      ->setParameter('co', $cours)
      ->getQuery()
      ->getResult();
    }

    public function findPointageByWeek($em, $etudiant, $date, $dateFinSemaine)
    {
      return $em->createQuery(
        'SELECT p.datePointageEntree, p.datePointageSortie, u.prenomUtilisateur, u.nomUtilisateur, u.numeroEtudiant,
        c.nomUe, pl.plageHoraire, p.commentaire, p.commentaireSortie, p.retard, p.PointeParAdmin, p.partiEnAvance, f.nomFormation, p.dureePointage
        FROM App\Entity\Pointage p
        INNER JOIN App\Entity\Utilisateur u, App\Entity\Cours c, App\Entity\PlageHoraire pl, App\Entity\Formation f
        WHERE p.datePointageEntree BETWEEN :dateD AND :dateF
        AND p.utilisateurEtudiant = :etudiant
        AND u.id = p.utilisateurEtudiant
        AND c.id = p.cours
        AND pl.id = p.plageHoraire
        AND f.id = p.formation
        ORDER BY p.datePointageEntree desc'
        )->setParameter('dateD', $date)
        ->setParameter('dateF', $dateFinSemaine)
        ->setParameter('etudiant', $etudiant)
        ->getResult();
    }
    public function findPointageTotaux($em, $user)
    {
      return $em->createQuery(
        "SELECT DISTINCT p.datePointageEntree, p.datePointageSortie, p.absence, c.nomUe
        FROM App\Entity\Pointage p
        INNER JOIN App\Entity\Utilisateur u WITH p.utilisateurEtudiant = u.id
        JOIN App\Entity\CoursPlanning cp WITH p.cours = cp.id
        JOIN App\Entity\Cours c WITH cp.cours = c.id
        AND p.utilisateurEtudiant = :etudiant
        AND cp.id != '1'
        ORDER BY p.datePointageSortie ASC"
        )->setParameter('etudiant', $user)
        ->getResult();
    }
    public function findPointageByUEForToday($entityManager, $cours)
    {
      dump($cours);
      return $entityManager->createQuery(
      "SELECT distinct(p.utilisateurEtudiant), e.numeroEtudiant ,e.nomUtilisateur, e.prenomUtilisateur, p.datePointageEntree, p.datePointageSortie, p.commentaire, p.commentaireSortie, c.nomUe, f.nomFormation, ph.plageHoraire
      FROM App\Entity\Pointage p
      INNER JOIN App\Entity\Utilisateur e, App\Entity\Cours c, App\Entity\PlageHoraire ph, App\Entity\Formation f
      WHERE c.nomUe = :cours
      AND p.datePointageEntree > CURRENT_DATE()
      AND e.id = p.utilisateurEtudiant
      AND c.id = p.cours
      AND ph.id = p.plageHoraire
      AND f.id = p.formation
      ORDER BY e.nomUtilisateur, p.datePointageEntree DESC"
      )->setParameter('cours', $cours)
       ->getResult();
    }

    public function findAllPointageByDate($em, $date, $dateFinSemaine)
    {
      return $em->createQuery(
        'SELECT p.id, p.datePointageEntree, p.datePointageSortie, u.prenomUtilisateur, u.nomUtilisateur, u.numeroEtudiant,
        c.nomUe, pl.plageHoraire, p.commentaire, p.commentaireSortie, p.retard, p.PointeParAdmin, p.partiEnAvance, f.nomFormation, p.dureePointage
        FROM App\Entity\Pointage p
        INNER JOIN App\Entity\Utilisateur u, App\Entity\Cours c, App\Entity\PlageHoraire pl, App\Entity\Formation f
        WHERE p.datePointageEntree BETWEEN :dateD AND :dateF
        AND u.id = p.utilisateurEtudiant
        AND c.id = p.cours
        AND pl.id = p.plageHoraire
        AND f.id = p.formation
        ORDER BY p.datePointageEntree ASC'
        )->setParameter('dateD', $date)
        ->setParameter('dateF', $dateFinSemaine)
        ->getResult();
    }

    public function findAllAnomalieByDate($em, $date, $dateFinSemaine)
    {
      return $em->createQuery(
        'SELECT p.id, p.datePointageEntree, p.datePointageSortie, u.prenomUtilisateur, u.nomUtilisateur, u.numeroEtudiant,
        c.nomUe, pl.plageHoraire, p.commentaire, p.commentaireSortie, p.retard, p.PointeParAdmin, p.partiEnAvance, f.nomFormation, p.dureePointage
        FROM App\Entity\Pointage p
        INNER JOIN App\Entity\Utilisateur u, App\Entity\Cours c, App\Entity\PlageHoraire pl, App\Entity\Formation f
        WHERE (p.datePointageEntree BETWEEN :dateD AND :dateF)
        AND u.id = p.utilisateurEtudiant
        AND c.id = p.cours
        AND pl.id = p.plageHoraire
        AND f.id = p.formation
        AND (p.retard > 0 OR p.partiEnAvance = 1)
        ORDER BY p.datePointageEntree ASC'
        )->setParameter('dateD', $date)
        ->setParameter('dateF', $dateFinSemaine)
        ->getResult();
    }

    public function CountPointageByDate($em, $date, $dateFinSemaine)
    {
      return $em->createQuery(
        'SELECT COUNT(u.nomUtilisateur)
        FROM App\Entity\Pointage p
        INNER JOIN App\Entity\Utilisateur u, App\Entity\Cours c, App\Entity\PlageHoraire pl, App\Entity\Formation f
        WHERE p.datePointageEntree BETWEEN :dateD AND :dateF
        AND u.id = p.utilisateurEtudiant
        AND c.id = p.cours
        AND pl.id = p.plageHoraire
        AND f.id = p.formation
        ORDER BY p.datePointageEntree ASC'
        )->setParameter('dateD', $date)
        ->setParameter('dateF', $dateFinSemaine)
        ->getSingleScalarResult();
    }

    public function CountAnomalieByDate($em, $date, $dateFinSemaine)
    {
      return $em->createQuery(
        'SELECT COUNT(u.nomUtilisateur)
        FROM App\Entity\Pointage p
        INNER JOIN App\Entity\Utilisateur u, App\Entity\Cours c, App\Entity\PlageHoraire pl, App\Entity\Formation f
        WHERE p.datePointageEntree BETWEEN :dateD AND :dateF
        AND u.id = p.utilisateurEtudiant
        AND c.id = p.cours
        AND pl.id = p.plageHoraire
        AND f.id = p.formation
        AND (p.retard>0 OR p.partiEnAvance=1)
        ORDER BY p.datePointageEntree ASC'
        )->setParameter('dateD', $date)
        ->setParameter('dateF', $dateFinSemaine)
        ->getSingleScalarResult();
    }

    public function CountRetardByDate($em, $date, $dateFinSemaine)
    {
      return $em->createQuery(
        'SELECT COUNT(p.retard)
        FROM App\Entity\Pointage p
        INNER JOIN App\Entity\Utilisateur u, App\Entity\Cours c, App\Entity\PlageHoraire pl, App\Entity\Formation f
        WHERE p.datePointageEntree BETWEEN :dateD AND :dateF
        AND u.id = p.utilisateurEtudiant
        AND c.id = p.cours
        AND pl.id = p.plageHoraire
        AND f.id = p.formation
        AND p.retard > 0
        ORDER BY p.datePointageEntree ASC'
        )->setParameter('dateD', $date)
        ->setParameter('dateF', $dateFinSemaine)
        ->getSingleScalarResult();
    }

    public function CountPartiAvanceByDate($em, $date, $dateFinSemaine)
    {
      return $em->createQuery(
        'SELECT COUNT(p.partiEnAvance)
        FROM App\Entity\Pointage p
        INNER JOIN App\Entity\Utilisateur u, App\Entity\Cours c, App\Entity\PlageHoraire pl, App\Entity\Formation f
        WHERE p.datePointageEntree BETWEEN :dateD AND :dateF
        AND u.id = p.utilisateurEtudiant
        AND c.id = p.cours
        AND pl.id = p.plageHoraire
        AND f.id = p.formation
        AND p.partiEnAvance = 1
        ORDER BY p.datePointageEntree ASC'
        )->setParameter('dateD', $date)
        ->setParameter('dateF', $dateFinSemaine)
        ->getSingleScalarResult();
    }

}
