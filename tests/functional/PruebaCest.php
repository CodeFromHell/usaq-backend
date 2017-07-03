<?php
namespace Test;
use Test\FunctionalTester;

class PruebaCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        error_log('entra test');
        $I->sendPOST('/api/user/register', ['username' => 'weadadawd', 'password' => 'gato', 'password_repeat' => 'gato']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['correct' => 'OK']);
    }
}
