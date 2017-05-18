<?php 
$I = new ApiTester($scenario);
$I->wantTo('perform actions and see result');

//add article
//tes kondisi requirement kurang
$I->sendPOST('http://localhost/blog/public/articles/', ['description' => 'test']);
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // ini 200
$I->seeResponseIsJson();
$I->seeResponseContains('{"status":0,"message":"[description] This value is too short. It should have 50 characters or more."}');

//tes saat requirement pas
$I->sendPOST('http://localhost/blog/public/articles/', ['description' => 'abcdeabcde abcdeabcde abcdeabcde abcdeabcde abcdeabcde abcdeabcde']);
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // ini 200
$I->seeResponseIsJson();
$I->seeResponseContains('{"status":1,"message":"Transaksi Berhasil !"}');

//delete aricle
$I->sendDELETE('http://localhost/blog/public/articles/52');
$I->seeResponseContains('1');

//put article saat sesuai
$I->sendPUT('http://localhost/blog/public/articles/52', ['data' => 'ajhdsjkahjksdhajhsdkha ajhsdjkahsjkdhajkhsdkj akjhsdjkahskjdhkajhsd kahsdjahskdhajkhsdjasdh sjadkahsjkdhakjhsdjkhajkhsdkjhajkhsdk']);
$I->seeResponseIsJson();
$I->seeResponseContains('{"status":1,"message":"Article 69Was Updated!"}');

//put article saat tidak sesuai
$I->sendPUT('http://localhost/blog/public/articles/52', ['data' => '']);
$I->seeResponseIsJson();
$I->seeResponseContains('{"status":0,"message":"[description] This value should not be blank."}');


