<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfCoursRepository")
 */
class ProfCours
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur")
     * @ORM\JoinColumn(name="prof", referencedColumnName="id")
     */
    private $prof;

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
    public function getProf(): ?int
    {
        return $this->prof;
    }

    public function setProf(int $prof): self
    {
        $this->prof = $prof;

        return $this;
    }
}
