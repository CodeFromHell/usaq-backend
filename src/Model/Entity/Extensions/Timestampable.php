<?php

namespace USaq\Model\Entity\Extensions;

trait Timestampable
{
    /**
     * @var \DateTime
     *
     * @Column(type="datetime")
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @Column(type="datetime")
     */
    protected $updated;

    /**
     * @internal
     *
     * @PrePersist
     * @PreUpdate
     */
    public function updateTimestamp(): void
    {
        if ($this->created === null) {
            $this->created = new \DateTime();
        }

        $this->updated = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     * @return static
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
        return $this;
    }
    /////////////////////////////////////////////////////////////////

    /**
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     * @return $this
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
        return $this;
    }
}