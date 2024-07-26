<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Vet;
use Faker\Generator;
use App\Entity\Horse;
use App\Entity\Client;
use App\Entity\Breeder;
use App\Entity\DonePrestations;
use App\Entity\Services;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $clients = [];
        $horses = [];
        $breeders = [];

        // Création d'un utilisateur admin
        $client = (new Client())
            ->setEmailCl('lucilemonti@test.com')
            ->setFirstNameCl('Lucile')
            ->setLastNameCl('Monti')
            ->setTelCl('0606060606')
            ->setPassword($this->passwordHasher->hashPassword(
                new Client(),
                'Test1234!'
            ))
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($client);

        // Création de 10 utilisateurs
        //Array pour les cliens
        
        for ($i = 0; $i < 10; $i++) {
            $client = (new Client())
                ->setEmailCl($this->faker->unique()->email())
                ->setFirstNameCl($this->faker->firstName())
                ->setLastNameCl($this->faker->lastName())
                ->setTelCl($this->faker->regexify('[0-9]{10}'))
                ->setPassword($this->passwordHasher->hashPassword(
                    new Client(),
                    'Test1234!'
                ));

            // Ajout de la date de création et de modification
            $client->setCreatedAt(new \DateTimeImmutable());
            $client->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($client);
            $clients[] = $client;
        }

        // Création de 5 éleveurs
        for ($i = 0; $i < 5; $i++) {
            $breeder = (new Breeder())
                ->setNameBr($this->faker->company())
                ->setSirenBr($this->faker->unique()->randomNumber(9));

            // Ajout de la date de création et de modification
            $breeder->setCreatedAt(new \DateTimeImmutable());
            $breeder->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($breeder);
            $breeders[] = $breeder;
        }

        // Création de 10 fiches cheval

        for ($i = 0; $i < 10; $i++) {
            $horse = (new Horse())
                ->setNameHo($this->faker->name())
                ->setBreedHo($this->faker->word())
                ->setBreederHo($breeders[array_rand($breeders)])
                ->setSexHo($this->faker->randomElement(['SEX_F', 'SEX_M', 'SEX_H']))
                ->setBirthDateHo($this->faker->dateTimeBetween('-10 years', '-1 years'))
                ->setClientId($clients[array_rand($clients)]);

            // Ajout de la date de création et de modification
            $horse->setCreatedAt(new \DateTimeImmutable());
            $horse->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($horse);
            $horses[] = $horse;
        }

        //Création de 7 fiches vétérinaire
        for ($i = 0; $i < 7; $i++) {
            $vet = (new Vet())
                ->setFirstNameVet($this->faker->firstName())
                ->setLastNameVet($this->faker->lastName())
                ->setTelVet($this->faker->regexify('[0-9]{10}'))
                ->setEmailVet($this->faker->unique()->email());

            // Ajout de la date de création et de modification
            $vet->setCreatedAt(new \DateTimeImmutable());
            $vet->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($vet);
        }

        //Création de 5 fiches services
        for ($i = 0; $i < 5; $i++) {
            $services = (new Services())
                ->setNameService($this->faker->word())
                ->setPriceService($this->faker->randomFloat(2, 0, 1000))
                ->setDescriptionService($this->faker->sentence());

            // Ajout de la date de création et de modification
            $services->setCreatedAt(new \DateTimeImmutable());
            $services->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($services);
        }

        //Création de 5 fiches de prestations
        for ($i = 0; $i < 5; $i++) {
            $donePrestation = (new DonePrestations())
                ->setDatePrestation($this->faker->dateTimeBetween('-10 years', '-1 years'))
                ->setServicePriceFixed($this->faker->randomFloat(2, 0, 1000))
                ->addHorse($horses[array_rand($horses)])
                ->setQuantity($this->faker->numberBetween(1, 10))
                ->setCommentaryPrestation($this->faker->sentence())
                ;

            // Ajout de la date de création et de modification
            $donePrestation->setCreatedAt(new \DateTimeImmutable());
            $donePrestation->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($donePrestation);
        }

        $manager->flush();
    }
}
