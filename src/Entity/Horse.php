<?php

namespace App\Entity;

use App\Entity\Traits\DatetimeTrait;
use App\Entity\Traits\EnableTrait;
use App\Repository\HorseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HorseRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Horse
{
    use DatetimeTrait;
    use EnableTrait;

    public const SEX_F = 'Femelle';
    public const SEX_M = 'Mâle';
    public const SEX_H = 'Hongre';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $breed_ho = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Choice(
        choices: [
            self::SEX_F, 
            self::SEX_H, 
            self::SEX_M
        ])]
    private ?string $sex_ho = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthdate_ho = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $name_ho = null;

    #[ORM\Column(nullable: true)]
    private ?string $picture_ho = null;

    #[ORM\ManyToOne(inversedBy: 'horses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBreedHo(): ?string
    {
        return $this->breed_ho;
    }

    public function setBreedHo(string $breed_ho): static
    {
        $this->breed_ho = $breed_ho;

        return $this;
    }

    public function getSexHo(): ?string
    {
        return $this->sex_ho;
    }

    public function setSexHo(string $sex_ho): static
    {
        $this->sex_ho = $sex_ho;

        return $this;
    }

    public function getBirthdateHo(): ?\DateTimeInterface
    {
        return $this->birthdate_ho;
    }

    public function setBirthdateHo(\DateTimeInterface $birthdate_ho): static
    {
        $this->birthdate_ho = $birthdate_ho;

        return $this;
    }

    public function getNameHo(): ?string
    {
        return $this->name_ho;
    }

    public function setNameHo(string $name_ho): static
    {
        $this->name_ho = $name_ho;

        return $this;
    }

    public function getPictureHo(): ?string
    {
        return $this->picture_ho;
    }

    public function setPictureHo(?string $picture_ho): static
    {
        $this->picture_ho = $picture_ho;

        return $this;
    }

    public function getClientId(): ?Client
    {
        return $this->client_id;
    }

    public function setClientId(?Client $client_id): static
    {
        $this->client_id = $client_id;

        return $this;
    }
}
