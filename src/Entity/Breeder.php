<?php

namespace App\Entity;

use App\Repository\BreederRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BreederRepository::class)]
class Breeder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $name_br = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Length(min: 9, max: 9, exactMessage: 'Le SIREN doit contenir 9 chiffres')]
    private ?int $siren_br = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameBr(): ?string
    {
        return $this->name_br;
    }

    public function setNameBr(string $name_br): static
    {
        $this->name_br = $name_br;

        return $this;
    }

    public function getSirenBr(): ?int
    {
        return $this->siren_br;
    }

    public function setSirenBr(?int $siren_br): static
    {
        $this->siren_br = $siren_br;

        return $this;
    }
}
