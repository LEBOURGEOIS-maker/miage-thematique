<?php

namespace App\Repository;

use App\Entity\Cours;
use App\Entity\Utilisateur;
use App\Entity\ProfCours;
use App\Entity\AbsencesJustifications;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProfCours|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfCours|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfCours[]    findAll()
 * @method ProfCours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfCoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfCours::class);
    }
    public function findAllLessonsByTeacher($em, $utilisateurProf)
    {
      return $em->createQuery(
        "SELECT c.id, u.prenomUtilisateur, c.nomUe, c.groupeTd
        FROM App\Entity\ProfCours p
        INNER JOIN App\Entity\Cours c
        JOIN App\Entity\Utilisateur u 
        WHERE p.cours = c.id 
        AND p.prof = u.id
        AND u.id = '".$utilisateurProf."'"
        )->getResult();
    }
    public function findAllJustificationsByClass($em, $lessonSelected)
    {
      return $em->createQuery(
        "SELECT c.id, p.prof, u.prenomUtilisateur, u.id, c.nomUe
        FROM App\Entity\ProfCours p
        INNER JOIN App\Entity\Cours c
        JOIN App\Entity\Utilisateur u 
        WHERE p.cours = c.id AND p.prof = u.id
        AND u.id = '".$lessonSelected."'"
        )->getResult();
    }
    public function findHorairesParCours($em, $utilisateurProf, $idCours)
    {
      return $em->createQuery(
        "SELECT c.nomUe, w.plageHoraire, c.id AS idCours, w.id AS idCreneau, d.dateCours AS ladate, d.id AS dateCours, c.groupeTd
        FROM App\Entity\CoursPlanning h
        INNER JOIN App\Entity\Cours c
        JOIN App\Entity\ProfCours p
        JOIN App\Entity\Utilisateur u
        JOIN App\Entity\PlageHoraire w
        JOIN App\Entity\DateCours d
        WHERE h.plageHoraire = w.id
        AND h.cours = c.id
        AND c.id = p.cours
        AND p.prof = u.id
        AND u.id = '".$utilisateurProf."'
        AND c.id = '".$idCours."'
        AND h.dateCours = d.id"
        )->getResult();
    }
    public function findAllEmargementsPassesParCours($em, $utilisateurProf, $idCours, $idDate, $idCreneau)
    {
      return $em->createQuery(
        "SELECT u.nomUtilisateur, u.prenomUtilisateur, c.nomUe, w.plageHoraire, d.dateCours,
         f.nomFormation, po.datePointageEntree, po.partiEnAvance, po.dureePointage, po.datePointageSortie, po.absence, u.email, po.id
        FROM App\Entity\CoursPlanning h
        INNER JOIN App\Entity\Cours c
        JOIN App\Entity\ProfCours p
        JOIN App\Entity\Utilisateur u
        JOIN App\Entity\CoursPlanning cp
        JOIN App\Entity\EtudiantCours ec
        JOIN App\Entity\PlageHoraire w
        JOIN App\Entity\DateCours d
        JOIN App\Entity\Formation f
        JOIN App\Entity\Pointage po
        WHERE h.plageHoraire = w.id
        AND h.cours = c.id
        AND c.id = p.cours
        AND c.id = '".$idCours."'
        AND w.id = '".$idCreneau."'
        AND cp.dateCours = '".$idDate."'
        AND h.dateCours = d.id
        AND u.formation = f.id
        AND u.formation = po.formation
        AND u.roles = '[\"ROLE_USER\"]'
        AND cp.cours = '".$idCours."'
        AND cp.id = po.cours
        AND po.utilisateurEtudiant = u.id
        AND u.id = ec.etudiant
        AND ec.cours = c.id
        ORDER BY u.nomUtilisateur DESC
        "
        )->getResult();
    }
    public function findEtudiantPasPointer($em, $utilisateurProf, $idCours, $idDate, $idCreneau)
    {
      $query = $em->createQuery("
      SELECT u.nomUtilisateur, u.prenomUtilisateur, u.id AS userID
      FROM App\Entity\EtudiantCours ec
      LEFT JOIN App\Entity\Pointage po WITH ec.etudiant = po.utilisateurEtudiant
      JOIN App\Entity\Utilisateur u WITH ec.etudiant = u.id
      JOIN App\Entity\Cours c WITH ec.cours = c.id
      JOIN App\Entity\CoursPlanning cp WITH po.cours = cp.id
      WHERE cp.cours = :idCours
      AND cp.dateCours = :idDate
      AND cp.plageHoraire = :idCreneau
      ")
      ->setParameter('idCours', $idCours)
      ->setParameter('idDate', $idDate)
      ->setParameter('idCreneau', $idCreneau);

      $result  = $query->getResult();
      return $result;
    }
    public function SYNTAXfindEtudiantPasPointer($em, $utilisateurProf, $idCours, $idDate, $idCreneau)
    {
      $query = $em->createQuery("
      SELECT u.nomUtilisateur, u.prenomUtilisateur, u.id AS userID
      FROM App\Entity\EtudiantCours ec
        LEFT JOIN App\Entity\Pointage po
          INNER JOIN App\Entity\Utilisateur u 
            WITH u.id = po.utilisateurEtudiant
          INNER JOIN App\Entity\CoursPlanning cp
            WITH cp.id = po.cours
            AND cp.cours = :idCours
            AND cp.plageHoraire = :idCreneau
            AND cp.dateCours = :idDate
        WITH po.utilisateurEtudiant = ec.etudiant
      WHERE po.utilisateurEtudiant is null
      ")
      ->setParameter('idCours', $idCours)
      ->setParameter('idDate', $idDate)
      ->setParameter('idCreneau', $idCreneau);

      $result  = $query->getResult();
      return $result;
    }
    public function OLDfindEtudiantPasPointer($em, $utilisateurProf, $idCours, $idDate, $idCreneau)
    {
      $query = $em->createQuery("
      SELECT u.nomUtilisateur, u.prenomUtilisateur, u.id AS userID
      FROM App\Entity\EtudiantCours ec
      JOIN App\Entity\Utilisateur u WITH ec.etudiant = u.id
      JOIN App\Entity\CoursPlanning cp
      JOIN App\Entity\Formation f WITH u.formation = f.id
      LEFT JOIN App\Entity\Pointage po WITH cp.plageHoraire = po.plageHoraire
      WHERE cp.cours = :idCours
      AND cp.plageHoraire = :idCreneau
      AND cp.dateCours = :idDate
      AND cp.cours= ec.cours
      ")
      ->setParameter('idCours', $idCours)
      ->setParameter('idDate', $idDate)
      ->setParameter('idCreneau', $idCreneau);

      $result  = $query->getResult();
      return $result;
    }
}
