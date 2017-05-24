<?php
namespace src\MyApp\Controllers;

use Silex\Application;
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
    
    public function store(){
        
        if (isset($_POST['description'])){
            $this->description = $_POST['description'];
        }
        $newArticle = array (
            'description' => $this->description
        );        
        
        return $this->articleModel->saveArticle($this->app, $newArticle);        
    }
    
    public function update($id){
        
        $this->id = $id;
        parse_str(file_get_contents("php://input"),$post_vars);
        
        if (isset($post_vars['data'])){
            $this->description = $post_vars['data'];
        }
        
        return $this->articleModel->updateArtikel($this->app, $id, $this->description);
    }

    public function destroy($id)
    {
        return $this->articleModel->deleteArtikel($this->app, $id);
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

    
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

