<?php

namespace App\DataFixtures;

use App\Entity\Contrat;
use App\Entity\Offre;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        $cdd = new Contrat();
        $cdd->setNom("CDD");

        $manager->persist($cdd);

        $cdi = new Contrat();
        $cdi->setNom("CDI");

        $manager->persist($cdi);

        $freelance = new Contrat();
        $freelance->setNom("freelance");

        $manager->persist($freelance);

        $plein = new Type();
        $plein->setNom("plein");

        $manager->persist($plein);

        $partiel = new Type();
        $partiel->setNom("partiel");

        $manager->persist($partiel);

        $types = [$partiel, $plein];
        $contrats = [$cdd, $cdi, $freelance];

        for ($i = 0; $i < 15; $i++) {
            $offre = new Offre();
            $typeIndex = array_rand($types, 1);
            $contratIndex = array_rand($contrats, 1);
            $type = $types[$typeIndex];
            $contrat = $contrats[$contratIndex];

            if ($contrat == $contrats[0]) {
                $offre->setContrat($contrat)
                    ->setType($type)
                    ->setTitle($faker->jobTitle)
                    ->setDescription($faker->text)
                    ->setAdresse($faker->address)
                    ->setPostcode(intval($faker->postcode))
                    ->setVille($faker->city)
                    ->setCreatedAt($faker->dateTimeBetween($startDate = '-12 months', $endDate = '-10 months'))
                    ->setEnd($faker->dateTimeBetween('-1 months'));
            } else {
                $offre->setContrat($contrat)
                    ->setType($type)
                    ->setTitle($faker->jobTitle)
                    ->setDescription($faker->text)
                    ->setAdresse($faker->address)
                    ->setPostcode(intval($faker->postcode))
                    ->setVille($faker->city)
                    ->setCreatedAt($faker->dateTimeBetween($startDate = '-12 months', $endDate = '-10 months'));
            }

            $manager->persist($offre);
        }

        $manager->flush();
    }
}
