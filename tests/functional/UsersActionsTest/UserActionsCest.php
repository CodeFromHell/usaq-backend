<?php
namespace Test\UsersActionsTest;
use Test\FunctionalTester;
use Test\Step\Functional\LoggedUserTester;
use USaq\Model\Entity\User;

class UserActionsCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function listAllUsersButNotAuthenticated(FunctionalTester $I)
    {
        $user = new User('nombre', 'password');
        $I->persistEntity($user);
        $I->sendGET("/api/user/{$user->getId()}/list");
        $I->seeResponseCodeIs(401);
    }

    // tests
    public function listAllUsersExceptAuthenticated(LoggedUserTester $I)
    {
        $totalUsers = count($I->grabEntitiesFromRepository(User::class));

        $I->loginInApplication();
        $I->haveHttpHeader('X-Auth-Token', $I->haveToken());
        $I->sendGET("/api/user/{$I->amUser()->getId()}/list");
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['meta' => ['count' => $totalUsers]]);
    }
}
