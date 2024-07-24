<?php

namespace App\Entity;

use App\Repository\DonePrestationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DonePrestationsRepository::class)]
class DonePrestations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_prestation = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\PositiveOrZero(message: 'Le prix doit être positif ou nul')]
    private ?int $service_price_fixed = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\PositiveOrZero(message: 'La quantité doit être un chiffre positif ou nul')]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentary_prestation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePrestation(): ?\DateTimeInterface
    {
        return $this->date_prestation;
    }

    public function setDatePrestation(\DateTimeInterface $date_prestation): static
    {
        $this->date_prestation = $date_prestation;

        return $this;
    }

    public function getServicePriceFixed(): ?int
    {
        return $this->service_price_fixed;
    }

    public function setServicePriceFixed(int $service_price_fixed): static
    {
        $this->service_price_fixed = $service_price_fixed;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCommentaryPrestation(): ?string
    {
        return $this->commentary_prestation;
    }

    public function setCommentaryPrestation(?string $commentary_prestation): static
    {
        $this->commentary_prestation = $commentary_prestation;

        return $this;
    }
}
