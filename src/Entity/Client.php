<?php

namespace App\Entity;

use App\Entity\Traits\DatetimeTrait;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL_CL', fields: ['email_cl'])]
#[ORM\HasLifecycleCallbacks]
class Client implements UserInterface, PasswordAuthenticatedUserInterface
{
    //Un trait permettant de factoriser le code pour les champs createdAt et updatedAt
    use DatetimeTrait;
    
    //L'ID est généré automatiquement par Symfony
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    //L'email est unique, c'est la méthode de connexion de l'utilisateur
    #[ORM\Column(length: 180)]
    #[Assert\Length(
        max: 180,
        maxMessage: 'L\'email ne peut pas dépasser {{ limit }} caractères.'
    )]
    #[Assert\NotBlank]
    private ?string $email_cl = null;

    //Il existe 2 rôles : ROLE_USER et ROLE_ADMIN, lequel n'appartient qu'à une personne (actuellement)
    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    //Le mot de passe est hashé pour des raisons de sécurité
    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    //Le prénom et le nom sont des champs obligatoires
    #[ORM\Column(length: 255)]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le prénom ne peut pas dépasser {{ limit }} caractères',
        min: 2,
        minMessage: 'Le prénom doit faire au minimum {{ limit }} caractères'
    )]
    #[Assert\NotBlank]
    private ?string $firstname_cl = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le nom ne peut pas dépasser {{ limit }} caractères',
        min: 2,
        minMessage: 'Le nom doit faire au minimul {{ limit }} caractères'
    )]
    #[Assert\NotBlank]
    private ?string $lastname_cl = null;

    //La date de naissance est optionnelle
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthdate_cl = null;

    //Le numéro de téléphone est obligatoire et doit faire 10 caractères
    #[ORM\Column(length: 10)]
    #[Assert\Length(
        max: 10,
        maxMessage: 'Le numéro de téléphone doit faire {{ limit }} caractères',
        min: 10,
        minMessage: 'Le numéro de téléphone doit faire {{ limit }} caractères'
    )]
    #[Assert\NotBlank]
    private ?string $tel_cl = null;

    //Un client peut avoir plusieurs chevaux
    /**
     * @var Collection<int, Horse>
     */
    #[ORM\OneToMany(targetEntity: Horse::class, mappedBy: 'client')]
    private Collection $horses;

    //Le constructeur initialise la collection de chevaux
    public function __construct()
    {
        $this->horses = new ArrayCollection();
    }

    //Les getters et setters sont générés automatiquement par Symfony
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmailCl(): ?string
    {
        return $this->email_cl;
    }

    public function setEmailCl(string $email_cl): static
    {
        $this->email_cl = $email_cl;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email_cl;
    }

    /**
     * @see UserInterface
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstnameCl(): ?string
    {
        return $this->firstname_cl;
    }

    public function setFirstnameCl(string $firstname_cl): static
    {
        $this->firstname_cl = $firstname_cl;

        return $this;
    }

    public function getLastnameCl(): ?string
    {
        return $this->lastname_cl;
    }

    public function setLastnameCl(string $lastname_cl): static
    {
        $this->lastname_cl = $lastname_cl;

        return $this;
    }

    public function getBirthdateCl(): ?\DateTimeInterface
    {
        return $this->birthdate_cl;
    }

    public function setBirthdateCl(\DateTimeInterface $birthdate_cl): static
    {
        $this->birthdate_cl = $birthdate_cl;

        return $this;
    }

    public function getTelCl(): ?string
    {
        return $this->tel_cl;
    }

    public function setTelCl(string $tel_cl): static
    {
        $this->tel_cl = $tel_cl;

        return $this;
    }

    /**
     * @return Collection<int, Horse>
     */
    public function getHorses(): Collection
    {
        //La méthode getHorses() retourne la collection de chevaux
        return $this->horses;
    }

    public function getHorsesByClient(): Collection
    {
        //La méthode getHorsesByClient() retourne la collection de chevaux d'un client
        return $this->horses->filter(function (Horse $horse) {
            return $horse->getClient() === $this;
        });
    }

    public function addHorse(Horse $horse): static
    {
        if (!$this->horses->contains($horse)) {
            $this->horses->add($horse);
            $horse->setClient($this);
        }

        return $this;
    }

    public function removeHorse(Horse $horse): static
    {
        if ($this->horses->removeElement($horse)) {
            // set the owning side to null (unless already changed)
            if ($horse->getClient() === $this) {
                $horse->setClient(null);
            }
        }

        return $this;
    }
}
