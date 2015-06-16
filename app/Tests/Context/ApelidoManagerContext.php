<?php

use Behat\Behat\Context\ContextInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;
use CA\Component\CoreComponent\CreateApelido;
use CA\Component\CoreComponent\CreateUser;
use CA\Component\CoreComponent\Repository\InMemoryApelidoRepository;
use CA\Component\CoreComponent\Repository\InMemoryUserRepository;
use CA\Component\CoreComponent\Repository\InMemoryCityRepository;
use CA\Component\CoreComponent\Repository\InMemoryCountryRepository;
use CA\Component\CoreComponent\Repository\InMemoryOrganizationRepository;
use CA\Component\Apelido\Apelido;
use CA\Component\Apelido\ApelidoRepositoryInterface;
use CA\Component\User\User;
use CA\Component\User\Organization;
use CA\Component\User\City;
use CA\Component\User\Country;
use CA\Component\User\UserRepositoryInterface;
use CA\Component\User\OrganizationRepositoryInterface;
use CA\Component\User\CityRepositoryInterface;
use CA\Component\User\CountryRepositoryInterface;

/**
 * Class ApelidoManagerContext
 */
class ApelidoManagerContext implements ContextInterface {

    /**
     * @var User
     */
    private $loggedInUser;

    /**
     * @var ApelidoRepositoryInterface
     */
    private $apelidoRepository;

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
     * @var string[]
     */
    private $notifications = [];

    /**
     * @var CreateApelido $createApelido
     */
    private $createApelido;

    /**
     * @var CreateUser $createUser
     */
    private $createUser;

    /**
     * @param Event $event
     */
    public function recordNotification(Event $event)
    {
        $this->notifications[] = $event->getName();
    }

    /**
     * @BeforeScenario
     */
    public function prepare()
    {
        $dispatcher = new EventDispatcher();

        $this->apelidoRepository = new InMemoryApelidoRepository();
        $this->userRepository = new InMemoryUserRepository();
        $this->countryRepository = new InMemoryCountryRepository();
        $this->cityRepository = new InMemoryCityRepository();
        $this->organizationRepository = new InMemoryOrganizationRepository();

        $this->createApelido = new CreateApelido($this->apelidoRepository, $dispatcher);
        $this->createUser = new CreateUser(
            $this->userRepository,
            $dispatcher
        );

        $machadoApelido = new Apelido("Machado");
        $this->createApelido->createApelido($machadoApelido);


        $this->cityRepository->save($berlinCity);
        $this->countryRepository->save($germanyCountry);
        $this->organizationRepository->save($abadaOrganization);

        $dispatcher->addListener(CreateApelido::SUCCESS, [$this, 'recordNotification']);
        $dispatcher->addListener(CreateApelido::FAILURE, [$this, 'recordNotification']);
        $dispatcher->addListener(CreateUser::SUCCESS, [$this, 'recordNotification']);
        $dispatcher->addListener(CreateUser::FAILURE, [$this, 'recordNotification']);
        $dispatcher->addListener(CreateUser::SUCCESS_CITY, [$this, 'recordNotification']);
        $dispatcher->addListener(CreateUser::FAILURE_CITY, [$this, 'recordNotification']);
        $dispatcher->addListener(CreateUser::SUCCESS_COUNTRY, [$this, 'recordNotification']);
        $dispatcher->addListener(CreateUser::FAILURE_COUNTRY, [$this, 'recordNotification']);
        $dispatcher->addListener(CreateUser::SUCCESS_ORGANIZATION, [$this, 'recordNotification']);
        $dispatcher->addListener(CreateUser::FAILURE_ORGANIZATION, [$this, 'recordNotification']);

    }

    /**
     * @Given /^I am not logged in$/
     */
    public function iAmNotLoggedIn()
    {
        if($this->loggedInUser != null) {
            throw new RuntimeException("User is not null!");
        }
    }

    /**
     * @When /^I create new apelido "([^"]*)"$/
     * @When /^I create new apelido "([^"]*)" with email "([^"]*)", group "([^"]*)", city "([^"]*)", country "([^"]*)"$/
     */
    public function iCreateNewApelidoWithEmail($apelido, $email, $organization, $city, $country)
    {
        $apelido = new Apelido($apelido);

        $this->createApelido->createApelido($apelido);

        $user = new User(
            $email,
            $apelido,
            new City($city, new Country($country)),
            new Organization($organization),
            uniqid()
        );

        $this->createUser->createUser($user);

        $this->loggedInUser = $user;
    }

    /**
     * @Then /^apelido "([^"]*)" should be saved$/
     */
    public function apelidoShouldBeSaved($name)
    {
        foreach($this->apelidoRepository->findAll() as $apelido)
        {
            if ($apelido->getName() == $name) {
                return;
            }
        }

        throw new RuntimeException("Apelido not saved");
    }

    /**
     * @Given /^my account "([^"]*)" created$/
     */
    public function myAccountCreated($email)
    {
        foreach($this->userRepository->findAll() as $user)
        {
            if ($user->getName() == $email) {
                return;
            }
        }

        throw new RuntimeException("Account not saved");
    }

    /**
     * @Given /^I should be notified about successful apelido creation$/
     */
    public function iShouldBeNotifiedAboutSuccess()
    {
        if (!in_array(CreateApelido::SUCCESS, $this->notifications)) {
            throw new RuntimeException('No notification received');
        };
    }

    /**
     * @Given /^I should be notified about successful account creation$/
     */
    public function iShouldBeNotifiedAboutSuccessfulAccountCreation()
    {
        if (!in_array(CreateUser::SUCCESS, $this->notifications)) {
            throw new RuntimeException('No notification received');
        };
    }

    /**
     * @Given /^I should get a valid token for my account$/
     */
    public function iShouldGetAValidTokenForMyAccount()
    {
        $token = $this->loggedInUser->getToken();

        $user = $this->userRepository->getUserByToken($token);

        if($user->getName() !== $this->loggedInUser->getName()) {
            throw new \RuntimeException("Logged in user with token does not exists in repository");
        }
    }

    /**
     * @Given /^apelido "([^"]*)" does not exists$/
     */
    public function apelidoDoesNotExists($name)
    {
        foreach($this->apelidoRepository->findAll() as $apelido)
        {
            if ($apelido->getName() == $name) {
                throw new \RuntimeException("Apelido already exists!");
            }
        }
    }

    /**
     * @Given /^I am logged in as "([^"]*)"$/
     */
    public function iAmLoggedInAs($arg1)
    {
        if(!$this->loggedInUser || $this->loggedInUser->getName() !== $arg1) {
            throw new \RuntimeException("User is not logged in");
        }
    }

    /**
     * @Given /^apelido "([^"]*)" does exist$/
     */
    public function apelidoDoesExist($name)
    {
        foreach($this->apelidoRepository->findAll() as $apelido)
        {
            if ($apelido->getName() == $name) {
                return;
            }
        }

        throw new \RuntimeException("Apelido does not exist!");
    }

    /**
     * @Given /^I should not be notified about successful apelido creation$/
     */
    public function iShouldNotBeNotifiedAboutSuccessfulApelidoCreation()
    {
        if (in_array(CreateApelido::SUCCESS, $this->notifications)) {
            throw new RuntimeException('Notification received!');
        };
    }

    /**
     * @Given /^group "([^"]*)" does not exist$/
     */
    public function groupDoesNotExist($name)
    {
        foreach($this->organizationRepository->findAll() as $group)
        {
            if ($group->getName() == $name) {
                throw new \RuntimeException("Group already exists!");
            }
        }
    }

    /**
     * @Given /^city "([^"]*)" does not exist$/
     */
    public function cityDoesNotExist($name)
    {
        foreach($this->cityRepository->findAll() as $city)
        {
            if ($city->getName() == $name) {
                throw new \RuntimeException("City already exists!");
            }
        }
    }

    /**
     * @Given /^country "([^"]*)" does not exist$/
     */
    public function countryDoesNotExist($name)
    {
        foreach($this->countryRepository->findAll() as $country)
        {
            if ($country->getName() == $name) {
                throw new \RuntimeException("Country already exists!");
            }
        }
    }

    /**
     * @Given /^group "([^"]*)" should be saved$/
     * @Given /^group "([^"]*)" does exist$/
     */
    public function groupShouldBeSaved($name)
    {
        foreach($this->organizationRepository->findAll() as $group)
        {
            if ($group->getName() == $name) {
                return;
            }
        }

        throw new RuntimeException("Group not saved");
    }

    /**
     * @Given /^city "([^"]*)" should be saved$/
     * @Given /^city "([^"]*)" does exist$/
     */
    public function cityShouldBeSaved($name)
    {
        foreach($this->cityRepository->findAll() as $city)
        {
            if ($city->getName() == $name) {
                return;
            }
        }

        throw new RuntimeException("City not saved");
    }

    /**
     * @Given /^country "([^"]*)" should be saved$/
     * @Given /^country "([^"]*)" does exist$/
     */
    public function countryShouldBeSaved($name)
    {
        foreach($this->countryRepository->findAll() as $country)
        {
            if ($country->getName() == $name) {
                return;
            }
        }

        throw new RuntimeException("Country not saved");
    }

    /**
     * @Given /^I should be notified about successful group creation$/
     */
    public function iShouldBeNotifiedAboutSuccessfulGroupCreation()
    {
        if (!in_array(CreateUser::SUCCESS_ORGANIZATION, $this->notifications)) {
            throw new RuntimeException('Notification not received!');
        };
    }

    /**
     * @Given /^I should be notified about successful city creation$/
     */
    public function iShouldBeNotifiedAboutSuccessfulCityCreation()
    {
        if (!in_array(CreateUser::SUCCESS_CITY, $this->notifications)) {
            throw new RuntimeException('Notification not received!');
        };
    }

    /**
     * @Given /^I should be notified about successful country creation$/
     */
    public function iShouldBeNotifiedAboutSuccessfulCountryCreation()
    {
        if (!in_array(CreateUser::SUCCESS_COUNTRY, $this->notifications)) {
            throw new RuntimeException('Notification not received!');
        };
    }

    /**
     * @Given /^I should not be notified about group creation$/
     */
    public function iShouldNotBeNotifiedAboutGroupCreation()
    {
        if (in_array(CreateUser::SUCCESS_ORGANIZATION, $this->notifications)) {
            throw new RuntimeException('Notification received!');
        };
    }

    /**
     * @Given /^I should not be notified about city creation$/
     */
    public function iShouldNotBeNotifiedAboutCityCreation()
    {
        if (in_array(CreateUser::SUCCESS_CITY, $this->notifications)) {
            throw new RuntimeException('Notification received!');
        };
    }

    /**
     * @Given /^I should not be notified about country creation$/
     */
    public function iShouldNotBeNotifiedAboutCountryCreation()
    {
        if (in_array(CreateUser::SUCCESS_COUNTRY, $this->notifications)) {
            throw new RuntimeException('Notification received!');
        };
    }

    /**
     * @Given /^I add to apelido "([^"]*)" user with email "([^"]*)", group "([^"]*)", city "([^"]*)", country "([^"]*)"$/
     */
    public function iAddToApelidoUserWithEmailGroupCityCountry($arg1, $arg2, $arg3, $arg4, $arg5)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I add to apelido "([^"]*)" description "([^"]*)"$/
     */
    public function iAddToApelidoDescription($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I add to apelido "([^"]*)" description "([^"]*)" as "([^"]*)"$/
     */
    public function iAddToApelidoDescriptionAs($arg1, $arg2, $arg3)
    {
        throw new PendingException();
    }
}