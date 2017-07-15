<?php
namespace Test\Utils;
use Test\FunctionalTester;
use USaq\App\Exception\ErrorInformation;

class UtilsCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function checkErrorListExists(FunctionalTester $I)
    {
        $I->sendGET('/api/error');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function retrieveInformationFromErrorThatExists(FunctionalTester $I)
    {
        $I->sendGET('/api/error/0');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'data' => [
                'error_code' => 0,
            ]
        ]);
    }

    public function retrieveInformationFromErrorWithIncorrectIdentifier(FunctionalTester $I)
    {
        $I->sendGET('/api/error/-1');
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
    }

    public function retrieveInformationFromNonExistingError(FunctionalTester $I)
    {
        $I->sendGET('/api/error/10000');
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'error_code' => ErrorInformation::ENTITY_NOT_FOUND['error_code']
        ]);
    }
}
