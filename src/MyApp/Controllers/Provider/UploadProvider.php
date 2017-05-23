<?php
namespace src\MyApp\Controllers\Provider;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use src\MyApp\Controllers\UploadController;

class UploadProvider implements ControllerProviderInterface{

    public function connect(Application $app)
    {
        $controllers = $app["controllers_factory"];
        
        $app['controller.index'] = function() use ($app) {
            return new UploadController($app);
        };
           
        $controllers->get("/", "controller.index:index");
        
        $controllers->match("/server/php", "controller.index:saveData");

        $controllers->delete("/delete", "controller.index:destroy"); 

        return $controllers;
    }

}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

