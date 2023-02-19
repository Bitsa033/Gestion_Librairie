<?php
namespace App\Service;

use App\Entity\Livre;
use App\Repository\LivreRepository;
use Doctrine\Persistence\ManagerRegistry;

class Livres implements LivreModel
{
  public $repo;
  public $db;
  public $table;
  
  function __construct(LivreRepository $livreRepository, ManagerRegistry $managerRegistry)
  {
    $this->repo=$livreRepository;
    $this->table=new Livre;
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
