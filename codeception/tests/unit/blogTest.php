<?php
require __DIR__.'/../../../vendor/autoload.php';

require '../src/MyApp/Controllers/ArticleController.php';
require '../src/MyApp/Models/ArticleModel.php';

use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;

use Silex\Application;

use src\MyApp\Controllers\ArticleController;

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

    // tests
    public function testfunctionFromCabangSurabaya()
    {
        $test = new ArticleController($this->app);
        
        $this->assertFalse($test->functionFromCabangSurabaya());        
    }
    
    public function testGetAllArticle()
    {
        $articles = new ArticleController($this->app);
        $this->assertTrue($articles->getAllArticle());
    }
    
    public function testDeleteArticle()
    {
        //$article = new ArticleController($this->app);
        //$article->show('55');
        //$this->assertFalse($article);
    }
}
