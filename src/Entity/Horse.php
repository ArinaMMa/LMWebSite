<?php

namespace App\Entity;

use App\Entity\Traits\DatetimeTrait;
use App\Repository\HorseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Entity\File;

#[ORM\Entity(repositoryClass: HorseRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Horse
{
    //Un trait permettant de factoriser le code pour les champs createdAt et updatedAt
    use DatetimeTrait;

    //initialisation des constantes pour le sexe du cheval
    public const SEX_F = 'Femelle';
    public const SEX_M = 'Mâle';
    public const SEX_H = 'Hongre';

    //L'ID est généré automatiquement par Symfony
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    //La race du cheval est obligatoire
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $breed_ho = null;

    //Le sexe du cheval est obligatoire et doit être l'une des valeurs suivantes : Femelle, Mâle, Hongre définies plus haut
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Choice(
        choices: [
            self::SEX_F, 
            self::SEX_H, 
            self::SEX_M
        ])]
    private ?string $sex_ho = null;

    //La date de naissance du cheval est obligatoire
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthdate_ho = null;

    //Le nom du cheval est obligatoire
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $name_ho = null;

    //La photo du cheval n'est pas obligatoire et est gérée par VichUploaderBundle
    #[ORM\Column(nullable: true)]
    private ?string $picture_ho = null;

    #[Vich\UploadableField(mapping: 'horse_pictures', fileNameProperty: 'picture_ho')]
    private ?File $pictureFile = null;

    //Le client propriétaire du cheval est obligatoire ; un cheval n'a qu'un seul propriétaire
    #[ORM\ManyToOne(inversedBy: 'horses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client_id = null;

    //Les vétérinaires du cheval sont optionnels ; un cheval peut avoir plusieurs vétérinaires
    /**
     * @var Collection<int, Vet>
     */
    #[ORM\ManyToMany(targetEntity: Vet::class, inversedBy: 'horses')]
    private Collection $vet_id;

    //L'éleveur du cheval est obligatoire ; un cheval n'a qu'un seul éleveur. Une option permettra de renseigner "Eleveur inconnu" si l'éleveur n'est pas connu
    #[ORM\ManyToOne(inversedBy: 'horses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Breeder $breeder_ho = null;

    //Les prestations effectuées sur le cheval sont optionnelles ; un cheval peut avoir plusieurs prestations effectuées
    /**
     * @var Collection<int, DonePrestations>
     */
    #[ORM\ManyToMany(targetEntity: DonePrestations::class, inversedBy: 'horses')]
    private Collection $done_prestation_id;

    //Le constructeur initialise les collections de vétérinaires et de prestations effectuées
    public function __construct()
    {
        $this->vet_id = new ArrayCollection();
        $this->done_prestation_id = new ArrayCollection();
    }

    //Les getters et setters sont générés automatiquement par Symfony
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

    /**
     * @return Collection<int, Vet>
     */
    public function getVetId(): Collection
    {
        return $this->vet_id;
    }

    public function addVetId(Vet $vetId): static
    {
        if (!$this->vet_id->contains($vetId)) {
            $this->vet_id->add($vetId);
        }

        return $this;
    }

    public function removeVetId(Vet $vetId): static
    {
        $this->vet_id->removeElement($vetId);

        return $this;
    }

    public function getBreederHo(): ?Breeder
    {
        return $this->breeder_ho;
    }

    public function setBreederHo(?Breeder $breeder_ho): static
    {
        $this->breeder_ho = $breeder_ho;

        return $this;
    }

    /**
     * @return Collection<int, DonePrestations>
     */
    public function getDonePrestationId(): Collection
    {
        return $this->done_prestation_id;
    }

    public function addDonePrestationId(DonePrestations $donePrestationId): static
    {
        if (!$this->done_prestation_id->contains($donePrestationId)) {
            $this->done_prestation_id->add($donePrestationId);
        }

        return $this;
    }

    public function removeDonePrestationId(DonePrestations $donePrestationId): static
    {
        $this->done_prestation_id->removeElement($donePrestationId);

        return $this;
    }
}
