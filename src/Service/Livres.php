<?php
namespace App\Service;

use App\Entity\Auteur;
use App\Entity\Livre;
use App\Repository\LivreRepository;
use Doctrine\Persistence\ManagerRegistry;

class Livres implements LivreModel
{
  public $repo;
  public $db;
  
  function __construct(LivreRepository $livreRepository, ManagerRegistry $managerRegistry)
  {
    $this->repo=$livreRepository;
    $connection=$managerRegistry->getManager();
    $this->db=$connection;
  }

  public function saveToDb($entiy)
  {
    $db=$this->db;
    $db->persist($entiy);
    $db->flush();
  }

  // C =  create
  public function saveData($data)
  {
    $auteur=new Auteur;
    $auteur->setNom($data["auteurName"]);
    $livre = new Livre;
    $livre->setNom($data["livreName"]);
    $livre->setGenre($data["genre"]);
    $livre->setAnneeEdition($data["anneeEdition"]);
    $livre->setQuantite($data["nbExemplaires"]);
    $livre->setAuteur($auteur);
    $this->saveToDb($livre);
  }
  
  
}
