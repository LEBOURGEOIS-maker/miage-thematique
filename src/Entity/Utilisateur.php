<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Utilisateur implements UserInterface
{
    /**
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->numeroEtudiant;
    }
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numeroEtudiant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomUtilisateur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomUtilisateur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pointage", mappedBy="utilisateurEtudiant")
     */
    private $pointage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Formation", inversedBy="utilisateurs")
     */
    private $formation;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Cours", inversedBy="utilisateurs")
     */
    private $cours;

    public function __construct()
    {
        $this->pointage = new ArrayCollection();
        $this->cours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->numeroEtudiant;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles, SORT_REGULAR);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNumeroEtudiant(): ?string
    {
        return $this->numeroEtudiant;
    }

    public function setNumeroEtudiant(?string $numeroEtudiant): self
    {
        $this->numeroEtudiant = $numeroEtudiant;

        return $this;
    }

    public function getPrenomUtilisateur(): ?string
    {
        return $this->prenomUtilisateur;
    }

    public function setPrenomUtilisateur(string $prenomUtilisateur): self
    {
        $this->prenomUtilisateur = $prenomUtilisateur;

        return $this;
    }

    public function getNomUtilisateur(): ?string
    {
        return $this->nomUtilisateur;
    }

    public function setNomUtilisateur(string $nomUtilisateur): self
    {
        $this->nomUtilisateur = $nomUtilisateur;

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
            $pointage->setUtilisateurEtudiant($this);
            dd($this, $pointage);
        }

        return $this;
    }

    public function removePointage(Pointage $pointage): self
    {
        if ($this->pointage->contains($pointage)) {
            $this->pointage->removeElement($pointage);
            // set the owning side to null (unless already changed)
            if ($pointage->getUtilisateurEtudiant() === $this) {
                $pointage->setUtilisateurEtudiant(null);
            }
        }

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

    /**
     * @return Collection|Cours[]
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): self
    {
        if (!$this->cours->contains($cour)) {
            $this->cours[] = $cour;
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->contains($cour)) {
            $this->cours->removeElement($cour);
        }

        return $this;
    }

	public function __toString()
	{

		$nom = $this->getNomUtilisateur();
		$prenom = $this->getPrenomUtilisateur();

		$identite = $prenom." ".$nom;
		return $identite;
    }

	public function __toString2()
	{
		return $this->getUsername();
    }
}
