<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonneRepository::class)
 */
class Personne
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $prenom;

    /**
     * @ORM\ManyToMany(targetEntity=Equipe::class, inversedBy="joueur")
     */
    private $equipeId;

    public function __construct()
    {
        $this->equipeId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEquipeId(): ?ArrayCollection
    {
        return $this->equipeId;
    }

    public function setEquipeId(?Equipe $equipeId): self
    {
        $this->equipeId[] = $equipeId;

        return $this;
    }
}
