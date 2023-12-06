<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use App\Entity\Formation;
use App\Entity\AbsencesJustifications;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AbsencesJustifications|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbsencesJustifications|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbsencesJustifications[]    findAll()
 * @method AbsencesJustifications[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbsencesJustificationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbsencesJustifications::class);
    }

    public function findAllJustifiedAbsences($em)
    {
      return $em->createQuery(
        "SELECT a.id, u.nomUtilisateur, u.email, u.prenomUtilisateur, f.nomFormation AS formation, a.lienFichier, 
        a.date, a.dateDebut, a.heureDebut, a.dateFin, a.heureFin, a.valider
        FROM App\Entity\AbsencesJustifications a 
        INNER JOIN App\Entity\Utilisateur u WITH a.utilisateurEtudiant = u.id
        JOIN App\Entity\Formation f WITH a.formation = f.id
        ORDER BY a.date ASC"
        )->getResult();
    }
    public function findStudentJustifiedAbs($em, $utilisateurEtudiant)
    {
        return $em->createQuery(
        "SELECT a.id, u.nomUtilisateur, u.email, u.prenomUtilisateur, IDENTITY(a.formation) AS formation, a.lienFichier, a.date,
        a.dateDebut, a.dateFin, a.heureDebut, a.heureFin, a.valider
        FROM App\Entity\AbsencesJustifications a 
        INNER JOIN App\Entity\Utilisateur u WITH a.utilisateurEtudiant = u.id
        AND a.utilisateurEtudiant = '".$utilisateurEtudiant."'
        ORDER BY a.date ASC"
        )->getResult(); 
    }
    /*
    public function UpdateStateEmargement( $id, $valider)
    {  
      // dans un repository on peut directement accéder à l'entiyManynagerInterface grâce à la propriété $ths->_em 
        return $this->_em->createQuery(
           "UPDATE App\Entity\AbsencesJustifications a 
           SET a.valider = :valider
           WHERE a.id = :id "
         )->setParameters([ 'id'  => $id, 'valider'  => $valider ])
         ->getResult();
    }
    */
}
