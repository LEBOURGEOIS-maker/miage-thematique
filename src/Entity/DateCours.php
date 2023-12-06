<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoursRepository")
 */
class DateCours
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
     * @ORM\Column(type="string", length=255)
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
    public function getDateCours(): ?string
    {
        return $this->dateCours;
    }

    public function setDateCours(string $dateCours): self
    {
        $this->dateCours = $dateCours;

        return $this;
    }
}
