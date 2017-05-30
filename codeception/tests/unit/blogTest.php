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
    public $app;
    public $cbSurabaya;
    public $baseDir = __DIR__.'/../';
    
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

    public function testfunctionFromCabangSurabaya()
    {
        $test = new ArticleController($this->app);        
        $this->assertFalse($test->functionFromCabangSurabaya());        
    }
    
    public function testGetAllArticle() 
    {
        $articles = new ArticleModel();
        $data = '[{"id":61,"description":"Dalam babak final yang digelar di Carrara Indoor Stadium, Minggu (28\/5\/2017), Korea berhasil mengalahkan China 3-2. Padahal menilik skuat yang dibawa, Korea didominasi pemain muda termasuk tunggal putra Jeon Hyeok Jin (21 tahun) serta Choi Solgyu (21 tahun) dan Chae Yoo Jung (22 tahun). "},{"id":62,"description":"Choi Solgyu\/Chae Yoo Jung yang ada di urutan ke-14 dunia mampu tampil tenang menghadapi ganda campuran China, Lu Kai\/Huang Yaqiong, dengan skor 21-17, 21-13 sekaligus memastikan juara untuk Korea. "}]';
        $this->assertJsonStringEqualsJsonString($data, $articles->allArticle($this->app));
    }
    
    public function testPenyimpananGagalKarenaDeskripsiJumlahCharakterKurang()
    {
        $articles = new ArticleController($this->app);
        $errorResponse = '{"status":0,"message":"[description] This value is too short. It should have 50 characters or more."}';
        $articles->description = "Test data";
        $this->assertJsonStringEqualsJsonString($errorResponse, $articles->store());
    }
    
    public function testUpdateGagalKarenaIdTidakDitemukan()
    {
        $article = new ArticleController($this->app);
        $article->description = "Test Update ashkdkjhaskjdh aksjhdjkashjkdhkjahsd aksjhdjkahsdkhajshd ashdjahsjdkhaksdh asjhdjahskjdhkashd";
        $constraint = '{"status":0,"message":"Not Found"}';
        $this->assertJsonStringEqualsJsonString($constraint, $article->update('65')); //ID 65 tidak ada di database
    }
    
    public function testUpdateBerhasil()
    {
        $article = new ArticleController($this->app);
        $article->description = "Dalam babak final yang digelar di Carrara Indoor Stadium, Minggu (28/5/2017), Korea berhasil mengalahkan China 3-2. Padahal menilik skuat yang dibawa, Korea didominasi pemain muda termasuk tunggal putra Jeon Hyeok Jin (21 tahun) serta Choi Solgyu (21 tahun) dan Chae Yoo Jung (22 tahun). ";
        $constraint = '{"status":1,"message":"Article 61Was Updated!"}';
        $this->assertJsonStringEqualsJsonString($constraint, $article->update('61')); //ID 65 ada di database
    }
    
    public function testDeleteArticleById()
    {
        $article = new ArticleController($this->app);
        $this->assertContains('0', [$article->destroy('')]); //jika id kosong
        $this->assertContains('1', [$article->destroy(71)]); //jika id ada
    }
}
