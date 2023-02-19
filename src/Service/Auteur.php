<?php
namespace App\Service;

use App\Repository\AuteurRepository;

class Auteur {
    public $repo;
    public $db;
    function __construct(AuteurRepository $auteurRepository)
    {
        
    }

}