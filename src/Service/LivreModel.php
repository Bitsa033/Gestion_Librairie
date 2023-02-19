<?php
namespace App\Service;

interface LivreModel
{
  // C =  create
  public function saveData($data);
  // R =  read
  public function getAllData();
  public function getIdData($id);
  // U  = update
  public function updateData();
  // D = delete
  public function removeAllData();
  public function removeOneData($id);

  
}
