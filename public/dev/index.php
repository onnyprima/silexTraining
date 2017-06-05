<?php

$loader = require __DIR__.'/../../vendor/autoload.php';
$baseDir = __DIR__.'/../';
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use MyEntity\Foo;
use src\MyApp\Entity\Article;
use src\MyApp\Entity\Comment;
use src\MyApp\Controllers\Provider\ArticleProvider;
use src\MyApp\Controllers\Provider\CommentProvider;
use src\MyApp\Controllers\Provider\UploadProvider;

use src\MyApp\Library\uploader\UploadHandler;

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../../resources/views',
));

$app->register(new \Silex\Provider\ValidatorServiceProvider());
$app->register(new \Silex\Provider\ServiceControllerServiceProvider());

Doctrine\Common\Annotations\AnnotationRegistry::registerLoader([$loader, 'loadClass']);

$app->register(
        new Silex\Provider\DoctrineServiceProvider(),
        [
            'db.options' => [
                'driver' => 'pdo_mysql',
                'host' => 'localhost',
                'dbname' => 'db_silexormDevelopment',
                'user' => 'user',
                'password' => '1234',
                'charset' => 'utf8',
                'driverOptions' => [
                    1002 => 'SET NAMES utf8',
                ],
            ],
        ]
        );

$app->register(new DoctrineOrmServiceProvider(), [
    'orm.proxies_dir' => '/src/MyApp/Entity',
    'orm.auto_generate_proxies' => TRUE,
    'orm.em.options' => [
        'mappings' => [
            [
                'type' => 'annotation',
                'namespace' => 'src\\MyApp\\Entity',
                'path' => $baseDir.'src/MyApp/Entity',
                'use_simple_annotation_reader' => false,
            ],
        ],
    ]
]);

$app->get("/", function(){
    return '<a href="articles">Beranda Development</a>';
});

$app->mount("/articles", new ArticleProvider());
$app->mount("/comments", new CommentProvider());
$app->mount("/upload", new UploadProvider());

$app['debug']=true;
$app->run();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

