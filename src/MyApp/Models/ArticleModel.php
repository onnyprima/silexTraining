<?php
namespace src\MyApp\Models;

use Silex\Application;

class ArticleModel {
    
    public function allArticle(Application $app)
    {
        $entityManager = $app['orm.em'];
        $articles = $entityManager->createQueryBuilder()
                ->select('article')
                ->from('src\MyApp\Entity\Article', 'article')
                ->getQuery()
                ->execute();
        foreach ($articles as $article){
            $all [] = array(
                'id' => $article->getId(),
                'description' => $article->getDescription()
            );
        }
        header('Content-Type:application/json');
        return json_encode($all);    
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

