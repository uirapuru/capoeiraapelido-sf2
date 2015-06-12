<?php
namespace CA\Component\CoreComponent;

use CA\Component\User\City;
use CA\Component\User\CityRepositoryInterface;
use CA\Component\User\CountryRepositoryInterface;
use CA\Component\User\Organization;
use CA\Component\User\OrganizationRepositoryInterface;
use CA\Component\User\User;
use CA\Component\User\UserRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateUser
{
    const SUCCESS = 'capoeira_apelido.user.creation_success';
    const FAILURE = 'capoeira_apelido.user.creation_failure';
    const SUCCESS_CITY = 'capoeira_apelido.user.city.creation_success';
    const FAILURE_CITY = 'capoeira_apelido.user.city.creation_failure';
    const SUCCESS_COUNTRY = 'capoeira_apelido.user.country.creation_success';
    const FAILURE_COUNTRY = 'capoeira_apelido.user.country.creation_failure';
    const SUCCESS_ORGANIZATION = 'capoeira_apelido.user.organization.creation_success';
    const FAILURE_ORGANIZATION = 'capoeira_apelido.user.organization.creation_failure';

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var CountryRepositoryInterface
     */
    private $countryRepository;

    /**
     * @var CityRepositoryInterface
     */
    private $cityRepository;

    /**
     * @var OrganizationRepositoryInterface
     */
    private $organizationRepository;

    /**
     * @var EventDispatcherInterface $dispatcher
     */
    private $dispatcher;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param CountryRepositoryInterface $countryRepository
     * @param CityRepositoryInterface $cityRepository
     * @param OrganizationRepositoryInterface $organizationRepository
     * @param EventDispatcherInterface $dispatcher
     */
    function __construct(
        UserRepositoryInterface $userRepository,
        CountryRepositoryInterface $countryRepository,
        CityRepositoryInterface $cityRepository,
        OrganizationRepositoryInterface $organizationRepository,
        EventDispatcherInterface $dispatcher
    )
    {
        $this->userRepository = $userRepository;
        $this->countryRepository = $countryRepository;
        $this->cityRepository = $cityRepository;
        $this->organizationRepository = $organizationRepository;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param User $user
     */
    public function createUser(User $user)
    {
        if (!$user->getName()) {
            $this->dispatcher->dispatch(self::FAILURE, new Event([
                'user' => $user,
                'reason'  => 'User name is empty'
            ]));

            return;
        }

        $this->saveCity($user->getCity());
        $this->saveOrganization($user->getOrganization());

        $this->userRepository->save($user);
        $this->dispatcher->dispatch(self::SUCCESS, new Event(['user' => $user]));
    }

    /**
     * @param City $city
     */
    private function saveCity(City $city)
    {
        $country = $city->getCountry();

        $foundCountry = $this->countryRepository->findOneByName($city->getCountry()->getName());

        if(!$foundCountry) {
            $this->countryRepository->save($country);
            $this->dispatcher->dispatch(self::SUCCESS_COUNTRY, new Event(['country' => $country]));
        }

        $foundCity = $this->cityRepository->findOneByName($city->getName());

        if(!$foundCity) {
            $this->cityRepository->save($city);
            $this->dispatcher->dispatch(self::SUCCESS_CITY, new Event(['city' => $city]));
        }
    }

    /**
     * @param Organization $organization
     */
    private function saveOrganization(Organization $organization)
    {
        $foundOrganization = $this->organizationRepository->findOneByName($organization->getName());

        if(!$foundOrganization) {
            $this->organizationRepository->save($organization);
            $this->dispatcher->dispatch(self::SUCCESS_ORGANIZATION, new Event(['organization' => $organization]));
        }
    }
}