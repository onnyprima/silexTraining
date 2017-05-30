<?php
namespace src\MyApp\Models;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse as Response;
use Symfony\Component\Validator\Constraints as Assert;

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
        return json_encode($all);
    }
    
    public function saveArticle(Application $app, $description)
    {        
        $constraint = new \Symfony\Component\Validator\Constraints\Collection(array(
            'description' => array(
                new \Symfony\Component\Validator\Constraints\Length(array('min'=> 50)                        )
                )
        ));
        
        $errors = $app['validator']->validate($description, $constraint);
        
        $message=array(
            'status' => 1,
            'message' => ''
        );
        
        if (count($errors) > 0){
            $message['status'] = 0;
            foreach ($errors  as $error) {
                    $message['message'] .= $error->getPropertyPath().' '.$error->getMessage();
            }
        }else{            
            $article = new \src\MyApp\Entity\Article();
            $article->setDescription($description['description']);
            $article->setImageUrl('sjadhkahsdkjhkjasd.jpg');
            $entityManager = $app['orm.em'];

            $entityManager->persist($article);
            $entityManager->flush();
            $message['message'] = 'Transaksi Berhasil !';            
        }
        return json_encode($message);        
    }
    public function updateArtikel(Application $app, $id, $description)
    {
        $updateData = array (
            'id' => $id,
            'description' => $description
        );
        
        $constrains = new Assert\Collection(array(
            'id' => new Assert\NotBlank(),
            'description' => array(
                new Assert\NotBlank(),
                new Assert\Length(array(
                    'min' => 50
                ))
            )
        ));
        
            $errors = $app['validator']->validate($updateData, $constrains);

            $errorCode = '';

            $response = array(
                'status' => 0,
                'message' => 'Error'
            );
            if (count($errors)>0){
                foreach ($errors as $error){
                    $errorCode .= $error->getPropertyPath().' '.$error->getMessage();
                }
                $response['status'] = 0;
                $response['message'] = $errorCode;
            }else{
                $entityManager = $app['orm.em'];
        
                $article = $entityManager->find('src\MyApp\Entity\Article', $id);
                
                if ($article == NULL){
                    $response['status'] = 0;
                    $response['message'] = 'Not Found';
                }else{
                    $article->setDescription($updateData['description']);

                    $entityManager->persist($article);
                    $entityManager->flush();

                    $response['status'] = 1;
                    $response['message'] = 'Article '.$id. 'Was Updated!';
                }
                //$article = $entityManager->createQueryBuilder()
                //        ->select('article')
                //        ->from('src\MyApp\Entity\Article', 'article')
                //        ->where('article.id = :id')
                //        ->setParameter('id', $id)
                //        ->getQuery()
                //        ->execute();
                //var_dump($article->getDescription());
                //foreach ($article as $row){
                //    var_dump($article);
                //    var_dump($row->getDescription());
                //}
            }
        return json_encode($response);
    }
    public function deleteArtikel(Application $app, $id)
    {
        if ($id != ''){
            $entityManager = $app['orm.em'];

            $comments = $entityManager->createQueryBuilder()
                    ->select('comment')
                    ->from('src\MyApp\Entity\Comment', 'comment')
                    ->where('comment.article = :id ')
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->execute();

            foreach ($comments as $comment){
                    $entityManager->remove($comment);
                    $entityManager->flush();
            }

            $article = $entityManager->find('src\MyApp\Entity\Article', $id);
            $entityManager->remove($article);
            $entityManager->flush();
            
            return '1';
        }else{
            return '0';
        }
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

