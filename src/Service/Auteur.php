<?php
namespace App\Service;

class Auteur{
    private $nom="None";
    public function setNom(string $nom)
    {
        $this->nom=$nom;
    }

    public function getNom()
    {
        return $this->nom;
    }

}