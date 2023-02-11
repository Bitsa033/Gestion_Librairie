<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\Livre;
use App\Repository\LivreRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $auteur=new Auteur;
        $auteur->setNom("Michel dedieu");

        $livre = new Livre;
        $livre->setNom("Execelence en Mathmatique 3eme ACD");
        $livre->setGenre("Education");
        $livre->setAnneeEdition(2020);
        $livre->setQuantite(5);
        $livre->setAuteur($auteur);

        $manager->persist($livre);

        $manager->flush();
    }
}
