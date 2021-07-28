<?php

namespace App\Entity;

use App\Repository\FilmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FilmRepository::class)
 */
class Film
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\OneToMany(targetEntity=Acteur::class, mappedBy="film", cascade={"persist"})
     */
    private $acteurs;

    /**
     * @ORM\OneToOne(targetEntity=Realisateur::class, inversedBy="film", cascade={"persist", "remove"})
     */
    private $realisateur;

    public function __construct()
    {
        $this->acteurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return Collection|acteur[]
     */
    public function getActeurs(): Collection
    {
        return $this->acteurs;
    }

    public function addActeur(acteur $acteur): self
    {
        if (!$this->acteurs->contains($acteur)) {
            $this->acteurs[] = $acteur;
            $acteur->setFilm($this);
        }

        return $this;
    }

    public function removeActeur(acteur $acteur): self
    {
        if ($this->acteurs->removeElement($acteur)) {
            // set the owning side to null (unless already changed)
            if ($acteur->getFilm() === $this) {
                $acteur->setFilm(null);
            }
        }

        return $this;
    }

    public function getRealisateur(): ?realisateur
    {
        return $this->realisateur;
    }

    public function setRealisateur(?realisateur $realisateur): self
    {
        $this->realisateur = $realisateur;

        return $this;
    }
}
