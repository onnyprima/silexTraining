<?php
namespace src\MyApp\Models;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse as Response;

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
        return new Response($all); 
    }
    
    public function saveArticle(Application $app, $description)
    {
        $article = new \src\MyApp\Entity\Article();
        $article->setDescription($description);
        $article->setImageUrl('sjadhkahsdkjhkjasd.jpg');
        $entityManager = $app['orm.em'];

        $entityManager->persist($article);
        $entityManager->flush();        
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

