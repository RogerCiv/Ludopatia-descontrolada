<?php

namespace App\Entity;

use App\Repository\NumerosLoteriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NumerosLoteriaRepository::class)]
class NumerosLoteria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Numero = null;

    #[ORM\OneToMany(mappedBy: 'numeroLoteria', targetEntity: Apuesta::class)]
    private Collection $apuestas;

    public function __construct()
    {
        $this->apuestas = new ArrayCollection();
    }


 
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->Numero;
    }

    public function setNumero(int $Numero): static
    {
        $this->Numero = $Numero;

        return $this;
    }

    /**
     * @return Collection<int, Apuesta>
     */
    public function getApuestas(): Collection
    {
        return $this->apuestas;
    }

    public function addApuesta(Apuesta $apuesta): static
    {
        if (!$this->apuestas->contains($apuesta)) {
            $this->apuestas->add($apuesta);
            $apuesta->setNumeroLoteria($this);
        }

        return $this;
    }

    public function removeApuesta(Apuesta $apuesta): static
    {
        if ($this->apuestas->removeElement($apuesta)) {
            // set the owning side to null (unless already changed)
            if ($apuesta->getNumeroLoteria() === $this) {
                $apuesta->setNumeroLoteria(null);
            }
        }

        return $this;
    }

}
