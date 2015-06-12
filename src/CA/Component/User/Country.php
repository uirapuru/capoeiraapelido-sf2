<?php
namespace CA\Component\User;

/**
 * Class Country
 * @package CA\Component\User
 */
class Country {
    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
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