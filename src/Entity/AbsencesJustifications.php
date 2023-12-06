<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AbsencesJustificationsRepository")
 */
class AbsencesJustifications
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur")
     * @ORM\JoinColumn(name="utilisateur_etudiant", referencedColumnName="id")
     */
    private $utilisateurEtudiant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Formation")
     * @ORM\JoinColumn(name="formation", referencedColumnName="id")
     */
    private $formation;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateDebut;
        /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateFin;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $heureDebut;
        /**
     * @ORM\Column(type="string", length=255)
     */
    private $heureFin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lienFichier;
        /**
     * @ORM\Column(type="string", length=255)
     */
    private $date;
    /**
     * @ORM\Column(type="integer")
     */
    private $valider;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCours(): ?string
    {
        return $this->cours;
    }

    public function setCours(string $cours): self
    {
        $this->cours = $cours;

        return $this;
    }
    public function getPlageHoraire(): ?string
    {
        return $this->plageHoraireJustifAbsence;
    }

    public function setPlageHoraire(string $plageHoraireJustifAbsence): self
    {
        $this->plageHoraire = $plageHoraireJustifAbsence;

        return $this;
    }
    public function getPlageHoraireJustifAbsence(): ?string
    {
        return $this->plageHoraireJustifAbsence;
    }

    public function setPlageHoraireJustifAbsence(string $plageHoraireJustifAbsence): self
    {
        $this->plageHoraireJustifAbsence = $plageHoraireJustifAbsence;

        return $this;
    }

    public function getUtilisateurEtudiant(): ?Utilisateur
    {
        return $this->utilisateurEtudiant;
    }

    public function setUtilisateurEtudiant(?Utilisateur $utilisateurEtudiant): self
    {
        $this->utilisateurEtudiant = $utilisateurEtudiant;

        return $this;
    }
    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    public function getLienFichier(): ?string
    {
        return $this->lienFichier;
    }

    public function setLienFichier(string $lienFichier): self
    {
        $this->lienFichier = $lienFichier;

        return $this;
    }
    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate()
    {
        $date = new \DateTime("now");
        $this->date = date_format($date, 'Y-m-d H:i:s');
        //$this->date = new \DateTime("now");
    }
    public function getDateDebut(): ?string
    {
        $dateDebut = "2020-06-20";
        return $this->dateDebut;
    }

    public function setDateDebut(string $dateDebut): self
    {
        $this->dateDebut = $dateDebut;
        
        return $this;
    }
    public function getDateFin(): ?string
    {
        $dateFin = "2020-06-25";
        return $this->dateFin;
    }

    public function setDateFin(string $dateFin): self
    {
        $this->dateFin = $dateFin;
        
        return $this;
    }
    public function getHeureDebut(): ?string
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(string $heureDebut): self
    {
        $this->heureDebut = $heureDebut;
        
        return $this;
    }
    public function getHeureFin(): ?string
    {
        return $this->heureFin;
    }

    public function setHeureFin(string $heureFin): self
    {
        $this->heureFin = $heureFin;
        
        return $this;
    }
    public function getValider(): ?int
    {
        return $this->valider;
    }
    public function setValider(int $valider): self
    {
        $this->valider = $valider;

        return $this;
    }
    public function getIdCoursEmarge(): ?int
    {
        return $this->idCoursEmarge;
    }
    public function setIdCoursEmarge(int $idCoursEmarge): self
    {
        $this->idCoursEmarge = $idCoursEmarge;

        return $this;
    }
}
