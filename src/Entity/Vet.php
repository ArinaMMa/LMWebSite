<?php

namespace App\Entity;

use App\Entity\Traits\EnableTrait;
use App\Repository\VetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VetRepository::class)]
class Vet
{
    use EnableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255, minMessage: 'Le nom doit contenir au moins 2 caractères', maxMessage: 'Le nom doit contenir au maximum 255 caractères')]
    private ?string $lastname_vet = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255, minMessage: 'Le prénom doit contenir au moins 2 caractères', maxMessage: 'Le prénom doit contenir au maximum 255 caractères')]
    private ?string $firstname_vet = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Email(message: 'L\'adresse email "{{ value }}" n\'est pas une adresse email valide.')]
    private ?string $email_vet = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Regex(pattern: '/^0[1-9]([-. ]?[0-9]{2}){4}$/', message: 'Le numéro de téléphone "{{ value }}" n\'est pas un numéro de téléphone valide.')]
    private ?string $tel_vet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastnameVet(): ?string
    {
        return $this->lastname_vet;
    }

    public function setLastnameVet(string $lastname_vet): static
    {
        $this->lastname_vet = $lastname_vet;

        return $this;
    }

    public function getFirstnameVet(): ?string
    {
        return $this->firstname_vet;
    }

    public function setFirstnameVet(string $firstname_vet): static
    {
        $this->firstname_vet = $firstname_vet;

        return $this;
    }

    public function getEmailVet(): ?string
    {
        return $this->email_vet;
    }

    public function setEmailVet(string $email_vet): static
    {
        $this->email_vet = $email_vet;

        return $this;
    }

    public function getTelVet(): ?string
    {
        return $this->tel_vet;
    }

    public function setTelVet(string $tel_vet): static
    {
        $this->tel_vet = $tel_vet;

        return $this;
    }
}
