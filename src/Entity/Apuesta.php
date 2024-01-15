<?php

namespace App\Entity;

use App\Repository\ApuestaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApuestaRepository::class)]
class Apuesta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'apuestas')]
    private ?NumerosLoteria $numeroLoteria = null;

    #[ORM\ManyToOne(inversedBy: 'apuestas')]
    private ?Sorteo $sorteo = null;

    #[ORM\ManyToOne(inversedBy: 'apuestas')]
    private ?User $usuario = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroLoteria(): ?NumerosLoteria
    {
        return $this->numeroLoteria;
    }

    public function setNumeroLoteria(?NumerosLoteria $numeroLoteria): static
    {
        $this->numeroLoteria = $numeroLoteria;

        return $this;
    }

    public function getSorteo(): ?Sorteo
    {
        return $this->sorteo;
    }

    public function setSorteo(?Sorteo $sorteo): static
    {
        $this->sorteo = $sorteo;

        return $this;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }
}
