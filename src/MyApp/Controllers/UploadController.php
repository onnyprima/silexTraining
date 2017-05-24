<?php
namespace src\MyApp\Controllers;

use Silex\Application;
use Symfony\Component\Validator\Constraints as Assert;
use src\MyApp\Library\uploader\UploadHandler;

class UploadController {

    protected $app;
    public function __construct(Application $app) {
        $this->app = $app;
    }
    public function index(){
        return include('../resources/views/uploader.php');
    }
    public function saveData()
    {
        error_reporting(E_ALL | E_STRICT);
        $upload_handler = new UploadHandler();
        sleep(3);
        return '';
    }
    public function destroy()
    {
        error_reporting(E_ALL | E_STRICT);
        $upload_handler = new UploadHandler();
        
        return '';
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

