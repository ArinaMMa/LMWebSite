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
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: HorseRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
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

    //Le fichier de la photo du cheval est géré par VichUploaderBundle
    #[Vich\UploadableField(mapping: 'horses', fileNameProperty: 'picture_ho')]
    private ?File $pictureFile = null;

    //Le setter de la photo du cheval permet de mettre à jour la date de modification de la photo
    public function setPictureFile(?File $pictureFile = null): static
    {
        $this->pictureFile = $pictureFile;

        if (null !== $pictureFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    //Le client propriétaire du cheval est obligatoire ; un cheval n'a qu'un seul propriétaire
    #[ORM\ManyToOne(inversedBy: 'horses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    //Les vétérinaires du cheval sont optionnels ; un cheval peut avoir plusieurs vétérinaires
    /**
     * @var Collection<int, Vet>
     */
    #[ORM\ManyToMany(targetEntity: Vet::class, inversedBy: 'horses')]
    private Collection $vets;

    //L'éleveur du cheval est obligatoire ; un cheval n'a qu'un seul éleveur. Une option permettra de renseigner "Eleveur inconnu" si l'éleveur n'est pas connu
    #[ORM\ManyToOne(inversedBy: 'horses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Breeder $breeder = null;

    //Les prestations effectuées sur le cheval sont optionnelles ; un cheval peut avoir plusieurs prestations effectuées
    /**
     * @var Collection<int, DonePrestations>
     */
    #[ORM\ManyToMany(targetEntity: DonePrestations::class, inversedBy: 'horses')]
    private Collection $done_prestations;

    //Le constructeur initialise les collections de vétérinaires et de prestations effectuées
    public function __construct()
    {
        $this->vets = new ArrayCollection();
        $this->done_prestations = new ArrayCollection();
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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, Vet>
     */
    public function getVets(): Collection
    {
        return $this->vets;
    }

    public function addVet(Vet $vet): static
    {
        if (!$this->vets->contains($vet)) {
            $this->vets->add($vet);
        }

        return $this;
    }

    public function removeVet(Vet $vet): static
    {
        $this->vets->removeElement($vet);

        return $this;
    }

    public function getBreeder(): ?Breeder
    {
        return $this->breeder;
    }

    public function setBreeder(?Breeder $breeder): static
    {
        $this->breeder = $breeder;

        return $this;
    }

    /**
     * @return Collection<int, DonePrestations>
     */
    public function getDonePrestations(): Collection
    {
        return $this->done_prestations;
    }

    public function addDonePrestation(DonePrestations $donePrestation): static
    {
        if (!$this->done_prestations->contains($donePrestation)) {
            $this->done_prestations->add($donePrestation);
        }

        return $this;
    }

    public function removeDonePrestation(DonePrestations $donePrestation): static
    {
        $this->done_prestations->removeElement($donePrestation);

        return $this;
    }
}
