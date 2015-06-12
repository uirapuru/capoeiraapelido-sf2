<?php
namespace CA\Component\User;

/**
 * Interface CountryRepositoryInterface
 * @package CA\Component\User
 */
interface CountryRepositoryInterface {

    /**
     * @param Country $country
     */
    public function save(Country $country);

    /**
     * @param User $user
     * @return Country
     */
    public function getCountryForUser(User $user);

    /**
     * @return Country[]
     */
    public function findAll();

    /**
     * @param string $name
     * @return Country
     */
    public function findOneByName($name);
}