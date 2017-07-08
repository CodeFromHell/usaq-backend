<?php

namespace USaq\Model\Entity;

/**
 * Token model.
 *
 * @package USaq\Model\Entity
 */
class Token
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $tokenString;

    /**
     * @var \DateTime
     */
    private $expireAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Token
     */
    public function setUser(User $user): Token
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getTokenString(): string
    {
        return $this->tokenString;
    }

    /**
     * @param string $tokenString
     * @return Token
     */
    public function setTokenString(string $tokenString): Token
    {
        $this->tokenString = $tokenString;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpireAt(): \DateTime
    {
        return $this->expireAt;
    }

    /**
     * @param \DateTime $expireAt
     * @return Token
     */
    public function setExpireAt(\DateTime $expireAt): Token
    {
        $this->expireAt = $expireAt;
        return $this;
    }

    /**
     * Generate a random string token
     */
    public function generateRandomToken(): void
    {
        $token = bin2hex(random_bytes(20));
        $this->setTokenString($token);
    }
}
