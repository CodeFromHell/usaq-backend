<?php

namespace USaq\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use USaq\Model\Entity\Extensions\Timestampable;

/**
 * User model.
 *
 * Represent user in the application.
 *
 * @Entity(repositoryClass="USaq\Model\Repository\UserRepository")
 * @Table(name="users")
 * @HasLifecycleCallbacks
 */
class User
{
    use Timestampable;

    /**
     * @var integer
     *
     * @Id @GeneratedValue
     * @Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(type="string")
     */
    private $username;

    /**
     * @var string
     *
     * @Column(type="string")
     */
    private $password;

    /**
     * @var string
     *
     * @Column(type="string", nullable=true)
     */
    private $nickname;

    /**
     * Many Users have many Users as friends.
     *
     * @ManyToMany(targetEntity="User")
     * @JoinTable(
     *     name="users_friends",
     *     joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@JoinColumn(name="friend_user_id", referencedColumnName="id")}
     * )
     */
    private $friends;

    /**
     * User constructor.
     *
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
        $this->friends = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set username.
     *
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set password.
     *
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get nickname.
     *
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname ?? '';
    }

    /**
     * Set nickname.
     *
     * @param string $nickname
     * @return User
     */
    public function setNickname(string $nickname): User
    {
        $this->nickname = $nickname;
        return $this;
    }

    /**
     * Add new friend to user.
     *
     * @param User $friend
     */
    public function addFriend(User $friend): void
    {
        if (!$this->friends->contains($friend)) {
            $this->friends->add($friend);
        }
    }

    /**
     * Removes friend.
     *
     * @param $friend
     */
    public function removeFriend(User $friend): void
    {
        $this->friends->removeElement($friend);
    }

    /**
     * Return all friends from user.
     *
     * @return Collection
     */
    public function getAllFriends()
    {
        return $this->friends;
    }
}
