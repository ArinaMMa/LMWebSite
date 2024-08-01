<?php

namespace App\Entity;

use App\Repository\AddressesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AddressesRepository::class)]
class Addresses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $number_address = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $street_address = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Length(min: 5, max: 5, exactMessage: 'Le code postal doit contenir 5 chiffres')]
    private ?int $zip_code_address = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $city_address = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $country_address = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberAddress(): ?int
    {
        return $this->number_address;
    }

    public function setNumberAddress(?int $number_address): static
    {
        $this->number_address = $number_address;

        return $this;
    }

    public function getStreetAddress(): ?string
    {
        return $this->street_address;
    }

    public function setStreetAddress(string $street_address): static
    {
        $this->street_address = $street_address;

        return $this;
    }

    public function getZipCodeAddress(): ?int
    {
        return $this->zip_code_address;
    }

    public function setZipCodeAddress(int $zip_code_address): static
    {
        $this->zip_code_address = $zip_code_address;

        return $this;
    }

    public function getCityAddress(): ?string
    {
        return $this->city_address;
    }

    public function setCityAddress(string $city_address): static
    {
        $this->city_address = $city_address;

        return $this;
    }

    public function getCountryAddress(): ?string
    {
        return $this->country_address;
    }

    public function setCountryAddress(string $country_address): static
    {
        $this->country_address = $country_address;

        return $this;
    }
}
