<?php
namespace CA\Component\CoreComponent\Repository;

use CA\Component\User\City;
use CA\Component\User\CityRepositoryInterface as BaseRepositoryInterface;
use CA\Component\User\User;

class InMemoryCityRepository implements BaseRepositoryInterface
{
    /**
     * @var City[] $cities
     */
    private $cities = [];

    /**
     * @param City $city
     * @return mixed
     */
    public function save(City $city)
    {
        $this->cities[$city->getName()] = $city;
    }

    /**
     * @param User $user
     * @return City
     */
    public function getCityForUser(User $user)
    {
        return $user->getCity();
    }

    /**
     * @return City[]
     */
    public function findAll()
    {
        return $this->cities;
    }

    /**
     * @param string $name
     * @return City
     */
    public function findOneByName($name)
    {
        if(in_array($name, array_keys($this->cities))) {
            return $this->cities[$name];
        }
    }
}