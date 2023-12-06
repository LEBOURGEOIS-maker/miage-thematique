<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoursRepository")
 */
class Cours
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
    private $nomUe;
    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $groupeTd;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Formation", mappedBy="cours")
     */
    private $formation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pointage", mappedBy="cours")
     */
    private $pointage;
    
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Utilisateur", mappedBy="cours")
     */
    private $utilisateurs;

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

    public function getNomUe(): ?string
    {
        return $this->nomUe;
    }

    public function setNomUe(string $nomUe): self
    {
        $this->nomUe = $nomUe;

        return $this;
    }
    public function getGroupeTd(): ?string
    {
        return $this->groupeTd;
    }

    public function setGroupeTd(string $groupeTd): self
    {
        $this->groupeTd = $groupeTd;

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

    /**
     * @return Collection|Formation[]
     */
    public function getFormation(): Collection
    {
        return $this->formation;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formation->contains($formation)) {
            $this->formation[] = $formation;
            $formation->addCour($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formation->contains($formation)) {
            $this->formation->removeElement($formation);
            $formation->removeCour($this);
        }

        return $this;
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
            $pointage->setCours($this);
        }

        return $this;
    }

    public function removePointage(Pointage $pointage): self
    {
        if ($this->pointage->contains($pointage)) {
            $this->pointage->removeElement($pointage);
            // set the owning side to null (unless already changed)
            if ($pointage->getCours() === $this) {
                $pointage->setCours(null);
            }
        }

        return $this;
    }

	public function __toString()
               	{
               		return $this->getNomUe();
               	}

    /**
     * @return Collection|Utilisateur[]
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
            $utilisateur->addCour($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->removeElement($utilisateur);
            $utilisateur->removeCour($this);
        }

        return $this;
    }


	protected $admin;

	public function getAdmin()
	{
		return $this->admin;
	}
}
