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
class ApiTester extends \Codeception\Actor
{
    use _generated\ApiTesterActions;

    /**
     * @Given sendPOSTdata
     */ 
    public function sendPOSTdata()
    {
        $this->sendPOST('http://localhost/blog/public/articles/', ['description' => 'test']);
    }
    /**
     * @Given melihat response JSON
     */
    public function melihatResponseJSON()
    {
        $this->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // ini 200
        $this->seeResponseIsJson();
        $this->seeResponseContains('{"status":0,"message":"[description] This value is too short. It should have 50 characters or more."}');        
    }
}
