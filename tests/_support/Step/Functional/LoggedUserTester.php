<?php
namespace Test\Step\Functional;

use Codeception\Scenario;
use USaq\Model\Entity\User;

class LoggedUserTester extends \Test\FunctionalTester
{
    private $myself;

    private $token;

    public function __construct(Scenario $scenario)
    {
        parent::__construct($scenario);
        $this->myself = new User('logged', password_hash('password', PASSWORD_BCRYPT));
    }

    public function amUser()
    {
        return $this->myself;
    }

    public function haveToken()
    {
        return $this->token;
    }

    public function loginInApplication()
    {
        $I = $this;
        $I->persistEntity($this->myself);
        $I->sendPOST('/api/user/login', ['username' => 'logged', 'password' => 'password']);
        $I->seeResponseCodeIs(200);
        $response = $I->grabResponse();
        $responseArray = json_decode($response, true);
        $this->token = $responseArray['data']['token'];
    }
}