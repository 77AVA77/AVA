<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    /**
     * @var Collection<int, Country>
     */
    #[ORM\OneToMany(targetEntity: Country::class, mappedBy: 'status')]
    private Collection $no;

    public function __construct()
    {
        $this->no = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Country>
     */
    public function getNo(): Collection
    {
        return $this->no;
    }

    public function addNo(Country $no): static
    {
        if (!$this->no->contains($no)) {
            $this->no->add($no);
            $no->setStatus($this);
        }

        return $this;
    }

    public function removeNo(Country $no): static
    {
        if ($this->no->removeElement($no)) {
            // set the owning side to null (unless already changed)
            if ($no->getStatus() === $this) {
                $no->setStatus(null);
            }
        }

        return $this;
    }
}
