<?php
namespace src\MyApp\Controllers;

use Silex\Application;
use Symfony\Component\Validator\Constraints as Assert;
use src\MyApp\Models\ArticleModel;

class ArticleController {

    protected $articleModel;
    protected $app;
    
    public $cbSurabaya;
    public $description;
    public $id;
    
    public function __construct(Application $ap) {
        $this->app = $ap;
        $this->articleModel = new ArticleModel();
    } 
    
    public function index(){
        
        return $this->app['twig']->render('indexOfArticle.php.twig');
    }
    
    public function getAllArticle()
    {
        return $this->articleModel->allArticle($this->app);        
    }

//<<<<<<< HEAD
    public function fungsiCabangMalang()
    {
        return 'Saya fungsi dari cabangmalang';
//=======
    }
    public function functionFromCabangSurabaya()
    {
        return FALSE;        
//>>>>>>> cabangsurabaya
    }
    
    public function fungsiFromClone()
    {
	return 'Ini fungsi dari clone diedit origin';
    }
	
    public function testCancelCommit()
    {
        return 'Should be Cancel Commit';
    }
    
    public function testKeClone()
    {
        return 'Test Clone Repo';
    }
    public function edit($id)
    {    
        return $id;
    }

    public function show($id){
        return $id;
    }

    public function store(){
        
        if (isset($_POST['description'])){
            $this->description = $_POST['description'];
        }
        
        $newArticle = array (
            'description' => $this->description
        );
        
        $constraint = new \Symfony\Component\Validator\Constraints\Collection(array(
            'description' => array(
                new \Symfony\Component\Validator\Constraints\Length(array('min'=> 50),
                new \Symfony\Component\Validator\Constraints\NotBlank()        
                        )
                )
        ));
        
        $errors = $this->app['validator']->validate($newArticle, $constraint);
        
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
            $this->articleModel->saveArticle($this->app, $newArticle['description']);
            $message['message'] = 'Transaksi Berhasil !';            
        }
        
        header('Content-Type:application/json');
        
        $pesan = array(
            'status' => 0,
            'message' => 'This value is too short. It should have 50 characters or more.'
        );
        
        return json_encode($message);
    }
    
    public function update($id){
        
        $this->id = $id;
        parse_str(file_get_contents("php://input"),$post_vars);
        
        if (isset($post_vars['data'])){
            $this->description = $post_vars['data'];
        }
        
        $updateData = array (
            'id' => $this->id,
            'description' => $this->description
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
        
            $errors = $this->app['validator']->validate($updateData, $constrains);

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
                $entityManager = $this->app['orm.em'];
        
                $article = $entityManager->find('src\MyApp\Entity\Article', $id);        
                $article->setDescription($updateData['description']);

                $entityManager->persist($article);
                $entityManager->flush();
                
                $response['status'] = 1;
                $response['message'] = 'Article '.$id. 'Was Updated!';
            }
        return json_encode($response);
    }

    public function destroy($id){
        
        if ($id != ''){
            $entityManager = $this->app['orm.em'];

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

