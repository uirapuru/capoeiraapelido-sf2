<?php
namespace CA\Component\User;

/**
 * Class City
 * @package CA\Component\User
 */
class City {

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