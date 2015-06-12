<?php
namespace CA\Component\User;

/**
 * Interface OrganizationRepositoryInterface
 * @package CA\Component\User
 */
interface OrganizationRepositoryInterface {
    /**
     * @param Organization $organization
     */
    public function save(Organization $organization);

    /**
     * @param User $user
     * @return Organization[]
     */
    public function getOrganizationForUser(User $user);

    /**
     * @return Organization[]
     */
    public function findAll();

    /**
     * @param string $name
     * @return Organization
     */
    public function findOneByName($name);
}