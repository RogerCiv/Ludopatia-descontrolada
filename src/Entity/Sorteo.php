<?php

namespace App\Entity;

use App\Repository\SorteoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SorteoRepository::class)]
class Sorteo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private ?string $Name = null;

    #[ORM\Column]
    private ?int $Prize = null;

    #[ORM\Column(length: 60)]
    private ?string $Winner = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Fecha = null;

    #[ORM\Column]
    private ?int $State = null;

    #[ORM\Column]
    private ?int $cost = null;

    #[ORM\OneToMany(mappedBy: 'sorteo', targetEntity: Apuesta::class)]
    private Collection $apuestas;


    public function __construct()
    {
        $this->apuestas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getPrize(): ?int
    {
        return $this->Prize;
    }

    public function setPrize(int $Prize): static
    {
        $this->Prize = $Prize;

        return $this;
    }

    public function getWinner(): ?string
    {
        return $this->Winner;
    }

    public function setGanador(string $Winner): static
    {
        $this->Winner = $Winner;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->Fecha;
    }

    public function setFecha(\DateTimeInterface $Fecha): static
    {
        $this->Fecha = $Fecha;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->State;
    }

    public function setState(int $State): static
    {
        $this->State = $State;

        return $this;
    }

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(int $cost): static
    {
        $this->cost = $cost;

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
            $apuesta->setSorteo($this);
        }

        return $this;
    }

    public function removeApuesta(Apuesta $apuesta): static
    {
        if ($this->apuestas->removeElement($apuesta)) {
            // set the owning side to null (unless already changed)
            if ($apuesta->getSorteo() === $this) {
                $apuesta->setSorteo(null);
            }
        }

        return $this;
    }

}
