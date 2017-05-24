<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Administrasi artikel.');

$I->comment('===Proses untuk melakukan penambahan artikel baru. [saat deskripsi KURANG===]');

$I->amOnPage('http://localhost/blog/public/articles/');
$I->see('New Article');
$I->see('Description');
$I->fillField('description', 'onny');
$I->see('myModal');
$I->click('Submit');
$I->see('Error');

$I->comment('===Proses untuk melakukan penambahan artikel baru. [saat deskripsi PASS===]');

$I->amOnPage('http://localhost/blog/public/articles/');
$I->see('New Article');
$I->see('Description');
$I->fillField('description', 'qrweytqrwetyqweqywtertyqwe qtwretqrwyterqtywretqywretyqwer qtwretyqrwetrqywtertqywreytqwer qwterqwytreyqwetrqtywerytqweryqwte qtyrwetyqrwetyrqytwerqtywerqytwer');
$I->see('myModal');
$I->click('Submit');
$I->see('Sukses');
