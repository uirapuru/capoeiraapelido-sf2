<?php
namespace CA\Component\User;

/**
 * Interface CityRepositoryInterface
 * @package CA\Component\User
 */
interface CityRepositoryInterface {

    /**
     * @param City $city
     */
    public function save(City $city);

    /**
     * @param User $user
     * @return City
     */
    public function getCityForUser(User $user);

    /**
     * @return City[]
     */
    public function findAll();

    /**
     * @param string $name
     * @return City
     */
    public function findOneByName($name);
}