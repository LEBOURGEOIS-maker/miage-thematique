<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoursPlanningRepository")
 */
class CoursPlanning
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cours")
     * @ORM\JoinColumn(name="cours", referencedColumnName="id")
     */
    private $cours;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PlageHoraire", inversedBy="pointage")
     * @ORM\JoinColumn(nullable=false)
     */
    private $plageHoraire;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DateCours")
     * @ORM\JoinColumn(name="date_cours", referencedColumnName="id")
     */
    private $dateCours;

    public function __construct()
    {
        $this->formation = new ArrayCollection();
        $this->pointage = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCours(): ?int
    {
        return $this->cours;
    }

    public function setCours(int $cours): self
    {
        $this->cours = $cours;

        return $this;
    }
    public function getPlageHoraire(): ?int
    {
        return $this->plageHoraire;
    }

    public function setPlageHoraire(int $plageHoraire): self
    {
        $this->plageHoraire = $plageHoraire;

        return $this;
    }
    public function getDateCours(): ?int
    {
        return $this->dateCours;
    }

    public function setDateCours(int $dateCours): self
    {
        $this->dateCours = $dateCours;

        return $this;
    }
}
