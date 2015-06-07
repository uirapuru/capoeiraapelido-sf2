<?php
namespace CA\Component\Description;

use CA\Component\User\User;

/**
 * Class Thumb
 * @package CA\Component\Description
 */
class Thumb {
    /**
     * @var integer $value
     */
    protected $value;

    /**
     * @var User
     */
    protected $author;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    function __construct($value, $author, $createdAt)
    {
        $this->value = $value;
        $this->author = $author;
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}