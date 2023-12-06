<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PointageRepository")
 */
class Pointage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datePointageEntree;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datePointageSortie;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cours", inversedBy="pointage")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cours;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PlageHoraire", inversedBy="pointage")
     * @ORM\JoinColumn(nullable=false)
     */
    private $plageHoraire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="pointage")
     */
    private $utilisateurEtudiant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Formation", inversedBy="pointages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="boolean")
     */
    private $PointeParAdmin;

    /**
     * @ORM\Column(type="integer")
     */
    private $retard;

    /**
     * @ORM\Column(type="boolean")
     */
    private $partiEnAvance;

    /**
     * @ORM\Column(type="integer")
     */
    private $dureePointage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commentaireSortie;

    /**
     * @ORM\Column(type="boolean")
     */
    private $absenceJustifie;

    /**
     * @ORM\Column(type="boolean")
     */
    private $departJustifie;

    /**
     * @ORM\Column(type="boolean")
     */
    private $absence;

    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePointageEntree(): ?\DateTimeInterface
    {
        return $this->datePointageEntree;
    }

    public function setDatePointageEntree(\DateTimeInterface $datePointageEntree): self
    {
        $this->datePointageEntree = $datePointageEntree;

        return $this;
    }

    public function getDatePointageSortie(): ?\DateTimeInterface
    {
        return $this->datePointageSortie;
    }

    public function setDatePointageSortie(\DateTimeInterface $datePointageSortie): self
    {
        $this->datePointageSortie = $datePointageSortie;

        return $this;
    }

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): self
    {
        $this->cours = $cours;

        return $this;
    }

    public function getPlageHoraire(): ?PlageHoraire
    {
        return $this->plageHoraire;
    }

    public function setPlageHoraire(?PlageHoraire $plageHoraire): self
    {
        $this->plageHoraire = $plageHoraire;

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

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getPointeParAdmin(): ?bool
    {
        return $this->PointeParAdmin;
    }

    public function setPointeParAdmin(bool $PointeParAdmin): self
    {
        $this->PointeParAdmin = $PointeParAdmin;

        return $this;
    }

    public function getRetard(): ?int
    {
        return $this->retard;
    }

    public function setRetard(int $retard): self
    {
        $this->retard = $retard;

        return $this;
    }

    public function getPartiEnAvance(): ?bool
    {
        return $this->partiEnAvance;
    }

    public function setPartiEnAvance(bool $partiEnAvance): self
    {
        $this->partiEnAvance = $partiEnAvance;

        return $this;
    }

    public function getDureePointage(): ?int
    {
        return $this->dureePointage;
    }

    public function setDureePointage(int $dureePointage): self
    {
        $this->dureePointage = $dureePointage;

        return $this;
    }

    public function getCommentaireSortie(): ?string
    {
        return $this->commentaireSortie;
    }

    public function setCommentaireSortie(?string $commentaireSortie): self
    {
        $this->commentaireSortie = $commentaireSortie;

        return $this;
    }

    public function getAbsenceJustifie(): ?bool
    {
        return $this->absenceJustifie;
    }

    public function setAbsenceJustifie(bool $absenceJustifie): self
    {
        $this->absenceJustifie = $absenceJustifie;

        return $this;
    }

    public function getDepartJustifie(): ?bool
    {
        return $this->departJustifie;
    }

    public function setDepartJustifie(bool $departJustifie): self
    {
        $this->departJustifie = $departJustifie;

        return $this;
    }

    public function getAbsence(): ?bool
    {
        return $this->absence;
    }

    public function setAbsence(bool $absence): self
    {
        $this->absence = $absence;

        return $this;
    }
}
