<?php 
namespace App\Repositories;

interface IRepository
{  
    public function getTop();
    
    public function search($field,$condition,$data);
}