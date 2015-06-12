<?php
namespace CA\Component\CoreComponent\Repository;

use CA\Component\User\Organization;
use CA\Component\User\OrganizationRepositoryInterface as BaseRepositoryInterface;
use CA\Component\User\User;

class InMemoryOrganizationRepository implements BaseRepositoryInterface
{
    /**
     * @var Organization[] $organizations
     */
    private $organizations = [];

    /**
     * @param Organization $organization
     * @return mixed
     */
    public function save(Organization $organization)
    {
        $this->organizations[$organization->getName()] = $organization;
    }

    /**
     * @param User $user
     * @return Organization
     */
    public function getOrganizationForUser(User $user)
    {
        return $user->getOrganization();
    }

    /**
     * @return Organization[]
     */
    public function findAll()
    {
        return $this->organizations;
    }

    /**
     * @param string $name
     * @return Organization
     */
    public function findOneByName($name)
    {
        if(in_array($name, array_keys($this->organizations))) {
            return $this->organizations[$name];
        }
    }
}