<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoursRepository")
 */
class EtudiantCours
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur")
     * @ORM\JoinColumn(name="etudiant", referencedColumnName="id")
     */
    private $etudiant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cours")
     * @ORM\JoinColumn(name="cours", referencedColumnName="id")
     */
    private $cours;

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

    public function getEtudiant(): ?int
    {
        return $this->etudiant;
    }

    public function setEtudiant(int $etudiant): self
    {
        $this->etudiant = $etudiant;

        return $this;
    }
    public function getCours(): ?string
    {
        return $this->TdGroupe;
    }

    public function setCours(integer $cours): self
    {
        $this->cours = $$cours;

        return $this;
    }
}
