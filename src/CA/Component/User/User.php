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
     * @var City $city
     */
    protected $city;

    /**
     * @var Organization
     */
    protected $organization;

    /**
     * @param $name
     * @param Apelido $apelido
     * @param City $city
     * @param $organization
     */
    function __construct($name, Apelido $apelido, City $city, Organization $organization)
    {
        $this->name = $name;
        $this->apelido = $apelido;
        $this->city = $city;
        $this->organization = $organization;
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
     * @return City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }
}