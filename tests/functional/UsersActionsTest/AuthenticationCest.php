<?php

namespace Test\UsersActionsTest;

use Test\FunctionalTester;
use USaq\Model\Entity\User;

class AuthenticationCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function registerCorrectlyAsUser(FunctionalTester $I)
    {
        $userData = [
            'username' => 'user1',
            'password' => '12345678',
            'password_repeat' => '12345678'
        ];

        $I->cantSeeInRepository(User::class, ['username' => $userData['username']]);
        $I->sendPOST('/api/user/register', $userData);
        $I->seeResponseCodeIs(200);
        $I->canSeeInRepository(User::class, ['username' => $userData['username']]);
    }

    public function registerAsUserButUserWithSameUsernameExistsAlready(FunctionalTester $I)
    {
        $I->persistEntity(new User('dave', 'xxxxxxx'));

        $I->wantTo('register as user with username dave');

        $newUser = [
            'username' => 'dave',
            'password' => '12345678',
            'password_repeat' => '12345678'
        ];

        $I->sendPOST('/api/user/register', $newUser);
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['title' => 'Entity already exists']);
    }
}
