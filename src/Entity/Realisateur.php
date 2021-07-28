<?php

namespace App\Entity;

use App\Repository\RealisateurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RealisateurRepository::class)
 */
class Realisateur
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
     * @ORM\OneToOne(targetEntity=Film::class, mappedBy="realisateur", cascade={"persist", "remove"})
     */
    private $film;

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

    public function getFilm(): ?Film
    {
        return $this->film;
    }

    public function setFilm(?Film $film): self
    {
        // unset the owning side of the relation if necessary
        if ($film === null && $this->film !== null) {
            $this->film->setRealisateur(null);
        }

        // set the owning side of the relation if necessary
        if ($film !== null && $film->getRealisateur() !== $this) {
            $film->setRealisateur($this);
        }

        $this->film = $film;

        return $this;
    }
}
