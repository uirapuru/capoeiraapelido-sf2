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

    function __construct($value, $author)
    {
        $this->value = $value;
        $this->author = $author;
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
}