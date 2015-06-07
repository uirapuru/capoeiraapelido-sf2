<?php
namespace CA\Component\User;

/**
 * Class Organization
 * @package CA\Component\User
 */
class Organization {

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @param $name
     */
    function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}