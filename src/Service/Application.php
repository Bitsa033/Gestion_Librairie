<?php
namespace App\Service;

use App\Entity\Auteur;
use App\Entity\Livre;
use App\Repository\AuteurRepository;
use App\Repository\LivreRepository;
use Doctrine\Persistence\ManagerRegistry;

class Application implements LivreModel
{
  public $repo_livre;
  public $table_auteur;
  public $repo_auteur;
  public $table_livre;
  public $db;
  
  function __construct(LivreRepository $livreRepository,
                        AuteurRepository $auteurRepository, 
                        ManagerRegistry $managerRegistry
  )
  {
    $this->repo_livre=$livreRepository;
    $this->repo_auteur=$auteurRepository;
    $this->table_auteur=new Auteur;
    $this->table_livre=new Livre;
    $connection=$managerRegistry->getManager();
    $this->db=$connection;
  }

  public function saveToDb($entiy)
  {
    $db=$this->db;
    $db->persist($entiy);
    $db->flush();
  }
  
  
}
