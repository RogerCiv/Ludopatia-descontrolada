<?php

namespace App\Entity;

use App\Repository\SorteoRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Nullable;

#[ORM\Entity(repositoryClass: SorteoRepository::class)]
class Sorteo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $prize = null;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $winner = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_inicio = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_fin = null;

    #[ORM\Column]
    private ?int $cost = null;
    #[ORM\OneToMany(mappedBy: 'sorteo', targetEntity: Apuesta::class)]
    private Collection $apuestas;

    #[ORM\ManyToMany(targetEntity: NumerosLoteria::class, inversedBy: 'sorteos')]
    private Collection $numerosLoteria;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrize(): ?int
    {
        return $this->prize;
    }

    public function setPrize(int $prize): static
    {
        $this->prize = $prize;

        return $this;
    }

    public function getWinner(): ?string
    {
        return $this->winner;
    }

    public function setWinner(string $winner): static
    {
        $this->winner = $winner;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fecha_inicio;
    }

    public function setFechaInicio(\DateTimeInterface $fecha_inicio): static
    {
        $this->fecha_inicio = $fecha_inicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fecha_fin;
    }

    public function setFechaFin(\DateTimeInterface $fecha_fin): static
    {
        $this->fecha_fin = $fecha_fin;

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
    /**
     * @return Collection<int, NumerosLoteria>
     */
    public function getNumerosLoteria(): Collection
    {
        return $this->numerosLoteria;
    }

    public function addNumerosLoteria(NumerosLoteria $numerosLoteria): static
    {
        if (!$this->numerosLoteria->contains($numerosLoteria)) {
            $this->numerosLoteria->add($numerosLoteria);
        }

        return $this;
    }

    public function removeNumerosLoteria(NumerosLoteria $numerosLoteria): static
    {
        $this->numerosLoteria->removeElement($numerosLoteria);

        return $this;
    }
}
