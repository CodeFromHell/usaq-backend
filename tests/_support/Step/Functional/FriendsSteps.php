<?php
namespace Test\Step\Functional;

use USaq\Model\Entity\User;

class FriendsSteps
{
    protected $I;

    public function __construct(LoggedUserTester $I)
    {
        $this->I = $I;
    }

    /**
     * @Given I have a friend with username :username
     */
    public function iHaveAFriendWithUsername($username)
    {
        /** @var User $user */
        $user = $this->I->grabEntityFromRepository(User::class, ['username' => $username]);
        $this->I->amUser()->addFriend($user);
        $this->I->persistEntity($this->I->amUser());
    }

    /**
     * @When I add new friend with username :username
     */
    public function iAddNewFriendWithUsername($username)
    {
        /** @var User $user */
        $user = $this->I->grabEntityFromRepository(User::class, ['username' => $username]);
        $this->I->amUser()->addFriend($user);
        $this->I->persistEntity($this->I->amUser());
    }

    /**
     * @Then I see i have :friendCount friends
     */
    public function iSeeIHaveFriends($friendCount)
    {
        /** @var User $myself */
        $myself = $this->I->grabEntityFromRepository(User::class, ['username' => $this->I->amUser()->getUsername()]);
        $this->I->assertEquals($friendCount, $myself->getAllFriends()->count());
    }

    /**
     * @Given I am logged in as user
     */
    public function iAmLoggedInAsUserWithUsername()
    {
        $this->I->loginInApplication();
    }

    /**
     * @Given Exists an user with username :username
     */
    public function existsAnUserWithUsername($username)
    {
        $user = new User($username, 'password');
        $this->I->persistEntity($user);
    }

    /**
     * @When I remove a friend with username :username
     */
    public function iRemoveAFriendWithUsername($username)
    {
        /** @var User $user */
        $user = $this->I->grabEntityFromRepository(User::class, ['username' => $username]);
        $this->I->amUser()->removeFriend($user);
        $this->I->persistEntity($this->I->amUser());
    }
}