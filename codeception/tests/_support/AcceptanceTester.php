<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * @Given Saya Harus pergi ke halaman index
     */
    public function sayaHarusPergiKeHalamanIndex(){
        //throw new \Codeception\Exception\Incomplete("Step `Saya Harus pergi ke halaman index` is not defined");
        $this->amOnPage('http://localhost/blog/public/articles/');
    }
    /**
     * @Then Seharusnya saya melihat judul halaman `New Article`
     */
    public function seharusnyaSayaMelihatJudulHalamanNewArticle()
    {
        //throw new \Codeception\Exception\Incomplete("Step `Seharusnya saya melihat judul halaman `New Article`");
        $this->see('New Article');
    }
    /**
     * @Then ada button Submit
     */
    public function adaButtonSubmit()
    {
        $this->see('Submit');
    }
}
