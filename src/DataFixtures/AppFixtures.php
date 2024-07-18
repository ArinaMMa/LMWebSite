<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
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

            $client->setCreatedAt(new \DateTimeImmutable());
            $client->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($client);
        }

        $manager->flush();
    }
}
