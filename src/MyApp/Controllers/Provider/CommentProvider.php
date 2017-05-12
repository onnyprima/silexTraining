<?php
namespace src\MyApp\Controllers\Provider;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;

require '/../CommentController.php';

class CommentProvider implements ControllerProviderInterface{

    public function connect(Application $app)
    {
        $controllers = $app["controllers_factory"];

        $controllers->get("/", "src\\MyApp\\Controllers\\CommentController::index");
        
        $controllers->get("/commentsBy", "src\\MyApp\\Controllers\\CommentController::getAllCommentBy");
        
        $controllers->post("/", "src\\MyApp\\Controllers\\CommentController::store");

        $controllers->get("/{id}", "src\\MyApp\\Controllers\\CommentController::show");

        $controllers->get("/edit/{id}", "src\\MyApp\\Controllers\\CommentController::edit");

        $controllers->put("/{id}", "src\\MyApp\\Controllers\\CommentController::update");

        $controllers->delete("/{id}", "src\\MyApp\\Controllers\\CommentController::destroy"); 

        return $controllers;
    }

}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

