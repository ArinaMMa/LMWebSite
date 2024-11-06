<?php

namespace App\tests;

use App\Entity\Horse;
use App\Entity\Client;
use App\Entity\Breeder;
use App\Entity\Vet;
use App\Entity\DonePrestations;
use PHPUnit\Framework\TestCase;

class HorseTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $horse = new Horse();

        // Test breed_ho
        $breed = 'Arabian';
        $horse->setBreedHo($breed);
        $this->assertEquals($breed, $horse->getBreedHo());

        // Test sex_ho
        $sex = Horse::SEX_F;
        $horse->setSexHo($sex);
        $this->assertEquals($sex, $horse->getSexHo());

        // Test birthdate_ho
        $birthdate = new \DateTime('2000-01-01');
        $horse->setBirthdateHo($birthdate);
        $this->assertEquals($birthdate, $horse->getBirthdateHo());

        // Test name_ho
        $name = 'Spirit';
        $horse->setNameHo($name);
        $this->assertEquals($name, $horse->getNameHo());

        // Test picture_ho
        $picture = 'picture.jpg';
        $horse->setPictureHo($picture);
        $this->assertEquals($picture, $horse->getPictureHo());

        // Test client
        $client = new Client();
        $horse->setClient($client);
        $this->assertEquals($client, $horse->getClient());

        // Test breeder
        $breeder = new Breeder();
        $horse->setBreeder($breeder);
        $this->assertEquals($breeder, $horse->getBreeder());
    }

    public function testAddAndRemoveVets()
    {
        $horse = new Horse();
        $vet = new Vet();

        // Test addVet
        $horse->addVet($vet);
        $this->assertCount(1, $horse->getVets());
        $this->assertTrue($horse->getVets()->contains($vet));

        // Test removeVet
        $horse->removeVet($vet);
        $this->assertCount(0, $horse->getVets());
        $this->assertFalse($horse->getVets()->contains($vet));
    }

    public function testAddAndRemoveDonePrestations()
    {
        $horse = new Horse();
        $donePrestation = new DonePrestations();

        // Test addDonePrestation
        $horse->addDonePrestation($donePrestation);
        $this->assertCount(1, $horse->getDonePrestations());
        $this->assertTrue($horse->getDonePrestations()->contains($donePrestation));

        // Test removeDonePrestation
        $horse->removeDonePrestation($donePrestation);
        $this->assertCount(0, $horse->getDonePrestations());
        $this->assertFalse($horse->getDonePrestations()->contains($donePrestation));
    }
}