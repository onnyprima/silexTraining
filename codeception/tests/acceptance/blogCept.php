<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('perform actions and see result');
$I->amOnPage('http://localhost/blog/public/articles/');
$I->see('New Article');
$I->see('Description');
$I->fillField('description', 'onny');
$I->see('myModal');
$I->click('Submit');

