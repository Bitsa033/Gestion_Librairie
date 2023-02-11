<?php
namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

interface LivreModel
{
  // C =  create
  public function saveData($data);
  // R =  read
  public function getAllData();
  // U  = update
  public function getIdData($id);
  public function updateData();
  // D = delete
  public function removeOneData($id);
  public function removeAllData();

  
}
