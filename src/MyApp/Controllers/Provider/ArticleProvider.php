<?php
namespace src\MyApp\Controllers\Provider;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;

require '/../ArticleController.php';

class ArticleProvider implements ControllerProviderInterface{

    public function connect(Application $app)
    {
        $controllers = $app["controllers_factory"];

        $controllers->get("/", "src\\MyApp\\Controllers\\ArticleController::index");
        
        $controllers->get("/allArticle", "src\\MyApp\\Controllers\\ArticleController::getAllArticle");
        
        $controllers->post("/", "src\\MyApp\\Controllers\\ArticleController::store");

        $controllers->get("/{id}", "src\\MyApp\\Controllers\\ArticleController::show");

        $controllers->get("/edit/{id}", "src\\MyApp\\Controllers\\ArticleController::edit");

        $controllers->put("/{id}", "src\\MyApp\\Controllers\\ArticleController::update");

        $controllers->delete("/{id}", "src\\MyApp\\Controllers\\ArticleController::destroy"); 

        return $controllers;
    }

}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

