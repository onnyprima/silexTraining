<?php 
$I = new ApiTester($scenario);
$I->wantTo('======================== Pengetesan API artikel ==========================');

$I->comment("===>skenario pertama input data dengan karakter description kurang.===>");
//add article
//tes kondisi requirement kurang
$I->sendPOST('http://localhost/blog/public/articles/', ['description' => 'test']);
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // ini 200
$I->seeResponseIsJson();
$I->seeResponseContains('{"status":0,"message":"[description] This value is too short. It should have 50 characters or more."}');

$I->comment("===>skenario kedua input data dengan karakter description sesuai.===>");
//tes saat requirement pas
$I->sendPOST('http://localhost/blog/public/articles/', ['description' => 'abcdeabcde abcdeabcde abcdeabcde abcdeabcde abcdeabcde abcdeabcde']);
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // ini 200
$I->seeResponseIsJson();
$I->seeResponseContains('{"status":1,"message":"Transaksi Berhasil !"}');

$I->comment("===>skenario ke tiga DELETE data.===>");
//delete aricle
$I->sendDELETE('http://localhost/blog/public/articles/52');
$I->seeResponseContains('1');

$I->comment("===>skenario ke empat update data dengan karakter description sesuai.===>");
//put article saat sesuai
$I->sendPUT('http://localhost/blog/public/articles/53', ['data' => 'ajhdsjkahjksdhajhsdkha ajhsdjkahsjkdhajkhsdkj akjhsdjkahskjdhkajhsd kahsdjahskdhajkhsdjasdh sjadkahsjkdhakjhsdjkhajkhsdkjhajkhsdk']);
$I->seeResponseIsJson();
$I->seeResponseContains('{"status":1,"message":"Article 53Was Updated!"}');

$I->comment("===>skenario ke lima update data dengan karakter description kurang.===>");
//put article saat tidak sesuai
$I->sendPUT('http://localhost/blog/public/articles/65', ['data' => '']);
$I->seeResponseIsJson();
$I->seeResponseContains('{"status":0,"message":"[description] This value should not be blank."}');


