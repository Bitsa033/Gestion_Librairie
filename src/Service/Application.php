<?php
namespace App\Service;

use App\Entity\Auteur;
use App\Entity\EntreeLivre;
use App\Entity\Livre;
use App\Entity\SortieLivre;
use App\Repository\AuteurRepository;
use App\Repository\EntreeLivreRepository;
use App\Repository\LivreRepository;
use App\Repository\SortieLivreRepository;
use Doctrine\Persistence\ManagerRegistry;

class Application implements LivreModel
{
  public $repo_auteur;
  public $repo_livre;
  public $repo_entree_livre;
  public $repo_sortie_livre;
  public $table_auteur;
  public $table_livre;
  public $table_entree_livre;
  public $table_sortie_livre;
  public $db;
  
  function __construct(LivreRepository $livreRepository,
                        AuteurRepository $auteurRepository,
                        EntreeLivreRepository $entreeLivreRepository,
                        SortieLivreRepository $sortieLivreRepository, 
                        ManagerRegistry $managerRegistry
  )
  {
    $this->repo_auteur=$auteurRepository;
    $this->repo_livre=$livreRepository;
    $this->repo_entree_livre=$entreeLivreRepository;
    $this->repo_sortie_livre=$sortieLivreRepository;
    $this->table_auteur=new Auteur;
    $this->table_livre=new Livre;
    $this->table_entree_livre=new EntreeLivre;
    $this->table_sortie_livre=new SortieLivre;
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
