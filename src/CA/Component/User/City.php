<?php
namespace CA\Component\User;

/**
 * Class UserCity
 * @package CA\Component\User
 */
class UserCity {

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var Country $country
     */
    protected $country;

    function __construct($name, Country $country)
    {
        $this->name = $name;
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }
}