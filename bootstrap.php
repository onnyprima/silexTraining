<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require "vendor/autoload.php";

$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/MyApp/Entity"), $isDevMode, null, null, FALSE);

$conn = array (
    'dbname' => 'db_silexorm',
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'driver' => 'pdo_mysql'
);

$entityManager = EntityManager::create($conn, $config);

$connection = $entityManager->getConnection();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

