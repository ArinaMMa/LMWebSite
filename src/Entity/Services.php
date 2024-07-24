<?php

namespace App\Entity;

use App\Repository\ServicesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServicesRepository::class)]
class Services
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name_service = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $description_service = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $minimum_duration_service = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\PositiveOrZero(message: 'Le prix doit être positif ou nul')]
    private ?int $price_service = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameService(): ?string
    {
        return $this->name_service;
    }

    public function setNameService(string $name_service): static
    {
        $this->name_service = $name_service;

        return $this;
    }

    public function getDescriptionService(): ?string
    {
        return $this->description_service;
    }

    public function setDescriptionService(string $description_service): static
    {
        $this->description_service = $description_service;

        return $this;
    }

    public function getMinimumDurationService(): ?string
    {
        return $this->minimum_duration_service;
    }

    public function setMinimumDurationService(?string $minimum_duration_service): static
    {
        $this->minimum_duration_service = $minimum_duration_service;

        return $this;
    }

    public function getPriceService(): ?int
    {
        return $this->price_service;
    }

    public function setPriceService(int $price_service): static
    {
        $this->price_service = $price_service;

        return $this;
    }
}
