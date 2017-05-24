<?php
namespace src\MyApp\Controllers\Provider;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use src\MyApp\Controllers\ArticleController;

class ArticleProvider implements ControllerProviderInterface{

    public function connect(Application $app)
    {
        $controllers = $app["controllers_factory"];
        
        $app['controller.index'] = function() use ($app) {
            return new ArticleController($app);
        };
           
        $controllers->get("/", "controller.index:index");
        
        $controllers->get("/allArticle", "controller.index:getAllArticle");
        
        $controllers->post("/", "controller.index:store");

        $controllers->get("/{id}", "controller.index:show");

        $controllers->get("/edit/{id}", "controller.index:edit");

        $controllers->put("/{id}", "controller.index:update");

        $controllers->delete("/{id}", "controller.index:destroy"); 

        return $controllers;
    }

}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

