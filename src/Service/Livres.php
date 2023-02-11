<?php
namespace App\Service;

use App\Entity\Auteur;
use App\Entity\Livre;
use App\Repository\LivreRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Livres extends AbstractController implements LivreModel
{
  protected $repo;
  protected $db;
  
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
    // $auteur=new Auteur;
    // $auteur->setNom($data["auteurName"]);
    // $auteurId=$this->repo->find($auteur);
    // $livre = new Livre;
    // $livre->setNom($data["nameLivre"]);
    // $livre->setGenre($data["genre"]);
    // $livre->setAnneeEdition($data["anneeEdition"]);
    // $livre->setQuantite($data["nbExemplaires"]);
    // $livre->setAuteur($auteurId);
    $auteur=new Auteur;
        $auteur->setNom("Michel dedieu");

        $livre = new Livre;
        $livre->setNom("Execelence en Mathmatique 3eme ACD");
        $livre->setGenre("Education");
        $livre->setAnneeEdition(2020);
        $livre->setQuantite(5);
        $livre->setAuteur($auteur);
    $this->saveToDb($livre);
  }
  // R =  read
  public function getAllData():array
  {
    $repo=$this->repo;
    $data=$repo->findAll();
    return $data;
  }
  public function getIdData($id)
  {
    $repo=$this->repo;
    $data=$repo->find($id);
    return $data;
  }
  // U  = update
  public function updateData()
  {

  }
  // D = delete
  public function removeOneData($id)
  {

  }
  public function removeAllData()
  {

  }
  
}