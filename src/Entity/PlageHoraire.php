<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlageHoraireRepository")
 */
class PlageHoraire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $plageHoraire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dureePlage;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pointage", mappedBy="plageHoraire")
     */
    private $pointage;

    public function __construct()
    {
        $this->pointage = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlageHoraire(): ?string
    {
        return $this->plageHoraire;
    }

    public function setPlageHoraire(string $plageHoraire): self
    {
        $this->plageHoraire = $plageHoraire;

        return $this;
    }

    public function getDureePlage(): ?string
    {
        return $this->dureePlage;
    }

    public function setDureePlage(string $dureePlage): self
    {
        $this->dureePlage = $dureePlage;

        return $this;
    }

    public function __toString()
                  {
                    return $this->getPlageHoraire();
                  }

    /**
     * @return Collection|Pointage[]
     */
    public function getPointage(): Collection
    {
        return $this->pointage;
    }

    public function addPointage(Pointage $pointage): self
    {
        if (!$this->pointage->contains($pointage)) {
            $this->pointage[] = $pointage;
            $pointage->setPlageHoraire($this);
        }

        return $this;
    }

    public function removePointage(Pointage $pointage): self
    {
        if ($this->pointage->contains($pointage)) {
            $this->pointage->removeElement($pointage);
            // set the owning side to null (unless already changed)
            if ($pointage->getPlageHoraire() === $this) {
                $pointage->setPlageHoraire(null);
            }
        }

        return $this;
    }
}
