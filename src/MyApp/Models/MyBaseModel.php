<?php
namespace src\MyApp\Models;

use Silex\Application;

class MyBaseModel {
    
    protected $entityManager;

    public function __construct() {
        //$entityManager = $app['orm.em'];
    }
    public function getEM()
    {
        return $this->entityManager;
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

