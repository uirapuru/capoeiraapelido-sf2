<?php
namespace CA\Component\CoreComponent\Repository;

use CA\Component\User\Country;
use CA\Component\User\CountryRepositoryInterface as BaseRepositoryInterface;
use CA\Component\User\User;

class InMemoryCountryRepository implements BaseRepositoryInterface
{
    /**
     * @var Country[] $countries
     */
    private $countries = [];

    /**
     * @param Country $country
     * @return mixed
     */
    public function save(Country $country)
    {
        $this->countries[$country->getName()] = $country;
    }

    /**
     * @param User $user
     * @return Country
     */
    public function getCountryForUser(User $user)
    {
        return $user->getCity()->getCountry();
    }

    /**
     * @return Country[]
     */
    public function findAll()
    {
        return $this->countries;
    }

    /**
     * @param string $name
     * @return Country
     */
    public function findOneByName($name)
    {
        if(in_array($name, array_keys($this->countries))) {
            return $this->countries[$name];
        }
    }
}