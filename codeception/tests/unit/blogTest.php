<?php
require __DIR__.'/../../../vendor/autoload.php';
require '../src/MyApp/Controllers/ArticleController.php';
require '../src/MyApp/Models/ArticleModel.php';

use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Application;
use src\MyApp\Controllers\ArticleController;
use src\MyApp\Models\ArticleModel;

class blogTest extends \PHPUnit_Framework_TestCase
{
    const S = 299; 
    public $app;
    public $cbSurabaya;
    public $baseDir = __DIR__.'/../';
    
    protected $descriptionDataAwalPass = array (
        array(
            "id" => self::S + 1,
            "description" => "We challenged ourselves to create a visual language for our users that synthesizes the classic principles of good design with the innovation and possibility of technology and science. This is material design. This spec is a living document that will be updated as we continue to develop the tenets and specifics of material design."
            ),
        array(
            "id" => self::S + 2,
            "description" => "Create a visual language that synthesizes classic principles of good design with the innovation and possibility of technology and science."
            ),
        array(
            "id" => self::S + 3,
            "description" => "Methods.Create a visual language that synthesizes classic principles of good design with the innovation and possibility of technology and science."
            )
    );

    protected $descriptionDataAwalError = array(
        array(
            "id" => 228,
            "description" => "We challenged"
            ),
        array(
            "id" => 229,
            "description" => "Create a "
            ),
        array(
            "id" => 230,
            "description" => "Develop"
            )
    );

    public function __construct() {
        $this->app = new Application();
        $this->setUp();
    }

    protected function setUp()
    {
        $this->app->register(new \Silex\Provider\ValidatorServiceProvider());
        $this->app->register(new \Silex\Provider\ServiceControllerServiceProvider());
        
        $this->app->register(
                new Silex\Provider\DoctrineServiceProvider(),
                [
                    'db.options' => [
                        'driver' => 'pdo_mysql',
                        'host' => 'localhost',
                        'dbname' => 'db_silexorm',
                        'user' => 'user',
                        'password' => '1234',
                        'charset' => 'utf8',
                        'driverOptions' => [
                            1002 => 'SET NAMES utf8',
                        ],
                    ],
                ]
                );

            $this->app->register(new DoctrineOrmServiceProvider(), [
            'orm.proxies_dir' => '/src/MyApp/Entity',
            'orm.auto_generate_proxies' => TRUE,
            'orm.em.options' => [
                'mappings' => [
                    [
                        'type' => 'annotation',
                        'namespace' => 'src\\MyApp\\Entity',
                        'path' => $this->baseDir.'src/MyApp/Entity',
                        'use_simple_annotation_reader' => false,
                    ],
                ],
            ]
        ]);
    }

    protected function tearDown()
    {
        
    }

    public function testInsertArticle()
    {
        $articles = new ArticleModel();
        
        $errorResponse = '{"status":0,"message":"[description] This value is too short. It should have 50 characters or more."}';        
        foreach ($this->descriptionDataAwalError as $key => $value){
            $this->assertJsonStringEqualsJsonString($errorResponse, $articles->saveArticle($this->app, 
                    array(
                        "id" => $value['id'],
                        "description" => $value['description']
                    )
            ));
        }

        $passResponse = array (
            "status" => 1,
            "message" => "Transaksi Berhasil"
        );
        
        foreach ($this->descriptionDataAwalPass as $key2 => $value2){
            $this->assertJsonStringEqualsJsonString(json_encode($passResponse), $articles->saveArticle($this->app,
                    array(
                        "id" => $value2['id'],
                        "description" => $value2['description']
                    )
            ));
        }        
    }
    
    public function testGetAllArticle() 
    {
        $articles = new ArticleModel();
        $dataJson = json_encode($this->descriptionDataAwalPass);
        $this->assertJsonStringEqualsJsonString($dataJson, $articles->allArticle($this->app));
    }
    
    public function testUpdateGagalKarenaIdTidakDitemukan()
    {
        $article = new ArticleModel();
        $data= "Dalam babak final yang digelar di Carrara Indoor Stadium, Minggu (28/5/2017), Korea berhasil mengalahkan China 3-2. Padahal menilik skuat yang dibawa, Korea didominasi pemain muda termasuk tunggal putra Jeon Hyeok Jin (21 tahun) serta Choi Solgyu (21 tahun) dan Chae Yoo Jung (22 tahun). ";
        $constraint = '{"status":0,"message":"Not Found"}';
        $this->assertJsonStringEqualsJsonString($constraint, $article->updateArtikel($this->app, self::S+4, $data)); 
    }
    
    public function testUpdateBerhasil()
    {
        $article = new ArticleModel();
        $data= "Dalam babak final yang digelar di Carrara Indoor Stadium, Minggu (28/5/2017), Korea berhasil mengalahkan China 3-2. Padahal menilik skuat yang dibawa, Korea didominasi pemain muda termasuk tunggal putra Jeon Hyeok Jin (21 tahun) serta Choi Solgyu (21 tahun) dan Chae Yoo Jung (22 tahun). ";
        $constraint = '{"status":1,"message":"Article '.(self::S+1).'Was Updated!"}';
        $this->assertJsonStringEqualsJsonString($constraint, $article->updateArtikel($this->app, self::S+1, $data)); 
    }
    
    public function testDeleteArticleById()
    {
        $article = new ArticleModel();
        
        $this->assertContains('0', [$article->deleteArtikel($this->app, '')]); //jika id tidak ada
        $this->assertContains('1', [$article->deleteArtikel($this->app, self::S+2)]); //jika id ada
    }
}
