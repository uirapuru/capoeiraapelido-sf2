<?php
namespace CA\Component\User;
use CA\Component\Apelido\Apelido;

/**
 * Class User
 * @package CA\Component\User
 */
class User {

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Apelido $apelido
     */
    protected $apelido;

    /**
     * @var string $city
     */
    protected $city;

    /**
     * @var string $country
     */
    protected $country;

    /**
     * @var string
     */
    protected $organization;

    /**
     * @var string
     */
    protected $token;

    /**
     * @param $name
     * @param Apelido $apelido
     * @param $city
     * @param $country
     * @param $organization
     * @param $token
     */
    function __construct($name, Apelido $apelido, $city, $country, $organization, $token)
    {
        $this->name = $name;
        $this->apelido = $apelido;
        $this->city = $city;
        $this->country = $country;
        $this->organization = $organization;
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Apelido
     */
    public function getApelido()
    {
        return $this->apelido;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }
}