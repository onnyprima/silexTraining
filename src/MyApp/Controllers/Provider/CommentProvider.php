<?php
namespace src\MyApp\Controllers\Provider;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;

require '/../CommentController.php';

class CommentProvider implements ControllerProviderInterface{

    public function connect(Application $app)
    {
        $controllers = $app["controllers_factory"];
        
        $app['controller.comments'] = function() use ($app) {
            return new \src\MyApp\Controllers\CommentController($app);
        };

        $controllers->get("/", "controller.comments:index");
        
        $controllers->get("/commentsBy", "controller.comments:getAllCommentBy");
        
        $controllers->post("/", "controller.comments:store");

        $controllers->get("/{id}", "controller.comments:show");

        $controllers->get("/edit/{id}", "controller.comments:edit");

        $controllers->put("/{id}", "controller.comments:update");

        $controllers->delete("/{id}", "controller.comments:destroy"); 

        return $controllers;
    }

}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

