<?php
namespace src\MyApp\Controllers;

use Silex\Application;
use src\MyApp\Entity\Comment;
use Symfony\Component\Validator\Constraints as Assert;

class CommentController {
    
    public function index(Application $app)
    {
        return 'index for comment controller';
    }
    public function store(Application $app)
    {   
        $inputData = array (
            'artikel_id' => $_POST['idArt'],
            'description' => $_POST['description']
        );
        
        $constraint = new Assert\Collection(array(
            'artikel_id' => new Assert\NotBlank(),
            'description' => array(
                new Assert\NotBlank(),
                new Assert\Length(array(
                    'min' => 10
                ))
            ),
        )); 
        
        $errors = $app['validator']->validate($inputData, $constraint);
        
        $dataResponse = '';
        
        if(count($errors)>0){
            foreach ($errors as $error){
                $dataResponse .= $error->getPropertyPath().' '.$error->getMessage().'\n';
            }
            $response = array(
                'status' => 0,
                'description' => $dataResponse
            );
            return json_encode($response); 
        }else{
            $entityManager = $app['orm.em'];
        
            $article = $entityManager->find('src\MyApp\Entity\Article', $inputData['artikel_id']);

            $comment = new Comment();
            $comment->setDescription($inputData['description']);

            $article->addComment($comment);

            $entityManager->persist($comment);
            $entityManager->flush();

            $response = array(
                'status' => 1,
                'description' => $inputData['description']
            );
            return json_encode($response);
        }                
    }
    public function getAllCommentBy(Application $app)
    {
        $id = $_GET['id'];
        
        $entityManager = $app['orm.em'];
        
        $article = $entityManager->find('src\MyApp\Entity\Article', $id);
        
        $comments=array();
        
        if (!empty($article)){
            foreach ($article->getComments() as $comment){
                $comments[] = array(
                    'id' => $comment->getId(),
                    'description' => $comment->getDescription()
                );
            }     
        }
        return json_encode($comments);
    }
    
}/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

