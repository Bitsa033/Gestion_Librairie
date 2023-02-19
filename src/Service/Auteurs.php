<?php
namespace App\Service;

use App\Entity\Auteur;
use App\Repository\AuteurRepository;

class Auteurs {
    public $repo;
    public $table;
    
    function __construct(AuteurRepository $auteurRepository)
    {
        $this->repo=$auteurRepository;
        $this->table=new Auteur;
    }

}